<div id="pending" class="wrap">
<div id="icon-tools" class="icon32 pending"><br/></div>
<h2>
Pending documents	<a href="<?=bloginfo('wpurl');?>/wp-admin/admin.php?page=cdm_document_upload" class="add-new-h2">Upload New documents</a></h2>

<p class="search-box">
	<label class="screen-reader-text" for="media-search-input">Search Media:</label>
	<input type="search" id="media-search-input" name="s" value="">
	<input type="submit" name="" id="search-submit" class="button" value="Search Media"></p>
<div class="tablenav top">

		<div class="alignleft actions">
			<select name="action">
<option value="-1" selected="selected">Bulk Actions</option>
	<option value="delete">Delete Permanently</option>
</select>
<input type="submit" name="" id="doaction" class="button-secondary action" value="Apply">
		</div>
		<div class="alignleft actions">
		<select name="m">
			<option selected="selected" value="0">Show all dates</option>
<option value="201206">June 2012</option>
		</select>
<input type="submit" name="" id="post-query-submit" class="button-secondary" value="Filter">		</div>
<div class="tablenav-pages"><span class="displaying-num">21 items</span>
<span class="pagination-links"><a class="first-page disabled" title="Go to the first page" href="http://localhost:83/wp-admin/upload.php">«</a>
<a class="prev-page disabled" title="Go to the previous page" href="http://localhost:83/wp-admin/upload.php?paged=1">‹</a>
<span class="paging-input"><input class="current-page" title="Current page" type="text" name="paged" value="1" size="1"> of <span class="total-pages">2</span></span>
<a class="next-page" title="Go to the next page" href="http://localhost:83/wp-admin/upload.php?paged=2">›</a>
<a class="last-page" title="Go to the last page" href="http://localhost:83/wp-admin/upload.php?paged=2">»</a></span></div>
		<br class="clear">
	</div>
<table class="widefat">
<thead>
    <tr>
        <th>S no.</th>
        <th>File name</th>
        <th>Adding data</th>
        <th>Users</th>
        <th>Action </th>
    </tr>
</thead>

<tbody>

<?php
foreach($pending as $k=>$v){
$user = get_user_by('id', $v->user_id);
?>
    <tr>
     <td><?php echo $k+1; ?></td>
     <td><?php echo $v->original_name; ?></td>
     <td><?php echo "Added by ".$user->user_nicename." at ".date("D, d M y \\a\\t H:i a",strtotime($v->date_added)); ?></td>
     <td>
         <select id="" class="multiselect" multiple="">
<?php foreach($usernames as $user): ?>
    <option value="<?=$user['id']?>"><?=$user['username']?></option>
    <?php

             endforeach; ?>

                </select></td>
     <td><button>Assign file</button></td>

   </tr>
    <?php

}
?>

</tbody>
</table>
<button class="button-primary">Assign all</button>

</div>


