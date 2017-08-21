		'use strict';
	
	var SettingAccountHandler = {
		createIt: function(options){
			
			var handler = {
				
				_validate: function(){
					var self = this;
					
					var bCheck = true;

					if($('#username').val() <= 0){
						$('.username-group').addClass('has-error');
						$('.username-msg').html('Username is required');
							
						bCheck = false;
					}

					var illegalChars = /\W/; // allow letters, numbers, and underscores

					if (illegalChars.test($('#username').val()))
					{
				        $('.username-group').addClass('has-error');
						$('.username-msg').html('Username contains illegal characters.');

						bCheck = false;
				    }

					if($('#fullname').val() <= 0){
						$('.fullname-group').addClass('has-error');
						$('.fullname-msg').html('Fullname is required');
							
						bCheck = false;
					}

					if($('#email').val() <= 0){
						$('.email-group').addClass('has-error');
						$('.email-msg').html('Email is required');
							
						bCheck = false;
					}

					var emailReg = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
					var valid = emailReg.test($('#email').val());

					if(!valid) {
						$('.email-group').addClass('has-error');
				        $('.email-msg').html('Email is not valid');

				        bCheck = false;
				    }

					if($('#phone').val() <= 0){
						$('.phone-group').addClass('has-error');
						$('.phone-msg').html('Phone is required');
							
						bCheck = false;
					}

					if($('#address').val() <= 0){
						$('.address-group').addClass('has-error');
						$('.address-msg').html('Address is required');
							
						bCheck = false;
					}

					if($('#password-conf').val() <= 0){
						$('.password-conf-group').addClass('has-error');
						$('.password-conf-msg').html('Password is required');
							
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
							messageBox(SUCCESS, 'Profile is updated..');
							window.location.href = options.baseUrl + '';
						}else{
							if(typeof response.message != 'undefined'){
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
						pre_username	: $('#pre-username').val(),
						username		: $('#username').val(),
						fullname		: $('#fullname').val(),
						email 			: $('#email').val(),
						phone 		 	: $('#phone').val(),
						address 		: $('#address').val(),
						password 		: $('#password-conf').val()
					}

					//console.log(postdata); return false;
					
					LumiRequest.sendApi({
						url: options.baseUrl + '/update',
						postdata: postdata,
						success: success,
						error: error
					})
				},

				_valdateChangePassword: function()
				{
					var self = this;
					
					var bCheck = true;

					if($('#username').val() <= 0){
						$('.username-group').addClass('has-error');
						$('.username-msg').html('Username is required');
							
						bCheck = false;
					}

					if($('#new-password').val() <= 0){
						$('.new-password-group').addClass('has-error');
						$('.new-password-msg').html('This field is required');
							
						bCheck = false;
					}

					if($('#conf-password').val() <= 0){
						$('.conf-password-group').addClass('has-error');
						$('.conf-password-msg').html('This field is required');
							
						bCheck = false;
					}

					if($('#pre-password').val() <= 0){
						$('.pre-password-group').addClass('has-error');
						$('.pre-password-msg').html('This field is required');
							
						bCheck = false;
					}



					return bCheck;
				},

				_changePassword: function()
				{
					var self = this;
					
					var valid = self._valdateChangePassword();

					if(!valid)
						return false;
					
					loader.block();
					var success = function(response){
						if(response.status == 'OK')
						{
							messageBox(SUCCESS, 'Change password success');
							window.location.href = options.baseUrl;

						}else
						{

							if(typeof response.message != 'undefined')
							{
								if(response.message.length > 0)
									messageBox(ERROR, response.message);
								else
									messageBox(ERROR, 'Change password is failed');
							}

						}
						loader.unblock();
					}
					
					var error = function(response){
						loader.unblock();
						messageBox(ERROR, response.responseText);
					}

					var postdata = {
						username 		: $('#username').val(),
						new_password	: $('#new-password').val(),
						conf_password	: $('#conf-password').val(),
						pre_password	: $('#pre-password').val()
					}
					
					//console.log(postdata); return false;
					
					LumiRequest.sendApi({
						url: options.baseUrl + '/changePassword',
						postdata: postdata,
						success: success,
						error: error
					})

					$('.change-password-confirmation').modal('hide');
					
				},

				_clickListener: function(){
					var self = this;

					/* edit profile */
					$('#username').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.length > 0){
							$('.username-group').removeClass('has-error');
							$('.username-msg').html('');
						}
					});

					$('#fullname').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.length > 0){
							$('.fullname-group').removeClass('has-error');
							$('.fullname-msg').html('');
						}
					});

					$('#email').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.length > 0){
							$('.email-group').removeClass('has-error');
							$('.email-msg').html('');
						}
					});

					$('#phone').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.length > 0){
							$('.phone-group').removeClass('has-error');
							$('.phone-msg').html('');
						}
					});

					$('#address').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.length > 0){
							$('.address-group').removeClass('has-error');
							$('.address-msg').html('');
						}
					});

					$('#password-conf').on('keyup', function(){
						var ctrl = $(this);
						if(ctrl.length > 0){
							$('.password-conf-group').removeClass('has-error');
							$('.password-conf-msg').html('');
						}
					});
					
					$('#form-action').on('submit', function(e){
						e.preventDefault()
						self._save();
					});
					/* end of edit profile */

					/* Change Password */
					$('#new-password').on('keyup', function()
					{
						var ctrl = $(this);

						if(ctrl.length > 0)
						{
							$('.new-password-group').removeClass('has-error');
							$('.new-password-msg').html('');
						}
					});

					$('#conf-password').on('keyup', function()
					{
						var ctrl 				= $(this);
						var new_password_length = $('#new-password').val().length;

						if(ctrl.length > 0)
						{
							$('.conf-password-group').removeClass('has-error');
							$('.conf-password-msg').html('');
							$('#old-password').removeAttr('disabled');
						}
					});

					$('#conf-password').on('focusout', function()
					{
						if($('#new-password').val() !== $('#conf-password').val())
						{
							$('.conf-password-group').addClass('has-error');
							$('.conf-password-msg').html('New password and confirmation password is different.');
							$('#pre-password').attr('disabled', 'disabled');
							$('#btn-change-password').attr('disabled', 'disabled');

						}else
						{
							$('.conf-password-group').removeClass('has-error');
							$('.conf-password-msg').html('');
							$('#pre-password').removeAttr('disabled');
							$('#btn-change-password').removeAttr('disabled');
						}
					});

					$('#pre-password').on('keyup', function()
					{
						var ctrl = $(this);
						if(ctrl.length > 0)
						{
							$('.pre-password-group').removeClass('has-error');
							$('.pre-password-msg').html('');
						}
					});
					
					$('.change-password-yes').on('click', function()
					{
						self._changePassword();
					});
					
					$(document).on('click', '.change-password', function()
					{						
						$('.change-password-confirmation').modal(
						{
							backdrop: 'static',
							keyboard: false
						});
					});
					/* end of edit profile */

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