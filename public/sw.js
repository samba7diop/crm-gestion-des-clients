self.addEventListener('install', (event) => {
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(self.clients.claim());
});

self.addEventListener('fetch', (event) => {
    if (event.request.method !== 'GET') {
        return;
    }

    event.respondWith(
        caches.open('crm-v1').then((cache) =>
            cache.match(event.request).then((cached) =>
                cached || fetch(event.request).then((response) => {
                    cache.put(event.request, response.clone());
                    return response;
                })
            )
        )
    );
});
