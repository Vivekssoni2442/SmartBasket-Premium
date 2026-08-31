document.addEventListener('DOMContentLoaded', function () {
    if (window.SmartBasketAIHubInitialized) return;
    window.SmartBasketAIHubInitialized = true;

    const drawer = document.querySelector('[data-ai-hub-drawer]');
    const overlay = document.querySelector('.ai-hub-overlay');
    const content = document.querySelector('[data-ai-hub-content]');
    const trigger = document.querySelector('[data-ai-hub-open]');

    if (!drawer || !overlay || !trigger) return;

    const close = () => {
        drawer.classList.remove('is-open');
        overlay.classList.remove('is-visible', 'is-open');
        drawer.setAttribute('aria-hidden', 'true');
        trigger.setAttribute('aria-expanded', 'false');
        document.body.classList.remove('ai-hub-open');
    };
    const open = () => {
        drawer.classList.add('is-open');
        overlay.classList.add('is-visible');
        drawer.setAttribute('aria-hidden', 'false');
        trigger.setAttribute('aria-expanded', 'true');
        document.body.classList.add('ai-hub-open');
    };
    const load = async (url) => {
        content.innerHTML = '<div class="ai-hub-drawer-empty"><span>✨</span><strong>Loading tool…</strong></div>';
        const joiner = url.includes('?') ? '&' : '?';
        try {
            const response = await fetch(url + joiner + 'sidebar=1', { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            if (response.redirected) { window.location.href = response.url; return; }
            if (!response.ok) throw new Error('Unable to load this tool.');
            content.innerHTML = await response.text();
        } catch (error) {
            content.innerHTML = '<div class="ai-hub-drawer-empty"><span>⚠️</span><strong>Unable to load this tool</strong><p>Please try again.</p></div>';
        }
    };

    trigger.addEventListener('click', () => {
        drawer.classList.contains('is-open') ? close() : open();
    });
    document.querySelectorAll('[data-ai-hub-close]').forEach((button) => button.addEventListener('click', close));
    document.querySelectorAll('[data-ai-hub-feature]').forEach((button) => button.addEventListener('click', () => {
        document.querySelectorAll('[data-ai-hub-feature]').forEach((item) => item.classList.remove('is-active'));
        button.classList.add('is-active');
        load(button.dataset.aiHubUrl);
    }));
    if (content) {
        content.addEventListener('click', (event) => {
            const link = event.target.closest('[data-ai-hub-panel-link]');
            if (!link) return;
            event.preventDefault();
            load(link.href);
        });
        content.addEventListener('submit', async (event) => {
        const form = event.target.closest('[data-ai-hub-form]');
        if (!form) return;
        event.preventDefault();
        const formData = new FormData(form);
        formData.set('sidebar', '1');
        const method = (form.method || 'GET').toUpperCase();
        let url = form.action;
        const options = { method, headers: { 'X-Requested-With': 'XMLHttpRequest' } };
        if (method === 'GET') { const query = new URLSearchParams(formData); url += (url.includes('?') ? '&' : '?') + query.toString(); } else { options.body = formData; }
        content.innerHTML = '<div class="ai-hub-drawer-empty"><span>✨</span><strong>Working…</strong></div>';
        try { const response = await fetch(url, options); if (response.redirected) { window.location.href = response.url; return; } if (!response.ok) throw new Error(); content.innerHTML = await response.text(); } catch (error) { content.innerHTML = '<div class="ai-hub-drawer-empty"><span>⚠️</span><strong>Something went wrong</strong><p>Please try again.</p></div>'; }
        });
    }
    document.addEventListener('keydown', (event) => { if (event.key === 'Escape') close(); });
});
