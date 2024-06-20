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



    <style>
        .item_menu{
            min-height: 100px
        }

        .item_menu:hover{
            background: #efefef;
        }
    </style>
</head>
<body class="w-100 h-100 d-flex justify-content-center">
<div class="col-md-3 col-12 shadow-sm">
    <nav id="top_nav" class="p-1 w-100 bg_basic py-2" style="height: 8%">
        <div class="row h-100 align-content-center" style="font-size: 1.1rem">
            <div class="col-6">
               <a href="{{route('panel')}}" class="fas fa-home bg-light p-2 rounded-2 text-dark"></a>
                <span style="font-size: 0.9rem">{{$user['name']}}</span>
            </div>
            <div class="col-6 d-flex justify-content-end">
                <i onclick="set_location()" class="fa fa-power-off p-2 rounded-2 text-dark"></i>
            </div>
        </div>
    </nav>


    <main class="py-1" style="height: 92%">
        @if($page=='home')
        <div class="col-6">
            <a href="{{route('page','sub_traffic')}}" class="shadow-sm p-1 border btn d-flex flex-column justify-content-center align-items-center item_menu">
                <i style="color: #3B94DC" class="fa fa-car my-2"></i>
               <h4 class="h6">ثبت تردد</h4>
            </a>

            <span id="cu">0</span>
        </div>
        @else
            @if(view()->exists('panel.'.$page)) @include('panel.'.$page) @endif
        @endif
    </main>

</div>
</body>


@include('config')
<script>



    if( navigator.serviceWorker.controller!=null){
        navigator.serviceWorker.controller.postMessage('Start_counter')
    }

    navigator.serviceWorker.addEventListener('message',function (e) {
        console.log(e.data)
        if(e.data.message=='hi'){
            $('#cu').html(e.data.cu)
        }
    })

</script>

</html>
