<?php
function array_to_object($array) {
  $obj = new stdClass;
  foreach($array as $k => $v) {
     if(is_array($v)) {
        $obj->{$k} = array_to_object($v); //RECURSION
     } else {
        $obj->{$k} = $v;
     }
  }
  return $obj;
}

/**
 * Returns the translated role of the current user. If that user has
 * no role for the current blog, it returns false.
 *
 * @return string The name of the current role
 **/
function get_current_user_role() {
	global $wp_roles;
	$current_user = wp_get_current_user();
	$roles = $current_user->roles;
	$role = array_shift($roles);
	return isset($wp_roles->role_names[$role]) ? translate_user_role($wp_roles->role_names[$role] ) : false;
}

function keygen($length=10)
{
	$key = '';
	list($usec, $sec) = explode(' ', microtime());
	mt_srand((float) $sec + ((float) $usec * 100000));

   	$inputs = array_merge(range('z','a'),range(0,9),range('A','Z'));

   	for($i=0; $i<$length; $i++)
	{
   	    $key .= $inputs{mt_rand(0,61)};
	}
	return $key;
}