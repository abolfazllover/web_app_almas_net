
@extends('components.map')
@section('footer_action')
    <div class="row m-auto">
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
    var code;

    function get_code_sub_traffic(){
        ajax_sender('{{route('get_code_sub_traffic')}}',{},"post",function (e){
            code=e.result;
            console.log(code)
        })
    }
    get_code_sub_traffic();

    var greenIcon = new L.Icon({
        iconUrl: 'https://img.icons8.com/color/48/marker--v1.png',
        iconSize: [30, 30],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
    });

    var redIcon = new L.Icon({
        iconUrl: 'https://img.icons8.com/ios-filled/50/228BE6/marker.png',
        iconSize: [30, 30],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
    });



    let mab_marker= L.marker([base_lat,base_lon], { icon: redIcon, title: "مبدا" });
    let magh_marker= L.marker([base_lat,base_lon], { icon: greenIcon, title: "مقصد" });


    $(window).ready(function () {
        my_location();
    })


    // این تابع هر زمان که موقعیت مکانی کاربر تغییر کند، فراخوانی می‌شود
    function positionChanged(position) {
        // گرفتن طول و عرض جغرافیایی از موقعیت مکانی کاربر
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;

        sub_playload(latitude,longitude)

        base_lat=latitude;
        base_lon=longitude;

        // نمایش طول و عرض جغرافیایی در کنسول (یا هر عملیات دیگری که می‌خواهید انجام دهید)
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
            },'post',function (e) {
               if(e.result.type=='magh'){
                  code=random_code();
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

    function random_code(){
        return "app"+Math.floor(Math.random() * 12);
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


</script>
 @endsection
