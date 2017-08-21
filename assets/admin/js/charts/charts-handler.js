	'use strict';
	
	var ChartsHandler = {
		createIt: function(options){
			
			var CHART_ID_,
				STATUS_,
				FILE_ID_,
				img;
			
			var handler = {
				
				_delete: function(){
					var self = this;
					
					var success = function(response){
						if(response.status == 'OK'){
							messageBox(SUCCESS, 'Delete chart is success');
							location.reload();
						}else{
							if(typeof response.message != 'undefined'){
								if(response.message.length > 0)
									messageBox(ERROR, response.message);
								else
									messageBox(ERROR, 'Delete chart is failed');
							}
						}
						loader.unblock();
					}
					
					var error = function(response){
						loader.unblock();
						messageBox(ERROR, response.responseText);
					}
					
					var postdata = {
						chart_id 	: CHART_ID_,
						file_id 	: FILE_ID_,
						position 	: $('td#position'+CHART_ID_).html(),
						title 		: $('#title'+CHART_ID_).html()
					}
					
					//console.log(postdata); return false

					LumiRequest.sendApi({
						url: options.baseUrl + '/delete',
						postdata: postdata,
						success: success,
						error: error
					});
				},
				
				_clickListener: function(){
					var self = this;

					$('#add-chart').on('click', function(){
						location.href = options.baseUrl + '/add'
					});
					
					$('.delete-yes').on('click', function(){
						$('.delete-confirmation').modal('hide');
						self._delete();
					});
					
					$(document).on('click', '#charts-list .btn-delete', function(){
						var ctrl = $(this);
						CHART_ID_ = ctrl.attr('data-id');
						FILE_ID_ = ctrl.attr('data-name');
						
						$('.delete-confirmation').modal({
							backdrop: 'static',
							keyboard: false
						});
					});
					
					$(document).on('click', '#charts-list .btn-edit', function(){
						var ctrl = $(this),
							id = ctrl.attr('data-id');

							
						location.href = options.baseUrl + '/edit/'+id
					});
					
					$(document).on('click', '#charts-list .btn-comments', function(){
						var ctrl = $(this),
							id = ctrl.attr('data-id');

						
						location.href = options.baseUrl + '/comments/' + id
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