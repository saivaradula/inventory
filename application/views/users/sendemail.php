<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="#">Home</a> </li>
				<li> <a href="#">Users</a> </li>
				<li> <a href="#">Send Individual Signup Email</a> </li>
			</ul>
		</div>
		<div class="page-content"> </div>
		<div class="">
			<div class="col-xs-12">
				<form method="post" class="form-horizontal" role="form" id="sendmailform" name="sendmailform" action="/users/agent/sendemail">
					<div class="form-group">
						<label class="col-sm-1 control-label no-padding-right" for="form-field-1"> Email ID </label>
						<div class="col-sm-9">
							<input type="text" id="email" name="email" placeholder="Valid Email id" class="col-xs-10 col-sm-5" />
							&nbsp;&nbsp;&nbsp;&nbsp;
							<button class="btn btn-success" type="submit"> <i class="ace-icon fa fa-fw fa-check"></i> Send Email </button>
							<span><?php echo $strMsg;?></span>
						</div>
					</div>
					<div class="hr hr-24"></div>
				</form>
			</div>
		</div>

		<h4>List of Self added Agents</h4>

		<div class="row">
			<div class="col-xs-12">
				<div class="row">
					<div class="col-xs-12">
						<table id="simple-table" class="table  table-bordered table-hover">
							<thead>
							<tr>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Status</th>
								<th>Phone</th>
								<th>Email</th>
								<th>Role</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>

							<?php foreach($arrAgents AS $arrAgent) {?>

								<tr>
									<td><?php echo $arrAgent->FIRST_NAME?></td>
									<td><?php echo $arrAgent->LAST_NAME?></td>
									<td><?php echo $arrAgent->Q_STATUS?></td>
									<td><?php echo $arrAgent->PHONE?></td>
									<td><a href="#"><?php echo $arrAgent->EMAILID?></a></td>
									<td>Agent</td>
									<td align="center"><div class="hidden-sm hidden-xs btn-group">
											<a href="/users/agent/view/<?php echo $arrAgent->USER_ID?> " title="View"><i class="ace-icon fa fa-search bigger-120"></i></a> &nbsp;&nbsp;
											<a href="#" title="Show Details"><i class="ace-icon fa fa-list bigger-120"></i></a></td>
								</tr>
							<?php } ?>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
<script language="javascript">

	$(function () {
		applyTS();

		$('#sendmailform').validate({
			errorPlacement: function (error, element) {
			},
			rules: {
				email: {
					required: true,
					email: true
				}
			},
			submitHandler: function (form, e) {
				e.preventDefault();
				$.ajax({
					url: "/validate/checkUserEmail",
					type: "POST",
					data: "em=" + $('#email').val(),
					success: function (response) {
						if (response == 0) {
							$('#sendmailform').unbind().submit();
						}
						else {
							alert("User with EmailID " + $('#email').val() + " already exists. !!!");
							return false;
						}
					}
				});
			}
		});


	});

	function applyTS() {
		$('#simple-table').dataTable({
			"aoColumnDefs": [{
				'bSortable': false, 'aTargets': [6]
			}]
		});
	}

</script>