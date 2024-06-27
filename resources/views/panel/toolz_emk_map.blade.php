@php
$all_namem_tci=(new \App\Http\Controllers\ApiController())->get_namem_tci();
$all_namem_tci=$all_namem_tci['result'];

@endphp
@extends('components.map')
@section('options')
    <i onclick="show_all_namem_tci()" id="tower_tci" class="fas fa-broadcast-tower bg-light p-1 rounded-2"></i>
    <i style="display: none" onclick="click_active_user()" id="users_namem" class="fas fa-users bg-light p-1 rounded-2"></i>
@endsection

@section('footer_action')
    <p class="text-center">
        فاصله بین شما و مشترک :
        <span id="distance">موقعیت خود را ثبت کنید</span>
    </p>

    <div id="bd_filter_num" class="row m-auto w-100" style="display: none">
        <div class="col-12" style="color: #9d9595;font-size: 0.7rem">فیلتر مراکز :</div>
        <div class="col-8"><input id="num_filter" type="number" placeholder="برحسب متر" class="form-control"></div>
        <div class="col-4"><button onclick="filter_dit()" class="btn d-block w-100 btn-success">فیلتر</button></div>
    </div>
@endsection



@section("script_map")
<script>

    var markers_tci = [];

    var user_icon = L.icon({
        iconUrl: '{{route('home')}}/img/user_location_icon.png',
        iconSize: [40, 40], // اندازه آیکون
    });

    var users_icon = L.icon({
        iconUrl: '{{route('home')}}/img/users_icon.png',
        iconSize: [40, 40], // اندازه آیکون
    });

    var tower_icon = L.icon({
        iconUrl: '{{route('home')}}/img/tower_location.png',
        iconSize: [40, 40], // اندازه آیکون
    });

    var tower_icon2 = L.icon({
        iconUrl: '{{route('home')}}/img/tower_location2.png',
        iconSize: [40, 40], // اندازه آیکون
    });


    var customer= L.marker([base_lat,base_lon],{icon : user_icon});




    customer.addTo(map)

    customer.bindPopup("موقعیت مشترک")
    user_marker.bindPopup("موقعیت شما")




    function show_all_namem_tci() {
        $('#bd_filter_num').show()
        @foreach($all_namem_tci as $key=>$item)
        @if(!isset($item['lat']) or $item['lat']==null) @continue @endif
        var text="{{$item['name']}}<br>"+"فاصله مشترک تا مرکز : "+calculateDistance(base_lat,base_lon,"{{$item['lat']}}","{{$item['lon']}}")
        var icon= {{$item['icon']}};
        var marker{{$key}}=L.marker([{{$item['lat']}},{{$item['lon']}}],{icon : icon}).bindPopup(text).addTo(map);
        markers_tci.push(marker{{$key}})


        if ("{{$item['icon']}}"=='tower_icon2'){
            marker{{$key}}.on('click',function () {
                $('#users_namem').attr('data-name',"{{$item['name']}}")
                $('#users_namem').attr('data-lat',"{{$item['lat']}}")
                $('#users_namem').attr('data-lon',"{{$item['lon']}}")
                $('#users_namem').show();
            })
        }else {
            marker{{$key}}.on('click',function () {
                $('#users_namem').hide();
            });
        }
        @endforeach

    }

    function filter_dit() {
        show_all_namem_tci();
        var num=parseInt($('#num_filter').val());
        markers_tci = markers_tci.filter(function(marker) {
            var latlng=marker.getLatLng();
            if (calculateDistance(latlng.lat,latlng.lng,base_lat,base_lon,true)>num){
                removeMarker(marker);
            }
        });
    }


    // تابع حذف تمامی خطوط
    function removeAllLines() {
        polylineGroup.clearLayers();
    }

    map.on("click",function (e){
        console.log(e)
    })


    var users_namem=[];
    function get_active_users_namem(namem,lat,lon) {
        $('#users_namem').fadeOut()
        users_namem.filter(function (marker) {
            removeMarker(marker);
        })
        removeAllLines();

        ajax_sender("{{route('get_active_users_namem_api')}}",{'namem' : namem},'post',function (e) {
            if(e.result.length>0){

                e.result.forEach(function (item) {
                   var marker=L.marker([item.lat,item.lon],{icon : users_icon}).bindPopup(item.name).addTo(map)
                   drawLine(item.lat,item.lon,lat,lon);
                   users_namem.push(marker);
                })
            }
        })
    }

    function click_active_user(){
        var elm=$('#users_namem');
        get_active_users_namem(elm.attr('data-name'),elm.attr('data-lat'),elm.attr('data-lon'));
    }


    active_back_icon()
</script>
@endsection
