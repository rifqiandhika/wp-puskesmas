<div id="map-canvas" style="width: 90%; margin: auto; height: 400px;"></div>

<script type="text/javascript">
    function cari_alamat() {
        var alamat = jQuery('#cari-alamat-input').val();
        geocoder = new google.maps.Geocoder();
        geocoder.geocode( { 'address': alamat}, function(results, status) {
            if (status == 'OK') {
                console.log('results', results);
                map.setCenter(results[0].geometry.location);
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }

    jQuery(document).ready(function(){
        var search = ''
            +'<div class="input-group" style="margin-bottom: 5px; display: block;">'
                +'<div class="input-group-prepend">'
                    +'<input class="form-control" id="cari-alamat-input" type="text" placeholder="Kotak pencarian alamat">'
                    +'<button class="btn btn-success" id="cari-alamat" type="button"><i class="dashicons dashicons-search"></i></button>'
                +'</div>'
            +'</div>';
        jQuery("#map-canvas").before(search);
        jQuery("#cari-alamat").on('click', function(){
            cari_alamat();
        });
        jQuery("#cari-alamat-input").on('keyup', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                cari_alamat();
            }
        });
    });

    function initMap() {
        // Lokasi Center Map
        var lokasi_aset = new google.maps.LatLng(-7.655205,111.3275165);
        // Setting Map
        var mapOptions = {
            zoom: 15,
            center: lokasi_aset,
            mapTypeId: google.maps.MapTypeId.HYBRID
        };
        // Membuat Map
        window.map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
        addMarker(lokasi_aset);
        addMarker({lat: -7.657010,lng: 111.325493});
        addMarker({lat: -7.657655,lng: 111.329797});
        addPolyline(lokasi_aset);
        addPolygon(lokasi_aset);
    }
    function addMarker(lokasi) {
        new google.maps.Marker({
            position:lokasi,
            map,
            title: "Hello World",
            icon: '<?php echo get_option('_crb_fotosatu_puskesmas');?>',
        });
    }
    function addPolyline(lokasi) {
        const flightPlanCoordinates = [
            { lat: -7.655205, lng: 111.3275165 },
            { lat: -7.630955,  lng: 111.529689 },
        ];

        const flightPath = new google.maps.Polyline({
            path: flightPlanCoordinates,
            geodesic: true,
            strokeColor: "#FF0000",
            strokeOpacity: 1.0,
            strokeWeight: 2,
        });

  flightPath.setMap(map);
    }
    function addPolygon(lokasi){
        const triangleCoords = [
            { lat: -7.7359841, lng: 111.4010564 },
            { lat: -7.7361017, lng: 111.3992391 },
            { lat: -7.7376992, lng: 111.4014665 },
            { lat: -7.7359841, lng: 111.4010564 },
        ];
        // Construct the polygon.
        const bermudaTriangle = new google.maps.Polygon({
            paths: triangleCoords,
            strokeColor: "#FF0000",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#FF0000",
            fillOpacity: 0.35,
        });

        bermudaTriangle.setMap(map);
    }   
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeleTgwtzo4PCX7AOtpb3oQlRoPZiZkl0&callback=initMap&libraries=places&libraries=drawing"></script>