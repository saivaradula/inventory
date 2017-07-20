<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="/home">Home</a> </li>
				<li> <a href="#">Administration</a> </li>
				<li> <a href="/admin/company">Company</a> </li>
				<li> <a href="#">Edit</a> </li>

			</ul>
		</div>
		<div class="clearfix hr-8"></div>

		<div class="col-xs-12">
			<form id="company_add_form" class="form-horizontal" role="form" method="post" action="/admin/company/edit">
				<input type="hidden" value="<?php echo $arrObjC[0]->ID?>" id="id_h" name="id_h" />
				<input type="hidden" value="<?php echo $arrObjC[0]->SCS?>" id="scs_h" />
				<div class="form-group">
					<label class="col-sm-2 control-label no-padding-right" for="form-field-1">Company Name</label>
					<div class="col-sm-4">
						<input value="<?php echo $arrObjC[0]->NAME?>" type="text" id="company_name" name="company_name"
						       placeholder="Company Name"  class="required col-xs-10 col-sm-9" />
					</div>
					<label class="col-sm-2 control-label no-padding-right" for="form-field-1">Contact Email</label>
					<div class="col-sm-4">
						<input value="<?php echo $arrObjC[0]->EMAIL?>" type="text" id="email" name="email" placeholder="Contact Email ID" class="required col-xs-10 col-sm-9" />
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label no-padding-right" for="form-field-1">Address</label>
					<div class="col-sm-4">
						<textarea id="address" name="address" placeholder="Company Address"
						          class="col-xs-10 col-sm-9"><?php echo $arrObjC[0]->ADDRESS?></textarea>
					</div>
					<label class="col-sm-2 control-label no-padding-right" for="form-field-1">Contact Phone</label>
					<div class="col-sm-4">
						<input value="<?php echo $arrObjC[0]->PHONE?>" type="text" id="phone" name="phone" placeholder="Contact Phone number" class="required col-xs-10 col-sm-9" />
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label no-padding-right" for="form-field-1">Website</label>
					<div class="col-sm-4">
						<input type="text" VALUE="<?php echo $arrObjC[0]->WEBSITE?>" id="website" name="website" placeholder="Website of the company" class="col-xs-10 col-sm-9" />
					</div>
					<div class="col-sm-4 f-right">
						<input type="checkbox" id="scs" name="scs" class="" /> &nbsp;&nbsp;&nbsp;
						<label for="form-field-1">Has Sub Contractors ?</label>
					</div>

				</div>
				<div>
					<div class="f-right">
						<button class="btn btn-success" type="submit"><i class="ace-icon fa fa-fw fa-check"></i> Update Company</button>
						&nbsp; &nbsp; &nbsp;
						<button class="btn" type="reset" onclick="javascript:location.href='/admin/company'">
							<i class="ace-icon fa fa-fw fa-times"></i> Cancel</button>
					</div>
				</div>
			</form>

		</div>
	</div>


	<script language="javascript">
		$(function () {
			$('#scs').prop("checked", false);

			if( $('#scs_h').val() == 1 ) {
				$('#scs').prop("checked", true);
			}

			$('#company_add_form').validate({
				errorPlacement: function (error, element) {
				},
				submitHandler: function (form) {
					$('#company_add_form').submit();
				}
			});
		});
	</script>
