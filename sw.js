const CACHE_NAME = 'escola-v1';
const urlsToCache = [
  'index.php',
  'cadastro.php',
  'editar.php',
  'manifest.json',
  'icons/icon-192.png',
  'icons/icon-512.png'
];

// 1. Instalação: Cache dos arquivos estáticos
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        console.log('Arquivos em cache');
        return cache.addAll(urlsToCache);
      })
  );
});

// 2. Ativação: Limpa caches antigos se mudar a versão
self.addEventListener('activate', event => {
  const cacheWhitelist = [CACHE_NAME];
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cacheName => {
          if (cacheWhitelist.indexOf(cacheName) === -1) {
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
});

// 3. Interceptação (Fetch): Tenta a rede primeiro, se cair, tenta o cache
// Isso é vital para PHP dinâmico. Não queremos mostrar dados velhos.
self.addEventListener('fetch', event => {
  event.respondWith(
    fetch(event.request)
      .catch(() => {
        return caches.match(event.request);
      })
  );
});