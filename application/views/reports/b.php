<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li> <i class="ace-icon fa fa-home home-icon"></i> <a href="/home">Home</a> </li>
                <li> <a href="#">Reports</a> </li>
                <li> <a href="#">Basic</a> </li>
            </ul>
        </div>

        <div class="page-content">
            <div class="panel">
                <div class="page-header">
                    <h4>Report By</h4>
                </div>
                <div class="panel-body">
                    <form id="filter_form" method="post" >
                        <input type="hidden" id="page" name="page" value="1" />
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-2">
                                    <select class="form-control required" id="company" name="company">
                                        <option value="">By Company</option>
                                        <?php foreach ( $arrObjC AS $arrObjCm ) { ?>
                                            <option value="<?php echo $arrObjCm->ID?>"><?php echo $arrObjCm->NAME?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                 <div class="col-sm-2" id="subcholder">
                                    <select class="form-control required" id="subc" name="subc">
                                        <option value="">By Sub Contractor</option>

                                    </select>
                                </div>
                                <div class="col-sm-2" id="locationholder">
                                    <select class="form-control" id="location" name="location">
                                        <option value="">By Location</option>
                                    </select>
                                </div>

                                <div class="col-sm-2">
                                    <select name="q_status" class="form-control" id="q_status">
                                        <option value="">By Status</option>
                                        <option value="CHECKED_IN">Checked In </option>
                                        <option value="ACTIVATED">Quaified</option>
                                        <option value="SHIPPED [R]">Returned</option>
                                    </select>
                                </div>

                                <!--
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="ponumber" id="ponumber" placeholder="By PO Number" />
                                </div> -->

                                <div class="col-sm-2">
                                    <button type="button" id="getreports" class="btn btn-warning f-left m-r">
                                        <i class="fa fa-filter"></i> Get Report
                                    </button>
                                </div>

                            </div>

                        </div>
                    </form>
                </div>
            </div>


            <div class="panel">
                <div class="page-header">
                    <h4>Inventory List</h4>
                </div>
                <div class="panel-body">
                    <div class="reports_results">
                        <table id="simple-table" class="table  table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>IMEI</th>
                                <th>PO NUMBER</th>
                                <th>STATUS</th>
                                <th>CURRENT USER</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if ( count($arrInventory) ) {
                                foreach ( $arrInventory AS $arrInv ) {
                                    ?>
                                    <tr>
                                        <td>
                                            <a class="tt" href="javascript:void(0)"  title="<?php echo $arrInv->LOG ?>">
                                                <?php echo $arrInv->IMEI?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php echo $arrInv->PO_NUMBER?>
                                        </td>
                                        <td><?php echo $arrInv->IMEI_STATUS?></td>
                                        <td><?php
                                            if( $arrInv->CU != '' ) {
                                                echo $arrInv->CU;
                                            } else {
                                                echo $arrInv->CUA;
                                            }
                                            ?></td>

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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function () {
            $('#getreports').click(function() {
                $('#page').val( 1 );
                $.ajax({
                    url: "/reports/getBasicReport",
                    type: "POST",
                    data: $('#filter_form').serialize(),
                    success: function (response) {
                        $('.reports_results').html(response);
                        $('#gobtn').click(function () {
                            $('#page').val( $('#shwpage').val() );
                            getReports();
                        });
                    }
                });
            });

            $('#gobtn').click(function () {
                $('#page').val( $('#shwpage').val() );
                getReports();
            });

            $('#company').change(function(){
                $.ajax({
                    url: "/ajaxcall/getSubContofCompy",
                    type: "POST",
                    data: "id=" + $(this).val(),
                    success: function (response) {
                        if(response == 0) {
                            $('#subcholder').hide();
                        } else {
                            $('#subcholder').show().html( response );
                            $('#subc option:first').html('By Sub Contractor');
                            $('#subc').change(function(){
                                changeSubC( $('#company').val(), $('#subc').val() );
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
                            $('#locationholder').hide();
                        } else {
                            $('#locationholder').show().html( response );
                            $('#location option:first').html('By Location')
                        }

                    }
                });

            });

            $('#subc').change(function(){
                changeSubC( $('#company').val(), $('#subc').val() );
            });




        });

        function getReportsByPage( p ) {
            $('#page').val( p );
            $.ajax({
                url: "/reports/getBasicReport",
                type: "POST",
                data: $('#filter_form').serialize(),
                success: function (response) {
                    $('.reports_results').html(response);
                    $('#gobtn').click(function () {
                        $('#page').val( $('#shwpage').val() );
                        getReports();
                    });
                }
            });
        }

        function getReports() {
            $.ajax({
                url: "/reports/getBasicReport",
                type: "POST",
                data: $('#filter_form').serialize(),
                success: function (response) {
                    $('.reports_results').html(response);
                    $('#gobtn').click(function () {
                        $('#page').val( $('#shwpage').val() );
                        getReports();
                    });
                }
            });
        }

        function changeSubC(id, sub) {
            $.ajax({
                url: "/ajaxcall/getLocOfCompy",
                type: "POST",
                data: "id=" + id + "&sub=" + sub,
                success: function (response) {
                    if(response == 0) {
                        $('#location').hide();
                    } else {
                        $('#location').show().html( response );
                        $('#location option:first').html('By Location');
                    }
                }
            });
        }


        
        


    </script>