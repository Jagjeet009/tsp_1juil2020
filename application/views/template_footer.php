						</div>										
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- container -->

				</div>
				<!-- Page content Wrapper -->

			</div>
			<!-- content -->

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
		</div>
		<!-- End Right content here -->

	</div>
	<!-- END wrapper -->
<modals>
<div id="duplicateSurveyModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Create Survey</h4>
      </div>
      <div class="modal-body">
		<form method="post" action="<?php echo base_url();?>survey/duplicate">
			<label>Name Your Survey</label>
			<input name="title" type="text">
			<input name="id" type="hidden" value="" />
			<input value="Create" type="submit">
		</form>       
      </div>
    </div>
  </div>
</div>	
</modals>

	<!-- jQuery  -->
	<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
	<script src="<?php echo base_url();?>theme/js/jquery-ui.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/popper.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/jquery.slimscroll.js"></script>
	<script src="<?php echo base_url();?>assets/js/waves.js"></script>
	<script src="<?php echo base_url();?>assets/pages/dashboard.js"></script>
	<!-- App js -->
	<script src="<?php echo base_url();?>assets/js/app.js"></script>
<script type="text/javascript">
function duplicateSurvey(survey_title_url){
	$('#duplicateSurveyModal').modal('show');
	$('#duplicateSurveyModal h4').html('Using this template');
	$('#duplicateSurveyModal input[name="id"]').val(survey_title_url);
}		
$(document).on('change','.template_country',function(){
	//alert($(this).val());
	window.location.href=$(this).val();
});
</script>	
</body>

</html>