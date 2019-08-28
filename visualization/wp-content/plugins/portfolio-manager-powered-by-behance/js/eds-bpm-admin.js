
function edsToggleCheckBox(source,entry_name)
{
	checkboxes = document.getElementsByName(entry_name);
	for(var i in checkboxes) 
		checkboxes[i].checked = source.checked;
}
	
function edsIsInt(value) {
	  return !isNaN(value) && (function(x) { return (x | 0) === x; })(parseFloat(value))
}

(function($){
	
	

	$(document).ready(function(){
		
		//Settings related JS
		//Category Color Picker
		$('#project_background_color').wpColorPicker();
		$('#loading_icon_color').wpColorPicker();
		
		$('#prev_btn_text_color').wpColorPicker();
		$('#prev_btn_bg_color').wpColorPicker();
		$('#next_btn_text_color').wpColorPicker();		
		$('#next_btn_bg_color').wpColorPicker();
		
		
		$('.project_attribute_switches').bootstrapSwitch();	
		
		
		//Category page buttons
		
		//Category Image upload
		var custom_uploader;
		$('#cat-icon-upload').click(function(e) {			 
	        e.preventDefault();
	 
	        //If the uploader object has already been created, reopen the dialog
	        if (custom_uploader) {
	            custom_uploader.open();
	            return;
	        }
	 
	        //Extend the wp.media object
	        custom_uploader = wp.media.frames.file_frame = wp.media({
	            title: edsBPMMessages.chooseImage,
	            button: {
	                text: edsBPMMessages.chooseImage
	            },
	            multiple: false
	        });
	 
	        //When a file is selected, grab the URL and set it as the text field's value
	        custom_uploader.on('select', function() {
	            attachment = custom_uploader.state().get('selection').first().toJSON();
	            $('#cat-icon').val(attachment.url);
	            $('#cat-icon-img').prop('src',attachment.url);
	        });
	 
	        //Open the uploader dialog
	        custom_uploader.open();
	 
	    });
		
		
		$("#search-category").click(function(event){
			event.preventDefault();			
			$("input[name=bpm-layout]").val("default");
			$("input[name=bpm-task]").val("search");
			$("#eds_bpm_category").submit();
			
		});
		
		$("#clear-category").click(function(event){
			$("input[name=bpm-layout]").val("default");
			$("input[name=bpm-task]").val("clear");
			$("#eds_bpm_category").submit();	
		});	
		
		$("#bpm-publish-cat").click(function(event){
			event.preventDefault();
			if($("input[name='entries[]']:checked").length)
			{				
				$("input[name=bpm-task]").val("publish");
				$("#eds_bpm_category").submit();				
			}
			else{
				alert(edsBPMMessages.selectCategory);
			}
			
		});
		
		$("#bpm-unpublish-cat").click(function(event){
			event.preventDefault();
			if($("input[name='entries[]']:checked").length)
			{
				$("input[name=bpm-task]").val("unpublish");
				$("#eds_bpm_category").submit();
			}
			else{
				alert(edsBPMMessages.selectCategory);
			}
			
		});
		
		$("#bpm-delete-cat").click(function(event){
			event.preventDefault();
			if($("input[name='entries[]']:checked").length)
			{
				if(confirm(edsBPMMessages.deleteSelectedCategory)){
					$("input[name=bpm-task]").val("delete");
					$("#eds_bpm_category").submit();
				}
			}
			else{
				alert(edsBPMMessages.selectCategory);
			}
			
		});
		
		$("#bpm-trash-cat").click(function(event){
			event.preventDefault();
			if($("input[name='entries[]']:checked").length)
			{
				if(confirm(edsBPMMessages.permanentDeleteSelectedCategory)){
					$("input[name=bpm-task]").val("trash");
					$("#eds_bpm_category").submit();
				}
			}
			else{
				alert(edsBPMMessages.selectCategory);
			}
			
		});	
	
		
		$("#bpm-save-cat").click(function(event){			
			$("input[name=bpm-task]").val("save");
			$("input[name=bpm-layout]").val("default");			
		});
		
		$(".bpm-category-status-link").click(function(event){
			event.preventDefault();
			$status = $(this).attr("current-status");
			
			if($status == 'published'){
				$("input[name=bpm-task]").val("unpublish");
			}else{
				$("input[name=bpm-task]").val("publish");
			}			
			$(this).parent().siblings('.bpm-checkbox-wrapper').find("input[name='entries[]']").prop('checked', true);			
			$("#eds_bpm_category").submit();
			
		});
		
		
		
		//Project related buttons 
		$("#search-projects").click(function(event){
			event.preventDefault();			
			$("input[name=bpm-layout]").val("default");
			$("input[name=bpm-task]").val("search");
			$("#eds_bpm_project").submit();
			
		});
		
		$("#clear-projects").click(function(event){
			$("input[name=bpm-layout]").val("default");
			$("input[name=bpm-task]").val("clear");
			$("#eds_bpm_project").submit();	
		});
	
		$("#bpm-publish-project").click(function(event){
			event.preventDefault();
			if($("input[name='entries[]']:checked").length)
			{			
				$("input[name=bpm-task]").val("publish");
				$("#eds_bpm_project").submit();
			
			}
			else{
				alert(edsBPMMessages.selectOneProject);
			}
			
		});
		
		$("#bpm-unpublish-project").click(function(event){
			event.preventDefault();
			if($("input[name='entries[]']:checked").length)
			{
				$("input[name=bpm-task]").val("unpublish");
				$("#eds_bpm_project").submit();				
			}
			else{
				alert(edsBPMMessages.selectOneProject);
			}
			
		});
		
		$("#bpm-set-featured-project").click(function(event){
			event.preventDefault();
			if($("input[name='entries[]']:checked").length)
			{				
				$("input[name=bpm-task]").val("setfeatured");
				$("#eds_bpm_project").submit();				
			}
			else{
				alert(edsBPMMessages.selectOneProject);
			}
			
		});
		
		$("#bpm-delete-project").click(function(event){
			event.preventDefault();
			if($("input[name='entries[]']:checked").length)
			{
				if(confirm(edsBPMMessages.deleteSelectedProject)){
					$("input[name=bpm-task]").val("delete");
					$("#eds_bpm_project").submit();
				}
			}
			else{
				alert(edsBPMMessages.selectOneProject);
			}
			
		});
		
		$("#bpm-trash-project").click(function(event){
			event.preventDefault();
			if($("input[name='entries[]']:checked").length)
			{
				if(confirm(edsBPMMessages.permanentDeleteSelectedProject)){
					$("input[name=bpm-task]").val("trash");
					$("#eds_bpm_project").submit();
				}
			}
			else{
				alert(edsBPMMessages.selectOneProject);
			}
			
		});
		
		
		$("#bpm-sync-project").click(function(event){
			event.preventDefault();
			if($("input[name='entries[]']:checked").length)
			{
				$("input[name=bpm-task]").val("sync");
				$("#eds_bpm_project").submit();
			}
			else{
				alert(edsBPMMessages.selectOneProject);
			}
			
		});
		
		
		$("#bpm-import-project").click(function(event){
			event.preventDefault();
			$("#bpm-ipm-msg").html("").hide();				
			$("#bpm-ipm-projects").html("");
			$("#bpm-ipm-projects-wrapper").hide();
			$("#bpm-ipm-search").show();
			$(".bpm-ipm-save").hide();
			$(".bpm-ipm-submit").show();
			$("#bpm-ipm").modal({
				backdrop: 'static',
				show: true
			});
		});
		
		$("#bpm-ipm-projects-reset").click(function(event){
			event.preventDefault();
			$("#bpm-ipm-msg").html("").hide();			
			$("#bpm-ipm-projects").html("");
			$("#bpm-ipm-projects-wrapper").hide();
			$(".bpm-ipm-save").hide();
			$(".bpm-ipm-submit").show();
			$("#bpm-ipm-search").show();			
		});		
		
		var updateIPMProjects = function(projects) {
			
			var projectList = $("#bpm-ipm-projects");
			var catSelector =  $("select[name='bpm-ipm-category']");
			var category = catSelector.val();
			
			var projectTemplate =['<div class="bpm-ipm-project">',
									'<div class="bpm-ipm-project-thumb">',
										'<img src="" />',
									'</div>',							
									'<div class="bpm-ipm-project-title">',
									'</div>',
									'<div class="bpm-ipm-project-cat">',
									'</div>',
								'</div>'].join("");
			
			projectList.empty();
			
			$.each(projects, function(index, project ){				
				var catSelectorClone = catSelector.clone(false);
				catSelectorClone.removeClass("form-control");
				catSelectorClone.val(category);				
				var projectWrap = $(projectTemplate);
				projectWrap.attr("data-projectid", project["id"]);
				projectWrap.attr("title", project["name"]);
				if( typeof project["covers"]["404"] != "undefined") {
					projectWrap.find('img').attr("src", project["covers"]["404"]);
				} else if( typeof project["covers"]["230"] != "undefined") {
					projectWrap.find('img').attr("src", project["covers"]["230"]);
				} else if( typeof project["covers"]["202"] != "undefined") {
					projectWrap.find('img').attr("src", project["covers"]["202"]);
				} else if( typeof project["covers"]["115"] != "undefined") {
					projectWrap.find('img').attr("src", project["covers"]["115"]);
				} else {
					projectWrap.find('img').attr("src", project["covers"]["original"]);
				}
				projectWrap.find('.bpm-ipm-project-title').html(project["name"]);				
				projectWrap.find('.bpm-ipm-project-cat').append(catSelectorClone);			
				projectList.append(projectWrap);							
			});
			
		}
		
		function edsImportProjects() {
			var msgWrap = $("#bpm-ipm-msg");
			msgWrap.removeClass("text-danger text-success").html("");
			
			var userId = $("#bpm-ipm-userid").val();
			
			if( userId == "" ) {
				msgWrap.addClass("text-danger");
				msgWrap.html(edsBPMMessages.provideUserId);
				msgWrap.show();
				return;
			} 
			
			msgWrap.addClass("text-success");
			msgWrap.html('<span class="bpm-ipm-msg-lg bpm-ipm-loading">' + edsBPMMessages.importingProjects + '</span>');
			msgWrap.show();
			$("#bpm-ipm-search").hide();
			
			var data = {
				'action': 'eds_bpm_import_projects',
				'user_id': userId
			};			
			
			jQuery.ajax({
				type: "POST",
				url: edsBPMParam.ajaxurl,
				data: data,
				async: true,
				success: function(responseText, status) {
					/*console.log(responseText);*/
					var response =  $.parseJSON(responseText);
					var projects = response['projects'];
					if( projects && projects.length ) {						
						msgWrap.hide();						
						$("#bpm-ipm-projects-wrapper-heading").html(projects.length + " " + edsBPMMessages.projectsImported)						
						updateIPMProjects(projects);
						$("#bpm-ipm-projects-wrapper").show();						
						$(".bpm-ipm-save").show();
						$(".bpm-ipm-submit").hide();
					} else {						
						msgWrap.removeClass("text-success").addClass("text-danger");
						msgWrap.html(edsBPMMessages.unableImportingProjects);
						msgWrap.show();
						$("#bpm-ipm-projects-wrapper").hide();
						$("#bpm-ipm-search").show();
						$(".bpm-ipm-save").hide();
						$(".bpm-ipm-submit").show();
					}									
				},
				error: function(obj, msg, error){	
					console.log(error);
					msgWrap.removeClass("text-success").addClass("text-danger");
					msgWrap.html(edsBPMMessages.problemImportingProjects);
					msgWrap.show();
					$("#bpm-ipm-projects-wrapper").hide();
					$("#bpm-ipm-search").show();
					$(".bpm-ipm-save").hide();
					$(".bpm-ipm-submit").show();
				}
			});	
		}
		
		$(".bpm-ipm-submit").click(function(event){
			event.preventDefault();	
			edsImportProjects();				
		});		

		$(".bpm-ipm-control").keypress(function(e) {
			if( e.which == 13) {
				e.preventDefault();
				edsImportProjects();
			}
		});
		
		
		$(".bpm-ipm-save").click(function(event){
			event.preventDefault();
		
			var msgWrap = $("#bpm-ipm-msg");			
			msgWrap.removeClass("text-danger text-success").html("");			
			
			if( !$(".bpm-ipm-project").length) {
				msgWrap.removeClass("text-success").addClass("text-danger");
				msgWrap.html(edsBPMMessages.noProjectAvailable);
				msgWrap.show();
				return;
			}			
			
			var projectCatMap = {};
			
			$(".bpm-ipm-project").each(function(index){
				var projectId = $(this).attr("data-projectid");
				var category = $(this).find("select").val();
				projectCatMap[projectId] = category;
			});
			
			/*console.log(projectCatMap );*/
			
			msgWrap.removeClass("text-danger").addClass("text-success");
			msgWrap.html('<span class="bpm-ipm-msg-lg bpm-ipm-loading">' + edsBPMMessages.savingProjects + '</span>');
			msgWrap.show();	
			
			$("#bpm-ipm-projects-wrapper").hide();	
							
			var data = {
				'action': 'eds_bpm_save_imported_projects',				
				'mappings': projectCatMap
			};		
			
			jQuery.ajax({
				type: "POST",
				url: edsBPMParam.ajaxurl,
				data: data,
				async: true,
				success: function(responseText, status) {
					/*console.log(responseText);*/
					var response =  $.parseJSON(responseText);
					if(response["success"]) {
						msgWrap.removeClass("text-danger").addClass("text-success");
						msgWrap.html( '<span class="bpm-ipm-msg-lg">' + edsBPMMessages.projectsSaved + '</span>');
						msgWrap.show();
						setTimeout(function(){
							location.reload();
						}, 1000);						 
					} else {
						msgWrap.removeClass("text-success").addClass("text-danger");
						msgWrap.html( edsBPMMessages.problemSavingProjects + ' <a href="https://wordpress.org/support/plugin/portfolio-manager-powered-by-behance">' + edsBPMMessages.contactPluginAdministor + '</a>.');
						msgWrap.show();
						$("#bpm-ipm-projects-wrapper").show();
					}
					
				},
				error: function(obj, msg, error){
					console.log(error);
					msgWrap.removeClass("text-success").addClass("text-danger");
					msgWrap.html( edsBPMMessages.problemSavingProjects + ' <a href="https://wordpress.org/support/plugin/portfolio-manager-powered-by-behance">' + edsBPMMessages.contactPluginAdministor + '</a>.');
					msgWrap.show();
					$("#bpm-ipm-projects-wrapper").show();
				}
			});	
			
			
		});
		
		
		
		$("#bpm-search-project-behance").click(function(event){
			event.preventDefault();
			var bp_id = $("#bp-search-id").val();
			
			if(bp_id == ''){
				alert(edsBPMMessages.behanceProjectId);
			}else if(!edsIsInt(bp_id)){
				alert(edsBPMMessages.inputNumericValue);				
			}
			else{
				$("input[name=bpm-sub-task]").val("b_project_search");
				$("#eds_bpm_project").attr("method","get");
				$("#eds_bpm_project").submit();
			}
			
		});
		
		$("#bpm-clear-project-behance").click(function(event){
			event.preventDefault();
			$("input[name=bpm-sub-task]").val("b_clear_search");
			$("#eds_bpm_project").submit();			
		});
		
		$("#bpm-save-behance-project").click(function(event){
			event.preventDefault();
			$("input[name=bpm-task]").val("save");
			$("input[name=bpm-layout]").val("default");
			$("#eds_bpm_project").submit();			
		});
		
		
		$(".bpm-project-status-link").click(function(event){
			event.preventDefault();
			$status = $(this).attr("current-status");
			
			if($status == 'published'){
				$("input[name=bpm-task]").val("unpublish");
			}else{
				$("input[name=bpm-task]").val("publish");
			}			
			$(this).parent().parent().siblings('.bpm-checkbox-wrapper').find("input[name='entries[]']").prop('checked', true);			
			$("#eds_bpm_project").submit();
			
		});
		
		$(".bpm-project-featured-link").click(function(event){
			event.preventDefault();
			$status = $(this).attr("current-status");
			
			if($status == '1'){
				$("input[name=bpm-task]").val("unsetfeatured");
			}else{
				$("input[name=bpm-task]").val("setfeatured");
			}			
			$(this).parent().parent().siblings('.bpm-checkbox-wrapper').find("input[name='entries[]']").prop('checked', true);			
			$("#eds_bpm_project").submit();
			
		});
		
		$('#bop-read-more').click(function(event){
			event.preventDefault();
			$(".bop-short-desc").hide();
			$(".bop-full-desc").show();
		});
		
		$('#bop-read-less').click(function(event){
			event.preventDefault();
			$(".bop-full-desc").hide();
			$(".bop-short-desc").show();
		});
		
		
		if(typeof eds_bpm_view !== 'undefined' && eds_bpm_view == "edit"){
			$('nav.bpm-top-info-nav li ul').hide().removeClass('fallback');
			$('nav.bpm-top-info-nav li').hover(function () {
				$('ul', this).stop().slideToggle(200);
			});

			if($('input[name="b_project_id"]').length && $('input[name="b_project_id"]').val().length){
				var url =  eds_bpm_css_url;			
				
				//Adding font awsome and material design iconic font
				//$('<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300">').appendTo("head");
				$('<link rel="stylesheet" type="text/css" href="'+url+'material-design-iconic-font.min.css">').appendTo("head");	
				$('<link rel="stylesheet" type="text/css" href="'+url+'project_view.css">').appendTo("head");
				//Adding project view related CSS
				
				$("#bop-waiting-popup").show();
								 
				var cssFile = "";
				
				var width = $("#bop-all-wrapper").parent().innerWidth();
								
				if(width<=1024 && width>767 )
					cssFile = "bop-responsive-768.css";
				else if(width<=767)					
					cssFile = "bop-responsive-767.css";	
				
				if(cssFile != "")
				{
					var cssURL = url + cssFile;
					$.ajax({
					  url: cssURL					  
					}).done(function( data ) {
						$('<style type="text/css">' + data + '</style>').appendTo("head");
						//Adding Custom CSS from behance
						$('<style type="text/css">' + eds_bpm_custom_css + '</style>').appendTo("head");			
						$("#bop-waiting-popup").hide();
						$("#bop-project").animate({opacity : 1},1000);																			    
					});
				}else{
					//Adding Custom CSS from behance
					$('<style type="text/css">' + eds_bpm_custom_css + '</style>').appendTo("head");					
					$("#bop-waiting-popup").hide();					
					$("#bop-project").animate({opacity : 1}, 1000);					
				}
				
				
			}					
		}
		
		
	});
})(jQuery);

