<!doctype html>
<html lang="fa"  style="overflow-x: hidden" class="w-100 h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>وب اپلیکیشن الماس نت</title>
    @include('meta')



    <link rel="stylesheet" href="https://static.neshan.org/sdk/leaflet/v1.9.4/neshan-sdk/v1.0.8/index.css"/>
    <script src="https://static.neshan.org/sdk/leaflet/v1.9.4/neshan-sdk/v1.0.8/index.js"></script>
    <script src="{{route('home')}}/js/Polyline.encoded.js"></script>



    <style>
        .item_menu{
            min-height: 100px
        }

        .item_menu:hover{
            background: #efefef;
        }
        .counter{
            position: absolute;
            right: 20px;
            top: 10px;
            padding: 5px;
            background: red;
            color: #fff;
            border-radius: 5px;
            min-width: 20px;
            font-size: 0.7rem;
        }
        a{
            text-decoration: inherit!important;
        }


    </style>

    <script>
        function active_back_icon(){
            $('#back_icon').show()
        }
        function request_to_access_geo(fun){
            navigator.geolocation.getCurrentPosition(function (position) {
                geo=position;
                fun(position)
            },function (e) {
                error_alert('دسترسی به موقعیت داده نشد!')
            })
        }

    </script>
</head>
<body class="w-100 h-100 d-flex justify-content-center">
<div class="col-md-3 col-12 shadow-sm">
    <nav id="top_nav" class="p-1 w-100 bg_basic py-2 m-0">
        <div class="row h-100 align-content-center" style="font-size: 1.1rem">
            <div class="col-6">
               <a href="{{route('panel')}}" class="fas fa-home bg-light p-2 rounded-2 text-dark"></a>
                <span style="font-size: 0.9rem">{{$user['name']}}</span>
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{route('log_out')}}" class="fa fa-power-off p-2 rounded-2 text-dark"></a>
                <a id="back_icon" style="display: none" href="{{url()->previous()}}" class="fa fa-arrow-left p-2 rounded-2 text-light ms-2"></a>
            </div>
        </div>
    </nav>


    <main class="py-1 row" style="height: 92%">
        @if($page=='home')
        <div class="col-6 position-relative">
            <a href="{{route('page','list_sub_traffic')}}" class="shadow-sm p-1 border btn d-flex flex-column justify-content-center align-items-center item_menu">
                <i style="color: #3B94DC" class="fa fa-car my-2"></i>
               <h4 class="h6">ثبت تردد</h4>
            </a>
        </div>

        <div class="col-6 position-relative">
                <a href="{{route('page','see_view_m')}}" class="shadow-sm p-1 border btn d-flex flex-column justify-content-center align-items-center item_menu">
                    <i style="color: #3B94DC" class="fa fa-walking my-2"></i>
                    <h4 class="h6">بازدید میدانی</h4>
                    @if($basic_info['num_view_m']>0)
                    <span class="counter">{{$basic_info['num_view_m']}}</span>
                    @endif
                </a>
        </div>
        @else
           <div class="col-12">
               @if(view()->exists('panel.'.$page)) @include('panel.'.$page) @endif
           </div>
        @endif
    </main>

</div>
</body>


@include('config')
<script>


    if( navigator.serviceWorker.controller!=null){
        navigator.serviceWorker.controller.postMessage('Start_counter')
    }else {
        console.log('not active navigator.serviceWorker.controller')
    }
</script>

</html>
