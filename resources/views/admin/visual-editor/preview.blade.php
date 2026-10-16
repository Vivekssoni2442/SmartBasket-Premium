<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Draft Preview | Smart Basket</title>
    <style>
        :root { color-scheme: light; font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif; }
        * { box-sizing: border-box; }
        body { min-height: 100vh; margin: 0; padding: clamp(16px, 4vw, 44px); color: #0b1f42; background: #f4f8ff; }
        .preview-shell { display: grid; min-height: calc(100vh - clamp(32px, 8vw, 88px)); place-items: center; }
        .preview-content { width: min(100%, 920px); min-height: 240px; padding: clamp(24px, 5vw, 56px); border: 1px solid #d8e2f0; border-radius: 22px; background: #fff; box-shadow: 0 18px 48px rgba(7, 21, 47, .12); overflow-wrap: anywhere; }
        .preview-content h1, .preview-content h2 { margin: 0 0 14px; line-height: 1.18; }
        .preview-content p { max-width: 68ch; margin: 0 0 22px; color: #475569; font-size: 16px; line-height: 1.7; }
        .preview-content button { min-height: 44px; padding: 11px 18px; border: 0; border-radius: 10px; color: #fff; background: #155eef; font: inherit; font-weight: 700; }
        @media (max-width: 600px) { .preview-content { border-radius: 16px; } }
    </style>
    <style>{!! $css !!}</style>
</head>
<body>
    <main class="preview-shell">
        <section class="preview-content" data-ve="{{ $revision->page_key.'.'.$revision->component_key }}">
            <h1>{{ $revision->settings['content']['title'] ?? $component['sample'] }}</h1>
            <p>{{ $revision->settings['content']['body'] ?? 'This is an authenticated preview of the selected website component.' }}</p>
            <button type="button">{{ $revision->settings['content']['button_label'] ?? 'Explore Smart Basket' }}</button>
        </section>
    </main>
</body>
</html>
