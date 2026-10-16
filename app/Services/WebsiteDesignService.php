<?php

namespace App\Services;

use App\Models\WebsiteDesignRevision;
use Illuminate\Support\Facades\Cache;

class WebsiteDesignService
{
    /** Explicit catalog: only these stable components can be edited. */
    public function catalog(): array
    {
        return [
            'customer.home' => ['label' => 'Customer home', 'audience' => 'Customer', 'components' => ['hero' => ['label' => 'Welcome hero', 'selector' => '[data-ve="customer.home.hero"]', 'accent_selector' => '[data-ve="customer.home.hero"] .customer-hero-actions a:first-child', 'movable' => true, 'sample' => 'Find something worth bringing home.']]],
            'customer.products' => ['label' => 'Product listing', 'audience' => 'Customer', 'components' => [
                'hero' => ['label' => 'Products hero', 'selector' => '[data-ve="customer.products.hero"]', 'accent_selector' => '[data-ve="customer.products.hero"] .hero-btn-primary', 'movable' => true, 'sample' => 'Shop smarter. Live better.'],
                'product_card' => ['label' => 'Product cards', 'selector' => '[data-ve="customer.products.card"]', 'accent_selector' => '[data-ve="customer.products.card"] .price', 'sample' => 'Product card'],
            ]],
            'customer.product_detail' => ['label' => 'Product details', 'audience' => 'Customer', 'components' => ['gallery' => ['label' => 'Product gallery frame', 'selector' => '[data-ve="customer.product_detail.gallery"]', 'accent_selector' => '[data-ve="customer.product_detail.gallery"] .thumb.active', 'sample' => 'Product gallery']]],
            'customer.shared' => ['label' => 'Shared customer taskbar', 'audience' => 'Shared', 'components' => ['taskbar' => ['label' => 'Customer taskbar', 'selector' => '[data-ve="customer.shared.taskbar"]', 'accent_selector' => '[data-ve="customer.shared.taskbar"] .sb-brand-mark,[data-ve="customer.shared.taskbar"] .sb-sidebar-logo', 'movable' => false, 'sample' => 'Smart Basket navigation']]],
            'seller.dashboard' => ['label' => 'Seller dashboard', 'audience' => 'Seller', 'components' => ['hero' => ['label' => 'Dashboard welcome', 'selector' => '[data-ve="seller.dashboard.hero"]', 'accent_selector' => '[data-ve="seller.dashboard.hero"] .sb-primary-btn', 'movable' => true, 'sample' => 'Grow your store. Sell smarter.']]],
        ];
    }

    public function component(string $page, string $component): ?array
    {
        return $this->catalog()[$page]['components'][$component] ?? null;
    }

    public function published(string $page, string $component): array
    {
        return Cache::remember("website-design:published:$page:$component", 600, fn () =>
            WebsiteDesignRevision::query()
                ->where('page_key', $page)
                ->where('component_key', $component)
                ->where('status', 'published')
                ->latest('revision')
                ->first()?->settings ?? []
        );
    }

    public function latestPublished(string $page, string $component): ?WebsiteDesignRevision
    {
        return WebsiteDesignRevision::query()
            ->where('page_key', $page)
            ->where('component_key', $component)
            ->where('status', 'published')
            ->latest('revision')
            ->first();
    }

    public function invalidate(string $page, string $component): void
    {
        Cache::forget("website-design:published:$page:$component");
    }

    public function renderCss(string $page, ?array $overrides = null): string
    {
        $rules = [];
        foreach ($this->catalog()[$page]['components'] ?? [] as $key => $component) {
            $settings = $overrides !== null && ($overrides['component_key'] ?? null) === $key
                ? ($overrides['settings'] ?? [])
                : $this->published($page, $key);
            if ($settings === []) continue;

            $selector = $component['selector'];
            $decl = [];
            foreach (['background' => 'background-color', 'text_color' => 'color', 'border_color' => 'border-color'] as $field => $property) {
                if (! empty($settings[$field])) $decl[] = $property . ':' . $settings[$field];
            }
            foreach (['radius' => 'border-radius', 'padding' => 'padding', 'font_size' => 'font-size'] as $field => $property) {
                if (isset($settings[$field])) $decl[] = $property . ':' . (int) $settings[$field] . 'px';
            }
            if (isset($settings['shadow'])) $decl[] = 'box-shadow:' . ($settings['shadow'] === 'soft' ? '0 14px 40px rgba(5,15,35,.18)' : 'none');
            if (! empty($settings['text_align'])) $decl[] = 'text-align:' . $settings['text_align'];
            if ($decl) $rules[] = $selector . '{' . implode(';', $decl) . '}';
            if (($settings['gradient_start'] ?? null) && ($settings['gradient_end'] ?? null)) $rules[] = $selector . '{background:linear-gradient(135deg,' . $settings['gradient_start'] . ',' . $settings['gradient_end'] . ')}';
            if (! empty($settings['accent']) && ! empty($component['accent_selector'])) $rules[] = $component['accent_selector'] . '{background-color:' . $settings['accent'] . ';border-color:' . $settings['accent'] . ';color:#fff}';
            if (! empty($settings['font_family'])) $rules[] = $selector . '{font-family:' . $settings['font_family'] . ',sans-serif}';
            if (isset($settings['font_weight'])) $rules[] = $selector . '{font-weight:' . (int) $settings['font_weight'] . '}';
            if (isset($settings['line_height'])) $rules[] = $selector . '{line-height:' . number_format((float) $settings['line_height'], 2, '.', '') . '}';
            if (isset($settings['letter_spacing'])) $rules[] = $selector . '{letter-spacing:' . number_format((float) $settings['letter_spacing'], 2, '.', '') . 'px}';
            if (isset($settings['opacity'])) $rules[] = $selector . '{opacity:' . number_format((float) $settings['opacity'], 2, '.', '') . '}';
            if (isset($settings['border_width'])) $rules[] = $selector . '{border-width:' . (int) $settings['border_width'] . 'px;border-style:solid}';
            if (! empty($settings['width'])) $rules[] = $selector . '{width:' . (int) $settings['width'] . '%}';
            if (! empty($settings['height'])) $rules[] = $selector . '{min-height:' . (int) $settings['height'] . 'px}';
            if (! empty($component['movable']) && (isset($settings['offset_x']) || isset($settings['offset_y']))) $rules[] = $selector . '{position:relative;left:' . (int) ($settings['offset_x'] ?? 0) . 'px;top:' . (int) ($settings['offset_y'] ?? 0) . 'px}';
            if (($settings['shadow'] ?? 'none') === 'glow') $rules[] = $selector . '{box-shadow:0 0 35px rgba(80,120,255,.35)}';
            if (isset($settings['mobile_radius']) || isset($settings['mobile_padding']) || isset($settings['mobile_font_size'])) {
                $mobile = [];
                foreach (['mobile_radius' => 'border-radius', 'mobile_padding' => 'padding', 'mobile_font_size' => 'font-size'] as $field => $property) {
                    if (isset($settings[$field])) $mobile[] = $property . ':' . (int) $settings[$field] . 'px';
                }
                $rules[] = '@media(max-width:700px){' . $selector . '{' . implode(';', $mobile) . '}}';
            }
            if (isset($settings['tablet_radius']) || isset($settings['tablet_padding']) || isset($settings['tablet_font_size'])) {
                $tablet = [];
                foreach (['tablet_radius' => 'border-radius', 'tablet_padding' => 'padding', 'tablet_font_size' => 'font-size'] as $field => $property) {
                    if (isset($settings[$field])) $tablet[] = $property . ':' . (int) $settings[$field] . 'px';
                }
                $rules[] = '@media(min-width:701px) and (max-width:1024px){' . $selector . '{' . implode(';', $tablet) . '}}';
            }
        }

        return implode("\n", $rules);
    }

    public function content(string $page, string $component, string $field, string $default): string
    {
        $settings = $this->published($page, $component);
        return (string) ($settings['content'][$field] ?? $default);
    }
}
