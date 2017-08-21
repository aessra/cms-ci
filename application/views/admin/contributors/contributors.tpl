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
                            Contributor
                        </div>
                        <div class="panel-body">
                            <div class="response-message">
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover" id="contributors-list">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="3%">#</th>
                                            <th class="text-center">Username</th>
                                            <th class="text-center">Full Name</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Phone</th>
											<th class="text-center" width="10%"><button id="add-user" type="button" class="btn btn-primary btn-xs btn-flat btn-add"><span class="glyphicon glyphicon-plus"></button></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    {% if contributors | length > 0 %}
                                        {% for contributor in contributors %}
                                        <tr>
                                            <td class="text-right">{{loop.index}}.</td>
                                            <td>{{ contributor.username }}</td>
                                            <td>{{ contributor.fullname }}</td>
                                            <td>{{ contributor.email }}</td>
                                            <td>{{ contributor.address}}</td>
                                            <td>{{ contributor.phone }}</td>
											<td class="text-center">
												<button type="button" data-id="{{ contributor.username }}" data-name="{{ contributor.username }}" class="btn btn-edit btn-default btn-xs btn-flat"><span class="glyphicon glyphicon-edit"></span></button>
												<button type="button" data-id="{{ contributor.username }}" data-name="{{ contributor.file_id }}" class="btn btn-delete btn-danger btn-xs btn-flat"><span class="glyphicon glyphicon-remove"></span></button>
											</td>
                                        </tr>
                                        {% endfor %}
                                    {% else %}
                                        <tr>
                                            <td class="text-center" colspan="7">Data is empty</td>
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
            <script src="{{ base_url() }}assets/admin/js/contributors/contributor-handler.js"></script>
            <script>
                $(document).ready(function(){
                    var contributor = ContributorHandler.createIt({
                        baseUrl: '{{ base_url() }}admin/contributor'
                    });
                    contributor.init();
                });
            </script>
        {% endblock %}