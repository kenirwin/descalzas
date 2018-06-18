
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
li { display: inline-block; background-color: #666;color:#eee; margin-left: 10px; padding: 5px; font-family: Arial, Helvetica, sans-serif; }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  </head>
  <body>
    <div id="selection">
      <ul>
      <li><input type="checkbox" id="alej" value="alej" checked> <label for="alej">Alejandra</label></li>
      <li><input type="checkbox" id="andy" value="andy" checked> <label for="andy">Andy</label></li>
      <li><input type="checkbox" id="betsy" value="betsy" checked> <label for="betsy">Betsy</label></li>
      <li><input type="checkbox" id="bill" value="bill" checked> <label for="bill">Bill</label></li>
<li><input type="checkbox" id="esther" value="esther" checked> <label for="esther">Esther</label></li>     
      <li><input type="checkbox" id="kate" value="kate" checked> <label for="kate">Kate</label></li>
      <li><input type="checkbox" id="ken" value="ken" checked> <label for="ken">Ken</label></li>
      <li><input type="checkbox" id="maureen" value="maureen" checked> <label for="maureen">Maureen</label></li>
      <li><input type="checkbox" id="pat" value="pat" checked> <label for="pat">Patrick</label></li>
      </ul>
    </div>
    <div id="map"></div>
    <script>
      var map;
      function initMap() {
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
      
      $('input').change(function() {
          UpdatePins(map);
        });//end input.change()
      
      UpdatePins(map);

      function UpdatePins(map) {
        var colors = ['red','orange','yellow','green','blue','purple','pink','lightblue','red-dot','orange-dot','yellow-dot','green-dot','blue-dot','purple-dot','pink-dot','ltblue-dot'];

        map.data.forEach(function(feature) {
            map.data.remove(feature);
          });
        var features = [];
        
        $('input:checked').each(function() {
            $.getJSON('http://www.wittprojects.net/dev/descalzas/geojson.php?person='+this.value, function (data) { features = map.data.addGeoJson(data) 
          });
            map.data.setStyle(feature=> {
        const person = feature.getProperty('traveler');
        return {
        icon: 'http://maps.google.com/mapfiles/ms/icons/'+colors[person]+'.png'
            }
      });
            
          });//end each checked input
      } //end UpdatePins
      } //end initMap
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCntYifbqyiilv85_sjj4OgwhgsAGecEGA&callback=initMap"
    async defer></script>
  </body>
</html>
