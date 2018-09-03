<?
header("Content-type: text/plain");

require ("GeoJsonCollect.class.php");
$coll = new GeoJsonCollect();

$roles_obj = GetRoles();

$women = array();
$known_women = array();
$convents = array();
$known_convents = array();
$roles = array();

foreach ($roles_obj as $arr) {
  foreach ($arr as $role) {
    
    if ($role->woman_id != '') {
      $id = $role->woman_id;
      $women[$id] = $role->woman;
    }
    if ($role->convent_id != '') { 
      $role->convent->lat = $role->convent->latitude; 
      $role->convent->long = $role->convent->longitude; 
      $convents[$role->convent_id] =  $role->convent;
    }
    array_push($roles, RoleData($role));
  }
}

foreach ($roles as $role) {
  $woman = $women[$role->woman_id];
  $convent = $convents[$role->convent_id];
  $params = array();
  $params['long'] = $convents[$role->convent_id]->longitude;
  $params['lat']  = $convents[$role->convent_id]->latitude;
  $params['woman_name'] = $women[$role->woman_id]->name;
  $params['convent_name'] = $convents[$role->convent_id]->name;
  $params['role'] = $role->role;
  $params['title'] = $params['woman_name'] . ' at ' .$params['convent_name'];
  if (($params['role'])!='') { $params['title'] .= ' as '. $params['role']; }
  $offset = getOffset($role->woman_id);
  $temp = $coll->createPoint($params,$offset['lat'],$offset['long']);
  $coll->addFeature($temp);
}

print($coll->getJson());



function GetRoles() { 
$url = "http://www.wittprojects.net/dev/agb/roles.json";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HEADER, 0); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$json = curl_exec ($ch);
$roles_obj = json_decode($json);
return $roles_obj;
}

function RoleData($role) {
  $temp_role = new stdClass();
  $fields = ['id','woman_id','convent_id','start_year','end_year','role'];
  foreach ($fields as $f){ 
    $temp_role->$f = $role->$f;
  }
  return($temp_role);
}

function getOffset ($id) {
  $mult = 0.007;
  if ($id == 0) { return['lat'=>0,'long'=>0]; }
  elseif ($id%4 == 0) { return ['lat'=> $id*$mult, 'long'=>$id*$mult]; }
  elseif ($id%3 == 0) { return ['lat'=> $id*$mult, 'long'=>$id*$mult*(-1)]; }
  elseif ($id%2 == 0) { return ['lat'=> $id*$mult*(-1), 'long'=>$id*$mult*(-1)]; }
  else { return ['lat'=> $id*$mult*(-1), 'long'=>$id*$mult]; }
}
?>