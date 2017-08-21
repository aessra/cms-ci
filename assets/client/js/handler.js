
	'use strict';
	
	var Handler = {
		createIt: function(options){
			
			var handler = {
				_inititalize: function(){
					var self = this;
				},
				
				_validate: function(){
					var self = this;

					var bCheck = true;

					if($('#name').val() <= 0){
						$('.name-group').addClass('has-error');
						$('.name-msg').html('Name is required');
							
						bCheck = false;
					}

					var email 	= $('#email').val();
					var atpos 	= email.indexOf("@");
				    var dotpos 	= email.lastIndexOf(".");

				    if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= email.length) {
				        $('.email-group').addClass('has-error');
						$('.email-msg').html('Email is not valid');

				        bCheck = false;
				    }

					if($('#comment').val() <= 0)
					{
						$('.comment-group').addClass('has-error');
						$('.comment-msg').html('Comment description is required');

						bCheck = false;
					}

					return bCheck;
				},
				
				_send: function(){
					var self = this;
					
					var valid = self._validate();
					if(!valid)
						return false;
					
					//loader.block();
					var success = function(response){

						if(response.status == 'OK'){
							$('#status').html('<i class="fa fa-check" aria-hidden="true" style="color:#d0075e"></i> Your comment has been sent.');
							$('.btn-custom').attr('disabled', 'disabled');

							setTimeout(function(){ location.reload(); }, 2000);

						}else{
							$('#status').html('<img id="imgstatus" src="'+ options.baseUrl +'assets/img/ajax-loader.gif" width="2%"> loading...');
							if(typeof response.message != 'undefined'){
								if(response.message == 'Recaptcha')
								{
									$('#status').html('<i class="fa fa-times" aria-hidden="true"></i> Sorry Google Recaptcha Unsuccessful!!');
									$('.btn-custom').removeAttr('disabled');
								}else
								{
									$('#status').html('<i class="fa fa-times" aria-hidden="true"></i> Sorry Google Recaptcha Unsuccessful!!');
									$('.btn-custom').removeAttr('disabled');
								}
							}
						}
						//$('#status').html('<img id="imgstatus" src="'+ options.baseUrl +'assets/img/ajax-loader.gif" width="2%"> loading...');
					}
					
					var error = function(response){
						$('#status').html('<i class="fa fa-times" aria-hidden="true"></i> Ups, sorry, we will fixed this asap.');
						$('.btn-custom').removeAttr('disabled');
					}

					var postdata = {
						g_capt_resp	: $('.g-recaptcha-response').val(),
						content_id	: $('#content_id').val(),
						name		: $('#name').val(),
						email		: $('#email').val(),
						comment		: $('#comment').val()
					}

					//console.log(postdata); return false;
					
					LumiRequest.sendApi({
						url: options.baseUrl + 'readmore/send',
						postdata: postdata,
						success: success,
						error: error
					})
				},

				_clickListener: function(){
					var self = this;

					$('#name').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.length > 0){
							$('.name-group').removeClass('has-error');
							$('.name-msg').html('');
						}
					});

					$('#email').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.length > 0){
							$('.email-group').removeClass('has-error');
							$('.email-msg').html('');
						}
					});

					$('#comment').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.length > 0){
							$('.comment-group').removeClass('has-error');
							$('.comment-msg').html('');
						}
					});

					$('#form-action').on('submit', function(e){
						e.preventDefault();
						self._send();
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