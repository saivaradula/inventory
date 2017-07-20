
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="/home">Home</a> </li>
				<li> <a href="#">Administration</a> </li>
				<li> <a href="#">Roles</a> </li>

			</ul>
		</div>
		<div class="clearfix hr-8"></div>

		<!-- <div class="row ">
			<div class="col-lg-3">&nbsp;</div>
			<div class="msg-div">
				<div class="alert alert-success fade in col-lg-6 success-div click-close">
						<a href="#" class="close close-sm" data-action="close">
							<i class="ace-icon fa fa-times"></i>
						</a>
					<strong>Success. </strong> <span id="success-msg"></span>
				</div>
			</div>
			<div class="col-lg-3">&nbsp;</div>
		</div> -->

		<div class="">
			<div class="col-xs-12 col-sm-4">
				<div class="widget-box">
					<div class="widget-header">
						<h6 class="widget-title">System Roles</h6>
						<div class="widget-toolbar">
							<a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a>
							<a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a>
						</div>
					</div>
					<div class="widget-body" style="display: block;">
						<div class="widget-main">
							<!-- <form class="cmxform form-horizontal" name="newroleform" id="newroleform">
								<div>
									<label for="form-field-mask-1">New Role Name</label>
									<div class="input-group">
										<input class="form-control input-mask-date required" type="text"
										       id="new_role" name="new_role">
						                    <span class="input-group-btn">
						                        <button class="btn btn-sm btn-default" type="submit">Add </button>
						                    </span>
									</div>
								</div>
							</form> -->


							<div class="control-group icheck" id="roles_holder">
								<?php
									if ( count($objArrRoles) ) {
									foreach ( $objArrRoles AS $objArrRole ) {
									?>
										<div class="radio m-t">
											<label>
												<input id="<?php echo $objArrRole->ID ?>"
												       value="<?php echo $objArrRole->ID ?>"
												       tabindex="3" type="radio"
												        type="radio" class="ace rolename" name="role-name">
												<span class="lbl"> <?php echo $objArrRole->ROLE_NAME?></span> </label>
											<!-- <a id="<?php echo $objArrRole->ID ?>" href="javascript:void(0)" data-action="close" class="text-danger f-right delrole">
												<i class="ace-icon fa fa-times"></i> </a> -->
										</div>
									<?php
										}
									} else {
										?>
										<div>No Roles Found</div>
									<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /.span -->

			<div class="col-sm-8 col-xs-12">
				<div class="row">
				<?php for ( $i = 0; $i < count($arrModules); $i++ ) { ?>
				<div class=" col-sm-6 col-xs-12">
						<div class="widget-box">
							<div class="widget-header">
								<h6 class="widget-title"><?php echo $arrModules[ $i ][ 'NAME' ] ?></h6>
								<span class="widget-toolbar">
									<a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a>
									<!-- <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> </span> -->
							</div>
							<div class="widget-body">
								<div class="widget-main">
									<div class="control-group icheck module_holder_body">
										<?php foreach ( $arrModules[ $i ][ 'CHILDS' ] AS $iKey => $strValue ) { ?>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="ace childs" name="modules[]"
												       id="m_<?php echo $iKey ?>"
												       value="<?php echo $iKey ?>">
												<span class="lbl"> <?php echo strtoupper($strValue); ?></span>
											</label>

										</div>
										<?php } ?>

									</div>
								</div>
							</div>
						</div>
				</div>
				<?php } ?>
			</div>
			</div>

			<!-- /.span -->

			<div class="form-group col-lg-12 row save-module-div">
				<div class="row pull-right">
					<button class="btn btn-info btn-sm save-module-btn" type="submit"> <i class="fa fa-fw fa-user"></i> Save Modules to
						<span></span></button>
				</div>
			</div>

			<!-- /.span -->
		</div>
	</div>
</div>

<!-- <script src="<?php echo PUBLIC_URL ?>js/iCheck/jquery.icheck.js"></script>
<script src="<?php echo PUBLIC_URL ?>js/icheck-init.js"></script> -->
<script language="javascript">

	function runRoleModules(id) {

		showLoader('Loading Modules...');
		$(".childs").each(function () {
			$(this).prop('checked', false);
		});

		$.ajax({
			url: "/admin/getrolemodules",
			type: "POST",
			data: "role_id=" + id,
			success: function (objResponse) {
				arrRoles = $.parseJSON(objResponse);
				var arrM = '';
				$(".childs").each(function () {
					arrM = $(this).attr('id').split("_");
					if (jQuery.inArray(arrM[1], arrRoles) != '-1') {
						$(this).prop('checked', true);
					}
				});
				$('.save-module-div').show();
				$('.save-module-btn').html(' <i class="fa fa-fw fa-user"></i> Update Modules for ' + $('#' + id).siblings().html());
				hideLoader();
			}
		});
	}

	function runSystemRoles() {
		$(".rolename").click(function () {
			runRoleModules($(this).attr('id'));
		});
	}

	function enableDelRole(id) {
		if( confirm("Deleting role ?") ){
			$.ajax({
				url: "/admin/deleterole",
				type: "POST",
				data: "role_id=" + id,
				success: function (objResponse) {
					$('#success-msg').html('Role Removed');
					$('.success-div').show();
					$('.msg-div').show();
					hideLoader();

					arrRoles = $.parseJSON(objResponse);
					var roleHolderValue = '';
					for (i = 0; i < arrRoles.length; i++) {
						roleHolderValue += '<div class="radio m-t">' +
						'<label>' +
						'<input id="' + arrRoles[i]['ID'] + '" value="' + arrRoles[i]['ID'] + '" tabindex="3" class="ace rolename" name="role-name" type="radio">'  +
						'<span class="lbl"> ' + arrRoles[i]['ROLE_NAME'] + '</span> </label>' +
						'<a onclick="enableDelRole(' + arrRoles[i]['ID'] + ')" id="' + arrRoles[i]['ID'] + '" href="#" data-action="close" class="text-danger delrole f-right">' +
						'<i class="ace-icon fa fa-times"></i> </a>' +
						'</div>';

					}

					$('.msg-div').show();
					$('#success-msg').html('Role Added.');
					$('.success-div').show();

					$('#roles_holder').html(roleHolderValue);
					/*$('.square-purple input').iCheck({
					 checkboxClass: 'icheckbox_square-purple',
					 radioClass: 'iradio_square-purple',
					 increaseArea: '20%' // optional
					 });*/
					$('#new_role').val('');
					runSystemRoles();


				}
			});
		}
	}

	$(function () {

		$('.delrole').click(function(){
			enableDelRole($(this).attr('id'));
		});


		$('.save-module-div').hide();
		runSystemRoles();

		$('.save-module-btn').click(function () {
			///hideMessages();
			showLoader('Assigning Modules...');
			var iRoleId = 0;
			var arrMds = [];
			$('.msg-div').hide();
			$('.rolename').each(function () {

				if ( $(this).is(':checked')) {
					iRoleId = $(this).val();
				}
			});

			$('.childs').each(function () {
				if ($(this).is(':checked')) {
					arrMds.push($(this).val());
				}
			});
			$.ajax({
				url: "/admin/addrolemodules",
				type: "POST",
				data: "role_id=" + iRoleId + "&m=" + arrMds,
				success: function (objResponse) {
					$('#success-msg').html('Modules Updated');
					$('.success-div').show();
					$('.msg-div').show();
					hideLoader();
				}
			});
		});


		$('#newroleform').validate({
			errorPlacement: function (error, element) {
			},
			submitHandler: function (form) {
				//hideMessages();
				showLoader('Adding new role...');
				$('.msg-div').hide();
				$('.error-div').hide();
				if ($('#new_role').val().toLowerCase() == 'admin') {
					$('.msg-div').show();
					$('#error-msg').html('You Cannot add "admin" as Role Name');
					$('.error-div').show();
					hideLoader();
					return false;
				}
				$.ajax({
					url: "/admin/addnewrole",
					type: "POST",
					data: $('#newroleform').serialize(),
					success: function (objResponse) {
						if (objResponse == 0) {
							showLoader('Error Occured !!');
							$('.msg-div').show();
							$('#error-msg').html('Role Already exists');
							$('.error-div').show();
						} else {
							showLoader('Reloading Roles ');
							$('#roles_holder').html();
							arrRoles = $.parseJSON(objResponse);
							var roleHolderValue = '';
							for (i = 0; i < arrRoles.length; i++) {
								roleHolderValue += '<div class="radio m-t">' +
								'<label>' +
								'<input id="' + arrRoles[i]['ID'] + '" value="' + arrRoles[i]['ID'] + '" tabindex="3" class="ace rolename" name="role-name" type="radio">'  +
								'<span class="lbl"> ' + arrRoles[i]['ROLE_NAME'] + '</span> </label>' +
								'<a onclick="enableDelRole(' + arrRoles[i]['ID'] + ')" id="' + arrRoles[i]['ID'] + '" href="#" data-action="close" class="text-danger delrole f-right">' +
								'<i class="ace-icon fa fa-times"></i> </a>' +
								'</div>';

							}

							$('.msg-div').show();
							$('#success-msg').html('Role Added.');
							$('.success-div').show();
							$('#roles_holder').html(roleHolderValue);
							/*$('.square-purple input').iCheck({
								checkboxClass: 'icheckbox_square-purple',
								radioClass: 'iradio_square-purple',
								increaseArea: '20%' // optional
							});*/
							$('#new_role').val('');
							runSystemRoles();
						}
						hideLoader();
					}
				});
			}
		});

	});
</script>