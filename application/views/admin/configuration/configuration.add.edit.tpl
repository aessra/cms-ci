            {% extends "admin/base/base.tpl" %}

            {% block css %}
            {% endblock %}
            
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
                                Add or Edit Page
                            </div>
                            <div class="panel-body">
                                <form id="img-upload-img" method="post" enctype="multipart/form-data" style="">
                                    <input type="hidden" id="img-id" name="img-id" value="">
                                </form>
                                <form id="form-action" role="form" method="post" enctype="multipart/form-data" action="">
                                    <div class="box-body">
                                        <div class="response-message">
                                        </div>
                                        <div class="row" id="bg-data">
                                            <div class="col-md-6">
                                                <div class="form-group page-url-group">
                                                    <label>Action</label>
                                                    <input type="text" class="form-control" name="act" id="act" value="{{ act }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group page-url-group">
                                                    <label>Page Url [Old]</label>
                                                    <input type="text" class="form-control" name="page-url-old" id="page-url-old" value="{{ page.page_url }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group page-id-group">
                                                    <label>Page ID <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                                                    
                                                    {% if page.page_id is empty %}

                                                        <input type="text" class="form-control" name="page-id" id="page-id" value="{{ page_id }}" readonly="readonly">

                                                    {% else %}
                                                    
                                                        <input type="text" class="form-control" name="page-id" id="page-id" value="{{ page.page_id }}" readonly="readonly">

                                                    {% endif %}

                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group page-title-group">
                                                    <label>Page Title <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                                                    <input type="text" class="form-control" name="page-title" id="page-title" value="{{ page.page_title }}">
                                                    <p class="help-block page-title-msg"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group page-url-group">
                                                    <label>Page URL <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                                                    
                                                    {% if page.page_url == 'configuration' %}
                                                    
                                                    	<input type="text" class="form-control" name="page-url" id="page-url" value="{{ page.page_url }}" readonly="readonly">
                                                    
                                                    {% elseif page.page_url == 'subscriber' %}
                                                    
                                                    	<input type="text" class="form-control" name="page-url" id="page-url" value="{{ page.page_url }}" readonly="readonly">
                                                    
                                                    {% elseif page.page_url == 'contributor' %}
                                                    
                                                    	<input type="text" class="form-control" name="page-url" id="page-url" value="{{ page.page_url }}" readonly="readonly">
                                                    
                                                    {% else %}
                                                    
                                                    	<input type="text" class="form-control" name="page-url" id="page-url" value="{{ page.page_url }}">
                                                    
                                                    {% endif %}
                                                    
                                                    <p class="help-block page-url-msg"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group is-parent-group">
                                                    <label>Is Parent? <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                                                    <select class="form-control" name="is-parent" id="is-parent" disabled="disabled">
                                                        <option value="{{ page.is_parent }}">{{ page.is_parent }}</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                    </select>
                                                    <p class="help-block is-parent-msg"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group parent-id-group">
                                                    <label>Parent ID <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                                                    <select class="form-control" name="parent-id" id="parent-id" disabled="disabled">

                                                        {% if page.parent_id is not empty %}

                                                            <option value="{{ page.parent_id }}">{{ page.parent_id }}</option>

                                                        {% else %}

                                                            <option value="0">0</option>

                                                        {% endif %}

                                                        {% if page_ids_for_parent_id | length > 0 %}

                                                            {% for page_id_for_parent_id in page_ids_for_parent_id %}

                                                                <option value="{{ page_id_for_parent_id.page_id }}">{{ page_id_for_parent_id.page_title }}</option>

                                                            {% endfor %}

                                                        {% else %}

                                                            <option value="0">0</option>

                                                        {% endif %}
                                                    </select>
                                                    <p class="help-block parent-id-msg"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group show-menu-group">
                                                    <label>Show Menu <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                                                    <select class="form-control" name="show-menu" id="show-menu" disabled="disabled">
                                                        <option value="{{ page.show_menu }}">{{ page.show_menu }}</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                    </select>
                                                    <p class="help-block show-menu-msg"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group back-end-group">
                                                    <label>Back End <i class="fa fa-question-circle-o" aria-hidden="true" title="1 if menu will displayed in contributor side, otherwise 0"></i></label>
                                                    <select class="form-control" name="back-end" id="back-end" disabled="disabled">
                                                        <option value="{{ page.back_end }}">{{ page.back_end }}</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                    </select>
                                                    <p class="help-block back-end-msg"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group front-end-group">
                                                    <label>Front End <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                                                    <select class="form-control" name="front-end" id="front-end" disabled="disabled">
                                                        <option value="{{ page.front_end }}">{{ page.front_end }}</option>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                    </select>
                                                    <p class="help-block front-end-msg"></p>
                                                </div>
                                            </div>
                                        </div>

                                        <hr/>

                                        <!-- CEO Optimation -->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-success">
                                                    <div class="panel-heading">
                                                        SEO Optimation <i class="fa fa-question-circle-o" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group seo-title-group">
                                                                    <label for="seo-title">Meta Title <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                                                                    <textarea class="form-control" id="seo-title" name="seo-title" placeholder="Meta Title" cols="100%" rows="5%">{{ page.seo_title }}</textarea>
                                                                    <p class="help-block seo-title-msg"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group seo-author-group">
                                                                    <label for="seo-author">Meta Author <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                                                                    <textarea class="form-control" id="seo-author" name="seo-author" placeholder="Meta Author" cols="100%" rows="5%">{{ page.seo_author }}</textarea>
                                                                    <p class="help-block seo-author-msg"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group seo-keywords-group">
                                                                    <label for="seo-keywords">Meta Keyword <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                                                                    <textarea class="form-control" id="seo-keywords" name="seo-keywords" placeholder="Meta Keywords" cols="100%" rows="5%">{{ page.seo_keywords }}</textarea>
                                                                    <p class="help-block seo-keywords-msg"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group seo-desc-group">
                                                                    <label for="seo-desc">Meta Description <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                                                                    <textarea class="form-control" id="seo-desc" name="seo-desc" placeholder="Meta Description" cols="100%" rows="5%">{{ page.seo_desc }}</textarea>
                                                                    <p class="help-block seo-desc-msg"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="box-footer pull-right">
                                        <div>
                                            <button type="button" id="cancel" class="btn btn-default" style="min-width: 120px;">Cancel</button>
                                            <button type="submit" class="btn btn-success" style="min-width: 120px;">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {% endblock %}

            {% block js %}
    			<script src="{{ base_url() }}assets/admin/js/configuration/configuration-addedit-handler.js"></script>
                <script>
                    var handler = AddEditHandler.createIt({
                        baseUrl: '{{ base_url() }}admin/configuration'
                    });
                    
                    handler.init();
                </script>
    		{% endblock %}