<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li> <i class="ace-icon fa fa-home home-icon"></i> <a href="/home">Home</a> </li>
                <li> <a href="/inventory">Manage Inventory</a> </li>
                <li> <a href="#">Return Inventory</a> </li>
            </ul>
        </div>
        <div class="clearfix hr-8"></div>

        <div class="page-content">
            <div class="panel">
                <div class="page-header">
                    <h4>Return Inventory</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <form id="inventory_checkin" class="form-horizontal" role="form" method="post" action="/inventory">
                            <input type="hidden" name="action" value="return" />
                            <div class="col-sm-7">
                                <div class="panel">
                                    <div class="page-header">
                                        <h4>Items Scanned (<span class="imei_scanned">0</span>)</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row m-b">
                                            <table width="100%">

                                                    <tr>
                                                        <td>
                                                            <textarea id="imei" name="imei" class="col-sm-12" cols="25" rows="10"></textarea>
                                                            <span class="imei_error">Error Message</span>
                                                        </td>
                                                    </tr>

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
                                        <h4>Return to</h4>
                                    </div>
                                    <div class="panel-body">

                                        <?php
                                        $strMgrR = 'required';
                                        if( $bSubC ) { $strMgrR = ''; ?>
                                            <select id="shpto_subc" name="shpto_subc" class="required col-sm-8">
                                                <option value="">Sub Contractor</option>
                                                <?php foreach ( $arrObjCUsers AS $arrObjCm ) { ?>
                                                    <option value="<?php echo $arrObjCm->USER_ID?>">
                                                        <?php echo $arrObjCm->NAME?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            <br /><br />
                                        <?php } ?>

                                        <select id="shpto_manager" name="shpto_manager" class="<?php echo $strMgrR?> col-sm-8">
                                            <option value="">Select</option>
                                            <?php if($iRoleId <= DIRECTOR) {?>
                                                <option value="-1">OEM</option>
                                            <?php } else { ?>
                                                <?php
                                                // comment starts
                                                /* for ( $i=0; $i < count( $arrObjSUsers ); $i++) {
                                                    if( $arrObjSUsers[$i]->NAME != '' ) { ?>
                                                        <option value="<?php echo $arrObjSUsers[$i]->ID?>">
                                                            <?php echo $arrObjSUsers[$i]->NAME?>
                                                        </option>
                                                    <?php }  ?>
                                                <?php } */
                                                // ends comment
                                                ?>
                                                <?php for ( $i=0; $i < count( $arrObjCUsers  ); $i++) {
                                                    if( $arrObjCUsers[$i]->NAME != '' ) { ?>
                                                        <option value="<?php echo $arrObjCUsers [$i]->ID?>">
                                                            <?php echo $arrObjCUsers [$i]->NAME?>
                                                        </option>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>



                                    </div>
                                </div>

                                <div class="panel">
                                    <div class="page-header">
                                        <h4>Reason</h4>
                                    </div>
                                    <div class="panel-body">
                                        <select id="reason_ddl" name="reason_small" class="required col-sm-8">
                                            <option value="">Select</option>
                                            <option value="DAMAGED">Damaged</option>

                                        </select>
                                        <div>&nbsp;</div>
                                        <br />
                                        <textarea class="required" name="reason"
                                                  placeholder="Enter reason for returning items" cols="55" rows="5"></textarea>
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
                                    <i class="ace-icon fa fa-fw fa-check"></i>Return Inventory<span></span>
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

        $('#loc_det').hide();
        var i = 10;
        $('#imei').focus();
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

                <?php
                    if( $iRoleId == SUPERADMIN ) {
                        ?>chkIM = false;<?php
                    }
                ?>
                if( chkIM ){
                    $.ajax({
                        url: "/validate/returnIMEI",
                        type: "POST",
                        data: $('#inventory_checkin').serialize(),
                        success: function (response) {
                            var objRes = JSON.parse(response);
                            if( objRes.proceed == true ) {
                                $('#inventory_checkin').unbind().submit();
                            } else {
                                if( objRes.error != '' ) {
                                    $('.imei_error').html(objRes.error).show();
                                } else {
                                    var strExis = '';
                                    for( var i=0; i < Object.keys(objRes).length - 1; i++ ){
                                        strExis +=  objRes[i].IMEI + " <br />";
                                    }
                                    $('.imei_error').html('Below IMEI are already Returned. <br >' + strExis).show();
                                }
                                return false;

                            }
                        }
                    });
                } else {
                    $('#inventory_checkin').unbind().submit();
                }

            }
        });




    });
</script>