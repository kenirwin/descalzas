<?
class JsonToGeoJson {
  public function __construct($json, $subfield='') {
    $this->data = json_decode($json);
    $this->output = new stdClass();
    $this->output->type = 'FeatureCollection';
    $this->output->features = array();
    if (isset($subfield)) { 
      $this->subfield = $subfield; 
      $this->collection = $this->data->$subfield; 
    }
    else { $this->collection = $this->data; } 
  }
  public function transform() {
    foreach ($this->collection as $point) {
      $returned = $this->transformPoint($point);
      if ($returned != null) {
	array_push($this->output->features, $returned);
      }
    }
    $this->geojson = json_encode($this->output);
  }

  private function transformPoint($point) {
    if (isset($point->latitude)  &! empty($point->latitude) && isset ($point->longitude) &! empty($point->longitude)) {
      $geometry = array('type' => 'Point',
			'coordinates' => [floatval($point->longitude),floatval($point->latitude)]
			);
      $feature = array();
      foreach ($point as $key=>$value) {
	$feature['properties'][$key]= $value;
      }
      $feature['type'] = 'Feature';
      $feature['geometry'] = $geometry;
      return $feature;
    }
    
  }
}