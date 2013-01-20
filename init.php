<?php
include 'includes/functions.php';
define('CDMPATH', dirname(__FILE__));
define('CDMURL', plugins_url('/',__FILE__));

class cdm{

    protected $configuration;



    function __construct() {
        add_action('admin_menu', array($this,'addMenu')); //backend menu
	$this->configuration = $this->loadPluginConfi();
        wp_register_style( 'cdm_style',plugins_url('/assets/style.min.css', __FILE__),'all' );

        wp_register_script('cdm_library',plugins_url('/assets/library.js', __FILE__),array('jquery'));
        wp_register_script(
		'cdm_admin_library',
		plugins_url('/assets/admin_plugins.min.js', __FILE__),
                array('cdm_library')
	);
add_action( 'wp_ajax_handle_upload', array( &$this, 'handle_upload' ) );
add_action( 'wp_ajax_get_usernames', array( &$this, 'get_usernames' ) );
add_action( 'wp_ajax_assign_file', array( &$this, 'assign_file' ) );
    }


    /*
     * lets load the configuration user have set.
     */
    protected function loadPluginConfi($object=true){
        $plugin_configuration=array(
            'roles'=>get_option('cdm_roles'),
            'batch_access'=>get_option('cdm_batch_access'),
            'client_comment'=>get_option('cdm_client_comment'),
            'client_upload'=>get_option('cdm_client_upload'),
            'display_month'=>get_option('cdm_display_month'),
            'display_year'=>get_option('cdm_display_year'),
            'display_date'=>get_option('cdm_display_date'),
            'display_all'=>get_option('cdm_display_all'),
            'external_css'=>get_option('cdm_external_css'),
            'secure_files'=>get_option('cdm_secure_files'),
            'allowed_extension'=>get_option('cdm_allowed_extension'),
            'update_options'=>get_option('cdm_update_options'),
            'filesize'=>get_option('cdm_allowed_filesize'),
            'userrole'=>get_option('cdm_userroles')
        );
        if($object) return array_to_object($plugin_configuration); else return $plugin_configuration;
    }

    function addMenu(){

        if (current_user_can('level_10')) $this->configuration->roles = 'administrator';
	add_menu_page(__('Stats'), 'Client Login', $this->configuration->roles, 'cdm', array($this,'AdminStats'),'',3);
	add_submenu_page('cdm','Document Upload','Document Upload', $this->configuration->roles, 'cdm_document_upload', array($this,'DocumentUpload'));
        //add_submenu_page('cdm','Batch Upload','Batch Upload', $this->configuration->roles, 'cdm_batch_upload', 'rep_document');
        add_submenu_page('cdm','Manage Users','Users', $this->configuration->roles, 'cdm_manage_users', array($this,'ManageUsers'));
	add_submenu_page('cdm','Configurations','Configurations', $this->configuration->roles, 'cdm_configurations',array($this,'configPage'));
    }

    /*******************************************************************************************************************/
    /*******************************************************************************************************************/
    /*****************************Below are the pages in sequence to the menu*******************************************/
    /*******************************************************************************************************************/
    /*******************************************************************************************************************/

    /**
     *default Stats page for analytics of downloads and users
     */
    function AdminStats(){

         $page = $_GET['g'];
        $page = (int)((int)5*(int)$page);
        $next = (int)($page+(int)5);

        global $wpdb;
         $pending = $wpdb->get_results( $wpdb->prepare("SELECT `user_id`,`date_added`,`id`, `original_name` FROM `".$wpdb->prefix."cdm_files` where `assigned`=0 limit $page,$next") );
//SELECT `id`, `original_name` FROM `wp_cdm_files` WHERE `assigned`=0
         if($pending):
             $usernames = $this->get_usernames(true);
         wp_enqueue_script(
		'cdm_stats',
		plugins_url('/assets/stats.js', __FILE__),
		array('cdm_admin_library')
	);
         wp_enqueue_style( 'ui-lightness','http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/ui-lightness/jquery-ui.css',array('cdm_style') );
             include 'includes/pending_files.php';

         endif;

    }


    /**
     *page for document upload, allows single document uploading, allows batch upload
     */
    function DocumentUpload(){

        wp_enqueue_script(
		'cdm_upload',
		plugins_url('/assets/documentupload.js', __FILE__),
		array('cdm_admin_library')
	);

        wp_enqueue_style( 'ui-lightness','http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/ui-lightness/jquery-ui.css',array('cdm_style') );

        include 'includes/upload_html.php';
    }

    /**
     *manage users page, contains create user thing
     */
    function ManageUsers(){
        
        include 'includes/user_form.php';
    }

    /*
     * the configuration page
     */
    function configPage(){
        include 'includes/config.php';

    }

    function handle_upload(){
        //print_r($_FILES);

        $y = date('Y',current_time('timestamp'));
        $d = date('d',current_time('timestamp'));
        $m = date('m',current_time('timestamp'));
        $full = $y.'/'.$m.'/'.$d;


//        chmod(WP_CONTENT_DIR.'/cdm_uploads/'.$y.'/'.$m.'/'.$d, 777);
//        chmod(WP_CONTENT_DIR.'/cdm_uploads/'.$y.'/'.$m, 777);
//        chmod(WP_CONTENT_DIR.'/cdm_uploads/'.$y, 777);

        $permission_denied = (!file_exists(WP_CONTENT_DIR.'/cdm_uploads/'.$y))?(mkdir(WP_CONTENT_DIR.'/cdm_uploads/'.$y,0755))?true:false:false;
        $permission_denied = (!file_exists(WP_CONTENT_DIR.'/cdm_uploads/'.$y.'/'.$m))?(mkdir(WP_CONTENT_DIR.'/cdm_uploads/'.$y.'/'.$m,0755))?true:false:false;
        $permission_denied = (!file_exists(WP_CONTENT_DIR.'/cdm_uploads/'.$y.'/'.$m.'/'.$d))?(mkdir(WP_CONTENT_DIR.'/cdm_uploads/'.$y.'/'.$m.'/'.$d,0755))?true:false:false;



if($permission){
$error=true;
$msg = 'Permission denied! Cannot create directories, Please make sure the directory wp-content/cdm_uploads is writable.';
}else{

        $uploadDir = WP_CONTENT_DIR.'/cdm_uploads/'.$full.'/';

if (!empty($_FILES)) {
	$tempFile   = $_FILES['Filedata']['tmp_name'][0];


	// Validate the file type
        $fileTypes = explode(',', $this->configuration->allowed_extension);
	//$fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // Allowed file extensions
	$fileParts = pathinfo($_FILES['Filedata']['name'][0]);
        $file_name = keygen(32).'.'.$fileParts['extension'];
        $targetFile = $uploadDir .$file_name;//$_FILES['Filedata']['name'][0];
	// Validate the filetype
	if (in_array($fileParts['extension'], $fileTypes)) {

		// Save the file
		if(move_uploaded_file($tempFile,$targetFile)){

                    if($id = $this->_save_file($file_name,$full,$_FILES['Filedata']['name'][0])){
                                $error = false;
                                $msg = "File ".$_FILES['Filedata']['name'][0]." Uploaded!";
                                $data = (array('id'=>$id,'name'=>$_FILES['Filedata']['name'][0]));

                    }else{
                        $error = true;
                        $msg = "Server problem! Couldn't save the file to database, please try again. Here is the server message <br/>".mysql_error();
                    }
                }

	} else {

		$error = true;
                $msg = "File type not allowed. Only ".$this->configuration->allowed_extension." are allowed.";


	}
}


}
header( "Content-Type: application/json" );
print_r(json_encode(array('error'=> $error,'msg'=>$msg,'file_data'=>$data)));
        die();
    }

    function _save_file($filename,$dir,$original){

        $current_user = wp_get_current_user();
        global $wpdb;
        $time = current_time('mysql',0);
        $wpdb->query( $wpdb->prepare("INSERT INTO `".$wpdb->prefix."cdm_files`  (`original_name`,`file_name`, `folder`, `user_id`, `date_added`, `assigned`)
            VALUES ('$original','$filename','$dir',$current_user->ID,'$time',0);") );
       if($wpdb->insert_id)
           return $wpdb->insert_id;
       else
           return false;

    }


    /**
     *usernames for dropdown
     */
    function get_usernames($json=false){
        if($this->configuration->userrole){
            $search = 'role='.$this->configuration->userrole;
        }
        $users = get_users($search);

        $return = array();
        foreach($users as $user){

            $return[] = array(
                'id'=>$user->ID,
                'username' =>$user->user_nicename
            );

        }

        if(!$json)
            print_r(json_encode($return));
        else
            return $return;
            die();
    }


    function assign_file(){


        $current_user = wp_get_current_user();
        $file = trim($_POST['file_id']);
        if(is_array($_POST['user_id'])){
            $user_ids = array_filter($_POST['user_id']);

            foreach ($user_ids as $user_id):
                global $wpdb;
        $time = current_time('mysql',0);

        $wpdb->query( $wpdb->prepare("INSERT INTO `".$wpdb->prefix."cdm_assign`  (`file_id`,`user_id`, `who_assigned`, `date`)
            VALUES ('$file','$user_id',$current_user->ID,'$time');") );

//        $wpdb->query( $wpdb->prepare("UPDATE `".$wpdb->prefix."cdm_files` SET `assigned_date` = '$time', `assigned_to` =  '$user' WHERE  `id` =$file;"));

            endforeach;
            $error = false;
            $msg = "Succesfully assigned";


        }else{
            $error = true;
            $msg = "Please select some user";
        }
        print_r(json_encode(array('error'=>$error,'msg'=>$msg)));

        die();

    }

    function install(){
        if(!file_exists(WP_CONTENT_DIR.'/cdm_uploads'))
        {mkdir(WP_CONTENT_DIR.'/cdm_uploads'); }
        global $wpdb;
        $file_assign_database = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."cdm_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original_name` varchar(255) NOT NULL,
  `file_name` varchar(40) NOT NULL,
  `folder` varchar(12) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_added` timestamp NULL DEFAULT NULL,
  `assigned` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;";
        
        $wpdb->query($file_assign_database);

$file_assign_database ="CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."cdm_assign` (
  `file_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `who_assigned` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


";

        //`test` TIMESTAMP NOT NULL
        $wpdb->query($file_assign_database);


    }

    function uninstall(){

        global $wpdb;
        $wpdb->query("DROP TABLE  `".$wpdb->prefix."cdm_files`");
    }

}