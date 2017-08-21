	'use strict';
	
	var HomeHandler = {
		createIt: function(options){

			var NUM_OF_LOADPOPULAR_,
				NUM_OF_LOADLATEST_;
			
			var handler = {

				_loadlatest: function(){
					var xhttp = new XMLHttpRequest();
					var formData = new FormData();
					var inc = eval(NUM_OF_LOADLATEST_) + 5;
				  	xhttp.onreadystatechange = function()
				  	{
				    	if (this.readyState == 4 && this.status == 200)
				    	{
				    		$('i#loading-latest').html('');
					     	$('tbody#tbody-latest').append(xhttp.responseText);
					     	$('span#num-of-loadlatest').html(inc)
				    	}else
				    	{
				    		$('i#loading-latest').html("<img src='../assets/img/ajax-loader.gif' />");
				    	}
				  	};

				  	xhttp.open("POST", options.baseUrl + '/getLatestContents', true);
				  	formData.append('num_of_loadlatest', NUM_OF_LOADLATEST_);
				  	xhttp.send(formData);
				},

				_loadpopular: function(){
					var xhttp = new XMLHttpRequest();
					var formData = new FormData();
					var inc = eval(NUM_OF_LOADPOPULAR_) + 5;
				  	xhttp.onreadystatechange = function()
				  	{
				    	if (this.readyState == 4 && this.status == 200)
				    	{
				    		$('i#loading-popular').html('');
					     	$('tbody#tbody-popular').append(xhttp.responseText);
					     	$('span#num-of-loadpopular').html(inc)
				    	}else
				    	{
				    		$('i#loading-popular').html("<img src='../assets/img/ajax-loader.gif' />");
				    	}
				  	};

				  	xhttp.open("POST", options.baseUrl + '/getPopularContents', true);
				  	formData.append('num_of_loadpopular', NUM_OF_LOADPOPULAR_);
				  	xhttp.send(formData);
				},
				
				_clickListener: function(){
					var self = this;
					
					$('#load-latest-contents').on('click', function()
					{
						NUM_OF_LOADLATEST_ = $('span#num-of-loadlatest').html();

						self._loadlatest();
					});
					
					$('#load-popular-content').on('click', function()
					{
						NUM_OF_LOADPOPULAR_ = $('span#num-of-loadpopular').html();

						self._loadpopular();
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