
	'use strict';
	
	var AddEditHandler = {
		createIt: function(options){
			
			var handler = {
				
				_delete: function(){
					var self = this;
					
					var success = function(response){
						if(response.status == 'OK'){

						}else{
							if(typeof response.message != 'undefined'){
								if(response.message.length > 0)
									console.log(response.message);
								else
									console.log('delete failed');
							}
						}
					}
					
					var error = function(response){
						console.log(response.responseText);
					}
					
					var postdata = {
						file_id: FILE_ID_
					}
					
					LumiRequest.sendApi({
						url: options.baseUrl + '/delete',
						postdata: postdata,
						success: success,
						error: error
					});
				},
				
				_validate: function(){
					var self = this;
					
					var bCheck = true;

					if($('#title').val().length <= 0){
						$('.title-group').addClass('has-error');
						$('.title-msg').html('Title is required. Please fill it first');
						
						bCheck = false;
					}
					
					if($('#album').val().length <= 0){
						$('.album-group').addClass('has-error');
						$('.album-msg').html('Album is required. Please fill it first');
						
						bCheck = false;
					}

					if($('#artis-band').val().length <= 0){
						$('.artis-band-group').addClass('has-error');
						$('.artis-band-msg').html('Artis/Band is required. Please fill it first');
						
						bCheck = false;
					}
					
					if($('#genre').val().length <= 0){
						$('.genre-group').addClass('has-error');
						$('.genre-msg').html('Genre is required. Please fill it first');
						
						bCheck = false;
					}
					
					if($('#url').val().length <= 0){
						$('.url-group').addClass('has-error');
						$('.url-msg').html('Url is required. Please fill it first');
						
						bCheck = false;
					}
					
					if($('#position').val().length <= 0){
						$('.position-group').addClass('has-error');
						$('.position-msg').html('Position is required. Please fill it first');
						
						bCheck = false;
					}
					
					/*if($('#pre-position').val().length <= 0){
						$('.pre-position-group').addClass('has-error');
						$('.pre-position-msg').html('Pre Position is required. Please fill it first');
						
						bCheck = false;
					}*/
					
					if(tinyMCE.get('lyric').getContent().length <= 0){
						$('.lyric-group').addClass('has-error');
						$('.lyric-msg').html('Lyric is required');
							
						bCheck = false;
					}

					var commas =  /^([a-zA-Z0-9\s*$])+\,([a-zA-Z0-9\s*$])+\,([a-zA-Z0-9\s*$])+\,([a-zA-Z0-9\s*$])+$/;
					var tag = $('#tag').val();

					if(!commas.test(tag))
					{
						$('.tag-group').addClass('has-error');
						$('.tag-msg').html('4 tags, please.. :)');

						bCheck = false;
					}

					if($('#seo-keywords').val() <= 0){
						$('.seo-keywords-group').addClass('has-error');
						$('.seo-keywords-msg').html('SEO Keywords is required.');
							
						bCheck = false;
					}

					if($('#seo-desc').val() <= 0){
						$('.seo-desc-group').addClass('has-error');
						$('.seo-desc-msg').html('SEO description is required');
							
						bCheck = false;
					}
					
					return bCheck;
				},
				
				_save: function(){
					var self = this;
					
					var valid = self._validate();
					if(!valid)
						return false;
					
					loader.block();
					var success = function(response){
						if(response.status == 'OK')
						{
							window.location.href = options.baseUrl + '';
						}else
						{
							if(typeof response.message != 'undefined')
							{
								if(response.message.length > 0)
									messageBox(ERROR, response.message);
								else
									messageBox(ERROR, 'Save news failed');
							}
						}
						loader.unblock();
					}
					
					var error = function(response){
						loader.unblock();
						messageBox(ERROR, response.responseText);
					}

					var postdata = {
						chart_id	: $('#chart-id').val(),
						title 		: $('#title').val(),
						old_title	: $('#old-title').val(),
						album 		: $('#album').val(),
						artis_band 	: $('#artis-band').val(),
						genre 		: $('#genre').val(),
						url 		: $('#url').val(),
						lyric 		: tinyMCE.get('lyric').getContent(),
						position	: $('#position').val(),
						old_position: $('#old-position').val(),
						pre_position: $('#pre-position').val(),
						seo_keywords: $('#seo-keywords').val(),
						seo_desc	: $('#seo-desc').val(),
						act 		: $('#act').html(),
						tag 		: $('#tag').val()
					}

					// Check file_id in the case of saving a file/image or not.

					if($('#act').html() == 'Add')
					{
						if($('div#upload-demo-i').html().length > 0){
							postdata['file_id'] = $('#chart-id').val();
						}else{
							postdata['file_id']	= 'no-file';
						}
					}

					if($('#act').html() == 'Edit')
					{
						if($('div#upload-demo-i').html().length > 0){
							postdata['file_id'] = $('#chart-id').val();
							
						}else{
							postdata['file_id']	= $('#file-id').val();
						}
					}

					//console.log(postdata); return false;

					LumiRequest.sendApi({
						url: options.baseUrl + '/save',
						postdata: postdata,
						success: success,
						error: error
					})
				},

				_clickListener: function(){
					var self = this;
					
					$('#title').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.length > 0){
							$('.title-group').removeClass('has-error');
							$('.title-msg').html('');
						}
					});

					if($('#act').html() == 'Add')
					{
						$("#title").focusout(function()
						{
							var ctrl = $(this);

							var success = function(response)
							{
								if(response.status == 'OK')
								{
									$('.title-group').removeClass('has-error');
									$('.title-msg').html('');
									$('button#save').removeAttr('disabled');
								}else{
									$('.title-group').addClass('has-error');
									$('.title-msg').html('This title has been used before. Check <strong>'+response.message+'</strong> page');
									$('button#save').attr('disabled', 'disabled');
								}
							}
							
							var error = function(response){
								$('.title-group').addClass('has-error');
								$('.title-msg').html('This title has been used before. Check <strong>'+response.message+'</strong> page');
								$('button#save').attr('disabled', 'disabled');
							}

							var postdata = {
								title		: ctrl.val()
							}

							//console.log(postdata); return false;
							
							LumiRequest.sendApi({
								url: options.baseUrl + '/checktitle',
								postdata: postdata,
								success: success,
								error: error
							})
						});
					}
					
					$('#album').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.length > 0){
							$('.album-group').removeClass('has-error');
							$('.album-msg').html('');
						}
					});
					
					$('#artis-band').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.length > 0){
							$('.artis-band-group').removeClass('has-error');
							$('.artis-band-msg').html('');
						}
					});
					
					$('#genre').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.length > 0){
							$('.genre-group').removeClass('has-error');
							$('.genre-msg').html('');
						}
					});
					
					$('#url').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.length > 0){
							$('.url-group').removeClass('has-error');
							$('.url-msg').html('');
						}
					});
					
					$('#position').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.length > 0){
							$('.position-group').removeClass('has-error');
							$('.position-msg').html('');
						}
					});
					
					/*$('#pre-position').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.length > 0){
							$('.pre-position-group').removeClass('has-error');
							$('.pre-position-msg').html('');
						}
					});*/
					
					$('#tag').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.length > 0){
							$('.tag-group').removeClass('has-error');
							$('.tag-msg').html('');
						}
					});
					
					$('#seo-keywords').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.length > 0){
							$('.seo-keywords-group').removeClass('has-error');
							$('.seo-keywords-msg').html('');
						}
					});
					
					$('#seo-desc').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.length > 0){
							$('.seo-desc-group').removeClass('has-error');
							$('.seo-desc-msg').html('');
						}
					});
					
					setTimeout(function(){
						
						var lyric = tinyMCE.get('lyric');

						lyric.on('keyup', function(){
							var ctrl = lyric.getContent();
							if(ctrl.length > 0){
								$('.lyric-group').removeClass('has-error');
								$('.lyric-msg').html('');
							}
						});

					}, 500);
					
					$('#form-action').on('submit', function(e){
						e.preventDefault()
						self._save();
					});
					
					$('#cancel').on('click', function(){
						window.location.href = options.baseUrl;
					});

					$('#btn-upload').on('click', function(){
						$('.upload-confirmation').modal({
							backdrop: 'static',
							keyboard: false
						});
					});
				},
				
				init: function(){
					var self = this;

					self._clickListener();
				}
			}
			
			return handler;
		}
	}