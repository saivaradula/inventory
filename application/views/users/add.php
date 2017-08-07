
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="/home">Home</a> </li>
				<li> <a href="#">Manage Users</a> </li>
				<li> <a href="/users/<?php echo strtolower($strType)?>"><?php echo ucfirst($strType)?></a> </li>
				<li> <a href="#">Add</a> </li>

			</ul>
		</div>
		<div class="col-sm-12 page-Title">
			<h4><i class="fa fa-fw fa-user"></i> Add <?php echo $strType?></h4>
		</div>
        <input type="hidden" id="selecState" value="<?php echo $arrUser->STATE?>" />
		<?php
			$arrOptions['strtype'] = strtolower($strType);
			$arrOptions['action'] = '/users/'. strtolower($strType);
			$arrOptions['arrObjC'] = $arrObjC;
			$arrOptions['arrUser'] = $arrUser;
			$arrOptions['bShowCmpny'] = $bShowCmpny;
			$arrOptions['bSubCShow'] = $bSubCShow;
			$arrOptions['arrObjCUsers'] = $arrObjCUsers;
			$arrOptions['arrLocations'] = $arrLocations;
			addUserForm( $arrOptions );
		?>
	</div>
</div>
<script language="javascript">

	$(function(){

        $( "#dob" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd/mm/yy",
            maxDate: '0'
        });


        <?php if( $bSubCShow ) { ?>
            $('#location option').hide();
            $('#location').find("option").eq(0).show();
            $('#subc').change(function(){
                $('#location option').hide();
                $('#location').find("option").eq(0).show();
                $('#location').find("option").eq(0).prop('selected', true);
                $('#location').find("option." + $('#subc').val() ).show();
            });
		<?php } ?>
	});

	$('#company_user_add_form').validate({
		errorPlacement: function (error, element) {},
		rules: {
			password: { minlength: 6},
			username: { minlength: 6},
			email: {
				required: true,
				email: true
			}
		},
		submitHandler: function (form, e) {
			var orgName = $('#old_login_name').val();
			var presentName = $('#username').val();
			if (orgName != presentName) {
				e.preventDefault();
				$.ajax({
					url: "/validate/checkUser",
					type: "POST",
					data: "loginname=" + $('#username').val(),
					success: function (response) {
						if (response == 0) {
							$.ajax({
								url: "/validate/checkUserEmail",
								type: "POST",
								data: "t=a&ut=CU&em=" + $('#email').val(),
								success: function (response) {
									if (response == 0) {
										<?php if( $bSubCShow ) { ?>
											$.ajax({
												url: "/ajaxcall/getLocationManager",
												type: "POST",
												data: "loc=" + $('#location').val(),
												success: function (response) {

													if (response != '' ) {
														if( confirm("This Location has been assigned to " + response + ". Do you want to replace ? !!!") ) {
															$('#company_user_add_form').unbind().submit();
														} else {
															return false;
														}
													}
													else {
														$('#company_user_add_form').unbind().submit();
													}
												}
											});
										<?php } else {
											?>$('#company_user_add_form').unbind().submit();<?php
										} ?>

									}
									else {
										alert("User with EmailID " + $('#email').val() + " already exists. !!!");
										return false;
									}

								}
							});

						}
						else {
							alert("UserName " + $('#username').val() + " already exists. !!!");
							return false;
						}
					}
				});
			}

		}
	});
</script>
