<!DOCTYPE html>
<html lang="en">

	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robot" content="noindex,nofollow" />
		<link rel="shortcut icon" href="{{ base_url() }}assets/client/img/favicon.ico" type="image/x-icon">
		<link rel="icon" href="{{ base_url() }}assets/client/img/favicon.ico" type="image/x-icon">

		<title>K-Pop Admin</title>

		<!-- Bootstrap Core CSS -->
		<link href="{{ base_url() }}assets/admin/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

		<!-- MetisMenu CSS -->
		<link href="{{ base_url() }}assets/admin/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

		<!-- Custom CSS -->
		<link href="{{ base_url() }}assets/admin/dist/css/sb-admin-2.css" rel="stylesheet">

		<!-- Custom Fonts -->
		<link href="{{ base_url() }}assets/admin/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

	</head>

	<body>

		<div class="container">
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<div class="login-panel panel panel-custom">
						<div class="panel-heading">
							<h3 class="panel-title">Please Sign In</h3>
						</div>
						<div class="panel-body">
							{% if message is not empty %}
								<div class="alert">
									<button type="button" class="close" dismiss="alert">&times;</button>
									<strong>Warning!</strong> {{ message }}
								</div>
							{% endif %}
							<form role="form" action="{{ base_url() }}admin/login/authentication" method="post">
								<fieldset>
									<div class="form-group">
										<input class="form-control" placeholder="Username" name="username" type="username" autocomplete="off" autofocus>
									</div>
									<div class="form-group">
										<input class="form-control" placeholder="Password" name="password" type="password" value="">
									</div>
									<button type="submit" class="btn btn-lg btn-custom btn-block">Login</button>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- jQuery -->
		<script src="{{ base_url() }}assets/admin/vendor/jquery/jquery.min.js"></script>

		<!-- Bootstrap Core JavaScript -->
		<script src="{{ base_url() }}assets/admin/vendor/bootstrap/js/bootstrap.min.js"></script>

		<!-- Metis Menu Plugin JavaScript -->
		<script src="{{ base_url() }}assets/admin/vendor/metisMenu/metisMenu.min.js"></script>

		<!-- Custom Theme JavaScript -->
		<script src="{{ base_url() }}assets/admin/dist/js/sb-admin-2.js"></script>

	</body>

</html>
