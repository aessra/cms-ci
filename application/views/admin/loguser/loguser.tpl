        {% extends "admin/base/base.tpl" %}

        {% block css %}

          <!-- Styles -->
          <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
          <style>
          #chartdiv {
            width: 100%;
            height: 500px;
          }

          .amcharts-export-menu-top-right {
            top: 10px;
            right: 0;
          }
          </style>
        {% endblock %}

        {% block content %}

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <hr/>
                </div>
            </div>
            <!-- /.row -->
            <!--
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Reader Graph
                        </div>
                        <div class="panel-body">
                          <div class="table-responsive">
                            <div id="chartdiv"></div>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Watcher Graph
                        </div>
                        <div class="panel-body">
                          <div class="table-responsive">
                            <div id="chartdiv"></div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
            -->
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Log Data Reader
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="contents-list">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="3%">#</th>
                                            <th class="text-center">IP Address</th>
                                            <th class="text-center" width="25%">Date Time</th>
                                            <th class="text-center" width="35%">Visit to</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-latest">

                                    {% if log_read | length > 0 %}
                                        {% for log in log_read %}
                                    
                                            <tr>
                                                <td class="text-right">{{ loop.index }}.</td>
                                                <td class="text-center">{{ log.ip_address }}</td>
                                                <td class="text-center">{{ log.date_time }}</td>
                                                <td class="text-center">
                                                    {% if log.detail != NULL %}
                                                    
                                                        {{ log.detail|slice(0, 15) }}...

                                                    {% endif %}
                                                </td>
                                            </tr>

                                        {% endfor %}
                                    {% else %}

                                        <tr>
                                            <td class="text-center" colspan="5">Data is empty.</td>
                                        </tr>

                                    {% endif %}
                                    </tbody>
                                </table>
                                <div class="text-center">
                                    <i id="loading-latest"></i>
                                </div>
                            </div>
                        </div>
                        <!--
                        <div class="panel-footer text-center">
                            <span id="num-of-loadlatest" hidden="hidden">5</span>
                            <button type="button" id="load-latest-contents" class="btn btn-default" style="min-width: 120px;">Load more....</button>
                        </div>
                        -->
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-thumbs-up" aria-hidden="true"></i> Log Data Watcher
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="contents-list">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="3%">#</th>
                                            <th class="text-center">IP Address</th>
                                            <th class="text-center" width="25%">Date Time</th>
                                            <th class="text-center" width="35%">Visit to</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-latest">

                                    {% if log_watch | length > 0 %}
                                        {% for log in log_watch %}
                                    
                                            <tr>
                                                <td class="text-right">{{ loop.index }}.</td>
                                                <td class="text-center">{{ log.ip_address }}</td>
                                                <td class="text-center">{{ log.date_time }}</td>
                                                <td class="text-center">
                                                    {% if log.detail != NULL %}

                                                        {{ log.detail|slice(0, 15) }}...

                                                    {% endif %}
                                                </td>
                                            </tr>

                                        {% endfor %}
                                    {% else %}

                                        <tr>
                                            <td class="text-center" colspan="5">Data is empty.</td>
                                        </tr>

                                    {% endif %}
                                    </tbody>
                                </table>
                                <div class="text-center">
                                    <i id="loading-popular"></i>
                                </div>
                            </div>
                        </div>
                        <!--
                        <div class="panel-footer text-center">
                            <span id="num-of-loadpopular" hidden="hidden">5</span>
                            <button type="button" id="load-popular-content" class="btn btn-default" style="min-width: 120px;">Load more....</button>
                        </div>
                        -->
                    </div>
                </div>
            </div>
        </div>

        {% endblock %}
        
        {% block js %}
            <!--
            <script src="{{ base_url() }}assets/admin/plugins/amchart/amcharts.js"></script>
            <script src="{{ base_url() }}assets/admin/plugins/amchart/serial.js"></script>
            <script src="{{ base_url() }}assets/admin/plugins/amchart/export.min.js"></script>
            <script src="{{ base_url() }}assets/admin/plugins/amchart/light.js"></script>
            <script src="{{ base_url() }}assets/admin/plugins/amchart/dataloader.min.js"></script>
            -->

            <!-- Chart code -->
            <!--
            <script>
            var chart = AmCharts.makeChart("chartdiv", {
              "type": "serial",
              "theme": "light",
              "marginRight": 70,
              "dataLoader": {
                "url": "http://sukakpop.com/admin/content/loadDataChart"
              },
              "valueAxes": [{
                "axisAlpha": 0,
                "position": "left",
                "title": "Number of Visitor"
              }],
              "startDuration": 1,
              "graphs": [{
                "valueField": "visits",
                "bullet": "round",
                "bulletBorderColor": "#FFFFFF",
                "bulletBorderThickness": 2,
                "lineThickness ": 2,
                "lineAlpha": 0.5
              }],
              "chartCursor": {
                "categoryBalloonEnabled": false,
                "cursorAlpha": 0,
                "zoomable": false
              },
              "categoryField": "date",
              "categoryAxis": {
                "gridPosition": "start",
                "labelRotation": 45
              },
              "export": {
                "enabled": true
              }

            });
            </script>
            -->
        {% endblock %}