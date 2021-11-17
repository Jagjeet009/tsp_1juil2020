<!DOCTYPE html>
<html lang="en"><head>
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
	<!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">-->
	<link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<!--<link href="<?php echo base_url();?>assets/css/icons.css" rel="stylesheet" type="text/css">-->
	<link href="<?php echo base_url();?>assets/css/dashboard.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url();?>theme/css/font-awesome.min.css">
	<style>
		#sidebar-menu> ul {
			display: none;
		}
		
		#sidebar-menu> ul.active {
			display: block;
		}
		
		#sidebar-menu> ul> li> a {
			padding: 15px 10px 15px 25px;
		}
		
		#sidebar-menu ul li .badge-success {
			position: absolute;
			right: 5px;
			top: 12px;
		}
		
		#sidebar-menu ul ul a {
			padding: 12px 35px 12px 63px;
		}
		
		.card.m-b-30 {
			overflow: hidden;
		}
		
		.card-blockquote {
			margin: 0;
		}
		
		.tab-btn {
			position: absolute;
			bottom: -100px;
			left: 0;
			right: 0;
			text-align: right;
			padding: 10px;
			background: #000;
			transition: all 0.3s ease-out;
		}
		
		.tab-btn button {
			margin-left: 10px;
		}
		
		.tab-pane .card.m-b-30:hover .tab-btn {
			bottom: 0;
		}
		
		#sidebar-menu li,
		#sidebar-menu a {
			width: 100%;
		}
		
		.select-country option {
			display: none;
		}
		
		.select-country option.active,
		.select-country option.common {
			display: block;
		}
		
		.tab-content .col-lg-4.deactive {
			display: none;
		}
	</style>
	
<!-- theme css -->
<?php 
if($this->session->has_userdata('user_logged_username')){
	$user_data=$this->User_model->get_user_by_id($this->session->userdata('user_logged_id'));
	?>
<link href="<?php echo base_url(); ?>userthemes/<?php echo $user_data[0]['theme']; ?>.css" rel="stylesheet" type="text/css">
<?php } ?>
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
			<button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left"> <i class="ion-close"></i> </button>

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
			<?php $this->load->view('question_bank_sidebar');?>
			<!-- end sidebarinner -->
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
                                        <!--<a class="dropdown-item"  href="javascript:void(0)" onClick="editProfile()"><i class="fa "></i> Edit Profile</a>
                                        <a class="dropdown-item"  href="javascript:void(0)" onClick="editPermission()"><i class="fa "></i> Permissions</a>
                                        <a class="dropdown-item" href="#"><i class="fa fa-tag"></i> My Wallet</a>
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

						<!-- end page title end breadcrumb -->

						<div class="row small-cards">
							<div class="col-sm-12">
								<?php $this->load->view('question_bank_filter');?>
							</div>
						</div>
						<div class="card m-b-30">
							<div class="card-body">
								<!-- Nav tabs -->

								<!--<div class="tab-pane p-3 active show" id="public-health" role="tabpanel">
	<div class="row">
		<div class="col-lg-4">
			<div class="card m-b-30 text-white bg-dark">
				<div class="tab-btn">
					<a href="" class="btn btn-outline-danger waves-effect waves-light" download>Download</a>
					<a href="" class="btn btn-outline-info waves-effect waves-light" target="_blank">View</a>
				</div>
				<div class="card-body">
					<blockquote class="card-blockquote">
						<h6></h6>
						<footer>Source : <cite> </cite>
						</footer>
					</blockquote>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="card m-b-30 text-white bg-info">
				<div class="tab-btn">
					<a href="" class="btn btn-outline-danger waves-effect waves-light" download>Download</a>
					<a href="" class="btn btn-outline-info waves-effect waves-light" target="_blank">View</a>
				</div>
				<div class="card-body">
					<blockquote class="card-blockquote">
						<h6></h6>
						<footer>Source : <cite> </cite>
						</footer>
					</blockquote>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="card m-b-30 text-white bg-danger">
				<div class="tab-btn">
					<a href="" class="btn btn-outline-danger waves-effect waves-light" download>Download</a>
					<a href="" class="btn btn-outline-info waves-effect waves-light" target="_blank">View</a>
				</div>
				<div class="card-body">
					<blockquote class="card-blockquote">
						<h6></h6>
						<footer>Source : <cite> </cite>
						</footer>
					</blockquote>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="card m-b-30 text-white bg-success">
				<div class="tab-btn">
					<a href="" class="btn btn-outline-danger waves-effect waves-light" download>Download</a>
					<a href="" class="btn btn-outline-info waves-effect waves-light" target="_blank">View</a>
				</div>
				<div class="card-body">
					<blockquote class="card-blockquote">
						<h6></h6>
						<footer>Source : <cite> </cite>
						</footer>
					</blockquote>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="card m-b-30 text-white bg-warning">
				<div class="tab-btn">
					<a href="" class="btn btn-outline-danger waves-effect waves-light" download>Download</a>
					<a href="" class="btn btn-outline-info waves-effect waves-light" target="_blank">View</a>
				</div>
				<div class="card-body">
					<blockquote class="card-blockquote">
						<h6></h6>
						<footer>Source : <cite> </cite>
						</footer>
					</blockquote>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="card m-b-30 text-white bg-primary">
				<div class="tab-btn">
					<a href="" class="btn btn-outline-danger waves-effect waves-light" download>Download</a>
					<a href="" class="btn btn-outline-info waves-effect waves-light" target="_blank">View</a>
				</div>
				<div class="card-body">
					<blockquote class="card-blockquote">
						<h6></h6>
						<footer>Source : <cite> </cite>
						</footer>
					</blockquote>
				</div>
			</div>
		</div>
	</div>
</div>-->

								<!-- Tab panes -->
								<div class="tab-content">
									<div class="tab-pane p-3 active show" id="home" role="tabpanel">


										<!--<h4 class="mt-0 header-title">Example</h4>-->
										<?php $this->load->view('question_bank_content');?>
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

	<!-- jQuery  -->
	<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
	<script src="<?php echo base_url();?>theme/js/jquery-ui.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/popper.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/jquery.slimscroll.js"></script>
	<script src="<?php echo base_url();?>assets/js/waves.js"></script>
	<script src="<?php echo base_url();?>assets/js/dashboard.js"></script>
	<!-- App js -->
	<script src="<?php echo base_url();?>assets/js/app.js"></script>
	<script>
		function primaryDashboard(survey_title_url=''){
			document.cookie = "design_survey="+survey_title_url+";path=/;";
			document.cookie = "fill_survey="+survey_title_url+";path=/;";
			document.cookie = "analytics_survey="+survey_title_url+";path=/;";
			setTimeout(function(){
				window.location='<?php echo base_url(); ?>';
			},10);
		}

		var tabMenuChange;
		var targetBlock = '#' + $( '.content-block .tab-pane.active' ).attr( 'id' );
		$( '.thematic-list>li>a' ).not( '.menu-sub' ).click( function () {
			$( '.thematic-list *' ).removeClass( 'active' );
			$( this ).addClass( "active" );
			$( this ).parent().addClass( "active" );
		} );
		$( '.thematic-list li ul a' ).click( function () {
			$( '.thematic-list *' ).removeClass( 'active' );
			$( this ).addClass( "active" );
			$( this ).parent().addClass( "active" );
			$( this ).parent().parent().parent().addClass( "active" );
			$( this ).parent().parent().parent().children().addClass( "active" );
		} );
		$( '.thematic-list a' ).click( function () {
			targetBlock = $( this ).attr( 'href' );
			$( '.select-country' ).show();
			if ( targetBlock != 'javascript:void(0);' ) {
				$( '.thematic-content>*' ).removeClass( 'active' ).removeClass( 'show' );
				$( targetBlock ).addClass( 'active' ).addClass( 'show' );
			}
			var liId = $( this ).parent().attr( 'id' );
			if ( liId ) {
				$( '.tab-pane .col-lg-4' ).removeClass( 'deactive' );
				$( '.select-country' ).prop( 'selectedIndex', 0 );
				$( '.select-country option' ).removeClass( 'active' );
				$( '.select-country option.' + liId ).addClass( 'active' );
			}
		} );
		$( '.select-country' ).change( function () {
			$( targetBlock + ' .col-lg-4' ).addClass( 'deactive' );
			var countryCode = $( '.select-country option:selected' ).attr( 'id' );
			$( '.' + countryCode ).removeClass( 'deactive' );
		} );
		$( '.thematic-list .no-contry' ).click( function () {
			$( '.select-country' ).hide();
		} );
		$( '.tab_option a' ).click( function () {
			tabMenuChange = $( this ).attr( 'id' );
			$( '#sidebar-menu>ul' ).removeClass( 'active' );
			$( '.' + tabMenuChange ).addClass( 'active' );
		} );
		$( '.thematic-list a.active' ).trigger('click');
	</script>
</body>

</html>