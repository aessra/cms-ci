<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robot" content="noindex,nofollow" />
		<link rel="shortcut icon" href="{{ base_url() }}assets/client/img/favicon.ico" type="image/x-icon">
		<link rel="icon" href="{{ base_url() }}assets/client/img/favicon.ico" type="image/x-icon">
        <title>K-Pop Panel</title>

        {% include "admin/base/css.tpl" %}

        {% block css %}
        {% endblock %}
		
    </head>

    <body>
	
        <div id="wrapper">

            {% include "admin/base/header.tpl" %}
            {% include "admin/base/left.sidebar.tpl" %}

            {% block content %}
            {% endblock %}
			
        </div>
        <!-- /#wrapper -->

        <div class="mask"></div>
        <div class="loader" style="display: none">Loading...</div>
            
        <div class="modal delete-confirmation">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Delete Confirmation</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure want to remove this record ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default delete-no" data-dismiss="modal">No</button>
                        <button type="button" class="btn btn-primary delete-yes">Yes</button>
                    </div>
                </div>
            </div>
        </div>
            
        <div class="modal publish-confirmation">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Publish Confirmation</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure want to publish this record ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default publish-no" data-dismiss="modal">No</button>
                        <button type="button" class="btn btn-primary publish-yes">Yes</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal upload-confirmation">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Upload an Image <i class="fa fa-question-circle-o" aria-hidden="true" style="cursor: pointer;" title="Max. Size : {{ max_size_text }} / Extension Allowed : {{ image_extension }}"></i> </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <input class="btn btn-default" type="file" id="upload" accept=".jpg, .jpeg">
                            </div>
                            <div class="col-sm-6 text-right">
                                <button class="btn btn-success upload-result">Upload Image</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <div id="upload-demo"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                         <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        {% include "admin/base/js.tpl" %}
        {% block js %}
        {% endblock %}

    </body>

</html>