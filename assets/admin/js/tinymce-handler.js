	'use strict';
	
	var TinyMce = {
		init: function(options){
			tinymce.init({
				selector: "textarea.tiny-mce",
				//menubar: "format view edit table tools",
				//plugins: "visualchars image table searchreplace code link responsivefilemanager",
				convert_newlines_to_brs: false,
				force_p_newlines: true,
				force_br_newlines : false,
				remove_redundant_brs : true,
				remove_linebreaks : true,
				forced_root_block : "", 
				//toolbar: [
					//"undo redo | styleselect | visualchars | bold italic | link image | alignleft | aligncenter | alignright | sizeselect | fontselect | fontsizeselect | responsivefilemanager",
				//], 
				plugins: [
					"advlist autolink lists link image charmap print preview hr anchor pagebreak",
					"searchreplace wordcount visualblocks visualchars code fullscreen",
					"insertdatetime media nonbreaking save table contextmenu directionality",
					"emoticons template paste textcolor colorpicker textpattern responsivefilemanager"
				],
				toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
				toolbar2: "print preview media | forecolor backcolor emoticons responsivefilemanager",
				font_size_style_values: "12px, 16px, 20px, 24px, 28px, 32px, 36px",
				relative_urls: true,
				filemanager_crossdomain: true,
				filemanager_title:"Responsive Filemanager",
				external_filemanager_path: options.baseUrl + "assets/admin/plugins/filemanager/",
				external_plugins: { "filemanager" : options.baseUrl +  "assets/admin/plugins/filemanager/plugin.min.js"},
				imagetools_cors_hosts: [options.baseUrl],
				remove_script_host : true,
				document_base_url : options.baseUrl,
				convert_urls : true,
				//tab key
				setup: function(ed) {
					ed.on('keydown', function(event) {
						if (event.keyCode == 9){ // tab pressed
							ed.execCommand('mceInsertContent', false, '&emsp;&emsp;'); // inserts tab
							event.preventDefault();
							event.stopPropagation();
							return false;
						}
					});
					
					ed.on('keyup', function(e) {
						//console.debug('Key up event: ' + e.keyCode);
					});
				}
				//tab key
			});
		}
	}