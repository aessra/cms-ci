        {% extends "client/base/base.tpl" %}
        
        {% block content %}

        <header>
            <div class="container {{ headers | length }}">
                <div class="row">

                {% if headers | length <= 5 %}
                    {% for header in headers %}

                        {% if loop.index == 1 %}

                            <div class="col-sm-6 image-left text-center animated rotateInDownLeft">
                                <small class="small-header">{{ header.page | capitalize }}</small>

                                {% if header.content_title is not empty %}

                                    <a href="{{ header.seo_url }}" class="img-hover">
                                        <img src="{{ base_url }}assets/img/background.png" data-original="{{ base_url() }}{{ contents_image_path }}{{ header.name }}" class="img img-responsive overlay" alt="{{ header.tag }}">
                                    </a>
                                    <div class="small-review-footer">
                                        <h1 class="primary-font"><a href="{{ header.seo_url }}">{{ header.content_title }}</a></h1>
                                    </div>

                                {% endif %}

                            </div>
                            <div class="col-sm-6 image-right">
                                <div class="row">

                        {% elseif loop.index == 2 %}

                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-6 image-uprl animated rotateInDownLeft">
                                                <small class="small-header">{{ header.page | capitalize }}</small>
                                                

                                                {% if header.content_title is not empty %}
                                                    
                                                    <a href="{{ header.seo_url }}" class="img-hover">
                                                        <img src="{{ base_url }}assets/img/background.png" data-original="{{ base_url() }}{{ contents_image_path }}{{ header.name }}" class="img img-responsive overlay" alt="{{ header.tag }}">
                                                    </a>
                                                    <h2 class="small-footer"><a href="{{ header.seo_url }}">{{ header.content_title }}</a></h2>

                                                {% endif %}

                                            </div>

                        {% elseif loop.index == 3 %}


                                            <div class="col-sm-6 image-uprr animated rotateInDownRight">
                                                <small class="small-header">{{ header.page | capitalize }}</small>

                                                {% if header.content_title is not empty %}
                                                    
                                                    <a href="{{ header.seo_url }}" class="img-hover">
                                                        <img src="{{ base_url }}assets/img/background.png" data-original="{{ base_url() }}{{ contents_image_path }}{{ header.name }}" class="img img-responsive overlay" alt="{{ header.tag }}">
                                                    </a>
                                                    <h2 class="small-footer"><a href="{{ header.seo_url }}">{{ header.content_title }}</a></h2>

                                                {% endif %}

                                            </div>
                                        </div>
                                    </div>

                        {% elseif loop.index == 4 %}

                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-6 image-udrl animated rotateInUpLeft">
                                                <small class="small-header">{{ header.page | capitalize }}</small>

                                                {% if header.content_title is not empty %}
                                                    
                                                    <a href="{{ header.seo_url }}" class="img-hover">
                                                        <img src="{{ base_url }}assets/img/background.png" data-original="{{ base_url() }}{{ contents_image_path }}{{ header.name }}" class="img img-responsive overlay" alt="{{ header.tag }}">
                                                    </a>
                                                    <h2 class="small-footer"><a href="{{ header.seo_url }}">{{ header.content_title }}</a></h2>

                                                {% endif %}

                                            </div>
                                            
                        {% elseif loop.index == 5 %}
                                    
                                            <div class="col-sm-6 image-udrr animated rotateInUpRight">
                                                <small class="small-header">{{ header.page | capitalize }}</small>

                                                {% if header.content_title is not empty %}

                                                    <a href="{{ header.seo_url }}" class="img-hover">
                                                        <img src="{{ base_url }}assets/img/background.png" data-original="{{ base_url() }}{{ contents_image_path }}{{ header.name }}" class="img img-responsive overlay" alt="{{ header.tag }}">
                                                    </a>
                                                    <h2 class="small-footer"><a href="{{ header.seo_url }}">{{ header.content_title }}</a></h2>

                                                {% endif %}

                                            </div>
                                        </div>
                                    </div>

                        {% endif %}

                    {% endfor %}
                {% endif %}
                
                </div>
            </div>
        </header>

		<section class="animated fadeInUpBig">
			<div class="container">
				<div class="row">

					<!-- Main Section -->
					<div class="col-sm-8">

                    {% if contents | length > 0 %}
                        {% for page, content in contents %}

                            <a href="{{ base_url }}{{ page }}"><small class="header-section">{{ page | capitalize }}</small></a>
                            <div class="main-section">
                                <div class="row">

                                    {% if content | length > 0 %}
                                        {% for ctn in content %}

                                        <div class="col-sm-4 thumb-main">
                                            <small class="small-header">{{ ctn.page | capitalize }}</small>
                                            <a href="{{ ctn.seo_url }}" class="img-hover">
                                                <img src="{{ base_url }}assets/img/background.png" data-original="{{ base_url() }}{{ contents_image_path }}{{ ctn.name }}" class="img img-responsive overlay">
                                            </a>
                                            <a href="{{ ctn.seo_url }}">{{ ctn.content_title }}</a>
                                        </div>

                                        {% endfor %}
                                    {% endif %}

                                </div>
                            </div>

                        {% endfor %}
                    {% endif %}

						<br/>
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
                                                        <a href="{{ base_url() }}{{ latest.seo_url }}" class="img-hover">
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
            $(document).ready(function () {
                ajaxDropDownInit('{{ base_url() }}');
            });
        </script>
        {% endblock %}