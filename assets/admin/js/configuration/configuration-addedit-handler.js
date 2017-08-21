	'use strict';
	
	var AddEditHandler = {
		createIt: function(options){
			
			var handler = {
				_inititalize: function(){
					var self = this;
				},

				_validate: function(){
					var self = this;
					
					var bCheck = true;

					if($('#page-id').val().length <= 0){
						$('.page-id-group').addClass('has-error');
						$('.page-id-msg').html('Please, check Page ID first');
						
						bCheck = false;
					}

					if($('#page-title').val().length <= 0){
						$('.page-title-group').addClass('has-error');
						$('.page-title-msg').html('Page Title is required. Please fill it first');
						
						bCheck = false;
					}


					if($('#page-url').val().length <= 0){
						$('.page-url-group').addClass('has-error');
						$('.page-url-msg').html('Type # if it root');
						
						bCheck = false;
					}

					if($('#is-parent').val().length <= 0){
						$('.is-parent-group').addClass('has-error');
						$('.is-parent-msg').html('Please choose this option first');
						
						bCheck = false;
					}

					/*
					if($('#parent-id').val().length <= 0){
						$('.parent-id-group').addClass('has-error');
						$('.parent-id-msg').html('Please choose this option first');
						
						bCheck = false;
					}
					*/

					if($('#show-menu').val().length <= 0){
						$('.show-menu-group').addClass('has-error');
						$('.show-menu-msg').html('Please choose this option first');
						
						bCheck = false;
					}

					if($('#back-end').val().length <= 0){
						$('.back-end-group').addClass('has-error');
						$('.back-end-msg').html('Please choose this option first');
						
						bCheck = false;
					}

					if($('#front-end').val().length <= 0){
						$('.front-end-group').addClass('has-error');
						$('.front-end-msg').html('Please choose this option first');
						
						bCheck = false;
					}

					if($('#seo-title').val().length <= 0){
						$('.seo-title-group').addClass('has-error');
						$('.seo-title-msg').html('This field is required');
						
						bCheck = false;
					}

					if($('#seo-author').val().length <= 0){
						$('.seo-author-group').addClass('has-error');
						$('.seo-author-msg').html('This field is required');
						
						bCheck = false;
					}

					if($('#seo-keywords').val().length <= 0){
						$('.seo-keywords-group').addClass('has-error');
						$('.seo-keywords-msg').html('This field is required');
						
						bCheck = false;
					}

					if($('#seo-desc').val().length <= 0){
						$('.seo-desc-group').addClass('has-error');
						$('.seo-desc-msg').html('This field is required');
						
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
						if(response.status == 'OK'){
							messageBox(SUCCESS, 'Save page is success');
							window.location.href = options.baseUrl;
						}else{
							if(typeof response.message != 'undefined'){
								if(response.message.length > 0)
									messageBox(ERROR, response.message);
								else
									messageBox(ERROR, 'Save page is failed');
							}
						}
						loader.unblock();
					}
					
					var error = function(response){
						loader.unblock();
						messageBox(ERROR, response.responseText);
					}

					var postdata = {
						act 		: $('#act').val(),
						page_id		: $('#page-id').val(),
						page_title	: $('#page-title').val(),
						page_url	: $('#page-url').val(),
						page_url_old: $('#page-url-old').val(),
						is_parent	: $('#is-parent').val(),
						parent_id	: $('#parent-id').val(),
						show_menu	: $('#show-menu').val(),
						back_end	: $('#back-end').val(),
						front_end	: $('#front-end').val(),
						seo_title	: $('#seo-title').val(),
						seo_author	: $('#seo-author').val(),
						seo_keywords: $('#seo-keywords').val(),
						seo_desc	: $('#seo-desc').val()
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
					
					$('#page-id').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.val().length > 0){
							$('.page-id-group').removeClass('has-error');
							$('.page-id-msg').html('');
						}
					});
					
					$('#page-title').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.val().length > 0){
							$('.page-title-group').removeClass('has-error');
							$('.page-title-msg').html('');
						}
					});
					
					$('#page-url').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.val().length > 0){
							$('.page-url-group').removeClass('has-error');
							$('.page-url-msg').html('');
						}
					});
					
					$('#is-parent').on('change', function(){
						var ctrl = $(this);
						if(ctrl.val() == 0){
							$('#parent-id').attr('disabled', 'disabled');
						}else{
							$('#parent-id').removeAttr('disabled');
						}
						if(ctrl.val().length > 0){
							$('.is-parent-group').removeClass('has-error');
							$('.is-parent-msg').html('');
						}
					});
					
					/*
					$('#parent-id').on('change', function(){
						var ctrl = $(this);
						if(ctrl.val().length > 0){
							$('.parent-id-group').removeClass('has-error');
							$('.parent-id-msg').html('');
						}
					});
					*/
					
					$('#show-menu').on('change', function(){
						var ctrl = $(this);
						if(ctrl.val().length > 0){
							$('.show-menu-group').removeClass('has-error');
							$('.show-menu-msg').html('');
						}
					});
					
					$('#back-end').on('change', function(){
						var ctrl = $(this);
						if(ctrl.val().length > 0){
							$('.back-end-group').removeClass('has-error');
							$('.back-end-msg').html('');
						}
					});
					
					$('#front-end').on('change', function(){
						var ctrl = $(this);
						if(ctrl.val().length > 0){
							$('.front-end-group').removeClass('has-error');
							$('.front-end-msg').html('');
						}
					});
					
					$('#seo-title').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.val().length > 0){
							$('.seo-title-group').removeClass('has-error');
							$('.seo-title-msg').html('');
						}
					});
					
					$('#seo-author').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.val().length > 0){
							$('.seo-author-group').removeClass('has-error');
							$('.seo-author-msg').html('');
						}
					});
					
					$('#seo-keywords').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.val().length > 0){
							$('.seo-keywords-group').removeClass('has-error');
							$('.seo-keywords-msg').html('');
						}
					});
					
					$('#seo-desc').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.val().length > 0){
							$('.seo-desc-group').removeClass('has-error');
							$('.seo-desc-msg').html('');
						}
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
					
					self._inititalize();
					self._clickListener();
				}
			}
			
			return handler;
		}
	}