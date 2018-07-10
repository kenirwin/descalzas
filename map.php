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
    <div id="controls">
      <ul>
      <li><input type="checkbox" id="alej" value="alej" checked> <label for="alej">Alejandra</label><img class="icon" /></li>
      <li><input type="checkbox" id="andy" value="andy" checked> <label for="andy">Andy</label><img class="icon" /></li>
      <li><input type="checkbox" id="betsy" value="betsy" checked> <label for="betsy">Betsy</label><img class="icon" /></li>
      <li><input type="checkbox" id="bill" value="bill" checked> <label for="bill">Bill</label><img class="icon" /></li>
<li><input type="checkbox" id="esther" value="esther" checked> <label for="esther">Esther</label><img class="icon" /></li>     
      <li><input type="checkbox" id="kate" value="kate" checked> <label for="kate">Kate</label><img class="icon" /></li>
      <li><input type="checkbox" id="ken" value="ken" checked> <label for="ken">Ken</label><img class="icon" /></li>
      <li><input type="checkbox" id="maureen" value="maureen" checked> <label for="maureen">Maureen</label><img class="icon" /></li>
      <li><input type="checkbox" id="pat" value="pat" checked> <label for="pat">Patrick</label><img class="icon" /></li>
      </ul>
    </div>
    <div id="map"></div>
    <script>
      var map;
      function initMap() {
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
      
      map.data.loadGeoJson('geojson.php');

      var colors = ['#FFCC00', '#FFFF00', '#CCFF00', '#99FF00', '#33FF00', '#00FF66', '#00FF99', '#00FFCC', '#FF0000', '#FF3300', '#FF6600', '#FF9900'];


      $('#controls li').each(function(i) {
	  console.log($(this).text() + ' ' +colors[i]);
	  $(this).css('background-color',colors[i]);
	});

      map.data.setStyle(function(feat) {
	  var id = feat.getProperty('travelerId');
	  return ({
	    label: feat.getProperty('nth-city'),
	    icon: { 
	      	  path: google.maps.SymbolPath.CIRCLE,
	      fillColor: colors[id],
	      fillOpacity: 0.8,
	      strokeWeight: 0.5,
	      strokeColor: '#fff',
		scale: 10,
		visible: true,
		  }
		});
	});

      google.maps.event.addDomListener($('#controls li input').click(function () {
	    var whoWasClicked = $(this).attr('id');
	    //console.log(whoWasClicked);
	  var vis = [];
	  $('#controls ul li input:checkbox').each(function(i) {
	      var p = $(this).attr('id');
	      vis[p] = this.checked;
	    });
	  //console.log(vis);
	  map.data.forEach(function(feat) {
	      //	      overrideStyle(function(feat, 'visible') {
	      var p = feat.getProperty('travelerName');
	      map.data.overrideStyle(feat,{'visible':vis[p]});
	      if (p == whoWasClicked && vis[p] === true) 
		{ 
		  map.data.overrideStyle(feat,{'zIndex':nextZ});
		  nextZ++;
		}
	    });
	  }));
	
      } //end initMap
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCntYifbqyiilv85_sjj4OgwhgsAGecEGA&callback=initMap"
    async defer></script>
  </body>
</html>
