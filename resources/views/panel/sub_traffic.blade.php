
<div class="col-12 position-relative">
    <div style="min-height: 100%" id="map"></div>
</div>

<script>
    $('#map').css('height',window.screen.height-55)
    const testLMap = new L.Map("map", {
        key: "web.fda9829e28434dd0a5ecb5ad60026ef3",
        maptype: "neshan",
        poi: false,
        traffic: false,
        center: [35.699756, 51.338076],
        zoom: 14,
    })

</script>
