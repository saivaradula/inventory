<?php //print_r( $arrAgent ); ?>
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="#">Home</a> </li>
				<li> <a href="#">Manage Users</a> </li>
				<li> <a href="/users/agent">Agents</a> </li>
				<li> <a href="#"><?php echo $arrAgent->FIRST_NAME ?>&nbsp;&nbsp;<?php echo $arrAgent->LAST_NAME ?></a> </li>
			</ul>
		</div>

		<div class="panel">
			<div class="page-header">
				<h4>View Agent Details</h4>
			</div>
			<div class="panel-body">
				<div class="page-content">
					<div class="row m-t-md">
                        <div id="agentsendemailmsg" style="display: none;" class="col-sm-12 col-xs-12" >
                            An Email has sent to Agent with Promocode.
                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <div class="profile-user-info profile-user-info-striped">
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Name </div>
                                    <div class="profile-info-value"><?php echo $arrAgent->FIRST_NAME ?> &nbsp;<?php echo $arrAgent->LAST_NAME ?></div>
                                    <div class="profile-info-name"> Promocode </div>
                                    <div class="profile-info-value"><?php echo $arrAgent->PROMOCODE ?></div>
                                </div>
                                <!-- <div class="profile-info-row">
                                    <div class="profile-info-name"> Enrollment Number </div>
                                    <div class="profile-info-value"><?php echo $arrAgent->ENROLLMENT_NUMBER ?></div>
                                    <div class="profile-info-name"> Enrollment Channel </div>
                                    <div class="profile-info-value"><?php echo $arrAgent->ENROLLMENT_CHANNEL ?></div>
                                </div> -->
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> State </div>
                                    <div class="profile-info-value"><?php echo $arrAgent->STATE ?></div>
                                    <div class="profile-info-name"> Zipcode </div>
                                    <div class="profile-info-value"><?php echo $arrAgent->ZIPCODE ?></div>
                                </div>
                                <!-- <div class="profile-info-row">
                                    <div class="profile-info-name"> USAC Form </div>
                                    <div class="profile-info-value"> <?php echo $arrAgent->USAC_FORM ?> </div>

                                </div>-->
                                <div class="profile-info-row">
                                    <!-- <div class="profile-info-name"> Group </div>
                                    <div class="profile-info-value"><?php echo $arrAgent->AG_GROUP ?></div> -->
                                    <div class="profile-info-name">Phone</div>
                                    <div class="profile-info-value"><?php echo $arrAgent->PHONE ?></div>
                                    <div class="profile-info-name">DOB</div>
                                    <div class="profile-info-value"><?php echo $arrAgent->DOB ?></div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Qualification Status </div>
                                    <div class="profile-info-value"><?php echo $arrAgent->Q_STATUS ?></div>
                                    <div class="profile-info-name">Email Id</div>
                                    <div class="profile-info-value"><?php echo $arrAgent->EMAILID ?></div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name">Sub Contractor</div>
                                    <div class="profile-info-value"><?php echo $arrAgent->SUBC ?></div>
                                    <div class="profile-info-name">Location</div>
                                    <div class="profile-info-value"><?php echo $arrAgent->LOCATION ?>, <?php echo $arrAgent->ADDRESS ?></div>
                                </div>

                            </div>
                        </div>

            </div>

			    <h3 class="header smaller lighter blue"> Documents </h3>
			    <div class="hr-24"></div>
                <div class="col-xs-12">
                    <div class="form-group p-t">
                        <label class="col-sm-4 control-label text-right p-t">Headshotfile:</label>
                        <div class="col-sm-2">
                            <?php if( $arrAgent->HEADSHOT_FILE != '') { ?>
                            <a title="View file" target="_blank" href="/<?php echo AGENTFILES . $arrAgent->HEADSHOT_FILE ?>">
                                <i class="menu-icon fa fa-2x fa-file-text-o"></i>
                            </a>
                            <?php } else { echo "N/A"; ?>
                                <input type="hidden" class="file404" value="1">
                            <?php } ?>
                        </div>
                        <label class="col-sm-4 control-label text-right p-t">Gov ID File:</label>
                        <div class="col-sm-2">
                            <?php if( $arrAgent->GOVID_FILE != '') { ?>
                                <a title="View file" target="_blank" href="/<?php echo AGENTFILES . $arrAgent->GOVID_FILE ?>">
                                    <i class="menu-icon fa fa-2x fa-file-text-o"></i>
                                </a>
                            <?php } else { echo "N/A"; ?>
                                <input type="hidden" class="file404" value="1">
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group p-t">
                        <label class="col-sm-4 control-label text-right p-t">Disclosure File:</label>
                        <div class="col-sm-2">
                            <?php if( $arrAgent->DISCLOSURE_FILE != '') { ?>
                                <a  title="View file" target="_blank" href="/<?php echo AGENTFILES . $arrAgent->DISCLOSURE_FILE ?>">
                                    <i class="menu-icon fa fa-2x fa-file-text-o"></i>
                                </a>
                            <?php } else { echo "N/A"; ?>
                                <input type="hidden" class="file404" value="1">
                            <?php } ?>
                        </div>
                        <label class="col-sm-4 control-label text-right p-t">BG Authentication File:</label>
                        <div class="col-sm-2">
                            <?php if( $arrAgent->BG_AUTH_FILE != '') { ?>
                                <a  title="View file" target="_blank" href="/<?php echo AGENTFILES . $arrAgent->BG_AUTH_FILE ?>">
                                    <i class="menu-icon fa fa-2x fa-file-text-o"></i>
                                </a>
                            <?php } else { echo "N/A"; ?>
                                <input type="hidden" class="file404" value="1">
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group p-t">
                        <label class="col-sm-4 control-label text-right p-t">Certificate File:</label>
                        <div class="col-sm-2">
                            <?php if( $arrAgent->COMP_CERT_FILE != '') { ?>
                                <a title="View file" target="_blank" href="/<?php echo AGENTFILES . $arrAgent->COMP_CERT_FILE ?>">
                                    <i class="menu-icon fa fa-2x fa-file-text-o"></i>
                                </a>
                            <?php } else { echo "N/A"; ?>
                                <input type="hidden" class="file404" value="1">
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 clearfix form-actions">
                    <div>

                        <?php if(  $arrAgent->PROMOCODE != '' ) { ?>
                            <?php if(  $arrAgent->Q_STATUS == 'QUALIFIED' ) { ?>
                                <button id="sendagentemail" onclick="javascript:sendAgentMail()" class="btn btn-success" type="button">
                                    <i class="ace-icon fa fa-fw fa-check"></i> Send Email to Agent
                                </button>
                                &nbsp;&nbsp; | &nbsp;
                            <?php } else { ?>
                                <button id="sendagentemail" onclick="javascript:alertMsg('Agent should be Qualified before sending PROMOCODE')" class="btn btn-success" type="button">
                                    <i class="ace-icon fa fa-fw fa-check"></i> Send Email to Agent
                                </button>
                                &nbsp;&nbsp; | &nbsp;
                            <?php } ?>
                        <?php } else { ?>
                            <button id="sendagentemail" onclick="javascript:alertMsg('Agent should have Promocode.')" class="btn btn-success" type="button">
                                <i class="ace-icon fa fa-fw fa-check"></i> Send Email to Agent
                            </button>
                            &nbsp;&nbsp; | &nbsp;
                        <?php } ?>

                        <button class="btn btn-success" type="button" onclick="javascript:location.href='/users/agent/edit/<?php echo $arrAgent->USER_ID?>'"> <i class="ace-icon fa fa-fw fa-check"></i> Edit Agent<span></span> </button>
                        &nbsp; &nbsp;&nbsp; | &nbsp;
                        <button class="btn btn-danger" type="button" onclick="javascript:location.href='/users/agent'">
                            <i class="ace-icon fa fa-fw fa-times"></i> Go Back<span></span>
                        </button>
                    </div>

                    <br /><br />
                    <div>
                        <input type="text" id="oememailid" value="sai.varadula@gmail.com">
                        <button onclick="javascript:sendemailtooem()" id="sendemailtooem" class="btn btn-success" type="button">
                            <i class="ace-icon fa fa-fw fa-check"></i> Send Email to OEM
                        </button>
                    </div>
                </div>

				</div>
			</div>
		</div>

	</div>
</div>

<input type="hidden" id="agent_id" value="<?php echo $arrAgent->USER_ID?>" />

<script type="text/javascript">
    jQuery(function($) {

    });

    function alertMsg(strMsg) {
        alert( strMsg );
    }

    function sendemailtooem() {
        var f404 = $('.file404').val();
        if( f404 == 1 ) {
            alert('Agent does not have all the documents. Cannot send email to OEM'); return false;
        } else {
            var oemmailid = $('#oememailid').val();
            if( oemmailid == '' ){
                alert('Please enter a valid OEM mail id'); $('#oememailid').focus(); return false;
            } else {
                var atpos = oemmailid.indexOf("@");
                var dotpos = oemmailid.lastIndexOf(".");
                if (atpos < 1 || dotpos < atpos+2 || dotpos+2 >= oemmailid.length) {
                    alert('Please enter a valid OEM mail id');  $('#oememailid').focus();  return false;
                } else {
                    $.ajax({
                        url: "/agentapp/sendoememail",
                        type: "POST",
                        data: "email="+oemmailid+"&id=" + $('#agent_id').val(),
                        success: function (response) {
                            alert('An Email has sent to OEM with Agent Details');
                        }
                    });
                }
            }
        }
    }

    function sendAgentMail() {
        $.ajax({
            url: "/agentapp/sendagentemail",
            type: "POST",
            data: "id=" + $('#agent_id').val(),
            success: function (response) {
               // $('#agentsendemailmsg').show();
                alert('An Email has sent to Agent with Promocode.');
            }
        });
    }
</script>