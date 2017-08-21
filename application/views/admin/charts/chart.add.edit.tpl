			{% extends "admin/base/base.tpl" %}
			
			{% block css %}
			<link rel="stylesheet" href="{{ base_url() }}assets/admin/plugins/datepicker/datepicker3.css">
			<link rel="stylesheet" href="{{ base_url() }}assets/admin/plugins/daterangepicker/daterangepicker-bs3.css">
			<link rel="stylesheet" href="{{ base_url() }}assets/admin/dist/css/croppie.css">
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
	                            <span id="act">{{ act }}</span> Chart
	                        </div>
							<div class="panel-body">
								<form id="form-action" role="form" method="post" enctype="multipart/form-data" action="">
									<div class="box-body">
										<div class="row" id="bg-data">
				                            <div class="col-md-6">
												<div class="form-group">
													<label>Chart ID</label>

													{% if chart.chart_id is not empty %}
														{% if content.content_id == 'no-file' %}
				                                    		
				                                    		<input type="text" class="form-control" name="chart-id" id="chart-id" value="{{ file_id }}">

				                                    	{% else %}

				                                    		<input type="text" class="form-control" name="chart-id" id="chart-id" value="{{ chart.chart_id }}">

				                                    	{% endif %}
				                                    {% else %}

				                                    	<input type="text" class="form-control" name="chart-id" id="chart-id" value="{{ file_id }}">

				                                    {% endif %}

				                                </div>
				                            </div>
				                            <div class="col-md-6">
				                            	<div class="form-group">
				                            		<label>Old Title</label>
				                            		<input type="text" name="old-title" id="old-title" class="form-control" value="{{ chart.chart_title }}">
				                            	</div>
				                            </div>
				                        </div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group title-group">
													<label for="title">Title <i class="fa fa-question-circle-o" aria-hidden="true" style="cursor: pointer;"></i></label>
													<input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{ chart.chart_title }}">
													<p class="help-block title-msg"></p>
												</div>
											</div><div class="col-md-6">
												<div class="form-group album-group">
													<label for="album">Album <i class="fa fa-question-circle-o" aria-hidden="true" style="cursor: pointer;"></i></label>
													<input type="text" class="form-control" id="album" name="album" placeholder="Album" value="{{ chart.chart_album }}">
													<p class="help-block album-msg"></p>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group artis-band-group">
													<label for="artist_band">Artist/Band <i class="fa fa-question-circle-o" aria-hidden="true" style="cursor: pointer;"></i></label>
													<input type="text" class="form-control" id="artis-band" name="artis-band" placeholder="Artis/Band" value="{{ chart.chart_artist_band }}">
													<p class="help-block artis-band-msg"></p>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group genre-group">
													<label for="genre">Genre <i class="fa fa-question-circle-o" aria-hidden="true" style="cursor: pointer;"></i></label>
													<input type="text" class="form-control" id="genre" name="genre" placeholder="Genre" value="{{ chart.chart_genre }}">
													<p class="help-block genre-msg"></p>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group url-group">
													<label for="url">External Url (ex: Youtube) <i class="fa fa-question-circle-o" aria-hidden="true" style="cursor: pointer;"></i></label>
													<input type="text" class="form-control" id="url" name="url" placeholder="Url" value="{{ chart.ext_url }}">
													<p class="help-block url-msg"></p>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group position-group">
													<label for="position">Position <i class="fa fa-question-circle-o" aria-hidden="true" style="cursor: pointer;"></i></label>
													<input type="text" class="form-control" id="position" name="position" placeholder="Position" value="{{ chart.position }}" onKeyPress="return check(event,value)">
													<input type="hidden" id="old-position" value="{{ chart.position }}">
													<p class="help-block position-msg"></p>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group change-pos-group">
													<label for="pre-position">Pre Position <i class="fa fa-question-circle-o" aria-hidden="true" style="cursor: pointer;"></i></label>
													<input type="text" class="form-control" id="pre-position" name="pre-position" placeholder="Pre Position" value="{{ chart.pre_position }}" readonly="readonly">
													<p class="help-block pre-position-msg"></p>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group lyric-group">
													<label for="lyric">Lyrics <i class="fa fa-question-circle-o" aria-hidden="true" style="cursor: pointer;"></i></label>
													<textarea class="form-control tiny-mce" id="lyric" name="lyric" placeholder="Lyric" cols="100%" rows="20%">{{ chart.chart_lyric }}</textarea>
													<p class="help-block lyric-msg"></p>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group tag-group">
													<label for="tag">Tag <small>{4 tags and separated by commas}</small> <i class="fa fa-question-circle-o" aria-hidden="true" style="cursor: pointer;"></i></label>
													<input type="text" class="form-control" id="tag" name="tag" placeholder="Tag" value="{{ chart.tag }}">
													<p class="help-block tag-msg"></p>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-3">
												<div class="form-group img-group">
													<label for="file-img" class="col-md-12" style="padding: 0;">Icon <i class="fa fa-question-circle-o" aria-hidden="true" style="cursor: pointer;"></i></label>
													<p id="btn-upload" class="btn btn-primary help-block">Choose File</p>
													<br/>
													<br/>
													<div id="upload-demo-i"></div>

													{% if chart.name is not empty %}
														<img src="{{ base_url() }}{{ charts_image_path }}/{{ chart.name }}" class="img img-responsive" id="chart-image" />
													{% endif %}
												</div>
											</div>
										</div>

										<hr/>

										<!-- CEO Optimation -->
										<div class="row">
							                <div class="col-lg-12">
							                    <div class="panel panel-success">
							                        <div class="panel-heading">
							                            SEO Optimation <i class="fa fa-question-circle-o" aria-hidden="true" style="cursor: pointer;"></i>
							                        </div>
							                        <div class="panel-body">
														<div class="row">
															<div class="col-md-12">
																<div class="form-group seo-keywords-group">
																	<label for="seo-keywords">Meta Keyword <small>{separate by commas}</small> <i class="fa fa-question-circle-o" aria-hidden="true" style="cursor: pointer;"></i></label>
																	<textarea class="form-control" id="seo-keywords" name="seo-keywords" placeholder="Meta Keywords" cols="100%" rows="5%">{{ chart.seo_keywords }}</textarea>
																	<p class="help-block seo-keywords-msg"></p>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-12">
																<div class="form-group seo-desc-group">
																	<label for="seo-desc">Meta Description <i class="fa fa-question-circle-o" aria-hidden="true" style="cursor: pointer;"></i></label>
																	<textarea class="form-control" id="seo-desc" name="seo-desc" placeholder="Meta Description" cols="100%" rows="5%">{{ chart.seo_desc }}</textarea>
																	<p class="help-block seo-desc-msg"></p>
																</div>
															</div>
														</div>
							                        </div>
							                    </div>
							                </div>
							            </div>
							            <div class="row">
							            	<div class="col-lg-12">
									            <div class="response-message">
												</div>
											</div>
							            </div>
									</div>
								</div>
								<div class="box-footer">
									<div class="pull-right">
										<button type="button" id="cancel" class="btn btn-default" style="min-width: 120px;">Cancel</button>
										<button type="submit" id="save" class="btn btn-success" style="min-width: 120px;">Save</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
            </div>
			{% endblock %}
			
			{% block js %}
			<script src="{{ base_url() }}assets/admin/plugins/datepicker/bootstrap-datepicker.js"></script>
			<script src="{{ base_url() }}assets/admin/js/charts/charts-addedit-handler.js"></script>
			<script src="{{ base_url() }}assets/admin/js/croppie.js"></script>
			<script>
				var handler = AddEditHandler.createIt({
					baseUrl: '{{ base_url() }}admin/chart/',
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
			<script type="text/javascript">
				$uploadCrop = $('#upload-demo').croppie({});

				$('#upload').on('change', function () {
					var reader = new FileReader();
				    reader.onload = function (e) {
				    	$uploadCrop.croppie('bind', {
				    		url: e.target.result
				    	}).then(function(){
				    		console.log('jQuery bind complete');
				    	});
				    	
				    }
				    reader.readAsDataURL(this.files[0]);
				});

				$('.upload-result').on('click', function (ev) {
					$uploadCrop.croppie('result', {
						type: 'canvas',
						size: 'viewport'
					}).then(function (resp) {
						loader.block();
						$.ajax({
							url: "{{ base_url() }}admin/chart/crUpload",
							type: "POST",
							data: {"image": resp, "file_id": $('input#chart-id').val()},
							success: function (data) {
								$('img#chart-image').hide();
								html = '<img src="' + resp + '" class="img img-responsive" />';
								$("#upload-demo-i").html(html);
								$('.upload-confirmation').modal('hide');
								loader.unblock();
							},
							error: function(data){
								loader.unblock();
							}
						});
					});
					
					$uploadCrop.croppie_thumb('result', {
						type: 'canvas',
						size: 'viewport'
					}).then(function (resp) {

						$.ajax({
							url: "{{ base_url() }}admin/chart/crUpload_thumb",
							type: "POST",
							data: {"image": resp, "file_id": $('input#chart-id').val()},
							success: function (data) {
								
							}
						});
					});
				});
			</script>
			{% endblock %}