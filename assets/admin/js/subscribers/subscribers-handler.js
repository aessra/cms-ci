
	'use strict';
	
	var SubscriberHandler = {
		createIt: function(options){
			
			var SUBSCRIBER_ID_;
			
			var handler = {
				
				_delete: function(){
					var self = this;
					
					var success = function(response){
						if(response.status == 'OK'){
							messageBox(SUCCESS, 'Delete subscriber success');
							location.reload();
						}else{
							if(typeof response.message != 'undefined'){
								if(response.message.length > 0)
									messageBox(ERROR, response.message);
								else
									messageBox(ERROR, 'Delete subscriber failed');
							}
						}
						loader.unblock();
					}
					
					var error = function(response){
						loader.unblock();
						messageBox(ERROR, response.responseText);
					}
					
					var postdata = {
						subscriber_id : SUBSCRIBER_ID_
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
					
					$(document).on('click', '#subscribers-list .btn-delete', function(){
						var ctrl = $(this);
						SUBSCRIBER_ID_ = ctrl.attr('data-id');
						
						$('.delete-confirmation').modal({
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