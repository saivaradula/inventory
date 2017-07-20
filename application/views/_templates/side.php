<div id="sidebar" class="sidebar responsive ace-save-state">
	<script type="text/javascript">
		try{ace.settings.loadState('sidebar')}catch(e){}
	</script>
	<!-- /.sidebar-shortcuts -->

	<ul class="nav nav-list">
		<li class="home_menu active"> <a href="/home">
				<i class="menu-icon fa fa-tachometer"></i>
				<span class="menu-text"> Dashboard </span>
			</a>
			<b class="arrow"></b>
		</li>

		<?php if ( $objC->isSuperAdmin() ) { ?>

			<li class="admin_menu">
				<a href="#" class="dropdown-toggle">
					<i class="menu-icon fa fa-user-plus"></i>
					<span class="menu-text"> Administration </span>
					<b class="arrow fa fa-angle-down"></b>
				</a>
				<b class="arrow"></b>

				<ul class="submenu">

						<li class="">
							<a href="/admin/roles">
								<i class="menu-icon fa fa-caret-right"></i>Manage Roles</a>
							<b class="arrow"></b>
						</li>

						<li class="">
							<a href="/admin/company">
								<i class="menu-icon fa fa-caret-right"></i>Manage Company</a>
							<b class="arrow"></b>
						</li>


				</ul>
			</li>
		<?php } ?>

		<?php if ( $objC->isAllowedModule('UL') ) { ?>
			<li class="users_menu">
				<a href="#" class="dropdown-toggle">
					<i class="menu-icon fa fa-user-plus"></i>
					<span class="menu-text"> Manage Users </span>
					<b class="arrow fa fa-angle-down"></b>
				</a>
				<b class="arrow"></b>

				<ul class="submenu">

					<?php if ( $objC->isAllowedModule('DIR') ) { ?>
						<li class="">
							<a href="/users/director">
								<i class="menu-icon fa fa-caret-right"></i>Directors</a>
							<b class="arrow"></b>
						</li>
					<?php } ?>

					<?php if ( $objC->isAllowedModule('SUBC') ) { ?>
						<?php if($_SESSION[ 'HAS_SCS' ]) { ?>
						<li class="">
							<a href="/users/subcontractor">
								<i class="menu-icon fa fa-caret-right"></i>Sub-Contractors</a>
							<b class="arrow"></b>
						</li>
						<?php } ?>
					<?php } ?>

					<?php if ( $objC->isAllowedModule('LOC') ) { ?>
						<li class="">
							<a href="/users/location">
								<i class="menu-icon fa fa-caret-right"></i>Location</a>
							<b class="arrow"></b>
						</li>
					<?php } ?>

					<?php if ( $objC->isAllowedModule('MGR') ) { ?>
						<li class="">
							<a href="/users/manager">
								<i class="menu-icon fa fa-caret-right"></i>Managers</a>
							<b class="arrow"></b>
						</li>
					<?php } ?>

					<?php if ( $objC->isAllowedModule('EMP') ) { ?>
						<li class="">
							<a href="/users/employee">
								<i class="menu-icon fa fa-caret-right"></i>Employee</a>
							<b class="arrow"></b>
						</li>
					<?php } ?>

					<?php if ( $objC->isAllowedModule('STF') ) { ?>
						<li class="">
							<a href="/users/staff">
								<i class="menu-icon fa fa-caret-right"></i>Staff</a>
							<b class="arrow"></b>
						</li>
					<?php } ?>

                    <?php if ( $objC->isAllowedModule('AGNT') ) { ?>
                        <li class="">
                            <a href="/users/agent">
                                <i class="menu-icon fa fa-caret-right"></i>Agent</a>
                            <b class="arrow"></b>
                        </li>
                    <?php } ?>

				</ul>
			</li>
		<?php } ?>
		<?php if ( $objC->isAllowedModule('INV') ) { ?>
		<li class="inventory_menu">
			<a href="#" class="dropdown-toggle">
				<i class="menu-icon fa fa-user-plus"></i>
				<span class="menu-text"> Manage Inventory </span>
				<b class="arrow fa fa-angle-down"></b>
			</a>
			<b class="arrow"></b>

			<ul class="submenu">
				<li class="">
					<a href="/inventory">
						<i class="menu-icon fa fa-caret-right"></i>My Inventory</a>
					<b class="arrow"></b>
				</li>
				<?php if ( $objC->isAllowedModule('CINV') ) { ?>
					<li class="">
						<a href="/inventory/checkin">
							<i class="menu-icon fa fa-caret-right"></i>Checkin</a>
						<b class="arrow"></b>
					</li>
				<?php } ?>
				<?php if ( $objC->isAllowedModule('SINV') ) { ?>
					<li class="">
						<a href="/inventory/shipping">
							<i class="menu-icon fa fa-caret-right"></i>Shipping</a>
						<b class="arrow"></b>
					</li>
				<?php } ?>
			</ul>
		<?php } ?>

		<li class=""> <a href="#" class="dropdown-toggle">
				<i class="menu-icon fa fa-info-circle"></i>
				<span class="menu-text"> Help </span> <b class="arrow fa fa-angle-down"></b> </a> <b class="arrow"></b>
			<ul class="submenu nav-hide" style="display: none;">
				<li class=""> <a href="#"> <i class="menu-icon fa fa-caret-right"></i> Download NLAD Training Manual </a> <b class="arrow"></b> </li>
				<li class=""> <a href="#"> <i class="menu-icon fa fa-caret-right"></i> Poverty Map </a> <b class="arrow"></b> </li>
			</ul>
		</li>

	</ul>
	<!-- /.nav-list -->

	<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse"> <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i> </div>
</div>