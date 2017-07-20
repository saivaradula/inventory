<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="#">Home</a> </li>
				<li> <a href="#">Manage Users</a> </li>
				<li> <a href="#">Agent</a> </li>
				<li> <a href="#"><?php echo $arrAgent->FIRST_NAME ?>  <?php echo $arrAgent->LAST_NAME ?></a></li>
			</ul>
		</div>

		<div class="page-content">
			<div class="panel">
				<div class="page-header">
					<h4>Edit <?php echo $arrAgent->FIRST_NAME ?>  <?php echo $arrAgent->LAST_NAME ?> Details</h4>
				</div>
				<div class="panel-body">
				<div class="">
				<div class="col-xs-12">
				<form class="form-horizontal" role="form" ENCTYPE="multipart/form-data"
				      id="agent_add_form" name="agent_add_form" method="post" action="/users/agent/edit/<?php echo $arrAgent->USER_ID ?>">
				<input type="hidden" value="<?php echo $arrAgent->USER_ID ?>" name="userid" id="userid" />

				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> First Name </label>
					<div class="col-sm-9">
						<input value="<?php echo $arrAgent->FIRST_NAME ?>" type="text" id="firstname" name="firstname" placeholder="First Name" class="required col-xs-10 col-sm-5"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Last Name </label>

					<div class="col-sm-9">
						<input  value="<?php echo $arrAgent->LAST_NAME ?>" type="text" id="lastname" name="lastname" placeholder="Last Name" class="required col-xs-10 col-sm-5"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Enrollment Number </label>

					<div class="col-sm-9">
						<input  value="<?php echo $arrAgent->ENROLLMENT_NUMBER ?>" type="text" id="enrollnumber" name="enrollnumber" placeholder="Enrollment Number" class="required col-xs-10 col-sm-5"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Enrollment Channel </label>

					<div class="col-sm-9">
						<input value="<?php echo $arrAgent->ENROLLMENT_CHANNEL ?>" type="text" id="enrollchannel" name="enrollchannel" placeholder="Enrollment Channel" class="required col-xs-10 col-sm-5"/>
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
						<input value="<?php echo $arrAgent->ZIPCODE ?>" class="required input-sm" type="text" id="zipcode" name="zipcode" placeholder="Zip Code"/>
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
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Batch Date </label>

					<div class="col-sm-4">
						<div class="input-group">
							<input value="<?php echo $arrAgent->BATCH_DATE ?>" class="required form-control input-mask-date" type="text" id="batchdate" name="batchdate">
                    <span class="input-group-btn">
                    <button class="btn btn-sm btn-default" type="button"><i
		                    class="ace-icon fa fa-calendar bigger-110"></i></button>
                    </span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Group</label>

					<div class="col-sm-9">
						<input value="<?php echo $arrAgent->AG_GROUP ?>" type="text" id="group" name="group" placeholder="Group" class="required col-xs-10 col-sm-5"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> DMA </label>

					<div class="col-sm-9">
						<input type="text" id="dma" value="<?php echo $arrAgent->DMA ?>"  name="dma" placeholder="DMA" class="required col-xs-10 col-sm-5"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Batch Year </label>

					<div class="col-sm-4">
						<div class="input-group">
							<input value="<?php echo $arrAgent->BATCH_YEAR ?>" class="required form-control input-mask-date" type="text" id="batchyear" name="batchyear">
                        <span class="input-group-btn">
                        <button class="btn btn-sm btn-default" type="button"><i
		                        class="ace-icon fa fa-calendar bigger-110"></i></button>
                        </span>
						</div>
					</div>
				</div>


				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">eMail</label>

					<div class="col-sm-9"> <span class="input-icon">
                     <input disabled value="<?php echo $arrAgent->EMAILID ?>"
                            type="text" class="col-xs-10 col-sm-12" >
					<input type="hidden" name="emailid" value="<?php echo $arrAgent->EMAILID ?>" />
                     <i class="ace-icon fa fa-envelope-o blue"></i> </span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Phone</label>

					<div class="col-sm-9"> <span class="input-icon">
                     <input value="<?php echo $arrAgent->PHONE ?>"  type="text" class="required col-xs-10 col-sm-12" id="phone" name="phone">
                     <i class="ace-icon fa fa-envelope-o blue"></i> </span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Status</label>

					<div class="col-sm-2">
						<select class="form-control" id="qstatus" name="qstatus">
							<option value="">Select</option>
							<option value="PENDING">PENDING</option>
							<option value="QUALIFIED">QUALIFIED</option>
							<option value="NOT_QUALIFIED">NOT QUALIFIED</option>
						</select>
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

						<button class="btn btn-success" type="submit"><i class="ace-icon fa fa-fw fa-check"></i> Update</button>
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
		</div>

</div>
</div>

<script type="text/javascript">
	jQuery(function($) {

		$( "#batchdate" ).datepicker({
			showOtherMonths: true,
			selectOtherMonths: false
		});


		$('#state').find("[value='<?php echo $arrAgent->STATE?>']").prop("selected", true);
		$('#usac').find("[value='<?php echo $arrAgent->USAC_FORM?>']").prop("selected", true);
		$('#qstatus').find("[value='<?php echo $arrAgent->Q_STATUS?>']").prop("selected", true);



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
				$('#agent_add_form').submit();
			}
		});
	});
</script>

<script language="javascript">

	/*$( "#batchdate" ).datepicker( {
	 dateFormat:  "dd/mm/yy",
	 changeYear:  true,
	 changeMonth: true,
	 maxDate:     0
	 } );*/


</script>
