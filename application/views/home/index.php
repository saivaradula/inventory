<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="/home">Home</a> </li>

			</ul>
			<!-- <div class="nav-search" id="nav-search">
				<form class="form-search">
		            <span class="input-icon">
		                    <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
		                    <i class="ace-icon fa fa-search nav-search-icon"></i> </span>
				</form>
			</div> -->
			<!-- /.nav-search -->

		</div>
        <?php if ( $strD != '' ) { ?>
        <div class="clearfix hr-8"></div>
        <div class="page-content">
            <div class="panel">
                <div class="page-header">
                    <h4>Data</h4>
                </div>
                <div class="panel-body">
                    <?php echo $strD ?>
                </div>
            </div>
        </div>
        <?php } ?>

	</div>
</div>