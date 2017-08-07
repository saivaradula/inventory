<div class="main-content">
<div class="main-content-inner">
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
	<ul class="breadcrumb">
		<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="/home">Home</a> </li>
		<li> <a href="#">Manage Users</a> </li>
		<li><a href="/users/agent">Agents</a></li>
		<li><a href="#">Add Agent</a></li>
	</ul>
</div>
<div class="col-sm-12 page-Title">
	<h4><i class="fa fa-fw fa-user"></i> Add Agent</h4>
</div>
<div class="">

<div class="col-xs-12">
<form class="form-horizontal" role="form"
      ENCTYPE="multipart/form-data"
      id="agent_add_form" name="agent_add_form" method="post" action="/users/agent">
    <?php if($strRole == 'MANAGER') { ?>
        <input type="hidden" name="location" value="<?php echo $arrL->ID?>" />
    <?php } ?>
<div class="form-group">
	<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> First Name </label>
	<div class="col-sm-9">
		<input type="text" id="firstname" name="firstname" placeholder="First Name" class="required col-xs-10 col-sm-5"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Last Name </label>

	<div class="col-sm-9">
		<input type="text" id="lastname" name="lastname" placeholder="Last Name" class="required col-xs-10 col-sm-5"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Enrollment Number </label>

	<div class="col-sm-9">
		<input type="text" id="enrollnumber" name="enrollnumber" placeholder="Enrollment Number" class="required col-xs-10 col-sm-5"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Enrollment Channel </label>

	<div class="col-sm-9">
		<input type="text" id="enrollchannel" name="enrollchannel" placeholder="Enrollment Channel" class="required col-xs-10 col-sm-5"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> State </label>

	<div class="col-sm-4">
		<select class="required form-control" id="state" name="state">
			<option value="">Select</option>
			<option value="AL">Alabama</option>
			<option value="AK">Alaska</option>
			<option value="AZ">Arizona</option>
			<option value="AR">Arkansas</option>
			<option value="CA">California</option>
			<option value="CO">Colorado</option>
			<option value="CT">Connecticut</option>
			<option value="DE">Delaware</option>
			<option value="FL">Florida</option>
			<option value="GA">Georgia</option>
			<option value="HI">Hawaii</option>
			<option value="ID">Idaho</option>
			<option value="IL">Illinois</option>
			<option value="IN">Indiana</option>
			<option value="IA">Iowa</option>
			<option value="KS">Kansas</option>
			<option value="KY">Kentucky</option>
			<option value="LA">Louisiana</option>
			<option value="ME">Maine</option>
			<option value="MD">Maryland</option>
			<option value="MA">Massachusetts</option>
			<option value="MI">Michigan</option>
			<option value="MN">Minnesota</option>
			<option value="MS">Mississippi</option>
			<option value="MO">Missouri</option>
			<option value="MT">Montana</option>
			<option value="NE">Nebraska</option>
			<option value="NV">Nevada</option>
			<option value="NH">New Hampshire</option>
			<option value="NJ">New Jersey</option>
			<option value="NM">New Mexico</option>
			<option value="NY">New York</option>
			<option value="NC">North Carolina</option>
			<option value="ND">North Dakota</option>
			<option value="OH">Ohio</option>
			<option value="OK">Oklahoma</option>
			<option value="OR">Oregon</option>
			<option value="PA">Pennsylvania</option>
			<option value="RI">Rhode Island</option>
			<option value="SC">South Carolina</option>
			<option value="SD">South Dakota</option>
			<option value="TN">Tennessee</option>
			<option value="TX">Texas</option>
			<option value="UT">Utah</option>
			<option value="VT">Vermont</option>
			<option value="VA">Virginia</option>
			<option value="WA">Washington</option>
			<option value="WV">West Virginia</option>
			<option value="WI">Wisconsin</option>
			<option value="WY">Wyoming</option>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-3 control-label no-padding-right" for="form-field-4">Zip Code</label>

	<div class="col-sm-9">
		<input class="required zipcodeUS input-sm" type="text" id="zipcode" name="zipcode" placeholder="Zip Code"/>
	</div>
</div>
<div class="form-group">
	<label class="required col-sm-3 control-label no-padding-right" for="form-field-1">USAC Form </label>

	<div class="col-sm-4">
		<select class="form-control" id="usac" name="usac">
			<option value="">Select</option>
			<option value="YES">Yes</option>
			<option value="NO">No</option>
			<option value="UNKNOWN">Unknown</option>
		</select>
	</div>
</div>
<!-- <div class="form-group">
	<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Batch Date </label>

	<div class="col-sm-4">
		<div class="input-group">
			<input class="required form-control input-mask-date" type="text" id="batchdate" name="batchdate">
                        <span class="input-group-btn">
                        <button class="btn btn-sm btn-default" type="button"><i
		                        class="ace-icon fa fa-calendar bigger-110"></i></button>
                        </span>
		</div>
	</div>
</div>

-->
<div class="form-group">
	<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Group</label>

	<div class="col-sm-9">
		<input type="text" id="group" name="group" placeholder="Group" class="required col-xs-10 col-sm-5"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> DMA </label>

	<div class="col-sm-9">
		<input type="text" id="dma" name="dma"  placeholder="DMA" class="required col-xs-10 col-sm-5"/>
	</div>
</div>
    <!--
<div class="form-group">
	<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Batch Year </label>

	<div class="col-sm-4">
		<div class="input-group">

			<select class="required form-control"  id="batchyear" name="batchyear">
				<option value="">Select</option>
				<?php for($y=2011; $y <= date('Y'); $y++){ ?>
					<option value="<?php echo $y?>"><?php echo $y?></option>
				<?php } ?>
			</select>

		</div>
	</div>
</div>

-->

<?php if( $strRole == 'SUPERADMIN') { ?>
	<div class="form-group">
		<label class="required col-sm-3 control-label no-padding-right" for="form-field-1"> Company </label>

		<div class="col-sm-4">
			<select class="form-control required" id="company" name="company">
				<option value="">Select</option>
				<?php foreach ( $arrObjC AS $arrObjCm ) { ?>
					<option value="<?php echo $arrObjCm->ID?>"><?php echo $arrObjCm->NAME?></option>
				<?php } ?>
			</select>
		</div>
	</div>
<?php } ?>





<div class="form-group">
	<label class="col-sm-3 control-label no-padding-right">eMail</label>

	<div class="col-sm-9"> <span class="input-icon">
                     <input type="text" class="required col-xs-10 col-sm-12" id="email" name="email">
                     <i class="ace-icon fa fa-envelope-o blue"></i> </span>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-3 control-label no-padding-right">Phone</label>

	<div class="col-sm-9"> <span class="input-icon">
                     <input type="text" class="required phoneUS col-xs-10 col-sm-12" id="phone" name="phone">
                     <i class="ace-icon fa fa-envelope-o blue"></i> </span>
	</div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label no-padding-right">Promo Code</label>

    <div class="col-sm-9">
        <input type="text" class="required col-sm-3" id="promocode" name="promocode">
    </div>
</div>
<h3 class="header smaller lighter blue">
	Upload Documents
	<small>Upload all your documents properly</small>
</h3>
<div class="hr-24"></div>
<div class="form-group">
	<label class="col-sm-3 control-label no-padding-right">Headshotfile</label>

	<div class="col-sm-9">
		<span class="btn btn-default btn-file"> <input name="headshotfile" id="headshotfile" type="file"/></span>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-3 control-label no-padding-right">Govidfile</label>

	<div class="col-sm-9">
		<span class="btn btn-default btn-file"> <input name="govidfile" id="govidfile" type="file"/></span>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-3 control-label no-padding-right">Disclosure file</label>

	<div class="col-sm-9">
		<span class="btn btn-default btn-file"> <input name="disclosurefile" id="disclosurefile" type="file"/></span>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-3 control-label no-padding-right">BG Auth File</label>

	<div class="col-sm-9">
		<span class="btn btn-default btn-file"> <input name="bgauthfile" id="bgauthfile" type="file"/></span>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-3 control-label no-padding-right">Compcertfile</label>

	<div class="col-sm-9">
		<span class="btn btn-default btn-file"> <input name="compcertfile" id="compcertfile" type="file"/></span>
	</div>
</div>
<div class="clearfix form-actions">
	<div class="col-md-offset-3 col-md-9">
		<button class="btn btn-success" type="submit"><i class="ace-icon fa fa-fw fa-check"></i> Submit</button>
		&nbsp; &nbsp; &nbsp;
		<button class="btn btn-danger" type="reset" onclick="javascript:location.href='/users/agent'">
			<i class="ace-icon fa fa-fw fa-times"></i>Cancel<span></span>
		</button>
	</div>
</div>
<div class="hr hr-24"></div>
</form>
</div>
</div>
</div>
</div>

<script src="<?php echo PUBLIC_URL ?>js/ace.min.js"></script>

<script language="javascript">


	$(function () {

			$( "#batchdate" ).datepicker({
				showOtherMonths: true,
				selectOtherMonths: false
			});


		$('#agent_add_form').validate({
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
					data: "t=a&em=" + $('#email').val(),
					success: function (response) {
						if (response == 0) {

                            $.ajax({
                                url: "/validate/checkPromocode",
                                type: "POST",
                                data: "t=a&em=" + $('#promocode').val(),
                                success: function (response) {
                                    if (response == 0) {
                                        $('#agent_add_form').unbind().submit()
                                    }
                                    else {
                                        alert(" Promocode " + $('#promocode').val() + " already taken. !!!");
                                        $('#promocode').focus()
                                        return false;
                                    }
                                }
                            });
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