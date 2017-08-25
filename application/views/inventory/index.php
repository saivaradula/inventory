
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="/home">Home</a> </li>
				<li> <a href="#">Manage Inventory</a> </li>
				<li> <a href="#">List</a> </li>
			</ul>
		</div>

		<div class="page-content">
			<div class="panel">
				<div class="page-header">
					<h4>Inventory Action</h4>
				</div>
				<div class="panel-body">
					<form id="filter_form" method="post">
                        <input type="hidden" id="page" name="page" value="1" />
						<div class="row">
							<div class="f-right col-sm-12" >

								<div class="col-sm-12">
									<div class="col-sm-2">
										<input VALUE="<?php echo $_POST['ponumber']?>"
                                               type="text" class="form-control" name="ponumber" id="ponum" placeholder="Search by PO Number" />
									</div>
									<div class="col-sm-2">
										<select name="q_status" class="form-control" id="q_status">
											<option value="">By Status</option>
											<option value="CHECKED_IN">Checked In </option>
											<option value="SHIPPED_IN">Shipped</option>
                                            <?php if ( $objC->isAllowedModule('AINV') ) { ?>
                                                <option value="ASSIGNED">Assigned</option>
                                            <?php } ?>
                                            <option value="RECEIVE">Re-Checkin</option>
											<option value="SHIPPED [R]">Returned</option>
										</select>
									</div>
									<div class="col-sm-8">
										<button id="getInvBtn" type="button" class="btn btn-warning f-left m-r">
                                            <i class="fa fa-filter"></i>
                                        </button>
										<a href="/inventory">
											<button type="button" id="resetbtn" class="btn btn-default f-left m-r"> Clear </button>
										</a>

										<div class="f-right">
                                            <?php if ( $objC->isAllowedModule('CINV') ) { ?>
                                                <?php if( $_SESSION['IS_SELF'] == 0 ){ ?>
                                                    <button class="btn btn-success" type="button"
                                                            onclick="javascript:location.href='/inventory/checkin'">
                                                        <i class="ace-icon fa fa-fw fa-check"></i>
                                                        Checkin
                                                    </button>
                                                <?php } ?>
                                            <?php } ?>

                                            <?php if ( $objC->isAllowedModule('SINV') ) { ?>
                                                <button class="btn btn-default" type="button"
                                                        onclick="javascript:location.href='/inventory/shipping'">
                                                    <i class="ace-icon fa fa-fw fa-truck"></i>
                                                    Shippin
                                                </button>
                                            <?php } ?>

                                            <?php if ( $objC->isAllowedModule('AINV') ) { ?>
                                                <?php if ( !$objC->isSuperAdmin() ) { ?>
                                                    <button class="btn btn-default" type="button"
                                                            onclick="javascript:location.href='/inventory/assign'">
                                                        <i class="ace-icon fa fa-fw fa-truck"></i>
                                                        Assign
                                                    </button>
                                                <?php } ?>
                                            <?php } ?>

                                            <?php if ( $objC->isAllowedModule('INVD') ) { ?>
                                                <?php if ( !$objC->isSuperAdmin() ) { ?>
                                                    <button class="btn btn-primary" type="button"
                                                            onclick="javascript:location.href='/inventory/receive'">
                                                        <i class="ace-icon fa fa-fw fa-repeat"></i>
                                                        Re-Checkin
                                                    </button>
                                                <?php } ?>
                                            <?php } ?>

                                            <?php if ( $objC->isAllowedModule('RINV') ) { ?>
                                                <button class="btn btn-primary" type="button"
                                                        onclick="javascript:location.href='/inventory/returnItem'">
                                                    <i class="ace-icon fa fa-fw fa-repeat"></i>
                                                    Return
                                                </button>
                                            <?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>


			<div class="panel">
				<div class="page-header">
					<h4>Inventory List</h4>
				</div>
				<div class="panel-body">
					<div class="inventory_listing">
                            Loading data please wait...
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$(function () {
            $('.tt').tooltip({
                content:function(){
                    return $(this).attr('title');
                }

            });
            getInventory(1);
			$('#q_status').find("[value='<?php echo $_POST['q_status']?>']").prop("selected", true);

			$('#getInvBtn').click( function() {
			    getInventory(1);
            });


		});
		function applyTS() {
			$('#simple-table').dataTable({
				"aoColumnDefs": [{
					'bSortable': false, 'aTargets': [7]
				}]
			});
		}

		function getInventory( p ) {
            $('#page').val( p );
            $.ajax({
                url: "/inventory/getInvList",
                type: "POST",
                data: $('#filter_form').serialize(),
                success: function (response) {
                    $('.inventory_listing').html(response);

                    $('.tt').tooltip({
                        content:function(){
                            return $(this).attr('title');
                        }

                    });
                }
            });
        }
	</script>