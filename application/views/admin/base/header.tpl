        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ base_url() }}admin/dashboard">K-Pop Panel</a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">

                        {% if jumnotif > 0 %}

                            <small style="color: red">{{ jumnotif }}</small><i class="fa fa-bell fa-fw" style="color: red"></i> <i class="fa fa-caret-down" style="color: red"></i>

                        {% else %}

                            <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>

                        {% endif %}

                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li class="divider"></li>

                        {% if notif_comment_content | length > 0 %}
                            {% for comment in notif_comment_content %}

                            <li>
                                <a href="{{ base_url() }}admin/{{ comment.page }}/comments/{{ comment.content_id }}">
                                    <div>
                                        <i class="fa fa-comment fa-fw"></i> {{ comment.comment_name }} in {{ comment.page | capitalize }}
                                        <span class="pull-right text-muted small">{{ comment.date }}</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>

                            {% endfor %}
                        {% endif %}

                        {% if notif_comment_chart | length > 0 %}
                            {% for comment in notif_comment_chart %}

                            <li>
                                <a href="{{ base_url() }}admin/{{ comment.page }}/comments/{{ comment.content_id }}">
                                    <div>
                                        <i class="fa fa-comment fa-fw"></i> {{ comment.comment_name }} in {{ comment.page | capitalize }}
                                        <span class="pull-right text-muted small">{{ comment.date }}</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>

                            {% endfor %}
                        {% endif %}

                        {% if session.userdata.level == 'A' %}

                            {% if noti_new_article > 0 %}

                            <li>
                                <a href="{{ base_url() }}admin/article" class="list-group-item" style="color: red">
                                    <i class="fa fa-bell fa-fw"></i> {{ noti_new_article }} New Article
                                    <span class="pull-right text-muted small">
                                        <em>-</em>
                                    </span>
                                </a>
                            </li>

                            {% endif %}

                        {% else %}

                            {% if noti_new_article > 0 %}

                            <li>
                                <a href="{{ base_url() }}admin/article" class="list-group-item" style="color: red">
                                    <i class="fa fa-bell fa-fw"></i> {{ noti_new_article }} Pending Article
                                    <span class="pull-right text-muted small">
                                        <em>-</em>
                                    </span>
                                </a>
                            </li>

                            {% endif %}

                        {% endif %}
                        
                        <li class="divider"></li>

                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> {{ session.userdata.fullname }} <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
							<a href="{{ base_url() }}admin/setting_account"><i class="fa fa-gear fa-fw"></i> Setting Account</a>
                        </li>
                        <li class="divider"></li>
                        <li>
							<a href="{{ base_url() }}admin/login/expired"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>