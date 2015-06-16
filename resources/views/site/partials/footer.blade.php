<footer class="footer-custom">
    <p>&copy; Powered by: <a href="http://yondu.com">YONDU</a>. All Rights Reserved 2015.</p>
</footer>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.3.min.js"><\/script>')</script>
{!! HTML::script('public/site/js/main.js') !!}
<script>

    transformicons.add('.tcon');
    var locations = [
        ['7th Floor, Panorama Tower', 14.555983, 121.049686, 1]
    ];

    var map = new google.maps.Map(document.getElementById('googleMap'), {
        zoom: 15,
        scrollwheel: false,
        center: new google.maps.LatLng(14.555983, 121.049686),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map
        });

        google.maps.event.addListener(marker, 'click', (function (marker, i) {
            return function () {
                infowindow.setContent(locations[i][0]);
                infowindow.open(map, marker);
            }
        })(marker, i));
    }

</script>