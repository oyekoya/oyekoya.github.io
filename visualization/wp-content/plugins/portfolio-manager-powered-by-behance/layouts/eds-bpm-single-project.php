<?php
 if ( ! defined( 'WPINC' ) ) {
	die;
} 
?>
<?php
	//Advanced Configuration Parameters
	$show_project_title = (isset($config['show_project_title']) && $config['show_project_title']=="yes");
	$show_creative_fields = (isset($config['show_creative_fields']) && $config['show_creative_fields']=="yes" && $b_pr_data['fields']!=null && sizeof($b_pr_data['fields']));
	$show_project_by = (isset($config['show_project_by']) && $config['show_project_by']=="yes");
	$show_about_project = ((isset($config['show_about_project']) && $config['show_about_project']=="yes") && $b_pr_data['description']!=null && strlen($b_pr_data['description']));
	$show_publish_date =  ((isset($config['show_publish_date']) && $config['show_publish_date']=="yes"));
	$show_views = (isset($config['show_views']) && $config['show_views']=="yes");
	$show_appreciations = (isset($config['show_appreciations']) && $config['show_appreciations']=="yes");
	$show_comments = (isset($config['show_comments']) && $config['show_comments']=="yes");	
	$show_tags = (isset($config['show_tags']) && $config['show_tags']=="yes" && $b_pr_data['tags']!=null && sizeof($b_pr_data['tags']));
	$show_tools_used = (isset($config['show_tools_used']) && $config['show_tools_used']=="yes" && $b_pr_data['tools']!=null && sizeof($b_pr_data['tools']));
	$show_copyright_info = (isset($config['show_copyright_info']) && 
							$config['show_copyright_info']=="yes" && 
							isset($b_pr_data['copyright']) && sizeof($b_pr_data['copyright']));
	
	
	//Navigation button related configuration
	$show_prev_next_btn = (isset($nav_btn_config['show_prev_next_btn']) && $nav_btn_config['show_prev_next_btn']=="yes");
	
	$prev_next_btn_style = $nav_btn_config['prev_next_btn_style'];
	$prev_next_btn_position = $nav_btn_config['prev_next_btn_position'];
	$prev_next_btn_icon = (isset($nav_btn_config['prev_next_btn_icon']) && $nav_btn_config['prev_next_btn_icon']=="yes");
	$prev_btn_icon= "";
	$next_btn_icon= "";	
	$prev_additional_class = '';
	$next_additional_class = '';
	if($prev_next_btn_icon){
		$prev_btn_icon = '<span class="eds-bpm-prev-btn-icon"></span>';
		$next_btn_icon = '<span class="eds-bpm-next-btn-icon"></span>';
		$prev_additional_class = 'eds-bpm-has-icon';
		$next_additional_class = 'eds-bpm-has-icon';
	}
	
	$prev_btn_text = $nav_btn_config['prev_btn_text'];	
	if(isset($prev_btn_text) && !empty($prev_btn_text)){
		$prev_additional_class .= ' eds-bpm-has-text';
	}
	$prev_btn_text_color = $nav_btn_config['prev_btn_text_color'];
	$prev_btn_bg_color = $nav_btn_config['prev_btn_bg_color'];
		
	$next_btn_text = $nav_btn_config['next_btn_text'];	
	if(isset($next_btn_text) && !empty($next_btn_text)){
		$next_additional_class .= ' eds-bpm-has-text';
	}
	$next_btn_text_color = $nav_btn_config['next_btn_text_color'];
	$next_btn_bg_color = $nav_btn_config['next_btn_bg_color'];
	
	$license_id = intval($b_pr_data['copyright']['license_id']);
	
	//Combined Checks
	$show_project_details_wrapper = $show_project_title || $show_creative_fields || $show_views || $show_appreciations || $show_comments;
	$show_project_info_wrapper = $show_tools_used || $show_about_project || $show_project_by;
	
	$show_project_sidebar = $show_project_by || $show_about_project || $show_publish_date || $show_tools_used;
	

	//Adding CSS properties from behance
	$customCSS = ".bpm-sr-attribution{ background-image: url('".plugin_dir_url(__FILE__)."../images/by.svg'); } ";
	$customCSS .= ".bpm-sr-noncommercial{ background-image: url('".plugin_dir_url(__FILE__)."../images/nc.svg'); } ";
	$customCSS .= ".bpm-sr-noderivatives{ background-image: url('".plugin_dir_url(__FILE__)."../images/nd.svg'); } ";
	$customCSS .= ".bpm-sr-sharealike{ background-image: url('".plugin_dir_url(__FILE__)."../images/sa.svg'); } ";
	$customCSS .= ".bpm-sr-zero{ background-image: url('".plugin_dir_url(__FILE__)."../images/zero.svg'); } ";
	$customCSS .= "#bop-container{ background-color:". $config['project_background_color'] . ";	} ";
	$customCSS .= ".flower-loader:after{ background-color:". $config['loading_icon_color'] . ";} ";
	
	if(isset($b_pr_data['canvas_width']) && !empty($b_pr_data['canvas_width'])){
		$customCSS .= "#bop-project-left { max-width:". $b_pr_data['canvas_width'] ."px; } ";
	}else{
		$customCSS .= "#bop-project-left { max-width:724px; } ";
	}
				
	$customCSS .= "#bop-project-left .bop-primary-project-content{";
	
	if(isset($b_pr_data['styles']['background']['color']))
		$customCSS .= "	background-color: #" . $b_pr_data['styles']['background']['color'] . ";";
		
	if(isset($b_pr_data['styles']['background']['image']['url']))
		$customCSS .= "background-image: url('" . $b_pr_data['styles']['background']['image']['url'] ."');";

	if(isset($b_pr_data['styles']['background']['image']['repeat'])){
		$customCSS .= "background-repeat: ". $b_pr_data['styles']['background']['image']['repeat'] . ";";
			
		if($b_pr_data['styles']['background']['image']['repeat'] == "repeat")
			$customCSS .= "background-size: auto";	
		else
			$customCSS .= "background-size: 100% auto;";
	}

	if(isset($b_pr_data['styles']['background']['image']['position']))
		$customCSS .= "background-position:". $b_pr_data['styles']['background']['image']['position'] .";";
			
	$customCSS .= " overflow-x: hidden; } ";
	
	if( isset( $b_pr_data['styles']['text']['title'] ) ){
		$customCSS .= " .bop-primary-project-content .title{";
		
		foreach($b_pr_data['styles']['text']['title'] as $p_name => $p_value){
			$p_name = str_replace('_','-' , $p_name);
			$customCSS .= $p_name.':'.$p_value.';';
		}
		
		$customCSS .= " }";
	}
	
	if( isset( $b_pr_data['styles']['text']['subtitle'] ) ){
		$customCSS .= " .bop-primary-project-content .sub-title{";
		
		foreach($b_pr_data['styles']['text']['subtitle'] as $p_name => $p_value){
			$p_name = str_replace('_','-' , $p_name);
			$customCSS .= $p_name.':'.$p_value.';';
		}
		
		$customCSS .= " }";
	}

	if( isset( $b_pr_data['styles']['text']['paragraph'] )) {
		$customCSS .= " .bop-primary-project-content p, .bop-primary-project-content .main-text{";
		
		foreach($b_pr_data['styles']['text']['paragraph'] as $p_name => $p_value){
			if( $p_name != 'display') {
				$p_name = str_replace('_','-' , $p_name);
				$customCSS .= $p_name.':'.$p_value.';';
			}
		}
		
		$customCSS .= " }";
	}
	
	if( isset( $b_pr_data['styles']['text']['caption'] )) {
		$customCSS .= " .bop-primary-project-content .caption{";
		
		foreach($b_pr_data['styles']['text']['caption'] as $p_name => $p_value){
			$p_name = str_replace('_','-' , $p_name);
			$customCSS .= $p_name.':'.$p_value.';';
		}
		
		$customCSS .= " }";
	}
		
	if( isset( $b_pr_data['styles']['text']['link'] )) {
		
		$customCSS .= ".bop-primary-project-content a{";
		
		foreach($b_pr_data['styles']['text']['link'] as $p_name => $p_value){
			$p_name = str_replace('_','-' , $p_name);
			$customCSS .= $p_name.':'.$p_value.';';
		}
		
		$customCSS .= " }";
	}	
		
	
	if( !$show_project_sidebar ){
		$customCSS .= " #bop-project-left{	margin-right: 0; } ";	
	}

	
	if($show_prev_next_btn) {
		$customCSS .= " #bop-container .bop-navigation .bop-navigation-prev{ ";
	
		
		if(isset($prev_btn_text_color) && !empty($prev_btn_text_color)) {
			$customCSS .= " color:" .$prev_btn_text_color . ";";
		}
		
		if(isset($prev_btn_bg_color) && !empty($prev_btn_bg_color)) {
			$customCSS .= " background-color:" .$prev_btn_bg_color . ";";
		}	
	
		$customCSS .= "} #bop-container .bop-navigation .bop-navigation-next { ";
	
	
		if(isset($next_btn_text_color) && !empty($next_btn_text_color)) {
			$customCSS .= " color:" .$next_btn_text_color . ";";
		}
		
		if(isset($next_btn_bg_color) && !empty($next_btn_bg_color)) {
			$customCSS .= " background-color:" .$next_btn_bg_color . ";";
		}		
	
		$customCSS .= "}";
		
		if(isset($prev_btn_text_color) && !empty($prev_btn_text_color)) {
			$customCSS .= " #bop-container .bop-navigation .bop-navigation-prev .eds-bpm-prev-btn-icon{ ";
			$customCSS .= " border: solid " .$prev_btn_text_color . ";";
			$customCSS .= "}";
		}
		
		if(isset($next_btn_text_color) && !empty($next_btn_text_color)) {
			$customCSS .= " #bop-container .bop-navigation .bop-navigation-next .eds-bpm-next-btn-icon{ ";
			$customCSS .= " border: solid " .$next_btn_text_color . ";";
			$customCSS .= "}";
		}
		
	}
	
	if (isset($config['eds_bpm_custom_css']) && trim($config['eds_bpm_custom_css'])!=''){	
		$customCSS .= trim($config['eds_bpm_custom_css']);
	}
	
	if($customCSS != null && $customCSS !="")
		$customCSS = EDS_BPM_Config::trim_all($customCSS);
	
	wp_localize_script( 'eds-bpm-site-js', 'eds_bpm_custom_css', $customCSS );
	wp_localize_script( 'eds-bpm-site-js', 'eds_bpm_css_url',  plugin_dir_url(__FILE__).'../css/');
	
?>
<?php 
$bFields ='';
foreach ($b_pr_data['fields'] as $bField){ 
	$bFields = $bFields. ', ' . $bField;
}
$bToolsUsed = "";
foreach ($b_pr_data['tools'] as $tool){
	$bToolsUsed .= ", " . $tool['title'];
}
?>
<div id="bop-container">
	<div id="bop-waiting-popup" class="bop-waiting-popup" style="display:none;">
	    <div class="bop-popup-background"></div>
	    <div class="bop-loading-image">
	        <div class="flower-loader">
  				Loading�
			</div>
	    </div>	    
	</div>
	<?php if($show_prev_next_btn && 
			( isset($prev_project) || isset($next_project) ) && 
			($prev_next_btn_position == 'both' || $prev_next_btn_position == 'top')):?>
	<div class="bop-navigation  <?php echo $prev_next_btn_style; ?>">		
		<?php if($enable_pretty_url):?>
			<?php if(is_front_page() && !is_home()):?>
				<?php if(isset($prev_project)): ?>
					<a class="bop-navigation-prev <?php echo $prev_additional_class; ?>" href="<?php echo $siteUrl."?p=".$currentPost->ID."&ch_eds_bpid=".$prev_project->id; ?>">
						<?php echo $prev_btn_icon; ?>
						<?php echo $prev_btn_text; ?>
					</a>
				<?php endif; ?>
				<?php if(isset($next_project)): ?>
					<a class="bop-navigation-next <?php echo $next_additional_class; ?>" href="<?php echo $siteUrl."?p=".$currentPost->ID."&ch_eds_bpid=".$next_project->id; ?>">
						<?php echo $next_btn_icon; ?>
						<?php echo $next_btn_text; ?>
					</a>
				<?php endif; ?>
			<?php else:?>
				<?php 
					$tempLink = get_permalink($currentPost->ID);
					$prevUrl = '';
					$nextUrl = '';
					if( substr($tempLink,-1) == '/' ) {
						$prevUrl = $tempLink . "bproject/";
						$nextUrl = $tempLink . "bproject/";
					} else {
						$prevUrl = $tempLink . "/bproject/";
						$nextUrl = $tempLink . "/bproject/";
					}
				?>
				<?php if(isset($prev_project)): ?>
					<a class="bop-navigation-prev <?php echo $prev_additional_class; ?>" href="<?php echo $prevUrl.$prev_project->slug; ?>">
						<?php echo $prev_btn_icon; ?>
						<?php echo $prev_btn_text; ?>
					</a>
				<?php endif; ?>
				<?php if(isset($next_project)): ?>
					<a class="bop-navigation-next <?php echo $next_additional_class; ?>" href="<?php echo $nextUrl.$next_project->slug; ?>">
						<?php echo $next_btn_icon; ?>
						<?php echo $next_btn_text; ?>
					</a>
				<?php endif; ?>
			<?php endif; ?>			
		<?php else: ?>
			<?php if(is_front_page() && !is_home()):?>
				<?php if(isset($prev_project)): ?>
					<a class="bop-navigation-prev <?php echo $prev_additional_class; ?>" href="<?php echo $siteUrl."?p=".$currentPost->ID."&ch_eds_bpid=".$prev_project->id; ?>">
						<?php echo $prev_btn_icon; ?>
						<?php echo $prev_btn_text; ?>
					</a>
				<?php endif; ?>
				<?php if(isset($next_project)): ?>
					<a class="bop-navigation-next <?php echo $next_additional_class; ?>" href="<?php echo $siteUrl."?p=".$currentPost->ID."&ch_eds_bpid=".$next_project->id; ?>">
						<?php echo $next_btn_icon; ?>
						<?php echo $next_btn_text; ?>
					</a>
				<?php endif; ?>
			<?php else: ?>
				<?php if(isset($prev_project)): ?>
					<a class="bop-navigation-prev <?php echo $prev_additional_class; ?>" href="<?php echo $siteUrl."?p=".$currentPost->ID."&eds_bpid=".$prev_project->id; ?>">
						<?php echo $prev_btn_icon; ?>
						<?php echo $prev_btn_text; ?>
					</a>
				<?php endif; ?>
				<?php if(isset($next_project)): ?>
					<a class="bop-navigation-next <?php echo $next_additional_class; ?>" href="<?php echo $siteUrl."?p=".$currentPost->ID."&eds_bpid=".$next_project->id; ?>">
						<?php echo $next_btn_icon; ?>
						<?php echo $next_btn_text; ?>
					</a>
				<?php endif; ?>			
			<?php endif; ?>			
		<?php endif; ?>		
	</div>
	<?php endif; ?>
	<div id="bop-project" style="opacity:0">	
		<div id="bop-all-wrapper">		
			<div class="bop-project-area">
				<div id="bop-project-wrapper">
					<div id="bop-project-left">
						<div class="bop-primary-project-content">
							<div class="spacer" style="height: <?php echo $b_pr_data['styles']['spacing']['project']['top_margin'];?>px">
							</div>
							<?php foreach($b_pr_data['modules'] as $bModule):?>
								<?php if($bModule['full_bleed'] == '1'): ?>
									<?php if($bModule['type'] == 'media_collection' && $bModule['collection_type'] == 'grid'): ?>	
									<div class="bop-text-center bop-image-full bop-grid-wrapper">
									<?php else: ?>
									<div class="bop-text-center bop-image-full">
									<?php endif; ?>
								<?php else: ?>
									<?php if($bModule['type'] == 'media_collection' && $bModule['collection_type'] == 'grid'): ?>	
									<div class="bop-text-center bop-grid-wrapper">
									<?php else: ?>
									<div class="bop-text-center">
									<?php endif; ?>
								<?php endif; ?>								
								<?php if($bModule['type'] == 'image'): ?>
									<img src="<?php echo $bModule['sizes']['original'];?>" />
									<?php if(isset($bModule['caption']) && !empty($bModule['caption'])): ?>
										<div class="caption-alignment-<?php echo $bModule['caption_alignment']; ?>">
											<div class="caption">
												<?php echo $bModule['caption']; ?>
											</div>
										</div>
									<?php endif; ?>
								<?php elseif ($bModule['type'] == 'text'):?>
									<?php if(isset($bModule['caption_alignment'])): ?>
									<div class="bop-project-text caption-alignment-<?php echo $bModule['caption_alignment']; ?>">
									<?php else: ?>
									<div class="bop-project-text">
									<?php endif; ?>
									<?php echo $bModule['text']; ?>		
									</div>
								<?php elseif ($bModule['type'] == 'audio'):?>
									<?php echo $bModule['embed']; ?>
									<?php if(isset($bModule['caption']) && !empty($bModule['caption'])): ?>
										<div class="caption-alignment-<?php echo $bModule['caption_alignment']; ?>">
											<div class="caption">
												<?php echo $bModule['caption']; ?>
											</div>
										</div>
									<?php endif; ?>
								<?php elseif ($bModule['type'] == 'embed'):?>
									<?php 
										$embed_original_width = ''; $embed_original_height = ''; $embed_padding_bottom = ''; $embed_alignment= ''; 									
										if( isset($bModule['original_width']) && isset($bModule['original_height'])){
											
											$embed_original_width = 'max-width: ' . $bModule['original_width'] .'px';									
											$embed_original_height = 'max-height: ' . $bModule['original_height'] .'px';											
											$aspect_ratio = (intval( $bModule['original_height'] ) /  intval($bModule['original_width']))*100;
											$aspect_ratio = round($aspect_ratio, 2 );
											$embed_padding_bottom = 'padding-bottom:' . $aspect_ratio . '%';
										}
										if( isset( $bModule['alignment'] ) ){
											$embed_alignment = 'embed-align-'.$bModule['alignment'];
										}
									?>
																	
									<div class="embed-dimensions <?php echo $embed_alignment; ?>" style="<?php echo $embed_original_width . ';' . $embed_original_height.';'; ?>">
								        <div class="embed-aspect-ratio" style="<?php echo $embed_padding_bottom?>;">							         
											<?php echo $bModule['embed']; ?>
										</div>
									</div>
									<?php if(isset($bModule['caption']) && !empty($bModule['caption'])): ?>
										<div class="caption-alignment-<?php echo $bModule['caption_alignment']; ?>">
											<div class="caption">
												<?php echo $bModule['caption']; ?>
											</div>
										</div>
									<?php endif; ?>
								<?php elseif ($bModule['type'] == 'video'):?>
									<?php  if(isset($bModule['embed'])): ?>
										<?php 
											$embed_original_width = ''; $embed_original_height = ''; $embed_padding_bottom = ''; $embed_alignment= ''; 									
											if( isset($bModule['width']) && isset($bModule['height'])){
												
												$embed_original_width = 'max-width: ' . $bModule['width'] .'px';									
												$embed_original_height = 'max-height: ' . $bModule['height'] .'px';											
												$aspect_ratio = (intval( $bModule['height'] ) /  intval($bModule['width']))*100;
												$aspect_ratio = round($aspect_ratio, 2 );
												$embed_padding_bottom = 'padding-bottom:' . $aspect_ratio . '%';
											}
											if( isset( $bModule['alignment'] ) ){
												$embed_alignment = 'embed-align-'.$bModule['alignment'];
											}
										?>																		
										<div class="embed-dimensions <?php echo $embed_alignment; ?>" style="<?php echo $embed_original_width . ';' . $embed_original_height.';'; ?>">
									        <div class="embed-aspect-ratio" style="<?php echo $embed_padding_bottom?>;">							         
												<?php echo $bModule['embed']; ?>
											</div>
										</div>
									<?php else: ?>
										<a href="<?php echo $bModule['src']; ?>" target="_blank" >Video</a>
									<?php endif;?>
									<?php if(isset($bModule['caption']) && !empty($bModule['caption'])): ?>
										<div class="caption-alignment-<?php echo $bModule['caption_alignment']; ?>">
											<div class="caption">
												<?php echo $bModule['caption']; ?>
											</div>
										</div>
									<?php endif; ?>
								<?php elseif( $bModule['type'] == 'media_collection' && $bModule['collection_type'] == 'grid' ):?>								
									<?php foreach($bModule['components'] as $component):?>
										<div class="bop-grid" style="width: <?php echo $component["flex_width"]; ?>px; flex-grow: <?php echo $component["flex_width"]; ?>;">											
											<?php $src_set = array(); ?>
											<?php if( isset( $component["dimensions"] ) && !empty($component["dimensions"])	&& 
													isset( $component["sizes"] ) && !empty($component["sizes"])):?>
											<?php foreach( $component["dimensions"] as $key => $dimension ):?>
												<?php if( isset($component["sizes"][$key]) ) :?>
													<?php array_push($src_set, ''.$component["sizes"][$key] . ' ' . $dimension["width"]. 'w' ); ?>
												<?php endif; ?>
											<?php endforeach;?>
											<?php endif;?>		
											<?php if(count($src_set)):?>
												<img class="bop-grid-image" src="<?php echo $component["src"]; ?>" srcset="<?php echo implode(", ",$src_set);?>">											
											<?php endif;?>												
										</div>
									<?php endforeach; ?>							
									<?php if(isset($bModule['caption']) && !empty($bModule['caption'])): ?>
										<div class="caption-alignment-<?php echo $bModule['caption_alignment']; ?>">
											<div class="caption">
												<?php echo $bModule['caption']; ?>
											</div>
										</div>
									<?php endif; ?>																	
								<?php endif;?>				
								</div>
								<div class="spacer" style="height: <?php echo $b_pr_data['styles']['spacing']['modules']['bottom_margin'];?>px">
									<?php $dividerStyle ='';?>
									<?php foreach($b_pr_data['styles']['dividers'] as $pName => $pValue):?>
									<?php $pName = str_replace('_','-' , $pName); ?>
									<?php $dividerStyle = $dividerStyle . ';'.$pName.':'.$pValue;?>
									<?php endforeach;?>
									<div class="divider" style="<?php echo substr($dividerStyle,1);?>">
									</div>
								</div>						
							<?php endforeach; ?>
						</div>
						<div id="bpm-project-footer-wrapper">
							<div id="bpm-inner-footer-wrapper">								
								<?php if($show_about_project || $show_publish_date):?>
								<div class="bpm-project-footer-block bpm-footer-basic-info">
									<?php if($show_about_project):?>		
									<div class="bpm-footer-block-heading">Basic Info</div>	
									<div class="bpm-footer-content-padding">						
									<?php echo $b_pr_data['description']; ?>
									</div>									
									<?php endif; ?>
									<?php if($show_publish_date):?> 
									<div class="bpm-footer-published-on">Published: <?php echo date('M d, Y', $b_pr_data['published_on']); ?></div>
									<?php endif;?>
								</div>
								<?php endif; ?>
								<?php if($show_project_by):?>
								<div class="bpm-project-footer-block bpm-footer-project-by">
									<div class="bpm-footer-block-heading">Credits</div>
									<div class="bpm-project-by-right-wrapper">
										<?php foreach($b_pr_data['owners'] as $owner) : ?>
											<div class="bpm-project-by-right">
												<div class="bpm-project-by-right-image">																							
													<?php
														$lastKey = 0; 
														$ownerImg = ""; 
														foreach($owner['images'] as $imKey => $imValue){
															if($lastKey < intval($imKey)){
																$lastKey = $imKey;
																$ownerImg = $imValue;	
															}														
														}
													?>												
													<img src="<?php echo $ownerImg; ?>" />												
												</div>
												<div class="bpm-project-by-right-author">
													<?php echo $owner['first_name'] . ' ' . $owner['last_name']; ?>
													<span class="bpm-project-by-place-right"> <i class="zmdi zmdi-pin"></i> <?php echo $owner['location']; ?></span>
												</div>
											</div>
										<?php endforeach;?>
									</div>
								</div>
								<?php endif; ?>
								<?php if($show_tags):?>	
								<div class="bpm-project-footer-block bpm-footer-basic-info">
									<div class="bpm-footer-block-heading">Tags</div>
									<div class="bpm-footer-content-padding">
									<?php foreach ($b_pr_data['tags'] as $bTag): ?>
									<span class="bpm-footer-tag"><?php echo $bTag; ?></span>
									<?php endforeach; ?>
									</div>
								</div>
								<?php endif; ?>
								<?php if($show_tools_used):?>
								<div class="bpm-project-footer-block bpm-footer-basic-info">
									<div class="bpm-footer-block-heading">Tools Used</div>
									<div class="bpm-footer-content-padding">
									<?php echo substr($bToolsUsed, 2);?> 
									</div>
								</div>
								<?php endif; ?>					
								<?php if($show_copyright_info):?>
								<div class="bpm-footer-copyrights-info">									
									<?php if($license_id != 7):?>
									<div class="bpm-sr-attribution">Attribution</div>
									<?php endif;?> 
									<?php if($license_id < 4 ):?> 
									<div class="bpm-sr-noncommercial">Non Commercial</div>
									<?php endif; ?>
									<?php if($license_id == 1 || $license_id ==4):?>
									<div class="bpm-sr-noderivatives">No Derivatives</div>
									<?php endif;?>
									<?php if($license_id == 2 || $license_id ==5):?>
									<div class="bpm-sr-sharealike">Share Alike</div>
									<?php endif;?>
									<?php if($license_id == 7):?>
									<div class="bpm-sr-zero">No Use</div>
									<?php endif; ?>									
								</div>
								<?php endif; ?>
								<div class="bpm-report-project">
								 	<a href="https://help.behance.net/hc/en-us/requests/new" target="_blank"><i class="zmdi zmdi-alert-triangle"></i> Report</a>
								</div>
							</div>					
						</div>
					</div>
					<?php if($show_project_sidebar): ?>
					<div id="bop-project-right">
						<div class="sidebar-group">
							<?php if($show_project_by):?>
							<div id="bop-project-info-right" class="bop-project-right">
								<div class="bpm-title-right">Credits</div>
								<div class="bpm-project-by-right-wrapper">
									<?php foreach($b_pr_data['owners'] as $owner) : ?>
										<div class="bpm-project-by-right">
											<div class="bpm-project-by-right-image">																							
												<?php
													$lastKey = 0; 
													$ownerImg = ""; 
													foreach($owner['images'] as $imKey => $imValue){
														if($lastKey < intval($imKey)){
															$lastKey = $imKey;
															$ownerImg = $imValue;	
														}														
													}
												?>												
												<img src="<?php echo $ownerImg; ?>" />												
											</div>
											<div class="bpm-project-by-right-author">
												<?php echo $owner['first_name'] . ' ' . $owner['last_name']; ?>
												<span class="bpm-project-by-place-right"> <i class="zmdi zmdi-pin"></i> <?php echo $owner['location']; ?></span>
											</div>
										</div>
									<?php endforeach;?>
								</div>
							</div>
							<?php endif; ?>							
							<?php if($show_project_details_wrapper || $show_publish_date):?>
							<div id="bop-project-about-right" class="bop-project-right">
								<?php if($show_project_title):?>
								<div class="bpm-title-right"><?php echo $b_pr_data['name']; ?></div>
								<?php endif;?>	
								<?php if($show_creative_fields):?>
								<div id="bop-category"><?php echo substr($bFields, 2);?></div>
								<?php endif; ?>	
								<div id="stats-top">
									<?php if($show_views):?>
									<span class="stats-top-project-views"><i class="zmdi zmdi-eye zmd-lg"></i> <?php echo $b_pr_data['stats']['views'] ; ?>  </span>
									<?php endif; ?>
									<?php if($show_appreciations):?>
									<span class="stats-top-project-appreciations"><i class="zmdi zmdi-thumb-up zmd-lg"></i> <?php echo $b_pr_data['stats']['appreciations'] ; ?>  </span>
									<?php endif; ?>
									<?php if($show_comments):?> 
									<span class="stats-top-project-comments"><i class="zmdi zmdi-comment-alt zmd-lg"></i> <?php echo $b_pr_data['stats']['comments'] ; ?>  </span>
									<?php endif; ?>	
								</div>
								<?php if($show_publish_date):?> 
								<div class="bpm-published-on">Published: <?php echo date('M d, Y', $b_pr_data['published_on']); ?></div>
								<?php endif;?>						
							</div>
							<?php endif; ?>							
							<?php if($show_tools_used):?>
							<div id="bop-project-info-right" class="bop-project-right">
								<div class="bpm-title-right">Tools Used</div>
								<p><?php echo substr($bToolsUsed, 2);?></p> 
							</div>
							<?php endif; ?>	
							<?php if($show_project_details_wrapper && $show_project_info_wrapper):?>							
							<div class="bpm-top-info-menu-dropdown-wrapper">
								<nav class="bpm-top-info-nav">
									<ul>
										<?php if($show_tools_used):?>
										<li>
											<a href="#"><i class="zmdi zmdi-info-outline zmd-lg"></i>Tools Used</a>
											<ul class="fallback">
												<li><?php echo substr($bToolsUsed, 2);?></li>
											</ul>
										</li>
										<?php endif; ?>
										<?php if($show_about_project):?>		
										<li>
											<a href="#"><i class="zmdi zmdi-wrench zmd-lg"></i>About</a>
											<ul class="fallback">
												<li><?php echo $b_pr_data['description']; ?> </li>
											</ul>
										</li>
										<?php endif; ?>
										<?php if($show_project_by):?>
										<li>
											<a href="#"><i class="zmdi zmdi-account zmd-lg"></i>Credits</a>
											<ul class="fallback bpm-project-by-small">
												<div class="bpm-project-by-right-wrapper">
													<?php foreach($b_pr_data['owners'] as $owner) : ?>
														<div class="bpm-project-by-right">
															<div class="bpm-project-by-right-image">																							
																<?php
																	$lastKey = 0; 
																	$ownerImg = ""; 
																	foreach($owner['images'] as $imKey => $imValue){
																		if($lastKey < intval($imKey)){
																			$lastKey = $imKey;
																			$ownerImg = $imValue;	
																		}														
																	}
																?>												
																<img src="<?php echo $ownerImg; ?>" />												
															</div>
															<div class="bpm-project-by-right-author">
																<?php echo $owner['first_name'] . ' ' . $owner['last_name']; ?>
																<span class="bpm-project-by-place-right"> <i class="zmdi zmdi-pin"></i> <?php echo $owner['location']; ?></span>
															</div>
														</div>
													<?php endforeach;?>
												</div>
											</ul>
										</li>
										<?php endif; ?>
									</ul>
								</nav>
							</div>								
							<?php endif; ?>							
						</div>
					</div>
					<?php endif; ?>
				</div>
			</div>	
		</div>
	</div>
	<?php if($show_prev_next_btn && 
			( isset($prev_project) || isset($next_project) ) && 
			( $prev_next_btn_position == 'both' || $prev_next_btn_position == 'bottom')):?>
	<div class="bop-navigation  <?php echo $prev_next_btn_style; ?>">		
		<?php if($enable_pretty_url):?>
			<?php if(is_front_page() && !is_home()):?>
				<?php if(isset($prev_project)): ?>
					<a class="bop-navigation-prev <?php echo $prev_additional_class; ?>" href="<?php echo $siteUrl."?p=".$currentPost->ID."&ch_eds_bpid=".$prev_project->id; ?>">
						<?php echo $prev_btn_icon; ?>
						<?php echo $prev_btn_text; ?>
					</a>
				<?php endif; ?>
				<?php if(isset($next_project)): ?>
					<a class="bop-navigation-next <?php echo $next_additional_class; ?>" href="<?php echo $siteUrl."?p=".$currentPost->ID."&ch_eds_bpid=".$next_project->id; ?>">
						<?php echo $next_btn_icon; ?>
						<?php echo $next_btn_text; ?>
					</a>
				<?php endif; ?>
			<?php else:?>
				<?php 
					$tempLink = get_permalink($currentPost->ID);
					$prevUrl = '';
					$nextUrl = '';
					if( substr($tempLink,-1) == '/' ) {
						$prevUrl = $tempLink . "bproject/";
						$nextUrl = $tempLink . "bproject/";
					} else {
						$prevUrl = $tempLink . "/bproject/";
						$nextUrl = $tempLink . "/bproject/";
					}
				?>
				<?php if(isset($prev_project)): ?>
					<a class="bop-navigation-prev <?php echo $prev_additional_class; ?>" href="<?php echo $prevUrl.$prev_project->slug; ?>">
						<?php echo $prev_btn_icon; ?>
						<?php echo $prev_btn_text; ?>
					</a>
				<?php endif; ?>
				<?php if(isset($next_project)): ?>
					<a class="bop-navigation-next <?php echo $next_additional_class; ?>" href="<?php echo $nextUrl.$next_project->slug; ?>">
						<?php echo $next_btn_icon; ?>
						<?php echo $next_btn_text; ?>
					</a>
				<?php endif; ?>
			<?php endif; ?>			
		<?php else: ?>
			<?php if(is_front_page() && !is_home()):?>
				<?php if(isset($prev_project)): ?>
					<a class="bop-navigation-prev <?php echo $prev_additional_class; ?>" href="<?php echo $siteUrl."?p=".$currentPost->ID."&ch_eds_bpid=".$prev_project->id; ?>">
						<?php echo $prev_btn_icon; ?>
						<?php echo $prev_btn_text; ?>
					</a>
				<?php endif; ?>
				<?php if(isset($next_project)): ?>
					<a class="bop-navigation-next <?php echo $next_additional_class; ?>" href="<?php echo $siteUrl."?p=".$currentPost->ID."&ch_eds_bpid=".$next_project->id; ?>">
						<?php echo $next_btn_icon; ?>
						<?php echo $next_btn_text; ?>
					</a>
				<?php endif; ?>
			<?php else: ?>
				<?php if(isset($prev_project)): ?>
					<a class="bop-navigation-prev <?php echo $prev_additional_class; ?>" href="<?php echo $siteUrl."?p=".$currentPost->ID."&eds_bpid=".$prev_project->id; ?>">
						<?php echo $prev_btn_icon; ?>
						<?php echo $prev_btn_text; ?>
					</a>
				<?php endif; ?>
				<?php if(isset($next_project)): ?>
					<a class="bop-navigation-next <?php echo $next_additional_class; ?>" href="<?php echo $siteUrl."?p=".$currentPost->ID."&eds_bpid=".$next_project->id; ?>">
						<?php echo $next_btn_icon; ?>
						<?php echo $next_btn_text; ?>
					</a>
				<?php endif; ?>			
			<?php endif; ?>			
		<?php endif; ?>		
	</div>
	<?php endif; ?>
</div>