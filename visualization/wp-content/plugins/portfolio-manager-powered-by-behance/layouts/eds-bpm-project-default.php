<?php
	if ( ! defined( 'WPINC' ) ) {
		die;
	}
	$response = $data['response'];
	$pagination_code = $data['pagination_code'];
	
	$filter_pname = $filters->get_filter_pname();
	$filter_pcategory = $filters->get_filter_pcategory();
	$filter_pstatus = $filters->get_filter_pstatus();
		
	$page_number = $filters->get_page_number();
	$order_by = $filters->get_order_by();	
	$ordering = $filters->get_ordering();
?>
<div class="modal fade bpm-modal" id="bpm-ipm" tabindex="-1" role="dialog" aria-labelledby="bpm-modal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php _e('Import Projects from Behance', 'eds-bpm'); ?></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12" id="bpm-ipm-msg">					
					</div>
				</div>	
				<div class="row" id="bpm-ipm-search" >					
					<div class="control-group col-xs-12">
						<label for="bpm-ipm-userid"><?php _e('Behance User Id', 'eds-bpm'); ?>:</label>
						<div class="controls">
							<input type="text" class="form-control bpm-ipm-control" id="bpm-ipm-userid" name="bpm-ipm-userid" value = "" />
						</div>
					</div>
					<div class="control-group col-xs-12">&nbsp;</div>
					<div class="control-group col-xs-12">
						<label for="bpm-ipm-category"><?php _e('Default Category:', 'eds-bpm'); ?>
						</label>						
						<select name="bpm-ipm-category" class="form-control bpm-ipm-control">						
							<?php foreach($response->category_list as $category):?>							
								<option value="<?php echo $category->id; ?>">
									<?php echo $category->name; ?>
								</option>							
							<?php endforeach;?>							
						</select>						
					</div>	
				</div>		
				<div class="row" id="bpm-ipm-projects-wrapper">															
					<div class="col-xs-12">
						<h4><span id="bpm-ipm-projects-wrapper-heading">Projects</span> &nbsp;<a href="#" id="bpm-ipm-projects-reset">&times;</a></h4>
					</div>
					<div id="bpm-ipm-projects" class="col-xs-12">					
					</div>
				</div>				
			</div>					
			<div class="modal-footer">
				<a class="btn btn-default" href="#" data-dismiss="modal"><?php _e('Cancel', 'eds-bpm'); ?></a>		
				<a class="btn btn-success bpm-ipm-submit" href="#"><?php _e('Import Projects', 'eds-bpm'); ?></a>
				<a class="btn btn-success bpm-ipm-save" href="#"><?php _e('Save', 'eds-bpm'); ?></a>																						
			</div>
		</div>
	</div>
</div>	
<div class="row">
	<div class="panel panel-default eds-bpm-filters">
		<div class="panel-heading">
			<?php _e('Filters:','eds-bpm');?>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="control-group col-md-4">
					<label for="bpm-project-name"><?php _e('Project', 'eds-bpm'); ?>:</label>
					<div class="controls">
						<input type="text" class="form-control input-sm" id="bpm-project-name" name="bpm-project-name" value = "<?php echo $filter_pname;?>" />
					</div>
				</div>
				<div class="form-group col-md-4">
					<label for="bpm-project-category"><?php _e('Categories:', 'eds-bpm'); ?>
					</label>						
					<select id="bpm-project-category" name="bpm-project-category" class="form-control">
						<option value="-1">All</option>
						<?php foreach($response->category_list as $category):?>
							<?php if($filter_pcategory == $category->id):?>
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
				<div class="form-group col-md-4">
					<label for="bpm-project-status"><?php _e('Status:', 'eds-bpm'); ?>
					</label>						
					<select id="bpm-project-status" name="bpm-project-status" class="form-control">
						<option value="" <?php echo ($filter_pstatus==null)?'selected="selected"':'';?>><?php _e('All','eds-bpm');?></option>
						<option value="published" <?php echo ($filter_pstatus=='published')?'selected="selected"':'';?>><?php _e('Published','eds-bpm');?></option>
						<option value="unpublished" <?php echo ($filter_pstatus=='unpublished')?'selected="selected"':'';?>><?php _e('Unpublished','eds-bpm');?></option>
						<option value="featured" <?php echo ($filter_pstatus=='featured')?'selected="selected"':'';?>><?php _e('Featured','eds-bpm');?></option>
						<option value="deleted" <?php echo ($filter_pstatus=='deleted')?'selected="selected"':'';?>><?php _e('Deleted','eds-bpm');?></option>							
					</select>						
				</div>
			</div>
			<div class="row eds-bpm-add-row-space">
				<div class="col-md-12">
					<div class="control-group">
						<div class="controls controls-row">
							<button class="button" type="button" name="search-projects" id="search-projects" ><?php _e('Search', 'eds-bpm'); ?></button>
							<button class="button" type="button" name="clear-projects" id="clear-projects" ><?php _e('Clear', 'eds-bpm'); ?></button>								 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row eds-bpm-add-row-space">
	<div class="col-md-12">
		<div class="btn-group" role="group" aria-label="...">
			<a href="<?php echo $newUrl; ?>" class="btn btn-default" id="bpm-new-project">
			<?php _e('New', 'eds-bpm'); ?>
			</a>			
			<button type="button" class="btn btn-default" id="bpm-publish-project">
			<?php _e('Publish', 'eds-bpm'); ?>
			</button>
			<button type="button" class="btn btn-default" id="bpm-unpublish-project">
			<?php _e('Unpublish', 'eds-bpm'); ?>
			</button>
			<button type="button" class="btn btn-default" id="bpm-set-featured-project">
			<?php _e('Featured', 'eds-bpm'); ?>
			</button>
			<?php if($filter_pstatus == 'deleted'): ?>
				<button type="button" class="btn btn-default" id="bpm-trash-project">
				<?php _e('Trash', 'eds-bpm'); ?>
				</button>
			<?php else: ?>
				<button type="button" class="btn btn-default" id="bpm-delete-project">
				<?php _e('Delete', 'eds-bpm'); ?>
				</button>
			<?php endif;?>
			<button type="button" class="btn btn-default" id="bpm-sync-project">
				<?php _e('Sync', 'eds-bpm'); ?>
			</button>
			<button type="button" class="btn btn-default" id="bpm-import-project">
				<?php _e('Import', 'eds-bpm'); ?>
			</button>
		</div>
	</div>
</div>
<div class="row eds-bpm-add-row-space">
	<div class="panel panel-default">
		<div class="panel-body no-padding table-responsive">
			<table class="table table-hover table-striped">
				<thead>
					<tr>
						<th><input type="checkbox" onClick="edsToggleCheckBox(this,'entries[]')"></th>
						<th>
							<?php if($order_by == 'b_project_name'): ?>
								<?php if($ordering=='asc'):?>
									<a href="<?php echo $url.'&bpm-ob=b_project_name&bpm-o=desc' ; ?>">
										<?php _e('Project' , 'eds-bpm'); ?>
										<i class="fa fa-caret-up"></i> 
									</a>
								<?php elseif($ordering=='desc'):?>
									<a href="<?php echo $url.'&bpm-ob=b_project_name&bpm-o=asc' ; ?>">
										<?php _e('Project' , 'eds-bpm'); ?>
										<i class="fa fa-caret-down"></i> 
									</a>
								<?php endif;?>
							<?php else:?>	
								<a href="<?php echo $url.'&bpm-ob=b_project_name&bpm-o=asc' ; ?>">
									<?php _e('Project' , 'eds-bpm'); ?>										 
								</a>
							<?php endif;?>
						</th>
						<th class="hidden-xs">
							<?php if($order_by == 'status'): ?>
								<?php if($ordering=='asc'):?>
									<a href="<?php echo $url.'&bpm-ob=status&bpm-o=desc' ; ?>">
										<?php _e('Status' , 'eds-bpm'); ?>
										<i class="fa fa-caret-up"></i> 
									</a>
								<?php elseif($ordering=='desc'):?>
									<a href="<?php echo $url.'&bpm-ob=status&bpm-o=asc' ; ?>">
										<?php _e('Status' , 'eds-bpm'); ?>
										<i class="fa fa-caret-down"></i> 
									</a>
								<?php endif;?>
							<?php else:?>	
								<a href="<?php echo $url.'&bpm-ob=status&bpm-o=asc' ; ?>">
									<?php _e('Status' , 'eds-bpm'); ?>									 
								</a>
							<?php endif;?>
						</th>
						<th class="hidden-xs">
							<?php _e('Behance Project ID' , 'eds-bpm'); ?>								
						</th>
						<th class="hidden-xs">
							<?php if($order_by == 'b_create_date'): ?>
								<?php if($ordering=='asc'):?>
									<a href="<?php echo $url.'&bpm-ob=b_create_date&bpm-o=desc' ; ?>">
										<?php _e('Date of Creation(Behance)' , 'eds-bpm'); ?>
										<i class="fa fa-caret-up"></i> 
									</a>
								<?php elseif($ordering=='desc'):?>
									<a href="<?php echo $url.'&bpm-ob=b_create_date&bpm-o=asc' ; ?>">
										<?php _e('Date of Creation(Behance)' , 'eds-bpm'); ?>
										<i class="fa fa-caret-down"></i> 
									</a>
								<?php endif;?>
							<?php else:?>	
								<a href="<?php echo $url.'&bpm-ob=b_create_date&bpm-o=asc' ; ?>">
									<?php _e('Date of Creation(Behance)' , 'eds-bpm'); ?>									 
								</a>
							<?php endif;?>
						</th>														
					</tr>
				</thead>
				<tbody>
					<?php foreach($response->rows as $row):?>
						<?php $row_class='';?>					
						<tr class="<?php echo $row_class; ?>">
							<td class="bpm-checkbox-wrapper">
								<input project-status="<?php echo $row->status; ?>"  
									type="checkbox" name="entries[]" value="<?php echo $row->id; ?>">
							</td>
							<td class="bpm-project-column">
								<a href="<?php echo $newUrl."&bpm-task=edit&bpm-layout=edit&bpm-id=".$row->id; ?>" class="bpm-project-link">
									<div class="eds-bpm-project-thumbnail-backend pull-left hidden-xs">
										<img src="<?php echo $row->b_project_thumb; ?>" /> 
									</div>
								</a>							
								<a href="<?php echo $newUrl."&bpm-task=edit&bpm-layout=edit&bpm-id=".$row->id; ?>" class="bpm-project-link">
									<?php echo $row->b_project_name; ?>
								</a>
								<div class="small">
									<?php _e('Category', 'eds-bpm');?>: <?php echo $row->cat_name; ?>
								</div>																		
							</td>
							<td class="hidden-xs">
								<div class="btn-group" role="group" aria-label="...">
									<a href="#" class="btn btn-xs btn-default bpm-project-status-link" 
										current-status="<?php echo $row->status;?>" 
										title="<?php echo strtoupper($row->status);?>">
										<?php if($row->status == 'published'):?>
											<span class="eds-bpm-icon-green"><i class="fa fa-check"></i></span>												
										<?php elseif($row->status == 'unpublished'):?>
											<span class="eds-bpm-icon-red"><i class="fa fa-times-circle"></i></span>
										<?php elseif($row->status == 'deleted'):?>
											<span class="eds-bpm-icon-red"><i class="fa fa-minus-circle"></i></span>										
										<?php endif; ?>
									</a>
									<a href="#" class="btn btn-xs btn-default bpm-project-featured-link" 
										current-status="<?php echo $row->featured;?>" 
										title="<?php echo ($row->featured==1)?'Featured':'Not Featured';?>">
										<?php if($row->featured == '1'):?>
											<span class="eds-bpm-icon-featured"><i class="fa fa-star"></i></span>												
										<?php else:?>
											<span class=""><i class="fa fa-star-o"></i></span>
										<?php endif; ?>
									</a>
								</div>								
							</td>
							<td class="hidden-xs">
								<?php echo $row->b_project_id; ?>
							</td>
							<td class="hidden-xs">
								<?php echo $row->b_create_date; ?>
							</td>								
						</tr>
					<?php endforeach;?>
				</tbody>
			</table>
		</div>
		<div class="panel-footer">
		 	<?php echo $pagination_code; ?>
		</div>		
	</div>
</div>
