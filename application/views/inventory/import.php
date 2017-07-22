<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li> <i class="ace-icon fa fa-home home-icon"></i> <a href="/home">Home</a> </li>
                <li> <a href="/inventory">Manage Inventory</a> </li>
                <li> <a href="#">Import & Verify</a> </li>
            </ul>
        </div>
        <div class="clearfix hr-8"></div>


        <div class="page-content">
            <div class="row col-sm-12"><?php echo $strMsg ?></div>
            <div class="clearfix hr-8"></div>
            <div class="panel">
                <div class="page-header">
                    <h4>Import Inventory</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <form name="import_form" enctype="multipart/form-data" id="inventory_checkin" class="form-horizontal"
                              role="form" method="post" action="/inventory/import">
                            <input type="hidden" value="1" name="import" />
                            <div class="form-group">

                                <div class="col-sm-3">
                                    <input type="file" name="importeddata" id="importeddata"  class="form-control required"  style="border: none;" />
                                </div>
                                <div class="col-sm-6">
                                    <input  class="btn btn-success" type="submit" value="Import" />
                                    &nbsp;&nbsp; | &nbsp;&nbsp;
                                    <input  class="btn btn-success" type="button" value="Verify" />
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="panel">
                <div class="page-header">
                    <h4>Verify Inventory</h4>
                </div>
                <div class="panel-body">
                    <div class="row">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script language="javascript">


</script>