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
				<h4>Inventory Action</h4>
			</div>
			<div class="panel-body">
				<form id="filter_form" method="post" action="/inventory/">
					<div class="row">
						<div class="f-right col-sm-12" >
							Filter by :
							<div class="f-right col-sm-11">
								<div class="col-sm-3">
									<input VALUE="<?php echo $_POST['ponumber']?>" type="text" class="form-control" name="ponumber" id="ponum" placeholder="By PO Number" />
								</div>
								<div class="col-sm-2">
									<select name="q_status" class="form-control" id="q_status">
										<option value="">By Status</option>
										<option value="CHECKED_IN">Checked In </option>
										<option value="SHIPPED_IN">Shipped</option>
										<option value="RETURN">Returned</option>
									</select>
								</div>
								<div class="col-sm-7">
									<button id="submit" class="btn btn-warning f-left m-r"> <i class="fa fa-filter"></i> </button>
									<a href="/inventory">
										<button type="button" id="resetbtn" class="btn btn-default f-left m-r"> Clear </button>
									</a>

									<div class="f-right">
										<button class="btn btn-success" type="button"
										                 onclick="javascript:location.href='/inventory/checkin'">
											<i class="ace-icon fa fa-fw fa-check"></i>
											Checkin
										</button>
										<button class="btn btn-default" type="button"
										        onclick="javascript:location.href='/inventory/shipping'">
											<i class="ace-icon fa fa-fw fa-truck"></i>
											Shippin
										</button>
										<button class="btn btn-primary" type="button"
										        onclick="/inventory/return'">
											<i class="ace-icon fa fa-fw fa-repeat"></i>
											Return
										</button>
									</div>
								</div>
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
					<div class="">
						<table id="simple-table" class="table  table-bordered table-hover">
							<thead>
							<tr>
								<th>Purchase Order</th>
								<th>Total Items</th>
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
												<a target="_blank" href="/inventory/<?php echo $arrInv->PO_NUMBER?>/items/">
													<?php echo $arrInv->PO_NUMBER?>
												</a>
											</td>
											<td><?php echo $arrInv->NUM_INV?></td>
											<td><?php echo $arrInv->PO_STATUS?></td>
											<td><?php echo ( $arrInv->ASSIGNEDTO != '' ) ? $arrInv->ASSIGNEDTO : "-"?></td>
											<td><?php echo $arrInv->ADDEDBY?></td>
											<td><?php echo $arrInv->ADDED_ON?></td>
											<td align="center">
												<div class="hidden-sm hidden-xs btn-group">
													<a href="/inventory/edit/<?php echo $arrInv->PO_NUMBER ?>" title="Edit Details" class="text-success"><i class="ace-icon fa fa-edit bigger-120"></i></a> &nbsp;&nbsp;
													<a target="_blank" href="/inventory/<?php echo $arrInv->PO_NUMBER?>/items/" title="View"><i class="ace-icon fa fa-search bigger-120"></i></a> &nbsp;&nbsp;

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
</div>

<script type="text/javascript">

	$(function () {
		applyTS();
		$('#q_status').find("[value='<?php echo $_POST['q_status']?>']").prop("selected", true);
	});



	function applyTS() {
		$('#simple-table').dataTable({
			"aoColumnDefs": [{
				'bSortable': false, 'aTargets': [6]
			}]
		});
	}
</script>