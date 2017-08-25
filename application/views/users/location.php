<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="/home">Home</a> </li>
				<li> <a href="#">Manage Locations</a> </li>
			</ul>
			<div class="f-right">
				<button class="btn btn-success" type="button" onclick="javascript:location.href='/users/location/add'">
					<i class="ace-icon fa fa-fw fa-plus"></i>
					New Location</button>
			</div>
		</div>

		<div class="page-content">
			<div class="panel">
				<div class="page-header">
					<h4><?php echo $strType?> List</h4>
				</div>
				<div class="panel-body">


					<div class="">
						<div class="clearfix hr-8"></div>
						<?php if( $iAdmin ) { ?>
                            <table id="simple-table" class="table  table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>State/Zipcode</th>
                                    <th>Company</th>
                                    <th>SC</th>
                                    <th>Manager</th>
                                    <th>Is Self</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if ( count($arrLocations) ) {
                                    foreach ( $arrLocations AS $arrLocation ) {
                                        ?>
                                        <tr>
                                            <td><?php echo $arrLocation->NAME?></td>
                                            <td title="<?php echo $arrLocation->ADDRESS_1 . " " . $arrLocation->ADDRESS_2 . " " .$arrLocation->ZIPCODE?>">
                                                <?php echo substr(  $arrLocation->ADDRESS_1 . " " . $arrLocation->ADDRESS_2, 0, 40 )

                                                ?> ...</td>
                                            <td><?php echo $arrLocation->STATE . ", " . $arrLocation->ZIPCODE?></td>
                                            <td><?php echo $arrLocation->COMPANY?></td>
                                            <td><?php echo $arrLocation->SUBCONTRACTOR?></td>
                                            <td><?php echo $arrLocation->MANAGER_NAME?></td>
                                            <td><?php echo ($arrLocation->IS_SELF) ? "Yes": "No"?></td>
                                            <td align="center">
                                                <div class="hidden-sm hidden-xs btn-group">
                                                    <a href="/users/location/edit/<?php echo $arrLocation->ID?>" title="Edit Details" class="text-success"><i class="ace-icon fa fa-edit bigger-120"></i></a> &nbsp;&nbsp;
                                                    <a href="/users/location/view/<?php echo $arrLocation->ID?>" title="View"><i class="ace-icon fa fa-search bigger-120"></i></a> &nbsp;&nbsp;

                                                    <a href="javascript:deleteCUser(<?php echo $arrLocation->ID?>)" title="Delete Agent" class="text-danger"><i class="ace-icon fa fa-times bigger-120"></i></a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="5">No <?php echo ucfirst($strType)?> Found</td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        <?php } else { ?>
                        <table id="simple-table" class="table  table-bordered table-hover">
							<thead>
							<tr>
								<th>Name</th>
								<th>Address</th>
								<th>State/Zipcode</th>
								<th>Manager</th>
								<th>Is Self</th>
								<?php if( $bSubCShow ) {?><th>Sub Contractor</th> <?php } ?>

                        <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ( count($arrLocations) ) {
                            foreach ( $arrLocations AS $arrLocation ) {
                                ?>
                                <tr>
                                    <td><?php echo $arrLocation->NAME?></td>
                                    <td title="<?php echo $arrLocation->ADDRESS_1 . " " . $arrLocation->ADDRESS_2 . " " .$arrLocation->ZIPCODE?>">
                                        <?php echo substr(  $arrLocation->ADDRESS_1 . " " . $arrLocation->ADDRESS_2, 0, 40 )

                                        ?> ...</td>
                                    <td><?php echo $arrLocation->STATE . ", " . $arrLocation->ZIPCODE?></td>
                                    <td><?php echo $arrLocation->MANAGER_NAME?></td>
                                    <td><?php echo ($arrLocation->IS_SELF) ? "Yes": "No"?></td>
                                    <?php if( $bSubCShow ) {?><td><?php echo $arrLocation->SCNAME?></td><?php } ?>

                                    <td align="center">
                                        <div class="hidden-sm hidden-xs btn-group">
                                            <a href="/users/location/edit/<?php echo $arrLocation->ID?>" title="Edit Details" class="text-success"><i class="ace-icon fa fa-edit bigger-120"></i></a> &nbsp;&nbsp;
                                            <a href="/users/location/view/<?php echo $arrLocation->ID?>" title="View"><i class="ace-icon fa fa-search bigger-120"></i></a> &nbsp;&nbsp;

                                            <a href="javascript:deleteCUser(<?php echo $arrLocation->ID?>)" title="Delete Agent" class="text-danger"><i class="ace-icon fa fa-times bigger-120"></i></a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="5">No <?php echo ucfirst($strType)?> Found</td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                        </table>
                       <?php } ?>



					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	$(function () {
		applyTS();
		$('#q_company').find("[value='<?php echo $_POST['q_company']?>']").prop("selected", true);
	});

	function deleteCUser(iUserId) {
		if(confirm('Do you want to delete the Location ?')){
			window.location.href = "/users/location/delete/" + iUserId;
		}
	}

	function applyTS() {
		<?php if( $bSubCShow ) {?>
			$('#simple-table').dataTable({
				"aoColumnDefs": [{
					'bSortable': false, 'aTargets': [4]
				}]
			});
		<?php } else { ?>
			$('#simple-table').dataTable({
				"aoColumnDefs": [{
					'bSortable': false, 'aTargets': [3]
				}]
			});
		<?php } ?>
	}
</script>