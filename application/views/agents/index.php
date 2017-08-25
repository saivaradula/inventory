<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="#">Home</a> </li>
				<li> <a href="/users">Manage Users</a> </li>
				<?php if($strF!=''){ ?>
						<li> <a href="/users/agent">Agents</a> </li>
						<li> <a href="#"><?php echo $strF?></a> </li>
				<?php } else { ?>
					<li> <a href="#">Agents</a> </li>
				<?php }?>
			</ul>

			<!-- /.nav-search -->
		</div>

		<div class="page-content">

			<form id="filter_form" method="post" action="/users/agent/filter">
				<div class="row">
					<div class="col-xs-12 col-sm-2 p-t-sm">
						<label> <span class="p-r-lg">Filter by</span>
							<input type="checkbox" name="file-format" id="id-file-format" class="ace">
							<span class="lbl"> All</span> </label>
					</div>
					<div class="col-xs-12 col-sm-2 p-t-sm">
						<select  name="q_status" class="form-control" id="q_status">
							<option value="">Status</option>
							<option value="QUALIFIED">Active</option>
							<option value="PENDING">Pending</option>
							<option value="EXEMPT">Exempt</option>
							<option value="NOT_QUALIFIED">Not Qualified</option>

						</select>
					</div>
					<div class="col-xs-12 col-sm-2 p-t-sm">
						<select class="form-control" id="form-field-select-1">
							<option value="">Team Leader</option>
							<option value="AL">Carla Bets</option>
							<option value="KS">John Duglus</option>
							<option value="KY">Eric Amstrong</option>
							<option value="LA">Kevin Louis</option>
						</select>
					</div>
					<div class="col-xs-12 col-sm-2 p-t-sm">
						<select class="form-control" id="form-field-select-1">
							<option value="">Director</option>
							<option value="AL">House</option>
							<option value="KS">WE Enterprise</option>
						</select>
					</div>
					<div class="col-xs-12 col-sm-2 p-t-sm">
						<select name="agent_type" class="form-control" id="agent_type">
							<option value="">Role</option>
							<option value="AGENT">Agent</option>
							<option value="TEAM LEADER">Team Lead</option>
						</select>
					</div>
					<div class="col-xs-12 col-sm-2 p-t-sm" style="height:30px;">
						<button id="submit" class="btn btn-warning"> <i class="fa fa-filter"></i> </button>
						<button type="button" class="btn btn-success f-right" onclick="location.href='/users/agent/add'"><i class="fa fa-fw fa-plus"></i> Add Agent</button>
					</div>
				</div>
			</form>
		</div>

		<div class="hr hr-18 dotted hr-double"></div>
				<div class="">
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
											<a href="/agents/view/<?php echo $arrAgent->USER_ID?> " title="View"><i class="ace-icon fa fa-search bigger-120"></i></a> &nbsp;&nbsp;
											<a href="#" title="Show Details"><i class="ace-icon fa fa-list bigger-120"></i></a></td>
								</tr>
							<?php } ?>

							</tbody>
						</table>
					</div>
				</div>


	</div>
</div>



<script type="text/javascript">

	$(function () {
		applyTS();
		$('#q_status').find("[value='<?php echo $_POST['q_status']?>']").prop("selected", true);
		$('#agent_type').find("[value='<?php echo $_POST['agent_type']?>']").prop("selected", true);
	});

	function applyTS() {
		$('#simple-table').dataTable({
			"aoColumnDefs": [{
				'bSortable': false, 'aTargets': [6]
			}]
		});
	}
</script>