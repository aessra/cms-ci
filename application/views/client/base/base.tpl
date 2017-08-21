<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="shortcut icon" href="{{ base_url() }}assets/client/img/favicon.ico" type="image/x-icon">
        <link rel="icon" href="{{ base_url() }}assets/client/img/favicon.ico" type="image/x-icon">

        <title>{{ title }}</title>

        <!-- You can use open graph tags to customize link previews. Learn more: https://developers.facebook.com/docs/sharing/webmasters -->
		<meta property="og:url"           content="{{ base_url() }}{{ url }}" />
		<meta property="og:type"          content="{{ type }}" />
		<meta property="og:title"         content="{{ title_og }}" />
		<meta property="og:description"   content="{{ desc }}" />
		<meta property="og:image"         content="{{ base_url() }}{{ path }}{{ image }}" />
		
        <meta name="robots" content="index, follow">
        <meta name="description" content="{{ desc }}">
        <meta name="keywords" content="{{ keywords }}">
        <meta name="author" content="{{ author }}">

        <meta name="Distribution" content="Global">

        <meta name="revisit-after" content="2 days">

        {% include "client/base/css.tpl" %}

        {% block css %}
        {% endblock %}

	</head>

	<body>
		<script>
		  window.fbAsyncInit = function() {
		    FB.init({
		      appId      : '1064885933630344',
		      xfbml      : true,
		      version    : 'v2.8'
		    });
		  };

		  (function(d, s, id){
		     var js, fjs = d.getElementsByTagName(s)[0];
		     if (d.getElementById(id)) {return;}
		     js = d.createElement(s); js.id = id;
		     js.src = "//connect.facebook.net/en_US/sdk.js";
		     fjs.parentNode.insertBefore(js, fjs);
		   }(document, 'script', 'facebook-jssdk'));
		</script>
	    <nav id="mainNav" class="navbar navbar-default navbar-custom navbar-fixed-top">
	        <div class="container">
	            <div class="navbar-header page-scroll">
	                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
	                </button>
	                <a class="navbar-brand page-scroll" href="{{ base_url() }}"><img src="{{ base_url() }}assets/client/img/logo.gif"></a>
	            </div>

	            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	                <ul class="nav navbar-nav navbar-right">
	                    <li class="hidden">
	                        <a href="#page-top"></a>
	                    </li>
	                    {{ menu | raw }}
	                    <li class="dropdown">
          					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-search" aria-hidden="true"></i></a>
						    <ul class="dropdown-menu animated slideInRight">
						    	<li class="search-custom">
						        	<div class="input-group">
							      		<input type="text" class="form-control" placeholder="Search for..." id="ajaxDropdown" autocomplete="off" style="border-radius: 4px;">
							      		<ul class="datalistPlaceHolder">
                            			</ul>
							    	</div>
							    </li>
						    </ul>
				        </li>
	                </ul>
	            </div>
	        </div>
	    </nav>

		<div class="holding-nav animated slideInDown" id="top"></div>

        {% block content %}
        {% endblock %}

        <div class="back-to-top navbar-fixed-bottom" style="margin-bottom: 50px; width: 50px; display: none;">
            <a href="#top"><img src="{{ base_url() }}assets/client/img/back-to-top-icon.png" width="50px"></a>
        </div>

		<div class="holding-footer"></div>

        <div class="mask"></div>
        <div class="loader" style="display: none">Loading...</div>
		<footer id="my-footer-navbar" class="navbar navbar-default navbar-fixed-bottom animated fadeInUp">
		  	<div class="container">
		  		<div class="row">
		  			<div class="col-sm-8 text-footer-left">
		  				<span>Copyright 2016 sukakpop.com All Right Reserved</span>
		  			</div>
		  			<div class="col-sm-4 text-footer-right">
		  				<span>Website Developed by <a href="http://www.lumi-one.com/" target="_BLANK">LumiOne</a></span>
		  			</div>
		  		</div>
		  	</div>
		</footer>

        {% include "client/base/js.tpl" %}

        {% block js %}
        <script type="text/javascript">
			jQuery(document).ready(function()
			{
				var offset = 250;
				var duration = 600;

				jQuery(window).scroll(function()
				{
					if(jQuery(this).scrollTop() > offset)
					{
						jQuery('.back-to-top').fadeIn(duration);
					}else
					{
						jQuery('.back-to-top').fadeOut(duration);
					}
				});

				jQuery('.back-to-top').click(function(event)
				{
					event.preventDefault();
					jQuery('html, body').animate({
						scrollTop: 0
					},duration);
					
					return false;
				})
			});
        </script>
        {% endblock %}

	</body>

</html>