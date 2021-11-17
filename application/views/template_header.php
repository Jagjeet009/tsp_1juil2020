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
.dashboard-title * {
    display: inline-block;
	color:#fff;
}		
	.dashboard-title a{margin-right:10px;}		
	</style>
	
<!-- theme css -->
<?php 
if($this->session->has_userdata('user_logged_username')){
	$user_data=$this->User_model->get_user_by_id($this->session->userdata('user_logged_id'));
	?>
<link href="<?php echo base_url(); ?>userthemes/<?php echo $user_data[0]['theme']; ?>.css" rel="stylesheet" type="text/css">
<?php } ?>
<!-- theme css -->
	
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
			
<?php $this->load->view('template_sidebar');?>
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
                                        <a class="dropdown-item" href="<?php echo base_url(); ?>login/logout"><i class="fa "></i> Logout</a>
                                    </div>
                                </li>
                            </ul>

							<ul class="list-inline menu-left mb-0">
								<li class="float-left">
									<button class="button-menu-mobile open-left waves-light waves-effect">
										<i class="fa fa-columns"></i>
									</button>
								</li>
								<li class="hide-phone dashboard-title">
									<!--<a class="waves-effect waves-light" href="<?php echo base_url(); ?>" aria-expanded="false">
										<i class="fa fa-arrow-circle-left fa-2x"></i>
									</a>-->
									<?php 
									if($this->session->userdata('user_logged_id')){ 
									$user_data=$this->User_model->get_user_by_id($this->session->userdata('user_logged_id'));
									?>
									<h3><?php echo $user_data[0]['username']; ?></h3>
									<?php } ?>
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
			<div class="page-title-box">
				<div class="float-right">
					<div class="dropdown">
						<select name="template_country" class="form-control template_country">
							<option disabled selected>Select Country</option>
							<?php
							$countryArr=unserialize(COUNTRY);
							foreach($countryArr as $c_k=>$c_v){
								$c_v_key=strtolower($c_v);
								$c_v_key=str_replace(' ','-',$c_v_key);								
							?>
							<option <?php if($c_v_key==$country){echo 'selected';}?> value="<?php echo base_url()."template/".$sector."/".$c_v_key; ?>"><?php echo $c_v; ?></option>
							<?php } ?>
							<!--<option id="country-1" class="thematic-4-5 thematic-7 thematic-9 thematic-16">AFGHANISTAN</option>
							<option id="country-2" class="thematic-4-1 thematic-10">AFRICA</option>
							<option id="country-180" class="thematic-16">ALBANIA</option>
							<option id="country-3" class="thematic-1 active thematic-8 thematic-15">AMERICA</option>
							<option id="country-179" class="thematic-16">ARGENTINA</option>
							<option id="country-4" class="thematic-7">ARMENIA</option>
							<option id="country-5" class="thematic-4-2 thematic-4-5 thematic-10 thematic-15">ASIA</option>
							<option id="country-6" class="thematic-10">ASIA-PACIFIC</option>
							<option id="country-7" class="thematic-1 active ">ATLANTA</option>
							<option id="country-8" class="thematic-1 active thematic-4-2 thematic-4-3 thematic-4-5 thematic-5 thematic-6 thematic-8 thematic-10 thematic-15">AUSTRALIA </option>
							<option id="country-181" class="thematic-16">AUSTRIA</option>
							<option id="country-9" class="thematic-6">AUSTRALIA AND NEW ZEALAND</option>
							<option id="country-10" class="thematic-4-2 thematic-5 thematic-6 thematic-9 thematic-10 thematic-16">BANGLADESH</option>
							<option id="country-178" class="thematic-16">BELARUS</option>
							<option id="country-11" class="thematic-9">BELIZE</option>
							<option id="country-12" class="">BERLAND </option>
							<option id="country-13" class="thematic-9 thematic-15">BHUTAN</option>
							<option id="country-140" class="thematic-15">BIRZEIT</option>
							<option id="country-177" class="thematic-16">BRAZIL</option>
							<option id="country-14" class="thematic-9">BULGARIA</option>
							<option id="country-15" class="">BURUNDI</option>
							<option id="country-16" class="thematic-1 active thematic-3 thematic-4-1 thematic-4-3 thematic-8">CALIFORNIA</option>
							<option id="country-17" class="thematic-4-2 thematic-7 thematic-10 thematic-16">CAMBODIA</option>
							<option id="country-18" class="thematic-10">CAMEROON, NIGERIA and KENYA</option>
							<option id="country-19" class="thematic-4-1 thematic-4-3 thematic-4-4 thematic-4-5 thematic-5 thematic-6 thematic-8 thematic-10 thematic-16">CANADA</option>
							<option id="country-20" class="thematic-5">CARIBBEAN STATES</option>
							<option id="country-21" class="thematic-10">CAROLINA</option>
							<option id="country-22" class="thematic-8">CHICAGO</option>
							<option id="country-176" class="thematic-16">CHILE</option>
							<option id="country-23" class="thematic-3 thematic-4-3 thematic-6 thematic-7 thematic-10 thematic-16">CHINA</option>
							<option id="country-24" class="thematic-10">CHINA-CANADA</option>
							<option id="country-25" class="thematic-1 active ">CITY OF WODONGA</option>
							<option id="country-26" class="thematic-10">COLORADO</option>
							<option id="country-27" class="thematic-6">CONGO</option>
							<option id="country-28" class="thematic-10">COPENHEGAN</option>
							<option id="country-29" class="thematic-10">COURTENAY</option>
							<option id="country-30" class="thematic-6 thematic-16">CROATIA</option>
							<option id="country-31" class="thematic-5">CYPRUS</option>
							<option id="country-175" class="thematic-16">CZECH REPUBLIC</option>
							<option id="country-32" class="thematic-4-2">DENMARK </option>
							<option id="country-137" class="thematic-4-3">DOMINICA</option>
							<option id="country-33" class="">DUBLIN</option>
							<option id="country-34" class="thematic-2 thematic-10 thematic-16">EGYPT</option>
							<option id="country-35" class="thematic-1 active thematic-10">ENGLAND</option>
							<option id="country-174" class="thematic-16">ESTONIA</option>
							<option id="country-36" class="thematic-2 thematic-4-2 thematic-7">ETHIOPIA</option>
							<option id="country-37" class="thematic-1 active thematic-3 thematic-4-1 thematic-4-2 thematic-4-3 thematic-4-4 thematic-4-5 thematic-5 thematic-6 thematic-7 thematic-8 thematic-9 thematic-10 thematic-15">EUROPE</option>
							<option id="country-38" class="">EUROPEAN COMMISSION</option>
							<option id="country-39" class="thematic-5">FINLAND</option>
							<option id="country-40" class="thematic-1 active thematic-3 thematic-4-3 thematic-8 thematic-10">FLORIDA</option>
							<option id="country-41" class="thematic-6">FNCA COUNTRIES</option>
							<option id="country-173" class="thematic-16">FRANCE</option>
							<option id="country-42" class="thematic-4-5">GENVA</option>
							<option id="country-43" class="thematic-3 thematic-4-1 thematic-16">GEORGIA</option>
							<option id="country-44" class="thematic-4-2 thematic-4-4 thematic-5 thematic-16">GHANA</option>
							<option id="country-172" class="thematic-16">GIBRATAR</option>
							<option id="country-45" class="thematic-1 active thematic-2 thematic-3 thematic-4-1 thematic-4-3 thematic-4-4 thematic-5 thematic-6 thematic-8 thematic-9 thematic-10 thematic-15">GLOBAL</option>
							<option id="country-46" class="">GREAT EASTON</option>
							<option id="country-47" class="thematic-4-3 thematic-5 thematic-7">GREECE</option>
							<option id="country-48" class="thematic-9">HINDU KUSH HIMALAYAS</option>
							<option id="country-49" class="thematic-4-3 thematic-5 thematic-6">HONG KONG</option>
							<option id="country-171" class="thematic-16">HUNGARY</option>
							<option id="country-50" class="common">INDIA</option>
							<option id="country-51" class="thematic-6 thematic-7 thematic-9 thematic-16">INDONESIA</option>
							<option id="country-170" class="thematic-16">IRAN</option>
							<option id="country-169" class="thematic-16">IRAQ</option>
							<option id="country-52" class="thematic-4-3 thematic-5 thematic-6 thematic-7 thematic-15 thematic-16">IRELAND</option>
							<option id="country-168" class="thematic-16">ISRAEL</option>
							<option id="country-53" class="thematic-6 thematic-16">ITALY</option>
							<option id="country-167" class="thematic-16">JAMAICA</option>
							<option id="country-54" class="thematic-1 active thematic-7 thematic-10 thematic-16">JAPAN</option>
							<option id="country-166" class="thematic-16">JORDON</option>
							<option id="country-141" class="thematic-15">KAZAKHSTAN</option>
							<option id="country-55" class="thematic-6 thematic-7 thematic-10 thematic-16">KENYA</option>
							<option id="country-165" class="thematic-16">KUWAIT</option>
							<option id="country-56" class="">KYRGYZ REPUBLIC</option>
							<option id="country-57" class="thematic-9">KYRGYZSTAN</option>
							<option id="country-164" class="thematic-16">LATVIA</option>
							<option id="country-58" class="thematic-9 thematic-16">LESOTHO</option>
							<option id="country-163" class="thematic-16">LIBERIA</option>
							<option id="country-59" class="thematic-7 thematic-16">LITHUANIA </option>
							<option id="country-60" class="thematic-10">LONDON</option>
							<option id="country-61" class="thematic-5">MACEDONIA</option>
							<option id="country-62" class="thematic-8 thematic-16">MALAYSIA</option>
							<option id="country-162" class="thematic-16">MALDIVES</option>
							<option id="country-63" class="thematic-7 thematic-16">MALTA</option>
							<option id="country-64" class="thematic-3">MARYLAND(US)</option>
							<option id="country-161" class="thematic-16">MAURITIUS</option>
							<option id="country-65" class="thematic-3">MICHIGAN</option>
							<option id="country-66" class="thematic-4-5">MINNESOTA</option>
							<option id="country-67" class="thematic-6">MONTENEGRO</option>
							<option id="country-68" class="thematic-9">MOZAMBIQUE</option>
							<option id="country-69" class="thematic-4-3 thematic-6 thematic-16">MYANMAR</option>
							<option id="country-70" class="thematic-4-2 thematic-7 thematic-16">NEPAL</option>
							<option id="country-135" class="thematic-4-1">NEW HEMPSHIRE</option>
							<option id="country-71" class="thematic-1 active thematic-4-3 thematic-8">NEW YORK</option>
							<option id="country-72" class="thematic-1 active thematic-3 thematic-4-1 thematic-4-3 thematic-4-5 thematic-6 thematic-7 thematic-15 thematic-16">NEW ZEALAND</option>
							<option id="country-73" class="thematic-6 thematic-7">NIGER</option>
							<option id="country-74" class="thematic-6 thematic-16">NIGERIA</option>
							<option id="country-142" class="thematic-15">NORTH AMERICA</option>
							<option id="country-75" class="thematic-1 thematic-4-1 active ">NORTH CAROLINA</option>
							<option id="country-76" class="">NORTH DAKOTA</option>
							<option id="country-160" class="thematic-16">NORTH KOREA</option>
							<option id="country-77" class="">NORTH NIGERIA </option>
							<option id="country-78" class="thematic-8">NORTHERN IRELAND</option>
							<option id="country-79" class="thematic-4-5">NORTHERN MARIANA </option>
							<option id="country-159" class="thematic-16">NORWAY </option>
							<option id="country-80" class="">NORWEGIAN </option>
							<option id="country-81" class="thematic-10">NORWOOD BOULEVARD</option>
							<option id="country-82" class="thematic-9">NOVA SCOTIA</option>
							<option id="country-158" class="thematic-16">OMAN</option>
							<option id="country-83" class="thematic-10">PACIFIC</option>
							<option id="country-84" class="thematic-2 thematic-5 thematic-6 thematic-16">PAKISTAN</option>
							<option id="country-157" class="thematic-16">PALAU</option>
							<option id="country-156" class="thematic-16">PARAGUAY</option>
							<option id="country-85" class="thematic-4-4">PARIS</option>
							<option id="country-86" class="thematic-3">PENNSYLVANIA</option>
							<option id="country-87" class="thematic-7">PERU</option>
							<option id="country-88" class="thematic-10">PHILADELPHIA</option>
							<option id="country-89" class="thematic-4-5 thematic-8 thematic-9 thematic-16">PHILIPPINES</option>
							<option id="country-90" class="thematic-10">PORTLAND</option>
							<option id="country-155" class="thematic-16">PORTUGAL</option>
							<option id="country-154" class="thematic-16">QATAR</option>
							<option id="country-91" class="thematic-5">QUEENSLAND</option>
							<option id="country-92" class="">REPUBLIC OF CHINA</option>
							<option id="country-153" class="thematic-16">ROMANIA</option>
							<option id="country-152" class="thematic-16">RUSSIA</option>
							<option id="country-151" class="thematic-16">RUSSIA-ARMENIA</option>
							<option id="country-136" class="thematic-4-2">RWANDA</option>
							<option id="country-134" class="thematic-4-1">SAMAO</option>
							<option id="country-93" class="thematic-4-1 thematic-9">SCOTLAND</option>
							<option id="country-94" class="thematic-9 thematic-16">SERBIA</option>
							<option id="country-95" class="">SIERRA LEONE </option>
							<option id="country-150" class="thematic-16">SINGAPORE </option>
							<option id="country-96" class="thematic-7 thematic-16">SLOVAKIA</option>
							<option id="country-97" class="thematic-6 thematic-16">SLOVENIA</option>
							<option id="country-98" class="">SOMALIA</option>
							<option id="country-99" class="thematic-4-1 thematic-4-2 thematic-7 thematic-8 thematic-9 thematic-10 thematic-16">SOUTH AFRICA</option>
							<option id="country-100" class="">SOUTH AMERICA </option>
							<option id="country-101" class="">SOUTH ASIA EUROPE</option>
							<option id="country-102" class="">SOUTH EAST ASIA</option>
							<option id="country-149" class="thematic-16">SOUTH KOREA</option>
							<option id="country-103" class="">SOUTH SADAN</option>
							<option id="country-104" class="">SPAIN</option>
							<option id="country-105" class="thematic-3 thematic-4-5 thematic-7 thematic-9 thematic-16">SRI LANKA</option>
							<option id="country-106" class="">STATE OF ISREAL </option>
							<option id="country-107" class="thematic-10">SUB-SAHARAN AFRICA</option>
							<option id="country-148" class="thematic-16">SUDAN</option>
							<option id="country-108" class="thematic-4-4 thematic-10">SWEDEN</option>
							<option id="country-109" class="thematic-7">SYRIA</option>
							<option id="country-110" class="thematic-2">TAJIKISTAN</option>
							<option id="country-111" class="thematic-4-1">TANZANIA </option>
							<option id="country-112" class="thematic-8 thematic-15">THAILAND</option>
							<option id="country-113" class="">THAILAND AND PHILIPPINES</option>
							<option id="country-133" class="thematic-4-1">TEXAS</option>
							<option id="country-138" class="thematic-4-5">TORONTO</option>
							<option id="country-114" class="thematic-10">TOWNSVILLE</option>
							<option id="country-115" class="">TUNISIA</option>
							<option id="country-116" class="thematic-9 thematic-16">TURKEY</option>
							<option id="country-117" class="thematic-4-3 thematic-4-4 thematic-4-5 thematic-6 thematic-9">UGANDA</option>
							<option id="country-118" class="thematic-4-2 thematic-4-3 thematic-4-4 thematic-4-5 thematic-5 thematic-6 thematic-7 thematic-9 thematic-10 thematic-15 thematic-16">UK</option>
							<option id="country-143" class="thematic-15">UK / EUROPE </option>
							<option id="country-119" class="">UK / INDIA </option>
							<option id="country-120" class="thematic-8 thematic-15">UNITED NATIONS</option>
							<option id="country-147" class="thematic-16">UKRAIN</option>
							<option id="country-121" class="">URGAND</option>
							<option id="country-122" class="thematic-1 active thematic-3 thematic-4-1 thematic-4-3 thematic-4-2 thematic-15">US</option>
							<option id="country-123" class="thematic-2 thematic-4-2 thematic-4-3 thematic-5 thematic-6 thematic-7 thematic-9 thematic-10 thematic-16">USA</option>
							<option id="country-124" class="thematic-4-2 thematic-15">UTAH</option>
							<option id="country-125" class="thematic-8">VASCO DA GAMA</option>
							<option id="country-146" class="thematic-16">VENEZUELA</option>
							<option id="country-126" class="thematic-1 active thematic-3">VICTORIA</option>
							<option id="country-127" class="">VIENTIANE</option>
							<option id="country-128" class="thematic-4-5">WAGENINGEN </option>
							<option id="country-129" class="thematic-7 thematic-16">WALES</option>
							<option id="country-130" class="thematic-10 thematic-15">WASHINGTON</option>
							<option id="country-131" class="thematic-2 thematic-4-1 thematic-4-2 thematic-4-4 thematic-4-5 thematic-15">WORLD</option>
							<option id="country-145" class="thematic-16">YEMEN</option>
							<option id="country-132" class="thematic-5 thematic-9 thematic-15 thematic-16">ZAMBIA</option>
							<option id="country-144" class="thematic-16">ZIMBABVE</option>-->
						</select>
					</div>
				</div>
				<h4 class="page-title">Thematic List</h4>
			</div>
		</div>
	</div>
	<div class="card m-b-30">
		<div class="card-body">

			<!-- Tab panes -->
			<div class="tab-content">
				<div class="tab-pane p-3 active show" id="home" role="tabpanel">

					<div class="tab-content content-block thematic-content">
						<div class="tab-pane p-3 active show" role="tabpanel">				