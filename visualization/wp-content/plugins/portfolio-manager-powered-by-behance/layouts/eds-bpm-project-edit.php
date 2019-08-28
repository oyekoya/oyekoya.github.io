<?php  
	if ( ! defined( 'WPINC' ) ) {
		die;
	}  
	$project = $data['project'];
	$show_search = $data['show_search'];
	$b_pr_data = $data['b_pr_data'];
	$status = $data['status'];	
	$customCSS = $data['customCSS'];
	$bp_search_id = $data['bp_search_id'];
	$category_list = $data['category_list'];
	$sub_task = $data['sub_task'];
	$b_fields = $data['b_fields'];    
?>
<input type="hidden" name="bpm-sub-task" value="<?php echo ($sub_task != null)?$sub_task:''; ?>" />
<?php if($status == 'S'):?>
<input type="hidden" name="b_project_id" value="<?php echo $project->b_project_id;?>" />
<input type="hidden" name="b_project_url" value="<<?php echo $project->b_project_url;?>>" />
<input type="hidden" name="b_project_name" value="<?php echo esc_html( $project->b_project_name );?>" />
<input type="hidden" name="b_project_thumb" value="<<?php echo $project->b_project_thumb;?>>" />
<input type="hidden" name="b_creative_fields" value="<?php echo $project->b_creative_fields;?>" />
<input type="hidden" name="b_create_date" value="<?php echo $project->b_create_date;?>" />
<input type="hidden" name="b_modified_timestamp" value="<?php echo $project->b_modified_timestamp;?>" />
<?php endif;?>   
         
<div class="row eds-bpm-add-row-space">
	<div class="col-md-12">
		<?php if($status != 'S'):?>
		<div class="btn-group" role="group" aria-label="...">
			<a href="<?php echo $url; ?>" class="btn btn-default">
				<?php _e('Close', 'eds-bpm'); ?>
			</a>
		</div>
		<?php else:?>
		<div class="btn-group" role="group" aria-label="...">
			<button type="button" class="btn btn-default" id="bpm-save-behance-project">
			<?php _e('Save & Close', 'eds-bpm'); ?>
			</button>
			<a href="<?php echo $url; ?>" class="btn btn-default">
				<?php _e('Close', 'eds-bpm'); ?>
			</a>					
		</div>
		<?php endif;?>		
	</div>
</div>
<div class="row eds-bpm-add-row-space">
	<div class="col-md-12">							
	<?php if($show_search):?>
		<?php if($status != 'S'):?>					
			<div class="eds-bpm-project-search-form">
				<div style="text-align:center;margin-bottom:20px;">
					<img src="<?php echo plugin_dir_url(__FILE__).'../images/portfolio-manager.png'; ?>">
				</div>
				<div style="text-align:center;">
					<div class="btn-group">
						<input type="text"
							class="form-control"
							name="bp-search-id" 
							id="bp-search-id"																										
							placeholder = "<?php _e('Behance Project ID', 'eds-bpm'); ?>" 
							value="<?php echo $bp_search_id; ?>" 
							required  
						/>
					</div>
					<div class="btn-group">
						<button type="button" class="btn btn-default" id="bpm-search-project-behance">
							<i class="fa fa-search"></i>									
						</button>								
					</div>
				</div>
				<div class="eds-bpm-information">
					<h5><?php _e('Having problems? Please refer to our','eds-bpm'); ?> <a target="_blank" href="http://www.downloads.eleopard.in/portfolio-manager-documentation-wordpress"><?php _e('Documentation','eds-bpm');?></a></h5>
				</div>
			</div>										
		<?php else: ?>				
			<div class="form-group col-md-4 ">
				<div class="row">
					<div class="col-md-10">	
						<label for="bp-search-id"><?php _e('Project ID:', 'eds-bpm'); ?>
						</label>
						<div style="text-align:left;">
							<div class="btn-group">
								<input type="text"
									class="form-control input-sm" 
									id="bp-search-id" 
									name="bp-search-id" 
									value = "<?php echo $bp_search_id; ?>"
									placeholder = "<?php _e('Behance Project ID', 'eds-bpm'); ?>"
									disabled ="disabled"																
									required														 
								/>
							</div>
							<div class="btn-group">
								<button type="button" class="btn btn-default btn-sm" id="bpm-clear-project-behance">
									<i class="fa fa-times"></i>								
								</button>								
							</div>
						</div>	
					</div>
				</div>										
			</div>				
		<?php endif;?>			
	<?php endif;?>
	<?php if($status == 'S'):?>
		<div class="form-group col-md-4">
			<div class="row">
				<div class="col-md-8">
					<label for="bpm-project-category"><?php _e('Categories:', 'eds-bpm'); ?>
					</label>						
					<select id="bpm-project-category" name="bpm-project-category" class="form-control">
						<?php foreach($category_list as $category):?>
							<?php if($project->catid == $category->id):?>
								<option value="<?php echo $category->id;?>" selected="selected">
									<?php echo $category->name; ?>
								</option>	
							<?php else:?>
								<option value="<?php echo $category->id; ?>">
									<?php echo $category->name; ?>
								</option>>
							<?php endif; ?>
						<?php endforeach;?>							
					</select>
				</div>
			</div>						
		</div>
		
		<div class="form-group col-md-4">
			<div class="row">
				<div class="col-md-8">
					<label for="bpm-project-status"><?php _e('Status:', 'eds-bpm'); ?>
					</label>						
					<select id="bpm-project-status" name="bpm-project-status" class="form-control">
						<option value="published" <?php echo ($project->status=='published')?'selected="selected"':'';?>><?php _e('Published','eds-bpm');?></option>
						<option value="unpublished" <?php echo ($project->status=='unpublished')?'selected="selected"':'';?>><?php _e('Unpublished','eds-bpm');?></option>
						<option value="deleted" <?php echo ($project->status=='deleted')?'selected="selected"':'';?>><?php _e('Deleted','eds-bpm');?></option>													
					</select>					
				</div>
			</div>	
		</div>
		
	<?php endif; ?>
	</div>					
</div>		
<?php if($status== 'S'):?>
<div class="row">
	<div class="col-md-12">
		<h4>Project Preview</h4>
		<?php include_once EDS_BPM_Loader::$abs_path . '/layouts/eds-bpm-project-preview.php';?>
	</div>
</div>		
<?php endif;?>