(function($){
	var bopHandler = {
		currentCat : "",
		
		getCurrentCat : function(){
			return this.currentCat;
		},
		
		setCurrentCat: function(curCat){
			this.currentCat= curCat;
		},
		
		initMosaicView : function($){
			
			
			var $container = $('#eds-bpm-project-container').isotope({
				  itemSelector: '.isotope-item',
				  layoutMode: 'fitRows'
			});
			
		
			
			$(".cat-tab").click(function(){
				
				var curCat = bopHandler.getCurrentCat();
				$("span[catname$='"+curCat+"']").removeClass("selected");
				$(this).addClass("selected");
				
				var newCat = $(this).attr("catname");
				if(newCat == 'be-all-cat')		
					$container.isotope({ filter: '*', transitionDuration: '1.0s'});
				else
					$container.isotope({ filter: '.'+newCat, transitionDuration: '1.0s' });
				
				bopHandler.setCurrentCat(newCat);			
				
			});
			
			$('.cat-tab').first().addClass("selected");
			var newCat = $('.cat-tab').first().attr('catname');
			if(newCat == 'be-all-cat')		
				$container.isotope({ filter: '*', transitionDuration: '1.0s'});
			else
				$container.isotope({ filter: '.'+newCat, transitionDuration: '1.0s' });
	
			bopHandler.setCurrentCat(newCat);
			
			return this;
		},
		
		addDynamicClass : function(marginClass, $){
			$(".isotope-item").addClass(marginClass);
			return this;
		},
		
		handleProjectDesc: function($){
			$('#bop-read-more').click(function(e){
				e.preventDefault();
				$(".bop-short-desc").hide();
				$(".bop-full-desc").show();
			});
			
			$('#bop-read-less').click(function(e){
				e.preventDefault();
				$(".bop-full-desc").hide();
				$(".bop-short-desc").show();
			});
		},
		
		setModalRel : function($, width, height){
			var finalWidth = bopHandler.getFinalWidth(width.trim());
			var finalHeight = bopHandler.getFinalHeight(height.trim());
			
			var paramVal = "{handler: 'iframe', size: {x:"+finalWidth+" , y:"+finalHeight+" }}";		
			$('.eds-bpm-info').each(function (){
				$(this).attr('rel',paramVal);			
			});
		},
		
		getFinalWidth : function(width){
			var pixelPattern = /[px]$/i;
			var percentPattern = /%$/i;
			if(pixelPattern.test(width)){
				width = width.substr(0, width.length - 2);
				if(isNaN(width))
					return bopHandler.getPercentWidth(90);
				
				return width;
					
			}else if(percentPattern.test(width)){
				width = width.substr(0, width.length - 1);
				if(isNaN(width))
					return bopHandler.getPercentWidth(90);
				
				return bopHandler.getPercentWidth(width);
				
			}else if(width!='' && !isNaN(width)){
				return width;
			}
			else{
				return bopHandler.getPercentWidth(90);
			}
			
			
		},
		
		getFinalHeight : function(height){
			var pixelPattern = /[px]$/i;
			var percentPattern = /%$/i;
			if(pixelPattern.test(height)){
				height = height.substr(0, height.length - 2);
				if(isNaN(height))
					return bopHandler.getPercentHeight(90); 
				
				return height;
			}else if(percentPattern.test(height)){
				height = height.substr(0, height.length - 1);
				if(isNaN(height))
					return bopHandler.getPercentHeight(90);
				
				return bopHandler.getPercentHeight(height);
			}else if(height!='' && !isNaN(height)){
				return height;
			}
			else{
				return bopHandler.getPercentHeight(90);
			}
			
		},
		
		getPercentWidth : function(width){
			var w = window.innerWidth;
			return Math.ceil((width * w)/100);
			
		},
		
		getPercentHeight : function(height){
			var h = window.innerHeight;
			return Math.ceil((height * h)/100);		
		}
	};
	
	$(document).ready(function(){
		
		if(typeof eds_bpm_view_type == 'undefined')
			return;
		
		if(eds_bpm_view_type == 'single_cat'){
			$('<style type="text/css">' + eds_bpm_custom_css + '</style>').appendTo("head");
			bopHandler.addDynamicClass("eds-bpm-view-dynamic", $);
		}
		else if(eds_bpm_view_type == 'multi_cat'){
			$('<style type="text/css">' + eds_bpm_custom_css + '</style>').appendTo("head");
			bopHandler.addDynamicClass("eds-bpm-view-dynamic", $).initMosaicView($);
		}
		else if(eds_bpm_view_type == 'single_project'){
			
			var url = eds_bpm_css_url;
			
			$('nav.bpm-top-info-nav li ul').hide().removeClass('fallback');
			$('nav.bpm-top-info-nav li').hover(function () {
				$('ul', this).stop().slideToggle(200);
			});

			var cssFile = "";
			var width = $("#bop-all-wrapper").parent().innerWidth();		
			
			if(width<=1024 && width>767 )
				cssFile = "bop-responsive-768.css";
			else if(width<=767)					
				cssFile = "bop-responsive-767.css";					
			
			if(cssFile != "")
			{
				$("#bop-waiting-popup").show();
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
								
			
			bopHandler.handleProjectDesc($);			
			
		}
	});	
	
	
})(jQuery);