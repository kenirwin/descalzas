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
			      
			      <? LoadControls(); ?>
  <body>
    <div id="controls">
      <ul>
      </ul>
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
      
      map.data.loadGeoJson('roles2convents.php');

      var colors = ['#FFCC00', '#FFFF00', '#CCFF00', '#99FF00', '#33FF00', '#00FF66', '#00FF99', '#00FFCC', '#FF0000', '#FF3300', '#FF6600', '#FF9900'];

      /*
      $('#controls li').each(function(i) {
	  console.log($(this).text() + ' ' +colors[i]);
	  $(this).css('background-color',colors[i]);
	});
      */

      map.data.setStyle(function(feat) {
	  var id = feat.getProperty('woman_id');
	  return ({
	    label: feat.getProperty('nth-city'),
	    icon: { 
	      	  path: google.maps.SymbolPath.CIRCLE,
	      fillColor: colors[id],
	      fillOpacity: 0.8,
	      strokeWeight: 0.5,
	      strokeColor: '#000',
		scale: 10,
		visible: true,
		  }
		});
	}); // end setStyle

      google.maps.event.addDomListener($('#controls li input').click(function () {
	    var whoWasClicked = $(this).attr('id');
	    console.log(whoWasClicked);
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
	  })); //end addDomListener
	

      map.data.addListener('click', function(event) {
	  var title = event.feature.getProperty('title');
	  title = title.charAt(0).toUpperCase() + title.substr(1);
	  /*
	  var stop = event.feature.getProperty('nth-city');
	  */

          var myHTML = "<h1>"+title+"</h1>";
	  infowindow.setContent("<div style='width:150px; text-align: center;'>"+myHTML+"</div>");
          infowindow.setPosition(event.feature.getGeometry().get());
	  infowindow.setOptions({pixelOffset: new google.maps.Size(0,-30)});
          infowindow.open(map);
	  map.data.overrideStyle(event.feature,{'zIndex':nextZ});
	  nextZ++;
	});    

      } //end initMap
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCntYifbqyiilv85_sjj4OgwhgsAGecEGA&callback=initMap"
    async defer></script>
  </body>
</html>

<?
	function LoadControls() {
	$url = "http://www.wittprojects.net/dev/agb/women.json";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$women_json = curl_exec($ch);
	curl_close($ch);
	$women = json_decode($women_json);
	$colors = ['#FFCC00', '#FFFF00', '#CCFF00', '#99FF00', '#33FF00', '#00FF66', '#00FF99', '#00FFCC', '#FF0000', '#FF3300', '#FF6600', '#FF9900'];
	$i = 0;
	$controls = '';
	foreach ($women as $arr) {
	  foreach ($arr as $w) {
	  $controls .= '<li style="background-color:'.$colors[$i].'"><input type="checkbox" id="'.$w->id.'" value="" checked> <label for="'.$w->id.'">'.$w->name.'</label> <img class="icon" /></li>';
	  $i++;
	  }
	}
	print '<ul id="controls">'.$controls.'</ul>';
      }