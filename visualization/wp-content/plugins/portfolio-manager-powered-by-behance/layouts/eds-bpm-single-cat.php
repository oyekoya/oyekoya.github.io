<?php  
 	if ( ! defined( 'WPINC' ) ) {
		die;
	}
	  
	$customCSS = '	 
		.eds-bpm-view-dynamic
		{
			margin: '.$attributes['tile_margin'].'px; 
		}			
		.isotope-item{
			position: relative;
		  	float: left;
		  	width: 220px;
	   		height: 158px;	  	
		}
		.isotope-item > * {
	  		margin: 0;
	  		padding: 0;
		} ';
	         
	
	
   
	if (isset($config['eds_bpm_custom_css']) && trim($config['eds_bpm_custom_css'])!=''){	
		$customCSS .= trim($config['eds_bpm_custom_css']);
	}   
	
	if($customCSS != null && $customCSS !="")
		$customCSS = EDS_BPM_Config::trim_all($customCSS);
		
	
	wp_localize_script( 'eds-bpm-site-js', 'eds_bpm_custom_css', $customCSS );	
	
?> 
<?php if($sct =='y' || $scd == 'y' || $sci=='y'):?>
<div id= "eds-bpm-category-header">
	<?php if($sci == 'y'):?>	
		<div class="cat-img-wrapper">
			<img src="<?php echo $category->icon; ?>" />
		</div>
	<?php endif; ?>
	<?php if($sct =='y' || $scd == 'y'):?>
	<div class="cat-content-wrapper">
		<?php if($sct == 'y'):?>	
			<div class="cat-title-wrapper">
				<?php echo $category->name; ?>
			</div>
		<?php endif; ?>		
		<?php if($scd == 'y'):?>	
			<div class="cat-desc-wrapper">
				<?php echo $category->description; ?>
			</div>
		<?php endif; ?>
	</div>
	<?php endif;?>			
</div>
<?php endif; ?>
<div class="eds-bpm-main <?php echo 'mosaic-view-'.$attributes['mosaic_style'];?>" id="eds-bpm-project-container">
	<?php foreach($projects as $project):?>			
		<div class= "isotope-item">			
			<div class="eds-bpm-view eds-bpm-view-first">
				<img src="<?php echo $project->b_project_thumb;?>" />
				<div class="eds-bpm-mask">
					<div class="eds-bpm-view-heading"><?php echo $project->b_project_name; ?></div>
					<div class="eds-bpm-view-para"><?php echo $project->b_creative_fields;?></div>
					<?php $new_tab_string = '';?>
					<?php if($open_in_different_tab): ?>
						<?php $new_tab_string = 'target="_blank"';?>
					<?php else: ?>
						<?php $new_tab_string = '';?>
					<?php endif; ?>
					<?php if($view_on_behance): ?>						
							<a class="eds-bpm-info" href="<?php echo $project->b_project_url; ?>"  <?php echo $new_tab_string; ?> ><?php _e('View Project','eds-bpm');?></a>
						
					<?php else: ?>
						<?php if($enable_pretty_url):?>
							<?php if(is_front_page() && !is_home()):?>
								<a class="eds-bpm-info" href="<?php echo $siteUrl."?p=".$currentPost->ID."&ch_eds_bpid=".$project->id; ?>"  <?php echo $new_tab_string; ?> ><?php _e('View Project','eds-bpm');?></a>						
							<?php else: ?>
								<?php
									$tempLink = get_permalink($currentPost->ID);
									$finalUrl = '';
									if( substr($tempLink,-1) == '/' ) {
										$finalUrl = $tempLink . "bproject/".$project->slug;
									} else {
										$finalUrl = $tempLink . "/bproject/".$project->slug;
									}
								?>
								<a class="eds-bpm-info" href="<?php echo $finalUrl; ?>"  <?php echo $new_tab_string; ?> ><?php _e('View Project','eds-bpm');?></a>
							<?php endif;?>				
						<?php else: ?>
							<?php if(is_front_page() && !is_home()):?>
								<a class="eds-bpm-info" href="<?php echo $siteUrl."?p=".$currentPost->ID."&ch_eds_bpid=".$project->id; ?>"  <?php echo $new_tab_string; ?> ><?php _e('View Project','eds-bpm');?></a>						
							<?php else: ?>
								<a class="eds-bpm-info" href="<?php echo $siteUrl."?p=".$currentPost->ID."&eds_bpid=".$project->id; ?>"  <?php echo $new_tab_string; ?> ><?php _e('View Project','eds-bpm');?></a>
							<?php endif;?>					
						<?php endif;?>
					<?php endif; ?>			
				</div>
			</div>
		</div>								
	<?php endforeach;?>	
</div>
