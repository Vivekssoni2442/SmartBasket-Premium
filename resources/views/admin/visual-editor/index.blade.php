@extends('layouts.admin')

@section('title', 'Visual Website Editor')

@section('content')
@php
    $componentInfo = $catalog[$page]['components'][$component];
    $values = $draft?->settings ?? $published?->settings ?? [];
    $contentValues = $values['content'] ?? [];
    $baseId = $published?->id ?? 0;
@endphp

<style>
    .ve-shell {
        --ve-navy: #07152f;
        --ve-midnight: #0b1f42;
        --ve-royal: #155eef;
        --ve-electric: #2979ff;
        --ve-sky: #58b7ff;
        --ve-cyan: #00a9d6;
        --ve-paper: #fff;
        --ve-cloud: #f4f8ff;
        --ve-line: #d8e2f0;
        --ve-slate: #64748b;
        --ve-ink: #14233d;
        --ve-purple: #8b5cf6;
        --ve-teal: #14b8a6;
        --ve-green: #16a34a;
        --ve-amber: #a35d00;
        --ve-red: #dc2626;
        color: var(--ve-ink);
        font-family: Inter, Poppins, system-ui, sans-serif;
        min-width: 0;
    }

    .ve-shell *, .ve-shell *::before, .ve-shell *::after { box-sizing: border-box; }
    .ve-shell a { color: inherit; }
    .ve-shell button, .ve-shell input, .ve-shell select, .ve-shell textarea { font: inherit; }
    .ve-shell :focus-visible { outline: 3px solid rgba(41,121,255,.48); outline-offset: 2px; }

    .ve-header {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 22px;
        padding: 22px 26px;
        margin-bottom: 18px;
        color: #fff;
        border: 1px solid rgba(88,183,255,.28);
        border-radius: 20px;
        background: linear-gradient(115deg, var(--ve-navy), var(--ve-midnight) 68%, #123a73);
        box-shadow: 0 14px 34px rgba(7,21,47,.16);
        overflow: hidden;
    }
    .ve-header::after {
        content: "";
        position: absolute;
        width: 250px;
        height: 250px;
        right: -90px;
        top: -155px;
        border: 1px solid rgba(0,212,255,.25);
        border-radius: 50%;
        box-shadow: 0 0 0 24px rgba(88,183,255,.035), 0 0 0 48px rgba(88,183,255,.025);
        pointer-events: none;
    }
    .ve-heading { position: relative; z-index: 1; min-width: 0; }
    .ve-heading-top { display: flex; align-items: center; gap: 12px; }
    .ve-brand-icon {
        display: grid;
        place-items: center;
        width: 44px;
        height: 44px;
        flex: 0 0 auto;
        color: #b9efff;
        background: rgba(41,121,255,.2);
        border: 1px solid rgba(88,183,255,.32);
        border-radius: 13px;
    }
    .ve-heading h1 { margin: 0; color: #fff; font-size: clamp(21px,2.2vw,29px); font-weight: 800; letter-spacing: -.035em; line-height: 1.2; }
    .ve-heading p { max-width: 820px; margin: 8px 0 0 56px; color: #d4e4f8; font-size: 13px; line-height: 1.55; }
    .ve-header-actions { position: relative; z-index: 1; display: flex; justify-content: flex-end; gap: 9px; flex-wrap: wrap; flex: 0 0 auto; }
    .ve-status {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        min-height: 34px;
        padding: 7px 10px;
        color: #d8e8ff;
        background: rgba(255,255,255,.08);
        border: 1px solid rgba(216,226,240,.2);
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }
    .ve-status-dot { width: 7px; height: 7px; border-radius: 50%; background: #fbbf24; box-shadow: 0 0 0 3px rgba(251,191,36,.15); }
    .ve-status.is-published .ve-status-dot { background: #34d399; box-shadow: 0 0 0 3px rgba(52,211,153,.15); }

    .ve-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 39px;
        padding: 9px 13px;
        color: #1d3556;
        background: #fff;
        border: 1px solid #cbd9eb;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 750;
        line-height: 1.2;
        text-decoration: none;
        cursor: pointer;
        transition: background-color .16s ease, border-color .16s ease, box-shadow .16s ease, transform .16s ease;
    }
    .ve-button:hover { background: #f0f6ff; border-color: #94b8f6; box-shadow: 0 4px 12px rgba(21,94,239,.1); }
    .ve-button:active { transform: translateY(1px); }
    .ve-button.primary { color: #fff; background: var(--ve-royal); border-color: var(--ve-royal); }
    .ve-button.primary:hover { background: #0e4fd4; border-color: #0e4fd4; }
    .ve-button.publish { color: #fff; background: #0d8b7b; border-color: #0d8b7b; }
    .ve-button.publish:hover { background: #087666; border-color: #087666; }
    .ve-button.danger { color: #a31f29; background: #fff; border-color: #fecaca; }
    .ve-button.danger:hover { background: #fff5f5; border-color: #fca5a5; }
    .ve-button:disabled { opacity: .62; cursor: wait; box-shadow: none; }
    .ve-header .ve-button { color: #eff7ff; background: rgba(255,255,255,.08); border-color: rgba(216,226,240,.24); }
    .ve-header .ve-button:hover { background: rgba(255,255,255,.15); border-color: rgba(88,183,255,.55); }

    .ve-alert {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        padding: 12px 14px;
        margin: 0 0 14px;
        color: #14532d;
        background: #effaf3;
        border: 1px solid #bbebc9;
        border-radius: 11px;
        font-size: 13px;
        line-height: 1.5;
    }
    .ve-alert::before { content: "✓"; display: grid; place-items: center; width: 19px; height: 19px; flex: 0 0 auto; color: #fff; background: var(--ve-green); border-radius: 50%; font-size: 12px; font-weight: 800; }
    .ve-alert.ve-error { color: #991b1b; background: #fff5f5; border-color: #fecaca; }
    .ve-alert.ve-error::before { content: "!"; background: var(--ve-red); }

    .ve-workspace {
        display: grid;
        grid-template-columns: minmax(205px, .63fr) minmax(0, 2.5fr);
        gap: 16px;
        align-items: start;
    }
    .ve-panel {
        min-width: 0;
        padding: 18px;
        background: var(--ve-paper);
        border: 1px solid var(--ve-line);
        border-radius: 16px;
        box-shadow: 0 7px 22px rgba(11,31,66,.055);
    }
    .ve-sidebar { position: sticky; top: 16px; padding: 14px; background: var(--ve-cloud); }
    .ve-panel-title {
        display: flex;
        align-items: center;
        gap: 9px;
        margin: 0 0 13px;
        color: var(--ve-navy);
        font-size: 15px;
        font-weight: 800;
        line-height: 1.35;
    }
    .ve-panel-title i { color: var(--ve-royal); }
    .ve-panel-title .ve-small { margin-left: auto; font-weight: 500; }
    .ve-nav-label, .ve-section-label {
        color: #56708f;
        font-size: 10px;
        font-weight: 850;
        letter-spacing: .09em;
        line-height: 1.4;
        text-transform: uppercase;
    }
    .ve-nav-label { display: block; margin: 8px 8px 7px; }
    .ve-page-nav { display: grid; gap: 4px; }
    .ve-nav-link {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        width: 100%;
        min-width: 0;
        padding: 9px 10px;
        color: #334963;
        background: transparent;
        border: 1px solid transparent;
        border-radius: 10px;
        font-size: 12px;
        line-height: 1.35;
        text-decoration: none;
        transition: background-color .15s ease, border-color .15s ease, color .15s ease;
    }
    .ve-nav-link i { width: 16px; margin-top: 1px; color: #65809f; text-align: center; }
    .ve-nav-link:hover { color: #113f9b; background: #e8f1ff; }
    .ve-nav-link[aria-current="page"] { color: #103d91; background: #e8f1ff; border-color: #b8d0fa; font-weight: 800; }
    .ve-nav-link[aria-current="page"] i { color: var(--ve-royal); }
    .ve-nav-group-components { display: grid; gap: 2px; margin: 1px 0 6px 34px; padding-left: 10px; border-left: 1px solid #d8e2f0; }
    .ve-nav-sub-link { display: block; min-width: 0; padding: 6px 8px; color: #64748b; border-radius: 7px; font-size: 11px; line-height: 1.4; overflow-wrap: anywhere; text-decoration: none; }
    .ve-nav-sub-link:hover { color: #103d91; background: #eef5ff; }
    .ve-nav-sub-link[aria-current="page"] { color: #103d91; background: #e8f1ff; font-weight: 800; }
    .ve-nav-divider { height: 1px; margin: 14px 3px; background: #dbe5f2; }
    .ve-nav-note { margin: 13px 7px 3px; color: #64748b; font-size: 11px; line-height: 1.55; }
    .ve-main { display: grid; grid-template-columns: minmax(380px,1.02fr) minmax(330px,.98fr); gap: 16px; align-items: start; }
    .ve-properties { min-width: 0; }
    .ve-field-grid { display: grid; grid-template-columns: repeat(2,minmax(0,1fr)); gap: 12px; }
    .ve-field { display: grid; gap: 6px; min-width: 0; align-content: start; }
    .ve-field > label, .ve-field-label { color: #344b68; font-size: 11px; font-weight: 750; line-height: 1.4; }
    .ve-field input:not([type="checkbox"]), .ve-field select, .ve-field textarea {
        display: block;
        width: 100%;
        min-width: 0;
        min-height: 40px;
        padding: 9px 10px;
        color: #172b46;
        background-color: #fff;
        border: 1px solid #c9d7e8;
        border-radius: 9px;
        font-size: 12px;
        line-height: 1.4;
        box-shadow: inset 0 1px 1px rgba(11,31,66,.025);
    }
    .ve-field input::placeholder, .ve-field textarea::placeholder { color: #71839a; opacity: 1; }
    .ve-field select { color-scheme: light; }
    .ve-field select option { color: #172b46; background: #fff; }
    .ve-field textarea { min-height: 84px; resize: vertical; }
    .ve-field input:not([type="checkbox"]):focus, .ve-field select:focus, .ve-field textarea:focus { border-color: #5790f5; box-shadow: 0 0 0 3px rgba(41,121,255,.12); outline: none; }
    .ve-field input[type="color"] { min-height: 42px !important; padding: 4px !important; cursor: pointer; }
    .ve-color-field { padding: 9px; background: #f8fbff; border: 1px solid #e1e9f4; border-radius: 10px; }
    .ve-check-label { display: flex; align-items: center; gap: 7px; color: #526780; font-size: 11px; font-weight: 600; line-height: 1.35; cursor: pointer; }
    .ve-check-label input { width: 15px; height: 15px; margin: 0; accent-color: var(--ve-royal); }
    .ve-section-label { grid-column: 1/-1; display: flex; align-items: center; gap: 8px; padding-top: 12px; margin-top: 3px; border-top: 1px solid #e4ebf4; color: #1552b5; }
    .ve-section-label i { color: var(--ve-cyan); font-size: 12px; }
    .ve-helper { grid-column: 1/-1; margin: -4px 0 0; color: #64748b; font-size: 11px; line-height: 1.5; }
    .ve-actions { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-top: 15px; }
    .ve-actions form { display: inline-flex; margin: 0; }
    .ve-actions .ve-button { min-width: 98px; }
    .ve-button.is-selected { color: #1145a0; background: #e8f1ff; border-color: #8eb5f8; box-shadow: inset 0 0 0 1px #b9d2fc; }
    .ve-save-state { margin-left: auto; color: #64748b; font-size: 11px; }

    .ve-canvas-panel { position: sticky; top: 16px; }
    .ve-canvas-tools { display: flex; align-items: center; justify-content: space-between; gap: 8px; flex-wrap: wrap; margin: 0 0 12px; }
    .ve-viewport-tools { display: flex; gap: 5px; padding: 3px; background: #f0f5fc; border: 1px solid #dfe8f4; border-radius: 10px; }
    .ve-viewport-tools .ve-button { min-height: 32px; padding: 7px 9px; background: transparent; border-color: transparent; box-shadow: none; font-size: 11px; }
    .ve-viewport-tools .ve-button:hover { background: #fff; }
    .ve-preview-stage {
        display: grid;
        place-items: center;
        min-height: 340px;
        max-width: 100%;
        margin: 0 auto;
        padding: 20px;
        overflow: auto;
        background: radial-gradient(circle at 50% 0%, #fff 0, #f5f8fd 65%, #edf3fb 100%);
        border: 1px solid #d9e4f1;
        border-radius: 13px;
        transition: max-width .2s ease;
    }
    .ve-preview-card {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
        width: min(100%,620px);
        min-height: 210px;
        padding: 30px;
        color: #f5f9ff;
        background: linear-gradient(135deg,#10284b,#174f9b);
        border: 1px solid #7bbcff;
        border-radius: 18px;
        box-shadow: 0 16px 35px rgba(11,52,112,.18);
        cursor: grab;
        touch-action: none;
    }
    .ve-preview-card:active { cursor: grabbing; }
    .ve-preview-card h3 { max-width: 100%; margin: 0 0 12px; color: inherit; font-size: 26px; font-weight: 800; letter-spacing: -.03em; line-height: 1.2; overflow-wrap: anywhere; }
    .ve-preview-card p { max-width: 60ch; margin: 0 0 18px; color: #e1edff; font-size: 14px; line-height: 1.6; overflow-wrap: anywhere; }
    .ve-preview-card button { min-height: 40px; padding: 10px 15px; color: #07152f; background: #a8e7ff; border: 0; border-radius: 9px; font-size: 12px; font-weight: 800; }
    .ve-preview-hint { margin-top: 16px; color: #d7e8ff; font-size: 10px; line-height: 1.4; }
    .ve-canvas-caption { margin: 11px 1px 0; color: #64748b; font-size: 11px; line-height: 1.55; }
    .ve-small { color: #64748b; font-size: 11px; line-height: 1.5; }

    .ve-history-panel { margin-top: 16px; }
    .ve-history-wrap { max-width: 100%; overflow-x: auto; border: 1px solid #e1e9f3; border-radius: 11px; }
    .ve-history { width: 100%; min-width: 650px; border-collapse: collapse; font-size: 12px; }
    .ve-history th, .ve-history td { padding: 11px 12px; color: #344b68; border-bottom: 1px solid #e8eef6; text-align: left; vertical-align: middle; line-height: 1.45; }
    .ve-history th { color: #536b87; background: #f5f8fd; font-size: 10px; font-weight: 850; letter-spacing: .06em; text-transform: uppercase; }
    .ve-history tr:last-child td { border-bottom: 0; }
    .ve-history form { margin: 0; }
    .ve-badge { display: inline-flex; align-items: center; gap: 6px; padding: 5px 8px; color: #1552b5; background: #edf5ff; border: 1px solid #d1e3ff; border-radius: 999px; font-size: 10px; font-weight: 750; }
    .ve-empty { padding: 20px; color: #64748b; background: #f8fbff; border: 1px dashed #cad8e9; border-radius: 11px; font-size: 12px; line-height: 1.55; }
    .ve-nojs { margin-top: 12px; }

    @media (max-width: 1450px) {
        .ve-workspace { grid-template-columns: minmax(190px,.55fr) minmax(0,2.2fr); }
        .ve-main { grid-template-columns: minmax(0,1fr); }
        .ve-canvas-panel { position: static; }
    }
    @media (max-width: 950px) {
        .ve-header { align-items: flex-start; flex-direction: column; padding: 20px; }
        .ve-header-actions { justify-content: flex-start; }
        .ve-workspace { grid-template-columns: minmax(0,1fr); }
        .ve-sidebar { position: static; }
        .ve-page-nav { grid-template-columns: repeat(2,minmax(0,1fr)); }
        .ve-component-nav { grid-template-columns: repeat(2,minmax(0,1fr)); }
        .ve-nav-divider { margin: 10px 3px; }
    }
    @media (max-width: 600px) {
        .ve-header { gap: 15px; padding: 17px; border-radius: 15px; }
        .ve-heading-top { align-items: flex-start; }
        .ve-brand-icon { width: 39px; height: 39px; }
        .ve-heading h1 { font-size: 21px; }
        .ve-heading p { margin: 8px 0 0; font-size: 12px; }
        .ve-header-actions { width: 100%; }
        .ve-header-actions .ve-button { flex: 1 1 auto; }
        .ve-status { flex: 1 1 100%; justify-content: center; }
        .ve-panel { padding: 14px; border-radius: 13px; }
        .ve-page-nav { grid-template-columns: minmax(0,1fr); }
        .ve-field-grid { grid-template-columns: minmax(0,1fr); }
        .ve-section-label, .ve-helper { grid-column: 1; }
        .ve-canvas-tools { align-items: flex-start; flex-direction: column; }
        .ve-preview-stage { min-height: 280px; padding: 13px; }
        .ve-preview-card { min-height: 205px; padding: 22px; }
        .ve-preview-card h3 { font-size: 23px; }
        .ve-actions .ve-button { flex: 1 1 auto; }
        .ve-actions form { flex: 1 1 auto; }
        .ve-actions form .ve-button { width: 100%; }
        .ve-save-state { width: 100%; margin: 0; }
    }
    @media (prefers-reduced-motion: reduce) {
        .ve-shell *, .ve-shell *::before, .ve-shell *::after { scroll-behavior: auto !important; transition-duration: .01ms !important; animation-duration: .01ms !important; }
    }
</style>

<div class="ve-shell">
    <header class="ve-header">
        <div class="ve-heading">
            <div class="ve-heading-top">
                <span class="ve-brand-icon" aria-hidden="true"><i class="fas fa-pen-ruler"></i></span>
                <h1>Visual Website Editor</h1>
            </div>
            <p>Shape supported Smart Basket sections, preview your draft, and publish when it is ready. Draft changes stay private until published.</p>
        </div>
        <div class="ve-header-actions">
            <span class="ve-status {{ $published ? 'is-published' : '' }}" aria-live="polite"><span class="ve-status-dot" aria-hidden="true"></span><span id="veSaveStatus">{{ $draft ? 'Draft ready to edit' : ($published ? 'Published revision '.$published->revision : 'Default design') }}</span></span>
            @if($draft)
                <a class="ve-button" href="{{ route('admin.visual-editor.preview', $draft) }}" target="_blank" rel="noopener"><i class="fas fa-eye" aria-hidden="true"></i> Preview draft</a>
            @endif
        </div>
    </header>

    @if(session('success'))<div class="ve-alert" role="status">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="ve-alert ve-error" role="alert">{{ $errors->first() }}</div>@endif
    <div id="veNotice" class="ve-alert d-none" role="status" aria-live="polite"></div>

    <div class="ve-workspace">
        <aside class="ve-panel ve-sidebar" aria-label="Website editor navigation">
            <span class="ve-nav-label">Website areas</span>
            <nav class="ve-page-nav" aria-label="Select website area">
                @foreach($catalog as $key => $group)
                    @php $firstComponent = array_key_first($group['components']); @endphp
                    <div class="ve-nav-group">
                        <a class="ve-nav-link" href="{{ route('admin.visual-editor.index', ['page' => $key, 'component' => $firstComponent]) }}" @if($page === $key) aria-current="page" @endif>
                            <i class="fas {{ str_starts_with($key, 'customer.') ? 'fa-bag-shopping' : (str_starts_with($key, 'seller.') ? 'fa-store' : 'fa-layer-group') }}" aria-hidden="true"></i>
                            <span>{{ $group['label'] }}</span>
                        </a>
                        <div class="ve-nav-group-components" aria-label="{{ $group['label'] }} components">
                            @foreach($group['components'] as $groupComponentKey => $groupComponent)
                                <a class="ve-nav-sub-link" href="{{ route('admin.visual-editor.index', ['page' => $key, 'component' => $groupComponentKey]) }}" @if($page === $key && $component === $groupComponentKey) aria-current="page" @endif>{{ $groupComponent['label'] }}</a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </nav>

            <p class="ve-nav-note">Only catalog-approved components can be edited. Checkout, payments, account security, and order data are outside the editor.</p>
        </aside>

        <main class="ve-main">
            <section class="ve-panel ve-properties" aria-labelledby="vePropertiesTitle">
                <h2 id="vePropertiesTitle" class="ve-panel-title"><i class="fas fa-sliders" aria-hidden="true"></i> Component properties <span class="ve-small">{{ $componentInfo['label'] }}</span></h2>

                <form id="veForm" method="POST" action="{{ route('admin.visual-editor.drafts.store') }}">
                    @csrf
                    <input type="hidden" name="page_key" value="{{ $page }}">
                    <input type="hidden" name="component_key" value="{{ $component }}">
                    <input type="hidden" name="base_revision_id" value="{{ $baseId }}">

                    <div class="ve-field-grid">
                        <div class="ve-section-label"><i class="fas fa-align-left" aria-hidden="true"></i> Content · Plain text</div>
                        <div class="ve-field" style="grid-column:1/-1"><label for="veTitle">Heading</label><input id="veTitle" name="settings[content][title]" maxlength="120" value="{{ $contentValues['title'] ?? '' }}" placeholder="{{ $componentInfo['sample'] }}" data-preview="title"></div>
                        <div class="ve-field" style="grid-column:1/-1"><label for="veBody">Supporting text</label><textarea id="veBody" name="settings[content][body]" maxlength="280" placeholder="Add a short supporting message" data-preview="body">{{ $contentValues['body'] ?? '' }}</textarea></div>
                        <div class="ve-field" style="grid-column:1/-1"><label for="veButtonLabel">Button label</label><input id="veButtonLabel" name="settings[content][button_label]" maxlength="40" value="{{ $contentValues['button_label'] ?? '' }}" placeholder="Explore Smart Basket" data-preview="button_label"></div>

                        <div class="ve-section-label"><i class="fas fa-palette" aria-hidden="true"></i> Colors & surface</div>
                        @foreach(['background'=>'Background','text_color'=>'Text','accent'=>'Accent','border_color'=>'Border','gradient_start'=>'Gradient start','gradient_end'=>'Gradient end'] as $field=>$label)
                            <div class="ve-field ve-color-field">
                                <label for="veColor{{ ucfirst($field) }}">{{ $label }}</label>
                                <input type="hidden" name="settings[use_{{ $field }}]" value="0">
                                <label class="ve-check-label"><input type="checkbox" name="settings[use_{{ $field }}]" value="1" @checked(isset($values[$field])) data-apply="{{ $field }}"> Apply this color</label>
                                <input id="veColor{{ ucfirst($field) }}" type="color" name="settings[{{ $field }}]" value="{{ $values[$field] ?? '#155eef' }}" data-style="{{ $field }}" aria-label="{{ $label }} color">
                            </div>
                        @endforeach
                        <div class="ve-field"><label for="veShadow">Shadow effect</label><select id="veShadow" name="settings[shadow]" data-style="shadow"><option value="none" @selected(($values['shadow'] ?? 'none')==='none')>None</option><option value="soft" @selected(($values['shadow'] ?? '')==='soft')>Soft</option><option value="glow" @selected(($values['shadow'] ?? '')==='glow')>Blue glow</option></select></div>
                        <div class="ve-field"><label for="veTextAlign">Text alignment</label><select id="veTextAlign" name="settings[text_align]" data-style="text_align"><option value="left" @selected(($values['text_align'] ?? 'left')==='left')>Left</option><option value="center" @selected(($values['text_align'] ?? '')==='center')>Center</option><option value="right" @selected(($values['text_align'] ?? '')==='right')>Right</option></select></div>

                        <div class="ve-section-label"><i class="fas fa-text-height" aria-hidden="true"></i> Size & typography · Desktop</div>
                        @foreach(['radius'=>'Radius (px)','padding'=>'Padding (px)','font_size'=>'Font size (px)','width'=>'Width (%)','height'=>'Minimum height (px)','border_width'=>'Border width (px)','font_weight'=>'Font weight','opacity'=>'Opacity','line_height'=>'Line height','letter_spacing'=>'Letter spacing (px)','offset_x'=>'Move X (px)','offset_y'=>'Move Y (px)'] as $field=>$label)
                            <div class="ve-field"><label for="ve{{ ucfirst($field) }}">{{ $label }}</label><input id="ve{{ ucfirst($field) }}" type="number" step="{{ in_array($field,['opacity','line_height','letter_spacing']) ? '0.1' : '1' }}" name="settings[{{ $field }}]" value="{{ $values[$field] ?? '' }}" data-style="{{ $field }}"></div>
                        @endforeach
                        <div class="ve-field"><label for="veFontFamily">Font family</label><select id="veFontFamily" name="settings[font_family]" data-style="font_family"><option value="">Page default</option>@foreach(['Inter','Manrope','Outfit','Arial','system-ui'] as $font)<option value="{{ $font }}" @selected(($values['font_family'] ?? '')===$font)>{{ $font }}</option>@endforeach</select></div>

                        <div class="ve-section-label"><i class="fas fa-mobile-screen-button" aria-hidden="true"></i> Responsive overrides</div>
                        <p class="ve-helper">Optional values replace desktop dimensions at the selected tablet or mobile breakpoint.</p>
                        @foreach(['tablet_radius'=>'Tablet radius','tablet_padding'=>'Tablet padding','tablet_font_size'=>'Tablet font size','mobile_radius'=>'Mobile radius','mobile_padding'=>'Mobile padding','mobile_font_size'=>'Mobile font size'] as $field=>$label)
                            <div class="ve-field"><label for="ve{{ ucfirst($field) }}">{{ $label }} (px)</label><input id="ve{{ ucfirst($field) }}" type="number" step="1" name="settings[{{ $field }}]" value="{{ $values[$field] ?? '' }}" data-style="{{ $field }}"></div>
                        @endforeach
                        <div class="ve-field" style="grid-column:1/-1"><label for="veChangeNote">Revision note</label><input id="veChangeNote" name="change_note" maxlength="180" placeholder="Optional summary for admins"></div>
                    </div>

                    <div class="ve-actions" aria-label="Draft editing controls">
                        <button class="ve-button primary" type="submit"><i class="fas fa-floppy-disk" aria-hidden="true"></i> Save draft</button>
                        <button class="ve-button" type="button" id="veUndo" aria-label="Undo last editor change"><i class="fas fa-rotate-left" aria-hidden="true"></i> Undo</button>
                        <button class="ve-button" type="button" id="veRedo" aria-label="Redo editor change"><i class="fas fa-rotate-right" aria-hidden="true"></i> Redo</button>
                        <button class="ve-button danger" type="button" id="veReset"><i class="fas fa-eraser" aria-hidden="true"></i> Reset fields</button>
                        <span class="ve-save-state" id="veUnsavedState" aria-live="polite">No unsaved edits</span>
                    </div>
                </form>

                @if($draft)
                    <div class="ve-actions" aria-label="Draft actions">
                        <form method="POST" action="{{ route('admin.visual-editor.publish', $draft) }}" onsubmit="return confirm('Publish this draft to the live website?');">@csrf<button class="ve-button publish" type="submit"><i class="fas fa-cloud-arrow-up" aria-hidden="true"></i> Publish changes</button></form>
                        <a class="ve-button" href="{{ route('admin.visual-editor.preview', $draft) }}" target="_blank" rel="noopener"><i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i> Open draft preview</a>
                        <form method="POST" action="{{ route('admin.visual-editor.discard', $draft) }}" onsubmit="return confirm('Discard this draft? This cannot be undone.');">@csrf @method('DELETE')<button class="ve-button danger" type="submit"><i class="fas fa-trash" aria-hidden="true"></i> Discard draft</button></form>
                    </div>
                @endif
            </section>

            <section class="ve-panel ve-canvas-panel" aria-labelledby="veCanvasTitle">
                <h2 id="veCanvasTitle" class="ve-panel-title"><i class="fas fa-display" aria-hidden="true" style="color:var(--ve-purple)"></i> Component canvas <span class="ve-small">Editor preview</span></h2>
                <div class="ve-canvas-tools">
                    <div class="ve-badge"><i class="fas fa-cube" aria-hidden="true"></i> {{ $catalog[$page]['label'] }} · {{ $componentInfo['label'] }}</div>
                    <div class="ve-viewport-tools" role="group" aria-label="Preview canvas size">
                        <button type="button" class="ve-button is-selected" data-ve-viewport="desktop" aria-pressed="true"><i class="fas fa-desktop" aria-hidden="true"></i> Desktop</button>
                        <button type="button" class="ve-button" data-ve-viewport="tablet" aria-pressed="false"><i class="fas fa-tablet-screen-button" aria-hidden="true"></i> Tablet</button>
                        <button type="button" class="ve-button" data-ve-viewport="mobile" aria-pressed="false"><i class="fas fa-mobile-screen-button" aria-hidden="true"></i> Mobile</button>
                    </div>
                </div>
                <div class="ve-preview-stage" id="veStage">
                    <article class="ve-preview-card" id="vePreview" data-ve="{{ $page.'.'.$component }}" tabindex="0" aria-label="Selected component preview. Use the Move X and Move Y fields to position it, or drag with a pointer.">
                        <h3 data-preview-target="title">{{ $contentValues['title'] ?? $componentInfo['sample'] }}</h3>
                        <p data-preview-target="body">{{ $contentValues['body'] ?? 'Preview the selected component appearance before saving and publishing this revision.' }}</p>
                        <button type="button" data-preview-target="button_label">{{ $contentValues['button_label'] ?? 'Explore Smart Basket' }}</button>
                        <span class="ve-preview-hint">Drag to adjust the supported section offset.</span>
                    </article>
                </div>
                <p class="ve-canvas-caption">This isolated canvas previews the selected catalog component. Use <strong>Open draft preview</strong> to inspect its saved styling in the authenticated preview page. Live design stays unchanged until you publish.</p>
            </section>
        </main>
    </div>

    <section class="ve-panel ve-history-panel" aria-labelledby="veHistoryTitle">
        <h2 id="veHistoryTitle" class="ve-panel-title"><i class="fas fa-clock-rotate-left" aria-hidden="true" style="color:#a35d00"></i> Published revision history <span class="ve-small">Latest 20</span></h2>
        @if($history->isEmpty())
            <div class="ve-empty"><strong>No published revisions yet.</strong><br>Save a draft and publish it when ready to begin a version history for this component.</div>
        @else
            <div class="ve-history-wrap"><table class="ve-history"><thead><tr><th scope="col">Revision</th><th scope="col">Status</th><th scope="col">Note</th><th scope="col">Published</th><th scope="col">Action</th></tr></thead><tbody>
                @foreach($history as $item)
                    <tr><td>#{{ $item->revision }}</td><td><span class="ve-badge">{{ ucfirst($item->status) }}</span></td><td>{{ $item->change_note ?: '—' }}</td><td>{{ $item->published_at?->format('d M Y H:i') ?: '—' }}</td><td>@if($item->status==='archived')<form method="POST" action="{{ route('admin.visual-editor.rollback', $item) }}" onsubmit="return confirm('Restore this version as the current published design?');">@csrf<button class="ve-button" type="submit">Restore version</button></form>@else<span class="ve-small">Current live revision</span>@endif</td></tr>
                @endforeach
            </tbody></table></div>
        @endif
    </section>
</div>

<script>
(() => {
    const form = document.getElementById('veForm');
    const preview = document.getElementById('vePreview');
    const stage = document.getElementById('veStage');
    const controls = [...form.querySelectorAll('[data-style], [data-preview], [data-apply]')];
    const snapshot = () => controls.map(input => [input.value, input.type === 'checkbox' ? input.checked : null]);
    const history = [snapshot()];
    let cursor = 0;
    let replaying = false;
    let viewportMode = 'desktop';
    const saveState = document.getElementById('veUnsavedState');
    const commitSnapshot = () => {
        if (replaying) return;
        const values = snapshot();
        if (JSON.stringify(values) === JSON.stringify(history[cursor])) return;
        history.splice(cursor + 1);
        history.push(values);
        cursor = history.length - 1;
        saveState.textContent = 'Unsaved edits';
    };
    const setControl = (input, value, checked) => {
        input.value = value;
        if (input.type === 'checkbox') input.checked = checked;
        input.dispatchEvent(new Event('input', {bubbles: true}));
        input.dispatchEvent(new Event('change', {bubbles: true}));
    };
    const applyPreview = () => {
        preview.style.cssText = '';
        controls.forEach(input => {
            const field = input.dataset.style;
            const isColor = ['background','text_color','accent','border_color','gradient_start','gradient_end'].includes(field);
            const applyColor = name => form.querySelector(`[data-apply="${name}"]`)?.checked;
            if (isColor && !applyColor(field)) return;
            if (field === 'background') preview.style.backgroundColor = input.value;
            if (field === 'gradient_start' || field === 'gradient_end') {
                const start = form.querySelector('[name="settings[gradient_start]"]').value;
                const end = form.querySelector('[name="settings[gradient_end]"]').value;
                if (applyColor('gradient_start') && applyColor('gradient_end')) preview.style.background = `linear-gradient(135deg,${start},${end})`;
            }
            if (field === 'text_color') preview.style.color = input.value;
            if (field === 'accent') preview.querySelector('button').style.backgroundColor = input.value;
            if (field === 'border_color') preview.style.borderColor = input.value;
            if (field === 'radius' && input.value !== '') preview.style.borderRadius = `${input.value}px`;
            if (field === 'padding' && input.value !== '') preview.style.padding = `${input.value}px`;
            if (field === 'font_size' && input.value !== '') preview.style.fontSize = `${input.value}px`;
            if (field === 'font_family' && input.value) preview.style.fontFamily = `${input.value},sans-serif`;
            if (field === 'font_weight' && input.value) preview.style.fontWeight = input.value;
            if (field === 'line_height' && input.value) preview.style.lineHeight = input.value;
            if (field === 'letter_spacing' && input.value) preview.style.letterSpacing = `${input.value}px`;
            if (field === 'opacity' && input.value) preview.style.opacity = input.value;
            if (field === 'shadow') preview.style.boxShadow = input.value === 'glow' ? '0 0 35px rgba(41,121,255,.28)' : input.value === 'soft' ? '0 14px 40px rgba(5,15,35,.18)' : 'none';
            if (field === 'width' && input.value) preview.style.width = `${input.value}%`;
            if (field === 'height' && input.value) preview.style.minHeight = `${input.value}px`;
            if (field === 'text_align' && input.value) preview.style.textAlign = input.value;
            if (field === 'offset_x') preview.style.left = `${input.value || 0}px`;
            if (field === 'offset_y') preview.style.top = `${input.value || 0}px`;
            if (input.dataset.preview) {
                const target = preview.querySelector(`[data-preview-target="${input.dataset.preview}"]`);
                if (target) target.textContent = input.value.trim() || target.dataset.defaultText || '';
            }
        });
        const responsive = viewportMode === 'mobile'
            ? ['mobile_radius', 'mobile_padding', 'mobile_font_size']
            : viewportMode === 'tablet'
                ? ['tablet_radius', 'tablet_padding', 'tablet_font_size']
                : ['radius', 'padding', 'font_size'];
        const properties = ['borderRadius', 'padding', 'fontSize'];
        responsive.forEach((name, index) => {
            const value = form.querySelector(`[name="settings[${name}]"]`)?.value;
            if (value) preview.style[properties[index]] = `${value}px`;
        });
    };
    const restoreSnapshot = index => {
        replaying = true;
        controls.forEach((input, controlIndex) => setControl(input, history[index][controlIndex][0], history[index][controlIndex][1]));
        replaying = false;
        applyPreview();
        saveState.textContent = 'Unsaved edits';
    };
    controls.forEach(input => {
        input.addEventListener('input', () => { applyPreview(); commitSnapshot(); });
        input.addEventListener('change', () => { applyPreview(); commitSnapshot(); });
    });

    document.querySelectorAll('[data-ve-viewport]').forEach(button => button.addEventListener('click', () => {
        const mode = button.dataset.veViewport;
        viewportMode = mode;
        stage.style.maxWidth = mode === 'mobile' ? '390px' : mode === 'tablet' ? '768px' : 'none';
        applyPreview();
        document.querySelectorAll('[data-ve-viewport]').forEach(item => {
            const selected = item === button;
            item.classList.toggle('is-selected', selected);
            item.setAttribute('aria-pressed', String(selected));
        });
    }));

    document.getElementById('veUndo').addEventListener('click', () => {
        if (cursor <= 0) return;
        cursor--;
        restoreSnapshot(cursor);
    });
    document.getElementById('veRedo').addEventListener('click', () => {
        if (cursor >= history.length - 1) return;
        cursor++;
        restoreSnapshot(cursor);
    });
    document.getElementById('veReset').addEventListener('click', () => {
        controls.forEach(input => {
            if (input.type === 'checkbox') input.checked = false;
            else if (input.type === 'color') input.value = '#155eef';
            else if (input.dataset.preview) input.value = '';
            else input.value = '';
        });
        preview.querySelector('[data-preview-target="title"]').textContent = @json($componentInfo['sample']);
        preview.querySelector('[data-preview-target="body"]').textContent = 'Preview the selected component appearance before saving and publishing this revision.';
        preview.querySelector('[data-preview-target="button_label"]').textContent = 'Explore Smart Basket';
        replaying = true;
        applyPreview();
        replaying = false;
        commitSnapshot();
    });

    let dragging = false, startX = 0, startY = 0;
    let offsetX = Number(form.querySelector('[name="settings[offset_x]"]').value || 0);
    let offsetY = Number(form.querySelector('[name="settings[offset_y]"]').value || 0);
    const updateOffsets = (x, y) => {
        offsetX = Math.max(-100, Math.min(100, x));
        offsetY = Math.max(-100, Math.min(100, y));
        replaying = true;
        setControl(form.querySelector('[name="settings[offset_x]"]'), offsetX, null);
        setControl(form.querySelector('[name="settings[offset_y]"]'), offsetY, null);
        replaying = false;
        applyPreview();
    };
    preview.addEventListener('pointerdown', event => {
        if (event.target.closest('button')) return;
        dragging = true;
        startX = event.clientX - offsetX;
        startY = event.clientY - offsetY;
        preview.setPointerCapture(event.pointerId);
    });
    preview.addEventListener('pointermove', event => {
        if (dragging) updateOffsets(event.clientX - startX, event.clientY - startY);
    });
    preview.addEventListener('pointerup', () => { if (dragging) commitSnapshot(); dragging = false; });
    preview.addEventListener('pointercancel', () => { dragging = false; });
    preview.addEventListener('keydown', event => {
        const delta = event.shiftKey ? 10 : 1;
        if (!['ArrowUp','ArrowDown','ArrowLeft','ArrowRight'].includes(event.key)) return;
        event.preventDefault();
        updateOffsets(offsetX + (event.key === 'ArrowRight' ? delta : event.key === 'ArrowLeft' ? -delta : 0), offsetY + (event.key === 'ArrowDown' ? delta : event.key === 'ArrowUp' ? -delta : 0));
        commitSnapshot();
    });

    const notice = document.getElementById('veNotice');
    form.addEventListener('submit', async event => {
        event.preventDefault();
        const button = form.querySelector('button[type="submit"]');
        button.disabled = true;
        saveState.textContent = 'Saving draft…';
        try {
            const response = await fetch(form.action, {method: 'POST', body: new FormData(form), headers: {'Accept':'application/json','X-Requested-With':'XMLHttpRequest'}});
            const result = await response.json();
            if (!response.ok) throw new Error(result.message || Object.values(result.errors || {}).flat()[0] || 'Could not save this draft.');
            notice.textContent = 'Draft saved to the database. Reloading the latest draft…';
            notice.classList.remove('d-none','ve-error');
            saveState.textContent = 'Draft saved';
            const url = new URL(window.location.href);
            url.searchParams.set('page', form.querySelector('[name="page_key"]').value);
            url.searchParams.set('component', form.querySelector('[name="component_key"]').value);
            window.location.href = url.toString();
        } catch(error) {
            notice.textContent = error.message;
            notice.classList.remove('d-none');
            notice.classList.add('ve-error');
            saveState.textContent = 'Save failed';
        } finally {
            button.disabled = false;
        }
    });

    preview.querySelectorAll('[data-preview-target]').forEach(target => { target.dataset.defaultText = target.textContent; });
    applyPreview();
})();
</script>
@endsection
