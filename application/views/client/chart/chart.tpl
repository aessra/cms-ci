        {% extends "client/base/base.tpl" %}

		{% block content %}

		<section class="animated fadeInUpBig">
			<div class="container">
				<div class="row">

					<!-- Main Section -->
					<div class="col-sm-12">
						<h1 class="chart-page-title">Weekly K-POP Chart</h1>

						{% if charts | length > 0 %}
							{% for chart in charts %}
								<div class="chart-line-top">
									<a href="{{ base_url() }}{{ chart.seo_url }}">
										<img src="{{ base_url() }}assets/client/img/chart-top.png" class="img img-responsive">
									</a>
								</div>
								<div class="chart">
		                            <div class="chart-pos pull-right">

		                            	{% if chart.position == chart.pre_position %}

		                            		<img src="{{ base_url() }}assets/client/img/icon_stay.png">

		                            	{% elseif chart.pre_position > chart.position %}

		                            		<img src="{{ base_url() }}assets/client/img/chart-up.png"> <span>{{ chart.pre_position }}</span>

		                            	{% elseif chart.pre_position < chart.position %}

		                            		<img src="{{ base_url() }}assets/client/img/chart-down.png"> <span style="color: red">{{ chart.pre_position }}</span>

		                            	{% endif %}

		                            </div>
									<div class="chart-description">
										<div class="row">
											<a href="{{ base_url() }}{{ chart.seo_url }}" style="color: #333333">
												<div class="col-sm-3 text-left">
													<div class="chart-position">

														{% if loop.index == 1 %}
														
															<img src="{{ base_url() }}assets/client/img/chart-num-one.png" class="img img-responsive chart-num-img">

														{% else %}

															{% if loop.index | length > 1 %}

																<span class="chart-num"><strong style="margin-left: 5px">{{ loop.index }}</strong></span>

															{% else %}

																<span class="chart-num"><strong>{{ loop.index }}</strong></span>

															{% endif %}

														{% endif %}

														{% if chart.name is empty %}

															<img src="{{ base_url() }}assets/img/no-img.jpg" class="img img-responsive chart-thumb">

														{% else %}

															<img src="{{ base_url }}assets/img/background.png" data-original="{{ base_url() }}{{ charts_image_path }}/{{ chart.name }}" class="img img-responsive chart-thumb">

														{% endif %}

													</div>
												</div>
												<div class="col-sm-3 text-left">
													<h2 class="chart-title">{{ chart.chart_title }}</h2>
												</div>
												<div class="col-sm-2 text-right">
													<h3 class="chart-album"><small>Album :</small>{{ chart.chart_album }}</h3>
												</div>
												<div class="col-sm-2 text-right">
													<h3 class="chart-artis-band"><small>Artis/Band :</small>{{ chart.chart_artist_band }}</h3>
												</div>
												<div class="col-sm-2 text-right">
													<h3 class="chart-genre"><small>Genre :</small>{{ chart.chart_genre }}</h3>
												</div>
											</a>
										</div>
		                            </div>
								</div>
								<div class="chart-line-bottom">
									<img src="{{ base_url() }}assets/client/img/chart-bottom.png" class="img img-responsive">
								</div>
							{% endfor %}
						{% endif %}

					</div>
					<!-- End of Main Section -->

				</div>
			</div>
		</section>

		{% endblock %}

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
                    jQuery('html,body').animate(
                        {
                            scrollTop: 0
                        },duration);
                    return false;
                })
            });
        </script>
        <script>
            $(document).ready(function () {
                ajaxDropDownInit('{{ base_url() }}');
            });
        </script>
        {% endblock %}