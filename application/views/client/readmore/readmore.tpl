        {% extends "client/base/base.tpl" %}

		{% block content %}

		<section>
			<div class="container">
				<div class="row">

					<!-- Main Section -->
					<article class="col-sm-8">

						{% if content.page == 'chart' %}
							
							<div class="chart-page-title">Weekly K-POP  <span id="page-identity">Chart</span></div>

							{% if content.position == 1 %}

								<div class="header-readmore">
									<h1 class="chart-title"><img src="{{ base_url() }}assets/client/img/chart-num-one.png" class="img img-responsive" width="5%"><span>{{ content.chart_title }}</span></h1>
								</div>

							{% else %}

								<div class="header-readmore">
									<h1 class="chart-title"><small class="chart-sort"><span>{{ content.position }}</span></small><span>{{ content.chart_title }}</span></h1>
								</div>

							{% endif %}

								<div class="row">
									<div class="col-sm-12 chart-video">
										{{ content.ext_url | raw }}
									</div>
									<div class="col-sm-12">
										<div class="chart-lyric">
											<div class="lyric-head">
												<h3><i class="fa fa-music" aria-hidden="true"></i>   <span>Track Lyrics</span></h3>
												<h4><span><small>Album :</small><strong>  {{ content.chart_album }}</strong></span><span><small>Artist/Band :</small><strong> {{ content.chart_artist_band }}</strong></span><span><small>Genre :</small><strong> {{ content.chart_genre }}</strong></span></h4>
											</div>
											<div class="lyric-body">{{ content.chart_lyric | raw }}</div>
										</div>
									</div>
								</div>

							<div class="footer-readmore">
								<div class="share">
                                    <ul class="list-inline list-social">
                                        <li>
                                            <strong>Let Share This: </strong>
                                        </li>
                                        <li class="social-facebook text-center">
                                            <a class="fb-share-button" data-href="{{ base_url() }}{{ content.seo_url }}" data-layout="button_count" href="https://www.facebook.com/dialog/share?app_id=145634995501895&href={{ base_url() }}{{ content.seo_url }}" target="_blank">
                                            	<i class="fa fa-facebook"></i>
                                            </a>
                                        </li>
                                        <li class="social-google-plus text-center">
                                            <a href="https://plus.google.com/share?url={{ base_url() }}{{ content.seo_url }}" target="_blank">
                                            	<i class="fa fa-google-plus"></i>
                                            </a>
                                        </li>
                                        <li class="social-twitter text-center">
                                            <a href="https://twitter.com/share?url={{ base_url() }}{{ content.seo_url }}" target="_blank">
                                            	<i class="fa fa-twitter"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>


						{% elseif content.page == 'profile' %}
						
							<div class="header-readmore">
								<h1>{{ content.content_title }}</h1>
								<small>Posted on {{ content.date }} by {{ content.fullname }} in {{ type }} <span id="page-identity" hidden="hidden">{{ content.page }}</span></small>
							</div>

							<div class="body-readmore">
								<img src="{{ base_url }}assets/img/background.png" data-original="{{ base_url() }}{{ contents_image_path }}{{ content.name }}" class="img img-responsive" alt="{{ content.tag }}">
								<div class="profile-body">{{ content.content_description | raw }}</div>
							</div>

							<div class="footer-readmore">
								<div class="share">
                                    <ul class="list-inline list-social">
                                        <li>
                                            <strong>Let Share This: </strong>
                                        </li>
                                        <li class="social-facebook text-center">
                                            <a class="fb-share-button" data-href="{{ base_url() }}{{ content.seo_url }}" data-layout="button_count" href="https://www.facebook.com/dialog/share?app_id=145634995501895&href={{ base_url() }}{{ content.seo_url }}" target="_blank">
                                            	<i class="fa fa-facebook"></i>
                                            </a>
                                        </li>
                                        <li class="social-google-plus text-center">
                                            <a href="https://plus.google.com/share?url={{ base_url() }}{{ content.seo_url }}" target="_blank">
                                            	<i class="fa fa-google-plus"></i>
                                            </a>
                                        </li>
                                        <li class="social-twitter text-center">
                                            <a href="https://twitter.com/share?url={{ base_url() }}{{ content.seo_url }}" target="_blank">
                                            	<i class="fa fa-twitter"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

						{% else %}
						
							<div class="header-readmore">
								<h1>{{ content.content_title }}</h1>
								<small>Posted on {{ content.date }} by {{ content.fullname }} in {{ type }} <span id="page-identity" hidden="hidden">{{ content.page }}</span></small>
							</div>

							<div class="body-readmore">
								<img src="{{ base_url }}assets/img/background.png" data-original="{{ base_url() }}{{ contents_image_path }}{{ content.name }}" class="img img-responsive" alt="{{ content.tag }}">
								<div class="content-description">
									{{ content.content_description | raw }}
								</div>
							</div>

							<div class="footer-readmore">
								<div class="share">
                                    <ul class="list-inline list-social">
                                        <li>
                                            <strong>Let Share This: </strong>
                                        </li>
                                        <li class="social-facebook text-center">
                                            <a class="fb-share-button" data-href="{{ base_url() }}{{ content.seo_url }}" data-layout="button_count" href="https://www.facebook.com/dialog/share?app_id=145634995501895&href={{ base_url() }}{{ content.seo_url }}" target="_blank">
                                            	<i class="fa fa-facebook"></i>
                                            </a>
                                        </li>
                                        <li class="social-google-plus text-center">
                                            <a href="https://plus.google.com/share?url={{ base_url() }}{{ content.seo_url }}" target="_blank">
                                            	<i class="fa fa-google-plus"></i>
                                            </a>
                                        </li>
                                        <li class="social-twitter text-center">
                                            <a href="https://twitter.com/share?url={{ base_url() }}{{ content.seo_url }}" target="_blank">
                                            	<i class="fa fa-twitter"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

						{% endif %}

								<div class="leave-comment">

									{% if content.diff_date <= 30 %}

										<h4>Leave a Comment</h4>
										<small>Your email address will not published. Required fields are marked *</small>

										<form id="form-action" role="form" method="post" action="">
											<div class="box-body">
												<div class="response-message">
												</div>

												<div class="row">
													<div class="col-md-6">
														<div class="form-group name-group">
															<label for="name">Name *</label>
															<input type="hidden" id="content_id" value="{{ content.chart_id }}{{ content.content_id }}+{{ content.page }}">
															<input class="form-control" type="text" id="name" name="name" placeholder="Name" value="">
															<p class="help-block name-msg"></p>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group email-group">
															<label for="email">Email *</label>
															<input class="form-control" type="text" id="email" name="email" placeholder="Email" value="">
															<p class="help-block email-msg"></p>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="form-group comment-group">
															<label for="comment">Comments *</label>
															<textarea class="form-control" id="comment" name="comment" placeholder="Comment"></textarea>
															<p class="help-block comment-msg"></p>
														</div>
														<span id="status" style="height: 10px"></span>
													</div>
												</div>
											</div>
											<div class="box-footer">
												<div class="row">
													<div class="col-md-6">
														<div class="error"><strong>{{ session.flashdata.flashSuccess }}</strong></div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6 center">
														<div class="g-recaptcha" data-sitekey="6LdH7wgUAAAAAJTj9CLk8k7slP_5lIcI44bx7UY6"></div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<button type="submit" class="btn btn-custom" style="min-width: 120px;">Post Comment</button>
													</div>
												</div>
											</div>
										</form>

									{% endif %}

								</div>

								<div class="comments-list">
									<div class="panel-body">
			                            <ul class="chat">

			                            {% if comments | length > 0 %}
			                            	{% for comment in comments %}
	                                        	{% if loop.index is even %}

	                                        		<li class="left clearfix">
					                                    <span class="chat-img pull-left">
					                                        <img src="{{ base_url() }}assets/img/avatar.jpg" alt="User Avatar" class="img-circle" />
					                                    </span>
					                                    <div class="chat-body clearfix">
					                                        <div class="header">
					                                            <strong class="primary-font" style="border-bottom: 1px dotted #CCCCCC"> <i class="fa fa-user" aria-hidden="true"></i> {{ comment.comment_name }}</strong>
					                                            <small class="pull-right text-muted" style="border-bottom: 1px dotted #CCCCCC">
					                                                <i class="fa fa-clock-o fa-fw"></i> {{ comment.date }}
					                                            </small>
					                                        </div>
					                                        <p style="text-indent: 10px">
					                                            {{ comment.comment }}
					                                        </p>
					                                    </div>
					                                </li>

			                            		{% else %}

			                            			<li class="right clearfix">
					                                    <span class="chat-img pull-right">
					                                        <img src="{{ base_url() }}assets/img/avatar.jpg" alt="User Avatar" class="img-circle" />
					                                    </span>
					                                    <div class="chat-body clearfix">
					                                        <div class="header">
					                                            <small class=" text-muted" style="border-bottom: 1px dotted #CCCCCC">
					                                                <i class="fa fa-clock-o fa-fw"></i> {{ comment.date }}
					                                            </small>
					                                            <strong class="primary-font" style="border-bottom: 1px dotted #CCCCCC"> <i class="fa fa-user" aria-hidden="true" style="margin-left: 10px"></i> {{ comment.comment_name }}</strong>
					                                        </div>
					                                        <p style="text-indent: 10px">
					                                            {{ comment.comment }}
					                                        </p>
					                                    </div>
					                                </li>

			                            		{% endif %}
			                            	{% endfor %}
			                            {% endif %}

			                            </ul>
			                        </div>
								</div>
							</div>
					
					</article>
					<!-- End of Main Section -->

					<!-- Side Section -->
                    <aside class="col-sm-4">
                        <div class="side-top">
                            <div class="side-header text-center">
                                <h4> <a href="{{ base_url() }}/chart" style="color: #FFFFFF; text-decoration: none !important"><i class="fa fa-music" aria-hidden="true"></i> <span>KPop Chart</span></a></h4>
                            </div>
                            <div class="side-body">
                                <ul class="side-content">

                                    {% if kpop_charts | length > 0 %}
                                        {% for kpop_chart in kpop_charts %}
                                            {% if loop.index == 1 %}

                                                <li class="clearfix">
                                                    <span class="side-content-number pull-left text-center">
                                                        <img src="{{ base_url() }}assets/client/img/thumb-kingchart.png">
                                                        <span class="num-one">{{ loop.index }}</span>
                                                    </span>
                                                    <span class="side-content-img pull-left">
                                                    	<a href="{{ base_url() }}{{ kpop_chart.seo_url }}">
                                                        	<img src="{{ base_url() }}{{ charts_image_path }}thumbs/thumb_{{ kpop_chart.name }}" alt="User Avatar" />
                                                        </a>
                                                    </span>
                                                    <div class="side-content-body clearfix">
                                                        <div class="header">
                                                            <a href="{{ base_url() }}{{ kpop_chart.seo_url }}">
                                                                <h3 class="primary-font">{{ kpop_chart.chart_title }}</h3>
                                                                <small>{{ kpop_chart.chart_album }}</small>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>

                                            {% else %}

                                                <li class="clearfix">
                                                    <span class="side-content-number pull-left text-center">
                                                        <span id="circle" style="">{{ loop.index }}</span>
                                                    </span>
                                                    <span class="side-content-img pull-left">
                                                    	<a href="{{ base_url() }}{{ kpop_chart.seo_url }}">
                                                        	<img src="{{ base_url() }}{{ charts_image_path }}thumbs/thumb_{{ kpop_chart.name }}" alt="User Avatar" />
                                                        </a>
                                                    </span>
                                                    <div class="side-content-body clearfix">
                                                        <div class="header">
                                                            <a href="{{ base_url() }}{{ kpop_chart.seo_url }}">
                                                                <h3 class="primary-font">{{ kpop_chart.chart_title }}</h3>
                                                                <small>{{ kpop_chart.chart_album }}</small>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>

                                            {% endif %}
                                        {% endfor %}
                                    {% endif %}

                                </ul>
                            </div>
                        </div>

                        <div class="side-bottom">
                            <ul class="nav nav-pills nav-justified side-nav">
                                <li class="active">
                                    <a href="#latest" data-toggle="tab">Latest</a>
                                </li>
                                <li>
                                    <a href="#popular" data-toggle="tab">Popular</a>
                                </li>
                                <li>
                                    <a href="#random" data-toggle="tab">Random</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="latest">
                                    <ul class="side-content">

                                        {% if latests | length > 0 %}
                                            {% for latest in latests  %}

                                                <li class="clearfix">
                                                    <span class="side-content-img pull-left">
                                                    	<a href="{{ base_url() }}{{ latest.seo_url }}">
                                                        	<img src="{{ base_url() }}{{ contents_image_path }}thumbs/thumb_{{ latest.name }}" alt="User Avatar" />
                                                        </a>
                                                    </span>
                                                    <div class="side-content-body clearfix">
                                                        <div class="header">
                                                            <a href="{{ base_url() }}{{ latest.seo_url }}">
                                                                <h3 class="primary-font">{{ latest.content_title }}</h3>
                                                                <!--<small class="view-count">{{ latest.num_of_visitors }} Views</small>-->
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>

                                            {% endfor %}
                                        {% endif %}

                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="popular">
                                    <ul class="side-content">

                                        {% if populars | length > 0 %}
                                            {% for popular in populars  %}

                                                <li class="clearfix">
                                                    <span class="side-content-img pull-left">
                                                    	<a href="{{ base_url() }}{{ latest.seo_url }}">
                                                        	<img src="{{ base_url() }}{{ contents_image_path }}thumbs/thumb_{{ popular.name }}" alt="User Avatar" />
                                                        </a>
                                                    </span>
                                                    <div class="side-content-body clearfix">
                                                        <div class="header">
                                                            <a href="{{ base_url() }}{{ latest.seo_url }}">
                                                                <h3 class="primary-font">{{ popular.content_title }}</h3>
                                                                <!--<small class="view-count">{{ popular.num_of_visitors }} Views</small>-->
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>

                                            {% endfor %}
                                        {% endif %}
                                        
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="random">
                                    <ul class="side-content">

                                        {% if randoms | length > 0 %}
                                            {% for random in randoms  %}

                                                <li class="clearfix">
                                                    <span class="side-content-img pull-left">
                                                    	<a href="{{ base_url() }}{{ random.seo_url }}">
                                                        	<img src="{{ base_url() }}{{ contents_image_path }}thumbs/thumb_{{ random.name }}" alt="User Avatar" />
                                                        </a>
                                                    </span>
                                                    <div class="side-content-body clearfix">
                                                        <div class="header">
                                                            <a href="{{ base_url() }}{{ random.seo_url }}">
                                                                <h3 class="primary-font">{{ random.content_title }}</h3>
                                                                <!--<small class="view-count">{{ random.num_of_visitors }} Views</small>-->
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>

                                            {% endfor %}
                                        {% endif %}

                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="side-subscribtion">
                            <div class="side-body">
                                <div id="contact" class="contact text-center">
                                    <a class="twitter-timeline" data-height="300" data-theme="light" data-link-color="#E81C4F" href="https://twitter.com/SukaKpop_ID">Tweets by SukaKpop_ID</a>
                                </div>
                            </div>
                        </div>
                        <div class="side-subscribtion">
                            <div class="side-body">
                                <div id="contact" class="contact text-center">
                                    <h4>We <i class="fa fa-heart"></i> new friends!</h4>
                                    <ul class="list-inline list-social">
                                        <li class="social-facebook">
                                            <a href="{{ fan_page.fan_page_fb }}" target="_blank"><i class="fa fa-facebook"></i></a>
                                        </li>
                                        <li class="social-google-plus">
                                            <a href="{{ fan_page.fan_page_gplus }}" target="_blank"><i class="fa fa-google-plus"></i></a>
                                        </li>
                                        <li class="social-twitter">
                                            <a href="{{ fan_page.fan_page_twitter }}" target="_blank"><i class="fa fa-twitter"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="side-subscribtion">
                            <div class="side-body">
                                <form id="form-action-subscribe" role="form" method="post" action="">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group email-subscriber-group">
                                                <label>Subscribe.</label>
                                                <input class="form-control" type="text" id="email-subscriber" name="email-subscriber" placeholder="Email" value="">
                                                <p class="help-block email-subscriber-msg"></p>
                                                <span id="status-subscriber" style="height: 10px"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-custom pull-right" style="min-width: 120px;">Subscribe</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </aside>
                    <!-- End of Side Section -->

				</div>
			</div>
		</section>

		<div class="additional-footer">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<small class="header-section">News Feed</small>
						<div class="main-section">
							<div class="row">

							{% if newsfeeds | length > 0 %}
								{% for newsfeed in newsfeeds %}
									{% if newsfeed.content_title is not empty %}

										<div class="col-sm-3">
											<a href="{{ newsfeed.seo_url }}">
												<img src="{{ base_url() }}{{ contents_image_path }}{{ newsfeed.name }}" class="img img-responsive">
											</a>
											<h3 class="small-footer text-center"><a href="{{ newsfeed.seo_url }}">{{ newsfeed.content_title }}</a></h3>
										</div>

									{% else %}

										<div class="col-sm-3">
											<a href="{{ newsfeed.seo_url }}">
												<img src="{{ base_url() }}{{ charts_image_path }}{{ newsfeed.name }}" class="img img-responsive">
											</a>
											<h3 class="small-footer text-center"><a href="{{ newsfeed.seo_url }}">{{ newsfeed.chart_title }}</a></h3>
										</div>

									{% endif %}
								{% endfor %}
							{% endif %}

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
					
		{% endblock %}

		{% block js %}
			<script src='https://www.google.com/recaptcha/api.js'></script>
			<script src='{{ base_url() }}assets/client/js/handler.js'></script>
			<script>
				var handler = Handler.createIt({
					baseUrl: '{{ base_url() }}'
				});
				handler.init();
			</script>
	        <script>
	            $(document).ready(function () {
	                ajaxDropDownInit('{{ base_url() }}');
	            });
	        </script>
		{% endblock %}