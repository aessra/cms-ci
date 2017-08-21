        {% extends "admin/base/base.tpl" %}
            
            {% block css %}
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
                            My Profile
                        </div>
                        <div class="panel-body">
                            <div class="box-body">
                                <form id="form-action" role="form" method="post" enctype="multipart/form-data" action="">
                                    <div class="box-body">
                                        <div class="response-message">
                                        </div>
                                        <div class="row">

                                            <div class="col-md-12" id="bg-data">
                                                <div class="form-group file-id-group">
                                                    <label>File ID: <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>

                                                    {% if my_profile.file_id == 'no-file' %}

                                                        <input class="form-control" type="text" name="file-id" id="file-id" value="{{ file_id }}" />

                                                    {% else %}

                                                        <input type="text" class="form-control" name="file-id" id="file-id" value="{{ my_profile.file_id }}">

                                                    {% endif %}
                                                    
                                                    <p class="help-block file-id-msg"></p>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group img-group">
                                                    {% if my_profile.name is not empty %}
                                                    
                                                        <img src="{{ base_url() }}{{ user_image_path }}/{{ my_profile.name }}" class="img img-responsive" style="margin-bottom: 10px" id="profile_pict">

                                                    {% endif %}

                                                        <div id="upload-demo-i"></div>

                                                    
                                                        <label for="file-img" class="col-md-12" style="padding: 0;">Icon <i class="fa fa-question-circle-o" aria-hidden="true" style="cursor: pointer;"></i></label>
                                                        <p id="btn-upload" class="btn btn-primary help-block">Choose File</p>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group pre-username-group" id="bg-data">
                                                    <label>Pre Username: <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                                                    <input class="form-control" type="text" name="pre-username" id="pre-username" value="{{ my_profile.username }}" />
                                                    <p class="help-block pre-username-msg"></p>
                                                </div>
                                                <div class="form-group username-group">
                                                    <label>Username: <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                                                    <input class="form-control" type="text" name="username" id="username" value="{{ my_profile.username }}" />
                                                    <p class="help-block username-msg"></p>
                                                </div>
                                                <div class="form-group fullname-group">
                                                    <label>Full Name: <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                                                    <input class="form-control" type="text" name="fullname" id="fullname" value="{{ my_profile.fullname }}" />
                                                    <p class="help-block fullname-msg"></p>
                                                </div>
                                                <div class="form-group email-group">
                                                    <label>Email: <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                                                    <input class="form-control" type="text" name="email" id="email" value="{{ my_profile.email }}" />
                                                    <p class="help-block email-msg"></p>
                                                </div>
                                                <div class="form-group phone-group">
                                                    <label>Phone: <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                                                    <input class="form-control" type="text" name="phone" id="phone" value="{{ my_profile.phone }}" onKeyPress="return check(event,value)" />
                                                    <p class="help-block phone-msg"></p>
                                                </div>
                                                <div class="form-group address-group">
                                                    <label>Address: <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                                                    <input class="form-control" type="text" name="address" id="address" value="{{ my_profile.address }}" />
                                                    <p class="help-block address-msg"></p>
                                                </div>
                                                <div class="form-group password-conf-group">
                                                    <label>Password: <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                                                    <input class="form-control" type="password" name="password-conf" id="password-conf" value="" />
                                                    <p class="help-block password-conf-msg"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-warning change-password" data-id="{{ my_profile.username }}" style="min-width: 120px;">Change Password</button>
                                            <button type="submit" class="btn btn-success" style="min-width: 120px;">Save</button>
                                        </div>
                                    </div>
                                    <div class="modal change-password-confirmation">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title">Change Password</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group new-password-group">
                                                                <label>New Password: <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                                                                <input class="form-control" type="password" name="new-password" id="new-password" value="" />
                                                                <p class="help-block new-password-msg"></p>
                                                            </div>
                                                            <div class="form-group conf-password-group">
                                                                <label>Conf Password: <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                                                                <input class="form-control" type="password" name="conf-password" id="conf-password" value="" />
                                                                <p class="help-block conf-password-msg"></p>
                                                            </div>
                                                            <div class="form-group pre-password-group">
                                                                <label>Old Password: <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
                                                                <input class="form-control" type="password" name="pre-password" id="pre-password" value="" />
                                                                <p class="help-block pre-password-msg"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default change-password-no" data-dismiss="modal">Cancel</button>
                                                    <button type="button" class="btn btn-primary change-password-yes" id="btn-change-password">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    
                </div>
            </div>
        </div>
        {% endblock %}

        {% block js %}
            <script src="{{ base_url() }}assets/admin/js/setting_account/setting_account.js"></script>
            <script src="{{ base_url() }}assets/admin/js/croppie.js"></script>
            <script>
                var handler = SettingAccountHandler.createIt({
                    baseUrl: '{{ base_url() }}admin/setting_account',
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
                            url: "{{ base_url() }}admin/setting_account/crUpload",
                            type: "POST",
                            data: {"image": resp, "file_id": $('input#file-id').val()},
                            success: function (data) {
                                $('img#profile_pict').hide();
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
                            url: "{{ base_url() }}admin/setting_account/crUpload_thumb",
                            type: "POST",
                            data: {"image": resp, "file_id": $('input#file-id').val()},
                            success: function (data) {
                                
                            }
                        });
                    });
                });
            </script>
            {% endblock %}