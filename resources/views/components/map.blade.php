<style>
    #map {
        height: 100%!important;
        width: 100%;
    }
    #bd_sub_loc{
        position: absolute;
        bottom: 0;
        left: 0;
        max-height: 250px;
        overflow-y: auto;
        z-index: 999999999;
    }
    #options{
        position: absolute;
        left: 10px;
        top: 80px;
        z-index: 999999999;
        font-size: 15pt;
        width: 32px;
    }

    #my_marker,#tower_tci,#users_namem{
        cursor: pointer;
        border: 1px solid #ccc;
        box-shadow: 0 0 5px 1px #ccc;
    }
</style>

<div class="h-100 col-12 position-relative">
    <div  id="map"></div>

    <div id="bd_sub_loc" class="w-100">
        <div class="p-2 ps-3 pe-3 bg-light" style="color: #525252;border-radius: 25px 25px 0 0;border: 1px solid #ccc">
            @yield('footer_action')
        </div>
    </div>

    <span id="options">
        <i onclick="my_location()" id="my_marker" class="fa fa-location bg-light p-1 rounded-2"></i>
        @yield('options')
    </span>
</div>

<script>
    var base_lat={{request('lat')}};
    var base_lon={{request('lon')}};
    var user_marker= L.marker([base_lat,base_lon]);


    $('#map').css('height',window.screen.height-55)
    const map = new L.Map("map", {
        key: "web.fda9829e28434dd0a5ecb5ad60026ef3",
        maptype: "neshan",
        poi: false,
        traffic: false,
        center: [base_lat,base_lon],
        zoom: 14,
    });
    var polylineGroup = L.layerGroup().addTo(map);

    var geo=null;
    function my_location(){

        if(geo==null){
            request_to_access_geo(function (e) {
                geo=e;
                basic_seter_marker(e.coords.latitude,e.coords.longitude)
                setView(e.coords.latitude,e.coords.longitude);

            });


        }else {

            basic_seter_marker(geo.coords.latitude,geo.coords.longitude)
            setView(geo.coords.latitude,geo.coords.longitude);

        }


    }

    var customer=null
    function basic_seter_marker(lat,lon){
        base_lat=lat;
        base_lon=lon;
        user_marker.setLatLng([lat,lon]).addTo(map)


        var latlng_user=user_marker.getLatLng();

        if (customer!=null){
            var latlng_customer=customer.getLatLng();
            var dic= calculateDistance(latlng_customer.lat,latlng_customer.lng,latlng_user.lat,latlng_user.lng);
            drawLine(latlng_customer.lat,latlng_customer.lng,latlng_user.lat,latlng_user.lng);
        }
        $('#distance').html(dic)
    }

    function setView(lat,lon){
        map.setView([lat,lon]);
    }

    // تابع ترسیم خط بین دو نقطه
    function drawLine(lat1, lon1, lat2, lon2) {
        var pointA = L.latLng(lat1, lon1);
        var pointB = L.latLng(lat2, lon2);

        var polyline = L.polyline([pointA, pointB], {color: 'blue'}).addTo(map);
        polyline.addTo(polylineGroup);
    }


    /* حذف مارکر*/
    function removeMarker(marker) {
        map.removeLayer(marker);
    }

    /* محاسبه فاصله 2 نقطه */
    function calculateDistance(lat1, lon1, lat2, lon2,just_num=false) {
        var pointA = L.latLng(lat1, lon1);
        var pointB = L.latLng(lat2, lon2);
        var distance = pointA.distanceTo(pointB);

        if (just_num){
            return distance;
        }

        if (distance > 1000) {
            return (distance / 1000).toFixed(2) + ' کیلومتر';
        } else {
            return distance.toFixed(2) + ' متر';
        }
    }

</script>

@yield('script_map')
