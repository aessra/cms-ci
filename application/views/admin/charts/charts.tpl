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
                            Data Chart
                        </div>
                        <div class="panel-body">
                            <small style="color: red">Note: Data yang ditampilkan di halaman depan hanya 10 chart teratas.</small>
                            <div class="table-responsive">
                                <div class="response-message">
                                </div>
                                <table class="table table-hover" id="charts-list">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="3%">#</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Album</th>
                                            <th class="text-center">Artist/Band</th>
                                            <th class="text-center">Genres</th>
                                            <th class="text-center">Position</th>
                                            <th class="text-center">Pre-Position</th>
                                            <th class="text-center" width="10%"><button id="add-chart" type="button" class="btn btn-primary btn-xs btn-flat"><span class="glyphicon glyphicon-plus"></button></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    {% if charts | length > 0 %}
                                        {% for chart in charts %}

                                        <tr>
                                            <td class="text-right">{{ loop.index }}.</td>
                                            <td id="title{{ chart.chart_id }}">{{ chart.chart_title }}</td>
                                            <td>{{ chart.chart_album }}</td>
                                            <td>{{ chart.chart_artist_band }}</td>
                                            <td class="text-center">{{ chart.chart_genre }}</td>
                                            <td class="text-center" id="position{{ chart.chart_id }}">{{ chart.position }}</td>
                                            <td class="text-center">

                                            {% if chart.position == chart.pre_position %}
                                                
                                                -

                                            {% else %}
                                                
                                                {{ chart.pre_position }}

                                            {% endif %}

                                            </td>
                                            <td class="text-center">
                                                <button type="button" data-id="{{ chart.chart_id }}" data-name="{{ chart.chart_id }}" class="btn btn-comments btn-success btn-xs btn-flat"><span class="glyphicon glyphicon-comment"></span></button>
                                                <button type="button" data-id="{{ chart.chart_id }}" data-name="{{ chart.file_id }}" class="btn btn-edit btn-default btn-xs btn-flat"><span class="glyphicon glyphicon-edit"></span></button>
                                                <button type="button" data-id="{{ chart.chart_id }}" data-name="{{ chart.file_id }}" class="btn btn-delete btn-danger btn-xs btn-flat"><span class="glyphicon glyphicon-remove"></span></button>
                                            </td>
                                        </tr>

                                        {% endfor %}
                                    {% else %}

                                        <tr>
                                            <td class="text-center" colspan="8">Data is empty.</td>
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
            <script src="{{ base_url() }}assets/admin/js/charts/charts-handler.js"></script>
            <script>
                $(document).ready(function(){
                    var charts = ChartsHandler.createIt({
                        baseUrl: '{{ base_url() }}admin/chart',
                        news_image_path: '{{ news_image_path }}',
                        ext: '{{ image_extension }}',
                        max_size: '{{ max_size }}',
                        max_size_text: '{{ max_size_text }}'
                    });
                    charts.init();
                });
            </script>
        {% endblock %}