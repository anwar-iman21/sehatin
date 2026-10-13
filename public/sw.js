const STATIC_CACHE = 'sehatin-static-v1';
const ARTICLE_CACHE = 'sehatin-articles-v1';
const ARTICLE_CACHE_LIMIT = 30;
const STATIC_URLS = [
    '/offline.html',
    '/manifest.webmanifest',
    '/sehatin-192.svg',
    '/sehatin-512.svg',
    '/favicon.svg',
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(STATIC_CACHE)
            .then(cache => cache.addAll(STATIC_URLS))
            .then(() => self.skipWaiting())
    );
});

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys()
            .then(keys => Promise.all(keys
                .filter(key => key.startsWith('sehatin-') && ![STATIC_CACHE, ARTICLE_CACHE].includes(key))
                .map(key => caches.delete(key))))
            .then(() => self.clients.claim())
    );
});

self.addEventListener('fetch', event => {
    const request = event.request;
    const url = new URL(request.url);
    if (request.method !== 'GET' || url.origin !== self.location.origin) return;

    if (request.mode === 'navigate' && /^\/artikel\/[^/]+\/?$/.test(url.pathname)) {
        event.respondWith(fetchArticleOrOffline(request));
        return;
    }

    if (request.mode === 'navigate' && url.pathname === '/offline') {
        event.respondWith(fetch(request).catch(() => caches.match('/offline.html')));
        return;
    }

    if (request.mode === 'navigate') {
        event.respondWith(fetchNavigationOrOffline(request));
        return;
    }

    if (url.pathname.startsWith('/build/') || url.pathname === '/favicon.svg'
        || url.pathname === '/sehatin-192.svg' || url.pathname === '/sehatin-512.svg') {
        event.respondWith(cacheStaticAsset(request));
    }
});


async function fetchNavigationOrOffline(request) {
    try {
        return await fetch(request);
    } catch {
        return await caches.match(request) || await caches.match('/offline.html');
    }
}
async function fetchArticleOrOffline(request) {
    try {
        const response = await fetch(request);
        const cacheControl = response.headers.get('Cache-Control') || '';
        if (response.ok && response.headers.get('Content-Type')?.includes('text/html')
            && !/\b(?:private|no-store)\b/i.test(cacheControl)) {
            const cache = await caches.open(ARTICLE_CACHE);
            await cache.put(request, response.clone());
            const keys = await cache.keys();
            if (keys.length > ARTICLE_CACHE_LIMIT) {
                await cache.delete(keys[0]);
            }
        }
        return response;
    } catch {
        return await caches.match(request) || await caches.match('/offline.html');
    }
}

async function cacheStaticAsset(request) {
    const cached = await caches.match(request);
    if (cached) return cached;

    const response = await fetch(request);
    if (response.ok) {
        const cache = await caches.open(STATIC_CACHE);
        await cache.put(request, response.clone());
    }
    return response;
}
