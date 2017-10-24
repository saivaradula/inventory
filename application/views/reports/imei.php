
<table id="simple-table" class="table  table-bordered table-hover">
    <tr>
        <th>Status for IMEI Number : <strong><?php echo $_POST['IMEI']?></strong></th>
    </tr>
</table>
<table id="simple-table" class="table  table-bordered table-hover">
    <thead>
    <tr>
        <th>S.No.</th>
        <th>USER</th>
        <th>PO NUMBER</th>
        <th>STATUS</th>
        <th>DESCRIPTION</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if ( count($arrR) ) {
        $i =0;
        foreach ( $arrR AS $arrInv ) {
            $i = $i + 1;
            ?>
            <tr>
                <td><?php echo $i?></td>
                <td><?php echo $arrInv->USER_TYPE?></td>
                <td><?php echo $arrInv->PO_NUMBER?></td>
                <td><?php echo $arrInv->IMEI_STATUS?></td>
                <td><?php echo $arrInv->DESCRIPTION?></td>

            </tr>
            <?php
        }
    } else {
        ?>
        <tr>
            <td colspan="8">No <?php echo ucfirst($strType)?> Found</td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>

<?php if ( $iTotalPages ) { ?>
    <table id="pagination" class="table table-bordered table-hover">
        <tr>
            <td width="25%" style="vertical-align: middle;">
                Showing
                <?php echo ( $arrOptions['low_limit'] ) ? $arrOptions['low_limit'] + 1 : "1"; ?> -
                <?php
                $iD = $arrOptions['limit_per_page'] * $_POST['page'];
                if( $iD > $iTotalRecords ) {
                    echo $iTotalRecords;
                } else {
                    echo $iD;
                }
                ?> of <?php echo $iTotalRecords?> Records
            </td>

            <td  width="50%" style="vertical-align: middle; text-align: center" >

                <a href="javascript:void(0)" title="Goto First Page" onclick="getReportsByPage(1)">
                    <i class="fa fa-angle-double-left  fa-lg"></i>
                </a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="javascript:void(0)" title="Goto Previous Page" onclick="getReportsByPage(<?php echo $_POST['page'] - 1?>)">
                    <i class="fa fa-angle-left  fa-lg"></i>
                </a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="javascript:void(0)" title="Goto Next Page" onclick="getReportsByPage(<?php echo $_POST['page'] + 1?>)">
                    <i class="fa fa-angle-right  fa-lg"></i>
                </a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="javascript:void(0)" title="Goto Last Page" onclick="getReportsByPage(<?php echo $iTotalPages?>)">
                    <i class="fa fa-angle-double-right fa-lg" aria-hidden="true"></i>
                </a>
            </td>

            <td>
                Page: &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="text" value="<?php echo $_POST['page']?>" id="shwpage"
                       maxlength="<?php echo strlen( $iTotalPages ) ?>"
                       size="<?php echo  strlen( $iTotalPages ) ?>">
                / <?php echo $iTotalPages?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="button" value="Go"  id="gobtn" />
            </td>
        </tr>
    </table>
<?php } ?>