<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
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
<meta content="Survey Point" name="author" />
<link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.ico">
<link href="https://fonts.googleapis.com/css?family=K2D" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>assets/css/icons.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>assets/css/dashboard.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>assets/css/home.css" rel="stylesheet" type="text/css">
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
<!-- Begin page -->
<div id="wrapper"> 
  
  <!-- ========== Left Sidebar Start ========== -->
  <div class="left side-menu"> 
    <!-- LOGO -->
    <div class="topbar-left">
      <div class="text-center"> 
        <!--<a href="index.html" class="logo"><i class="fa fa-paw"></i> Aplomb</a>--> 
        <a href="<?php echo base_url();?>" class="logo logo-1 active"><img src="<?php echo base_url();?>assets/images/logo-1.png" height="45" alt="logo"></a> 
        <a href="<?php echo base_url();?>" class="logo logo-2"><img src="<?php echo base_url();?>assets/images/logo-2.png" height="45" alt="logo"></a> </div>
    </div>
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
				<a class="nav-link dropdown-toggle arrow-none waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false"> 
					<img src="<?php echo base_url();?>assets/images/menu_white.png"> 
				</a>
              <div class="dropdown-menu dropdown-menu-right profile-dropdown "> 
                <!-- item-->
                <!--<div class="dropdown-item noti-title">
                  <h5>Welcome</h5>
                </div>-->
                <a class="dropdown-item" href="javascript:void(0)" onClick="$('#signupModal').modal('show');"><i class="mdi mdi-account-multiple"></i> Sign Up</a> 
                <a class="dropdown-item" href="javascript:void(0)" onClick="$('#loginModal').modal('show');"><i class="mdi mdi-login-variant"></i> Login</a> 
                <a class="dropdown-item" href="<?php echo base_url()."docs";?>"><i class="mdi mdi-file-document"></i> Docs</a> 
                <a class="dropdown-item" href="<?php echo base_url()."help";?>"><i class="mdi mdi-comment-question-outline"></i> Help</a>
                <!--<div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="#"><i class="mdi mdi-power text-danger"></i> Logout</a> -->
                </div>
            </li>
          </ul>
          <div class="clearfix bg-color"></div>
        </nav>
      </div>
      <!-- Top Bar End --> 
    </div>
    <!-- content --> 
    
  </div>
  <!-- End Right content here -->
  
  <section class="banner clearfix">
    <video preload="auto" autoplay loop muted>
      <source src="<?php echo base_url();?>assets/images/banner1.mp4" />
    </video>
    <div class="baner-text">
      <div>
        <h2>&nbsp;<br><br><br><br></h2>
        <h4> <a href="javascript:void(0);" class="typewrite" data-period="4000" data-type='[ "We aid collection of high quality data", "We help derive business insights to be used as actionable elements", "We enable organizations to leverage data for informed decision making", "We cater to audience across the globe", "We help capitalize data on one integrated platform" ]'> <span class="wrap"></span> </a> </h4>
        <h2>&nbsp;<br><br><br></h2>
        <h2>Technological augmentation for intelligent decision making.</h2>
      </div>
      <!--<a href="javascript:void(0);"> <i class="fa fa-chevron-circle-down fa-3x"></i> </a> -->
    </div>
  </section>
  <div class="section-space space-1 clearfix"></div>
  
  <section class="section create three-steps clearfix">
    <div class=" clearfix img"> <img src="<?php echo base_url();?>assets/images/candc.gif" />
      <div class="text">
        <h2>CREATE AND CUSTOMIZE</h2>
        <p>A large set of intuitive tools and comprehensive library of questionnaires and templates to aid the process of creating surveys. Professional surveys can be created through a drag and drop mechanism with minimal usage of coding, though the software is equipped with high end functions to be used at an advanced level.</p>
      </div>
    </div>
  </section>
  
  <section class="section create three-steps clearfix">
    <div class=" clearfix img right"> <img src="<?php echo base_url();?>assets/images/aandp.gif" />
      <div class="text">
        <h2>ACT AND PRIORITIZE</h2>
        <p>A multitude of advanced methods to collect and compile high quality data. It hugely reduces the drudging paperwork and the time put to collect data through its facile technology induced support system or help files.</p>
      </div>
    </div>
  </section>  
  
  <section class="section create three-steps clearfix">
    <div class=" clearfix img"> <img src="<?php echo base_url();?>assets/images/aandpr.gif" />
      <div class="text">
        <h2>ANALYZE AND PREDICT</h2>
        <p>Predictive analytics for strategy formulation, insight derivation and execution. Use the collated data to create a range of next generation visualizations to draw rudimentary inferences for informed decision making.</p>
      </div>
    </div>
  </section>  
  
  <!--<section class="section fill three-steps clearfix">
    <div class=" clearfix img"> <img src="assets/images/bg-3.jpg" /> </div>
    <div class="text">
      <div>
        <h2>ACT AND COMPILE</h2>
        <p>A multitude of advanced methods to collect and compile high quality data. It hugely reduces the drudging paperwork and the time put to collect data through its facile technology induced support system or help files.</p>
      </div>
    </div>
  </section>
  
  <section class="section analyse three-steps clearfix">
    <div class=" clearfix img">
      <div class="text">
        <h2>ANALYZE AND INTERPRET</h2>
        <p>Primitive and advanced analytics for strategy formulation, insight derivation and execution. Use the collated data to create a range of static visualizations to draw rudimentary inferences about the various indicators of the study.</p>
      </div>
    </div>
  </section>-->
  
  <!-- Start Footer content here -->
  <footer class="footer clearfix">
    <div class="footer-menu row text-left">
      <div class="col-md-3"> <img src="<?php echo base_url();?>assets/images/logo-1.png" class="footer-logo"/>
        <p>Technological augmentation for intelligent decision making.</p>
        <p>&nbsp;</p>
        <img src="<?php echo base_url();?>assets/images/sambodhilogo.png" class="footer-logo"/>
      </div>
      <div class="col-md-3">
        <h5>&nbsp;</h5>
        <!--<p>Thesurveypoint is an integrated data collection platform designed to help customers collect high quality data and give their workforce new tools to deliver better services.</p>-->
        <ul>
          <li><a href="<?php echo base_url()."about-us";?>">About Us</a></li>
          <li><a href="<?php echo base_url()."privacy-policy";?>">Privacy Policy</a></li>
          <li><a href="<?php echo "https://blog.thesurveypoint.com/";?>">Blog</a></li>
        </ul>
      </div>
      <div class="col-md-3">
        <h5>Contact us</h5>
        <p>Contact us if you have any question. We'll happy to help.</p>
        <a href="mailto:contact@sambodhi.co.in"><i class="fa fa-envelope"></i>contact@sambodhi.co.in</a> <a href="call:+91 (120)4056400"><i class="fa fa-phone"></i>+91 (120)4056400</a> </div>
      <div class="col-md-3">
        <h5>We Love Feedback</h5>
        <form>
          <input type="text" placeholder="Name" />
          <input type="email" placeholder="Email" />
          <textarea rows="3" placeholder="Message"></textarea>
          <input type="submit" value="Submit" class="btn btn-danger btn-submit" />
        </form>
      </div>
    </div>
    <div class="copyright">
      <div class="icons"> 
		  <a href="https://www.facebook.com/thesurveypoint" target="_blank">
		  	<i class="fab fa-facebook-f"></i>
		  </a> 
		  <a href="https://twitter.com/sambodhi" target="_blank">
		  	<i class="fab fa-twitter"></i>
		  </a> 
		  <a href="https://www.linkedin.com/in/thesurveypoint/" target="_blank">
		  	<i class="fab fa-linkedin-in"></i>
		  </a> 
		  	<a href="https://www.instagram.com/thesurveypoint/" target="_blank">
		  <i class="fab fa-instagram"></i>
		  </a> 
		  <a href="https://plus.google.com/u/0/115478327721066879463" target="_blank">
		  	<i class="fab fa-google-plus-g"></i>
		  </a> 
      </div>
      <p>COPYRIGHT © 2018 <a href="http://www.sambodhi.co.in">Sambodhi Research &amp; Communications Pvt Ltd</a></p>
    </div>
  </footer>
  <!-- End Footer content here --> 
  
</div>
<!-- END wrapper --> 

<!-- jQuery  --> 
<script src="<?php echo base_url(); ?>theme/js/jquery.min.js"></script> 
<script src="<?php echo base_url(); ?>theme/js/jquery-ui.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/waves.js"></script> 
<!--<script src="assets/js/modernizr.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>

        <script src="assets/plugins/metro/MetroJs.min.js"></script>
        <script src="assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
        <script src="assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <script src="assets/plugins/sparkline-chart/jquery.sparkline.min.js"></script>
        <script src="assets/plugins/morris/morris.min.js"></script>
        <script src="assets/plugins/raphael/raphael-min.js"></script>--> 
<script src="<?php echo base_url(); ?>assets/js/dashboard.js"></script> 
<!-- App js --> 
<script src="<?php echo base_url(); ?>assets/js/app.js"></script> 
<script>
	$(window).scroll(function() {    
		var scroll = $(window).scrollTop();
		 console.log(scroll);
		if (scroll >= 550) {
			//console.log('a');
			$(".logo").removeClass("active");
			$(".logo.logo-2").addClass("active");
			$(".side-menu").addClass("change");
			$(".content-page").addClass("change");
			$(".logo img").addClass("active");
		} else {
			//console.log('a');
			$(".logo").removeClass("active");
			$(".logo.logo-1").addClass("active");
			$(".side-menu").removeClass("change");
			$(".content-page").removeClass("change");
			$(".logo img").removeClass("active");
		}
	});
	var TxtType = function(el, toRotate, period) {
		this.toRotate = toRotate;
		this.el = el;
		this.loopNum = 0;
		this.period = parseInt(period, 10) || 2000;
		this.txt = '';
		this.tick();
		this.isDeleting = false;
	};
	TxtType.prototype.tick = function() {
		var i = this.loopNum % this.toRotate.length;
		var fullTxt = this.toRotate[i];

		if (this.isDeleting) {
		this.txt = fullTxt.substring(0, this.txt.length - 1);
		} else {
		this.txt = fullTxt.substring(0, this.txt.length + 1);
		}

		this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';

		var that = this;
		var delta = 200 - Math.random() * 500;

		if (this.isDeleting) { delta /= 2; }

		if (!this.isDeleting && this.txt === fullTxt) {
		delta = this.period;
		this.isDeleting = true;
		} else if (this.isDeleting && this.txt === '') {
		this.isDeleting = false;
		this.loopNum++;
		delta = 500;
		}

		setTimeout(function() {
		that.tick();
		}, delta);
	};
	window.onload = function() {
		var elements = document.getElementsByClassName('typewrite');
		for (var i=0; i<elements.length; i++) {
			var toRotate = elements[i].getAttribute('data-type');
			var period = elements[i].getAttribute('data-period');
			if (toRotate) {
			  new TxtType(elements[i], JSON.parse(toRotate), period);
			}
		}
		// INJECT CSS
		var css = document.createElement("style");
		css.type = "text/css";
		css.innerHTML = ".typewrite > .wrap { border-right: 0.08em solid #fff}";
		document.body.appendChild(css);
	};
	
$('body').on('keydown', '#register-form', function(event) {
	code=event.which || event.keyCode;
	if(code=='13'){
		$(this).find('input[type="button"]').addClass('disabled');
		console.log("Register Form Submitted");	
		registerOnline();
		//event.preventDefault();
	}
});		
$('body').on('keydown', '#login-form', function(event) {
	code=event.which || event.keyCode;
	if(code=='13'){
		$(this).find('input[type="button"]').addClass('disabled');
		console.log("Login Form Submitted");	
		loginOffline();
		//event.preventDefault();
	}
});		
$('body').on('keydown', '#forgot-form', function(event) {
	code=event.which || event.keyCode;
	if(code=='13'){
		$(this).find('input[type="button"]').addClass('disabled');
		console.log("forgot Form Submitted");	
		forgotOnline();
	}
});		
function registerOnline(submitButton){
	$(submitButton).addClass('disabled');
	var username=$("#register-form").find('input[name="username"]').val();
	var name=$("#register-form").find('input[name="name"]').val();
	var email=$("#register-form").find('input[name="email"]').val();
	var contact=$("#register-form").find('input[name="contact"]').val();
	if(username==''){
		alert('Username is compulsory');$("#register-form").find('input[name="username"]').focus();
	}else if(name==''){
		alert('Name is compulsory');$("#register-form").find('input[name="name"]').focus();
	}else if(email==''){
		alert('Email is compulsory');$("#register-form").find('input[name="email"]').focus();
	}else if(contact==''){
		alert('Contact is compulsory');$("#register-form").find('input[name="contact"]').focus();
	}else{
		$('#LoaderModal').modal({backdrop: 'static', keyboard: false}, 'show');		
		$.ajax({
			url: '<?php echo ONLINE_URL;?>desktop_api/register/', // url where to submit the request
			type : "POST", // type of action POST || GET
			data : $("#register-form").serialize(), // post data || get data
			dataType: "json",
			success : function(result) {
				if(result.success=="1"){
					alert('Registered Successfully!');
					$.ajax({
						url: '<?php echo base_url();?>login/savelocal/', // url where to submit the request
						type : "POST", // type of action POST || GET
						data : result, // post data || get data
						success : function(result) {
							setTimeout(function(){
								alert("Registered Sucessfully!!!");
								window.location.reload();
							}, 1000);
						}
					});
				}else{
					setTimeout(function(){
						alert("Try Again");
						window.location.reload();
					}, 1000);
				}
			}
		});
	}
}
function netCheck(){
	iNet=navigator.onLine;
	//iNet=checkNetConnection();
	return iNet;
}	
function loginOffline(submitButton){
	$(submitButton).addClass('disabled');	
	var username=$("#login-form").find('input[name="username"]').val();
	var password=$("#login-form").find('input[name="password"]').val();
	var logintime="";
	if(username==''){
		alert('Username is compulsory');$("#login-form").find('input[name="username"]').focus();
	}else if(password==''){
		alert('Password is compulsory');$("#login-form").find('input[name="password"]').focus();
	}else{
		var synclog=0;
		$('#LoaderModal').modal({backdrop: 'static', keyboard: false}, 'show');
		var formdata=$("#login-form").serialize();
		console.log("Login Data Submitted: "+formdata);
		$.post('<?php echo base_url();?>desktop_api/login/',formdata).then( function(result) {
			//console.log("local attempt: "+result);
			return result;
		<?php if(base_url()!=ONLINE_URL){?>			
		}).then(function(result2) {
			var result_2=JSON.parse(result2);
			if(result_2.success=="1"){
				synclog=result_2.synclog;
				console.log("local attempt: "+result2);
				return result2;
			}else{
				console.log("online attempt: ");
				return $.post('<?php echo ONLINE_URL;?>desktop_api/login/', formdata);
			}
		}).then(function(result3) {
			var result_3=JSON.parse(result3);
			if(result_3.success=="1"){
				if(netCheck()){
					if(synclog>0){
						logintime="second";
						var result_for_syncreceive={};
						result_for_syncreceive.data='';
						result_for_syncreceive.username=username;
						result_for_syncreceive.last_time=synclog;
						result_for_syncreceive.surveys=result_3.surveys;
						console.log("syncseconddata: ");
						return $.post('<?php echo ONLINE_URL;?>login/syncseconddata/'+username, {'data':result_for_syncreceive});
					}else{
						console.log("syncfirstdata: ");
						return $.post('<?php echo ONLINE_URL;?>login/syncfirstdata/'+username, result3);
					}
				}else{
					alert("No Internet Connection For Updates");
					setTimeout(function(){
						window.location.reload();
					}, 1000);						
				}
			}else{
				alert(result_3.message);
				setTimeout(function(){
					window.location.reload();
				}, 1000);					
			}
		}).then(function(result4){
			console.log("Calculating Sync Data... ");
			if(synclog>0){
				if(logintime=="second"){
					return $.post('<?php echo base_url()."desktop_api/syncgetsecond/";?>'+username, {'data':result4});
				}else{
					return $.post('<?php echo base_url()."desktop_api/syncget/";?>'+username, {'data':result4});
				}
			}else{
				return $.post('<?php echo base_url();?>login/syncfirstdataupdate/'+username, {'data':result4});
			}
		}).then(function(result5){	
			console.log(result5);
			console.log("Updating Sync Data and Login Again on Local... ");
			return $.post('<?php echo base_url();?>desktop_api/login/',formdata);
		<?php }?>
		}).then(function(result6){
			var result_6=JSON.parse(result6);
			if(result_6.success=="1"){
				setTimeout(function(){
					alert("You Logged Sucessfully!!!");
					window.location.reload();
				}, 1000);		
			}else{
				alert(result6.message);
				setTimeout(function(){
					window.location.reload();
				}, 1000);					
			}
		}).fail(console.log.bind(console));		
											
	}
}
function forgotOnline(submitButton){
	$(submitButton).addClass('disabled');	
	var username=$("#forgot-form").find('input[name="username"]').val();
	var email=$("#forgot-form").find('input[name="email"]').val();
	if(username=='' && email==''){
		alert('Either username or email is compulsory');
		console.log("username: "+username+" email: "+email);
	}else{
		$("#forgot-form").submit();
	}
}
function license_check(){
	var pattern=/[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}/g;
	var license=$('input[name="license_key"]').val();
	var username=$('input[name="username"]').val();
	if(pattern.test(license)){

	<?php if(base_url()!=ONLINE_URL){?>		
		$.post('<?php echo ONLINE_URL."desktop_api/license_check/";?>',{'license_key':license,'username':username}).then( function(result) {
			result=JSON.parse(result);
			console.log(result.license_key);
			return $.post('<?php echo base_url()."desktop_api/license_check/";?>',{'license_key':result.license_key,'username':result.username});
		}).then(function(result2) {			
			alert('License Sucessful!!!');
			setTimeout(function(){
				window.location.reload();
			}, 1000);
		}).fail(console.log.bind(console));			
	<?php }else{ ?>
		$.post('<?php echo base_url()."desktop_api/license_check/";?>',{'license_key':license,'username':username}).then( function(result) {
		}).then(function(result2) {			
			alert('License Sucessful!!!');
			setTimeout(function(){
				window.location.reload();
			}, 1000);
		}).fail(console.log.bind(console));
		<?php }?>
	}else{
		alert('Please Enter Correct License Key');
	}
	
	
}	
$(document).ready(function(){
	$('.modal').on('shown.bs.modal', function () {
		setTimeout(function(){
			$('body').addClass('modal-open');
			$('body').css('padding-right','0');
		}, 100);   		
	});
	$('#loginModal').on('shown.bs.modal', function () {
		setTimeout(function(){
			$('#login-form').find('.username').focus();
		}, 100);   		
	});	
});	
</script>
<modals>
	<div id="signupModal" class="modal fade" role="dialog">
	  <div class="modal-dialog" style="width:500px;">
		<div class="modal-content">
		 <div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		   <h4 class="modal-title">Sign Up</h4>
		  </div>
		  <div class="modal-body">
			<form name="register-form" id="register-form" method="post">
			<label>Username <span id="username_checked"></span></label>
			<input name="username" class="check_username" required="" type="text" tabindex="3">
			<label>Email</label>
			<input name="email" required="" type="email" autocomplete="email" tabindex="4">
			<label>Name</label>
			<input name="name" required="" type="text" autocomplete="name" tabindex="5">
			<label>Contact</label>
			<input name="contact" required="" type="text" autocomplete="contact" tabindex="6">
			<input value="Sign Up" type="button" onclick="registerOnline(this)" tabindex="7">
			</form>              
		  </div>
		</div>
	  </div>
	</div>		
	<div id="loginModal" class="modal fade" role="dialog">
	  <div class="modal-dialog" style="width:500px;">
		<div class="modal-content">
		 <div class="modal-header">
		   <button type="button" class="close" data-dismiss="modal">&times;</button>
		   <h4 class="modal-title">Login</h4>
		  </div>
		  <div class="modal-body">
			<form name="login-form" id="login-form" method="post">
			<label>Username</label>
			<input class="username" name="username" required="" type="text" autocomplete="username" tabindex="8">
			<label>Password</label>
			<input name="password" required="" type="password" autocomplete="password" tabindex="9">
			<input value="Login" type="button" onclick="loginOffline(this)" tabindex="10">
			<a href="javascript:void(0)" onClick="$('#loginModal').modal('hide');$('#forgotModal').modal('show');">Forgot your password</a>
			</form>	             
		  </div>
		</div>
	  </div>
	</div>	
	<div id="forgotModal" class="modal fade" role="dialog">
	  <div class="modal-dialog" style="width:500px;">
		<div class="modal-content">
		 <div class="modal-header">
		   <button type="button" class="close" data-dismiss="modal">&times;</button>
		   <h4 class="modal-title">Forgot Password</h4>
		  </div>
		  <div class="modal-body">
			<form name="forgot-form" id="forgot-form" method="post" action="<?php echo base_url(); ?>login/forgot">
			<!--<label><strong>Forgot Password</strong></label>-->
			<label>Username</label>
			<input name="username" type="text" autocomplete="username" tabindex="11">
			<label>OR Email</label>
			<input name="email" type="text" autocomplete="email" tabindex="12">
			<input value="Send" type="button" onclick="forgotOnline(this)" tabindex="13">
			<a href="javascript:void(0)" onClick="$('#forgotModal').modal('hide');$('#loginModal').modal('show');">Go to login</a>
			</form>             
		  </div>
		</div>
	  </div>
	</div>		
</modals>

</body>
</html>