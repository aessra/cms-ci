
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
                                                            <a href="{{ content.seo_url }}"><strong class="primary-font">{{ content.content_title }}</strong></a>
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
                                                            <a href="{{ content.seo_url }}"><strong class="primary-font">{{ content.content_title }}</strong></a>
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