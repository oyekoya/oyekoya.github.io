<!doctype html>
<html  lang="en" >
    <head>        
        <meta charset="utf-8">
        <title><?php _e('Portfolio Manager - Layout Generator','eds-bpm'); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__).'../css/font-awesome.min.css'; ?>" />
		<link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__).'../css/bootstrap.min.css'; ?>" />
		<link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__).'../css/bootstrap-switch.min.css'; ?>" />
		<link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__).'../css/eds-bpm-loading.css'; ?>" />
		<style type="text/css">
			.bootstrap-switch{
				height:2.5em;
			}
		</style>	
		<style type="text/css">
			.eds-bpm-mc-tab-id{
				cursor :pointer;
			}
		</style>           
		<script language="javascript" type="text/javascript" src="<?php echo get_site_url() . '/wp-includes/js/tinymce/tiny_mce_popup.js'; ?>"></script>     
    </head>
    <body onLoad="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';" dir="ltr">
    	<div id="eds-bpm-load" class="eds-bpm-page-load-wrapper" style="display:none;">
			<div class="eds-bpm-loading"></div>
		</div>
		<div class="container-fluid">			
			<form name="edsbportman_form" id="edsbportman_form" class="form-horizontal">
				<div class="form-group">
					<label class="col-sm-4 control-label" for="layout-type"><?php _e('Layout Type' , 'eds-bpm'); ?></label>
					<div class="col-sm-3">							
						<select class="form-control" id="layout-type" name="layout-type">
							<option value=""><?php _e('--Select--', 'eds-bpm');?></option>
							<option value="single_project"><?php _e('Single Project', 'eds-bpm');?></option>
							<option value="single_cat"><?php _e('Single Category', 'eds-bpm');?></option>
							<option value="multi_cat"><?php _e('Multiple Categories', 'eds-bpm');?></option>
						</select>			
					</div> 								
				</div>
				<div class="form-group eds-bpm-dynamic-field eds-bpm-sp-atr-wrap">
					<label class="col-sm-4 control-label" for="project-list"><?php _e('Project', 'eds-bpm');?></label>
					<div class="col-sm-3">							
						<select class="form-control" id="project-list" name="project-list">									
						</select>			
					</div> 								
				</div>
				<div class="form-group eds-bpm-dynamic-field eds-bpm-sc-atr-wrap">
					<label class="col-sm-4 control-label" for="category-list"><?php _e('Category', 'eds-bpm');?></label>
					<div class="col-sm-3">							
						<select class="form-control" id="category-list" name="category-list">									
						</select>			
					</div> 								
				</div>
				
				<div class="form-group eds-bpm-dynamic-field eds-bpm-mc-atr-wrap">
					<label class="col-sm-4 control-label" for="multi-category-list"><?php _e('Categories', 'eds-bpm');?></label>
					<div class="col-sm-3">							
						<select class="form-control" id="multi-category-list" name="multi-category-list" size="5" multiple >									
						</select>			
					</div> 								
				</div>
				
				
				
				<div class="form-group eds-bpm-dynamic-field eds-bpm-mc-atr-wrap">
					<label class="col-sm-4 control-label" for="mc-basic-settings"><h3><?php _e('Basic Settings','eds-bpm');?>:</h3></label>						
				</div>
				
				<div class="form-group eds-bpm-dynamic-field eds-bpm-mc-atr-wrap eds-bpm-sc-atr-wrap">
					<label class="col-sm-4 control-label" for="mc-show-featured-only"><?php _e('Show Only Featured', 'eds-bpm');?></label>
					<div class="col-sm-3">							
						<input
							 data-on-text="YES"
			 				data-off-text="NO"
			 				data-size ="small"
							type="checkbox"			
							class="eds-bpm-layout-switches form-control" 
							name="mc-show-featured-only"
							id = "mc-show-featured-only"
							value="yes" />			
					</div> 								
				</div>
				
				<div class="form-group eds-bpm-dynamic-field eds-bpm-mc-atr-wrap eds-bpm-sc-atr-wrap">
					<label class="col-sm-4 control-label" for="mc-mosaic-style"><?php _e('Mosaic Style', 'eds-bpm');?></label>
					<div class="col-sm-3">							
						<select class="form-control" id="mc-mosaic-style" name="mc-mosaic-style">		
							<option value="one"><?php _e('Style 1', 'eds-bpm');?></option>
							<option value="two"><?php _e('Style 2', 'eds-bpm');?></option>
							<option value="three"><?php _e('Style 3', 'eds-bpm');?></option>
							<option value="four"><?php _e('Style 4', 'eds-bpm');?></option>
							<option value="five"><?php _e('Style 5', 'eds-bpm');?></option>							
						</select>			
					</div> 								
				</div>
				
				<div class="form-group eds-bpm-dynamic-field eds-bpm-mc-atr-wrap eds-bpm-sc-atr-wrap">
					<label class="col-sm-4 control-label" for="mc-tile-margin"><?php _e('Margin between Tiles (in pixel)', 'eds-bpm');?></label>
					<div class="col-sm-3">							
						<input
							type="text"			
							class="form-control"
							name="mc-tile-margin"
							id="mc-tile-margin"
							value="20" />			
					</div> 								
				</div>
				
				<div class="form-group eds-bpm-dynamic-field eds-bpm-sc-atr-wrap">
					<label class="col-sm-4 control-label" for="sc-show-cat-title"><?php _e('Show Category Title', 'eds-bpm');?></label>
					<div class="col-sm-3">							
						<input
							 data-on-text="YES"
			 				data-off-text="NO"
			 				data-size ="small"
							type="checkbox"			
							class="eds-bpm-layout-switches form-control" 
							name="sc-show-cat-title"
							id="sc-show-cat-title"
							value="yes" />			
					</div> 								
				</div>
				
				<div class="form-group eds-bpm-dynamic-field eds-bpm-sc-atr-wrap">
					<label class="col-sm-4 control-label" for="sc-show-cat-desc"><?php _e('Show Category Description', 'eds-bpm');?></label>
					<div class="col-sm-3">							
						<input
							 data-on-text="YES"
			 				data-off-text="NO"
			 				data-size ="small"
							type="checkbox"			
							class="eds-bpm-layout-switches form-control" 
							name="sc-show-cat-desc"
							id = "sc-show-cat-desc"
							value="yes" />			
					</div> 								
				</div>
				
				<div class="form-group eds-bpm-dynamic-field eds-bpm-sc-atr-wrap">
					<label class="col-sm-4 control-label" for="sc-show-cat-img"><?php _e('Show Category Image', 'eds-bpm');?></label>
					<div class="col-sm-3">							
						<input
							 data-on-text="YES"
			 				data-off-text="NO"
			 				data-size ="small"
							type="checkbox"			
							class="eds-bpm-layout-switches form-control" 
							name="sc-show-cat-img"
							id = "sc-show-cat-img"
							value="yes" />			
					</div> 								
				</div>
				
				
				<div class="form-group eds-bpm-dynamic-field eds-bpm-mc-atr-wrap eds-bpm-sc-atr-wrap">
					<label class="col-sm-4 control-label" for="mc-mosaic-order-by"><?php _e('Order By', 'eds-bpm');?></label>
					<div class="col-sm-3">							
						<select class="form-control" id="mc-mosaic-order-by" name="mc-mosaic-order-by">		
							<option value="id"><?php _e('Default', 'eds-bpm');?></option>
							<option value="b_project_name"><?php _e('Project Name', 'eds-bpm');?></option>
							<option value="b_create_date"><?php _e('Creation Date on Behance', 'eds-bpm');?></option>														
						</select>			
					</div> 								
				</div>
				
				<div class="form-group eds-bpm-dynamic-field eds-bpm-mc-atr-wrap eds-bpm-sc-atr-wrap">
					<label class="col-sm-4 control-label" for="mc-mosaic-ordering"><?php _e('Ordering', 'eds-bpm');?></label>
					<div class="col-sm-3">							
						<select class="form-control" id="mc-mosaic-ordering" name="mc-mosaic-ordering">		
							<option value="asc"><?php _e('Ascending', 'eds-bpm');?></option>
							<option value="desc"><?php _e('Descending', 'eds-bpm');?></option>														
						</select>			
					</div> 								
				</div>
				
				
				
				<div class="form-group eds-bpm-dynamic-field eds-bpm-mc-atr-wrap">
					<label class="col-sm-4 control-label" for="mc-tab-settings"><h3><?php _e('Tab Settings','eds-bpm');?>:</h3></label>					
				</div>
				
				<div class="form-group eds-bpm-dynamic-field eds-bpm-mc-atr-wrap">
					<label class="col-sm-4 control-label" for="mc-tab-ubc"><?php _e('Unselected Background Color', 'eds-bpm');?></label>
					<div class="col-sm-2">
						<div class=" input-group">													
							<input
								type="text"		
								class = "form-control eds-bpm-mc-tab-cp"					
								name="mc-tab-ubc"
								id="mc-tab-ubc"
								value="#e1e1e1" 
								readonly
								/>		
							<div class="input-group-addon eds-bpm-mc-tab-id">
								<i class="fa fa-eyedropper"></i>
							</div>	
						</div>
					</div> 								
				</div>
				<div class="form-group eds-bpm-dynamic-field eds-bpm-mc-atr-wrap">
					<label class="col-sm-4 control-label" for="mc-tab-utc"><?php _e('Unselected Text Color', 'eds-bpm');?></label>
					<div class="col-sm-2">
						<div class="input-group">							
							<input
								type="text"		
								class = "form-control eds-bpm-mc-tab-cp"					
								name="mc-tab-utc"
								id="mc-tab-utc"
								value="#252c33" 
								readonly
								/>	
							<div class="input-group-addon eds-bpm-mc-tab-id">
								<i class="fa fa-eyedropper"></i>
							</div>		
						</div>
					</div> 								
				</div>
				<div class="form-group eds-bpm-dynamic-field eds-bpm-mc-atr-wrap">
					<label class="col-sm-4 control-label" for="mc-tab-sbc"><?php _e('Selected Background Color', 'eds-bpm');?></label>
					<div class="col-sm-2">
						<div class=" input-group">							
						<input
							type="text"		
							class = "form-control eds-bpm-mc-tab-cp"					
							name="mc-tab-sbc"
							id="mc-tab-sbc"
							value="#afafaf" 
							readonly
							/>	
						<div class="input-group-addon eds-bpm-mc-tab-id">
								<i class="fa fa-eyedropper"></i>
							</div>		
						</div>
					</div> 								
				</div>
				<div class="form-group eds-bpm-dynamic-field eds-bpm-mc-atr-wrap">
					<label class="col-sm-4 control-label" for="mc-tab-stc"><?php _e('Selected Text Color', 'eds-bpm');?></label>
					<div class="col-sm-2">
						<div class="input-group">							
							<input
								type="text"		
								class = "form-control eds-bpm-mc-tab-cp"					
								name="mc-tab-stc"
								id="mc-tab-stc"
								value="#ffffff" 
								readonly
								/>	
							<div class="input-group-addon eds-bpm-mc-tab-id">
								<i class="fa fa-eyedropper"></i>
							</div>		
						</div>
					</div> 								
				</div>
				<div class="form-group eds-bpm-dynamic-field eds-bpm-mc-atr-wrap">
					<label class="col-sm-4 control-label" for="mc-tab-hbc"><?php _e('Hover Background Color', 'eds-bpm');?></label>
					<div class="col-sm-2">
						<div class="input-group">							
							<input
								type="text"		
								class = "form-control eds-bpm-mc-tab-cp"					
								name="mc-tab-hbc"
								id="mc-tab-hbc"
								value="#c9c9c9" 
								readonly
								/>
							<div class="input-group-addon eds-bpm-mc-tab-id">
								<i class="fa fa-eyedropper"></i>
							</div>
						</div>			
					</div> 								
				</div>
				<div class="form-group eds-bpm-dynamic-field eds-bpm-mc-atr-wrap">
					<label class="col-sm-4 control-label" for="mc-tab-htc"><?php _e('Hover Text Color', 'eds-bpm');?></label>
					<div class="col-sm-2 ">
						<div class="input-group">
													
						<input
							type="text"		
							class = "form-control eds-bpm-mc-tab-cp"					
							name="mc-tab-htc"
							id="mc-tab-htc"
							value="#252c33" 
							readonly
							/>	
						<div class="input-group-addon eds-bpm-mc-tab-id">
								<i class="fa fa-eyedropper"></i>
							</div>		
						</div>
					</div> 								
				</div>	
				
				<div class="form-group eds-bpm-dynamic-field" id="eds-bpm-button-wrapper">
					<label class="col-sm-4 control-label" for="eds-bpm-button"></label>
					<div class="col-sm-3">							
						<button class="btn btn-primary insert-btn">Insert</button>
						<button class="btn btn-default" onclick="tinyMCEPopup.close();">Cancel</button>				
					</div> 								
				</div>	
				
			</form>
		</div>	
    	<script type="text/javascript">    	    	
			var args = top.tinymce.activeEditor.windowManager.getParams();
			var url = args['plugin_url'];
			var ajaxUrl = args['ajaxurl'];
			var jQuery = args['jquery'];
		</script>
				
		<script src="<?php echo plugin_dir_url(__FILE__).'../js/bootstrap-switch.min.js'; ?>"></script>
				
		<script type="text/javascript">
			function get_json_data($, layoutType){				
				$.find("#eds-bpm-load").show();
				var data = {
					'action': 'eds_bpm_get_layout_data',
					'layout-type': layoutType
				};			
				var response = jQuery.ajax({
					type: "POST",
					url: ajaxUrl,
					data: data,
					async: false
				}).responseText;
								
				$.find("#eds-bpm-load").hide();					
				
				return jQuery.parseJSON(response);
			}


			function insertEDSBPortMan($){
								
					var shortCode = "[edsbportman ";
					var layoutType = $.find("#layout-type").val();
					shortCode = shortCode + "layout_type=\"" + layoutType +"\" ";
		
					if(layoutType == 'single_project'){
						var id = $.find("#project-list").val();
						shortCode = shortCode + "id=\"" + id +"\" ";
					}else if(layoutType == 'single_cat'){
						
						var id = $.find("#category-list").val();
						shortCode = shortCode + "id=\"" + id +"\" ";

						if($.find("#mc-show-featured-only").is(':checked'))
							shortCode = shortCode + "featured=\"y\" ";
						else
							shortCode = shortCode + "featured=\"n\" ";
						
						var mosaic_style= $.find("#mc-mosaic-style").val();
						shortCode = shortCode + "mosaic_style=\"" + mosaic_style +"\" ";

						var tile_margin = $.find("#mc-tile-margin").val();
						shortCode = shortCode + "tile_margin=\"" + tile_margin +"\" ";
				
						if($.find("#sc-show-cat-title").is(':checked'))
							shortCode = shortCode + "sct=\"y\" ";
						else
							shortCode = shortCode + "sct=\"n\" ";

						if($.find("#sc-show-cat-desc").is(':checked'))
							shortCode = shortCode + "scd=\"y\" ";
						else
							shortCode = shortCode + "scd=\"n\" ";

						if($.find("#sc-show-cat-img").is(':checked'))
							shortCode = shortCode + "sci=\"y\" ";
						else
							shortCode = shortCode + "sci=\"n\" ";

						shortCode = shortCode + "order_by=\"" + $.find("#mc-mosaic-order-by").val() +"\" ";

						shortCode = shortCode + "ordering=\"" + $.find("#mc-mosaic-ordering").val() +"\" ";
						
					}else if(layoutType == 'multi_cat'){
						var id = "";
						 $.find("#multi-category-list option:selected" ).each(function() {
							 id += "," + $.find( this ).val() ;
						 });
						shortCode = shortCode + "id=\"" + id.substring(1) +"\" ";

						if($.find("#mc-show-featured-only").is(':checked'))
							shortCode = shortCode + "featured=\"y\" ";
						else
							shortCode = shortCode + "featured=\"n\" ";

						var mosaic_style= $.find("#mc-mosaic-style").val();
						shortCode = shortCode + "mosaic_style=\"" + mosaic_style +"\" ";

						var tile_margin = $.find("#mc-tile-margin").val();
						shortCode = shortCode + "tile_margin=\"" + tile_margin +"\" ";

						shortCode = shortCode + "tab_ubc=\"" + $.find("#mc-tab-ubc").val() +"\" ";
						shortCode = shortCode + "tab_utc=\"" + $.find("#mc-tab-utc").val() +"\" ";
						shortCode = shortCode + "tab_sbc=\"" + $.find("#mc-tab-sbc").val() +"\" ";
						shortCode = shortCode + "tab_stc=\"" + $.find("#mc-tab-stc").val() +"\" ";
						shortCode = shortCode + "tab_hbc=\"" + $.find("#mc-tab-hbc").val() +"\" ";
						shortCode = shortCode + "tab_htc=\"" + $.find("#mc-tab-htc").val() +"\" ";			

						shortCode = shortCode + "order_by=\"" + $.find("#mc-mosaic-order-by").val() +"\" ";

						shortCode = shortCode + "ordering=\"" + $.find("#mc-mosaic-ordering").val() +"\" ";		
					}
					shortCode += "]";

					tinyMCEPopup.editor.execCommand('mceInsertContent', false, shortCode);
					tinyMCEPopup.close();
			}
				

			(function($){
				$.ready(function(){	

					$.find('.eds-bpm-layout-switches').bootstrapSwitch();	

					$.find('.eds-bpm-mc-tab-cp').click(function(e){
						var obj = $.find(this);
						tinyMCEPopup.pickColor(e, obj.attr("id"));
						
					});

					$.find('.eds-bpm-mc-tab-id').click(function(e){
						var obj = $.find(this);
						tinyMCEPopup.pickColor(e, obj.siblings("input").attr("id"));					
					});

					$.find(".eds-bpm-dynamic-field").hide();
													
					$.find("#layout-type").change(function(){					
						var obj = $.find(this);
						var layoutType = obj.val();

						$.find(".eds-bpm-dynamic-field").hide();
						
						if(layoutType != ''){
																											
							var data= get_json_data($, layoutType);
							
							if(layoutType == 'single_project'){
								
								$.find("#project-list").empty();
								jQuery.each(data ,function(key , project){
									$.find("#project-list").append(
										jQuery("<option />").val(project.id).text(project.name)
									);							  
								});
								$.find(".eds-bpm-sp-atr-wrap").show();
								$.find("#eds-bpm-button-wrapper").show();
																
							}else if(layoutType == 'single_cat'){
								$.find("#category-list").empty();
								jQuery.each(data,function(key , category){
									$.find("#category-list").append(
										jQuery("<option />").val(category.id).text(category.name)
									);							  
								});
								$.find(".eds-bpm-sc-atr-wrap").show();
								$.find("#eds-bpm-button-wrapper").show();
								
							}else if(layoutType == 'multi_cat'){
								$.find("#multi-category-list").empty();		
								$.find("#multi-category-list").append(
										jQuery("<option selected=\"selected\" />").val('-1').text('All')
								);
								jQuery.each(data,function(key,category){
									$.find("#multi-category-list").append(
										jQuery("<option />").val(category.id).text(category.name)
									);							  
								});
								$.find(".eds-bpm-mc-atr-wrap").show();
								$.find("#eds-bpm-button-wrapper").show();							
							}																
						}
					});


					$.find(".insert-btn").click(function(e){
						insertEDSBPortMan($);
					});
				});								
			})(jQuery(document));
    	</script>
    </body>
</html>