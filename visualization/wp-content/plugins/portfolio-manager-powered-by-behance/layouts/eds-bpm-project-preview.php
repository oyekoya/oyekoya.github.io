<?php
	if ( ! defined( 'WPINC' ) ) {
		die;
	}
	
	$b_tools_used = "";
	foreach ($b_pr_data['tools'] as $tool){
		$b_tools_used .= ", " . $tool['title'];
	}
	
	$license_id = intval($b_pr_data['copyright']['license_id']);

	//	Localizing admin javascript
	wp_localize_script( 'eds-bpm-admin-js', 'eds_bpm_view', 'edit' );
	wp_localize_script( 'eds-bpm-admin-js', 'eds_bpm_custom_css', $customCSS );
	wp_localize_script( 'eds-bpm-admin-js', 'eds_bpm_css_url',  plugin_dir_url(__FILE__).'../css/');

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
									<?php if(isset($bModule['caption'])): ?>
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
								<div class="bpm-project-footer-block bpm-footer-basic-info">							
									<div class="bpm-footer-block-heading">Basic Info</div>
									<div class="bpm-footer-content-padding">							
										<?php echo $b_pr_data['description']; ?>
									</div>									 
									<div class="bpm-footer-published-on">Published: <?php echo date('M d, Y', $b_pr_data['published_on']); ?></div>									
								</div>								
								<div class="bpm-project-footer-block bpm-footer-project-by">
									<div class="bpm-footer-block-heading">Credits</div>
									<div class="bpm-project-by-right-wrapper">
										<?php foreach($b_pr_data['owners'] as $owner) : ?>
											<div class="bpm-project-by-right">
												<div class="bpm-project-by-right-image">																							
													<?php
														$last_key = 0; 
														$owner_img = ""; 
														foreach($owner['images'] as $im_key => $im_value){
															if($last_key < intval($im_key)){
																$last_key = $im_key;
																$owner_img = $im_value;	
															}														
														}
													?>												
													<img src="<?php echo $owner_img; ?>" />												
												</div>
												<div class="bpm-project-by-right-author">
													<?php echo $owner['first_name'] . ' ' . $owner['last_name']; ?>
													<span class="bpm-project-by-place-right"> <i class="zmdi zmdi-pin"></i> <?php echo $owner['location']; ?></span>
												</div>
											</div>
										<?php endforeach;?>
									</div>
								</div>						
								<div class="bpm-project-footer-block bpm-footer-basic-info">
									<div class="bpm-footer-block-heading">Tags</div>
									<div class="bpm-footer-content-padding">
									<?php foreach ($b_pr_data['tags'] as $b_tag): ?>
									<span class="bpm-footer-tag"><?php echo $b_tag; ?></span>
									<?php endforeach; ?>
									</div>
								</div>								
								<div class="bpm-project-footer-block bpm-footer-basic-info">
									<div class="bpm-footer-block-heading">Tools Used</div>
									<div class="bpm-footer-content-padding">
										<?php echo substr($b_tools_used, 2);?> 
									</div>
								</div>
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
								<div class="bpm-report-project">
								 	<a href="https://help.behance.net/hc/en-us/requests/new" target="_blank"><i class="zmdi zmdi-alert-triangle"></i> Report</a>
								</div>						
							</div>					
						</div>
					</div>
					<div id="bop-project-right">
						<div class="sidebar-group">							
							<div id="bop-project-info-right" class="bop-project-right">
								<div class="bpm-title-right">Credits</div>
								<div class="bpm-project-by-right-wrapper">
									<?php foreach($b_pr_data['owners'] as $owner) : ?>
										<div class="bpm-project-by-right">
											<div class="bpm-project-by-right-image">																							
												<?php
													$last_key = 0; 
													$owner_img = ""; 
													foreach($owner['images'] as $im_key => $im_value){
														if($last_key < intval($im_key)){
															$last_key = $im_key;
															$owner_img = $im_value;	
														}														
													}
												?>												
												<img src="<?php echo $owner_img; ?>" />												
											</div>
											<div class="bpm-project-by-right-author">
												<?php echo $owner['first_name'] . ' ' . $owner['last_name']; ?>
												<span class="bpm-project-by-place-right"> <i class="zmdi zmdi-pin"></i> <?php echo $owner['location']; ?></span>
											</div>
										</div>
									<?php endforeach;?>
								</div>
							</div>							
							<div id="bop-project-about-right" class="bop-project-right">																
								<div class="bpm-title-right"><?php echo $b_pr_data['name']; ?></div>
								<div id="bop-category"><?php echo substr($b_fields, 2);?></div>	
								<div id="stats-top">							
									<span class="stats-top-project-views"><i class="zmdi zmdi-eye zmd-lg"></i> <?php echo $b_pr_data['stats']['views'] ; ?>  </span>						
									<span class="stats-top-project-appreciations"><i class="zmdi zmdi-thumb-up zmd-lg"></i> <?php echo $b_pr_data['stats']['appreciations'] ; ?>  </span>						 
									<span class="stats-top-project-comments"><i class="zmdi zmdi-comment-alt zmd-lg"></i> <?php echo $b_pr_data['stats']['comments'] ; ?>  </span>								
								</div>					 
								<div class="bpm-published-on">Published: <?php echo date('M d, Y', $b_pr_data['published_on']); ?></div>								
							</div>						
							<div id="bop-project-info-right" class="bop-project-right">
								<div class="bpm-title-right">Tools Used</div>
								<p><?php echo substr($b_tools_used, 2);?></p> 
							</div>		
							<div class="bpm-top-info-menu-dropdown-wrapper">
								<nav class="bpm-top-info-nav">
									<ul>							
										<li>
											<a href="#"><i class="zmdi zmdi-info-outline zmd-lg"></i>Tools Used</a>
											<ul class="fallback">
												<li><?php echo substr($b_tools_used, 2);?></li>
											</ul>
										</li>							
										<li>
											<a href="#"><i class="zmdi zmdi-wrench zmd-lg"></i>About</a>
											<ul class="fallback">
												<li><?php echo $b_pr_data['description']; ?> </li>
											</ul>
										</li>								
										<li>
											<a href="#"><i class="zmdi zmdi-account zmd-lg"></i>Credits</a>
											<ul class="fallback bpm-project-by-small">
												<div class="bpm-project-by-right-wrapper">
													<?php foreach($b_pr_data['owners'] as $owner) : ?>
														<div class="bpm-project-by-right">
															<div class="bpm-project-by-right-image">																							
																<?php
																	$last_key = 0; 
																	$owner_img = ""; 
																	foreach($owner['images'] as $im_key => $im_value){
																		if($last_key < intval($im_key)){
																			$last_key = $im_key;
																			$owner_img = $im_value;	
																		}														
																	}
																?>												
																<img src="<?php echo $owner_img; ?>" />												
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
									</ul>
								</nav>
							</div>													
						</div>
					</div>
				</div>
			</div>	
		</div>
	</div>
</div>