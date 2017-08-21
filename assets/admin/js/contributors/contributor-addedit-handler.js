	'use strict';
	
	var AddEditHandler = {
		createIt: function(options){
			
			var img,
				FILE_ID_,
				USERNAME_;
			
			var handler = {
				_inititalize: function(){
					var self = this;
					
					self._initUploader();
				},

				_initUploader: function(){
					var self = this;
					
					var btn = $('#upload-btn-img'),
						progressBar = $('#progress-bar-img'),
						progressOuter = $('#progress-outer-img'),
						filenameContainer = $('#filename-img');
						
					var ext = options.ext,
						ext = ext.split('|');
					
					img = new ss.SimpleUpload({
						button: btn,
						url: options.baseUrl + '/upload',
						allowedExtensions: ext,
						maxSize: options.max_size, // kilobytes
						name: 'img',
						autoSubmit: false,
						multipart: true,
						hoverClass: 'hover',
						focusClass: 'focus',
						responseType: 'json',
						form: $('#img-upload-img'),
						startXHR: function() {
							progressOuter.css('display', 'block'); // make progress bar visible
							this.setProgressBar( progressBar );
						},
						onChange: function(filename){
							filenameContainer.html(filename);
							$('.img-group').removeClass('has-error');
							$('.img-msg').html('');
							
							this.removeCurrent();
						},
						onSubmit: function() {
							
						},
						onComplete: function( filename, response ) {
							btn.innerHTML = 'Choose Another File';
							progressOuter.css('display', 'none'); // hide progress bar when upload is completed

							if ( !response ) {
								loader.unblock();
								messageBox(ERROR, 'Unable to upload file');
								return;
							}
							
							if ( response.status === 'OK' ) {
								messageBox(SUCCESS, 'Save contributor success');
								window.location.href = options.baseUrl + '';
							} else {
								if ( response.message )  {
									loader.unblock();
									messageBox(ERROR, response.message);
								} else {
									loader.unblock();
									messageBox(ERROR, 'An error occurred and the upload failed.');
								}
							}
						},
						onExtError: function(filename, extension){
							loader.unblock();
							img.destroy();
							self._initUploader();
							$('#filename-img').html('');
							
							if($('#file-id').val().length <= 0)
								self._delete();
							
							progressOuter.css('display', 'none');
							messageBox(ERROR, 'Extension not allowed. Allowed extension is : ' + ext.join(','));
						},
						onSizeError: function(filename, filesize){
							loader.unblock();
							img.destroy();
							self._initUploader();
							$('#filename-img').html('');
							
							if($('#file-id').val().length <= 0)
								self._delete();
							
							progressOuter.css('display', 'none');
							messageBox(ERROR, 'File size is to big. Max size : ' + options.max_size_text);
						},
						onError: function(){
							loader.unblock();
							img.destroy();
							self._initUploader();
							$('#filename-img').html('');
							
							if($('#file-id').val().length <= 0)
								self._delete();
							
							progressOuter.css('display', 'none');
							messageBox(ERROR, 'Upload image failed');
						}
					});
				},
				
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
							
							FILE_ID_ = response.file_id;
								
							$('#img-id').val(FILE_ID_);
							
							if($('#filename-img').html().length > 0)
							{
							
								$('#img-upload-img').submit();
							
							}else
							{
								window.location.href = options.baseUrl + '';
							}

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
					
					var error = function(response)
					{
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
						act 			: $('#act').html()
					}

					// Check file_id in the case of saving a file/image or not.

					if($('#act').html() == 'Add')
					{
						if($('#filename-img').html().length > 0){
							postdata['file_id']	= $('#file-id').val();
						}else{
							postdata['file_id']	= 'no-file';
						}
					}

					if($('#act').html() == 'Edit')
					{
						if($('#filename-img').html().length > 0){
							if($('#file-id').val() == 'no-file'){
								postdata['file_id']	= $('#file-id-edit').val();
							}else{
								postdata['file_id']	= $('#file-id').val();
							}
							
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
					
					$('#form-action').on('submit', function(e){
						e.preventDefault()
						self._save();
					});
					
					$('#cancel').on('click', function(){
						window.location.href = options.baseUrl;
					});
					
					$('.delete-yes').on('click', function(){
						self._delete();
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