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
$survey=$this->db->query("select * from survey where title_url='".$title_url."' ");
if($survey->num_rows()>0){
	$survey=$survey->result_array();
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
<link rel="stylesheet" href="<?php echo base_url();?>theme/css/main.css" />
<link rel="stylesheet" href="<?php echo base_url();?>theme/css/jquery.minicolors.css" />
<script src="<?php echo base_url();?>theme/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>theme/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>theme/css/jquery-ui.css">
<style type="text/css">
.navbar-custom{height:70px;}
#front .design-container{color:#000;}
.fill-survey{font-family:Courier New;color:#000;}
input{font-family:Courier New;}
.survey-name{font-size:30px;line-height: 100%;}
.section-name{line-height: 100%;text-align:inherit;}
.question-text{margin:0;padding:0;line-height: 100%;text-align:inherit;}
.savebuttonlabel{padding:0;text-align:inherit;margin:10px 0 0 0;}	
.question-answer-detail{margin:0 20px 0 20px;padding:0;line-height: 100%;text-align:inherit;}
.question-answer-text{margin:0 20px 0 20px;padding:0;line-height: 100%;text-align:inherit;}
input[type=checkbox], input[type=radio]{display: inline-block;height: auto;width: auto;}
#front .fill-survey {padding: 0 20px 20px 20px;}
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
<body class="">
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
	</div>
</div>
<div id="page-wrapper">
  <div id="header-wrapper">
    <section id="front" class="container-fluid">
<?php 
$new_sections=array();
$sections=array();
if($survey[0]['section_sort_id']!=""){
	$sort=explode(',',$survey[0]['section_sort_id']);
	foreach($sort as $s){
		$sec_data=$this->Survey_model->get_survey_section_by_id($s);
		if(sizeof($sec_data)>0){
			if($sec_data[0]['question_sort_id']!=""){
				$questions=array();
				$sort1=explode(',',$sec_data[0]['question_sort_id']);
				foreach($sort1 as $s1){
					$ques_data=$this->Survey_model->get_survey_data_by_id($s1);
					if(sizeof($ques_data)>0){
						array_push($questions,$ques_data[0]);
					}
				}
				$sec_data[0]['questions']=$questions;
			}else{
				$questions=array();
				$questions=$this->Survey_model->get_survey_data_by_title_url($sec_data[0]['title_url']);
				$sec_data[0]['questions']=$questions;
			}								
			array_push($new_sections,$sec_data[0]);
		}
	}
}else{
	$sections=$this->Survey_model->get_survey_sections_by_title_url($survey[0]['title_url']);
	foreach($sections as $sec){
		if($sec['question_sort_id']!=""){
			$questions=array();
			$sort1=explode(',',$sec['question_sort_id']);
			foreach($sort1 as $s1){
				$ques_data=$this->Survey_model->get_survey_data_by_id($s1);
				if(sizeof($ques_data)>0){
					array_push($questions,$ques_data[0]);
				}
			}
			$sec['questions']=$questions;
		}else{
			$questions=array();
			$questions=$this->Survey_model->get_survey_data_by_title_url($sec['title_url']);
			$sec['questions']=$questions;
		}
		array_push($new_sections,$sec);
	}
}
$sections=$new_sections;
$big_code='';
$small_code='';

$code_name_array=array();
foreach($sections as $sec){
	foreach($sec['questions'] as $sec_question){
		if($sec_question['code_name']!=''){
			$sec_question['code_name']=(array) json_decode($sec_question['code_name']);
			//print_r($sec_question['code_name']);
			foreach($sec_question['code_name'] as $keyy=>$valuee){
				$code_name_array[$keyy]=$valuee;
			}
		}
	}
}
$survey[0]['style']=(array) json_decode($survey[0]['style']);
$survey_style='';
if(isset($survey[0]['style']['survey_font_size']) && $survey[0]['style']['survey_font_size']!=''){
	$survey_style.="font-size:".$survey[0]['style']['survey_font_size']."px !important;";
}
if(isset($survey[0]['style']['survey_font_color']) && $survey[0]['style']['survey_font_color']!=''){
	$survey_style.="color:".$survey[0]['style']['survey_font_color']." !important;";
}
if(isset($survey[0]['style']['survey_background']) && $survey[0]['style']['survey_background']!=''){
	$survey_style.="background-color:".$survey[0]['style']['survey_background']." !important;";
}

if(isset($survey[0]['style']['survey_align']) && $survey[0]['style']['survey_align']!=''){
	$survey_style.="text-align:".$survey[0]['style']['survey_align']." !important;";
}
if(isset($survey[0]['style']['survey_font_weight']) && $survey[0]['style']['survey_font_weight']!=''){
	$survey_style.="font-weight:".$survey[0]['style']['survey_font_weight']." !important;";
}
if(isset($survey[0]['style']['survey_font_style']) && $survey[0]['style']['survey_font_style']!=''){
	$survey_style.="font-style:".$survey[0]['style']['survey_font_style']." !important;";
}
if(isset($survey[0]['style']['survey_text_transform']) && $survey[0]['style']['survey_text_transform']!=''){
	$survey_style.="text-transform:".$survey[0]['style']['survey_text_transform']." !important;";
}
if(isset($survey[0]['style']['survey_text_decoration']) && $survey[0]['style']['survey_text_decoration']!=''){
	$survey_style.="text-decoration:".$survey[0]['style']['survey_text_decoration']." !important;";
}

if(isset($survey[0]['style']['survey_border_style']) && $survey[0]['style']['survey_border_style']!=''){
	$survey_style.="border-style:".$survey[0]['style']['survey_border_style']." !important;";
}
if(isset($survey[0]['style']['survey_border_color']) && $survey[0]['style']['survey_border_color']!=''){
	$survey_style.="border-color:".$survey[0]['style']['survey_border_color']." !important;";
}
if(isset($survey[0]['style']['survey_border_top']) && $survey[0]['style']['survey_border_top']!=''){
	$survey_style.="border-top-width:".$survey[0]['style']['survey_border_top']."px !important;";
}
if(isset($survey[0]['style']['survey_border_right']) && $survey[0]['style']['survey_border_right']!=''){
	$survey_style.="border-right-width:".$survey[0]['style']['survey_border_right']."px !important;";
}
if(isset($survey[0]['style']['survey_border_bottom']) && $survey[0]['style']['survey_border_bottom']!=''){
	$survey_style.="border-bottom-width:".$survey[0]['style']['survey_border_bottom']."px !important;";
}
if(isset($survey[0]['style']['survey_border_left']) && $survey[0]['style']['survey_border_left']!=''){
	$survey_style.="border-left-width:".$survey[0]['style']['survey_border_left']."px !important;";
}

if(isset($survey[0]['style']['survey_margin_top']) && $survey[0]['style']['survey_margin_top']!=''){
	$survey_style.="margin-top:".$survey[0]['style']['survey_margin_top']."px !important;";
}
if(isset($survey[0]['style']['survey_margin_right']) && $survey[0]['style']['survey_margin_right']!=''){
	$survey_style.="margin-right:".$survey[0]['style']['survey_margin_right']."px !important;";
}
if(isset($survey[0]['style']['survey_margin_bottom']) && $survey[0]['style']['survey_margin_bottom']!=''){
	$survey_style.="margin-bottom:".$survey[0]['style']['survey_margin_bottom']."px !important;";
}
if(isset($survey[0]['style']['survey_margin_left']) && $survey[0]['style']['survey_margin_left']!=''){
	$survey_style.="margin-left:".$survey[0]['style']['survey_margin_left']."px !important;";
}
if(isset($survey[0]['style']['survey_padding_top']) && $survey[0]['style']['survey_padding_top']!=''){
	$survey_style.="padding-top:".$survey[0]['style']['survey_padding_top']."px !important;";
}
if(isset($survey[0]['style']['survey_padding_right']) && $survey[0]['style']['survey_padding_right']!=''){
	$survey_style.="padding-right:".$survey[0]['style']['survey_padding_right']."px !important;";
}
if(isset($survey[0]['style']['survey_padding_bottom']) && $survey[0]['style']['survey_padding_bottom']!=''){
	$survey_style.="padding-bottom:".$survey[0]['style']['survey_padding_bottom']."px !important;";
}
if(isset($survey[0]['style']['survey_padding_left']) && $survey[0]['style']['survey_padding_left']!=''){
	$survey_style.="padding-left:".$survey[0]['style']['survey_padding_left']."px !important;";
}
//language shorts
$restrict_lang=array('b','n','s','f');
$language_shortcut=(array) json_decode($survey[0]['languages']);
array_unshift($language_shortcut,"English");	
$max_len_lang=0;			
foreach($language_shortcut as $ls){
	if(strlen($ls)>$max_len_lang){
		$max_len_lang=strlen($ls);
	}
}			
$lang_short=array();			
foreach($language_shortcut as $ls){
	for($l=0;$l<sizeof($max_len_lang);$l++){
		$ls[$l]=strtolower($ls[$l]);
		if(!in_array($ls[$l],$lang_short) && !in_array($ls[$l],$restrict_lang)){
			//echo "checking 1 ".$ls[$l]." in  ".implode(' , ',$lang_short)." in  ".implode(' , ',$restrict_lang)."\r\n";
			array_push($lang_short,$ls[$l]);
		}else{
			$l++;
			if(!in_array($ls[$l],$lang_short) && !in_array($ls[$l],$restrict_lang)){
				//echo "checking 2 ".$ls[$l]." in  ".implode(' , ',$lang_short)." in  ".implode(' , ',$restrict_lang)."\r\n";
				array_push($lang_short,$ls[$l]);
			}else{			
				$l++;
				if(!in_array($ls[$l],$lang_short) && !in_array($ls[$l],$restrict_lang)){
					//echo "checking 3 ".$ls[$l]." in  ".implode(' , ',$lang_short)." in  ".implode(' , ',$restrict_lang)."\r\n";
					array_push($lang_short,$ls[$l]);
				}else{			
					$l++;
					if(!in_array($ls[$l],$lang_short) && !in_array($ls[$l],$restrict_lang)){
						//echo "checking 4 ".$ls[$l]." in  ".implode(' , ',$lang_short)." in  ".implode(' , ',$restrict_lang)."\r\n";
						array_push($lang_short,$ls[$l]);
					}else{			
						$l++;
						if(!in_array($ls[$l],$lang_short) && !in_array($ls[$l],$restrict_lang)){
							//echo "checking 5 ".$ls[$l]." in  ".implode(' , ',$lang_short)." in  ".implode(' , ',$restrict_lang)."\r\n";
							array_push($lang_short,$ls[$l]);
						}else{			
							$l++;
							if(!in_array($ls[$l],$lang_short) && !in_array($ls[$l],$restrict_lang)){
								//echo "checking 6 ".$ls[$l]." in  ".implode(' , ',$lang_short)." in  ".implode(' , ',$restrict_lang)."\r\n";
								array_push($lang_short,$ls[$l]);
							}else{			
								//echo "checking 7 ".$ls[$l]."\r\n";
								array_push($lang_short,$ls[$l]);
							}
						}
					}
				}
			}
		}
	}
}
$language_shorts=array();
if(sizeof($language_shortcut)==sizeof($lang_short)){
	for($i=0;$i<sizeof($language_shortcut);$i++){
		$language_shorts[$language_shortcut[$i]]=strtolower($lang_short[$i]);
	}
}
?>
<div id="survey_carbon" class="design-container fill-survey">
	<ul>
		<li><div class="survey-name" style="<?php echo $survey_style; ?>"><?php echo $survey[0]['title'];?></div></li>
    </ul>
   	<?php 
	$si=0;$skip_id=0;$sec_id=0;
	foreach($sections as $sec){
		$sec['style']=(array) json_decode($sec['style']);
		$si++;
		$section_style='';
		$sec_id++;
		if(isset($sec['style']['section_font_size']) && $sec['style']['section_font_size']!=''){
			$section_style.="font-size:".$sec['style']['section_font_size']."px !important;";
		}
		if(isset($sec['style']['section_font_color']) && $sec['style']['section_font_color']!=''){
			$section_style.="color:".$sec['style']['section_font_color']." !important;";
		}
		if(isset($sec['style']['section_background']) && $sec['style']['section_background']!=''){
			$section_style.="background-color:".$sec['style']['section_background']." !important;";
		}

		if(isset($sec['style']['section_align']) && $sec['style']['section_align']!=''){
			$section_style.="text-align:".$sec['style']['section_align']." !important;";
		}
		if(isset($sec['style']['section_font_weight']) && $sec['style']['section_font_weight']!=''){
			$section_style.="font-weight:".$sec['style']['section_font_weight']." !important;";
		}
		if(isset($sec['style']['section_font_style']) && $sec['style']['section_font_style']!=''){
			$section_style.="font-style:".$sec['style']['section_font_style']." !important;";
		}
		if(isset($sec['style']['section_text_transform']) && $sec['style']['section_text_transform']!=''){
			$section_style.="text-transform:".$sec['style']['section_text_transform']." !important;";
		}
		if(isset($sec['style']['section_text_decoration']) && $sec['style']['section_text_decoration']!=''){
			$section_style.="text-decoration:".$sec['style']['section_text_decoration']." !important;";
		}

		if(isset($sec['style']['section_border_color']) && $sec['style']['section_border_color']!=''){
			$section_style.="border-color:".$sec['style']['section_border_color']." !important;";
		}
		if(isset($sec['style']['section_border_style']) && $sec['style']['section_border_style']!=''){
			$section_style.="border-style:".$sec['style']['section_border_style']." !important;";
		}
		if(isset($sec['style']['section_border_top']) && $sec['style']['section_border_top']!=''){
			$section_style.="border-top-width:".$sec['style']['section_border_top']."px !important;";
		}
		if(isset($sec['style']['section_border_right']) && $sec['style']['section_border_right']!=''){
			$section_style.="border-right-width:".$sec['style']['section_border_right']."px !important;";
		}
		if(isset($sec['style']['section_border_bottom']) && $sec['style']['section_border_bottom']!=''){
			$section_style.="border-bottom-width:".$sec['style']['section_border_bottom']."px !important;";
		}
		if(isset($sec['style']['section_border_left']) && $sec['style']['section_border_left']!=''){
			$section_style.="border-left-width:".$sec['style']['section_border_left']."px !important;";
		}

		if(isset($sec['style']['section_margin_top']) && $sec['style']['section_margin_top']!=''){
			$section_style.="margin-top:".$sec['style']['section_margin_top']."px !important;";
		}
		if(isset($sec['style']['section_margin_right']) && $sec['style']['section_margin_right']!=''){
			$section_style.="margin-right:".$sec['style']['section_margin_right']."px !important;";
		}
		if(isset($sec['style']['section_margin_bottom']) && $sec['style']['section_margin_bottom']!=''){
			$section_style.="margin-bottom:".$sec['style']['section_margin_bottom']."px !important;";
		}
		if(isset($sec['style']['section_margin_left']) && $sec['style']['section_margin_left']!=''){
			$section_style.="margin-left:".$sec['style']['section_margin_left']."px !important;";
		}
		if(isset($sec['style']['section_padding_top']) && $sec['style']['section_padding_top']!=''){
			$section_style.="padding-top:".$sec['style']['section_padding_top']."px !important;";
		}
		if(isset($sec['style']['section_padding_right']) && $sec['style']['section_padding_right']!=''){
			$section_style.="padding-right:".$sec['style']['section_padding_right']."px !important;";
		}
		if(isset($sec['style']['section_padding_bottom']) && $sec['style']['section_padding_bottom']!=''){
			$section_style.="padding-bottom:".$sec['style']['section_padding_bottom']."px !important;";
		}
		if(isset($sec['style']['section_padding_left']) && $sec['style']['section_padding_left']!=''){
			$section_style.="padding-left:".$sec['style']['section_padding_left']."px !important;";
		}
	?>
	<form class="section-slide" method="post" action="">
		<ul>
			<li><div class="section-name" style="<?php echo $section_style; ?>"><?php echo $sec['title'];?></div></li>
			<?php foreach($sec['questions'] as $sec_question){$skip_id++;?>
			<li data-id="<?php echo $skip_id; ?>">
				<ul class="question">
					<?php
					$data=array(
						'sd'=>$sec_question,
						'survey'=>$survey
					);
					$this->load->view('fill_question',$data);
					?>
				</ul>
			</li>
			<?php
				if($sec_question['code']!=''){
					$sec_question['code']=preg_split('/\/\//',$sec_question['code']);
					unset($sec_question['code'][0]);
					//print_r($sec_question['code']);
					$code=array();
					$key_code='';
					$value_code='';
					//print_r($sec_question['code']);
					$i=0;
					foreach($sec_question['code'] as $c){
						$i++;
						if($i%2==1){
							$key_code=$c;		
						}else{
							$value_code=$c;
						}
						$code[$key_code]=$value_code;
					}
					foreach($code as $k=>$v){
						$big_code_temp='';
						$small_code_temp='';
						if(strstr($v,"/*preproc*/")){
							/*extracting preprec code from postproc code start*/
							$v_temp=explode("/*preproc*/",$v);
							/*extracting preprec code from postproc code end*/
							if(sizeof($v_temp)>0){
								if(!empty($v_temp[2])){
									if(trim($v_temp[2])!=''){
										$big_code_temp.='function '.$k.'(){'.$v_temp[2].'}';
									}
								}
								if(!empty($v_temp[1])){
									if(trim($v_temp[1])!=''){
										$small_code_temp.='function _'.$k.'(){'.$v_temp[1].'}';
									}
								}
							}else{
								if(trim($v)!=''){
									$big_code_temp.='function '.$k.'(){'.$v.'}';
								}
							}
						}else{
							if(trim($v)!=''){
								$big_code_temp.='function '.$k.'(){'.$v.'}';
							}
						}
						$big_code.=$big_code_temp;
						$small_code.=$small_code_temp;
					}
				}
			}
			?>
		</ul>
	</form>
	<?php }?>
</div>
    </section>
  </div>
</div>
<div class="dashor-footer">
	<div class="icons">
							<a href="https://www.facebook.com/thesurveypoint" target="_blank"><i class="fa fa-facebook"></i></a>
							<a href="https://twitter.com/sambodhi" target="_blank"><i class="fa fa-twitter"></i></a> 
							<a href="https://www.linkedin.com/in/thesurveypoint/" target="_blank"><i class="fa fa-linkedin"></i></a> 
							<a href="https://www.instagram.com/thesurveypoint/" target="_blank"><i class="fa fa-instagram"></i></a> 
							<a href="https://plus.google.com/u/0/115478327721066879463" target="_blank"><i class="fa fa-google-plus"></i></a> 
	</div>
	<p>COPYRIGHT © 2015-<?php echo date('Y',time()); ?> <a href="http:www.sambodhi.co.in">Sambodhi Research &amp; Communications Pvt Ltd</a></p>
</div>
<script src="<?php echo base_url();?>theme/js/moment.min.js"></script>
<script src="<?php echo base_url();?>theme/js/tableHeadFixer.js"></script>
<script src="<?php echo base_url(); ?>theme/js/jquery-ui.min.js"></script>
<script type="text/javascript">
function showLanguage(language){
	//console.log("show language "+language);
	processLanguages();
}
function hideLanguage(language){
	//console.log("hide language "+language);
	processLanguages();
}
function pl(ele){
	//console.log("pl "+ele);
	var json_string=readCookie("survey_language");
	var json_array=JSON.parse(json_string);
	for (i=0; i < json_array.length; i++) {
		ele.find(json_array[i]).removeClass('hide_language');
	}
}	
function rl(ele,optext){						//calls on select elements for language
	if(optext===undefined){
	}else{
		//console.log("rl "+ele+" "+optext);
		var temp_language='';
		var json_string=readCookie("survey_language");

		var json_array=JSON.parse(json_string);
		for (i=0; i < json_array.length; i++) {
			optextarr=optext.replace(/> </g,">@<");
			optextarr=optextarr.split("@");
			for (j=0; j < optextarr.length; j++) {
				if(optextarr[j].indexOf(json_array[i])===1){
					optextarr[j]=optextarr[j].replace(/(<([^>]+)>)/ig,"");
					//temp_language=temp_language+" <br>"+optextarr[j]; 	inserting br tag in select box in filling form
					temp_language=temp_language+" "+optextarr[j];
				}
			}
		}
		if(temp_language!=''){
			ele.text("["+ele.val()+"] "+temp_language);
		}
	}
}	
function processLanguages(){
	//console.log("processlanguages");
	var labels=$('.fill-survey').find('label').not('.navigation-labels,.savebuttonlabel,.language_labels').each(function (i) {
		var label=$(this);
		label.children().not(':input,table,div,span.question-no,span.option-value').each(function (i) {	//simple text in html
			$(this).addClass('hide_language');
		});
		label.children().each(function (i) {
			if($(this).prop('type')=="select-one"){						//simple select element in html
				var sel=$(this);
				sel.children().each(function (j) {
					var op=$(this);
					var optext=op.data('lang');
					rl(op,optext);
				});
			}
		});
		label.children().find(':input').each(function (i) {
			if($(this).prop('type')=="select-one"){						//select element in table in html
				var sel=$(this);
				sel.children().each(function (j) {
					var op=$(this);
					var optext=op.data('lang');
					rl(op,optext);
				});
			}
		});
		label.find('th,td').children().not(':input,label.option,br').each(function (i) {		//simple text in table in html
			$(this).addClass('hide_language');
		});
		pl($(this));
	});
}
function setTabIndexAll(){
	//console.log("tab indexing start: "+new Date());
	var system_elements_temp=[];
	$('form.section-slide').find('input[type="radio"],input[type="checkbox"],input[type="text"],textarea,select').each(function (i) { 
		var element_name=$(this).attr('name'); 
		var element_value;
		if($(this).prop('tagName')=="SELECT"){
			element_value=$(this).val();
		}
		else if($(this).prop('tagName')=="TEXTAREA"){
			element_value=$(this).val();
		}
		else if($(this).attr('type')=="text"){
			element_value=$(this).val();
		}
		else if($(this).attr('type')=="radio"){
			if($(this).filter(':checked').length==0){
				element_value=$(this).filter(':first-child').val();
			}else{
				element_value=$(this).filter(':checked').val();
			}
		}
		else if($(this).attr('type')=="checkbox"){
			$('input[type="checkbox"][data-id="'+$(this).data('id')+'"]').each(function (i) { 
				element_value=$(this).val();
			});
		}
		else if($(this).attr('type')=="file"){
			element_value=$(this).val();
		}
		else if($(this).attr('type')=="submit"){
			element_value=$(this).val();
		}
		else{}
		system_elements_temp[element_name]=element_value;
	});
	system_elements=system_elements_temp;
	Object.keys(system_elements).forEach(function(key,index) {
		$('[name="'+key+'"]').attr('tabindex', (index+1));
	});	
	//console.log("tab indexing end: "+new Date());
}	
function primaryDashboard(survey_title_url=''){
	document.cookie = "design_survey="+survey_title_url+";path=/;";
	document.cookie = "fill_survey="+survey_title_url+";path=/;";
	document.cookie = "analytics_survey="+survey_title_url+";path=/;";
	setTimeout(function(){
		window.location='<?php echo base_url(); ?>';
	}, 1000);
}		
$(document).ready(function(){
	$(".fixTable").tableHeadFixer({"head" : true, "left" : 1}); 
	$('input,select,textarea').attr('disabled','true');	
});
</script>
</body>
</html>
