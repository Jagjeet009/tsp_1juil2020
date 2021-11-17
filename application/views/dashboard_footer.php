<script type="text/javascript">
function primaryDashboard(survey_title_url=''){
	document.cookie = "design_survey="+survey_title_url+";path=/;";
	document.cookie = "fill_survey="+survey_title_url+";path=/;";
	document.cookie = "analytics_survey="+survey_title_url+";path=/;";
	setTimeout(function(){
		window.location='<?php echo base_url(); ?>';
	}, 1000);
}	
</script>	
<modals>
	<div id="shareDashboardWeblinkModal" class="modal fade" role="dialog">
	  <div class="modal-dialog" style="width:700px;max-width:700px;">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Web Link</h4>
		  </div>
		  <div class="modal-body">
			<form name="dashboard-form" id="dashboard-form" method="post">
				<input name="username" type="hidden" value="">
				<label>Dashboard Url</label>
				<input name="dashboard_url" required type="text" value="" readonly>
				<input type="button" class="close" data-dismiss="modal" value="Close">
			</form>              
		  </div>
		</div>
	  </div>
	</div>	
	<div id="shareDashboardEmailModal" class="modal fade" role="dialog">
	  <div class="modal-dialog" style="width:700px;max-width:700px;">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Email</h4>
		  </div>
		  <div class="modal-body">
			<form name="dashboard-form" id="dashboard-form" method="post" action="<?php echo base_url();?>dashboard/email/">
				<input name="email_url" type="hidden" value="">
				<label>To (a@gmail.com,b@gmail.com)</label>
				<input name="email_to" required type="text" value="">
				<label>Subject</label>
				<input name="email_subject" required type="text" value="Thesurveypoint.com Dashboard Sharing" readonly>
				<label>Message</label>
				<textarea name="email_message" required readonly>
				</textarea>
				<input value="Send" type="submit">
			</form>              
		  </div>
		</div>
	  </div>
	</div>		
</modals>	
                 <footer class="footer">
                    <div class="col-md-12">
						<div class="icons">
							<a href="https://www.facebook.com/thesurveypoint" target="_blank"><i class="fa fa-facebook"></i></a>
							<a href="https://twitter.com/sambodhi" target="_blank"><i class="fa fa-twitter"></i></a> 
							<a href="https://www.linkedin.com/in/thesurveypoint/" target="_blank"><i class="fa fa-linkedin"></i></a> 
							<a href="https://www.instagram.com/thesurveypoint/" target="_blank"><i class="fa fa-instagram"></i></a> 
							<a href="https://plus.google.com/u/0/115478327721066879463" target="_blank"><i class="fa fa-google-plus"></i></a> 
						</div>
						<p>COPYRIGHT © 2015-<?php echo date('Y',time()); ?> <a href="http:www.sambodhi.co.in">Sambodhi Research &amp; Communications Pvt Ltd</a></p>
					</div>
                </footer>
        <!-- jQuery  -->
        <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>theme/js/jquery-ui.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/waves.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/dashboard.js"></script>
        <!-- App js -->
        <script src="<?php echo base_url(); ?>assets/js/app.js"></script>
		<script src="<?php echo base_url(); ?>theme/js/bootstrap3-typeahead.min.js"></script>  
<link href="<?php echo base_url(); ?>theme/css/jquery.contextMenu.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url(); ?>theme/js/jquery.contextMenu.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url()."theme/"; ?>jqcloud/jqcloud.css" />
<script type="text/javascript" src="<?php echo base_url()."theme/"; ?>jqcloud/jqcloud.js"></script>

<script type="text/javascript" src="<?php echo base_url()."theme/"; ?>js/html2canvas.js"></script>