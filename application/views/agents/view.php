<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="#">View your details</a> </li>

			</ul>
		</div>
		<div class="page-content">
			<div class="row m-t-md">
				<div class="col-sm-12 col-xs-12">
					<div class="profile-user-info profile-user-info-striped">
						<div class="profile-info-row">
							<div class="profile-info-name"> First Name </div>
							<div class="profile-info-value"><?php echo $arrAgent->FIRST_NAME ?></div>
							<div class="profile-info-name"> Last Name </div>
							<div class="profile-info-value"><?php echo $arrAgent->LAST_NAME ?></div>
						</div>

						<div class="profile-info-row">
							<div class="profile-info-name"> State </div>
							<div class="profile-info-value"><?php echo $arrAgent->STATE ?></div>
							<div class="profile-info-name"> Zipcode </div>
							<div class="profile-info-value"><?php echo $arrAgent->ZIPCODE ?></div>
						</div>

						<div class="profile-info-row">
                            <div class="profile-info-name"> DOB </div>
                            <div class="profile-info-value"><?php echo $arrAgent->DOB ?></div>
							<div class="profile-info-name">Phone</div>
							<div class="profile-info-value"><?php echo $arrAgent->PHONE ?></div>
						</div>
						<div class="profile-info-row">
							<div class="profile-info-name"> Qualification Status </div>
							<div class="profile-info-value"><?php echo $arrAgent->Q_STATUS ?></div>
							<div class="profile-info-name">Email Id</div>
							<div class="profile-info-value"><?php echo $arrAgent->EMAILID ?></div>
						</div>
                        <div class="profile-info-row">

                        </div>
					</div>
				</div>

			</div>

			<h3 class="header smaller lighter blue"> Upload Documents <small>Upload all your documents properly</small> </h3>
			<div class="hr-24"></div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="form-group p-t">
					<label class="col-sm-4 control-label text-right p-t">Headshotfile:</label>
					<div class="col-sm-2">
                        <?php if( $arrAgent->HEADSHOT_FILE != ''  ) { ?>
						<a title="View file" target="_blank" href="/<?php echo AGENTFILES . $arrAgent->HEADSHOT_FILE ?>">
							<i class="menu-icon fa fa-2x fa-file-video-o"></i>
						</a>
                        <?php } else {?>
                            N/A
                        <?php } ?>
					</div>
					<label class="col-sm-4 control-label text-right p-t">Gov ID File:</label>
					<div class="col-sm-2">
                        <?php if( $arrAgent->GOVID_FILE != ''  ) { ?>
						<a title="View file" target="_blank" href="/<?php echo AGENTFILES . $arrAgent->GOVID_FILE ?>">
							<i class="menu-icon fa fa-2x fa-file-text-o"></i>
						</a>
                        <?php } else {?>
                            N/A
                        <?php } ?>
					</div>
					</div>
				<div class="form-group p-t">
					<label class="col-sm-4 control-label text-right p-t">Disclosure File:</label>
					<div class="col-sm-2">
                        <?php if( $arrAgent->DISCLOSURE_FILE != ''  ) { ?>
                            <a  title="View file" target="_blank" href="/<?php echo AGENTFILES . $arrAgent->DISCLOSURE_FILE ?>">
                                <i class="menu-icon fa fa-2x fa-file-pdf-o"></i>
                            </a>
                        <?php } else {?>
                            N/A
                        <?php } ?>
					</div>
					<label class="col-sm-4 control-label text-right p-t">BG Authentication File:</label>
					<div class="col-sm-2">
                        <?php if( $arrAgent->BG_AUTH_FILE != ''  ) { ?>
                            <a  title="View file" target="_blank" href="/<?php echo AGENTFILES . $arrAgent->BG_AUTH_FILE ?>">
                                <i class="menu-icon fa fa-2x fa-file-powerpoint-o"></i>
                            </a>
                        <?php } else {?>
                            N/A
                        <?php } ?>
					</div>
				</div>
				<div class="form-group p-t">
					<label class="col-sm-4 control-label text-right p-t">Certificate File:</label>
					<div class="col-sm-2">
                        <?php if( $arrAgent->COMP_CERT_FILE != ''  ) { ?>
                            <a title="View file" target="_blank" href="/<?php echo AGENTFILES . $arrAgent->COMP_CERT_FILE ?>">
                                <i class="menu-icon fa fa-2x fa-file-audio-o"></i>
                            </a>
                        <?php } else {?>
                            N/A
                        <?php } ?>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>