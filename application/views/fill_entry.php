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
.languages-panel > label{font-size:15px;line-height: 100%;}
.languages-panel{height:auto;}
.section-name{line-height: 100%;text-align:inherit;}
.question-text{margin:0;padding:0;line-height: 100%;text-align:inherit;}
.savebuttonlabel{padding:0;text-align:inherit;margin:10px 0 0 0;}	
.question-answer-detail{margin:0 20px 0 20px;padding:0;line-height: 100%;text-align:inherit;}
.question-answer-text{margin:0 20px 0 20px;padding:0;line-height: 100%;text-align:inherit;}
#survey_copy{clear:both;width:100%;background-color:#fff;display:none;}	
#fillStatus{font-size:10px;float:left;line-height:15px;}
#directRespondentModal{overflow: hidden}
input[type=checkbox], input[type=radio]{display: inline-block;height: auto;width: auto;}
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

<script type="text/javascript">
	document.cookie = "fill_survey=<?php echo $survey[0]['title_url']; ?>;path=/;";
</script>	
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
	<div class="dashor_menu">
		<div class="topbar">
			<nav class="navbar-custom">
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
//$keycodes=array('a'=>'65','b'=>'66','c'=>'67','d'=>'68','e'=>'69','f'=>'70','g'=>'71','h'=>'72','i'=>'73','j'=>'74','k'=>'75','l'=>'76','m'=>'77','n'=>'78','o'=>'79','p'=>'80','q'=>'81','r'=>'82','s'=>'83','t'=>'84','u'=>'85','v'=>'86','w'=>'87','x'=>'88','y'=>'89','z'=>'90');
//print_r($language_shortcut);
//print_r($lang_short);
?>
<div id="survey_carbon" class="design-container fill-survey">
	<?php if($survey[0]['control']==1){ ?>
	<div class="overlay-div"></div>
	<?php } ?>
	
	<input style="display:none;" <?php if($survey[0]['control']==1){echo "checked";} ?> type="checkbox" name="control" value="1" />
	<ul>
		<li><div class="survey-name" style="<?php echo $survey_style; ?>"><?php echo $survey[0]['title'];?></div></li>
		<li class="languages-panel">
        <?php
		if(isset($_COOKIE["survey_language"])){
			$survey_language=(array) json_decode($_COOKIE["survey_language"]);
		}
		?>
        	<label class="language_labels"><input class="lang-selector" type="checkbox" <?php if(isset($survey_language) && sizeof($survey_language)>0 && in_array("English",$survey_language)){echo "checked";} ?> <?php if(!isset($survey_language) || !sizeof($survey_language)>0){echo "checked";} ?> name="survey_language" value="English" onclick="return checkLanguage(this)" <?php if(array_key_exists("English",$language_shorts)){echo ' data-language="'.$language_shorts['English'].'"';} ?> />&nbsp;English&nbsp;<?php if(array_key_exists("English",$language_shorts)){echo "(Alt+".strtoupper($language_shorts['English']).")";} ?></label>
            <?php foreach((array) json_decode($survey[0]['languages']) as $sl){ ?>
        	<label class="language_labels"><input class="lang-selector" type="checkbox" <?php if(isset($survey_language) && sizeof($survey_language)>0 && in_array($sl,$survey_language)){echo "checked";} ?> name="survey_language" value="<?php echo $sl;?>"  onclick="return checkLanguage(this)" <?php if(array_key_exists($sl,$language_shorts)){echo ' data-language="'.$language_shorts[$sl].'"';} ?> />&nbsp;<?php echo $sl;?>&nbsp;<?php if(array_key_exists($sl,$language_shorts)){echo "(Alt+".strtoupper($language_shorts[$sl]).")";} ?></label>
            <?php } ?>
        </li>
    </ul>
    <div class="navigation-labels">
		<a class="fill-survey-anchor-prev" href="javascript:void(0)" onClick="partialPrev(this)"><input type="button" value="Back (Alt+B)" /></a>
		<a class="fill-survey-anchor-next" href="javascript:void(0)" onClick="partialNext(this)"><input type="button" value="Next (Alt+N)" /></a>
    </div>
    <input type="hidden" name="section-slide-counter" value="1" />
    <input type="hidden" name="section-count" value="<?php echo sizeof($sections); ?>" />
    <input type="hidden" name="survey_case_id" value="<?php echo $randomstring; ?>" />
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
	<form data-id="<?php echo $sec_id; ?>" class="section-slide" method="post" action="<?php echo base_url()."survey/partial/save/";?>" enctype="multipart/form-data">
		<input type="hidden" value="<?php echo $survey[0]['title_url'];?>" name="survey_title_url" />
		<input type="hidden" value="<?php echo $sec['title_url'];?>" name="section_title_url" />
		<ul>
			<li><div class="section-name" style="<?php echo $section_style; ?>"><?php echo $sec['title'];?></div></li>
			<?php foreach($sec['questions'] as $sec_question){$skip_id++;?>
			<li data-id="<?php echo $skip_id; ?>">
				<ul class="question">
					<?php
					$data=array(
						'sd'=>$sec_question
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
		<div class="savebuttonlabel">
			<input class="partial-survey" name="partial-save" type="button" value="Partial Save (Alt+S)" onClick="partialSave(this,1);" />
			<?php if($si==sizeof($sections)){ ?>
				<input class="finish-survey" name="finish-save" type="button" value="Finish (Alt+F)" onClick="finishSave(this)" />
			<?php } ?>
		</div>
	</form>
	<?php }?>
    <div class="navigation-labels">
		<a class="fill-survey-anchor-prev" href="javascript:void(0)" onClick="partialPrev(this)"><input type="button" value="Back (Alt+B)" /></a>
		<a class="fill-survey-anchor-next" href="javascript:void(0)" onClick="partialNext(this)"><input type="button" value="Next (Alt+N)" /></a>
    </div>
<div id="fillStatus">Status</div>
</div>
<div class="error_panel disappear" id="error_panel">test text</div>

<?php 
/*function filterJavascriptCode($c){
	$c=str_replace("answer_answer_","answer_",$c);
	$c=str_replace("answer_answer_","answer_",$c);
	$c=str_replace("answer_answer_","answer_",$c);
	$c=str_replace("answer_answer_","answer_",$c);
	$c=str_replace("answer_answer_","answer_",$c);
	
	$c=str_replace("function","\r\nfunction",$c);
	$c=str_replace("}","\r\n}\r\n",$c);
	$c = preg_replace("/[\r\n]+/", "\n", $c);
	$c=trim($c);
	return $c;
}*/
function invertCodeNames($c,$code_name_array){
	$c=str_replace('"',"'",$c);			//replacing doubel quotes to single ones
	foreach($code_name_array as $sqcn_k=>$sqcn_v){
		$c=str_replace('function _'.$sqcn_v.'(){','function _'.$sqcn_k.'(){',$c);	//preproc functions
		$c=str_replace('function '.$sqcn_v.'(){','function '.$sqcn_k.'(){',$c);		//postproc functions
		$c=str_replace("'".$sqcn_v."'","'".$sqcn_k."'",$c);		//inner code
	}
	return $c;
}
/*if(sizeof($code_name_array)>0){
	foreach($code_name_array as $sqcn_k=>$sqcn_v){
		$big_code=str_ireplace($sqcn_v,$sqcn_k,$big_code);
		$small_code=str_ireplace($sqcn_v,$sqcn_k,$small_code);
	}
}*/
$small_code=invertCodeNames($small_code,$code_name_array);
$big_code=invertCodeNames($big_code,$code_name_array);

//$small_code=filterJavascriptCode($small_code);
//$big_code=filterJavascriptCode($big_code);
?>	
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
<modals>
<div id="directRespondentModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
     <div class="modal-header">
       <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
       <h4 class="modal-title">Direct Respondent Info</h4>
      </div>
      <div class="modal-body">
			<form name="direct-respondent-form" id="direct-respondent-form" method="post">
				<label>Username <span id="username_checked"></span></label>
				<input name="username" class="check_username" required="" tabindex="3" type="text">
				<label>Email</label>
				<input name="email" required="" autocomplete="email" tabindex="4" type="email">
				<label>Name</label>
				<input name="name" required="" autocomplete="name" tabindex="5" type="text">
				<label>Contact</label>
				<input name="contact" required="" autocomplete="contact" tabindex="6" type="text">
				<div class="row">
					<div class="col-lg-6 col-md-6">
					<label>Age</label>
					<input name="age" required="" autocomplete="age" tabindex="7" type="text">
					</div>
					<div class="col-lg-6 col-md-6">
					<label>Gender</label>
					<input type="radio" name="gender" value="male" checked tabindex="8" /> Male
					<input type="radio" name="gender" value="female" tabindex="8" /> Female
					</div>
				</div>
				<label>Location</label>
				<input name="location" required="" autocomplete="location" tabindex="9" type="text">
				<input value="Sign Up" onclick="registerOnline()" tabindex="10" type="button">
			</form>
      </div>
    </div>
  </div>
</div>
</modals>
<iframe id="survey_copy" src="javascript:void(0)"></iframe>

<script type="text/javascript">
<?php echo $small_code;?>
<?php echo $big_code;?>
<?php $this->load->view("fill_entry_javascript_functions");?>
	
<?php if(!$this->session->userdata('user_logged_id')){ ?>	
$('#directRespondentModal').modal('show');	
<?php } ?>	
</script>
<script type="text/javascript">
$(document).ready(function(){
	$('#survey_copy').html($('#survey_carbon').html());
});
$(document).ready(function(){
	ready1();
});
</script>
<script src="<?php echo base_url();?>theme/js/moment.min.js"></script>
<script src="<?php echo base_url();?>theme/js/cspro_validation1.0_definition.js"></script>
<script src="<?php echo base_url();?>theme/js/cspro_validation1.0.js?<?php echo time(); ?>"></script>
<script src="<?php echo base_url();?>theme/js/tableHeadFixer.js"></script>
<script>
var system_return='';
var stop_next='';
$(document).ready(function() {
	ready2();
});
</script>
<script type="text/javascript">
document.body.addEventListener('keydown', event => {
	if (event.altKey && 'abcdefghijklmnopqrstuvwxyz'.indexOf(event.key) !== -1) {
		event.preventDefault();
		event.stopImmediatePropagation();
		event.stopPropagation();	  
		//console.log(event.key);
		if(event.key=='s'){
			//console.log("alt s pressed");
			var button=$('form.section-slide:visible .partial-survey:visible:first');
			//console.log(button);
			button.trigger('click');
		}else if(event.key=='n'){
			//console.log("alt n pressed");
			var button=$('.fill-survey-anchor-next:visible:first');
			//console.log(button);
			<?php if($survey[0]['control']==0){ ?> button.trigger('click'); <?php } ?>
		}else if(event.key=='b'){
			//console.log("alt b pressed");
			var button=$('.fill-survey-anchor-prev:visible:first');
			//console.log(button);
			<?php if($survey[0]['control']==0){ ?> button.trigger('click'); <?php } ?>
		}else if(event.key=='f'){
			//console.log("alt f pressed");
			var button=$('form.section-slide:visible .finish-survey:visible:first');
			//console.log(button);
			<?php if($survey[0]['control']==0){ ?> button.trigger('click'); <?php } ?>
		}else{
			//console.log("alt language shortcut pressed");
			var button=$('.lang-selector[data-language="'+event.key+'"]');
			//console.log(button);
			button.trigger('click');			
		}		
	}
})	
$(document).ready(function() {				//run once in staring
	ready3();
});
$(document).ready(function() {														//for capitalize text box alphabets
	ready5();
});
function ready5(){
    $("input, textarea").keyup(function() {
        var val = $(this).val()
        $(this).val(val.toUpperCase());
    });
    $('input[type="text"]').on('keypress', function() { 
        var $this = $(this), value = $this.val(); 
        if (value.length === 1) { 
            $this.val( value.charAt(0).toUpperCase() );
        }  
    });
	$(document).on('keyup','input, textarea',function(event){	
        var val = $(this).val()
        $(this).val(val.toUpperCase());		
	});
	$(document).on('keypress','input[type="text"]',function(event){	
        var $this = $(this), value = $this.val(); 
        if (value.length === 1) { 
            $this.val( value.charAt(0).toUpperCase() );
        }  		
	});
    $('input[type="text"]').keyup(function(e) {
		var val = $(this).val();
		var regx = /^[A-Za-z0-9 ]+$/;		//alphanumeric
		var regx2 = /^[^\\s]+$/;		//no whitespace at beginnging
		var regx3 = /^[0-9.]+$/;					//numeric
		if ($(this).is('[data-format]')) {
			var dataFormat=$(this).data('format');
			if(dataFormat=="F"){
				//console.log("dataFormat: Numeric");
				if (regx3.test(val)){
					//console.log("correct");
				}else{
					//console.log("incorrect");
					msg("Must Be Numeric");
				}
			}
			if(dataFormat=="A"){
				//console.log("dataFormat: Alpha");
				if (regx.test(val) && regx2.test(val)){
					//console.log("correct");
				}else{
					//console.log("incorrect");
					msg("Must Be Alphabets");
				}
			}
		}
    });
}		
$(document).ready(function() {	
	ready4();
});
$(document).ready(function() {				//run once in staring
	ready6();
});	
function ready6(){
	var survey_title_url=$('.fill-survey').find('input[name="survey_title_url"]:first').val();
	var fillStatus=$('#fillStatus');
	//console.log(survey_title_url);
	$.ajax({
		url: '<?php echo base_url()."survey/fill/status/";?>'+survey_title_url, // url where to submit the request
		type : "GET", // type of action POST || GET
		//data : {formData},
		success : function(result) {
			fillStatus.html(result);
			//console.log(result);
		},error: function(xhr, resp, text) {log2(xhr, resp, text);}
	});
	console.log("ready6 called");
}		
window.onload = function(){
  setTimeout(function(){
	console.log(performance);
	  var s=parseInt(performance.timing.navigationStart);
	  var e=parseInt(performance.timing.loadEventEnd);
    console.log("performance timming: "+(e-s));
  }, 0);
}
</script>
<script src="<?php echo base_url(); ?>theme/js/jquery-ui.min.js"></script>
<script type="text/javascript">
$(".no-work").hover(function(){
	var obj=$(this);
	obj.parent().attr('href','javascript:void(0)');
});
$(document).on('keydown', '#direct-respondent-form', function(event) {
	code=event.which || event.keyCode;
	if(code=='13'){
		//console.log("Register Form Submitted");	
		registerOnline();
		//event.preventDefault();
	}
});		
function registerOnline(){
	var username=$("#direct-respondent-form").find('input[name="username"]').val();
	var name=$("#direct-respondent-form").find('input[name="name"]').val();
	var email=$("#direct-respondent-form").find('input[name="email"]').val();
	var contact=$("#direct-respondent-form").find('input[name="contact"]').val();
	var age=$("#direct-respondent-form").find('input[name="age"]').val();
	var location=$("#direct-respondent-form").find('input[name="location"]').val();
	if(username==''){
		alert('Username is compulsory');$("#direct-respondent-form").find('input[name="username"]').focus();
	}else if(name==''){
		alert('Name is compulsory');$("#direct-respondent-form").find('input[name="name"]').focus();
	}else if(email==''){
		alert('Email is compulsory');$("#direct-respondent-form").find('input[name="email"]').focus();
	}else if(contact==''){
		alert('Contact is compulsory');$("#direct-respondent-form").find('input[name="contact"]').focus();
	}else if(age==''){
		alert('Age is compulsory');$("#direct-respondent-form").find('input[name="age"]').focus();
	}else if(location==''){
		alert('Location is compulsory');$("#direct-respondent-form").find('input[name="location"]').focus();
	}else{
		$('#LoaderModal').modal({backdrop: 'static', keyboard: false}, 'show');		
		$.ajax({
			url: '<?php echo base_url();?>desktop_api/registerDirectRespondent/', // url where to submit the request
			type : "POST", // type of action POST || GET
			data : $("#direct-respondent-form").serialize(), // post data || get data
			dataType: "json",
			success : function(result) {
				if(result.success=="1"){
					setTimeout(function(){
						alert("Registered Sucessfully!!!");
						window.location.reload();
					}, 1000);					
				}
			}
		});
	}
}	
function partialSave(currentButton,mesg){
//log2('partialSave');
	var proceed=true;
	var currentElement;
	var survey_case_id=$('input[name="survey_case_id"]').val();
	
	if(proceed===false){
		$('[tabindex=' + currentElement.attr('tabindex') + ']').focus();
		return false;
	}else{
		var survey_case_id=$('input[name="survey_case_id"]').val();
		var form_data=$(currentButton).closest('form').serializeArray();
		callAjaxPost('<?php echo base_url()."survey/partial/save/";?>'+survey_case_id,form_data,'');
		if(mesg==1){
			//console.log("going new case");
			$.ajax({
				url: '<?php echo base_url()."survey/newcase/";?>', // url where to submit the request
				type : "GET", // type of action POST || GET
				success : function(result) {
					result=JSON.parse(result);
					//console.log("new case after partial save: "+result.key);
					setSurveyCase2(result.key,"New");
					alert('Partially Saved!!');
				},error: function(xhr, resp, text) {log2(xhr, resp, text);}
			});			
		}
		//log2('partially saved');
		return true;
	}
}
function finishSave(currentButton){
	var proceed=true;
	var currentElement;
	var survey_case_id=$('input[name="survey_case_id"]').val();

	if(confirm("Are You Sure! You Want To Save!!") == false) {
		proceed=false;
	} 	
	if(proceed===false){
		//$('[tabindex=' + currentElement.attr('tabindex') + ']').focus();
		//return false;
	}else{
		var survey_case_id=$('input[name="survey_case_id"]').val();
		var form_data=$(currentButton).closest('form').serializeArray();
		//console.log(form_data);
		$.post('<?php echo base_url()."survey/partial/save/";?>'+survey_case_id,{'formData':form_data})
		.then(function(){
			var formData=$(currentButton).closest('form').serializeArray();
			var survey_case_id=$('input[name="survey_case_id"]').val();			
		   return $.post('<?php echo base_url()."survey/final/save/";?>'+survey_case_id,{'formData':formData}) //second ajax call
		})
		.done(function(resp){
			$.ajax({
				url: '<?php echo base_url()."survey/newcase/";?>', // url where to submit the request
				type : "GET", // type of action POST || GET
				success : function(result) {
					result=JSON.parse(result);
					//console.log("new case after finish save: "+result.key);
					setSurveyCase2(result.key,"New");
					alert('Finally Saved!!');
				},error: function(xhr, resp, text) {log2(xhr, resp, text);}
			});	
		 });
		//return true;
	}	
}	
function ready3(){
	<?php if($survey[0]['control']==1){ ?>								  
	$('.fill-survey>.overlay-div').on("click", function(e) {
		e.preventDefault();
		e.stopImmediatePropagation();
		e.stopPropagation();
		return false;		
	});	
	$('.fill-survey>.overlay-div').on("mousedown", function(e) {
		e.preventDefault();
		e.stopImmediatePropagation();
		e.stopPropagation();
		return false;		
	});		
	<?php } ?>

	$('.fill-survey form').find(":input").not('[type="button"]').on("focus", function(event) {			// add green border on focus
		$(this).parent().addClass('published_selected_element');
		$(this).addClass('above_overlay');
		
		<?php if(isset($survey['0']['control']) && $survey['0']['control']=='1'){echo "$(this).prop('required',true);";} ?>
		
		var tw=$(this).closest('div.table-wrapper');			//setting autofocus of matrix according to element
		if(tw.length>0){
			var $this = $(this);
			var $tr=$this.closest('tr');
			var trWidth=$tr.innerWidth();
			var firstTD=$tr.find('td:first');
			var firstTDWidth=firstTD[0].offsetLeft;
			var toTd=$this.closest('td');
			var toTdLeft=toTd[0].offsetLeft;
			var sl=toTdLeft-firstTDWidth;

			$this.closest('div.table-wrapper').animate({
			scrollLeft: sl
			}, 100);											///vertical focus
			
			
			var firstTR=tw.find('tr:first');
			var firstTRHeight=firstTR.innerHeight();
			
			var trHeight=$tr.innerHeight();
			//console.log(trHeight);
			//console.log($tr[0].offsetTop);
			var s2=$tr[0].offsetTop-firstTRHeight;
			//console.log(s2);
			$this.closest('div.table-wrapper').animate({
			scrollTop: s2
			}, 100);											//horizontal focus
		}
		
		//setting autofocus of not matrix question according to element
		var extraTop=$('.fill-survey')[0].offsetTop;
		var extraHeight=$('.dashor_logo').height();
		//console.log("extratop: "+extraTop+" height: "+extraHeight);
		var ulQuestion=$(this).closest('ul.question');
		var viewportHeight = $(window).height();
		//var s3=(ulQuestion[0].offsetTop+ulQuestion.innerHeight())-viewportHeight;
		var s3=(ulQuestion[0].offsetTop+ulQuestion.height()+extraTop+extraHeight+20)-viewportHeight;
		//console.log("top: "+ulQuestion[0].offsetTop+" height: "+ulQuestion.height()+" totalheight: "+viewportHeight+" total: "+s3) ;
		$('html,body').animate({scrollTop: s3}, 100);

	});
	$('.fill-survey form').find(":input").not('[type="button"]').on("blur", function(event) {			// remove green border on blur
		$(this).parent().removeClass('published_selected_element');
		//$(this).removeClass('above_overlay');
		<?php if(isset($survey['0']['control']) && $survey['0']['control']=='1'){echo "$(this).prop('required',false);";} ?>
		
		if(event.relatedTarget!=null){
			focus_by_setqtext='0';
			//onclick prev element show between elements
			var fromElement=$(this).attr('tabindex');
			var toElement=$(event.relatedTarget).attr('tabindex');
			if(toElement<fromElement){
				for(i=(parseInt(fromElement));i>=(parseInt(toElement));i--){
					$('[tabindex=' + i + ']').closest('ul.question').closest('li').css('display','list-item');
					$('[tabindex=' + i + ']').not('.extratext').each(function(){
						$(this).parent().show();
						$(this).show();
					});
					//$('[tabindex=' + i + ']:not(.extratext)').css('display','inline-block');
					var lTag=$('[tabindex=' + i + ']').closest('ul.question').find('.temp');
					if(lTag.length>0){
						lTag.remove();
					}
				}
			}
		}		
	});
	
	$("select").on("change", function() {
		if($(this).hasClass('setOther')){
			if($(this).prop('selectedIndex')==($(this).prop('length')-1)){
				var extratext=$(this).parent().find('.extratext');
				$(extratext).show();
				$(extratext).focus();
				setTimeout(function(){
					$(extratext).val('');
				}, 1);					
			}else{
				var extratext=$(this).parent().parent().find('.extratext');
				$(extratext).hide();
				setTimeout(function(){
					$(extratext).val('');
				}, 1);					
			}
		}
	});		//work other on select
	$(":radio").on("change", function() {
		if($(this).hasClass('setOther')){
			var extratext=$(this).parent().find('.extratext');
			$(extratext).show();
			$(extratext).focus();
			setTimeout(function(){
				$(extratext).val('');
			}, 1);				
		}else{
			var extratext=$(this).parent().parent().find('.extratext');
			$(extratext).hide();
			setTimeout(function(){
				$(extratext).val('');
			}, 1);				
		}
	});		//work other on radio
	$(":checkbox").on("change", function() {
		if($(this).is(':checked')){
			if($(this).hasClass('setOther')){
				var extratext=$(this).parent().find('.extratext');
				$(extratext).show();
				$(extratext).focus();
				setTimeout(function(){
					$(extratext).val('');
				}, 1);				
			}
		}else{
			if($(this).hasClass('setOther')){
				var extratext=$(this).parent().find('.extratext');
				$(extratext).hide();
				setTimeout(function(){
					$(extratext).val('');
				}, 1);				
			}
		}
	});		//work other on checkbox
	
	$(":radio,:checkbox").on("click", function() {			//auto enter on radio and checkbox on click
		$(this).trigger('change');
		var e = jQuery.Event("keydown");
		e.which = 13; // some value (backspace = 8)	
		$(this).trigger(e);
	});		// auto enter on radio and checkbox
	$("select option").on("click", function() {			//auto enter on radio and checkbox on click
		$(this).trigger('change');
		var e = jQuery.Event("keydown");
		e.which = 13; // some value (backspace = 8)	
		$(this).trigger(e);
	});		// auto enter on radio and checkbox

	$("select").on("mousedown", function(e) {
		var length=$(this).find('option').length;
		$(this).attr('size',length);		
	}); 			//open select on focus [under construction]
	$("select").on("focus", function() {
		var length=$(this).find('option').length;
		$(this).attr('size',length);
	});	
	$("select").on("blur", function() {
		$(this).attr('size',1);
	});	
	
	var timer = null, initials = "";	
	$(":radio,select").keypress(function (e) {
		initials += String.fromCharCode(e.which);
		
		//console.log(initials);
		
		var elementname=$(this).attr('name');
		var element=$(this);
		if((element).attr('type')=="radio"){
			$('input[name="'+elementname+'"][value="'+initials+'"]').prop('checked', true);
			$('input[name="'+elementname+'"][value="'+initials+'"]').focus();
			//$('input[name="'+elementname+'"][value="'+initials+'"]').trigger('change');
		
		}
		if((element).prop('tagName')=="SELECT"){
			$('select[name="'+elementname+'"]').val(initials);
		}
		// Set/reset timer
		if (timer) {
			clearTimeout(timer);
			timer = null;
		}
		timer = setTimeout(function () {
			
			if((element).attr('type')=="radio"){
				$('input[name="'+elementname+'"][value="'+initials+'"]').trigger('change');
				var e = jQuery.Event("keydown");
				e.which = 13; // some value (backspace = 8)	
				$('input[name="'+elementname+'"][value="'+initials+'"]').trigger(e);	
			}
			if((element).prop('tagName')=="SELECT"){
				$('select[name="'+elementname+'"]').trigger('change');
				var e = jQuery.Event("keydown");
				e.which = 13; // some value (backspace = 8)	
				$('select[name="'+elementname+'"]').trigger(e);	
			}
			
			timer = null;
			initials = "";
		}, 500); // Max 2 second pause allowed between key presses
		//return false;
	});			// type number to chosse option
	
	var timer1 = null, initials1 = "";	
	$(":checkbox").keypress(function (e) {
		initials1 += String.fromCharCode(e.which);
		
		var element1name1=$(this).attr('name');
		var element1=$(this);
		
		// Set/reset timer1
		if (timer1) {
			clearTimeout(timer1);
			timer1 = null;
		}
		timer1 = setTimeout(function () {
			
			if((element1).attr('type')=="checkbox"){
				var group=$('input[name="'+element1name1+'"]').parent().parent();
				group.find(':checkbox[value="'+initials1+'"]').each(function (i) {
					if(!$(this).is(':checked')){
						$(this).prop('checked', true);
						$(this).focus();
						$(this).trigger('change');
						var e = jQuery.Event("keydown");
						e.which = 13; // some value (backspace = 8)	
						$(this).trigger(e);				
					}else{
						$(this).prop('checked', false);
						$(this).trigger('change');
						var e = jQuery.Event("keydown");
						e.which = 13; // some value (backspace = 8)	
						$(this).trigger(e);				

					}
				});
			}			
			
			timer1 = null;
			initials1 = "";
		}, 500); // Max 2 second pause allowed between key presses
		//return false;
	});			// type number to chosse option	
	
	setTabIndexAll();
	goNext(0);	
}	
	
</script>
</body>
</html>
