<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="#">Home</a> </li>
				<li> <a href="/agentapp">Application</a> </li>
				<li> <a href="#">Send Individual Signup Email ( Agents )</a> </li>
			</ul>
		</div>
		<div class="page-content"> </div>
		<div class="">
			<div class="col-xs-12">
				<form method="post" class="form-horizontal" role="form" id="sendmailform" name="sendmailform" action="/agentapp">
					<div class="form-group">
						<label class="col-sm-1 control-label no-padding-right" for="form-field-1"> Email ID </label>
						<div class="col-sm-9">
							<input type="text" id="email" name="email" placeholder="Valid Email id" class="col-xs-10 col-sm-5" />
							&nbsp;&nbsp;&nbsp;&nbsp;
							<button class="btn btn-success" type="submit"> <i class="ace-icon fa fa-fw fa-check"></i> Send Email Application </button>
							<span><?php echo $strMsg;?></span>
							<a href="/agentapp">
								<button class="btn btn-cancel" type="button"> <i class="ace-icon fa fa-fw fa-check"></i>Cancel </button>
							</a>
						</div>
					</div>
					<div class="hr hr-24"></div>
				</form>
			</div>
		</div>





	</div>
</div>
<script language="javascript">

	$(function () {

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



</script>