<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="/home">Home</a> </li>
				<li> <a href="/inventory">Manage Inventory</a> </li>
				<li> <a href="#">Shipping</a> </li>
			</ul>
		</div>
		<div class="clearfix hr-8"></div>

		<div class="page-content">
			<div class="panel">
				<div class="page-header">
					<h4>Shipping Inventory</h4>
				</div>
				<div class="panel-body">
					<div class="row">
						<form id="inventory_checkin" class="form-horizontal" role="form" method="post" action="/inventory">
							<input type="hidden" name="action" value="shipin" />
							<input type="hidden" name="prevcheckaction" value="'CHECKED_IN'" />
							<div class="col-sm-7">
								<div class="panel">
									<div class="page-header">
                                        <h4>Items Scanned (<span class="imei_scanned">0</span>)</h4>
									</div>
									<div class="panel-body">
										<div class="row m-b">
											<table width="100%">
                                                <textarea id="imei" name="imei" class="required col-sm-12" cols="55" rows="10"></textarea>
                                                <span class="imei_error">Error Message</span>
											</table>
										</div>
										<div class="f-right">
											<!-- <button class="btn btn-notification addfieldIcon" type="button">
												<i class="ace-icon fa fa-fw fa-plus"></i>
												Add More..
											</button> -->
										</div>
									</div>
								</div>
							</div>


							<div class="col-sm-5">
								<div class="panel">
									<div class="page-header">
										<h4>Shipping Details</h4>
									</div>
									<div class="panel-body">

                                        <?php if( $iAdmin ) {?>

                                                <select class="required col-sm-8" id="company" name="company">
                                                    <option value="">Select</option>
                                                    <?php foreach ( $arrObjC AS $arrObjCm ) { ?>
                                                        <option value="<?php echo $arrObjCm->ID?>"><?php echo $arrObjCm->NAME?></option>
                                                    <?php } ?>
                                                </select>
                                                <br /><br />

                                        <?php } ?>

										<?php
											$strMgrR = 'required';
											if( $bSubC ) { $strMgrR = ''; ?>
											<select id="shpto_subc" name="shpto_subc" class="required col-sm-8">
												<option value="">Select Sub Contractor</option>
												<?php foreach ( $arrObjCUsers AS $arrObjCm ) { ?>
													<option value="<?php echo $arrObjCm->USER_ID?>">
														<?php echo $arrObjCm->NAME?>
													</option>
												<?php } ?>
											</select>
											<br /><br />
										<?php } ?>


										<select id="shpto_manager" name="shpto_manager" class="<?php echo $strMgrR?> col-sm-8 required">
											<option value="">Select Location</option>
											<?php foreach ( $arrObjLocation AS $arrObjCMm ) { ?>
												<option value="<?php echo $arrObjCMm->ID?>">
													<?php echo $arrObjCMm->NAME?>
												</option>
											<?php } ?>
										</select>

									</div>
								</div>
							</div>

							<div class="col-sm-5" id="loc_det">
								<div class="panel">
									<div class="page-header">
										<h4>Location Details</h4>
									</div>
									<div class="panel-body">
										<div class=" col-sm-8">
											<strong>Manager</strong> : &nbsp;&nbsp;&nbsp;
											<span id="manager_name"></span>
										</div>
										<div class="col-sm-8">&nbsp;</div>
										<div class="col-sm-8">
											<strong>Address</strong> : &nbsp;&nbsp;&nbsp;
										</div>
										<div class="col-sm-8" id="location_address"></div>

									</div>
								</div>
							</div>

							<div class="clearfix"></div>
							<div class="f-right m-r">
								<button class="btn btn-success" type="submit" id="checkin_inv">
									<i class="ace-icon fa fa-fw fa-check"></i>Ship Inventory<span></span>
								</button>
								<button class="btn btn-cancel" type="button"
								        onclick="javascript: location.href='/inventory'">
									<i class="ace-icon fa fa-fw fa-remove"></i>Cancel<span></span>
								</button>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script language="javascript">
	$(function(){

        $('#imei').focus();
        jQuery('#imei').on('paste input', function() {
            var strIM = $(this).val();
            var arrIM  = strIM.split(/\s+/);
            $('.imei_scanned').html( arrIM.length - 1 );

        });

        $('#company').change(function(){
            //subcholder
            $.ajax({
                url: "/ajaxcall/getSubContofCompy",
                type: "POST",
                data: "id=" + $(this).val(),
                success: function (response) {
                    if(response == 0) {
                        //$('#subcholder').hide();
                        $('#shpto_subc').hide();
                    } else {
                        //$('#subcholderL').show();
                        $('#shpto_subc').show().html( response );
                    }

                }
            });

            $.ajax({
                url: "/ajaxcall/getLocOfCompy",
                type: "POST",
                data: "id=" + $(this).val(),
                success: function (response) {
                    if(response == 0) {
                        $('#shpto_manager').hide();
                    } else {
                        $('#shpto_manager').show().html( response );
                    }
                }
            });
        });


        $('#loc_det').hide();
		var i = 10;
		$('.addfieldIcon').css('padding', '3px 10px').click(function(){
			$("table tr:first").clone().find("input").each(function() {
				$(this).attr({
					'id': function(_, id) { return id + i },
					'name': function(_, name) { return name },
					'value': ''
				});
			}).end().appendTo("table");
			$("table tr:last").find('input').focus().val('');
		});

		$('.imei').blur(function(){
			if($(this).val() != '' ){
				$(this).siblings().attr('id', $(this).val() );
			} else {
				$(this).siblings().removeAttr('id');
			}
		});

		$('#inventory_checkin').validate({
			errorPlacement: function (error, element) {},
			submitHandler: function (form, e) {
				e.preventDefault();
				var chkIM = true;

				$('.imei').each(function(){

				});

				// Check if Inventory belongs to This user while shipping.
                $.ajax({
                    url: "/validate/checkBlgShipIMEI",
                    type: "POST",
                    data: $('#inventory_checkin').serialize(),
                    success: function (response) {
                        var objRes = JSON.parse(response);
                        if( objRes.proceed == true ) {
                            $.ajax({
                                url: "/validate/shipIMEI",
                                type: "POST",
                                data: $('#inventory_checkin').serialize(),
                                success: function (response) {
                                    var objRes = JSON.parse(response);
                                    if( objRes.proceed == true ) {
                                        $('#inventory_checkin').unbind().submit();
                                    } else {
                                        var strExis = '';
                                        for( var i=0; i < Object.keys(objRes).length - 1; i++ ){
                                            strExis +=  objRes[i].IMEI + " <br />";
                                        }
                                        $('.imei_error').html('Below IMEI already Shipped. <br >' + strExis).show();
                                    }
                                }
                            });
                        } else {
                            $('.imei_error').html('Some of IMEI does not exist in your Inventory').show();
                        }
                    }
                });

			}
		});

		$('#shpto_manager').change(function(){
			if( $(this).val() != '' ){
				$.ajax({
					url: "/ajaxcall/getLocationID",
					type: "POST",
					data: "id=" + $('#shpto_manager').val(),
					success: function (response) {
						var objRes = JSON.parse(response);
						$('#manager_name').html(objRes.MANAGER_NAME);
						$('#location_address').html(objRes.ADDRESS);
						$('#loc_det').show();
					}
				});
			} else {
				$('#loc_det').hide();
			}

		});

        <?php if( $bSubC ) { $strMgrR = ''; ?>
            $('#shpto_subc').change(function(){
                $.ajax({
                    //url: "/ajaxcall/getManagerBySubC/dd",
                    url: "/ajaxcall/getLocationBySubC/dd",
                    type: "POST",
                    data: "subc=" + $('#shpto_subc').val(),
                    success: function (response) {
                        if (response != '' ) {
                            $('#shpto_manager').html( response );
                        }
                        else {
                            //$('#company_user_add_form').unbind().submit();
                        }
                    }
                });
            });
        <?php } ?>
	});
</script>