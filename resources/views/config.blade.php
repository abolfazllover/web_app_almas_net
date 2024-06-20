

<script>

    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/sw.js?v3').then(function(registration) {
                console.log('Service Worker registered with scope:', registration.scope);

                /* برسی آپدیت سرویس ورکر */
                registration.onupdatefound = function() {
                    const installingWorker = registration.installing;
                    installingWorker.onstatechange = function() {
                        if (installingWorker.state === 'installed') {
                            if (navigator.serviceWorker.controller) {
                                // سرویس ورکر جدید نصب شده است و در حالت "waiting" قرار دارد.
                                console.log('New Service Worker available');
                                showUpdateNotification();
                            } else {
                                // اولین بار نصب سرویس ورکر
                                console.log('Service Worker installed for the first time');
                            }
                        }
                    };
                };


                console.log( registration.update());

            }, function(err) {
                console.log('Service Worker registration failed:', err);
            });
        });
    }



    var deferredPrompt;

    window.addEventListener('beforeinstallprompt', (e) => {
        deferredPrompt=e;
    });

    function install_app(){
        if(deferredPrompt!==undefined){
            deferredPrompt.prompt()
        }else {
            alert('امکان نصب وجود ندارد!')
        }
    }

    // if (window.matchMedia('(display-mode: standalone)').matches) {
    //     alert('App is running in standalone mode');
    // } else {
    //     alert('App is running in browser mode');
    // }

    @if($errors->any())
    @foreach ($errors->all() as $error)
    error_alert("{{$error}}",'خطا')
    @endforeach
    @endif

    @if(session()->has('success'))
    success_alert("{{session('success')}}")
    @endif


    function showUpdateNotification() {
        const updateDiv = document.createElement('div');
        updateDiv.id = 'update-notification';
        updateDiv.innerHTML = `
    <p>New version available. Please reload the page.</p>
    <button onclick="updateServiceWorker()">Reload</button>
  `;
        $('body').html(updateDiv);
    }

    function updateServiceWorker() {
        if (navigator.serviceWorker.controller) {
            navigator.serviceWorker.controller.postMessage({ action: 'skipWaiting' });
        }
        window.location.reload();
    }

</script>
