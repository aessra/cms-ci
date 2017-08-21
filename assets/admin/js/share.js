	
	'use strict';
	
	var ERROR = 'alert-danger',
		SUCCESS = 'alert-success';
	
	var key = base64_encode('fega:2015fega123');
	
	//INIT LOADER HERE
	var loader = Loader.init();
	
	function isEmail(email){
		var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
		return re.test(email);
	}
	
	function isNumeric(e){
		
		var key = window.event ? event.keyCode : event.which;
		if (event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 46
		 || event.keyCode == 37 || event.keyCode == 39 || (event.keyCode >= 96 && event.keyCode <= 105)) {
			return true;
		}
		else if ( key < 48 || key > 57 ) {
			return false;
		}
		else return true;
	}

	function post(path, params, method) {
		method = method || "post"; // Set method to post by default if not specified.

		// The rest of this code assumes you are not using a library.
		// It can be made less wordy if you use one.
		var form = document.createElement("form");
		form.setAttribute("method", method);
		form.setAttribute("action", path);

		for(var key in params) {
			if(params.hasOwnProperty(key)) {
				var hiddenField = document.createElement("input");
				hiddenField.setAttribute("type", "hidden");
				hiddenField.setAttribute("name", key);
				hiddenField.setAttribute("value", params[key]);

				form.appendChild(hiddenField);
			 }
		}

		document.body.appendChild(form);
		form.submit();
	}
	/*
	Example :
	post('/contact/', {name: 'Johnny Bravo'});
	*/

	function messageBox(type, msg, selector){
		var tpl = '<div class="alert {{ label }}">'+
				  '		<button type="button" class="close" data-dismiss="alert">&times;</button>'+
				  '		<strong>Message : </strong> {{ message }}'+
				  '</div>',
			msgBox = '';
			
		msgBox += tpl;
		msgBox = msgBox.replace(/{{ label }}/gi, type);
		msgBox = msgBox.replace(/{{ message }}/gi, msg);
		
		if(selector)
			selector.html(msgBox);
		else
			$('.response-message').html(msgBox);
	}
	
	function base64_encode(data) {
		//  discuss at: http://phpjs.org/functions/base64_encode/
		// original by: Tyler Akins (http://rumkin.com)
		// improved by: Bayron Guevara
		// improved by: Thunder.m
		// improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
		// improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
		// improved by: Rafal Kukawski (http://kukawski.pl)
		// bugfixed by: Pellentesque Malesuada
		//   example 1: base64_encode('Kevin van Zonneveld');
		//   returns 1: 'S2V2aW4gdmFuIFpvbm5ldmVsZA=='
		//   example 2: base64_encode('a');
		//   returns 2: 'YQ=='

		var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
		var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
			ac = 0,
			enc = '',
			tmp_arr = [];

		if (!data) {
			return data;
		}

		do { // pack three octets into four hexets
			o1 = data.charCodeAt(i++);
			o2 = data.charCodeAt(i++);
			o3 = data.charCodeAt(i++);

			bits = o1 << 16 | o2 << 8 | o3;

			h1 = bits >> 18 & 0x3f;
			h2 = bits >> 12 & 0x3f;
			h3 = bits >> 6 & 0x3f;
			h4 = bits & 0x3f;

			// use hexets to index into b64, and append result to encoded string
			tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
		} while (i < data.length);

		enc = tmp_arr.join('');

		var r = data.length % 3;

		return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);
	}
	