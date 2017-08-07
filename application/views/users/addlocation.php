
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="/home">Home</a> </li>
				<li> <a href="/users/location">Manage Locations</a> </li>
				<?php if( $arrLoc->ID != '' ){ ?>
					<li> <a href="#">Update</a> </li>
				<?php } else { ?>
					<li> <a href="#">Add</a> </li>
				<?php } ?>

			</ul>
		</div>
		<div class="col-sm-12 page-Title">
			<h4><i class="fa fa-fw fa-user"></i>
                <?php if( $arrLoc->ID != '' ){ ?>
                    Update
                <?php } else { ?>
                    Add
                <?php } ?>
                Location</h4>
		</div>
		<form id="location_add_form" class="form-horizontal" role="form" method="post" action="/users/location">
			<?php if( $arrLoc->ID != '' ){ ?>
				<input type="hidden" name="location_id" value="<?php echo $arrLoc->ID?>" />
			<?php } ?>
			<div class="form-group">
				<label class="col-sm-2 control-label no-padding-right" for="form-field-1">Location Name</label>
				<div class="col-sm-7">
					<input value="<?php echo $arrLoc->NAME?>" type="text" id="locname" id name="locname" placeholder="Full Name"
					       class="required col-xs-10 col-sm-9" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label no-padding-right" for="form-field-1">Location Address</label>
				<div class="col-sm-8">
					<textarea class="required" name="address" cols="60" rows="5"><?php echo $arrLoc->ADDRESS?></textarea>
				</div>
			</div>
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Is Self Location</label>
                <div class="col-sm-8">
                    <input type="checkbox" name="is_self" />
                </div>
            </div>
			<div class="form-group">

                <?php if( $iAdmin ) {?>
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

				<?php if( $bSubCShow ) { ?>
					<label class="col-sm-2 control-label no-padding-right" for="form-field-1">Sub Contractor</label>
					<div class="col-sm-2">
						<select class="form-control required" id="subc" name="subc">
							<option value="">Select</option>
							<?php foreach ( $arrObjCUsers AS $arrObjCm ) { ?>
								<option value="<?php echo $arrObjCm->USER_ID?>"><?php echo $arrObjCm->USER_LOGIN_ID?></option>
							<?php } ?>
						</select>
					</div>
				<?php } ?>

			</div>
			<div class="clearfix form-actions">
				<div class="text-right">
					<?php if( $arrLoc->ID != '' ){ ?>
						<button class="btn btn-success" type="submit"> <i class="ace-icon fa fa-fw fa-check"></i> Update Location<span></span> </button>
					<?php } else  { ?>
						<button class="btn btn-success" type="submit"> <i class="ace-icon fa fa-fw fa-check"></i> Add Location<span></span> </button>
					<?php } ?>
					&nbsp;
					<button class="btn btn-danger" type="button"  onclick="javascript:location.href='/users/location'">
						<i class="ace-icon fa fa-fw fa-times"></i> Cancel<span></span>
					</button>
				</div>
			</div>
		</form>
	</div>
</div>
<script language="javascript">
	$(function(){
		$('#subc').find("[value='<?php echo $arrLoc->SUBCONTRACTOR?>']").prop("selected", true);
	});
	$('#location_add_form').validate({
		errorPlacement: function (error, element) {},
		submitHandler: function (form, e) {
			$('#location_add_form').unbind().submit();

		}
	});
</script>
