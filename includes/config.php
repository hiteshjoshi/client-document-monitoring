<?php

class config extends cdm{
    public $options;
    function __construct() {
	parent::__construct();
	if(isset($_POST['cdm_update_options'])):
	$this->saveOptions($_POST);
	endif;

    }

    function getRoles($selected=null){
	global $wp_roles;
	$roles = $wp_roles->get_names();
	foreach($roles as $name => $role){
	    if($selected && $selected==$name)
	    echo "<option value='$name' selected>".$role."</option>";
	    else
	    echo "<option value='$name'>".$role."</option>";

	    }
	    }

	    function saveOptions($options){

		update_option('cdm_roles',$options['cdm_roles']);
		update_option('cdm_client_comment',$options['cdm_client_comment']);
		update_option('cdm_client_upload',$options['cdm_client_upload']);
		update_option('cdm_display_month',$options['cdm_display_month']);
		update_option('cdm_display_year',$options['cdm_display_year']);
		update_option('cdm_display_date',$options['cdm_display_date']);
		update_option('cdm_display_all',$options['cdm_display_all']);
		update_option('cdm_external_css',$options['cdm_external_css']);
		update_option('cdm_secure_files',$options['cdm_secure_files']);
		update_option('cdm_allowed_extension',$options['cdm_allowed_extension']);
		update_option('cdm_update_options',$options['cdm_update_options']);
                update_option('cdm_allowed_filesize',$options['cdm_allowed_filesize']);//cdm_userroles
                update_option('cdm_userroles',$options['cdm_userroles']);//

	    }
	    }

	    $config = new config();

?>


<h1>Configurations </h1>

<form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    <fieldset>
	<p>
	<h3>Backend access</h3>
	<label for="roles">
	    Roles
	    <select id="roles" name="cdm_roles">
		<?php
		$config->getRoles(get_option('cdm_roles'));
		?>
	    </select>
	</label> <span class="description">The default user role who can upload files, add user and can assign files to users.</span>
	</p>

        <p>
	<h3>Backend access</h3>
	<label for="userroles">
	    Roles
	    <select id="userroles" name="cdm_userroles">
                <option value="">none</option>
		<?php
		$config->getRoles(get_option('cdm_userroles'));
		?>
	    </select>
	</label> <span class="description">Option role for users.</span>
	</p>

	<hr/>
	<p><h3>Client access</h3>
	<label for="client_comment">
	    Client can Comment?
	    <select name="cdm_client_comment" id="client_comment">
		<option value="yes" <?php if(get_option('cdm_client_comment')=='yes') echo "selected='selected'"; ?>>Yes</option>
		<option value="no" <?php if(get_option('cdm_client_comment')=='no') echo "selected='selected'"; ?>>No</option>

	    </select>
	</label>
	    <span class="description">Select yes if you grant clients the access to comment on their files.</span>
	</p>
	<p>

	<label for="client_upload">
	    Client can Upload?
	    <select name="cdm_client_upload" id="client_upload">
		<option value="yes" <?php if(get_option('cdm_client_upload')=='yes') echo "selected='selected'"; ?>>Yes</option>
		<option value="no" <?php if(get_option('cdm_client_upload')=='no') echo "selected='selected'"; ?>>No</option>

	    </select>
	</label>

	<span class="description">Select yes if you grant clients the access to upload files as a reply for their respective documents.</span>
	</p>

	<hr/>
	<p><h3>Client Elements and UI</h3>
	    <label for="display_month"> Display month?
		<select name="cdm_display_month" id="display_month">
		   <option value="yes" <?php if(get_option('cdm_display_month')=='yes') echo "selected='selected'"; ?>>Yes</option>
		<option value="no" <?php if(get_option('cdm_display_month')=='no') echo "selected='selected'"; ?>>No</option>

		</select>
	    </label>
	    <label for="display_year"> Display year?
		<select name="cdm_display_year" id="display_year">
		   <option value="yes" <?php if(get_option('cdm_display_year')=='yes') echo "selected='selected'"; ?>>Yes</option>
		<option value="no" <?php if(get_option('cdm_display_year')=='no') echo "selected='selected'"; ?>>No</option>

		</select>
	    </label>

	    <label for="display_date"> Display date?
		<select name="cdm_display_date" id="display_date">
		    <option value="yes" <?php if(get_option('cdm_display_date')=='yes') echo "selected='selected'"; ?>>Yes</option>
		<option <?php if(trim(get_option('cdm_display_date'))=="no") echo "selected='selected'"; ?> value="no" >No</option>

		</select>
	    </label>
	</p>


	<p>
	    <label for="display_all">
		Display all files ?
		<select name="cdm_display_all">
		    <option value="yes" <?php if(get_option('cdm_display_all')=='yes') echo "selected='selected'"; ?>>Yes</option>
		<option value="no" <?php if(get_option('cdm_display_all')=='no') echo "selected='selected'"; ?>>No</option>

		</select>

	    </label>
	    <span class="description">Select yes if you want to display all the files on a single go, without using the filter to sort through month,year,date. <b>This option will over write above options</b></span>
	</p>

	<p>
	    <label for="load_css">Load External CSS ?
	    <input type="text" name="cdm_external_css" value="<?php echo get_option('cdm_external_css');?>" />
	    </label>
	    <span class="description">URL of External css for user interaction page, leave blank for default, write <b>false</b> for not loading plugin's default css(might be helpful when theme includes css for forms/tables etc)</span>
	</p>
	<hr/><h3>Security configuration</h3>
	<p>
	    <label for="secure_files">Secure files?
	    <select name="cdm_secure_files" id="secure_files">
		<option value="yes" <?php if(get_option('cdm_secure_files')=='yes') echo "selected='selected'"; ?>>Yes</option>
		<option value="no" <?php if(get_option('cdm_secure_files')=='no') echo "selected='selected'"; ?>>No</option>

	    </select>
	    </label> <span class="description">Only authorised user can download the files, client's file url won't work for other users or public</span>
	</p>

	<p>
	    <label for="allowed_extension">Allowed files extentions
	   <input type="text" name="cdm_allowed_extension" value="<?php echo get_option('cdm_allowed_extension');?>"/>
	    </label> <span class="description">Useful if different users are uploading files for users or if client is allowed to upload files as a reply. Leave blank for all file types(.exe,.bat etc are never allowed for security reasons). Example : <b>.pdf,.ppt,.doc,.docx,.xml</b> etc</span>
	</p>
<p>
	    <label for="allowed_filesize">Single file size limit
	   <input id="allowed_filesize" type="text" name="cdm_allowed_filesize" value="<?php echo get_option('cdm_allowed_filesize');?>"/><b>KB</b><br/>
	    </label> <span class="description">max allowed size for every file, please cross check with php file size limit and server (eg. apache,nginx) file size limit.</span>
	</p>

    </fieldset>
    <input type="hidden" name="cdm_update_options" value="yes" />
    <input type="submit" class="button" value="Save"/>
</form>