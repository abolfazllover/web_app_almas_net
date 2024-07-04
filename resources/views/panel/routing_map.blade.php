@extends('panel.sub_traffic')


 @section('after_geo_accept')
     var address="https://api.neshan.org/v4/direction?type=car&origin="+base_lat+","+base_lon+"&destination={{request('lat_emk')}},{{request('lon_emk')}}";
     neshan_api(address,function (data) {
     draw_rout_to_map(map,data)
     })
 @endsection

{{--<script>--}}
{{--    var address="https://api.neshan.org/v4/direction?type=car&origin="+base_lat+","+base_lon+"&destination={{request('lat_emk')}},{{request('lon_emk')}}";--}}
{{--    neshan_api(address,function (data) {--}}
{{--        draw_rout_to_map(map,data)--}}
{{--    })--}}
{{--</script>--}}
