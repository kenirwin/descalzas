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
	      'betsy' => array('cordoba','valladolid','caceres'),
	      'kate' => array('madrid','zaragoza'),
	      'ken'=> array('toledo','madrid'),
	      'pat' => array('cordoba','toledo'),
	      );

$p = $_REQUEST['person'];
$traveler_id = array_search($_REQUEST['person'],array_keys($people));
foreach ($people[$p] as $city) {
  $mycity = $$city;
  $mycity['traveler'] = $traveler_id;
  $offset = $traveler_id *.001;
  $temp = $coll->createPoint($mycity,$offset);
  $coll->addFeature($temp);
}
print($coll->getJson());

?>