        {% extends "admin/base/base.tpl" %}

        {% block css %}

          <!-- Styles -->
          <link rel="stylesheet" href="{{ base_url() }}assets/admin/plugins/jqplot/jquery.jqplot.min.css" type="text/css" media="all" />
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
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Visitor Graph
                        </div>
                        <div class="panel-body">
                          <div class="table-responsive">
                            <div id="chart" style="width: 99%"></div>
                          </div>
                        </div>
                        <div class="panel-footer">
                            <i class="fa fa-circle" aria-hidden="true" style="color: #4bb2c5"></i> : Visit to sukakpop.com*
                            <br/>
                            <i class="fa fa-circle" aria-hidden="true" style="color: #eaa228"></i> : Read {Profile/News/Gossip/Article}**
                            <br/>
                            <i class="fa fa-circle" aria-hidden="true" style="color: #c5b47f"></i> : Watch (Chart)**
                            <br/>
                            <small style="margin-left: 30px">* Filtered by IP Address</small>
                            <br/>
                            <small style="margin-left: 30px">** Filtered by what visitor read or watched</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Latest Contents (Sort by created date descending)
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="contents-list">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="3%">#</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center" width="15%">Created Date</th>
                                            <th class="text-center" width="15%">Modified Date</th>
                                            <th class="text-center" width="5%">In</th>
                                            <th class="text-center" width="10%">Views</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-latest">

                                    {% if latest_contents | length > 0 %}
                                        {% for latest_content in latest_contents %}
                                    
                                            <tr>
                                                <td class="text-right">{{ loop.index }}.</td>
                                                <td><a href="{{ base_url() }}{{ latest_content.seo_url }}" target="_BLANK">{{ latest_content.content_title }}</a></td>
                                                <td class="text-center">{{ latest_content.cdate }}</td>
                                                <td class="text-center">{{ latest_content.date }}</td>
                                                <td class="text-center"><a href="{{ base_url() }}admin/{{ latest_content.page }}" target="_BLANK">{{ latest_content.page | capitalize }}</a></td>
                                                <td class="text-center">{{ latest_content.num_of_visitors }} Views</td>
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
                        <div class="panel-footer text-center">
                            <span id="num-of-loadlatest" hidden="hidden">5</span>
                            <button type="button" id="load-latest-contents" class="btn btn-default" style="min-width: 120px;">Load more....</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-thumbs-up" aria-hidden="true"></i> Popular Contents (Sort by number of visitor descending)
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="contents-list">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="3%">#</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center" width="5%">In</th>
                                            <th class="text-center" width="20%">Views</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-popular">

                                    {% if popular_contents | length > 0 %}
                                        {% for popular_content in popular_contents %}
                                    
                                            <tr>
                                                <td class="text-right">{{ loop.index }}.</td>
                                                <td><a href="{{ base_url() }}{{ popular_content.seo_url }}" target="_BLANK">{{ popular_content.content_title }}</a></td>
                                                <td class="text-center">{{ popular_content.date }}</td>
                                                <td class="text-center"><a href="{{ base_url() }}admin/{{ popular_content.page }}" target="_BLANK">{{ popular_content.page | capitalize }}</a></td>
                                                <td class="text-center">{{ popular_content.num_of_visitors }} Views</td>
                                            </tr>

                                        {% endfor %}
                                    {% else %}

                                        <tr>
                                            <td class="text-center" colspan="4">Data is empty.</td>
                                        </tr>

                                    {% endif %}
                                    </tbody>
                                </table>
                                <div class="text-center">
                                    <i id="loading-popular"></i>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-center">
                            <span id="num-of-loadpopular" hidden="hidden">5</span>
                            <button type="button" id="load-popular-content" class="btn btn-default" style="min-width: 120px;">Load more....</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {% endblock %}
        
        {% block js %}
            <script src="{{ base_url() }}assets/admin/js/home/home-handler.js"></script>
            <script>
                $(document).ready(function(){
                    var home = HomeHandler.createIt({
                        baseUrl: '{{ base_url() }}admin/content',
                    });
                    home.init();
                });
            </script>

            <script src="{{ base_url() }}assets/admin/plugins/jqplot/jquery.jqplot.min.js"></script>
            <script src="{{ base_url() }}assets/admin/plugins/jqplot/plugins/jqplot.json2.js"></script>
            <script type="text/javascript" src="{{ base_url() }}assets/admin/plugins/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
            <script type="text/javascript" src="{{ base_url() }}assets/admin/plugins/jqplot/plugins/jqplot.barRenderer.min.js"></script>
            <script type="text/javascript" src="{{ base_url() }}assets/admin/plugins/jqplot/plugins/jqplot.highlighter.min.js"></script>
            <script type="text/javascript" src="{{ base_url() }}assets/admin/plugins/jqplot/plugins/jqplot.cursor.min.js"></script>
            <script type="text/javascript" src="{{ base_url() }}assets/admin/plugins/jqplot/plugins/jqplot.pointLabels.min.js"></script>

            <!-- Chart code -->
            <script>
            (function() {
              var dataSrc = "{{ base_url() }}admin/content/loadDataChart";
              $.getJSON(dataSrc, {
                format: "json"
              })
              .done(function(data){
                var dataVisitor = new Array(data.length);
                var dataReader = new Array(data.length);
                var dataWatcher = new Array(data.length);
                var max = 0;

                for(var i = 0; i < data.length; i++)
                {
                  var dsplit = data[i].split(",");
                  dataVisitor[i] =  [dsplit[0], dsplit[1]];

                  if(max < dsplit[1])
                  {
                    max = eval(dsplit[1]);
                  }
                }

                for(var i = 0; i < data.length; i++)
                {
                  var dsplit = data[i].split(",");
                  dataReader[i] =  [dsplit[0], dsplit[2]];

                  if(max < dsplit[2])
                  {
                    max = eval(dsplit[2]);
                  }
                }

                for(var i = 0; i < data.length; i++)
                {
                  var dsplit = data[i].split(",");
                  dataWatcher[i] =  [dsplit[0], dsplit[3]];

                  if(max < dsplit[3])
                  {
                    max = eval(dsplit[3]);
                  }
                }

                max += 10;

                $.jqplot ('chart', [dataVisitor, dataReader, dataWatcher],{
                  title:'Visitor Chart',
                  animate: true,
                  animateReplot: true,
                  cursor: {
                    show: true,
                    zoom: true,
                    looseZoom: true,
                    showTooltip: false
                  },
                  highlighter: {
                    show: true, 
                    showLabel: true, 
                    tooltipAxes: 'y',
                    sizeAdjust: 7.5,
                    tooltipLocation: 'ne'
                  },
                  axes:{
                    xaxis:{
                      renderer:$.jqplot.DateAxisRenderer, 
                      tickOptions:{formatString:'%b %#d'},
                      tickInterval:'1 day'
                    },
                    yaxis: {
                        min:0,
                        max:max
                    }
                  }
                });
              });
            })();
            </script>
        {% endblock %}