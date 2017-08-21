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
                            View and Publish a Content
                        </div>
                        <div class="panel-body">
                            <div class="box-body text-justify">
                                <h4>{{ content.content_title }}</h4>
                                <hr/>
                                <img src="{{ base_url() }}{{ contents_image_path }}{{ content.name }}" class="img img-responsive">
                                <hr/>
                                <div class="col-md-12">
                                    <div class="form-group description-group">
                                        <textarea class="form-control tiny-mce" id="description" name="description" placeholder="Description" cols="100%" rows="20%">{{ content.content_description }}</textarea>
                                    </div>
                                </div>
                           	</div>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="response-message">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-right">
                                        <button type="button" id="cancel" class="btn btn-default" style="min-width: 120px;">Cancel</button>
                                        <button type="submit" class="btn btn-success" id="btn-publish" data-name="{{ content.content_id }}" data-id="{{ content.status }}" style="min-width: 120px;">Publish</button>
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
            <script src="{{ base_url() }}assets/admin/js/contents/contents-handler.js"></script>
            <script type="text/javascript">
                'use strict';
                var TinyMce = {
                    init: function(options){
                        tinymce.init({
                            selector: "textarea.tiny-mce",
                            readonly : 1,
                            document_base_url : options.baseUrl
                        });
                    }
                }
            </script>
            <script>
                var handler = ContentsHandler.createIt({
                    baseUrl: '{{ base_url() }}admin/{{ page_action }}',
                    fresh_content: '{{ content.fresh_content }}'
                });
                
                handler.init();
            </script>
		{% endblock %}