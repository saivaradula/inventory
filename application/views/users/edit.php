<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="/home">Home</a> </li>
				<li> <a href="#">Manage Users</a> </li>
				<li> <a href="/users/<?php echo strtolower($strType)?>"><?php echo ucfirst($strType)?></a> </li>
				<li> <a href="#">Edit</a> </li>

			</ul>
		</div>
		<div class="col-sm-12 page-Title">
			<h4><i class="fa fa-fw fa-user"></i> Update <?php echo $strType?> details</h4>
		</div>
		<input type="hidden" id="presentLocId" value="<?php echo $arrUser->LOCID?>" />
        <input type="hidden" id="selecState" value="<?php echo $arrUser->STATE?>" />
		<?php

			///print_r( $arrUser );

			$arrOptions['strtype'] = strtolower($strType);
			$arrOptions['action'] = '/users/'. strtolower($strType) . '/edit';
			$arrOptions['arrObjC'] = $arrObjC;
			$arrOptions['arrUser'] = $arrUser;
			$arrOptions['bShowCmpny'] = $bShowCmpny;
			$arrOptions['bSubCShow'] = $bSubCShow;
			$arrOptions['arrObjCUsers'] = $arrObjCUsers;

			$arrOptions['arrLocations'] = $arrLocations;
            $arrOptions['ida'] = $iDisplayAddress;
			addUserForm( $arrOptions );

			//addUserForm( strtolower($strType), '/users/'. strtolower($strType) . '/edit', $arrObjC, $arrUser);

		?>
	</div>
</div>
<script language="javascript">

	$(function () {

        $( "#dob" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "mm/dd/yy",
            maxDate: '0'
        });

        $('#state option[value="' + $('#selecState').val() +'"]').prop('selected', true);

		$('#company').find("[value='<?php echo $arrUser->COMPANY?>']").prop("selected", true);
        $('#company').change();
		$('#subc').find("[value='<?php echo $arrUser->LOCSUBCONTRACTOR?>']").prop("selected", true);
        $('#subc').change();
		$('#location').find("[value='<?php echo $arrUser->LOCID?>']").prop("selected", true);

		<?php if( $bSubCShow ){ ?>
			<?php if( $arrUser->LOCSUBCONTRACTOR != '' ){ ?>
				$('#location option').hide();
				$('#location').find("option").eq(0).show();
				$('#location').find("option.<?php echo $arrUser->LOCSUBCONTRACTOR?>").show();
			<?php } ?>
		<?php } ?>

		/*$('#subc').change(function(){
			$('#location option').hide();
			$('#location').find("option").eq(0).show();
			$('#location').find("option").eq(0).prop('selected', true);
			$('#location').find("option." + $('#subc').val() ).show();
		});*/

        $('#subc').change(function(){
            loadLocations( $('#company').val(), $('#subc').val() );
        });

        $('#company').change(function(){
            $.ajax({
                url: "/ajaxcall/getSubContofCompy",
                type: "POST",
                data: "id=" + $(this).val(),
                success: function (response) {
                    if(response == 0) {
                        $('#subcholder').hide();
                        $('#subcholderL').hide();
                    } else {
                        $('#subcholderL').show();
                        $('#subcholder').show().html( response );
                        $('#subc').change(function(){
                            loadLocations( $('#company').val(), $('#subc').val() );
                        });
                    }

                }
            });

            $.ajax({
                url: "/ajaxcall/getLocOfCompy",
                type: "POST",
                data: "id=" + $(this).val(),
                success: function (response) {
                    if(response == 0) {
                        $('#location').hide();
                    } else {
                        $('#location').show().html( response );
                    }
                }
            });
        });

		$('#company_user_add_form').validate({
			errorPlacement: function (error, element) {},
			rules: {

				email: {
					required: true,
					email: true
				}
			},
			submitHandler: function (form, e) {
                $('.subbtn').prop('disabled', true);
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
								//$('#company_user_add_form').unbind().submit();
								<?php //if( $bSubCShow ) { ?>
									if( $('#presentLocId').val() != $('#location').val() ) {
										$.ajax({
											url: "/ajaxcall/getLocationManager",
											type: "POST",
											data: "loc=" + $('#location').val(),
											success: function (response) {

												if (response != '' ) {
													if( confirm("This Location has been assigned to " + response + ". Do you want to replace ? !!!") ) {
														$('#company_user_add_form').unbind().submit();
													} else {
                                                        $('.subbtn').prop('disabled', false);
                                                        return false;
													}
												}
												else {
													$('#company_user_add_form').unbind().submit();
												}
											}
										});
									} else {
                                        $('.subbtn').prop('disabled', false);
									}
								<?php  /* } else {
									?>$('#company_user_add_form').unbind().submit();<?php
								 }  */ ?>

							}
							else {
								alert("UserName " + $('#username').val() + " already exists. !!!");
                                $('.subbtn').prop('disabled', false);
								return false;
							}
						}
					});
				} else {

					<?php //if( $bSubCShow ) { ?>
						if( $('#presentLocId').val() != $('#location').val() ) {
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
						} else {
							$('#company_user_add_form').unbind().submit();
						}
					<?php /* } else {
						?>$('#company_user_add_form').unbind().submit();<?php
					}*/ ?>
				}
			}
		});
	});

    function loadLocations(id, sub) {
        $.ajax({
            url: "/ajaxcall/getLocOfCompy",
            type: "POST",
            data: "id=" + id + "&sub=" + sub,
            success: function (response) {
                if(response == 0) {
                    $('#location').hide();
                } else {
                    $('#location').show().html( response );
                }
            }
        });
    }

</script>
