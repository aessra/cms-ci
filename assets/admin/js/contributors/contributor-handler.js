	'use strict';
	
	var ContributorHandler = {
		createIt: function(options){
			
			var USERNAME_,
				FILE_ID_,
				img;
			
			var handler = {
				
				_delete: function(){
					var self = this;
					
					var success = function(response)
					{
						if(response.status == 'OK')
						{
							messageBox(SUCCESS, 'Delete contributor success');
							location.reload();

						}else
						{
							if(typeof response.message != 'undefined'){
								if(response.message.length > 0)
									messageBox(ERROR, response.message);
								else
									messageBox(ERROR, 'Delete contributor failed');
							}
						}
						loader.unblock();
					}
					
					var error = function(response){
						loader.unblock();
						messageBox(ERROR, response.responseText);
					}
					
					var postdata = {
						file_id 	: FILE_ID_,
						username 	: USERNAME_
					}
					
					//console.log(postdata); return false;

					LumiRequest.sendApi({
						url: options.baseUrl + '/delete',
						postdata: postdata,
						success: success,
						error: error
					});
					
				},
				
				_clickListener: function(){
					var self = this;
					
					$('.delete-yes').on('click', function(){
						$('.delete-confirmation').modal('hide');
						self._delete();
					});
					
					$(document).on('click', '#contributors-list .btn-delete', function(){
						var ctrl = $(this);

						USERNAME_	= ctrl.attr('data-id');
						FILE_ID_ 	= ctrl.attr('data-name');

						$('.delete-confirmation').modal({
							backdrop: 'static',
							keyboard: false
						});
					});
					
					$(document).on('click', '#contributors-list .btn-add', function(){
						location.href = options.baseUrl + '/add'
					});
					
					$(document).on('click', '#contributors-list .btn-edit', function(){
						var ctrl = $(this),
							id = ctrl.attr('data-id');

						
						location.href = options.baseUrl + '/edit/'+id
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