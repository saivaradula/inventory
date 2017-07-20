<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="/home">Home</a> </li>
				<li> <a href="#">Administration</a> </li>
				<li> <a href="#">Company</a> </li>
			</ul>
			<div class="f-right">
				<button class="btn btn-success" type="button" onclick="javascript:location.href='/admin/addCompany'">
					<i class="ace-icon fa fa-fw fa-check"></i>
					Add New Company</button>
			</div>
		</div>
		<div class="clearfix hr-8"></div>

		<div class="page-content">
						<div class="panel">
							<div class="page-header">
								<h4>Company List</h4>
							</div>
							<div class="panel-body">

					<div class="">
				<div class="col-xs-12">
					<div class="clear">&nbsp;</div>
					<table id="simple-table" class="table  table-bordered table-hover">
						<thead>
							<tr>
								<th>Company Name</th>
								<th>Address</th>
								<th>Phone</th>
								<th>Email</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						<?php
							if ( count($arrObjC) ) {
								foreach ( $arrObjC AS $arrObjCm ) {
									?>
									<tr>
										<td><?php echo $arrObjCm->NAME?></td>
										<td><?php echo $arrObjCm->ADDRESS?></td>
										<td><?php echo $arrObjCm->PHONE?></td>
										<td><?php echo $arrObjCm->EMAIL?></td>
										<td align="center">
											<div class="hidden-sm hidden-xs btn-group">
												<a href="/admin/company/edit/<?php echo $arrObjCm->ID ?>" title="Edit Details" class="text-success"><i class="ace-icon fa fa-edit bigger-120"></i></a> &nbsp;&nbsp;
												<a href="/admin/company/view/<?php echo $arrObjCm->ID ?>" title="View"><i class="ace-icon fa fa-search bigger-120"></i></a> &nbsp;&nbsp;

												<a href="javascript:delC(<?php echo $arrObjCm->ID ?>)" title="Delete Agent" class="text-danger"><i class="ace-icon fa fa-times bigger-120"></i></a>
										</td>
									</tr>
								<?php
								}
							} else {
								?>
									<tr>
										<td colspan="6">No Companies Found</td>
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
</div>


<script type="text/javascript">
	$(function () {
		applyTS();
		//$('#q_status').find("[value='<?php echo $_POST['q_status']?>']").prop("selected", true);
		//$('#agent_type').find("[value='<?php echo $_POST['agent_type']?>']").prop("selected", true);

		$('#company_add_form').validate({
			errorPlacement: function (error, element) {
			},
			submitHandler: function (form) {
				$('#company_add_form').submit();
			}
		});
	});

	function delC( cid ){
		if( confirm("Do you want delete this Company ?") ){
			window.location.href = "/admin/company/delete/" + cid;
		}
	}

	function applyTS() {
		$('#simple-table').dataTable({
			"aoColumnDefs": [{
				'bSortable': false, 'aTargets': [5]
			}]
		});
	}
</script>