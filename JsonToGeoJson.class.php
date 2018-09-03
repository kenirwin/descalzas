<?
class JsonToGeoJson {
  public function __construct($input, $input_type='json', $subfield=null) {
    if ($input_type=='json') {
      $this->data = json_decode($input);
    }
    elseif ($input_type=='object') {
      $this->data = $input;
    }
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
	if ($value != '') {
	  if(!in_array($key, ['created','modified'])) {
	    $feature['properties'][$key]= $value;
	  }
	}
      }
      $feature['type'] = 'Feature';
      $feature['geometry'] = $geometry;
      return $feature;
    }
    
  }
}