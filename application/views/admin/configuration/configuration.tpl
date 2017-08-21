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
                            Setup Fan Pages
                        </div>
                        <div class="panel-body">
                            <form id="form-action-fan-page" role="form" method="post" action="">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group facebook-page-group">
                                            <label>Facebook Page Url <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                                            <input type="text" class="form-control" name="facebook-page" id="facebook-page" value="{{ fan_page.fan_page_fb }}">
                                            <p class="help-block facebook-page-msg"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group twitter-page-group">
                                            <label>Twitter Page Url <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                                            <input type="text" class="form-control" name="twitter-page" id="twitter-page" value="{{ fan_page.fan_page_twitter }}">
                                            <p class="help-block twitter-page-msg"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group gplus-page-group">
                                            <label>Google Plus Page Url <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                                            <input type="text" class="form-control" name="gplus-page" id="gplus-page" value="{{ fan_page.fan_page_gplus }}">
                                            <p class="help-block gplus-page-msg"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box-footer pull-right">
                                            <div>
                                                <label id="fan-page-id" hidden="hidden">{{ fan_page.fan_page_id }}</label>
                                                <button type="submit" class="btn btn-success" style="min-width: 120px;">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="response-message">
                    </div>
					<div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Setup Pages & SEO Page</h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="pages-list">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Page ID</th>
                                            <th class="text-center">Page Title</th>
                                            <th class="text-center">Page Url</th>
                                            <th class="text-center">Parent ID</th>
                                            <th class="text-center">Front End</th>
                                            <th class="text-center">Back End</th>
                                            <th class="text-center">Modified Date</th>
                                            <th class="text-center">Modified By</th>
                                            <th class="text-center" width="10%"><button id="-add-pages" type="button" class="btn btn-primary btn-xs btn-flat"><span class="glyphicon glyphicon-plus"></button></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    {% if pages | length > 0 %}
                                        {% for page in pages %}
                                        <tr>
                                            <td class="text-center">{{ page.page_id }}</td>
                                            <td>{{ page.page_title }}</td>
                                            <td id="page-url{{ page.page_id }}">{{ page.page_url }}</td>
                                            <td class="text-center">{{ page.parent_id }}</td>
                                            <td class="text-center">{{ page.front_end }}</td>
                                            <td class="text-center">{{ page.back_end }}</td>
                                            <td class="text-center">{{ page.date }}</td>
                                            <td class="text-center">{{ page.modified_by }}</td>
											<td class="text-center">

                                            {% if page.default == 0 %}

												<button type="button" data-id="{{ page.page_id }}" class="btn btn-edit btn-default btn-xs btn-flat"><span class="glyphicon glyphicon-edit"></span></button>
												<button type="button" data-id="{{ page.page_id }}" class="btn -btn-delete btn-danger btn-xs btn-flat"><span class="glyphicon glyphicon-remove"></span></button>

                                            {% else %}

                                                <button type="button" data-id="{{ page.page_id }}" class="btn btn-edit btn-default btn-xs btn-flat"><span class="glyphicon glyphicon-edit"></span></button> <i class="fa fa-question-circle-o" aria-hidden="true" title="Unavailable to delete. This is default menu."></i>

                                            {% endif %}

											</td>
                                        </tr>
                                        {% endfor %}
                                    {% else %}
                                        <tr>
                                            <td class="text-center" colspan="7">Data is empty.</td>
                                        </tr>
                                    {% endif %}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="button" class="btn btn-success btn-sitemap" style="min-width: 120px;">Refresh Sitemap</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {% endblock %}
        
        {% block js %}
            <script src="{{ base_url() }}assets/admin/js/configuration/configuration-handler.js"></script>
            <script>
                $(document).ready(function(){
                    var configuration = ConfigurationHandler.createIt({
                        baseUrl: '{{ base_url() }}admin/configuration'
                    });
                    configuration.init();
                });
            </script>
        {% endblock %}