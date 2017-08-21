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

					if($('#title').val() <= 0){
						$('.title-group').addClass('has-error');
						$('.title-msg').html('Title is required');
							
						bCheck = false;
					}
					
					if(tinyMCE.get('description').getContent().length <= 0){
						$('.description-group').addClass('has-error');
						$('.description-msg').html('Description is required');
							
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
						$('.seo-keywords-msg').html('SEO Keyword is required');
							
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
					var success = function(response)
					{
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
									messageBox(ERROR, 'Save is failed');
							}
						}
						loader.unblock();
					}
					
					var error = function(response){
						loader.unblock();
						messageBox(ERROR, response.responseText);
					}

					var postdata = {
						content_id		: $('#content-id').val(),
						old_title		: $('#old-title').val(),
						title 			: $('#title').val(),
						description 	: tinyMCE.get('description').getContent(),
						seo_keywords	: $('#seo-keywords').val(),
						seo_desc		: $('#seo-desc').val(),
						act 			: $('#act').html(),
						tag 			: $('#tag').val(),
					}

					// Check file_id in the case of saving a file/image or not.

					if($('#act').html() == 'Add')
					{
						if($('div#upload-demo-i').html().length > 0){
							postdata['file_id'] = $('#content-id').val();
						}else{
							postdata['file_id']	= 'no-file';
						}
					}

					if($('#act').html() == 'Edit')
					{
						if($('div#upload-demo-i').html().length > 0){
							postdata['file_id'] = $('#content-id').val();
							
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

					setTimeout(function(){

						var desc = tinyMCE.get('description');

						desc.on('keyup', function(){
							var ctrl = desc.getContent();
							if(ctrl.length > 0){
								$('.description-group').removeClass('has-error');
								$('.description-msg').html('');
							}
						});

					}, 500);
					
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

					$('#btn-upload').on('click', function(){
						$('.upload-confirmation').modal({
							backdrop: 'static',
							keyboard: false
						});
					});
					
					$('#form-action').on('submit', function(e){
						e.preventDefault()
						self._save();
					});
					
					$('#cancel').on('click', function(){
						window.location.href = options.baseUrl;
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