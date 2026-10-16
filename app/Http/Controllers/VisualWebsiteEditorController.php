<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\AdminAuditLog;
use App\Models\WebsiteDesignRevision;
use App\Services\WebsiteDesignService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class VisualWebsiteEditorController extends Controller
{
    public function __construct(private readonly WebsiteDesignService $designs) {}

    public function index(Request $request)
    {
        $catalog = $this->designs->catalog();
        $page = $request->query('page', 'customer.products');
        abort_unless(isset($catalog[$page]), 404);
        $component = $request->query('component', array_key_first($catalog[$page]['components']));
        abort_unless($this->designs->component($page, $component), 404);

        $published = $this->designs->latestPublished($page, $component);
        $draft = WebsiteDesignRevision::query()
            ->where('page_key', $page)->where('component_key', $component)
            ->where('created_by', session('admin_id'))->where('status', 'draft')->latest('revision')->first();
        $history = WebsiteDesignRevision::query()
            ->where('page_key', $page)->where('component_key', $component)
            ->whereIn('status', ['published', 'archived'])
            ->latest('revision')->limit(20)->get();

        return view('admin.visual-editor.index', compact('catalog', 'page', 'component', 'published', 'draft', 'history'));
    }

    public function preview(WebsiteDesignRevision $revision)
    {
        abort_unless($revision->status === 'draft' && $revision->created_by === (string) session('admin_id'), 404);
        $component = $this->designs->component($revision->page_key, $revision->component_key);
        abort_unless($component, 404);
        return view('admin.visual-editor.preview', [
            'revision' => $revision,
            'component' => $component,
            'css' => $this->designs->renderCss($revision->page_key, ['component_key' => $revision->component_key, 'settings' => $revision->settings]),
        ]);
    }

    public function saveDraft(Request $request)
    {
        $validated = $this->validateEditorPayload($request);
        $admin = $this->currentAdmin();
        $base = $this->designs->latestPublished($validated['page_key'], $validated['component_key']);
        if ((int) ($validated['base_revision_id'] ?? 0) !== (int) ($base?->id ?? 0)) {
            return response()->json(['message' => 'A newer published revision exists. Reload this component before saving.'], 409);
        }

        $draft = DB::transaction(function () use ($validated, $admin, $base) {
            $keyQuery = WebsiteDesignRevision::query()->where('page_key', $validated['page_key'])->where('component_key', $validated['component_key']);
            $latest = (clone $keyQuery)->lockForUpdate()->max('revision') ?? 0;
            (clone $keyQuery)->where('created_by', (string) $admin->id)->where('status', 'draft')->update(['status' => 'superseded']);
            return WebsiteDesignRevision::create([
                'page_key' => $validated['page_key'], 'component_key' => $validated['component_key'],
                'revision' => $latest + 1, 'settings' => $validated['settings'], 'status' => 'draft',
                'base_revision_id' => $base?->id, 'created_by' => (string) $admin->id,
                'change_note' => $validated['change_note'] ?? null,
            ]);
        });

        AdminAuditLog::log($admin, 'website_design.save_draft', $draft->page_key, (string) $draft->id, 'Saved a website design draft.', null, ['component' => $draft->component_key, 'revision' => $draft->revision]);
        return response()->json(['success' => true, 'revision_id' => $draft->id, 'preview_url' => route('admin.visual-editor.preview', $draft)]);
    }

    public function publish(WebsiteDesignRevision $revision)
    {
        abort_unless($revision->status === 'draft' && $revision->created_by === (string) session('admin_id'), 404);
        $admin = $this->currentAdmin();
        DB::transaction(function () use ($revision, $admin) {
            $current = $this->designs->latestPublished($revision->page_key, $revision->component_key);
            if ((int) ($current?->id ?? 0) !== (int) ($revision->base_revision_id ?? 0)) {
                throw ValidationException::withMessages(['revision' => 'The published design changed since this draft was created. Save a new draft from the latest version.']);
            }
            WebsiteDesignRevision::query()->where('page_key', $revision->page_key)->where('component_key', $revision->component_key)->where('status', 'published')->update(['status' => 'archived']);
            $revision->update(['status' => 'published', 'published_by' => (string) $admin->id, 'published_at' => now()]);
        });
        $this->designs->invalidate($revision->page_key, $revision->component_key);
        AdminAuditLog::log($admin, 'website_design.publish', $revision->page_key, (string) $revision->id, 'Published a website design revision.', null, ['component' => $revision->component_key, 'revision' => $revision->revision]);
        return redirect()->route('admin.visual-editor.index', ['page' => $revision->page_key, 'component' => $revision->component_key])->with('success', 'Design published on the live website.');
    }

    public function discard(WebsiteDesignRevision $revision)
    {
        abort_unless($revision->status === 'draft' && $revision->created_by === (string) session('admin_id'), 404);
        $revision->update(['status' => 'discarded']);
        AdminAuditLog::log($this->currentAdmin(), 'website_design.discard_draft', $revision->page_key, (string) $revision->id, 'Discarded a website design draft.', null, ['component' => $revision->component_key, 'revision' => $revision->revision]);
        return back()->with('success', 'Draft discarded.');
    }

    public function rollback(WebsiteDesignRevision $revision)
    {
        abort_unless(in_array($revision->status, ['published', 'archived'], true), 404);
        $admin = $this->currentAdmin();
        $newRevision = DB::transaction(function () use ($revision, $admin) {
            WebsiteDesignRevision::query()->where('page_key', $revision->page_key)->where('component_key', $revision->component_key)->where('status', 'published')->update(['status' => 'archived']);
            $number = WebsiteDesignRevision::query()->where('page_key', $revision->page_key)->where('component_key', $revision->component_key)->lockForUpdate()->max('revision') + 1;
            return WebsiteDesignRevision::create([
                'page_key' => $revision->page_key, 'component_key' => $revision->component_key,
                'revision' => $number, 'settings' => $revision->settings, 'status' => 'published',
                'base_revision_id' => $revision->id, 'created_by' => (string) $admin->id,
                'published_by' => (string) $admin->id, 'published_at' => now(),
                'change_note' => 'Restored revision #' . $revision->revision,
            ]);
        });
        $this->designs->invalidate($revision->page_key, $revision->component_key);
        AdminAuditLog::log($admin, 'website_design.rollback', $revision->page_key, (string) $newRevision->id, 'Restored a previous website design.', ['source_revision' => $revision->id], ['revision' => $newRevision->revision]);
        return back()->with('success', 'Previous design restored as a new published revision.');
    }

    private function validateEditorPayload(Request $request): array
    {
        $data = $request->validate([
            'page_key' => ['required', 'string', 'in:' . implode(',', array_keys($this->designs->catalog()))],
            'component_key' => ['required', 'string', 'max:100'],
            'base_revision_id' => ['nullable', 'integer', 'min:0'],
            'change_note' => ['nullable', 'string', 'max:180'],
            'settings' => ['required', 'array:background,text_color,accent,border_color,gradient_start,gradient_end,use_background,use_text_color,use_accent,use_border_color,use_gradient_start,use_gradient_end,radius,padding,font_size,tablet_radius,tablet_padding,tablet_font_size,mobile_radius,mobile_padding,mobile_font_size,width,height,offset_x,offset_y,border_width,opacity,line_height,letter_spacing,font_family,font_weight,shadow,text_align,content'],
            'settings.background' => ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'settings.text_color' => ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'settings.accent' => ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'settings.border_color' => ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'settings.gradient_start' => ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'settings.gradient_end' => ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'settings.use_background' => ['sometimes', 'boolean'],
            'settings.use_text_color' => ['sometimes', 'boolean'],
            'settings.use_accent' => ['sometimes', 'boolean'],
            'settings.use_border_color' => ['sometimes', 'boolean'],
            'settings.use_gradient_start' => ['sometimes', 'boolean'],
            'settings.use_gradient_end' => ['sometimes', 'boolean'],
            'settings.radius' => ['nullable', 'integer', 'between:0,64'],
            'settings.padding' => ['nullable', 'integer', 'between:0,96'],
            'settings.font_size' => ['nullable', 'integer', 'between:10,64'],
            'settings.tablet_radius' => ['nullable', 'integer', 'between:0,56'],
            'settings.tablet_padding' => ['nullable', 'integer', 'between:0,64'],
            'settings.tablet_font_size' => ['nullable', 'integer', 'between:10,52'],
            'settings.mobile_radius' => ['nullable', 'integer', 'between:0,48'],
            'settings.mobile_padding' => ['nullable', 'integer', 'between:0,48'],
            'settings.mobile_font_size' => ['nullable', 'integer', 'between:10,40'],
            'settings.width' => ['nullable', 'integer', 'between:30,100'],
            'settings.height' => ['nullable', 'integer', 'between:100,900'],
            'settings.offset_x' => ['nullable', 'integer', 'between:-100,100'],
            'settings.offset_y' => ['nullable', 'integer', 'between:-100,100'],
            'settings.border_width' => ['nullable', 'integer', 'between:0,12'],
            'settings.opacity' => ['nullable', 'numeric', 'between:0.3,1'],
            'settings.line_height' => ['nullable', 'numeric', 'between:1,2.5'],
            'settings.letter_spacing' => ['nullable', 'numeric', 'between:-2,8'],
            'settings.font_family' => ['nullable', 'in:Inter,Manrope,Outfit,Arial,system-ui'],
            'settings.font_weight' => ['nullable', 'integer', 'in:400,500,600,700,800,900'],
            'settings.shadow' => ['nullable', 'in:none,soft,glow'],
            'settings.text_align' => ['nullable', 'in:left,center,right'],
            'settings.content' => ['nullable', 'array:title,body,button_label'],
            'settings.content.title' => ['nullable', 'string', 'max:120'],
            'settings.content.body' => ['nullable', 'string', 'max:280'],
            'settings.content.button_label' => ['nullable', 'string', 'max:40'],
        ]);
        if (! $this->designs->component($data['page_key'], $data['component_key'])) {
            throw ValidationException::withMessages(['component_key' => 'This component is not supported by the visual editor.']);
        }

        foreach (['background', 'text_color', 'accent', 'border_color', 'gradient_start', 'gradient_end'] as $colorField) {
            $applyKey = 'use_' . $colorField;
            if (array_key_exists($applyKey, $data['settings']) && ! $data['settings'][$applyKey]) {
                unset($data['settings'][$colorField]);
            }
            unset($data['settings'][$applyKey]);
        }

        return $data;
    }

    private function currentAdmin(): Admin
    {
        return Admin::query()->findOrFail((string) session('admin_id'));
    }
}
