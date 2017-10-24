<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li> <i class="ace-icon fa fa-home home-icon"></i> <a href="/home">Home</a> </li>
                <li> <a href="/inventory">Manage Inventory</a> </li>
                <li> <a href="#">Edit Inventory</a> </li>
            </ul>
        </div>
        <div class="clearfix hr-8"></div>

        <div class="page-content">
            <div class="panel">
                <div class="page-header">
                    <h4>Edit Inventory</h4>
                </div>
                <div class="panel-body">
                    <span class="imei_error">Error Message</span>
                    <div class="row">
                        <form name="inventory_checkin" id="inventory_checkin" class="form-horizontal"
                              role="form" method="post" action="/inventory">
                            <input type="hidden" name="action" value="edit" />
                            <input type="hidden" name="pre_imei" value="<?php echo $arrInv->IMEI?>" />
                            <input type="hidden" name="pre_po" value="<?php echo $arrInv->PO_NUMBER?>" />
                            <input type="hidden" name="id" value="<?php echo $arrInv->ID?>" />

                            <div class="col-sm-7">
                                <div class="panel">
                                    <div class="page-header">
                                        Edit Inventory
                                    </div>
                                    <div class="panel-body">
                                        <div class="row m-b">
                                            <table width="100%">
                                                <tr>
                                                    <td>
                                                        <input type="text" name="imei" id="imei" value="<?php echo $arrInv->IMEI?>" />
                                                    </td>
                                                </tr>
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
                                        <input id="ponumber" name="ponumber" placeholder="P.O. Number"
                                               value="<?php echo $arrInv->PO_NUMBER ?>"
                                               class="required col-sm-12" aria-required="true" type="text">

                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="f-right m-r">
                                <button class="btn btn-success" type="submit" id="checkin_inv">
                                    <i class="ace-icon fa fa-fw fa-check"></i>Update Inventory<span></span>
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

        $('#inventory_checkin').validate({
            errorPlacement: function (error, element) {},
            submitHandler: function (form, e) {
                e.preventDefault();
                var chkIM = true;



                $.ajax({
                    url: "/validate/checkEditCheckin",
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



            }
        });
    });

</script>