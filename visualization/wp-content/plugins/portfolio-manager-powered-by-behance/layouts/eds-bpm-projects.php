<?php
	if ( ! defined( 'WPINC' ) ) {
		die;
	}
	
	$flag = $data['flag'];
	$msg = $data['msg'];	
		
?>

<div class="container-fluid">
	<div class="row eds-bpm-add-row-space">
		<div class="col-md-12">
			<?php if(  null !== $curl_flag  && false == $curl_flag ):?>
				<div class="alert alert-danger alert-dismissible eds-bpm-alert" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  	<i class="fa fa-times-circle"></i><?php _e('CURL module is not enabled.', 'eds-bpm'); ?>
				</div>
			<?php endif; ?>		
			<?php if($flag !== null && $msg!== null):?>
			<div class="alert <?php echo ($flag)?'alert-success':'alert-danger';?> alert-dismissible eds-bpm-alert" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  	<?php echo ($flag)?'<i class="fa fa-check-circle"></i>':'<i class="fa fa-times-circle"></i>';?><?php echo $msg; ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="wrap">
			<h2>
				<?php if($layout == "default"): ?>
					<?php _e('Portfolio Manager - Projects', 'eds-bpm'); ?>
					<a class="add-new-h2" href="<?php echo $newUrl; ?>"><?php _e('Add New', 'eds-bpm'); ?></a>
				<?php elseif($layout == "new"): ?>
					<?php _e('Portfolio Manager - New Project', 'eds-bpm'); ?>
				<?php elseif($layout == "edit"): ?>
					<?php _e('Portfolio Manager - Edit Project', 'eds-bpm'); ?>
				<?php endif; ?>
			</h2>
			</div>
		</div>		
	</div>
	<?php if($layout == "default"): ?>
	<form name="eds_bpm_project" id="eds_bpm_project"
		action="<?php echo $url; ?>" method="post">
	<?php else: ?>
	<form name="eds_bpm_project" id="eds_bpm_project"
		action="<?php echo $newUrl; ?>" method="post">
	<?php endif; ?>
		<input type="hidden" name="bpm-task" value="<?php echo $task; ?>" /> 
		<input type="hidden" name="bpm-layout" value="<?php echo $layout; ?>" />
		<input type="hidden" name="page" value="<?php echo $page_slug; ?>" />
		<input type="hidden" name="bpm-id" value="<?php echo $bpm_id;?>" />
		<?php if($layout == "default"):?>
			<?php include_once $default_template_url;?>
		<?php elseif($layout == "new" || $layout == "edit"):?>
			<?php include_once $edit_template_url;?>
		<?php endif; ?>				
	</form>
</div>