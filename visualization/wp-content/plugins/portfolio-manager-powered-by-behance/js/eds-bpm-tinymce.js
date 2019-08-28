(function($, ajaxurl) {
	tinymce.create('tinymce.plugins.EDSBPortMan', {
		init : function(editor, url) {
			editor.addButton('edsbportman', {
				title : 'Portfolio Manager - Powered by Behance',
				icon : true,
				image : url+'/../images/eds-bpm-dark-20x20.png',
				onclick : function() {
					editor.windowManager.open({						
						file : ajaxurl + '?action=eds_bpm_get_popup',
						width : window.innerWidth-100,
						height : window.innerHeight-100,
						inline : 1
					}, {
						plugin_url : url, // Plugin absolute URL
						ajaxurl: ajaxurl, //AJAX URL
						jquery: $ //jQuery Object
					});				
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		},
		getInfo : function() {
			return {
				longname : "Portfolio Manager - Powered by Behance",
				author : 'Eleopard Design Studios Pvt. Ltd.',
				authorurl : 'http://eleopard.in/',
				infourl : 'http://downloads.eleopard.in/',
				version : "1.0"
			};
		}
	});
	tinymce.PluginManager.add('edsbportman', tinymce.plugins.EDSBPortMan);
})(jQuery, ajaxurl);
