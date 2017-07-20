<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<title>AI - Logiin</title>
	<meta name="description" content="User login page" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

	<!-- bootstrap & fontawesome -->
	<link rel="stylesheet" href="<?php echo PUBLIC_URL ?>/css/bootstrap.min.css" />
	<link rel="stylesheet" href="<?php echo PUBLIC_URL ?>/css/style.css" />
	<link rel="stylesheet" href="<?php echo PUBLIC_URL ?>/font-awesome/4.5.0/css/font-awesome.min.css" />

	<!-- text fonts -->
	<link rel="stylesheet" href="<?php echo PUBLIC_URL ?>/css/fonts.googleapis.com.css" />

	<!-- ace styles -->
	<link rel="stylesheet" href="<?php echo PUBLIC_URL ?>/css/ace.min.css" />

	<!--[if lte IE 9]>
	<link rel="stylesheet" href="<?php echo PUBLIC_URL ?>/css/ace-part2.min.css" />
	<![endif]-->
	<link rel="stylesheet" href="<?php echo PUBLIC_URL ?>/css/ace-rtl.min.css" />

	<!--[if lte IE 9]>
	<link rel="stylesheet" href="<?php echo PUBLIC_URL ?>/css/ace-ie.min.css" />
	<![endif]-->

	<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

	<!--[if lte IE 8]>
	<script src="<?php echo PUBLIC_URL ?>/js/html5shiv.min.js"></script>
	<script src="<?php echo PUBLIC_URL ?>/js/respond.min.js"></script>
	<![endif]-->
</head>

<body class="login-layout">

<div id="dvLoading">
	<div id="loadingimg"></div>
	<div id="loadingmsg">Please wait....</div>
</div>


<div class="main-container">
	<div class="main-content">
		<div class="row" style="margin-top:100px;">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="login-container">
					<div class="center">
						<h1> <i class="ace-icon fa fa-leaf green"></i> <span class="white">a-Inv</span> </h1>
					</div>
					<div class="space-6"></div>
					<div class="position-relative">
						<div id="login-box" class="login-box visible widget-box no-border">
							<div class="widget-body">
								<div class="widget-main">
									<span id="loginfailedspan" class="pull-right red" style="">Invalid Username/Password</span>
									<h4 class="header blue lighter bigger"> Signin </h4>
									<div class="space-6"></div>
									<form class="form-signin" name="login-form" id="login-form" method="post">
										<fieldset>
											<label class="block clearfix"> <span class="block input-icon input-icon-right">
                        <input type="text" name="userid" id="userid"class="form-control required" placeholder="Username" />
                        <i class="ace-icon fa fa-user"></i> </span> </label>
											<label class="block clearfix"> <span class="block input-icon input-icon-right">
                        <input type="password" name="lpassword" id="lpassword" class="form-control required" placeholder="Password" />
                        <i class="ace-icon fa fa-lock"></i> </span> </label>
											<div class="space"></div>
											<div class="clearfix">
												<label class="inline m-t-sm">
													<a href="#">Forgot Password</a> </label>

												<button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
													<i class="ace-icon fa fa-key"></i> <span class="bigger-110">Login</span>
												</button>
											</div>
											<div class="space-4"></div>
										</fieldset>
									</form>
									<input type="hidden" id="dest" value="<?php echo $_GET['d']?>" />
									<div class="space-6"></div>
								</div>
								<!-- /.widget-main -->
							</div>
							<!-- /.widget-body -->
						</div>
						<!-- /.login-box -->
					</div>
					<!-- /.position-relative -->

				</div>
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</div>
	<!-- /.main-content -->
</div>
<!-- /.main-container -->
<div class="footer">
	<div class="footer-inner">
		<div class="footer-content white">  <span class="blue bolder">a-Inv</span> &copy; 2016-2017. All rights reserved. </div>
	</div>
</div>
<!-- basic scripts -->

<!--[if !IE]> -->
<script src="<?php echo PUBLIC_URL ?>/js/jquery-2.1.4.min.js"></script>


<!-- <![endif]-->

<!--[if IE]>
<script src="<?php echo PUBLIC_URL ?>/js/jquery-1.11.3.min.js"></script>

<![endif]-->

<script src="<?php echo PUBLIC_URL ?>/js/md5.js"></script>
<script src="<?php echo PUBLIC_URL ?>/js/jquery.validate.min.js"></script>
<script src="<?php echo PUBLIC_URL ?>/js/application.js"></script>

<script type="text/javascript">
	if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo PUBLIC_URL ?>/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>

<!-- inline scripts related to this page -->
<script type="text/javascript">
	jQuery(function($) {
		$( '#loginfailedspan' ).hide();
		$(document).on('click', '.toolbar a[data-target]', function(e) {
			e.preventDefault();
			var target = $(this).data('target');
			$('.widget-box.visible').removeClass('visible');//hide others
			$(target).addClass('visible');//show target
		});


		$('#login-form').validate({
			errorPlacement: function (error, element) {},
			submitHandler: function ( form ) {
				showLoader( 'Authenticating... ' );
				$( '#lpassword' ).val( CryptoJS.MD5( $( '#lpassword' ).val() ) );
				$.ajax( {
					url: "validate/login",
					type: "POST",
					data: $( '#login-form' ).serialize(),
					success: function ( objResponse ) {
						$( '.errormsg' ).hide();
						if ( objResponse == 0 ) {
							showLoader( 'Please wait... ' );
							$( '#loginfailedspan' ).show();
							hideLoader();
							$('#lpassword').val('');
						} else {
							showLoader( 'Please wait... ' );
							if($('#dest').val() != '' ){
								window.location = "/" + $('#dest').val();
							} else {
								window.location = "/home";
							}

						}
					}
				} );

			}
		});

	});






	//you don't need this, just used for changing background
	jQuery(function($) {
		$('#btn-login-dark').on('click', function(e) {
			$('body').attr('class', 'login-layout');
			$('#id-text2').attr('class', 'white');
			$('#id-company-text').attr('class', 'blue');

			e.preventDefault();
		});
		$('#btn-login-light').on('click', function(e) {
			$('body').attr('class', 'login-layout light-login');
			$('#id-text2').attr('class', 'grey');
			$('#id-company-text').attr('class', 'blue');

			e.preventDefault();
		});
		$('#btn-login-blur').on('click', function(e) {
			$('body').attr('class', 'login-layout blur-login');
			$('#id-text2').attr('class', 'white');
			$('#id-company-text').attr('class', 'light-blue');

			e.preventDefault();
		});

	});
</script>
</body>
</html>
