<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="/home">Home</a> </li>
				<li> <a href="#">Administration</a> </li>
				<li> <a href="/admin/company">Company</a> </li>
				<li> <a href="#">Users</a> </li>

			</ul>
		</div>
		<div class="clearfix hr-8"></div>

		<div class="">
			<div class="col-xs-12">
				<div class="col-md-offset-9">
					<button class="btn btn-success" type="button" onclick="javascript:location.href='/admin/addCompanyUser'">
						<i class="ace-icon fa fa-fw fa-check"></i>
						Add Company New Users</button>
				</div>
				<div class="hr hr-24"></div>

				<table id="simple-table" class="table  table-bordered table-hover">
					<thead>
					<tr>
						<th>Name</th>
						<th>Email</th>
						<th>Company</th>
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
									<td><?php echo $arrObjCUser->COMPANY?></td>
									<td><?php echo $arrObjCUser->PHONE?></td>
									<td align="center">
										<div class="hidden-sm hidden-xs btn-group">
											<a href="#" title="View"><i
													class="ace-icon fa fa-search bigger-120"></i></a> &nbsp;&nbsp;
											<a href="#" title="Show Details"><i
													class="ace-icon fa fa-list bigger-120"></i></a>
									</td>
								</tr>
							<?php
							}
						} else {
							?>
							<tr>
								<td colspan="2">No Users Found</td>
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
