<?php
if ( 'kt-right-display-options.php' == basename( $_SERVER['PHP_SELF'] ) )
	exit();
?>

<div class="ktcleanpressright">
<span class = "kthtitle"><?php _e("HELP SECTION" , 'kt-cleanpress')?></span>
<fieldset>
<legend><?php _e("Posts cleaning options" , 'kt-cleanpress')?></legend>
	<span class = "kttitle"><?php _e("Clean Draft Posts:" , 'kt-cleanpress')?></span>
	<span class = "kttext"><?php _e("Will remove all posts marked as Draft including any related database data." , 'kt-cleanpress')?></span><br>
	<span class = "kttitle"><?php _e("Clean Pending Posts:" , 'kt-cleanpress')?></span>
	<span class = "kttext"><?php _e("Will remove all posts marked as pending including any related database data." , 'kt-cleanpress')?></span><br>
	<span class = "kttitle"><?php _e("Clean trash Posts:" , 'kt-cleanpress')?></span>
	<span class = "kttext"><?php _e("Will remove all posts marked as trash including any related database data." , 'kt-cleanpress')?></span><br>
</fieldset>
<fieldset>
<legend><?php _e("Pages Cleaning Options" , 'kt-cleanpress')?></legend>
<span class = "kttitle"><?php _e("Clean Draft Pages:" , 'kt-cleanpress')?></span>
<span class = "kttext"><?php _e("Will remove all pages marked as Draft including any related database data." , 'kt-cleanpress')?></span><br>
<span class = "kttitle"><?php _e("Clean Pending Pages:" , 'kt-cleanpress')?></span>
<span class = "kttext"><?php _e("Will remove all pages marked as Pending any related database data." , 'kt-cleanpress')?></span><br>
<span class = "kttitle"><?php _e("Clean Trash Pages:" , 'kt-cleanpress')?></span>
<span class = "kttext"><?php _e("Will remove all pages marked as Trash any related database data." , 'kt-cleanpress')?></span><br>
</fieldset>
<fieldset>
<legend><?php _e("Comments Cleaning Options" , 'kt-cleanpress')?></legend>
<span class = "kttitle"><?php _e("Clean Spam Comments:" , 'kt-cleanpress')?></span>
<span class = "kttext"><?php _e("Will remove all comments marked as spam including any related database data." , 'kt-cleanpress')?></span><br>
<span class = "kttitle"><?php _e("Clean Unapproved Comments:" , 'kt-cleanpress')?></span>
<span class = "kttext"><?php _e("Will remove all comments marked as unapproved including any related database data." , 'kt-cleanpress')?></span><br>
<span class = "kttitle"><?php _e("Clean Trash Comments:" , 'kt-cleanpress')?></span>
<span class = "kttext"><?php _e("Will remove all comments marked as trash including any related database data." , 'kt-cleanpress')?></span><br>
</fieldset>
<fieldset>
<legend><?php _e("Other Cleaning Options" , 'kt-cleanpress')?></legend>
<span class = "kttitle"><?php _e("Clean Post Revisions:" , 'kt-cleanpress')?></span>
<span class = "kttext"><?php _e("Whenever a post is edited and saved WordPress automatically creates a backup to which one can revert. This option will remove all posts backups." , 'kt-cleanpress')?></span><br>
<span class = "kttitle"><?php _e("Clean Auto Draft :" , 'kt-cleanpress')?></span>
<span class = "kttext"><?php _e("This is a left over from the process of creating a new WordPress page or post and not saving it as a draft of publishing it." , 'kt-cleanpress')?></span><br>
<span class = "kttitle"><?php _e("Clean Other Left Overs:" , 'kt-cleanpress')?></span>
<span class = "kttext"><?php _e("Will remove navigation menus that are created but not saved , and all their related data ,  and will also remove  unneeded lock and last entries in the database." , 'kt-cleanpress')?></span><br>
<span class = "kttitle"><?php _e("Clean Empty Categories:" , 'kt-cleanpress')?></span>
<span class = "kttext"><?php _e("Will delete all categories that don’t have any post or link associated with them but will not remove the default WordPress categories." , 'kt-cleanpress')?></span><br>
<span class = "kttitle"><?php _e("Clean Empty Tags:" , 'kt-cleanpress')?></span>
<span class = "kttext"><?php _e("Will delete all tags that don’t have any post associated with them." , 'kt-cleanpress')?></span><br>
<span class = "kttitle"><?php _e("Optimize Tables:" , 'kt-cleanpress')?></span>
<span class = "kttext"><?php _e("Reclaim unused space and defragment the data file." , 'kt-cleanpress')?></span><br> 
</fieldset>
</div>