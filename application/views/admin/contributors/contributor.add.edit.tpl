			{% extends "admin/base/base.tpl" %}
			
			{% block css %}
			<link rel="stylesheet" href="{{ base_url() }}assets/admin/plugins/datepicker/datepicker3.css">
			<link rel="stylesheet" href="{{ base_url() }}assets/admin/plugins/daterangepicker/daterangepicker-bs3.css">
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
	                            <span id="act">{{ act }}</span> a contributor
	                        </div>

	                        <div class="panel-body">
	                            <div class="box-body">
	                                <form id="img-upload-img" method="post" enctype="multipart/form-data" style="">
	                                    <input type="hidden" id="img-id" name="img-id" value="">
	                                </form>
	                                <form id="form-action" role="form" method="post" enctype="multipart/form-data" action="">
	                                    <div class="box-body">
	                                        <div class="response-message">
	                                        </div>
	                                        <div class="row">

	                                            <div class="row" id="bg-data" hidden="hidden">
													<div class="col-md-6">
														<div class="form-group">
															<label>File ID</label>
															{% if contributor.file_id is not empty %}
																<input type="text" class="form-control" id="file-id" name="file-id" value="{{ contributor.file_id }}">
															{% else %}
																<input type="text" class="form-control" id="file-id" name="file-id" value="{{ file_id }}">
															{% endif %}
						                                </div>
						                            </div>
						                            <div class="col-md-6">
														<div class="form-group">
															<label>File ID Edit</label>
						                                    {% if file_id_edit is not empty %}
						                                    	<input type="text" class="form-control" id="file-id-edit" name="file-id-edit" value="{{ file_id_edit }}">
						                                    {% endif %}
						                                </div>
						                            </div>
						                        </div>

	                                            <div class="col-md-4">
	                                                <div class="form-group img-group">
	                                                    {% if contributor.name is not empty %}
	                                                    
	                                                        <img src="{{ base_url() }}{{ user_image_path }}/{{ contributor.name }}" class="img img-responsive" style="margin-bottom: 10px">

	                                                    {% else %}
	                                                    
	                                                        <div>No Picture</div>

	                                                    {% endif %}

	                                                    
	                                                        <label for="file-img" class="col-md-12" style="padding: 0;">Icon <i class="fa fa-question-circle-o" aria-hidden="true" style="cursor: pointer;"></i></label>
	                                                        <button id="upload-btn-img" class="btn btn-primary">Choose File</button>
	                                                        <span id="filename-img" class="" style=""></span>
	                                                        <p class="help-block">Extension Allowed : {{ image_extension }}</p>
	                                                        <p class="help-block">Max. Size : {{ max_size_text }}</p>
	                                                        <p class="help-block" id="bg-data">Action : <span id="act">{{ act }}</span></p>
	                                                        <p class="help-block img-msg"></p>
	                                                        
	                                                        <div id="progress-outer-img" class="progress progress-striped active" style="display:none;">
	                                                            <div id="progress-bar-img" class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
	                                                            </div>
	                                                        </div>
	                                                </div>
	                                            </div>
	                                            <div class="col-md-8">
	                                                <div class="form-group pre-username-group" id="bg-data">
	                                                    <label>Pre Username: <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
	                                                    <input class="form-control" type="text" name="pre-username" id="pre-username" value="{{ contributor.username }}" />
	                                                    <p class="help-block pre-username-msg"></p>
	                                                </div>
	                                                <div class="form-group username-group">
	                                                    <label>Username: <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
	                                                    <input class="form-control" type="text" name="username" id="username" value="{{ contributor.username }}" autofocus="autofocus" />
	                                                    <p class="help-block username-msg"></p>
	                                                </div>
	                                                <div class="form-group fullname-group">
	                                                    <label>Full Name: <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
	                                                    <input class="form-control" type="text" name="fullname" id="fullname" value="{{ contributor.fullname }}" />
	                                                    <p class="help-block fullname-msg"></p>
	                                                </div>
	                                                <div class="form-group email-group">
	                                                    <label>Email: <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
	                                                    <input class="form-control" type="text" name="email" id="email" value="{{ contributor.email }}" />
	                                                    <p class="help-block email-msg"></p>
	                                                </div>
	                                                <div class="form-group phone-group">
	                                                    <label>Phone: <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
	                                                    <input class="form-control" type="text" name="phone" id="phone" value="{{ contributor.phone }}" onKeyPress="return check(event,value)" />
	                                                    <p class="help-block phone-msg"></p>
	                                                </div>
	                                                <div class="form-group address-group">
	                                                    <label>Address: <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
	                                                    <input class="form-control" type="text" id="address" name="address" value="{{ contributor.address }}" />
	                                                    <p class="help-block address-msg"></p>
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </div>
	                                    <div class="box-footer">
	                                        <div class="pull-right">
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
            </div>
			{% endblock %}
			
			{% block js %}
			<script src="{{ base_url() }}assets/admin/plugins/datepicker/bootstrap-datepicker.js"></script>
			<script src="{{ base_url() }}assets/admin/js/contributors/contributor-addedit-handler.js"></script>
			<script>
				var handler = AddEditHandler.createIt({
					baseUrl: '{{ base_url() }}admin/contributor',
					ext: '{{ image_extension }}',
					max_size: '{{ max_size }}',
					max_size_text: '{{ max_size_text }}'
				});
				handler.init();
			</script>
			<script type="text/javascript">
				function check(e,value)
				{
				    //Check Charater
				    var unicode=e.charCode? e.charCode : e.keyCode;
				    if (value.indexOf(".") != -1)if( unicode == 46 )return false;
				    if (unicode!=8)if((unicode<48||unicode>57)&&unicode!=46)return false;
				}
			</script>
			{% endblock %}