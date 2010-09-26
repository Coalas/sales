<?php
function array2json(array $arr)
{
//if(function_exists('json_encode')) return json_encode($arr); //Lastest versions of PHP already has this functionality.
$parts = array();
$is_list = false;

if (count($arr)>0){
//Find out if the given array is a numerical array
$keys = array_keys($arr);
$max_length = count($arr)-1;
if(($keys[0] === 0) and ($keys[$max_length] === $max_length)) {//See if the first key is 0 and last key is length - 1
$is_list = true;
for($i=0; $i<count($keys); $i++) { //See if each key correspondes to its position
if($i !== $keys[$i]) { //A key fails at position check.
$is_list = false; //It is an associative array.
break;
}
}
}

foreach($arr as $key=>$value) {
$str = ( !$is_list ? '"' . $key . '":' : '' );
if(is_array($value)) { //Custom handling for arrays
$parts[] = $str . array2json($value);
} else {
//Custom handling for multiple data types
if (is_numeric($value) && !is_string($value)){
$str .= $value; //Numbers
} elseif(is_bool($value)) {
$str .= ( $value ? 'true' : 'false' );
} elseif( $value === null ) {
$str .= 'null';
} else {
//$str .= '"' . addslashes($value) . '"'; //All other things
  echo $value."\n";
$str .= '"'. $value . '"'; //All other things
}
$parts[] = $str;
}
}
}
$json = implode(',',$parts);

if($is_list) return '[' . $json . ']';//Return numerical JSON
return '{' . $json . '}';//Return associative JSON
}
?>
