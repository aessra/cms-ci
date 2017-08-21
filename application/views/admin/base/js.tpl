		<!-- jQuery -->
        <script src="{{ base_url() }}assets/admin/vendor/jquery/jquery.min.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="{{ base_url() }}assets/admin/vendor/bootstrap/js/bootstrap.min.js"></script>
        <!-- Metis Menu Plugin JavaScript -->
        <script src="{{ base_url() }}assets/admin/vendor/metisMenu/metisMenu.min.js"></script>
        <!-- Custom Theme JavaScript -->
        <script src="{{ base_url() }}assets/admin/dist/js/sb-admin-2.js"></script>
		<!-- TinyMCE -->
		<script src="{{ base_url() }}assets/admin/js/tinymce-handler.js"></script>
		<script src="{{ base_url() }}assets/admin/js/moment.min.js"></script>
		<script src="{{ base_url() }}assets/admin/plugins/tinymce/js/tinymce/tinymce.min.js"></script>
		<script src="{{ base_url() }}assets/admin/plugins/select2/select2.min.js"></script>
		<script src="{{ base_url() }}assets/admin/plugins/ss/SimpleAjaxUploader.js"></script>
		<script src="{{ base_url() }}assets/admin/js/loader.js"></script>
		<script src="{{ base_url() }}assets/admin/js/share.js"></script>
		<script src="{{ base_url() }}assets/admin/js/lumi-request.js"></script>
		<script>
			$(document).ready(function(){
				TinyMce.init({
					baseUrl: '{{ base_url() }}'
				});
			});
		</script>