<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="#">Home</a> </li>
				<li> <a href="#">Application</a> </li>
			</ul>
			<div class="f-right p-t-sm">
				<button type="button" class="btn btn-success f-right" onclick="location.href='/agentapp/sendapp'"><i class="fa fa-fw fa-plus"></i> New Application</button>
			</div>
		</div>
		<div class="page-content">
			<div class="panel">


				<div class="page-header">
					<h4>List of Self added Agents</h4>
				</div>
				<form id="filter_form" method="post" action="/agentapp">

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
							<select name="self_action" class="form-control" id="self_action">
								<option value="">Document Status</option>
								<option value="New">Newly Added</option>
								<option value="save">Saved</option>
								<option value="submit">Submitted</option>
							</select>
						</div>
						<div class="col-xs-12 col-sm-6 p-t-sm" style="height:30px;">
							<button id="submit" class="btn btn-warning f-left m-r"> <i class="fa fa-filter"></i> </button>
							<a href="/agentapp"><button type="button" id="resetbtn" class="btn btn-warning f-left m-r"> Clear </button></a>
							<span><?php echo $strMsg;?></span>
						</div>

				</form>
				<div class="clearfix"></div>
				<div class="panel-body">
					<table id="simple-table" class="table  table-bordered table-hover">
						<thead>
						<tr>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Status</th>
							<th>Phone</th>
							<th>Email</th>
							<th>Agent Action</th>
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
								<td><?php echo $arrAgent->SELF_ACTION?></td>
								<td align="center"><div class="hidden-sm hidden-xs btn-group">
										<a href="/users/agent/edit/<?php echo $arrAgent->USER_ID?> " title="Edit"><i class="ace-icon fa fa-edit"></i></a> &nbsp;&nbsp;
										<a href="/users/agent/view/<?php echo $arrAgent->USER_ID?> " title="View"><i class="ace-icon fa fa-search"></i></a> &nbsp;&nbsp;
										<a href="#" title="Show Details"><i class="ace-icon fa fa-list"></i></a></td>
							</tr>
						<?php } ?>

						</tbody>
					</table>
				</div>
			</div>




		</div>




		<div class="row">
			<div class="col-xs-12">
				<div class="row">
					<div class="col-xs-12">

					</div>
				</div>
			</div>
		</div>

	</div>
</div>
<script language="javascript">

	$(function () {
		applyTS();
		$('#q_status').find("[value='<?php echo $_POST['q_status']?>']").prop("selected", true);
		$('#self_action').find("[value='<?php echo $_POST['self_action']?>']").prop("selected", true);
	});

	function applyTS() {
		$('#simple-table').dataTable({
			"aoColumnDefs": [{
				'bSortable': false, 'aTargets': [6]
			}]
		});
	}

</script>