self.addEventListener('install', (event) => {
    event.waitUntil(self.skipWaiting());
});

self.addEventListener('activate', (event) => {
    event.waitUntil(self.clients.claim());
});

self.addEventListener('fetch', (event) => {
    if (event.request.method === 'GET' && event.request.destination !== 'document') {
        event.respondWith(fetch(event.request));
    }
});

self.addEventListener('notificationclick', (event) => {
    event.notification.close();
    const target = new URL(event.notification.data?.url || '/', self.location.origin).href;
    event.waitUntil(self.clients.matchAll({ type: 'window', includeUncontrolled: true }).then((clients) => {
        const existing = clients.find((client) => client.url.startsWith(self.location.origin + '/delivery/driver/'));
        if (existing) return existing.focus().then(() => existing.navigate(target));
        return self.clients.openWindow(target);
    }));
});
