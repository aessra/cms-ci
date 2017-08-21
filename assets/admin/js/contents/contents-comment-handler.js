	'use strict';
	
	var CommentHandler = {
		createIt: function(options){
			
			var ART_ID_,
				COMMENT_ID_;
			
			var handler = {
				_inititalize: function(){
					var self = this;
				},

				_publish: function(){
					var success = function(response){
						if(response.status == 'OK'){
							messageBox(SUCCESS, 'Publish comment is success');
							location.reload();
						}else{
							if(typeof response.message != 'undefined'){
								if(response.message.length > 0)
									messageBox(ERROR, response.message);
								else
									messageBox(ERROR, 'Publish comment is failed');
							}
						}
						loader.unblock();
					}
					
					var error = function(response){
						loader.unblock();
						messageBox(ERROR, response.responseText);
					}
					
					var postdata = {
						article_id 	: ART_ID_,
						comment_id 	: COMMENT_ID_
					}

					//console.log(postdata); return false;
					
					LumiRequest.sendApi({
						url: options.baseUrl + '/publishComment',
						postdata: postdata,
						success: success,
						error: error
					});
				},
				
				_delete: function(){
					var success = function(response){
						if(response.status == 'OK'){
							messageBox(SUCCESS, 'Delete comment success');
							location.reload();
						}else{
							if(typeof response.message != 'undefined'){
								if(response.message.length > 0)
									messageBox(ERROR, response.message);
								else
									messageBox(ERROR, 'Delete comment failed');
							}
						}
						loader.unblock();
					}
					
					var error = function(response){
						loader.unblock();
						messageBox(ERROR, response.responseText);
					}
					
					var postdata = {
						article_id 	: ART_ID_,
						comment_id 	: COMMENT_ID_
					}
					
					//console.log(postdata); return false;

					LumiRequest.sendApi({
						url: options.baseUrl + '/deleteComment',
						postdata: postdata,
						success: success,
						error: error
					});
				},
				
				_validate: function(){
					var self = this;

					var bCheck = true;

					if($('textarea#comment').val() == '')
					{
						$('.comment-group').addClass('has-error');
						$('.comment-msg').html('Comment description is required');

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

						console.log(response.status);

						if(response.status == 'OK'){
							
							messageBox(SUCCESS, 'Respond comment is success');
							location.reload();

						}else{
							if(typeof response.message != 'undefined'){
								if(response.message.length > 0)
									messageBox(ERROR, response.message);
								else
									messageBox(ERROR, 'Respond comment is failed');
							}
						}
						loader.unblock();
					}
					
					var error = function(response){
						loader.unblock();
						messageBox(ERROR, response.responseText);
					}

					var postdata = {
						content_id	: $('#content-id').val(),
						comment 	: $('#comment').val()
					}
					
					LumiRequest.sendApi({
						url: options.baseUrl + '/sendComment',
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
					
					$('textarea#comment').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.length > 0){
							$('.comment-group').removeClass('has-error');
							$('.comment-msg').html('');
						}
					});

					$('.publish-yes').on('click', function(){
						$('.publish-confirmation').modal('hide');
						self._publish();
					});
					
					$(document).on('click', '#publish', function(){
						var ctrl = $(this);

						ART_ID_		= ctrl.attr('data-id');
						COMMENT_ID_	= ctrl.attr('data-name');
						
						$('.publish-confirmation').modal({
							backdrop: 'static',
							keyboard: false
						});
					});

					$('.delete-yes').on('click', function(){
						$('.delete-confirmation').modal('hide');
						self._delete();
					});
					
					$(document).on('click', '#delete', function(){
						var ctrl = $(this);

						ART_ID_ 	= ctrl.attr('data-id');
						COMMENT_ID_	= ctrl.attr('data-name');
						
						$('.delete-confirmation').modal({
							backdrop: 'static',
							keyboard: false
						});
					});

					$('#form-action-comment').on('submit', function(e){
						e.preventDefault();
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