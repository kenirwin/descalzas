<?php
class GeoJsonCollect {
  public function __construct() {
    $this->collection = array(
			      'type'      => 'FeatureCollection',
			      'features'  => array()
			      );
  }//end construct
  
  public function getJson () {
    return (json_encode($this->collection));
  }
  
  public function createPoint($params) { //returns an array
    //expects minimum params: lat, long
    //other params: name, description, country
    if (array_key_exists('lat',$params) && array_key_exists('long',$params)) {
      $geometry = array('type'=>'Point',
				'coordinates'=> [$params['long'],$params['lat']]
				);
      $feature = array();
      foreach ($params as $key => $value) {
	if (! in_array($key, ['lat','long'])) {
	  $feature['properties'][$key]=$value;
	}
      }
      $feature['type'] = 'Feature';
      $feature['geometry'] = $geometry;
      return $feature;
    } //end if params includes coordinates
    else {
      throw new Exception ('createPoint method requires $params to include "lat" and "long"');
    } //end else
  } //end createPoint
  
  public function addFeature($feature) {
    array_push($this->collection['features'],$feature);
  }
} //end GeoJsonCollect
?>