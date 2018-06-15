<?
header('Access-Control-Allow-Origin: *');
require('GeoJsonCollect.class.php');
$coll = new GeoJsonCollect();
$barcelona = array("name"=>"Barcelona",
		   "lat"=>41.3851,
		   "long"=>2.17434,
		   );
$madrid = array ("name" => "Madrid",
		 "lat"=>40.415363,
		 "long"=>-3.707398);
$toledo = array ("name" => "Toledo",
		 "lat"=>39.8628,
		 "long"=>-4.0273,);
$valladolid = array ("name" => "Valladolid",
		     "lat" => 41.6523,
		     "long" => -4.7123);
$caceres = array ("name" => "Caceres",
		     "lat" => 39.4753,
		     "long" => -6.3724);
$cordoba  = array ("name" => "Cordoba",
		     "lat" => 37.8882,
		     "long" => -4.7794);
$zaragoza  = array ("name" => "Zaragoza",
		     "lat" => 41.6488,
		     "long" => -0.8891);
$people=array(
	      'alej' => array('madrid','barcelona'),
	      'betsy' => array('cordoba','valladolid','caceres','madrid'),
	      'kate' => array('madrid','zaragoza'),
	      'ken'=> array('toledo','madrid'),
	      'pat' => array('cordoba','toledo','madrid'),
	      'esther' => array('cordoba','valladolid','madrid'),
	      'andy' => array('toledo','barcelona','valladolid','madrid'),
	      'bill' => array('madrid','cordoba','toledo'),
	      'maureen' => array('madrid', 'zaragoza', 'caceres'),
	      );

$p = $_REQUEST['person'];
$traveler_id = array_search($_REQUEST['person'],array_keys($people));
foreach ($people[$p] as $city) {
  $mycity = $$city;
  $mycity['traveler'] = $traveler_id;
  $offset = getOffset($traveler_id);
  $temp = $coll->createPoint($mycity,$offset['lat'],$offset['long']);
  $coll->addFeature($temp);
}
print($coll->getJson());

function getOffset ($id) {
  $mult = 0.007;
  print $id;
  if ($id == 0) { return['lat'=>0,'long'=>0]; }
  elseif ($id%4 == 0) { return ['lat'=> $id*$mult, 'long'=>$id*$mult]; }
  elseif ($id%3 == 0) { return ['lat'=> $id*$mult, 'long'=>$id*$mult*(-1)]; }
  elseif ($id%2 == 0) { return ['lat'=> $id*$mult*(-1), 'long'=>$id*$mult*(-1)]; }
  else { return ['lat'=> $id*$mult*(-1), 'long'=>$id*$mult]; }
}
?>