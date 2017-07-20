<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="/home">Home</a> </li>
				<li> <a href="#">Administration</a> </li>
				<li> <a href="/admin/company">Company</a> </li>
				<li> <a href="/admin/companyusers">Users</a> </li>
				<li> <a href="#">Add User</a> </li>

			</ul>
		</div>
		<div class="clearfix hr-8"></div>

		<form id="company_user_add_form" class="form-horizontal" role="form" method="post" action="/admin/addcuser">
			<div class="form-group">
				<label class="col-sm-2 control-label no-padding-right" for="form-field-1">Name</label>
				<div class="col-sm-4">
					<input type="text" id="name" id name="name" placeholder="Full Name" class="required col-xs-10 col-sm-9" />
				</div>
				<label class="col-sm-2 control-label no-padding-right" for="form-field-1">Email</label>
				<div class="col-sm-4">
					<input type="text" id="email" id name="email" placeholder="Email ID" class="required col-xs-10 col-sm-9" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label no-padding-right" for="form-field-1">Phone</label>
				<div class="col-sm-4">
					<input type="text" id="phone" id name="phone" placeholder="Phone Number" class="col-xs-10 col-sm-9" />
				</div>
				<label class="col-sm-2 control-label no-padding-right" for="form-field-1">Login Name/Username</label>
				<div class="col-sm-4">
					<input type="text" id="username" id name="username" placeholder="Login Name/Username" class="required col-xs-10 col-sm-9" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label no-padding-right" for="form-field-1">Company Name</label>
				<div class="col-sm-2">
					<select class="form-control required" id="company" name="company">
						<option value="">Select</option>
						<?php foreach ( $arrObjC AS $arrObjCm ) { ?>
							<option value="<?php echo $arrObjCm->ID?>"><?php echo $arrObjCm->NAME?></option>
						<?php } ?>

					</select>
				</div>
				<div class="col-sm-2"></div>
				<label class="col-sm-2 control-label no-padding-right" for="form-field-1">Password</label>
				<div class="col-sm-4">
					<input type="password" id="password" name="password" placeholder="Password" class="required col-xs-10 col-sm-9" />
				</div>
			</div>
			<div class="clearfix form-actions">
				<div class="col-md-offset-9 col-md-9">
					<button class="btn btn-success" type="submit"> <i class="ace-icon fa fa-fw fa-check"></i> Add User<span></span> </button>
					&nbsp;
					<button class="btn" type="reset" onclick="javascript:location.href='/admin/companyusers'">
							<i class="ace-icon fa fa-fw fa-times"></i>Cancel<span></span>
					</button>
				</div>
			</div>
		</form>

	</div>
</div>


<script language="javascript">
	$('#company_user_add_form').validate({
		errorPlacement: function (error, element) {
		},
		rules: {
			email: {
				required: true,
				email: true
			}
		},
		submitHandler: function (form) {
			$('#company_user_add_form').submit();
		}
	});
</script>

