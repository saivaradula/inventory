<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="/home">Home</a> </li>
				<li> <a href="#">Manage Inventory</a> </li>
				<li> <a href="#">List</a> </li>
			</ul>
		</div>
		<div class="page-content">

			<div class="panel">
				<div class="page-header">
					<h4>Inventory List For Purchase Order: <?php echo $arrInv->PO_NUMBER?></h4>
				</div>
				<div class="panel-body">
					<div class="">
						<table id="simple-table" class="table  table-bordered table-hover">
							<thead>
							<tr>
								<th>IMEI</th>
								<th>PO NUMBER</th>
								<th>STATUS</th>
								<th>ASSIGNED TO</th>
								<th>ADDED BY</th>
								<th>ADDED DATE</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
							<?php
								if ( count($arrInventory) ) {
									foreach ( $arrInventory AS $arrInv ) {
										?>
										<tr>
											<td>
												<?php echo $arrInv->IMEI?>
											</td>
											<td><?php echo $arrInv->PO_NUMBER?></td>
											<td><?php echo $arrInv->IMEI_STATUS?></td>
											<td><?php echo ( $arrInv->ASSIGNEDTO != '' ) ? $arrInv->ASSIGNEDTO : "-"?></td>
											<td><?php echo $arrInv->ADDEDBY?></td>
											<td><?php echo $arrInv->ADDED_ON?></td>
											<td align="center">
												<div class="hidden-sm hidden-xs btn-group">
													<a href="javascript:deleteCUser(<?php echo $arrObjCUser->USER_ID?>)" title="Delete Agent" class="text-danger"><i class="ace-icon fa fa-times bigger-120"></i></a>
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
					</div>
				</div>
			</div>
		</div>
	</div>