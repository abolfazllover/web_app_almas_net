const CACHE_NAME = 'my-cache-v1';
const urlsToCache = [];

// Install event: cache the resources
self.addEventListener('install', event => {
    console.log('Service Worker installing.');
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                return cache.addAll(urlsToCache);
            })
            .then(() => self.skipWaiting())
            .catch(error => {
                console.error('Failed to cache during install:', error);
            })
    );
});

// Activate event: clear old caches
self.addEventListener('activate', event => {
    console.log('Service Worker activating.');
    const cacheWhitelist = [CACHE_NAME];
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (!cacheWhitelist.includes(cacheName)) {
                        console.log(`Deleting cache: ${cacheName}`);
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});



// Optional: message event for manual cache clearing
self.addEventListener('message', event => {
    if (event.data === 'skipWaiting') {
        self.skipWaiting();
    }
});


var client;
var geo;
self.addEventListener("message", (event) => {

    client=event.source;

    if (event.data==='Start_counter'){
        request_to_access_geo();
    }
});

function request_to_access_geo(){
    navigator.geolocation.getCurrentPosition(function (position) {
        geo=position;
        sendData_toClient({'message' : "geo",'data' : geo})
    },function (e) {
        error_alert('دسترسی به موقعیت داده نشد!')
    })
}

function sendData_toClient(data){
    self.clients.matchAll({ type: 'window' }).then(function(clients) {
        clients.forEach(function(client) {
            if (client instanceof WindowClient) {
                client.postMessage(data);
            }
        });
    });
}


