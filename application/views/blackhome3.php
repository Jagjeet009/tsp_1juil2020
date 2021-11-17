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
<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/css/dashboard.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo base_url();?>theme/css/font-awesome.min.css">
<!--<link rel="stylesheet" href="<?php echo base_url();?>theme/css/font-awesome.min-5.3.1.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">-->
<script src="<?php echo base_url();?>theme/js/jquery.min.js"></script>

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
               
				<?php $this->load->view('dashboard_sidebar'); ?>
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
                                    <a class="nav-link dropdown-toggle arrow-none nav-user" data-toggle="dropdown" href="javascript:void(0)" role="button"
                                        aria-haspopup="false" aria-expanded="false">
                                        <i class="fa fa-user rounded-circle" style="color:transparent"></i>
                                    </a>
                                </li>
                            </ul>

                            <ul class="list-inline menu-left mb-0">
                                <li class="float-left">
                                    <button class="button-menu-mobile open-left waves-light waves-effect">
                                        <i class="fa fa-columns"></i>
                                    </button>
                                </li>
                                <li class="hide-phone dashboard-title">
									<h3><?php echo $username."-".$dashboard_name; ?></h3>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </nav>
                    </div>
                    <!-- Top Bar End -->
                   <?php
					if($panel=="mydata"){
						$this->load->view('dashboard_mydata');
					}else if($panel=="mytable"){
						$this->load->view('dashboard_mytable');
					}else if($panel=="mychart"){
						$this->load->view('dashboard_mychart');
					}else if($panel=="sharedashboard"){
						$this->load->view('dashboard_sharedashboard');
					}else if($panel=="sharesurvey"){
						$this->load->view('dashboard_sharesurvey');
						
					}else if($panel=="records"){
						$this->load->view('dashboard_records');
					}else if($panel=="trackmychart"){
						$this->load->view('dashboard_trackmychart');
					}else if($panel=="trackmytable"){
						$this->load->view('dashboard_trackmytable');
						
					}else{
						$this->load->view('dashboard_mydata');
					}
					?>


                </div> <!-- content -->

			<?php $this->load->view('dashboard_footer'); ?>

            </div>
            <!-- End Right content here -->

        </div>
        <!-- END wrapper -->
       

    </body>
</html>