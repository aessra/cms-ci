<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="http://sukakpop.com/assets/client/img/favicon.ico" type="image/x-icon">
        <link rel="icon" href="http://sukakpop.com/assets/client/img/favicon.ico" type="image/x-icon">

        <title>General Error</title>

        		<!-- Bootstrap CSS -->
		<link rel="stylesheet" type="text/css" href="http://sukakpop.com/assets/client/css/bootstrap.min.css">

		<!-- Font-awesome CSS -->
		<link rel="stylesheet" href="http://sukakpop.com/assets/client/font-awesome/css/font-awesome.min.css">

		<!-- Custom CSS -->
		<link rel="stylesheet" type="text/css" href="http://sukakpop.com/assets/client/css/style.css">

		<!-- Animated CSS -->
		<link rel="stylesheet" type="text/css" href="http://sukakpop.com/assets/contributor/animate.css">

	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	    <![endif]-->

	</head>

	<body>

		<div class="holding-nav" id="top"></div>

		<section>
			<div class="container">
				<div class="row">

					<!-- Main Section -->
					<div class="col-sm-12 text-center">
						<h1 class="animated flash">O ow... <?php echo $heading; ?></h1>
						<h5 class="animated slideInUp"><i style="color: grey"><?php echo $message; ?></i></h5>
						<a class="btn btn-danger animated shake" href="http://sukakpop.com/">Lets go back home... )</a>
					</div>
					<!-- End of Main Section -->

				</div>
			</div>
		</section>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	    <script src="http://sukakpop.com/assets/client/js/jquery-1.11.3.min.js"></script>

	    <!-- Include all compiled plugins (below), or include individual files as needed -->
	    <script src="http://sukakpop.com/assets/client/js/bootstrap.min.js"></script>

	</body>

</html>