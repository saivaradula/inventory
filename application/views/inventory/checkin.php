<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="/home">Home</a> </li>
				<li> <a href="/inventory">Manage Inventory</a> </li>
				<li> <a href="#">Checkin</a> </li>
			</ul>
		</div>
		<div class="clearfix hr-8"></div>

		<div class="page-content">
			<div class="panel">
				<div class="page-header">
					<h4>Checkin Inventory</h4>
				</div>
				<div class="panel-body">
					<div class="row">
						<form name="inventory_checkin" id="inventory_checkin" class="form-horizontal"
						            role="form" method="post" action="/inventory">
							<input type="hidden" name="action" value="chekin" />
                            <input type="hidden" name="prevcheckaction" value="'SHIPPING'" />
							<div class="col-sm-7">
								<div class="panel">
									<div class="page-header">
										<h4>Items Scanned (<span class="imei_scanned">0</span>)</h4>
									</div>
									<div class="panel-body">
									<div class="row m-b">
										<table width="100%">
											<?php /* for($i=1; $i < 10; $i++){ ?>
												<tr>
													<td>
														<input value="" id="imei_<?php echo $i ?>" name="imei[]"
														       placeholder="IMEI NUMBER" class="imei col-sm-7"
														       aria-required="true" type="text" />
														<span class="imei_error">Error Message</span>
													</td>
												</tr>
											<?php } */ ?>
                                            <textarea id="imei" name="imei" class="required col-sm-12" cols="25" rows="10"></textarea>
                                            <span class="imei_error">Error Message</span>
										</table>
										</div>
										<!-- <div class="f-right">
											<button class="btn btn-notification addfieldIcon" type="button">
												<i class="ace-icon fa fa-fw fa-plus"></i>
												Add More..
											</button>
										</div> -->
									</div>
								</div>
							</div>
							<div class="col-sm-5">
								<div class="panel">
									<div class="page-header">
										<h4>Purchase Order Number</h4>
									</div>
									<div class="panel-body">
										<input value="" id="ponumber" name="ponumber" placeholder="P.O. Number"
										       class="required col-sm-12" aria-required="true" type="text">

									</div>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="f-right m-r">
								<button class="btn btn-success" type="submit" id="checkin_inv">
									<i class="ace-icon fa fa-fw fa-check"></i>Checkin Inventory<span></span>
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
        var iScn = 0;
        $('#imei').focus();
        
        jQuery('#imei').on('paste input', function() {

            var strIM = $(this).val();
            var arrIM  = strIM.split(/\s+/);
            $('.imei_scanned').html( arrIM.length - 1 );

        });

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

		/*$('#checkin_inv').click(function(){
			$('#inventory_checkin').submit();
		});*/


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

				<?php // if( $iRoleId > DIRECTOR ) { ?>
                    /* $.ajax({
                        url: "/validate/checkBlgChekinIMEI",
                        type: "POST",
                        data: $('#inventory_checkin').serialize(),
                        success: function (response) {
                            var objRes = JSON.parse(response);
                            if( objRes.proceed == true ) {
                                $.ajax({
                                    url: "/validate/checkIMEI",
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

                                            $('.imei_error').html('Below IMEI already checked in. <br >' + strExis).show();

                                        }
                                    }
                                });
                            } else {
                                $('.imei_error').html(objRes.reason).show();

                            }
                        }
                    }); */
                <?php /* } else { */ ?>

                    $.ajax({
                        url: "/validate/checkIMEI",
                        type: "POST",
                        data: $('#inventory_checkin').serialize(),
                        success: function (response) {

                            var objRes = JSON.parse(response);

                            if( objRes.proceed == true ) {
                                $('#inventory_checkin').unbind().submit();
                            } else {
                                var strExis = '';
                                for( var i=0; i < Object.keys(objRes).length - 2; i++ ){
                                    strExis +=  objRes[i].IMEI + " <br />";
                                }
                                $('.imei_error').html( objRes.reason + '<br >' + strExis).show();

                            }
                        }
                    });
                <?php // } ?>



			}
		});
	});

</script>