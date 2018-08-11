<!DOCTYPE html>
<html>
  <head>
    <title>Spain Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
li { display: inline-block; background-color: #666;color:#000; margin-left: 10px; padding: 5px; font-family: Arial, Helvetica, sans-serif; }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  </head>
  <body>
			     <h1>Convent Map</h1>
	<div id="controls">		      
    </div>

    <div id="map"></div>
    <script>
										  var map;


      function initMap() {
	var infowindow = new google.maps.InfoWindow();
	var nextZ = 100;
	var options = {
      center: {lat: 40.4168, lng: -3.7083},
      zoom: 7,
      mapTypeId: 'terrain',
      styles:[{
            "featureType": "road",
            "stylers": [{ "visibility" : "off" }]
          }]
      }
      map = new google.maps.Map(document.getElementById('map'), options);
      
      map.data.loadGeoJson('convent_geojson.php');

      } //end initMap
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCntYifbqyiilv85_sjj4OgwhgsAGecEGA&callback=initMap"
    async defer></script>
  </body>
</html>
