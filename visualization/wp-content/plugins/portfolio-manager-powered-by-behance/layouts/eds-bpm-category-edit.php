<?php
if ( ! defined( 'WPINC' ) ) {
	die;
} 
$category = $data['category'];
?>

<div class="row eds-bpm-add-row-space">
	<div class="col-md-12">			
		<div class="btn-group" role="group" aria-label="...">
			<input 
				type="submit" 
				class="btn btn-default" 
				id="bpm-save-cat" 
				name="submit" 
				value="<?php _e('Save & Close', 'eds-bpm'); ?>" />									
			<a href="<?php echo $url; ?>" class="btn btn-default">
				<?php _e('Close', 'eds-bpm'); ?>
			</a>					
		</div>		
	</div>
</div>
<div class="row eds-bpm-add-row-space">
	<div class="col-md-12">
		<div class="form-group">
			<label class="col-sm-2" for="cat-name"><?php _e('Category Name' , 'eds-bpm');?></label>
			<div class="col-sm-4">							
				<input type="text"
					class="form-control" 
					name="cat-name" 
					id="cat-name" 
					placeholder=""
					
					value = "<?php echo esc_html($category->name); ?>"
					required 					
				/>			
			</div> 								
		</div>	
		
		<div class="form-group">
			<label class="col-sm-2" for="cat-icon-img"></label>
			<div class="col-sm-8">
				<?php if($category->icon != null && $category->icon !=''):?>
				<img id="cat-icon-img" style="max-width:120px; max-height:120px;" src="<?php echo $category->icon; ?>" />
				<?php else:?>
				<img id="cat-icon-img" style="max-width:120px; max-height:120px;" src="<?php echo plugin_dir_url(__FILE__).'../images/default-category-icon.jpg'; ?>" />
				<?php endif;?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2" for="cat-icon"><?php _e('Category Icon', 'eds-bpm'); ?></label>
			
			<div class="col-sm-8">
					<?php if($category->icon != null && $category->icon !=''):?>							
					<input id="cat-icon" name="cat-icon" type="text" value="<?php echo $category->icon; ?>" readonly />
					<?php else:?>
					<input id="cat-icon" name="cat-icon" type="text" value="<?php echo plugin_dir_url(__FILE__).'../images/default-category-icon.jpg'; ?>" readonly />
					<?php endif;?>
					<button id="cat-icon-upload" class="button" name="cat-icon-upload" ><?php _e('Upload','eds-bpm');?></button> 
			</div> 								
		</div>
			
		
		<div class="form-group">
			<label class="col-sm-2" for="cat-description"><?php _e('Description' , 'eds-bpm');?></label>
			<div class="col-sm-4">
				<textarea 
					name="cat-desc" 
					id="cat-desc" 
					class="form-control"><?php echo esc_html($category->description); ?></textarea>									
			</div> 								
		</div>
	</div>
</div>