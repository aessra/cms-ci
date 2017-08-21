		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	    <script src="{{ base_url() }}assets/client/js/jquery-1.11.3.min.js"></script>

	    <!-- Include all compiled plugins (below), or include individual files as needed -->
	    <script src="{{ base_url() }}assets/client/js/bootstrap.min.js"></script>
		<script src='{{ base_url() }}assets/client/js/lumi-request.js'></script>
		<script src='{{ base_url() }}assets/client/js/subscribe-handler.js'></script>
        <script src='{{ base_url() }}assets/client/js/sukakpop.js'></script>
        <script src='{{ base_url() }}assets/client/js/search.js'></script>
        <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
		
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
                    jQuery('html,body').animate(
                        {
                            scrollTop: 0
                        },duration);
                    return false;
                })
            });
        </script>
        <script>
            function init() {
                var imgDefer = document.getElementsByTagName('img');
                for (var i=0; i<imgDefer.length; i++)
                {
                    if(imgDefer[i].getAttribute('data-original'))
                    {
                        imgDefer[i].setAttribute('src',imgDefer[i].getAttribute('data-original'));
                    }
                } 
            }
            window.onload = init;
        </script>
		<script>
			var subscribehandler = SubscribeHandler.createIt({
				baseUrl: '{{ base_url() }}',
				segment: '{{ segment }}',
				author: '{{ content.created_by }}'
			});
			subscribehandler.init();
		</script>