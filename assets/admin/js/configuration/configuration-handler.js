
	'use strict';
	
	var ConfigurationHandler = {
		createIt: function(options){
			
			var PAGE_ID_,
				PAGE_URL_;
			
			var handler = {
				
				_delete: function(){
					var self = this;
					
					var success = function(response){
						if(response.status == 'OK'){
							messageBox(SUCCESS, 'Delete a page success');
							location.reload();
						}else{
							if(typeof response.message != 'undefined'){
								if(response.message.length > 0)
									messageBox(ERROR, response.message);
								else
									messageBox(ERROR, 'Delete a page failed');
							}
						}
						loader.unblock();
					}
					
					var error = function(response){
						loader.unblock();
						messageBox(ERROR, response.responseText);
					}
					
					var postdata = {
						page_id 	: PAGE_ID_,
						page_url 	: PAGE_URL_
					}

					//console.log(postdata); return false;
					
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

					if($('#facebook-page').val().length <= 0){
						$('.facebook-page-group').addClass('has-error');
						$('.facebook-page-msg').html('This field is required');
						
						bCheck = false;
					}

					if($('#twitter-page').val().length <= 0){
						$('.twitter-page-group').addClass('has-error');
						$('.twitter-page-msg').html('This field is required');
						
						bCheck = false;
					}


					if($('#gplus-page').val().length <= 0){
						$('.gplus-page-group').addClass('has-error');
						$('.gplus-page-msg').html('This field is required');
						
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
							messageBox(SUCCESS, 'Save fan pages success');
						}else{
							if(typeof response.message != 'undefined'){
								if(response.message.length > 0)
									messageBox(ERROR, response.message);
								else
									messageBox(ERROR, 'Save fan pages failed');
							}
						}
						loader.unblock();
					}
					
					var error = function(response){
						loader.unblock();
						messageBox(ERROR, response.responseText);
					}

					var postdata = {
						fan_page_id 	: $('#fan-page-id').html(),
						facebook_page	: $('#facebook-page').val(),
						twitter_page	: $('#twitter-page').val(),
						gplus_page		: $('#gplus-page').val()
					}

					//console.log(postdata); return false;
					
					LumiRequest.sendApi({
						url: options.baseUrl + '/saveFanPage',
						postdata: postdata,
						success: success,
						error: error
					})
				},

				_sitemap: function()
				{
					loader.block();
					var success = function(response){
						if(response.status == 'OK'){
							messageBox(SUCCESS, 'Sitemap.xml is updated');
						}else{
							if(typeof response.message != 'undefined'){
								if(response.message.length > 0)
									messageBox(ERROR, response.message);
								else
									messageBox(ERROR, 'Updating sitemap has been failed');
							}
						}
						loader.unblock();
					}
					
					var error = function(response){
						loader.unblock();
						messageBox(ERROR, response.responseText);
					}

					var postdata = {
						sitemap	: 'sitemap'
					}

					//console.log(postdata); return false;
					
					LumiRequest.sendApi({
						url: options.baseUrl + '/createSitemap',
						postdata: postdata,
						success: success,
						error: error
					})
				},
				
				_clickListener: function(){
					var self = this;
					
					$('#facebook-page').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.val().length > 0){
							$('.facebook-page-group').removeClass('has-error');
							$('.facebook-page-msg').html('');
						}
					});
					
					$('#twitter-page').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.val().length > 0){
							$('.twitter-page-group').removeClass('has-error');
							$('.twitter-page-msg').html('');
						}
					});
					
					$('#gplus-page').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.val().length > 0){
							$('.gplus-page-group').removeClass('has-error');
							$('.gplus-page-msg').html('');
						}
					});
					
					$('#form-action-fan-page').on('submit', function(e){
						e.preventDefault()
						self._save();
					});

					$('#add-pages').on('click', function(){
						location.href = options.baseUrl + '/add'
					});
					
					$('.delete-yes').on('click', function(){
						$('.delete-confirmation').modal('hide');
						
						self._delete();
					});
					
					$(document).on('click', '#pages-list .btn-delete', function(){
						var ctrl = $(this);
						PAGE_ID_ = ctrl.attr('data-id');

						PAGE_URL_ = $('td#page-url'+PAGE_ID_).html();
						
						$('.delete-confirmation').modal({
							backdrop: 'static',
							keyboard: false
						});
					});
					
					$(document).on('click', '#pages-list .btn-edit', function(){
						var ctrl = $(this),
							id = ctrl.attr('data-id');

							
						location.href = options.baseUrl + '/edit/'+id;
					});
					
					$('.btn-sitemap').on('click', function(e)
					{
						e.preventDefault()
						self._sitemap();
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