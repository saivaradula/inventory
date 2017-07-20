
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="/home">Home</a> </li>
				<li> <a href="/users/location">Manage Locations</a> </li>

					<li> <a href="#">View</a> </li>


			</ul>
		</div>
		<div class="col-sm-12 page-Title">
			<h4><i class="fa fa-fw fa-user"></i> View Location Details</h4>
		</div>
		<form id="location_add_form" class="form-horizontal" role="form" method="post" action="/users/location">

			<div class="form-group">
				<label class="col-sm-2 control-label no-padding-right" for="form-field-1">Location Name</label>
				<div class="col-sm-7">
					<label class="col-sm-1 control-label no-padding-right" for="form-field-1">
						<strong><?php echo $arrLoc->NAME?></strong>
					</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label no-padding-right" for="form-field-1">Location Address</label>
				<div class="col-sm-8">
					<textarea style="border: 0px;" class="required" name="address" cols="60" rows="5"><?php echo $arrLoc->ADDRESS?></textarea>
				</div>
			</div>
			<div class="form-group">
				<?php if( $bSubCShow ) { ?>
					<label class="col-sm-2 control-label no-padding-right" for="form-field-1">Sub Contractor</label>
					<div class="col-sm-2">
						<select style="border: 0px;" class="form-control required" id="subc" name="subc">
							<option value="">Select</option>
							<?php foreach ( $arrObjCUsers AS $arrObjCm ) { ?>
								<option value="<?php echo $arrObjCm->USER_ID?>"><?php echo $arrObjCm->NAME?></option>
							<?php } ?>
						</select>
						<label class="col-sm-9 control-label no-padding-right" for="form-field-1">
							<strong><span id="subcl"></span></strong>
						</label>
					</div>
				<?php } ?>

			</div>

			<div class="clearfix form-actions">
				<div class="text-right">

					&nbsp;
					<button class="btn btn-danger" type="button"  onclick="javascript:location.href='/users/location'">
						<i class="ace-icon fa fa-fw fa-times"></i> Back to List<span></span>
					</button>
				</div>
			</div>

		</form>
	</div>
</div>
<script language="javascript">
	$(function(){
		$('#subc').find("[value='<?php echo $arrLoc->SUBCONTRACTOR?>']").prop("selected", true);
		///$('#subc option['selected']').text();
		$('#subcl').html( $('#subc option:selected').text() );
		$('#subc').hide();
	});

</script>
