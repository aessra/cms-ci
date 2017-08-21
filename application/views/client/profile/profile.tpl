        {% extends "client/base/base.tpl" %}

		{% block content %}

		<section class="animated fadeInUpBig">
			<div class="container">
				<div class="row">

					<!-- Main Section -->
					<div class="col-sm-8">
						<small class="header-section">{{ small_header }}</small>
                        <div class="main-section">
                            <ul class="content">

                                {% if contents | length > 0 %}
                                    {% for content in contents %}
                                        {% if loop.index is even %}

                                            <li class="right clearfix">
                                                <span class="content-img pull-right text-center">
                                                    <a href="{{ content.seo_url }}">
                                                        <img src="{{ base_url() }}{{ contents_image_path }}{{ content.name }}" class="img img-responsive" width="200px" />
                                                    </a>
                                                    <small class="small-header">{{ small_header }}</small>
                                                    <small class="triangle-caption-right"></small>
                                                </span>
                                                <div class="content-body clearfix">
                                                    <div class="content-padding-right">
                                                        <div class="header">
                                                            <h2 class="primary-font"><a href="{{ content.seo_url }}">{{ content.content_title }}</a></h2>
                                                        </div>
                                                        <small class="contributor">Posted on {{ content.date }} by {{ content.fullname }}</small>
                                                        <p><i class="fa fa-facebook-square" aria-hidden="true"></i> <i class="fa fa-share-square-o" aria-hidden="true"></i> <i class="fa fa-twitter-square" aria-hidden="true"></i></p>
                                                        <small class="view-count">

                                                            {% if content.num_comment is empty %}
                                                                
                                                                0

                                                            {% else %}
                                                                
                                                                {{ content.num_comment }}

                                                            {% endif %}

                                                            Comments
                                                        </small>
                                                    </div>
                                                </div>
                                            </li>

                                        {% else %}

                                            <li class="left clearfix">
                                                <span class="content-img pull-left text-center">
                                                    <small class="small-header">{{ small_header }}</small>
                                                    <a href="{{ content.seo_url }}">
                                                        <img src="{{ base_url() }}{{ contents_image_path }}{{ content.name }}" class="img img-responsive" width="200px" />
                                                    </a>
                                                    <small class="triangle-caption-left"></small>
                                                </span>
                                                <div class="content-body clearfix">
                                                    <div class="content-padding">
                                                        <div class="header">
                                                            <h2 class="primary-font"><a href="{{ content.seo_url }}">{{ content.content_title }}</a></h2>
                                                        </div>
                                                        <small class="contributor">Posted on {{ content.date }} by {{ content.fullname }}</small>
                                                        <p><i class="fa fa-facebook-square" aria-hidden="true"></i> <i class="fa fa-share-square-o" aria-hidden="true"></i> <i class="fa fa-twitter-square" aria-hidden="true"></i></p>
                                                        <small class="view-count">

                                                            {% if content.num_comment is empty %}
                                                                
                                                                0

                                                            {% else %}
                                                                
                                                                {{ content.num_comment }}

                                                            {% endif %}

                                                            Comments
                                                        </small>
                                                    </div>
                                                </div>
                                            </li>

                                        {% endif %}
                                    {% endfor %}
                                {% endif %}

                            </ul>
                            <i hidden="hidden" id="num-of-content">{{ num_of_content }}</i>
                            <i hidden="hidden" id="current-load">6</i>
                            <div class="row loading" hidden="hidden">
                                <div class="col-sm-12 text-center">
                                    <img src="{{ base_url }}assets/img/ajax-loader-page.gif">
                                    <small>Loading page...</small>
                                </div>
                            </div>
                            <button class="load-data btn btn-default btn-block" onclick="loadMore()">Load More</button>
                        </div>
                    </div>
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
                                                        <a href="{{ base_url() }}{{ popular.seo_url }}">
                                                            <img src="{{ base_url() }}{{ contents_image_path }}thumbs/thumb_{{ popular.name }}" alt="User Avatar" />
                                                        </a>
                                                    </span>
                                                    <div class="side-content-body clearfix">
                                                        <div class="header">
                                                            <a href="{{ base_url() }}{{ popular.seo_url }}">
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
                                    <a class="twitter-timeline" href="https://twitter.com/SukaKpop_ID" height="20px">Tweets by SukaKpop_ID</a>
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
                    </aside>
                    <!-- End of Side Section -->

                </div>
            </div>
        </section>
        
        {% endblock %}

        {% block js %}
        <script>
            $(document).ready(function() {
                var win = $(window);

                var num_of_content = eval($('i#num-of-content').html());
                var start = 6;

                win.scroll(function()
                {
                    var current_load = eval($('i#current-load').html());
                    if(num_of_content > start)
                    {
                        if(current_load <= num_of_content)
                        {
                            if ($(document).height() - win.height() == win.scrollTop())
                            {
                                $('.loading').show();
                                $.ajax({
                                    url: '{{ base_url() }}{{ segment }}/loadmore/'+current_load,
                                    dataType: 'html',
                                    success: function(html) {
                                        $('.content').append(html);
                                        $('.loading').hide();
                                    }
                                });

                                start = start + 6;

                                $('i#current-load').html(start);
                            }
                        }
                    }
                });

            });
            function loadMore()
            {
                var num_of_content = eval($('i#num-of-content').html());
                var start = 6;
                var current_load = eval($('i#current-load').html());
                if(num_of_content > start)
                {
                    if(current_load <= num_of_content)
                    {
                        $('.loading').show();
                        $.ajax({
                            url: '{{ base_url() }}{{ segment }}/loadmore/'+current_load,
                            dataType: 'html',
                            success: function(html) {
                                $('.content').append(html);
                                $('.loading').hide();
                            }
                        });
                        start = start + 6;
                        $('i#current-load').html(start);
                    }
                }
            }
        </script>
        <script>
            $(document).ready(function () {
                ajaxDropDownInit('{{ base_url() }}');
            });
        </script>

        {% endblock %}