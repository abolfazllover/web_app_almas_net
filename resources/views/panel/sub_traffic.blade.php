@if(request()->has('for'))
    @php $code=base64_decode(request('for')); @endphp
@endif

@extends('components.map')
@section('footer_action')
    <div class="row m-auto step1" style="min-height: 120px">
        <div class="col-12 d-flex justify-content-center align-items-center">
            <div class="btn-group btn-group">
                <button {{request()->has('type') && request('type')=='magh' ? 'disabled' : ''}} id="btn_mab" onclick="next_step('mab')" class="btn btn-primary">ثبت مبدا</button>
                <button {{request()->has('type') && request('type')=='mab' ? 'disabled' : ''}} id="btn_magh" onclick="next_step('magh')" class="btn btn-warning">ثبت مقصد</button>
            </div>
        </div>
    </div>
    <div class="row m-auto step2" style="display: none">
        <div class="col-12">
            <div style="font-size: 1.2rem" class="mb-2 ms-2 form-check form-switch d-flex align-items-center">
                <input  style="font-size: 1.4rem" class="form-check-input" type="checkbox" role="switch" id="has_car">
                <label style="font-size: 0.7rem" class="form-check-label my-0 ms-2 me-2" for="has_car">تردد با خودرو</label>
            </div>
        </div>
        <div class="col-12"><textarea id="dic" class="form-control" placeholder="توضیحات"></textarea></div>
        <div class="col-12 mt-2"><button onclick="send_data()" style="" class="btn w-100 btn-success">ثبت موقعیت</button></div>
    </div>
@endsection

@section('script_map')
<script>

    active_back_icon();
    var code="{{$code ?? $basic_info['code_traffic']}}";
    var type='{{request()->has('type') ? request('type') : 'mab'}}';

    @if(request()->has('type')) next_step("{{request('type')}}") @endif

    function next_step(type_selected){
        $('.step1').hide();
        $('.step2').show()
        type=type_selected;
    }
    function prev_step(type){

        if(type=='mab'){
            $('#btn_mab').prop('disabled',true)
        }else {
            $('#btn_magh').prop('disabled',true)
        }
        $('.step1').show();
        $('.step2').hide()
    }

    function get_code_sub_traffic(){
        ajax_sender('{{route('get_code_sub_traffic')}}',{},"post",function (e){
            console.log(e)
        })
    }


    var icon_mab=new L.Icon({
        iconUrl: '{{route('home')}}/img/mr_mab.png',
        iconSize: [40, 40],
    });

    var icon_magh=new L.Icon({
        iconUrl: '{{route('home')}}/img/mr_magh.png',
        iconSize: [40, 40],
    });





    let mab_marker= L.marker([base_lat,base_lon], { icon: icon_mab, title: "مبدا" });
    let magh_marker= L.marker([base_lat,base_lon], { icon: icon_magh, title: "مقصد" });


    $(window).ready(function () {
        my_location();
    })


    // این تابع هر زمان که موقعیت مکانی کاربر تغییر کند، فراخوانی می‌شود
    function positionChanged(position) {
        // گرفتن طول و عرض جغرافیایی از موقعیت مکانی کاربر
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;

        // sub_playload(latitude,longitude)

        base_lat=latitude;
        base_lon=longitude;
        
       basic_seter_marker(latitude,longitude)
    }

    // این تابع در صورتی که گرفتن موقعیت مکانی کاربر با مشکل مواجه شود، فراخوانی می‌شود
    function positionError(error) {
        error_alert(error.message)
    }

    // تنظیمات برای watchPosition
    var options = {
        enableHighAccuracy: true, // استفاده از GPS در صورت موجود بودن
        timeout: 5000, // زمان انتظار برای گرفتن موقعیت مکانی
        maximumAge: 0 // موقعیت مکانی کش شده را استفاده نکن
    };

    // فراخوانی watchPosition برای ردیابی تغییرات موقعیت مکانی کاربر
    var watchID = navigator.geolocation.watchPosition(positionChanged, positionError, options);



    async function send_data(){
        var has_car=$('#has_car').prop('checked')
        var dic=$('#dic').val()

        var addres=await getAddres(base_lat,base_lon);


        if (dic==''){
            error_alert('توضیحات خالی میباشد!')
        }else {
            ajax_sender("{{route('sub_traffic')}}",{
                'has_car' : has_car,
                'dic' : dic,
                'lat' : base_lat,
                'lon' : base_lon,
                'address' : addres,
                'code' : code,
                'type' : type,
            },'post',function (e) {
                prev_step(type);
                code=e.result.code;
                type=e.result.type;
               if(e.result.type=='magh'){
                  magh_marker.setLatLng([base_lat,base_lon])
                  magh_marker.addTo(map)
               }else {
                   mab_marker.setLatLng([base_lat,base_lon])
                   mab_marker.addTo(map)
               }

               success_alert('مشخصات با موفقیت ثبت شد!')
            })
        }
    }



    async function  getAddres(lat,len){
        var ad='';
        $.ajax({
            url : "https://api.neshan.org/v5/reverse?&lat="+lat+"&lng="+len+"",
            type : 'get',
            async: false,
            headers : {
                'Api-Key' : 'service.393611b6541247348119027bd24254d3',
            },
            dataType : 'json',
            success : function (a){
             ad= a.formatted_address;
            },
            error : function (a){
                console.log(a)
            }
        })
        return ad;
    }

    function sub_playload(lat,lon){
        ajax_sender("{{route('sub_playload')}}",{
            'code' : code,
            'lat' : lat,
            'lon' : lon,
            'user' : "{{$user['username']}}"
        },'get',function (e){

        })
    }


    @foreach($basic_info['list_traffic_to_day'] as $key=>$item)
        @foreach($item as $traffic)
        @php
        $text=$traffic['type']=='mab' ? 'مبدا' : 'مقصد';
        $icon="icon_".$traffic['type'];
        @endphp
            L.marker([{{$traffic['lat']}},{{$traffic['lon']}}],{icon : {{$icon}}}).bindPopup("{{$text}}").addTo(map)
        @endforeach

    @endforeach

</script>
 @endsection
