
<?php

	function company( $arrObjC ) {

	}
	function displayRoles(){

	}

	//function addUserForm( $strType, $action, $arrObjC, $arrUser = array(), $bShowCmpny = false, $bSubCShow = false ) {
	function addUserForm( $arrOptions ) {
			$strType = $arrOptions['strtype'];
			$action = $arrOptions['action'];;
			$arrObjC = $arrOptions['arrObjC'];
			$arrUser = $arrOptions['arrUser'];
			$bShowCmpny = $arrOptions['bShowCmpny'];
			$bSubCShow = $arrOptions['bSubCShow'];
			$arrObjCUsers = $arrOptions['arrObjCUsers'];
			$arrLocations = $arrOptions['arrLocations'];

		?>
		<form id="company_user_add_form" class="form-horizontal" role="form" method="post" action="<?php echo $action?>">
			<input type="hidden" id="old_login_name" value="<?php echo $arrUser->USER_NAME?>" />
			<input type="hidden" id="user_id" name="user_id" value="<?php echo $arrUser->USER_ID?>" />
			<div class="form-group">
				<label class="col-sm-2 control-label no-padding-right" for="form-field-1">Name</label>
				<div class="col-sm-4">
					<input value="<?php echo $arrUser->NAME?>" type="text" id="name" id name="name" placeholder="Full Name" class="required col-xs-10 col-sm-9" />
				</div>
				<label class="col-sm-2 control-label no-padding-right" for="form-field-1">Email</label>
				<div class="col-sm-4">
					<input value="<?php echo $arrUser->EMAIL_ID?>" type="text" id="email" id name="email" placeholder="Email ID" class="required col-xs-10 col-sm-9" />
				</div>
			</div>
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Date Of Birth</label>
                <div class="col-sm-4">
                    <input value="<?php echo $arrUser->DOB?>" type="text" id="dob"
                           name="dob" placeholder="Date of Birth" class="required col-xs-10 col-sm-9" />
                </div>
                <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Social</label>
                <div class="col-sm-4">
                    <input value="<?php echo $arrUser->SOCIAL?>" type="text"
                           id="social" name="social" placeholder="Social Security Number"
                           class="required col-xs-10 col-sm-9" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Address Line 1</label>
                <div class="col-sm-4">
                    <input value="<?php echo $arrUser->ADDRESS_ONE?>" type="text"
                           id="address_one" name="address_one" placeholder="Address Line One" class="required col-xs-10 col-sm-9" />
                </div>
                <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Address Line 2</label>
                <div class="col-sm-4">
                    <input value="<?php echo $arrUser->ADDRESS_TWO?>" type="text"
                           id="address_two" name="address_two" placeholder="Address Line Two" class="col-xs-10 col-sm-9" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="form-field-1">State</label>
                <div class="col-sm-4">
                    <?php include "states.php"; ?>
                </div>
                <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Zip Code</label>
                <div class="col-sm-4">
                    <input value="<?php echo $arrUser->ZIP_CODE?>" type="text"
                           id="zipcode" id name="zipcode" placeholder="Zip Code" class="required zipcodeUS col-xs-10 col-sm-9" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="form-field-1">DL</label>
                <div class="col-sm-4">
                    <input value="<?php echo $arrUser->DL?>" type="text"
                           id="dl" id name="dl" placeholder="DL#" class="col-xs-10 col-sm-9" />
                </div>

            </div>
			<div class="form-group">
				<label class="col-sm-2 control-label no-padding-right" for="form-field-1">Phone</label>
				<div class="col-sm-4">
					<input value="<?php echo $arrUser->PHONE?>" type="text" id="phone" id name="phone" placeholder="Phone Number" class="phoneUS col-xs-10 col-sm-9" />
				</div>
				<label class="col-sm-2 control-label no-padding-right" for="form-field-1">Login Name/Username</label>
				<div class="col-sm-4">
					<?php
						if( $arrUser->USER_NAME != '' ){
							?><input disabled value="<?php echo $arrUser->USER_NAME?>" type="text" id="username" name="username" placeholder="Login Name/Username" class="required col-xs-10 col-sm-9" /><?php
						} else {
							?><input type="text" id="username" name="username" placeholder="Login Name/Username" class="required col-xs-10 col-sm-9" /><?php
						}
					?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label no-padding-right" for="form-field-1">Role</label>
				<div class="col-sm-2">
					<input type="text" disabled value="<?php echo strtoupper($strType)?>" />
					<input type="hidden" disabled value="<?php echo strtoupper($strType)?>" />
				</div>

				<div class="col-sm-2"></div>
				<label class="col-sm-2 control-label no-padding-right" for="form-field-1">Password</label>
				<div class="col-sm-4">
					<?php  if( $arrUser->USER_NAME != '' ){ $isRequired = "";	} else { $isRequired = "required";} ?>
					<input type="password" id="password" name="password" placeholder="Password" class="<?php echo $isRequired?> col-xs-10 col-sm-9" />
				    <br /><br />
                    <span style="font-size: 10px; font-style: italic">** Password should be atleast 6 charecters</span>
                </div>
			</div>

			<div class="form-group">
				<?php if( $bShowCmpny ) { ?>
					<label class="col-sm-2 control-label no-padding-right" for="form-field-1">Company</label>
					<div class="col-sm-2">
						<select class="form-control required" id="company" name="company">
							<option value="">Select</option>
							<?php foreach ( $arrObjC AS $arrObjCm ) { ?>
								<option value="<?php echo $arrObjCm->ID?>"><?php echo $arrObjCm->NAME?></option>
							<?php } ?>
						</select>
					</div>
				<?php } ?>
			</div>

			<?php if( $strType == 'manager' ) { ?>
                <div class="form-group">
                    <?php if( $bSubCShow ) { ?>
                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Sub Contractor</label>
                        <div class="col-sm-2">
                            <select class="form-control" id="subc" name="subc">
                                <option value="">Select</option>
                                <?php foreach ( $arrObjCUsers AS $arrObjCm ) { ?>
                                    <option value="<?php echo $arrObjCm->USER_ID?>"><?php echo $arrObjCm->NAME?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } else {
                        ?>
                            <label class="col-sm-2 control-label no-padding-right" for="form-field-1"></label>
                            <div class="col-sm-2"></div>
                        <?php
                    }?>

                    <label class="col-sm-4 control-label no-padding-right" for="form-field-1">Location</label>
                    <div class="col-sm-2">
                        <select class="form-control" id="location" name="location">
                            <option value="">Select</option>
                            <?php foreach ( $arrLocations AS $arrLocation ) {  ?>
                                <option value="<?php echo $arrLocation->ID?>"
                                            class="<?php echo $arrLocation->SUBCONTRACTOR?>">
                                    <?php echo $arrLocation->NAME?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
			<?php } ?>

			<div class="clearfix form-actions">
				<div class="text-right">
					<?php if( $arrUser->USER_NAME != '' ){ ?>
						<button class="btn btn-success" type="submit"> <i class="ace-icon fa fa-fw fa-check"></i> Update <?php echo ucfirst($strType)?><span></span> </button>
					<?php } else  { ?>
						<button class="btn btn-success" type="submit"> <i class="ace-icon fa fa-fw fa-check"></i> Add <?php echo ucfirst($strType)?><span></span> </button>
					<?php } ?>
						&nbsp;
					<a href="javascript:location.href='/users/<?php echo $strType?>'">
                        <button class="btn btn-danger" type="button"  onclick="javascript:location.href=/users/<?php echo $strType?>">
                            <i class="ace-icon fa fa-fw fa-times"></i> Cancel<span></span>
                        </button>
                    </a>
				</div>
			</div>
		</form>
	<?php } ?>