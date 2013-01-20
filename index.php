<?php
/*
Plugin Name: Client Document Monitoring
Plugin URI: http://hiteshjoshi.com/wordpress/client_document_monitoring.html
Description: <p>This plugin helps in managing document and users more easily and effectively.Features :- <br>*You can create users more faster than wordpress default user system.<br> *You can upload documents and can assign to different users.<br> *Users can login and download/view their document.<br> *Everything AJAX based.
</p>
Version: 4.0
Author: Hitesh Joshi
Author URI: http://hiteshjoshi.com
License: GPL2
*/
?>
<?php

add_action( 'send_headers', 'site_router');

function site_router() {
global $route,$wp_query,$window_title;
$bits =explode("/",$_SERVER['REQUEST_URI']);
var_dump(is_404());
$route->class = $bits[1];
$route->method = $bits[2];
$route->prop1 = $bits[3];
$route->prop2 = $bits[4];
$route->prop3 = $bits[5];
$route->prop4 = $bits[6];
$wp_query->is_404 = false;
if ( $wp_query->is_404 ) {
    echo "<script>alert('d');</script>";
$wp_query->is_404 = false;

//include(get_template_directory() . path_to_classes . $route->class . ".php" ); // replace path_to_classes with the actual directory where you keep your class files
///* at the end of your classfile include, you can create the object as $myObject = new Class */
//$myObject->$route->method($route->prop1); // after calling the method, you can set a property in the object for the template
//$template = locate_template($myObject->template);
//$window_title = $myObject->window_title;
//if ($template) {
//load_template($template);
//die;
//}
print_r($bits);
}
}

include 'init.php';


$cdm = new cdm();
register_activation_hook( __FILE__, array( &$cdm, 'install' ));
register_deactivation_hook(__FILE__,array(&$cdm,'uninstall'));