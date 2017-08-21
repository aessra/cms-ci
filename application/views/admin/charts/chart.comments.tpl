        {% extends "admin/base/base.tpl" %}

        {% block content %}
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <hr/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            View and respond the comments from reader
                        </div>
                        <div class="panel-body">
                            <div class="box-body">
                                <h4>{{ chart.chart_title }}</h4>
                                <p class="text-justify">{{ chart.chart_artist_band }}</p>
                                <div class="row">
                                    <div class="col-md-12 chart-video">
                                        {{ chart.ext_url | raw }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            Comments
                        </div>
                        <div class="panel-body">
                            <div class="box-body">
                                <ul class="chat">

                                {% if comments | length > 0 %}
                                    {% for comment in comments %}
                                        {% if loop.index is even %}
                                        <li class="right clearfix">
                                            <span class="chat-img pull-right">
                                                <img src="{{ base_url() }}{{ ano_thumbs }}ano.png" alt="User Avatar" class="img-circle" />
                                            </span>
                                            <div class="chat-body clearfix">
                                                <div class="header">
                                                    <small class=" text-muted">
                                                        {% if comment.comment_status == 'publish' %}
                                                            <span class="fa fa-unlock" style="cursor: pointer;" id="publish" data-id="{{ comment.content_id }}" data-name="{{ comment.comment_id }}"></span>
                                                        {% else %}
                                                            <span class="fa fa-lock" style="cursor: pointer;" id="publish" data-id="{{ comment.content_id }}" data-name="{{ comment.comment_id }}"></span>
                                                        {% endif %}
                                                        <i class="fa fa-clock-o fa-fw"></i> {{ comment.date }} 
                                                        <span class="fa fa-remove" style="cursor: pointer;" id="delete" data-id="{{ comment.content_id }}" data-name="{{ comment.comment_id }}"></span>
                                                    </small>
                                                    <strong class="pull-right primary-font">{{ comment.comment_name }}</strong>
                                                </div>
                                                <p>
                                                    {{ comment.comment }}
                                                </p>
                                            </div>
                                        </li>
                                        {% else %}
                                        <li class="left clearfix">
                                            <span class="chat-img pull-left">
                                                <img src="{{ base_url() }}{{ ano_thumbs }}ano.png" alt="User Avatar" class="img-circle" />
                                            </span>
                                            <div class="chat-body clearfix">
                                                <div class="header">
                                                    <strong class="primary-font">{{ comment.comment_name }}</strong>
                                                    <small class="pull-right text-muted">
                                                        {% if comment.comment_status == 'publish' %}
                                                            <span class="fa fa-unlock" style="cursor: pointer;" id="publish" data-id="{{ comment.content_id }}" data-name="{{ comment.comment_id }}"></span>
                                                        {% else %}
                                                            <span class="fa fa-lock" style="cursor: pointer;" id="publish" data-id="{{ comment.content_id }}" data-name="{{ comment.comment_id }}"></span>
                                                        {% endif %}
                                                        <i class="fa fa-clock-o fa-fw"></i> {{ comment.date }} 
                                                        <span class="fa fa-remove" style="cursor: pointer;" id="delete" data-id="{{ comment.content_id }}" data-name="{{ comment.comment_id }}"></span>
                                                    </small>
                                                </div>
                                                <p>
                                                    {{ comment.comment }}
                                                </p>
                                            </div>
                                        </li>
                                        {% endif %}
                                    {% endfor %}
                                {% else %}
                                    <li class="left clearfix">
                                        <div class="chat-body clearfix text-center">
                                            Comment is empty
                                        </div>
                                    </li>
                                {% endif %}
                                </ul>
                            </div>

                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form id="form-action-comment" role="form" method="post" enctype="multipart/form-data" action="">
                                            <div class="form-group" id="bg-data">
                                                <label>Chart ID</label>
                                                <input type="hidden" name="content-id" id="content-id" class="form-control" value="{{ chart.chart_id }}">
                                            </div>
                                            <div class="form-group comment-group">
                                                <label for="comment">Reply Comment <i class="fa fa-question-circle-o" aria-hidden="true" style="cursor: pointer;"></i></label>
                                                <textarea class="form-control tiny-mce" id="comment" name="comment" placeholder="Comment"></textarea>
                                                <p class="help-block comment-msg"></p>
                                            </div>
                                            <div class="pull-right">
                                                <button type="button" id="cancel" class="btn btn-default" style="min-width: 120px;">Cancel</button>
                                                <button type="submit" class="btn btn-success" style="min-width: 120px;">Send</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {% endblock %}

        {% block js %}
            <script src="{{ base_url() }}assets/admin/js/contents/contents-comment-handler.js"></script>
            <script>
                var handler = CommentHandler.createIt({
                    baseUrl: '{{ base_url() }}admin/chart',
                    ext: '{{ image_extension }}',
                    max_size: '{{ max_size }}',
                    max_size_text: '{{ max_size_text }}'
                });
                
                handler.init();
            </script>
        {% endblock %}