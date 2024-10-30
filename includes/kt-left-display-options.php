<?php
if ( 'kt-left-display-options.php' == basename( $_SERVER['PHP_SELF'] ) )
	exit();
?>
<script type="text/javascript">
function ktselectall(formid) {
	var i = 0;
	for (i;i<formid.elements.length;i++)
	if (formid.elements[i].type == 'checkbox') {
		formid.elements[i].checked = 'checked';
	}
}
</SCRIPT>
<div class ="wrap">
	<?php screen_icon( 'plugins' );?>
	<h2>Kt Cleanpress</h2>
<div class ="ktmainclass">
	<?php 
	if (isset($_POST['submit'])){
		$ktresults = ktclean_process();
	if (isset($ktresults['empty'])){?>
		<div id="message" class="error"><?php _e('Please Select Some Options');?></div>
	<?php }
	elseif($ktresults['difference'] == '0b'  ){
	?>
		<div id="message" class="error"><?php _e('Your Database is Already clean and optimized.');?></div>
	<?php 
	}else{
		?><div id="message" class="updated"><?php printf(__("Original Database Size was %1s , Final Database size is %2s , Freed Space %3s , Execution Time : %4s"),$ktresults['originalsize'],$ktresults['finalsize'],$ktresults['difference'],$ktresults['extime'])?></div>
	<?php	
	}}?>
	<div class="ktcleanpressleft">
		<form action="" method="post" id="ktcleanpost">
			<fieldset>
				<legend><?php _e( 'Posts Cleaning options' , 'kt-cleanpress' )?></legend>
				<label for="clean-draft"><?php _e('Clean Draft Posts' , 'kt-cleanpress')?></label>
				<input type="checkbox" id="clean-draft" name="clean-draft" >
				<label for="clean-pending"><?php _e('Clean Pending Posts' , 'kt-cleanpress')?></label>
				<input type="checkbox" id="clean-pending" name="clean-pending" >
				<label for="clean-trash"><?php _e('Clean Trash Posts' , 'kt-cleanpress')?></label>
				<input type="checkbox" id="clean-trash" name="clean-trash" >
			</fieldset>
				<fieldset>
				<legend><?php _e( 'Pages Cleaning options' , 'kt-cleanpress' )?></legend>
				<label for="cleanp-draft"><?php _e('Clean Draft Pages' , 'kt-cleanpress')?></label>
				<input type="checkbox" id="cleanp-draft" name="cleanp-draft" >
				<label for="cleanp-pending"><?php _e('Clean Pending Pages' , 'kt-cleanpress')?></label>
				<input type="checkbox" id="cleanp-pending" name="cleanp-pending" >
				<label for="cleanp-trash"><?php _e('Clean Trash Pages' , 'kt-cleanpress')?></label>
				<input type="checkbox" id="cleanp-trash" name="cleanp-trash" >
			</fieldset>
			<fieldset>
				<legend><?php _e( 'Comments Cleaning options' , 'kt-cleanpress' )?></legend>
				<label for="clean-spam"><?php _e('Clean Spam Comments' , 'kt-cleanpress')?></label>
				<input type="checkbox" id="clean-spam" name="clean-spam" >		
				<label for="clean-unaproved"><?php _e('Clean Unapproved  Comments' , 'kt-cleanpress')?></label>
				<input type="checkbox" id="clean-unaproved" name="clean-unaproved" >	
				<label for="clean-trashcomment"><?php _e('Clean Trash  Comments' , 'kt-cleanpress')?></label>
				<input type="checkbox" id="clean-trashcomment" name="clean-trashcomment" >						
			</fieldset>
			<fieldset>
				<legend><?php _e( 'Other Cleaning options' , 'kt-cleanpress' )?></legend>
				<label for="clean-revision"><?php _e('Clean Post Revisions' , 'kt-cleanpress')?></label>
				<input type="checkbox" id="clean-revision" name="clean-revision" >
				<label for="clean-autodraft"><?php _e('Clean Auto Draft' , 'kt-cleanpress')?></label>
				<input type="checkbox" id="clean-autodraft" name="clean-autodraft" >		
				<label for="clean-navmenulock"><?php _e('Clean Other Left Overs' , 'kt-cleanpress')?></label>
				<input type="checkbox" id="clean-navmenulock" name="clean-navmenulock" >
				<label for="clean-emptyc"><?php _e('Clean Empty  Categories' , 'kt-cleanpress')?></label>
				<input type="checkbox" id="clean-emptyc" name="clean-emptyc" >	
				<label for="clean-emptyt"><?php _e('Clean Empty  Tags' , 'kt-cleanpress')?></label>
				<input type="checkbox" id="clean-emptyt" name="clean-emptyt" >	
				<label for="clean-optimize"><?php _e('Optimize Tables' , 'kt-cleanpress')?></label>
				<input type="checkbox" id="clean-optimize" name="clean-optimize" >									
			</fieldset>	
			<input type="button" class="button-primary" onclick="ktselectall(document.getElementById('ktcleanpost'));" value="<?php _e('Select All','kt-cleanpress')?>">
			<input type="submit" name="submit" class="button-primary" value="<?php _e('Execute','kt-cleanpress')?>">
			<input type="reset" name="reset" class="button-primary" value="<?php _e('Reset','kt-cleanpress')?>">			
		</form>
	</div>
<?php include ( plugin_dir_path(__FILE__) . 'kt-right-display-options.php' );?>
</div >
</div>