<div class="row small-cards">
	<div class="col-lg-3">
		<div class="card m-b-30">
			<a href="javascript:void(0)" onclick="shareDashboardWebLink()">
				<div class="card-header">
					<i class="fa fa-link fa-3x"></i>
				</div>
				<div class="card-body">
					<h4 class="card-title font-20 mt-0">Web Link</h4>
					<p class="card-text">Ideal for sharing via email, social media, etc.</p>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="card m-b-30">
			<a href="javascript:void(0)" onclick="shareDashboardEmail()">
				<div class="card-header">
					<i class="fa fa-envelope fa-3x"></i>
				</div>
				<div class="card-body">
					<h4 class="card-title font-20 mt-0">Email</h4>
					<p class="card-text">Ideal for tracking your survey respondents.</p>
				</div>
			</a>
		</div>
	</div>
	<!--<div class="col-lg-3">
		<div class="card m-b-30">
			<a href="#">
				<div class="card-header">
					<i class="fa fa-users fa-3x"></i>
				</div>
				<div class="card-body">
					<h4 class="card-title font-20 mt-0">Buy Responses</h4>
					<p class="card-text">Find people who fit your criteria.</p>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="card m-b-30">
			<a href="#">
				<div class="card-header">
					<i class="fab fa-facebook-f fa-3x"></i>
				</div>
				<div class="card-body">
					<h4 class="card-title font-20 mt-0">Social Media</h4>
					<p class="card-text">Post your survey on Facebook, LinkedIn or Twitter </p>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="card m-b-30">
			<a href="#">
				<div class="card-header">
					<i class="fa fa-file-alt fa-3x"></i>
				</div>
				<div class="card-body">
					<h4 class="card-title font-20 mt-0">Website</h4>
					<p class="card-text">Embed your survey on your website.</p>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="card m-b-30">
			<a href="#">
				<div class="card-header">
					<i class="fa fa-pencil-alt fa-3x"></i>
				</div>
				<div class="card-body">
					<h4 class="card-title font-20 mt-0">Manual Data Entry</h4>
					<p class="card-text">Manually enter responses.</p>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="card m-b-30">
			<a href="#">
				<div class="card-header">
					<i class="fab fa-facebook-messenger fa-3x"></i>
				</div>
				<div class="card-body">
					<h4 class="card-title font-20 mt-0">Facebook Messenger</h4>
					<p class="card-text">Get feedback in messenger</p>
				</div>
			</a>
		</div>
	</div>-->
</div>
<script type="text/javascript">
function shareDashboardWebLink(){
	$('#shareDashboardWeblinkModal').modal('show');
	$('#shareDashboardWeblinkModal input[name="dashboard_url"]').val("<?php echo base_url()."dashboard/".$dashboard_url; ?>");
}
function shareDashboardEmail(){
	$('#shareDashboardEmailModal').modal('show');
	var mtext="Hi, This is <?php echo $username; ?>.\r\nI want to share dashboard via the link below:\r\n[<?php echo base_url()."dashboard/".$dashboard_url; ?>]";
	$('#shareDashboardEmailModal [name="email_message"]').val(mtext);
}	
</script>		

