
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="#">Home</a> </li>
				<li> <a href="#">Manage Users</a> </li>
				<li> <a href="#"><?php echo $strType?></a> </li>
				<li> <a href="#"><?php echo $arrUser->NAME ?></a></li>
			</ul>
		</div>
		<div class="page-content">

			<div class="panel">
				<div class="page-header">
					<h4>View <?php echo $arrUser->NAME ?> Details</h4>
				</div>
				<div class="panel-body">
					<div class="row m-t-md">
						<div class="col-sm-12 col-xs-12">
							<div class="profile-user-info profile-user-info-striped">
								<div class="profile-info-row">
									<div class="profile-info-name">Name</div>
									<div class="profile-info-value"><?php echo $arrUser->NAME ?></div>
									<div class="profile-info-name">Email</div>
									<div class="profile-info-value"><?php echo $arrUser->EMAIL_ID ?></div>
								</div>

								<div class="profile-info-row">
									<div class="profile-info-name"> Phone </div>
									<div class="profile-info-value"><?php echo $arrUser->PHONE ?></div>
									<div class="profile-info-name"> Company </div>
									<div class="profile-info-value"><?php echo $arrUser->CNAME ?></div>
								</div>
								<div class="profile-info-row">
									<div class="profile-info-name"> Login </div>
									<div class="profile-info-value"><?php echo $arrUser->USER_NAME ?></div>
									<div class="profile-info-name"> Password </div>
									<div class="profile-info-value">**********</div>
								</div>
								<?php if($arrUser->LOCNAME != '' ) { ?>
								<div class="profile-info-row">
									<div class="profile-info-name"> Sub Contractor </div>
									<div class="profile-info-value"><?php echo $arrUser->LOCSUBCONTRACTOR ?></div>
									<div class="profile-info-name"> Location </div>
									<div class="profile-info-value"><?php echo $arrUser->LOCNAME ?></div>
								</div>
								<?php } ?>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> DOB </div>
                                    <div class="profile-info-value"><?php echo $arrUser->DOB ?></div>
                                    <div class="profile-info-name"> SOCIAL </div>
                                    <div class="profile-info-value"><?php echo $arrUser->SOCIAL ?></div>
                                </div>



                                <div class="profile-info-row">

                                    <?php if( $iDisplayAddress ) { ?>
                                        <div class="profile-info-name">Address:</div>
                                        <div class="profile-info-value">
                                            <?php
                                                echo $arrUser->ADDRESS_ONE . ", " . $arrUser->ADDRESS_TWO . "<br />" . $arrUser->STATE . ", " . $arrUser->ZIP_CODE;
                                            ?>
                                        </div>
                                    <?php } ?>

                                    <div class="profile-info-name"> DL </div>
                                    <div class="profile-info-value"><?php echo $arrUser->DL ?></div>
                                </div>


							</div>
						</div>
						<div>&nbsp;</div>
						<div class="clearfix form-actions">
							<div class="text-right">
								<button class="btn btn-success" type="button" onclick="javascript:location.href='/users/<?php echo $strType?>/edit/<?php echo $arrUser->USER_ID ?>'"> <i class="ace-icon fa fa-fw fa-check"></i> Edit <?php echo $strType?> <span></span> </button>
								&nbsp;
								<button class="btn btn-danger" type="button"  onclick="javascript:location.href='/users/<?php echo $strType?>'">
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