
	'use strict';
	
	var ContentsHandler = {
		createIt: function(options){
			
			var CONTENT_ID_,
				STATUS_,
				FILE_ID_,
				TITLE_,
				img;
			
			var handler = {
				
				_delete: function(){
					var self = this;
					
					var success = function(response)
					{
						if(response.status == 'OK')
						{
							messageBox(SUCCESS, 'Delete content success');
							location.reload();

						}else
						{
							if(typeof response.message != 'undefined'){
								if(response.message.length > 0)
									messageBox(ERROR, response.message);
								else
									messageBox(ERROR, 'Delete content failed');
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
						content_id 	: CONTENT_ID_,
						title 		: TITLE_
					}
					
					//console.log(postdata); return false;

					LumiRequest.sendApi({
						url: options.baseUrl + '/delete',
						postdata: postdata,
						success: success,
						error: error
					});
					
				},

				_publish: function(){
					var self = this;

					var success = function(response)
					{
						if(response.status == 'OK')
						{
							messageBox(SUCCESS, 'Content has been published/unpublished')
							window.location.href = options.baseUrl;
						}else
						{
							if(typeof response.message != 'undefined'){
								if(response.message.length > 0)
									messageBox(ERROR, response.message);
								else
									messageBox(ERROR, 'Publish content failed');
							}
						}
						loader.unblock();
					}

					var error = function(response){
						loader.unblock();
						messageBox(ERROR, response.responseText);
					}
					
					var postdata = {
						content_id 		: CONTENT_ID_,
						status 			: STATUS_,
						fresh_content 	: options.fresh_content
					}
					
					//console.log(postdata); return false;

					LumiRequest.sendApi({
						url: options.baseUrl + '/publishContent',
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
					
					$(document).on('click', '#contents-list .btn-delete', function(){
						var ctrl = $(this);

						CONTENT_ID_ = ctrl.attr('data-id');
						FILE_ID_ 	= ctrl.attr('data-name');
						TITLE_		= $('td#title'+CONTENT_ID_).html()
						
						$('.delete-confirmation').modal({
							backdrop: 'static',
							keyboard: false
						});
					});
					
					$(document).on('click', '#contents-list .btn-add', function(){
						location.href = options.baseUrl + '/add'
					});
					
					$(document).on('click', '#contents-list .btn-edit', function(){
						var ctrl = $(this),
							id = ctrl.attr('data-id');

						
						location.href = options.baseUrl + '/edit/'+id
					});
					
					$(document).on('click', '#contents-list .btn-comments', function(){
						var ctrl = $(this),
							id = ctrl.attr('data-id');

						
						location.href = options.baseUrl + '/comments/' + id
					});
					
					$(document).on('click', '#contents-list .btn-publish', function(){
						var ctrl = $(this),
							id = ctrl.attr('data-id');

						
						location.href = options.baseUrl + '/view/' + id
					});
					
					$('#btn-publish').on('click', function(){
						var ctrl = $(this);
						CONTENT_ID_ = ctrl.attr('data-name');
						STATUS_ 	= ctrl.attr('data-id');

						self._publish();
					});
					
					$('#cancel').on('click', function(){
						window.location.href = options.baseUrl;
					});
					
					$(document).on('click', '#contents-list .btn-edit', function(){
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