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
                            Data {{ page_title }} (Unpublished)
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="contents-list">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="3%">#</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Picture</th>
                                            <th class="text-center">Date</th>
                                            
                                            {% if session.userdata.level == 'A' %}
                                            
                                                <th class="text-center">Contributor</th>
                                            
                                            {% endif %}
                                            
                                            <th class="text-center" width="10%">Status</th>
                                            <th class="text-center" width="10%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    {% if contents | length > 0 %}
                                        {% for content in contents %}
                                            {% if content.status == '0' %}
                                    
                                        <tr>
                                            <td class="text-right">{{ loop.index }}.</td>
                                            <td id="title{{ content.content_id }}">{{ content.content_title }}</td>
                                            <td class="text-center">
                                                <img src="{{ base_url() }}{{ contents_image_path }}/thumbs/thumb_{{ content.name }}" class="img img-responsive" id="content-image" />
                                            </td>
                                            <td class="text-center">{{ content.date }}</td>
                                            
                                            {% if session.userdata.level == 'A' %}
                                            
                                                <td class="text-center"><a href="javascript:void" data-id="{{ content.username }}" data-name="{{ content.username }}">{{ content.fullname }}</a></td>
                                            
                                            {% endif %}
                                            
                                            <td class="text-center">

                                            {% if session.userdata.level == 'A' %}

                                                <button type="button" data-id="{{ content.content_id }}" data-name="{{ content.content_id }}" class="btn btn-publish btn-success btn-xs btn-flat"><span class="glyphicon glyphicon-eye-close"></span></button>

                                            {% else %}
                                                
                                                <strong style="color: red">Pending</strong>  <i class="fa fa-question-circle-o" aria-hidden="true" style="cursor: pointer;"></i>

                                            {% endif %}

                                            </td>
                                            <td class="text-center">
                                                <button type="button" data-id="{{ content.content_id }}" data-name="{{ content.content_id }}" class="btn btn-edit btn-default btn-xs btn-flat"><span class="glyphicon glyphicon-edit"></span></button>
                                                <button type="button" data-id="{{ content.content_id }}" data-name="{{ content.file_id }}" class="btn btn-delete btn-danger btn-xs btn-flat"><span class="glyphicon glyphicon-remove"></span></button>
                                            </td>
                                        </tr>

                                            {% endif %}
                                        {% endfor %}
                                    {% else %}

                                        <tr>
                                            <td class="text-center" colspan="6">Data is empty.</td>
                                        </tr>

                                    {% endif %}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="response-message">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Data {{ page_title }} (Published)
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="contents-list">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="3%">#</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Picture</th>
                                            <th class="text-center">Created Date</th>
                                            <th class="text-center">Modified Date</th>
                                            
                                            {% if session.userdata.level == 'A' %}
                                            
                                                <th class="text-center">Contributor</th>
                                            
                                            {% endif %}
                                            
                                            <th class="text-center" width="10%">Status</th>
                                            <th class="text-center" width="10%"><button type="button" class="btn btn-add btn-primary btn-xs btn-flat"><span class="glyphicon glyphicon-plus"></button></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    {% if contents | length > 0 %}
                                        {% for content in contents %}
                                            {% if content.status == '1' %}
                                    
                                        <tr>
                                            <td class="text-right">{{ loop.index }}.</td>
                                            <td id="title{{ content.content_id }}">{{ content.content_title }}</td>
                                            <td class="text-center">
                                                <img src="{{ base_url() }}{{ contents_image_path }}/thumbs/thumb_{{ content.name }}" class="img img-responsive" id="content-image" />
                                            </td>
                                            <td class="text-center">{{ content.cr_date }}</td>
                                            <td class="text-center">{{ content.date }}</td>
                                            
                                            {% if session.userdata.level == 'A' %}
                                            
                                                <td class="text-center"><a href="javascript:void" data-id="{{ content.username }}" data-name="{{ content.username }}">{{ content.fullname }}</a></td>
                                            
                                            {% endif %}
                                            
                                            <td class="text-center">

                                            {% if session.userdata.level == 'A' %}
                                                
                                                <button type="button" data-id="{{ content.content_id }}" data-name="{{ content.content_id }}" class="btn btn-publish btn-success btn-xs btn-flat"><span class="glyphicon glyphicon-eye-open"></span></button>

                                            {% else %}

                                                <strong style="color: green">Published</strong>
                                                
                                            {% endif %}

                                            </td>
                                            <td class="text-center">
                                                <button type="button" data-id="{{ content.content_id }}" data-name="{{ content.content_id }}" class="btn btn-comments btn-success btn-xs btn-flat"><span class="glyphicon glyphicon-comment"></span></button>
                                                <button type="button" data-id="{{ content.content_id }}" data-name="{{ content.content_id }}" class="btn btn-edit btn-default btn-xs btn-flat"><span class="glyphicon glyphicon-edit"></span></button>
                                                <button type="button" data-id="{{ content.content_id }}" data-name="{{ content.file_id }}" class="btn btn-delete btn-danger btn-xs btn-flat"><span class="glyphicon glyphicon-remove"></span></button>
                                            </td>
                                        </tr>

                                            {% endif %}
                                        {% endfor %}
                                    {% else %}

                                        <tr>
                                            <td class="text-center" colspan="6">Data is empty.</td>
                                        </tr>

                                    {% endif %}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {% endblock %}
        
        {% block js %}
            <script src="{{ base_url() }}assets/admin/js/contents/contents-handler.js"></script>
            <script>
                $(document).ready(function(){
                    var contents = ContentsHandler.createIt({
                        baseUrl: '{{ base_url() }}admin/{{ page_action }}'
                    });
                    contents.init();
                });
            </script>
        {% endblock %}