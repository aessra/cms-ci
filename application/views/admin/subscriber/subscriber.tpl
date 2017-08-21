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
                            Subscriber
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="subscribers-list">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="2%">#</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Date</th>

                                            <th class="text-center" width="10%">
                                                Act
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    {% if subscribers | length > 0 %}
                                        {% for subscriber in subscribers %}
                                        <tr>
                                            <td class="text-right">{{ loop.index }}.</td>
                                            <td class="text-center">{{ subscriber.subscriber_email }}</td>
                                            <td class="text-center">{{ subscriber.date }}</td>
											<td class="text-center">
												<button type="button" data-id="{{ subscriber.subscriber_id }}" data-name="{{ subscriber.subscriber_id }}" class="btn btn-delete btn-danger btn-xs btn-flat"><span class="glyphicon glyphicon-remove"></span></button>
											</td>
                                        </tr>
                                        {% endfor %}
                                    {% else %}
                                        <tr>
                                            <td class="text-center" colspan="4">Data is empty.</td>
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
            <script src="{{ base_url() }}assets/admin/js/subscribers/subscribers-handler.js"></script>
            <script>
                $(document).ready(function(){
                    var subscriber = SubscriberHandler.createIt({
                        baseUrl: '{{ base_url() }}admin/subscriber'
                    });
                    subscriber.init();
                });
            </script>
        {% endblock %}