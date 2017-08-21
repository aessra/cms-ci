	
	"use strict";
	
	var Loader = {
		init: function(){
			var selector = $('.mask, .loader');
			var load = {
				block: function(){
					selector.show();
				},
				
				unblock: function(){
					selector.fadeOut('normal');
				}
			}
			
			return load;
		}
	}