<?php
?>
<h1>Create Users </h1>

<form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    <fieldset>
	<p>
	<h3>Backend access</h3>
	<label for="roles">
	    Roles
	    
	</label> <span class="description">The default user role who can upload files, add user and can assign files to users.</span>
	</p>

    </fieldset>
    <input type="submit" class="button" value="Create user"/>
</form>