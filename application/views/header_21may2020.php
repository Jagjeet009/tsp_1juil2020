<!DOCTYPE HTML>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
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
<meta charset="utf-8" />
<link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.ico">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo base_url();?>theme/css/bootstrap.min.css" />
<!--<link rel="stylesheet" href="<?php echo base_url();?>theme/css/bootstrap.min.css.map" />-->
<link rel="stylesheet" href="<?php echo base_url();?>theme/css/font-awesome.min.css" />
<link href="<?php echo base_url();?>assets/css/dashboard.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo base_url();?>theme/css/main.css?<?php echo time(); ?>" />
<link rel="stylesheet" href="<?php echo base_url();?>theme/css/jquery.minicolors.css" />
<script src="<?php echo base_url();?>theme/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>theme/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>theme/css/jquery-ui.css">

<!-- theme css -->
<?php 
if($this->session->has_userdata('user_logged_username')){
	$user_data=$this->User_model->get_user_by_id($this->session->userdata('user_logged_id'));
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
<body class="">
       <!-- base image file-->
		<?php 
		if($this->session->has_userdata('user_logged_username')){
			$user_data=$this->User_model->get_user_by_id($this->session->userdata('user_logged_id'));
			?>
		<div id="base_theme">
			<?php if($user_data[0]['theme']!=''){?>
			<img src="<?php echo base_url()."userthemes/".$user_data[0]['theme']; ?>.jpg" />
			<?php } ?>
		</div>
		<?php } ?>
       <!-- base image file-->

<div class="error_panel disappear" id="error_panel">test text</div>
<div class="dashor_header">

	<!-- LOGO -->
	<div class="dashor_logo">
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
	</div>
	<div class="dashor_menu">
		<div class="topbar">
			<nav class="navbar-custom">
				<ul class="list-inline float-right mb-0">
					<li class="list-inline-item dropdown notification-list">
						<a class="nav-link dropdown-toggle arrow-none waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
							<!--<img src="assets/images/users/avatar-1.jpg" alt="user" class="rounded-circle">-->
							<i class="fa fa-user rounded-circle"></i>
						</a>
                                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                        <!-- item-->
                                        <div class="dropdown-item noti-title">
                                            <h5>Welcome</h5>
                                        </div>
									<?php if($this->session->userdata('user_logged_id') && (get_cookie('design_survey')!="")){ ?>
                                        <a class="dropdown-item"  href="javascript:void(0)" onClick="changeTheme()"><i class="fa "></i> Change Theme</a>
                                        <a class="dropdown-item"  href="javascript:void(0)" onClick="editProfile()"><i class="fa "></i> Edit Profile</a>
                                        <a class="dropdown-item"  href="javascript:void(0)" onClick="editPermission()"><i class="fa "></i> Permissions</a>
									<?php } ?>                                        
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
							<i class="fa fa-columns"></i>
						</button>
					</li>
					<li class="hide-phone dashboard-title">
						<a class="waves-effect waves-light" href="javascript:void(0)" aria-expanded="false" onclick="primaryDashboard();">
							<i class="fa fa-arrow-circle-left fa-2x"></i>
						</a>
						<?php 
						$connected=@fsockopen("www.google.com", 80);
						if($this->session->userdata('user_logged_id')){ 
						$user_data=$this->User_model->get_user_by_id($this->session->userdata('user_logged_id'));
						?>
						<?php if(base_url()!=ONLINE_URL){?>
							<?php  if ($connected){ ?>
								<a class="waves-effect waves-light online sync-link sync-button-cover" href="javascript:void(0);" onClick="execSync(this)" aria-expanded="false">
									<input type="hidden" id="username" name="username" value="<?php echo $user_data[0]['username']; ?>" />
									<i class="fa fa-cloud-upload fa-2x"></i>
								</a>	
							<?php }else{ ?>
								<a class="waves-effect waves-light sync-link sync-button-cover" href="javascript:void(0);" onClick="alert('No Internet Connection')" aria-expanded="false">
									<i class="fa fa-cloud-upload fa-2x"></i>
								</a>	
							<?php } ?>
						<?php } ?>
						<h3><?php echo $user_data[0]['username']; ?></h3>
						<?php } ?>
					</li>
				</ul>
				<div class="clearfix"></div>
			</nav>
		</div>
	</div>
</div>
<?php if($this->session->userdata('user_logged_id')){?>
<script type="text/javascript">
	var iNet=false;
	var cf;		
	var checkFlag;
	var taskcount=0;
	var taskupdate=0;	
	var queue;
	var connectionString;
	var sync_status="pending";
	function updateTaskProgress(v){
		//console.log(v);
		$('#syncprogress').html(parseInt(v)+"%");
	}
	function checkQueue(){
		setInterval(function(){
			netCheck();

			if(iNet && sync_status=="stopped"){
				console.log('gosync again called');
				sync_status="pending";
				goSync();
			}

			console.log("Net: "+iNet+" Sync Status: "+sync_status);
		}, 1000);		
	}
	function checkNetConnection(){
	 var xhr = new XMLHttpRequest();
	 var file = "https://www.thesurveypoint.com/theme/images/logo.png";
	 var r = Math.round(Math.random() * 10000);
	 xhr.open('HEAD', file + "?subins=" + r, false);
	 try {
	  xhr.send();
		 //console.log(xhr);
	  if (xhr.status >= 200 && xhr.status < 304) {
	   return true;
	  } else {
	   return false;
	  }
	 } catch (e) {
	  return false;
	 }
	}				
	function netCheck(){
		iNet=navigator.onLine;
		//iNet=checkNetConnection();
		//console.log("netCheck: "+iNet);

		if(iNet){
			connectionString='';
		}else{
			sync_status="stopped";
			connectionString=" No Connection! ";
		}
		$('#syncstatus').html(connectionString);

		return iNet;
	}
	function goSync(){
		var u=$('input[name="username"]').val();
		$('#LoaderModal').modal({backdrop: 'static', keyboard: false}, 'show');

		$.get('<?php echo base_url()."desktop_api/sync/";?>'+u).then( function(result) {
			//console.log("result: "+result);
			var new_sync_data=[];
			var result_j=JSON.parse(result);
			taskcount=taskcount+result_j.data.length;
			for (i in result_j.data) {
				var new_data={};
				var new_data_data=[];
				new_data.username=result_j.username;
				new_data.last_time=result_j.last_time;
				new_data_data.push(result_j.data[i]);
				new_data.data=new_data_data;
				new_sync_data.push(new_data);
			}
			queue = Promise.resolve(); // start waiting
			new_sync_data.forEach(function(nsd){
				 queue = queue.then(function(result_r){
					taskupdate++;
					updateTaskProgress(((taskupdate/taskcount))*100);
					if (result_r === undefined) {
					}else{
						//console.log("resultr: "+result_r);						 
						$.getJSON('<?php echo base_url()."desktop_api/syncstatusupdate/";?>'+JSON.parse(result_r)[0].id);
					}
					 console.log("syncing: "+JSON.stringify(nsd));
					return $.post('<?php echo ONLINE_URL."desktop_api/syncsendsingle/";?>'+u, {'data':nsd});
				});
			});
			queue.then(function(result_r){
			//console.log("resultr: "+result_r);					
				if (result_r === undefined) {
				}else{
					$.getJSON('<?php echo base_url()."desktop_api/syncstatusupdate/";?>'+JSON.parse(result_r)[0].id);
				}
				var result_j3=JSON.parse(result);
				$.post('<?php echo ONLINE_URL."desktop_api/syncreceive/";?>'+u,{'data':result_j3}).then( function(backresult) {
					//console.log("backresult: "+backresult);
					$.post('<?php echo base_url()."desktop_api/syncget/";?>',{'data':backresult}).then( function(lastresult) {
						//console.log("lastresult: "+lastresult);
					});
				});
			 // all done here
			sync_status="complete";
			console.log('all done');
			setTimeout(function(){
				$('#LoaderModal').modal('hide');
				alert('Sync sucessful!');
				window.location.reload();
			}, 3000);				
			});	
		}).fail(function(jqXHR, textStatus, errorThrown) {
			console.log("query stopped");
			console.log(jqXHR+" "+textStatus+" "+errorThrown);
		});
	}
	</script>
<?php } ?>							

<div id="page-wrapper">
  <div id="header-wrapper">
    <!--<div id="header" class="container">
        <nav id="nav">
          <ul>
            <li><a href="<?php echo base_url();?>docs">Docs</a></li>
            <li><a href="<?php echo base_url();?>faqs">Faqs</a></li>
			<li><h1 class="a1" id="logo"><a href="javascript:void(0)" onclick="primaryDashboard();">Home</a></h1></li>
			<?php if($this->session->userdata('user_logged_id')){
            $user_data=$this->User_model->get_user_by_id($this->session->userdata('user_logged_id'));
            ?>
            <li><a href="<?php echo base_url();?>login/logout">Logout</a></li>
			<?php }else{ ?>
            <li class="break dropdown"><a class="dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown"> Signup</a>
                <div class="dropdown-menu">
                    <form name="register-form" id="register-form" method="post" action="<?php echo base_url();?>login/register">
                    <label>Username <span id="username_checked"></span></label>
                    <input name="username" class="check_username" required type="text">
                    <label>Email</label>
                    <input name="email" required type="email" autocomplete="email">
                    <label>Name</label>
                    <input name="name" required type="text" autocomplete="name">
                    <label>Contact</label>
                    <input name="contact" required type="text">
                    <input value="Sign Up" type="submit">
                    </form>              
                </div>
            </li>
            <li class="dropdown"><a class="dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown"> Login</a>
                <div class="dropdown-menu">
                    <form name="login-form" id="login-form" method="post" action="<?php echo base_url();?>login/login">
                    <label>Username</label>
                    <input name="username" required type="text">
                    <label>Password</label>
                    <input name="password" required type="password">
                    <input value="Login" type="submit">
                    </form>              
                    <form name="forgot-form" id="forgot-form" method="post" action="<?php echo base_url();?>login/forgot">
                    <label><strong>Forgot Password</strong></label>
                    <label>Username</label>
                    <input name="username" type="text">
                    <label>OR Email</label>
                    <input name="email" type="text" autocomplete="email">
                    <input value="Send" type="submit">
                    </form>              
                </div>
            </li>
			<?php }?>                      
          </ul>
        </nav>
    </div>-->
    <section id="front" class="container-fluid"> <!--<img src="<?php echo base_url();?>theme/images/sambodhi-logo.png">-->
		<?php if($this->session->userdata('user_logged_id') && (get_cookie('design_survey')!="" || get_cookie('fill_survey')!="" || get_cookie('analytics_survey')!="")){ ?>
			<!--<div class="task-tabs">
				<div class="tasks <?php if(get_cookie('design_survey')!=""){echo "task-tab-enable";}else{echo "task-tab-disable";}?>">
					<a href="javascript:createOrExistSurvey()"><h3>Design Survey</h3></a>
				</div>
				<div class="tasks <?php if(get_cookie('fill_survey')!=""){echo "task-tab-enable";}else{echo "task-tab-disable";}?>">
					<a href="javascript:fillSurvey()"><h3>Fill Survey</h3></a>
				</div>
				<div class="tasks <?php if(get_cookie('analytics_survey')!=""){echo "task-tab-enable";}else{echo "task-tab-disable";}?>">
					<a href="javascript:analyticsSurvey()"><h3>Analyse Survey</h3></a>
				</div>
			</div>-->
		<?php } ?>
<?php 
$codeArr=unserialize(codeArr);
$codeArrAvailable=unserialize(codeArrAvailable);
?>		
