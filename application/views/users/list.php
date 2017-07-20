<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="/home">Home</a> </li>
				<li> <a href="#">Manage Users</a> </li>
				<li> <a href="#"><?php echo $strType?></a> </li>
			</ul>
			<div class="f-right">
				<button class="btn btn-success" type="button" onclick="javascript:location.href='/users/<?php echo strtolower($strType)?>/add'">
					<i class="ace-icon fa fa-fw fa-plus"></i>
					New <?php echo $strType?></button>
			</div>
		</div>

		<div class="page-content">
			<div class="panel">
				<div class="page-header">
					<h4><?php echo $strType?> List</h4>
				</div>
				<div class="panel-body">
					<?php if( $_SESSION['ROLE_ID'] == SUPERADMIN ) { ?>
						<form id="filter_form" method="post" action="/users/<?php echo $strType?>">
							<div class="row">

								<div class="col-xs-12 col-sm-2 p-t-sm">
									<select  name="q_company" class="form-control" id="q_company">
										<option value="">By Company</option>
										<?php foreach ( $arrObjC AS $arrObjCm ) { ?>
											<option value="<?php echo $arrObjCm->ID?>"><?php echo $arrObjCm->NAME?></option>
										<?php } ?>
									</select>
								</div>

								<div class="col-xs-12 col-sm-6 p-t-sm" style="height:30px;">
									<button id="submit" class="btn btn-warning f-left m-r"> <i class="fa fa-filter"></i> </button>
									<a href="/users/<?php echo $strType?>"><button type="button" id="resetbtn" class="btn btn-warning f-left m-r"> Clear </button></a>
								</div>
							</div>
						</form>
					<?php } ?>

					<div class="">
						<div class="clearfix hr-8"></div>
						<table id="simple-table" class="table  table-bordered table-hover">
							<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<?php if( $bShowCmpny ) {?><th>Company</th> <?php } ?>
								<th>Phone</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
							<?php
								if ( count($arrObjCUsers) ) {
									foreach ( $arrObjCUsers AS $arrObjCUser ) {
										?>
										<tr>
											<td><?php echo $arrObjCUser->NAME?></td>
											<td><?php echo $arrObjCUser->EMAIL_ID?></td>
											<?php if( $bShowCmpny ) {?><td><?php echo $arrObjCUser->COMPANY?></td><?php } ?>
											<td><?php echo $arrObjCUser->PHONE?></td>
											<td align="center">
												<div class="hidden-sm hidden-xs btn-group">
													<a href="/users/<?php echo $strType ?>/edit/<?php echo $arrObjCUser->USER_ID?>" title="Edit Details" class="text-success"><i class="ace-icon fa fa-edit bigger-120"></i></a> &nbsp;&nbsp;
													<a href="/users/<?php echo $strType ?>/view/<?php echo $arrObjCUser->USER_ID?>" title="View"><i class="ace-icon fa fa-search bigger-120"></i></a> &nbsp;&nbsp;

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
		$('#q_company').find("[value='<?php echo $_POST['q_company']?>']").prop("selected", true);
	});

	function deleteCUser(iUserId) {

		if(confirm('Do you want to delete the <?php echo $strType ?> ?')){
			window.location.href = "/users/<?php echo $strType ?>/delete/" + iUserId;
		}
	}

	function applyTS() {
		<?php if( $bShowCmpny ) {?>
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