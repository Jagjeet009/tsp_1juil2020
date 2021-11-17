<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<!-- seo url tags start-->
<?php
$tags=$this->db->query("select tags from urls where url='".current_url()."'");
if($tags->num_rows()>0){
	$tags=$tags->result_array();
	$tags=$tags[0]['tags'];
	//print_r($tags);
	if($tags!=''){echo $tags;}
}else{
	echo '<title>The Survey Point - Sambodhi</title>';
}
?>

<!-- seo url tags end-->
<link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.ico">
<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/css/dashboard.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo base_url();?>theme/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>theme/css/jquery-ui.css">

<!-- theme css -->
<?php 
if($this->session->has_userdata('user_logged_username')){
	$user_data=$this->User_model->get_user_by_id($this->session->userdata('user_logged_id'));
	//print_r($user_data);
	if($user_data[0]['theme']!=''){
	?>
<link href="<?php echo base_url(); ?>userthemes/<?php echo $user_data[0]['theme']; ?>.css" rel="stylesheet" type="text/css">
<?php }} ?>
<!-- theme css -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-129581270-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-129581270-1');
</script>

</head>
    <body class="fixed-left">
       <!-- base image file-->
		<?php 
		if($this->session->has_userdata('user_logged_username')){
			$user_data=$this->User_model->get_user_by_id($this->session->userdata('user_logged_id'));
			?>
		<div id="base_theme">
			<img src="<?php echo base_url()."userthemes/".$user_data[0]['theme']; ?>.jpg" />
		</div>
		<?php } ?>
       <!-- base image file-->
       
        <!-- Begin page -->
        <div id="wrapper">

            <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">
                <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left">
                    <i class="ion-close"></i>
                </button>

                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center">
					<?php 
					if($this->session->has_userdata('user_logged_username')){
						$user_data=$this->User_model->get_user_by_id($this->session->userdata('user_logged_id'));
						if($user_data[0]['theme']==""){
						?>
                        <a href="<?php echo base_url(); ?>" class="logo"><img src="<?php echo base_url(); ?>assets/images/logo-2.png" height="65" alt="logo"></a>
						<?php }else{?>
                        <a href="<?php echo base_url(); ?>" class="logo"><img src="<?php echo base_url(); ?>assets/images/logo-3.png" height="65" alt="logo"></a>
						<?php }?>
					<?php } ?>
					</div>
                </div>
               

                <div class="sidebar-inner slimscrollleft" id="sidebar-main">

                    <div id="sidebar-menu">
                        <ul>
                            <!--<li class="menu-title">Overview</li>-->
                            <li>
                                <a href="javascript:void(0)" onClick="$('#dashboard_createsurvey').show();$('#dashboard_mysurvey').hide();$('#dashboard_manage').hide();" class="waves-effect waves-light"><i class="fa fa-tag"></i><span> Create Survey </span></a>
                            </li>
							<li>
								<a href="javascript:void(0)" class="waves-effect waves-light" onclick="$('#dashboard_mysurvey').show();$('#dashboard_manage').hide();$('#dashboard_createsurvey').hide();"><i class="fa fa-tag"></i><span> My Surveys  </span></a>
							</li>

                            <li>
                                <a href="javascript:void(0)" onClick="$('#newDashboardModal').modal('show');" class="waves-effect waves-light"><i class="fa fa-tag"></i><span> Create Dashboard </span></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" class="waves-effect waves-light" onclick="$('#dashboard_mysurvey').hide();$('#dashboard_manage').show();$('#dashboard_createsurvey').hide();"><i class="fa fa-tag"></i><span> Manage Dashboard </span></a>
                            </li>
                            <li class="has_sub">
							   <?php
								$q=$this->db->query("select * from dashboards where username='".$this->session->userdata('user_logged_username')."' ");
								$q_total=$q->num_rows();
								?>                                   
                                <a href="javascript:void(0);" class="waves-effect waves-light"><i class="fa fa-tag"></i><span> My Dashboards </span><span class="badge badge-pill badge-primary float-right"><?php echo $q_total; ?></span></a>
                                <ul class="list-unstyled">
                                   <?php
									if($q->num_rows()>0){
										$q=$q->result_array();
										foreach($q as $qq){
											echo '<li><a href="'.base_url()."dashboard/".$qq['dashboard_url'].'">'.$qq['dashboard_name'].'</a></li>';
										}
									}
									?>
                                </ul>
                            </li>

							
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div> <!-- end sidebarinner -->
            </div>
            <!-- Left Sidebar End -->

            <!-- Start right Content here -->

            <div class="content-page">
                <!-- Start content -->
                <div class="content">

                    <!-- Top Bar Start -->
                    <div class="topbar">
                        <nav class="navbar-custom">
                            <ul class="list-inline float-right mb-0">
                                <li class="list-inline-item dropdown notification-list">
                                    <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                                        aria-haspopup="false" aria-expanded="false">
                                        <!--<img src="assets/images/users/avatar-1.jpg" alt="user" class="rounded-circle">-->
                                        <i class="fa fa-user rounded-circle"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                        <!-- item-->
                                        <div class="dropdown-item noti-title">
                                            <h5>Welcome</h5>
                                        </div>
                                        <a class="dropdown-item"  href="javascript:void(0)" onClick="changeTheme()"><i class="fa "></i> Change Theme</a>
                                        <a class="dropdown-item"  href="javascript:void(0)" onClick="editProfile()"><i class="fa "></i> Edit Profile</a>
                                        <a class="dropdown-item"  href="javascript:void(0)" onClick="editPermission()"><i class="fa "></i> Permissions</a>
                                        <!--<a class="dropdown-item" href="#"><i class="fa fa-tag"></i> My Wallet</a>
                                        <a class="dropdown-item" href="#"><span class="badge badge-primary float-right">3</span><i class="fa "></i> Settings</a>
                                        <a class="dropdown-item" href="#"><i class="fa fa-tag"></i> Lock screen</a>-->
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="<?php echo base_url(); ?>login/logout"><i class="fa "></i> Logout</a>
                                    </div>
                                </li>
                            </ul>

                            <ul class="list-inline menu-left mb-0">
                                <li class="float-left">
                                    <button class="button-menu-mobile open-left waves-light waves-effect">
                                        <i class="fa fa-tag"></i>
                                    </button>
                                </li>
                                <li class="hide-phone dashboard-title">
									<h3><?php print_r($this->session->userdata('user_logged_username')); ?></h3>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </nav>
                    </div>
                    <!-- Top Bar End -->
                    <div class="page-content-wrapper">
                        <div class="container-fluid">
                        	<div id="dashboard_mysurvey" class="row small-cards">
								<?php $this->load->view('dashboard_mysurvey'); ?>
							</div><!-- End table -->
							<div id="dashboard_manage" class="row small-cards">
								<?php $this->load->view('dashboard_manage'); ?>
							</div><!-- row -->
							<div id="dashboard_createsurvey" class="row small-cards">
								<?php $this->load->view('dashboard_createsurvey'); ?>
							</div><!-- row -->
                        </div><!-- container -->
                    </div> <!-- Page content Wrapper -->
                </div> <!-- content -->
               
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
<?php 
if($this->session->userdata('user_logged_id')){
	$user_data=$this->User_model->get_user_by_id($this->session->userdata('user_logged_id'));
?>
<modals>
	<div id="profileModal" class="modal fade" role="dialog">
	  <div class="modal-dialog" style="width:300px;">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Edit Your Profile</h4>
		  </div>
		  <div class="modal-body">
				<form name="profile-form" id="profile-form" method="post" action="<?php echo base_url();?>login/profile/save/<?php echo $user_data[0]['username'];?>">
				<label>Username</label>
				<input name="username" required type="text" disabled value="<?php echo $user_data[0]['username'];?>">
				<label>Email</label>
				<input name="email" required type="email" value="<?php echo $user_data[0]['email'];?>">
				<label>Password</label>
				<input name="password" required type="text" value="<?php echo $user_data[0]['password'];?>">
				<label>Name</label>
				<input name="name" required type="text" value="<?php echo $user_data[0]['name'];?>">
				<label>Contact</label>
				<input name="contact" required type="text" value="<?php echo $user_data[0]['contact'];?>">
				<input value="Save" type="submit">
				</form>              
		  </div>
		</div>
	  </div>
	</div>
	<div id="permissionModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
	  <div class="modal-dialog" style="width:400px;">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Give Survey Permissions</h4>
		  </div>
		  <div class="modal-body">
				<form name="permission-form" id="permission-form" method="post" action="">
				<label>Username</label>
				<input name="username" class="permission_check typeahead2" required type="text" value="" autocomplete="off">
				<label>Survey</label>
				<input name="survey" class="permission_check typeahead3" required type="text" value="" autocomplete="off">
				<input name="survey_id" required type="hidden" value="" />
				<label>Design Permission <input name="design_permission" type="checkbox" value="1" /></label>
				<label>Fill Permission <input name="fill_permission" type="checkbox" value="1" /></label>
				<label>Analytics Permission <input name="analytics_permission" type="checkbox" value="1" /></label>
				<input value="Save" type="button" onClick="savePermission(this)">
				<input value="Edit Permissions" type="button" onClick="editPermissions()">
				</form>              
		  </div>
		</div>
	  </div>
	</div>
	<div id="permissionsModal" class="modal fade" role="dialog">
	  <div class="modal-dialog" style="width:400px;">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Edit Survey Permissions</h4>
		  </div>
		  <div class="modal-body">
			<?php //print_r($surveys_list);?>
			<table border="1">
				<?php 
				foreach($surveys_list as $sl){
					if($sl['permission_design']!='' or $sl['permission_fill']!='' or sizeof(json_decode($sl['permission_design']))>0 or sizeof(json_decode($sl['permission_fill']))>0	){
				?>
						<tr>
							<td align="center" colspan="3"><strong><?php echo $sl['title']; ?></strong></td>
						</tr>
						<tr>
							<th><strong>Username</strong></th>
							<th><strong>Design</strong></th>
							<th><strong>Fill</strong></th>
						</tr>
						<?php 
						$pd=(array) json_decode($sl['permission_design']);
						$pf=(array) json_decode($sl['permission_fill']);
						if(sizeof($pd)>sizeof($pf)){
							$perm_count=sizeof($pd);
						}
						else if(sizeof($pf)>sizeof($pd)){
							$perm_count=sizeof($pf);
						}else{
							$perm_count=sizeof($pd);
						}
						$p_d_f=array_merge($pd,$pf);
						$p_d_f=array_unique($p_d_f);
						//print_r($p_d_f);
						if(sizeof($p_d_f)>0){
							foreach($p_d_f as $pdf){
						?>
							<tr>
								<td><?php echo $pdf;?></td>
								<td><?php if(in_array($pdf,$pd)){?><i class="fa fa-check" aria-hidden="true"></i> <a onClick="removePermission(this,'<?php echo $sl['title_url']; ?>','permission_design','<?php echo $pdf;?>')" href="javascript:void(0)">Remove</a><?php } ?></td>
								<td><?php if(in_array($pdf,$pf)){?><i class="fa fa-check" aria-hidden="true"></i> <a onClick="removePermission(this,'<?php echo $sl['title_url']; ?>','permission_fill','<?php echo $pdf;?>')" href="javascript:void(0)">Remove</a><?php } ?></td>
							</tr>
				<?php }}}} ?>
			</table>
				<input value="Save" type="button" onClick="closePermission()">
		  </div>
		</div>
	  </div>
	</div>  
	<div id="newDashboardModal" class="modal fade" role="dialog">
	  <div class="modal-dialog" style="width:300px;">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<!--<h4 class="modal-title">Dashboard Details</h4>-->
		  </div>
		  <div class="modal-body">
			<form name="dashboard-form" id="dashboard-form" method="post" action="<?php echo base_url();?>dashboard/save/" onSubmit="mesg('Your Dashboard has been created')">
				<input name="username" type="hidden" value="<?php echo $user_data[0]['username'];?>">
				<label>Dashboard Name</label>
				<input name="dashboard_name" required type="text" value="">
				<input value="Save" type="submit">
			</form>              
		  </div>
		</div>
	  </div>
	</div>	
	<div id="createSurveyModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
	  <div class="modal-dialog" style="width:300px;">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Create Survey</h4>
		  </div>
		  <div class="modal-body">
			<form method="post" action="<?php echo base_url();?>survey/save">
				<label>Name Your Survey</label>
				<input name="title" type="text">
				<label>Sample</label>
				<input name="survey_sample" type="text">
				<label>Start Date</label>
				<input class="datepicker" name="start_date" type="text">
				<label>End Date</label>
				<input class="datepicker" name="end_date" type="text">
				<input value="Create" type="submit">
			</form>       
		  </div>
		</div>
	  </div>
	</div>	
	<div id="selectSurveyCaseToCompleteModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
	  <div class="modal-dialog" style="width:500px;">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title"><strong>Select Survey Case To Complete</strong></h4>
		  </div>
		  <div class="modal-body">
		  </div>
		</div>
	  </div>
	</div>		      
	<div id="shareSurveyModal" class="modal fade" role="dialog">
	  <div class="modal-dialog" style="width:500px;">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Share Your Survey</h4>
		  </div>
		  <div class="modal-body">
				<input name="survey_title_url" type="hidden" value="" />
				<div class="row">
					<div class="col-lg-6">
						<div class="card m-b-30">
							<a href="javascript:void(0)" onClick="shareSurveyViaWeblink()">
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
					<div class="col-lg-6">
						<div class="card m-b-30">
							<a href="javascript:void(0)" onClick="shareSurveyViaEmail()">
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
		  </div>
		</div>
	  </div>
	</div>
	<div id="shareSurveyWeblinkModal" class="modal fade" role="dialog">
	  <div class="modal-dialog" style="width:700px;max-width:700px;">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Web Link</h4>
		  </div>
		  <div class="modal-body">
			<form name="share-survey-form" id="share-survey-form" method="post">
				<label>Survey Url</label>
				<input name="survey_title_url" required type="text" value="" readonly>
				<input type="button" class="close" data-dismiss="modal" value="Close">
			</form>              
		  </div>
		</div>
	  </div>
	</div>	
	<div id="shareSurveyEmailModal" class="modal fade" role="dialog">
	  <div class="modal-dialog" style="width:700px;max-width:700px;">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Email</h4>
		  </div>
		  <div class="modal-body">
			<form name="share-survey-form" id="share-survey-form" method="post" action="<?php echo base_url();?>survey/email/">
				<input name="survey_title_url" type="hidden" value="" />
				<label>To (a@gmail.com,b@gmail.com)</label>
				<input name="email_to" required type="text" value="">
				<label>Subject</label>
				<input name="email_subject" required type="text" value="Thesurveypoint.com Survey Sharing" readonly>
				<label>Message</label>
				<textarea name="email_message" required readonly>
				</textarea>
				<input value="Save" type="submit">
			</form>              
		  </div>
		</div>
	  </div>
	</div>	
	<div id="themeModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
	  <div class="modal-dialog" style="width:605px;">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Change Your Theme</h4>
		  </div>
		  <div class="modal-body">
			<form name="theme-form" id="theme-form" method="post" action="<?php echo base_url();?>login/theme/save">
				<input name="username" required type="hidden" value="<?php echo $user_data[0]['username'];?>">
				<div class="row theme-box-big">
						<label class="theme-box-cover">
							<div class="theme-box-small">
								<div class="theme-box-small-inner">
									<img src="<?php echo base_url()."userthemes/no-image.png"; ?>" alt="No Theme" />
									<input <?php if($user_data[0]['theme']==""){echo "checked";}?> type="radio" name="theme" value="" /> Default
								</div>
							</div>
						</label>				
						<label class="theme-box-cover">
							<div class="theme-box-small">
								<div class="theme-box-small-inner">
									<img src="<?php echo base_url()."userthemes/ocean.jpg"; ?>" />
									<input <?php if($user_data[0]['theme']=="ocean"){echo "checked";}?> type="radio" name="theme" value="ocean" /> Ocean
								</div>
							</div>
						</label>
						<label class="theme-box-cover">
							<div class="theme-box-small">
								<div class="theme-box-small-inner">
									<img src="<?php echo base_url()."userthemes/nature.jpg"; ?>" />
									<input <?php if($user_data[0]['theme']=="nature"){echo "checked";}?> type="radio" name="theme" value="nature" /> Nature
								</div>
							</div>
						</label>						
						<label class="theme-box-cover">
							<div class="theme-box-small">
								<div class="theme-box-small-inner">
									<img src="<?php echo base_url()."userthemes/grass.jpg"; ?>" />
									<input <?php if($user_data[0]['theme']=="grass"){echo "checked";}?> type="radio" name="theme" value="grass" /> Grass
								</div>
							</div>
						</label>						
						<label class="theme-box-cover">
							<div class="theme-box-small">
								<div class="theme-box-small-inner">
									<img src="<?php echo base_url()."userthemes/autumn.jpg"; ?>" />
									<input <?php if($user_data[0]['theme']=="autumn"){echo "checked";}?> type="radio" name="theme" value="autumn" /> Autumn
								</div>
							</div>
						</label>						
						<label class="theme-box-cover">
							<div class="theme-box-small">
								<div class="theme-box-small-inner">
									<img src="<?php echo base_url()."userthemes/desert.jpg"; ?>" />
									<input <?php if($user_data[0]['theme']=="desert"){echo "checked";}?> type="radio" name="theme" value="desert" /> Desert
								</div>
							</div>
						</label>						
				</div>
				<input value="Save" type="submit">
			</form>                  
		  </div>
		</div>
	  </div>
	</div>		
</modals>
<?php } ?>       
       
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
		<script type="text/javascript">
		<?php if(sizeof($surveys)>0){ ?>
			$('#dashboard_mysurvey').show();
			$('#dashboard_createsurvey').hide();
		<?php }else{?>
			$('#dashboard_mysurvey').hide();
			$('#dashboard_createsurvey').show();
		<?php } ?>
		$('#dashboard_manage').hide();
		</script>	        
		<script type="text/javascript">
		function changeTheme(){
			$('#themeModal').modal('show');
		}			
		function editProfile(){
			$('#profileModal').modal('show');
		}
		function editPermission(){
			$('#permissionModal').modal('show');
		}	
		function savePermission(savePermissionButton){
			var formData=$(savePermissionButton).closest('form').serializeArray();
			$.ajax({
				url: '<?php echo base_url();?>survey/permission/save', // url where to submit the request
				type : "POST", // type of action POST || GET
				data : formData, // post data || get data
				success : function(result) {
					alert('Permission Saved Sucessfully!');
					$('#permissionModal').modal('hide');
					setTimeout(function(){
						window.location.reload();
					}, 1000);
				},error: function(xhr, resp, text) {console.log(xhr, resp, text);}
			});	
		}	
		function editPermissions(){
			$('#permissionModal').modal('hide');
			$('#permissionsModal').modal('show');	

		}	
		function removePermission(permission_remove_link,survey_id,value,username){
			//console.log(survey_id+" "+value+" "+username);
			callAjaxGet('<?php echo base_url()."survey/permission/update/";?>'+survey_id+"/"+value+"/"+username,'');
			$(permission_remove_link).parent().html('');
		}	
		function callAjaxGet(ajaxUrl,modalId){
			$.ajax({
				url: ajaxUrl, // url where to submit the request
				type : "GET", // type of action POST || GET
				success : function(result) {
					if(modalId!=''){
						$('#'+modalId+" .modal-body").html(result);
						//console.log(result);
					}
				},
				error: function(xhr, resp, text) {
					console.log(xhr, resp, text);
				}
			})		
		}		
		function closePermission(){
			$('#permissionsModal').modal('hide');	
			setTimeout(function(){
				window.location.reload();
			}, 1000);
		}	
		function callAjaxGet(ajaxUrl,modalId){
			$.ajax({
				url: ajaxUrl, // url where to submit the request
				type : "GET", // type of action POST || GET
				success : function(result) {
					if(modalId!=''){
						$('#'+modalId+" .modal-body").html(result);
						//console.log(result);
					}
				},
				error: function(xhr, resp, text) {
					console.log(xhr, resp, text);
				}
			})		
		}	
		function callAjaxPost(ajaxUrl,formData,modalId){
			$.ajax({
				url: ajaxUrl, // url where to submit the request
				type : "POST", // type of action POST || GET
				data : {formData},
				success : function(result) {
					if(modalId!=''){
						$('#'+modalId+" .modal-body").html(result);
						//console.log(result);
					}
				},
				error: function(xhr, resp, text) {
					console.log(xhr, resp, text);
				}
			})		
		}	
		function setSurveyCase(survey_case_id,survey_case){
			localStorage.setItem("survey_case_id", survey_case_id);
			localStorage.setItem("case", survey_case);
			setTimeout(function(){
				window.location.reload();
			}, 1000);
		}
		function setSurveyCase2(survey_case_id,survey_case){
			fill_vals_save();
			var survey_copy=$('#survey_copy');
			localStorage.setItem("survey_case_id", survey_case_id);
			localStorage.setItem("case", survey_case);
			if(survey_copy.length>0){
				if(survey_case=="New"){
					$('#survey_carbon').html($('#survey_copy').html());
					$('#selectSurveyCaseToCompleteModal').modal('hide');
					ready1();
					ready2();
					ready3();
					ready5();
					ready4();
				}else if(survey_case=="Old"){
					$('#survey_carbon').html($('#survey_copy').html());
					$('#selectSurveyCaseToCompleteModal').modal('hide');
					ready1();
					ready2();
					ready3();
					ready5();
					ready4();
				}else{}		
			}else{
				setTimeout(function(){
					window.location.reload();
				}, 1);		
			}
			//console.log($('#survey_copy').html());
		}
		function fill_vals_save(){
			var fill_vals=localStorage.getItem("fill_vals");
			if(fill_vals!=''){
				$.ajax({
					url: '<?php echo base_url()."survey/fill_vals_save";?>', // url where to submit the request
					type : "POST", // type of action POST || GET
					data : {formData:fill_vals},
					success : function(result) {
						//console.log(result);
					},
					error: function(xhr, resp, text) {
						console.log(xhr, resp, text);
					}
				})		
				localStorage.removeItem("fill_vals");
				localStorage.setItem("fill_vals",'');	
				console.log("fill_vals_save removed cookie");
			}
		}			
		function chooseSurvey(survey_title_url){
			document.cookie = "fill_survey="+survey_title_url+"; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
			document.cookie = "analytics_survey="+survey_title_url+"; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
			document.cookie = "design_survey="+survey_title_url+";path=/;";
			//$('#selectSurveyModal').modal('hide');
			setTimeout(function(){
				window.location='<?php echo base_url(); ?>';
			}, 1000);
		}	
		function chooseSurveyAndFill(survey_title_url){
			document.cookie = "design_survey="+survey_title_url+"; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
			document.cookie = "analytics_survey="+survey_title_url+"; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
			document.cookie = "fill_survey="+survey_title_url+";path=/;";
			//$('#fillSurveyModal').modal('hide');
			$('#selectSurveyCaseToCompleteModal').modal('show');
			callAjaxGet('<?php echo base_url()."survey/cases/";?>'+survey_title_url,'selectSurveyCaseToCompleteModal');
		}
		function chooseSurveyAndAnalytics(survey_title_url){
			document.cookie = "design_survey="+survey_title_url+"; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
			document.cookie = "fill_survey="+survey_title_url+"; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
			document.cookie = "analytics_survey="+survey_title_url+";path=/;";
			//$('#analyticsSurveyModal').modal('hide');
			setTimeout(function(){
				window.location='<?php echo base_url(); ?>';
			}, 1000);
		}
		function primaryDashboard(survey_title_url=''){
			document.cookie = "design_survey="+survey_title_url+";path=/;";
			document.cookie = "fill_survey="+survey_title_url+";path=/;";
			document.cookie = "analytics_survey="+survey_title_url+";path=/;";
			setTimeout(function(){
				window.location='<?php echo base_url(); ?>';
			}, 1000);
		}
		function shareSurvey(survey_title_url=''){
			$('#shareSurveyModal').modal('show');
			$('#shareSurveyModal .modal-body [name="survey_title_url"]').val(survey_title_url);
		}
		function shareSurveyViaWeblink(){
			var survey_title_url=$('#shareSurveyModal [name="survey_title_url"]').val();
			$('#shareSurveyModal').modal('hide');
			$('#shareSurveyWeblinkModal').modal('show');
			$('#shareSurveyWeblinkModal .modal-body form [name="survey_title_url"]').val("<?php echo base_url() ?>survey/fill/entry/"+survey_title_url);
		}
		function shareSurveyViaEmail(){
			var survey_title_url=$('#shareSurveyModal [name="survey_title_url"]').val();
			$('#shareSurveyModal').modal('hide');
			$('#shareSurveyEmailModal').modal('show');
			$('#shareSurveyEmailModal .modal-body form [name="survey_title_url"]').val("<?php echo base_url() ?>survey/fill/entry/"+survey_title_url);
			var mtext="Hi, This is <?php echo $this->session->userdata('user_logged_username'); ?>.\r\nI want to share survey via the link below:\r\n[<?php echo base_url()."survey/fill/entry/"; ?>"+survey_title_url+"]";
			console.log(mtext);
			$('#shareSurveyEmailModal [name="email_message"]').val(mtext);
			
		}
		function mesg(a){
			alert(a);
		}
		</script>
		
		<script src="<?php echo base_url(); ?>theme/js/bootstrap3-typeahead.min.js"></script>  
		<script src="<?php echo base_url(); ?>theme/js/jquery-ui.min.js"></script>
		<script type="text/javascript">	
		$(document).ready(function(){
			<?php if($this->session->userdata('user_logged_id')){ ?>
				$(".typeahead2").typeahead({
					source: function(query, process) {
						return $.get('<?php echo ONLINE_URL."login/users/search/".$user_data[0]['username'];?>', { query: query }, function (data) {
							data=JSON.parse(data);
							//console.log(data);
							objects = [];
							map = {};
							//var data = [{"label":"System Administrator","value":"1"},{"label":"Software Tester","value":"3"},{"label":" Software Developer","value":"4"},{"label":"Senior Developer","value":"5"},{"label":"Cloud Developer","value":"6"},{"label":"Wordpress Designer","value":"7"}] // Or get your JSON dynamically and load it into this variable
							//console.log(data);
							$.each(data, function(i, object) {
								map[object.value] = object;
								objects.push(object.value);
							});
							return process(objects);
							//console.log(data);
							//return process(data);
						});			
					},
				   items : 10,
				   minLength : 0,
				   updater: function(item){
					   //console.log(item);
					   selectedKey = map[item].data;
					   //console.log(selectedKey);
					   $('input[name="username"]').val(selectedKey);
					   return item;
				   }		
				});	
				$(".typeahead3").typeahead({
					source: function(query, process) {
						return $.get('<?php echo base_url()."survey/search/".$user_data[0]['username'];?>', { query: query }, function (data) {
							data=JSON.parse(data);
							//console.log(data);
							objects = [];
							map = {};
							//var data = [{"label":"System Administrator","value":"1"},{"label":"Software Tester","value":"3"},{"label":" Software Developer","value":"4"},{"label":"Senior Developer","value":"5"},{"label":"Cloud Developer","value":"6"},{"label":"Wordpress Designer","value":"7"}] // Or get your JSON dynamically and load it into this variable
							//console.log(data);
							$.each(data, function(i, object) {
								map[object.value] = object;
								objects.push(object.value);
							});
							return process(objects);
							//console.log(data);
							//return process(data);
						});			
					},
				   items : 10,
				   minLength : 0,
				   updater: function(item){
					   //console.log(item);
					   selectedKey = map[item].data;
					   //console.log(selectedKey);
					   $('input[name="survey_id"]').val(selectedKey);
					   return item;
				   }		
				});	
			<?php } ?>
			var start_tab_index=1;
			$(':input').each(function(){
				start_tab_index++;
				//console.log($(this));
				//$(this).attr('autocomplete','off');
				$(this).attr('tabindex',start_tab_index);
			});

		<?php if($this->session->userdata('user_logged_id')){ ?>	
			<?php if($TRIAL_EXPIRED && $user_data[0]['license_key_date']==0){?>
				$('#TrialModal').modal({backdrop: 'static', keyboard: false}, 'show');		
			<?php } ?>	
		<?php } ?>	
			 
			$('#permissionModal').on("blur", ".permission_check",function(){
		var p1=$('#permissionModal').find('input[name="username"]').val();
		var p2=$('#permissionModal').find('input[name="survey_id"]').val();
		if(p1!='' && p2!=''){
			$.ajax({
				url: '<?php echo base_url();?>survey/permission/check/'+p1+'/'+p2, // url where to submit the request
				type : "GET", // type of action POST || GET
				//data : $("#form_data_code").serialize(), // post data || get data
				success : function(result) {
					if(result!=''){
						result=JSON.parse(result);
						if(result.permission_design=='1'){
							$('#permissionModal').find('input[name="design_permission"]').prop('checked',true);
						}else{
							$('#permissionModal').find('input[name="design_permission"]').prop('checked',false);
						}
						if(result.permission_fill=='1'){
							$('#permissionModal').find('input[name="fill_permission"]').prop('checked',true);
						}else{
							$('#permissionModal').find('input[name="fill_permission"]').prop('checked',false);
						}
						if(result.permission_analytics=='1'){
							$('#permissionModal').find('input[name="analytics_permission"]').prop('checked',true);
						}else{
							$('#permissionModal').find('input[name="analytics_permission"]').prop('checked',false);
						}
						console.log(result);
					}
				},
				error: function(xhr, resp, text) {
					console.log(xhr, resp, text);
				}
			});
		}
	});	
			
			$('.modal').on('shown.bs.modal', function () {
				setTimeout(function(){
					$('body').addClass('modal-open');
					$('body').css('padding-right','0');
					$('html').css('overflow-x','unset');		//for removing double scrollbar in modals
				}, 1000);   		
			});
		});
		$(function () {
			$('.datepicker').datepicker();
		});
		$(document).ready(function(){
			var count=0;
			var dashboard_id,survey_id;
			var classArray=[];
			var indexNumber;
			$(".draggable").draggable({
				revert: true
			});
			$(".dashboard-list").droppable({
				activeClass: "active",
				drop: function (event, ui) {
					var content=ui.draggable.text();
					dashboard_id=$(this).data('dashboard');
					survey_id=ui.draggable.data('survey');
					//alert(dashboard_id+" "+survey_id);
					var arrayLength=classArray.length;
					var classNumber=0;
					count=count+1;
					if(arrayLength==0){
						classNumber=classNumber+1;
						classArray.push(classNumber);
					}else{
						for(var i=1;i<=count;i++){
							for(var j=0;j<arrayLength;j++){
								if(classArray[j]==i){
									classNumber=0;
									break;
								}else{
									classNumber=i;
								}
							}
							if(classNumber!=0){
								classArray.push(classNumber);
								break;
							}
						}
					}
					$(this).append('<p data-survey="'+survey_id+'" class="active-'+classNumber+'">'+content+' <i class="fa fa-times"></i></p>');
					ui.draggable.addClass('active-'+classNumber).hide();
					
					callAjaxGet('<?php echo base_url()."dashboard/update/1/";?>'+dashboard_id+'/'+survey_id,'');
				}
			});
			$(document).on('click','.fa-times',function(){
				dashboard_id=$(this).parent('p').parent('div').data('dashboard');
				survey_id=$(this).parent('p').data('survey');
				$('#survey-list').find('[data-survey="'+survey_id+'"]').show();
				//alert(dashboard_id+' = '+survey_id);
				$(this).parent('p').remove();
				callAjaxGet('<?php echo base_url()."dashboard/update/0/";?>'+dashboard_id+'/'+survey_id,'');
			});

		});			
		</script>	
    </body>
</html>