<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="#">Home</a> </li>
				<li> <a href="#">Manage Users</a> </li>
				<?php if($strF!=''){ ?>
					<li> <a href="/users/agent">Agents</a> </li>
					<li> <a href="#"><?php echo $strF?></a> </li>
				<?php } else { ?>
					<li> <a href="#">Agents</a> </li>
				<?php }?>
			</ul>
			<div class="f-right p-t-sm">
				<button type="button" class="btn btn-success f-left" onclick="location.href='/users/agent/add'"><i class="fa fa-fw fa-plus"></i> New Agent</button>
			</div>
			<!-- /.nav-search -->
		</div>

		<div class="page-content">
			<div class="panel">
				<div class="page-header">
					<h4>Agent List</h4>
				</div>
			<div class="panel-body">
			<form id="filter_form" method="post" action="/users/agent/filter">
				<div class="row">
					<div class="col-xs-12 col-sm-2">
						<select  name="q_status" class="form-control" id="q_status">
							<option value="">Status</option>
							<option value="QUALIFIED">Qualified</option>
							<option value="PENDING">Pending</option>
							<option value="EXEMPT">Exempt</option>
							<option value="NOT_QUALIFIED">Not Qualified</option>
						</select>
					</div>
					<div class="col-xs-12 col-sm-2">
						<select name="agent_type" class="form-control" id="agent_type">
							<option value="">Role</option>
							<option value="AGENT">Agent</option>
							<option value="TEAM LEADER">Team Lead</option>
						</select>
					</div>
					<div class="col-xs-12 col-sm-2" style="height:30px;">
						<button id="submit" class="btn btn-warning f-left m-r"> <i class="fa fa-filter"></i> </button>
						<a href="/users/agent"><button type="button" id="resetbtn" class="btn btn-warning f-left m-r"> Clear </button></a>
					</div>
				</div>
			</form>
			<div class="row clearfix m-t-lg">
			<div class="col-xs-12 col-sm-12">
			<table id="simple-table" class="table table-bordered table-hover">
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
						<td align="center">
							<div class="hidden-sm hidden-xs btn-group">
								<a href="/users/agent/edit/<?php echo $arrAgent->USER_ID?>" title="Edit Details"><i class="ace-icon fa fa-edit"></i></a> &nbsp;&nbsp;
								<a href="/users/agent/view/<?php echo $arrAgent->USER_ID?>" title="View"><i class="ace-icon fa fa-search"></i></a> &nbsp;&nbsp;
								<a href="#" title="Show Details"><i class="ace-icon fa fa-bars"></i></a> &nbsp;&nbsp;
								<a href="javascript:deleteCUser(<?php echo $arrAgent->USER_ID?>)" title="Delete Agent"><i class="ace-icon fa fa-times"></i></a>
							</div>
						</td>
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
</div>



<script type="text/javascript">
	$(function () {
		applyTS();
		$('#q_status').find("[value='<?php echo $_POST['q_status']?>']").prop("selected", true);
		$('#agent_type').find("[value='<?php echo $_POST['agent_type']?>']").prop("selected", true);
	});

	function deleteCUser(iUserId) {

		if(confirm('Do you want to delete the User')){
			window.location.href = "/users/agent/delete/" + iUserId;
		}
	}

	function applyTS() {
		$('#simple-table').dataTable({
			"aoColumnDefs": [{
				'bSortable': false, 'aTargets': [6]
			}]
		});
	}
</script>