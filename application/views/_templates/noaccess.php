
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="/home">Home</a> </li>
				<li> <a href="#">NO ACCESS PAGE</a> </li>
			</ul>
		</div>
		<div class="clearfix hr-8"></div>
		<div class="page-content">
			<div class="panel">
				<div class="page-header">
					<h4>! No Access</h4>
				</div>
				<div class="panel-body">
					<h3><?php echo $_SESSION['USER_NAME']?>, you have no access to this page. Contact Administrator.</h3>
					<p id="redirect">This page will redirect to home page automatically in <span id="seconds">5</span> seconds.</p>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
	#seconds {
		font-size: 17px;
	}
</style>
<script type="text/javascript">
	jQuery(function($) {
		var doUpdate = function() {
			$('#seconds').each(function() {
				var count = parseInt($(this).html());
				if (count !== 0) {
					$(this).html(count - 1);
				} else {
					$('#redirect').html('Redirect initiated...').css('font-size', '17px');
				}
			});
		};
		setInterval(doUpdate, 1000);
		setTimeout(function(){
			window.location = '/home';
		}, 6000);
	});
</script>

<?php exit;?>

