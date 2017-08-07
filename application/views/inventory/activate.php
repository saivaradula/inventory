<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li> <i class="ace-icon fa fa-home home-icon"></i> <a href="/home">Home</a> </li>
                <li> <a href="/inventory">Manage Inventory</a> </li>
                <li> <a href="#">Activation</a> </li>
            </ul>
        </div>

        <div class="page-content" style="padding-top: 0px;">
            <div class="row col-sm-12"><?php echo $strMsg ?></div>
            <div class="clearfix hr-8"></div>
            <div class="panel">
                <div class="page-header">
                    <h4>Import Activation Inventory</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <form name="import_form" enctype="multipart/form-data" id="import_form" class="form-horizontal"
                              role="form" method="post" action="/inventory/activation">
                            <input type="hidden" value="1" name="import" />
                            <div class="form-group">

                                <div class="col-sm-3">
                                    <input type="file" name="importeddata" id="importeddata"  class="form-control required"  style="border: none;" />
                                </div>
                                <div class="col-sm-2">
                                    <input  class="btn btn-success" type="submit" value="Import" />
                                    &nbsp;&nbsp;| &nbsp;&nbsp;
                                </div>
                                <div class="col-sm-7">                                 &nbsp;&nbsp;
                                    <input  class="btn btn-success" type="button" onclick="activate()" value="Activate" />
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="panel">
                <div class="page-header">
                    <h4>List of Inventory for Activation</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div id="impreport">
                            <table width="70%" class="table-bordered" id="acttable">
                                <tr>
                                    <th><input type="checkbox" class="checkbox chkall" value="0"></th>
                                    <th>IMEI</th>
                                    <th>Promocode</th>
                                    <th>Date</th>
                                </tr>
                                <?php for( $i=0; $i < count($arrUnActivated); $i++ ){
                                    ?>
                                        <tr>
                                            <td><input type="checkbox" class="chkbox checkbox"
                                                       value="<?php echo $arrUnActivated[$i]->imei?>"></td>
                                            <td><?php echo $arrUnActivated[$i]->imei?></td>
                                            <td><?php echo $arrUnActivated[$i]->promocode?></td>
                                            <td><?php echo $arrUnActivated[$i]->added_on?></td>
                                        </tr>
                                    <?php
                                } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script language="javascript">

    $(function () {

        $('.tt').tooltip({
            content:function(){
                return $(this).attr('title');
            }
        });

        $(".chkall").click(function () {
            if ($(".chkall").is(':checked')) {
                $(".chkbox").prop("checked", true);
            } else {
                $(".chkbox").prop("checked", false);
            }
        });

    });
    
    function activate() {
        var proceed = 0;
        var strACTID = '';
        $(".chkbox").each(function(){
            if($(this).is(':checked')) {
                proceed = 1;
                strACTID += $(this).val() + ", ";
            }
        });
        if( proceed == 1 ){
            $.ajax({
                url: "/ajaxcall/activate",
                type: "POST",
                data: "id=" + strACTID,
                success: function (response) {
               //     alert( response );
                    location.href = '/inventory/activation';
                }
            });
        } else {
            alert('Check atleast one IMEI to Activate !!! ');
        }

    }

</script>