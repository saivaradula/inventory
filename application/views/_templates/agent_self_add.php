<?php $objC = new Controller(); ?>
	<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>AI</title>
		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="<?php echo PUBLIC_URL ?>/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo PUBLIC_URL ?>/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- page specific plugin styles -->

		<!-- text fonts -->
		<link rel="stylesheet" href="<?php echo PUBLIC_URL ?>/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="<?php echo PUBLIC_URL ?>/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

		<!--[if lte IE 9]>
		<link rel="stylesheet" href="<?php echo PUBLIC_URL ?>/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->
		<link rel="stylesheet" href="<?php echo PUBLIC_URL ?>/css/ace-skins.min.css" />
		<link rel="stylesheet" href="<?php echo PUBLIC_URL ?>/css/ace-rtl.min.css" />

		<!--[if lte IE 9]>
		<link rel="stylesheet" href="<?php echo PUBLIC_URL ?>/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<link rel="stylesheet" href="<?php echo PUBLIC_URL ?>css/style.css" />

		<!-- ace settings handler -->
		<script src="<?php echo PUBLIC_URL ?>js/ace-extra.min.js"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="<?php echo PUBLIC_URL ?>js/html5shiv.min.js"></script>
		<script src="<?php echo PUBLIC_URL ?>js/respond.min.js"></script>
		<![endif]-->

		<!--dynamic table-->

		<link href="<?php echo PUBLIC_URL ?>js/advanced-datatable/css/demo_table.css" rel="stylesheet"/>
		<link rel="stylesheet" href="<?php echo PUBLIC_URL ?>js/data-tables/DT_bootstrap.css"/>

		<style>
			.p-t-sm {
				padding-top: 8px;
			}
			.p-r-lg {
				padding-right: 15px;
			}
		</style>


		<!--[if !IE]> -->
		<script src="<?php echo PUBLIC_URL ?>js/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
		<script src="<?php echo PUBLIC_URL ?>js/jquery-1.11.3.min.js"></script>
		<![endif]-->

		<script src="<?php echo PUBLIC_URL ?>js/jquery.validate.min.js"></script>
		<script src="<?php echo PUBLIC_URL ?>js/application.js"></script>
		<script type="text/javascript" src="<?php echo PUBLIC_URL ?>js/bootstrap-datepicker/js/jquery.datetimepicker.js"></script>



	</head>

<body class="no-skin">

	<div id="dvLoading">
		<div id="loadingmsg"> <br />Working... </div>
		<div id="loadingimg"></div>
	</div>

	<div id="navbar" class="navbar navbar-default ace-save-state">
		<div class="navbar-container ace-save-state" id="navbar-container">
			<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar"> <span class="sr-only">Toggle sidebar</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
			<div class="navbar-header pull-left"> <a href="index.html" class="navbar-brand"> <small> <i class="fa fa-user"></i> a-Inv </small> </a> </div>
			<div class="navbar-buttons navbar-header pull-right" role="navigation">
				<uace-icon fa fa-signall class="nav ace-nav">
					<li class="light-blue dropdown-modal"> <a data-toggle="dropdown" href="#" class="dropdown-toggle">
						<img class="nav-user-photo" src="<?php echo PUBLIC_URL ?>/images/avatars/user.jpg" alt="Jason's Photo" />
						<span class="user-info"> <small>Welcome,</small> Guest </span> <i class="ace-icon fa"></i> </a>
					</li>
					</ul>
			</div>
		</div>
		<!-- /.navbar-container -->
	</div>

	<div class="main-container ace-save-state" id="main-container">


