<?php session_start();?>
<?
   if(!$userid)
   {
?> 
<div id="mainCarousel">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="item active">
                    <script
                        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCaRo34-BOraihXV-df2Mt3jJTShLHO9gM">
                    </script>
                    <script>
                        var myCenter = new google.maps.LatLng(32.882946, -117.2340906);
                        var marker;

                        var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        var labelIndex = 0;
                        var address = 'Los Angeles';
                        var geocoder = new google.maps.Geocoder();
                        var map;

                        function initialize() {
                            var mapProp = {
                                center: myCenter,
                                zoom: 18,
                                mapTypeId: google.maps.MapTypeId.ROADMAP    //지도 종류 정하기 Terratin, satiliate
                            };


                            map = new google.maps.Map(document.getElementById("googleMap"), mapProp);

                            marker = new google.maps.Marker({
                                position: myCenter,
                                //icon:'themes/assets/images/nepali-momo.png',
                                label: labels[labelIndex++ % labels.length],
                                animation: google.maps.Animation.BOUNCE,
                                title: 'Air pollution station 1'
                                //map:map
                            });

                            marker.setMap(map);

                            marker.addListener('click', function () {
                                map.setZoom(18);
                                map.setCenter(marker.getPosition());
                            });

                            // Info open
                            var infowindow = new google.maps.InfoWindow({
                                content: "Hello World!"
                            });

                            google.maps.event.addListener(marker, 'click', function () {
                                infowindow.open(map, marker);
                            });

                        }
                        function codeAddress(zipCode) {
                            geocoder.geocode({ 'address': zipCode }, function (results, status) {
                                if (status == google.maps.GeocoderStatus.OK) {
                                    //Got result, center the map and put it out there
                                    myCenter = results[0].geometry.location;
                                    map.setCenter(myCenter);
                                    var marker = new google.maps.Marker({
                                        map: map,
                                        position: results[0].geometry.location
                                    });
                                } else {
                                    alert("Geocode was not successful for the following reason: " + status);
                                }
                            });
                        }

                        //initialize 호출
                        google.maps.event.addDomListener(window, 'load', initialize);
                        codeAddress(address);
                    </script>
                    <div id="googleMap" style="height: 450px;"></div>
                    <!--<div class="container">
                        <!--지도위에버튼
                        <div class="carousel-caption">
                            <a class="btn btn-lg btn-default" href="#" role="button" style="font-size: 2em">Order Online Now &raquo;</a>
                        </div>
                    </div>-->
                </div>
            </div>
        </div>
    </div>