<?php   
 	if ( ! defined( 'WPINC' ) ) {
		die;
	}	   
	$customCSS = '	 
		eds-bpm-section {
			margin: 0;			    
		    text-align: center;
		}
		
		eds-bpm-section ul {	
			margin: 0;		    
		    padding: 20px 0;
		    border-bottom: 1px solid rgb(220,220,220);
		}     
		   
		eds-bpm-section li {
		    display: inline-block;
		    list-style: none outside none;
		    border: 0px none;
		    margin: 16px 4px;
		} 
		  
		
		eds-bpm-section li span { 
		 margin: 0 10px 10px 0;
		 line-height: 39px;
		 color: '.$attributes['tab_utc'].';
		 padding: 10px 20px;
		 text-decoration: none !important;
		 font-family: \'Open Sans\',sans-serif !important;
		 background:  '.$attributes['tab_ubc'].';
		
		}
		
		eds-bpm-section li span.selected {
		 top: 1px;
		 background: '.$attributes['tab_sbc'].';
		 color: '.$attributes['tab_stc'].';
		}
		
		eds-bpm-section li span:hover {
			background: '.$attributes['tab_hbc'].';
			color: '.$attributes['tab_htc'].';	
			cursor:pointer;
		}
		
		.eds-bpm-option-set{
		 	position: relative;
		 }
		 
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
<eds-bpm-section id="options" class="clearfix">
	<ul id="filters" class="eds-bpm-option-set" data-option-key="filter">
		<?php if($show_all==1):?>			
			<li><span class="cat-tab" catname="be-all-cat"><?php _e('All','eds-bpm');?></span></li>			
		<?php endif;?>
		<?php foreach($categories as $category):?>
			<?php if($category!= null):?>
				<li><span class="cat-tab" catname="<?php echo $category->slug?>">
					<?php echo $category->name;?></span>
				</li>										
			<?php endif; ?>
		<?php endforeach;?>
	</ul>
</eds-bpm-section>
<div class="eds-bpm-main isotope <?php echo 'mosaic-view-'.$attributes['mosaic_style'];?>" id="eds-bpm-project-container">
	<?php foreach($projects as $project):?>		
		<div class= "isotope-item <?php echo $project->cat_slug;?>">	
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
						<a class="eds-bpm-info" href="<?php echo $project->b_project_url; ?>" <?php echo $new_tab_string; ?> ><?php _e('View Project','eds-bpm');?></a>								
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