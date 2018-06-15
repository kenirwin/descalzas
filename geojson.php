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
$toledo = array ("name" => "Toledo",
		 "lat"=>39.8628,
		 "long"=>-4.0273,);
$people=array(
	      'ken'=> array('toledo','madrid'),
	      'alej' => array('madrid','barcelona')
	      );

$p = $_REQUEST['person'];
foreach ($people[$p] as $city) {
  $mycity = $$city;
  $mycity['traveler'] = $p;
  $temp = $coll->createPoint($mycity);
  $coll->addFeature($temp);
}
print($coll->getJson());

?>