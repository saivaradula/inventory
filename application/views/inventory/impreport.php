<div class="col-sm-12 col-xs-12">
    <div>
        <p>
            Original Inventory from OEM with PO Number : <strong><?php echo $_POST['po'] ?></strong> contains
            <strong><?php echo count($arrSImpRec) ?></strong> items.
        </p>
        <p>Your Inventory contains <strong><?php echo count( $arrSMyInv ) ?></strong> items.</p>
    </div>

    <div>
        <div class="row col-sm-6">
            <div class="panel">
                <div class="page-header">
                    <h4>Matching Inventory</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <table width="100%" class="table">
                            <tr>
                                <th>IMEI( Status )</th>
                            </tr>
                            <tr><td><?php echo $strMInv?></td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-1"></div>
        <div class="row col-sm-5">
            <div class="panel">
                <div class="page-header">
                    <h4>UnMatched Inventory ( total <?php echo $iUNC?> items ) </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <table width="100%" class="table">
                            <tr>
                                <th>IMEI</th>
                            </tr>
                            <?php /* for($i=0; $i < count($arrUnMInv); $i++) { ?>
                                <tr><td><?php echo $arrUnMInv[$i]?></td></tr>
                            <?php } */ ?>
                            <tr><td><?php echo $strUMInv?></td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>