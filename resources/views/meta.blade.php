<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="almasNetApp">
<link rel="apple-touch-icon" sizes="180x180" href="{{route('home')}}/img/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="{{route('home')}}/img/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="{{route('home')}}/img/favicon-16x16.png">
<link rel="manifest"  href="{{route('home')}}/manifest.json">

<meta name="theme-color" content="#dfdfdf">


<link rel="stylesheet" href="{{route('home')}}/css/bootstrap.css">
<script src="{{route('home')}}/js/jq.js"></script>
<script src="{{route('home')}}/js/basic.js"></script>
<script src="{{route('home')}}/js/bootstrap-notify.min.js"></script>
<script src="{{route('home')}}/js/bootstrap.js"></script>
<meta name="csrf-token" content="{{@csrf_token()}}">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>

    @font-face {
        font-family: 'yk_bold';
        src: url('{{route('home')}}/fonts/IRANSansXBold.ttf') format('truetype'),
    }
    @font-face {
        font-family: 'yk_normal';
        src: url('{{route('home')}}/fonts/IRANSansXMedium.ttf') format('truetype'),
    }

    @media only screen and (max-width: 600px) {
        body{
            font-size: 0.7rem;
        }
    }

    body{
        font-size: 0.8rem;
    }

    *{
        font-family: yk_normal;
        direction: rtl;
    }
    h1,h2,h3,h4,h5,h6{
        font-family: yk_bold;
    }
    label{
        font-family: yk_bold;
        color: #757575;
        margin: 5px 0;
    }
    .bg_basic{
        background: #3B94DC;
        color: #fff;
    }

    .color_basic{
        color: #3B94DC;
    }

    .select2-selection{
        height: 40px!important;
        padding: 7px!important;
        border-color: #ccc!important;
    }
    .select2-selection__arrow{
        top: 8px!important;
        left: 10px!important;
    }
</style>

