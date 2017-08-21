
	"use strict";
	
	var LumiRequest = {
		sendApi: function(obj){
			return this.send(obj);
		},
		send: function(obj){
			$.ajax({
				url: obj.url,
				type: "POST",
				dataType: "JSON",
				/*
				beforeSend : function(xhr) {
					xhr.setRequestHeader("Authorization", 'Basic ' + key);
				},
				*/
				data: obj.postdata,
				success: function(response) {
					obj.success(response);
				},
				error: function(response) {
					if(typeof response.status != 'undefined'){
						if(response.status == 401){
							location.href = BASE_URL + 'lpanel/login/expired'
						}else{
							obj.error(response);
						}
					}
				}
			}); 
		}
	}