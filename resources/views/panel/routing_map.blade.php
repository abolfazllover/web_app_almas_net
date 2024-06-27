@extends('components.map')

@section("script_map")
    <script>

        var user_icon = L.icon({
            iconUrl: '{{route('home')}}/img/user_location_icon.png',
            iconSize: [40, 40], // اندازه آیکون
        });


        var customer=L.marker([base_lat,base_lon],{icon : user_icon}).addTo(map)

        active_back_icon();
        if (geo==null){
            request_to_access_geo(function (e){
              geo=e;
              var lat=geo.coords.latitude;
              var lon=geo.coords.longitude;

              var address="https://api.neshan.org/v4/direction?type=car&origin="+base_lat+","+base_lon+"&destination="+lat+','+lon;
                console.log(address)
                neshan_api(address,function (data){
                    draw_rout_to_map(map,data)
                    L.marker([lat,lon]).addTo(map)
                })
            })
        }else {
            var lat=geo.coords.latitude;
            var lon=geo.coords.longitude;

            var address="https://api.neshan.org/v4/direction?type=car&origin="+base_lat+","+base_lon+"&destination="+lat+','+lon;
            console.log(address)
            neshan_api(address,function (data){
                draw_rout_to_map(map,data)
                L.marker([lat,lon]).addTo(map)
            })
        }




    </script>
@endsection
