<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="/home">Home</a> </li>
				<li> <a href="#">Administration</a> </li>
				<li> <a href="/admin/company">Company</a> </li>
				<li> <a href="#">View</a> </li>
			</ul>
		</div>
		<div class="page-content">

			<div class="panel">
				<div class="page-header">
					<h4>View <?php echo $arrObjC[0]->NAME ?> Details</h4>
				</div>
				<div class="panel-body">
					<div class="row m-t-md">
						<div class="col-sm-12 col-xs-12">
							<div class="profile-user-info profile-user-info-striped">
								<div class="profile-info-row">
									<div class="profile-info-name">Company Name</div>
									<div class="profile-info-value"><?php echo $arrObjC[0]->NAME ?></div>
									<div class="profile-info-name">Email</div>
									<div class="profile-info-value"><?php echo $arrObjC[0]->EMAIL ?></div>
								</div>

								<div class="profile-info-row">
									<div class="profile-info-name"> Phone </div>
									<div class="profile-info-value"><?php echo $arrObjC[0]->PHONE ?></div>
									<div class="profile-info-name"> Website </div>
									<div class="profile-info-value"><?php echo $arrObjC[0]->WEBSITE ?></div>
								</div>
								<div class="profile-info-row">
									<div class="profile-info-name"> Address </div>
									<div class="profile-info-value"><?php echo $arrObjC[0]->ADDRESS ?></div>
									<div class="profile-info-name"> Has Subcontractors </div>
									<div class="profile-info-value"><?php echo ( $arrObjC[0]->SCS ) ? "Yes" : "No" ?></div>
								</div>
							</div>
						</div>
						<div>&nbsp;</div>
						<div class="clearfix form-actions">
							<div class="text-right">
								<button class="btn btn-success" type="button" onclick="javascript:location.href='/admin/company/edit/<?php echo $arrObjC[0]->ID ?>'"> <i class="ace-icon fa fa-fw fa-check"></i> Edit Company<span></span> </button>
								&nbsp;
								<button class="btn btn-danger" type="button"  onclick="javascript:location.href='/admin/company'">
									<i class="ace-icon fa fa-fw fa-times"></i> Go Back<span></span>
								</button>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

	</div>
</div>