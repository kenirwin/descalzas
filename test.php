<?
require('GeoJsonCollect.class.php');
$coll = new GeoJsonCollect();
$barcelona = array("name"=>"Barcelona",
		   "lat"=>41.3851,
		   "long"=>2.17434,
		   );
$madrid = array ("name" => "Madrid",
		 "lat"=>40.415363,
		 "long"=>-3.707398);

$b = $coll->createPoint($barcelona);
$coll->addFeature($b);
$m = $coll->createPoint($madrid);
$coll->addFeature($m);
print($coll->getJson());

?>