<?php
	if ( ! defined( 'WPINC' ) ) {
		die;
	}
	$response = $data['response'];
	$pagination_code = $data['pagination_code'];
		
	$filter_category = $filters->get_filter_category();
	$filter_status = $filters->get_filter_status();
	
	$page_number = $filters->get_page_number();
	$order_by = $filters->get_order_by();	
	$ordering = $filters->get_ordering();
	
?>
<div class="row">
	<div class="panel panel-default eds-bpm-filters">
		<div class="panel-heading">
		<?php _e('Filters:','eds-bpm');?>
		</div>
		<div class="panel-body">	
			<div class="row">
				<div class="control-group col-md-4">
					<label class="control-label" for="bpm-cat-name"><?php _e('Category Name', 'eds-bpm'); ?>:</label>
					<div class="controls">
						<input type="text" class="form-control input-sm" id="bpm-cat-name" name="bpm-cat-name" value = "<?php echo $filter_category;?>" />
					</div>
				</div>
				<div class="form-group col-md-4">
					<label for="bpm-cat-status"><?php _e('Status:', 'eds-bpm'); ?>
					</label>						
					<select id="bpm-cat-status" name="bpm-cat-status" class="form-control">
						<option value="" <?php echo ($filter_status==null)?'selected="selected"':'';?>><?php _e('All','eds-bpm'); ?> </option>
						<option value="published" <?php echo ($filter_status=='published')?'selected="selected"':'';?>><?php _e('Published','eds-bpm'); ?></option>
						<option value="unpublished" <?php echo ($filter_status=='unpublished')?'selected="selected"':'';?>><?php _e('Unpublished','eds-bpm'); ?></option>
						<option value="deleted" <?php echo ($filter_status=='deleted')?'selected="selected"':'';?>><?php _e('Deleted','eds-bpm'); ?></option>							
					</select>						
				</div>					
			</div>				
			<div class="row eds-bpm-add-row-space">
				<div class="col-md-12">
					<div class="control-group">
						<div class="controls controls-row">
							<button class="button" type="button" name="search-category" id="search-category" ><?php _e('Search', 'eds-bpm'); ?></button>
							<button class="button" type="button" name="clear-category" id="clear-category" ><?php _e('Clear', 'eds-bpm'); ?></button>								 
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
			<a href="<?php echo $url."&bpm-task=new&bpm-layout=new"; ?>" class="btn btn-default" id="bpm-new-cat">
			<?php _e('New', 'eds-bpm'); ?>
			</a>			
			<button type="button" class="btn btn-default" id="bpm-publish-cat">
			<?php _e('Publish', 'eds-bpm'); ?>
			</button>
			<button type="button" class="btn btn-default" id="bpm-unpublish-cat">
			<?php _e('Unpublish', 'eds-bpm'); ?>
			</button>
			<?php if($filter_status =='deleted'):?>
				<button type="button" class="btn btn-default" id="bpm-trash-cat">
				<?php _e('Trash', 'eds-bpm'); ?>
				</button>
			<?php else: ?>
				<button type="button" class="btn btn-default" id="bpm-delete-cat">
				<?php _e('Delete', 'eds-bpm'); ?>
				</button>					
			<?php endif;?>
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
							<?php if($order_by == 'name'): ?>
								<?php if($ordering=='asc'):?>
									<a href="<?php echo $url.'&bpm-ob=name&bpm-o=desc' ; ?>">
										<?php _e('Category Name' , 'eds-bpm'); ?>
										<i class="fa fa-caret-up"></i> 
									</a>
								<?php elseif($ordering=='desc'):?>
									<a href="<?php echo $url.'&bpm-ob=name&bpm-o=asc' ; ?>">
										<?php _e('Category Name' , 'eds-bpm'); ?>
										<i class="fa fa-caret-down"></i> 
									</a>
								<?php endif;?>
							<?php else:?>	
								<a href="<?php echo $url.'&bpm-ob=name&bpm-o=asc' ; ?>">
									<?php _e('Category Name' , 'eds-bpm'); ?>										 
								</a>
							<?php endif;?>
						</th>
						<th class="hidden-xs">
							<?php _e('Description' , 'eds-bpm'); ?>
						</th>													
						<th class="hidden-xs hidden-sm hidden-md">
							<?php if($order_by == 'doc'): ?>
								<?php if($ordering=='asc'):?>
									<a href="<?php echo $url.'&bpm-ob=doc&bpm-o=desc' ; ?>">
										<?php _e('Creation Date' , 'eds-bpm'); ?>
										<i class="fa fa-caret-up"></i> 
									</a>
								<?php elseif($ordering=='desc'):?>
									<a href="<?php echo $url.'&bpm-ob=doc&bpm-o=asc' ; ?>">
										<?php _e('Creation Date' , 'eds-bpm'); ?>
										<i class="fa fa-caret-down"></i> 
									</a>
								<?php endif;?>
							<?php else:?>	
								<a href="<?php echo $url.'&bpm-ob=doc&bpm-o=asc' ; ?>">
									<?php _e('Creation Date' , 'eds-bpm'); ?>									 
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
					</tr>
				</thead>
				<tbody>
					<?php foreach($response->rows as $row):?>
						<?php $row_class='';?>							 
						<?php
							/*switch ($row->status){
								case 'unpublished':
									$row_class = 'warning';
									break;									
								case 'published':
									$row_class = 'success';
									break;									
								case 'deleted':
									$row_class = 'danger';
									break;
							} */
						?>
						<tr class="<?php echo $row_class; ?>">
							<td class="bpm-checkbox-wrapper">
								<input category-status="<?php echo $row->status; ?>"  
									type="checkbox" name="entries[]" value="<?php echo $row->id; ?>">
							</td>
							<td>
								<a href="<?php echo $url."&bpm-task=edit&bpm-layout=edit&bpm-id=".$row->id; ?>" class="bpm-category-link">
									<?php echo $row->name?>
								</a>
							</td>	
							<td class="hidden-xs">	
								<?php echo $row->description; ?>
							</td>							
							<td class="hidden-xs hidden-sm hidden-md">	
								<?php echo $row->doc; ?>
							</td>
							<td class="hidden-xs">
								<a href="#" class="btn btn-xs btn-default bpm-category-status-link" 
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
