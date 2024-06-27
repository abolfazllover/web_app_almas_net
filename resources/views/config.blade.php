<style>
    .loader {
        position: relative;
        width: 100px;
        height: 100px;
    }

    .loader:before , .loader:after{
        content: '';
        border-radius: 50%;
        position: absolute;
        inset: 0;
        box-shadow: 0 0 10px 2px rgba(0, 0, 0, 0.3) inset;
    }
    .loader:after {
        box-shadow: 0 2px 0 #3B94DC inset;
        animation: rotate 2s linear infinite;
    }

    @keyframes rotate {
        0% {  transform: rotate(0)}
        100% { transform: rotate(360deg)}
    }
</style>

<div  id="loader" class="position-fixed end-0 top-0 w-100 h-100" style="display: none;z-index: 99999999999999999;background: rgba(58,58,58,0.85)">
    <div class="d-flex w-100 h-100 justify-content-center align-items-center"><span class="d-block loader"></span></div>
</div>


<script>
    $('.select2').select2({
        placeholder: 'یک گزینه انتخاب کنید.'
    })

    function open_loader(){
      $('#loader').show();
      setTimeout(function () {
          $('#loader').hide();
      },4000)
    }

    $('a').click(function (){
        open_loader();
    })

    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js')
            .then(registration => {
                console.log('Service Worker registered with scope:', registration.scope);





                // Listen for the updatefound event on the registration
                registration.onupdatefound = () => {
                    const installingWorker = registration.installing;
                    console.log('A new service worker is being installed:', installingWorker);

                    installingWorker.onstatechange = () => {
                        switch (installingWorker.state) {
                            case 'installed':
                                if (navigator.serviceWorker.controller) {
                                    // New update available
                                    console.log('New content is available; please refresh.');
                                    if (confirm('نسجه جدید در دسترس است ! لطفا صفحه را مجدد بارگذاری کنید!')) {
                                        window.location.reload();
                                    }
                                } else {
                                    // Content is cached for offline use
                                    console.log('Content is cached for offline use.');
                                }
                                break;

                            case 'redundant':
                                console.error('The installing service worker became redundant.');
                                break;
                        }
                    };
                };
            })
            .catch(error => {
                console.error('Error during service worker registration:', error);
            });
    }



    let installPrompt = null;
    const installButton = document.querySelector("#install");

    window.addEventListener("beforeinstallprompt", (event) => {
        event.preventDefault();
        installPrompt = event;
        installButton.removeAttribute("hidden");
    });


    if (installButton!=null){
        installButton.addEventListener("click", async () => {
            if (!installPrompt) {
                return;
            }
            const result = await installPrompt.prompt();
            console.log(`Install prompt was: ${result.outcome}`);
            disableInAppInstallPrompt();
        });
    }

    function disableInAppInstallPrompt() {
        installPrompt = null;
        installButton.setAttribute("hidden", "");
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


</script>
