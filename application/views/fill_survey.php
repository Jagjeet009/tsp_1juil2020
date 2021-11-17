<style type="text/css">
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
</style>
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
//print_r($language_shortcut);
//print_r($max_len_lang);
$lang_short=array();			
foreach($language_shortcut as $ls){
	for($l=0;$l<sizeof($max_len_lang);$l++){
		$ls[$l]=strtolower($ls[$l]);
		if(isset($ls[$l]) && !in_array($ls[$l],$lang_short) && !in_array($ls[$l],$restrict_lang)){
			//echo "checking 1 ".$ls[$l]." in  ".implode(' , ',$lang_short)." in  ".implode(' , ',$restrict_lang)."\r\n";
			array_push($lang_short,$ls[$l]);
		}else{
			$l++;
			if(isset($ls[$l]) && !in_array($ls[$l],$lang_short) && !in_array($ls[$l],$restrict_lang)){
				//echo "checking 2 ".$ls[$l]." in  ".implode(' , ',$lang_short)." in  ".implode(' , ',$restrict_lang)."\r\n";
				array_push($lang_short,$ls[$l]);
			}else{			
				$l++;
				if(isset($ls[$l]) && !in_array($ls[$l],$lang_short) && !in_array($ls[$l],$restrict_lang)){
					//echo "checking 3 ".$ls[$l]." in  ".implode(' , ',$lang_short)." in  ".implode(' , ',$restrict_lang)."\r\n";
					array_push($lang_short,$ls[$l]);
				}else{			
					$l++;
					if(isset($ls[$l]) && !in_array($ls[$l],$lang_short) && !in_array($ls[$l],$restrict_lang)){
						//echo "checking 4 ".$ls[$l]." in  ".implode(' , ',$lang_short)." in  ".implode(' , ',$restrict_lang)."\r\n";
						array_push($lang_short,$ls[$l]);
					}else{			
						$l++;
						if(isset($ls[$l]) && !in_array($ls[$l],$lang_short) && !in_array($ls[$l],$restrict_lang)){
							//echo "checking 5 ".$ls[$l]." in  ".implode(' , ',$lang_short)." in  ".implode(' , ',$restrict_lang)."\r\n";
							array_push($lang_short,$ls[$l]);
						}else{			
							$l++;
							if(isset($ls[$l]) && !in_array($ls[$l],$lang_short) && !in_array($ls[$l],$restrict_lang)){
								//echo "checking 6 ".$ls[$l]." in  ".implode(' , ',$lang_short)." in  ".implode(' , ',$restrict_lang)."\r\n";
								array_push($lang_short,$ls[$l]);
							}else{			
								if(isset($ls[$l])){
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
}
//print_r($lang_short);
$language_shorts=array();
if(sizeof($language_shortcut)==sizeof($lang_short)){
	for($i=0;$i<sizeof($language_shortcut);$i++){
		$language_shorts[$language_shortcut[$i]]=strtolower($lang_short[$i]);
	}
}
//print_r($language_shorts);
//print_r($language_shorts);
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
<script type="text/javascript">
<?php echo $small_code;?>
<?php echo $big_code;?>

</script>
<script type="text/javascript">
var system_partial_save=0;		
var system_finish_save=0;	
var system_end_survey=0;
$(document).ready(function(){
	$('#survey_copy').html($('#survey_carbon').html());
});
$(document).ready(function(){
	fillSurveyLog();
	ready1();
});
function ready1(){
	
	localStorage.removeItem("fill_vals");
	localStorage.setItem("fill_vals",'');	
	//console.log("new fill_vals_save cookie");	
	
	var prev_survey_case_id=$('input[name="survey_case_id"]').val();
	//log2("previous survey case id was "+prev_survey_case_id);
	var survey_case_id = localStorage.getItem("survey_case_id");
	if(survey_case_id){
		$('input[name="survey_case_id"]').val(survey_case_id);
		//log2("new survey case id is "+survey_case_id);
	}else{
		$('input[name="survey_case_id"]').val(prev_survey_case_id);
		//log2("again previous survey case id is set "+prev_survey_case_id);
	}
	partialSet('');
	partialLoad('0');
	//partialNextTill();
	if($('input[name="survey_language"]:checked').length>0){$(this).find(':input').each(function(){
		var i=$(this);
		//console.log(i);
	});
		checkLanguage($('input[name="survey_language"]:checked'));
	}else{
		checkLanguage($('input[name="survey_language"]:first-child'));
	}	
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
		//console.log("fill_vals_save removed cookie");
	}
}	
function collect_fill_vals(event,element){
	//console.log("collect_fill_vals called");
	code=event.which || event.keyCode;
	//console.log("code: "+code);
	var el=element;
	var n=el.attr('name');
	if(code=='13'){		
		if(el.attr('type')=="checkbox"){
			//console.log(n+" "+$('[name="'+n+'"][value="'+el.val()+'"]').prop('checked')+" "+el.val());
			if($('[name="'+n+'"][value="'+el.val()+'"]').prop('checked')==true){
				var v=el.val();
			}else{
				var v='';
			}
		}else if(el.attr('type')=="radio"){
			if($('[name="'+n+'"][value="'+el.val()+'"]').prop('checked')==true){
				var v=el.val();
			}
		}else if(el.prop('type')=="select-one"){
			var v=el.val();
		}else{
			var v=el.val();
		}
		if(typeof v !== "undefined"){
			fill_vals=localStorage.getItem("fill_vals");
			new_fill_vals=","+n+":"+v;
			fill_vals+=new_fill_vals;
			localStorage.setItem("fill_vals",fill_vals);
			//console.log(new_fill_vals);
		}else{
			//console.log("v is undefined");
		}
	}		
}	
function partialSet(turn){
//console.log('partialSet turn: '+turn);
	$('form.section-slide').hide();
	var totalSections=$('form.section-slide').length;
	var currentPartial=$('input[name="section-slide-counter"]').val();
	var sectionCount=$('input[name="section-count"]').val();
	currentPartial=parseInt(currentPartial);
	sectionCount=parseInt(sectionCount);
	//console.log("currentPartial: "+currentPartial+" turn: "+turn);
	if(currentPartial=="1"){
		if(totalSections=="1"){
			$('.fill-survey-anchor-prev').hide();
			$('.fill-survey-anchor-next').hide();				
		}else{
			$('.fill-survey-anchor-prev').hide();
			$('.fill-survey-anchor-next').show();			
		}
	}else if(currentPartial==sectionCount){
		$('.fill-survey-anchor-prev').show();
		$('.fill-survey-anchor-next').hide();
	}else{
		$('.fill-survey-anchor-prev').show();
		$('.fill-survey-anchor-next').show();
	}	
	var f=$('form.section-slide:nth-of-type('+currentPartial+')');
	f.show();
	if(turn=="prev"){
		//var i=f.find('ul.question:last').find(':input:last');
		var i=f.find('ul.question').find(':input:last').last();
		i.focus();
	}
	if(turn=="next"){
		//var i=f.find('ul.question:first').find(':input:first');
		var i=f.find('ul.question').find(':input:first').first();
		i.focus();
	}
	system_partial_save=0;
	system_finish_save=0;		
	//console.log(i);
}	
function partialPrev(anchor){
//log2('partialPrev');	
	var currentPartial=$('input[name="section-slide-counter"]').val();
	currentPartial=parseInt(currentPartial);
	
	var currentForm=$('form.section-slide:nth-of-type('+(currentPartial)+')');
	var noPrevious='1';	
	//console.log("currentpartial: "+currentPartial);
	
	while(true){
		if(currentForm.length<1 || noPrevious=='0'){
			break;
		}else{
			currentPartial--;
			
			currentForm=$('form.section-slide:nth-of-type('+(currentPartial)+')');
			var prevFormLi=currentForm.find('ul.question').parent('li').length;
			var prevFormLiHidden=0;
			currentForm.find('ul.question').parent('li').each(function(){
				//console.log($(this).find(':input'));
				//console.log($(this).css('display'));
				if($(this).css('display')=='none' || $(this).find(':input').length===0){
					prevFormLiHidden++;
				}
			});
			if(prevFormLi!==prevFormLiHidden && prevFormLi!=='0'){
				noPrevious='0';
			}
		//console.log("currentpartial: "+currentPartial+" form length: "+currentForm.length+" noprevious: "+noPrevious);
		//console.log("total li: "+prevFormLi+" hidden li: "+prevFormLiHidden);
		}
	}
	//console.log("currentpartial: "+currentPartial);
	$('input[name="section-slide-counter"]').val(currentPartial);
	partialSet('prev');
	partialLoad('');
}	
function partialNext(anchor){
//log2('partialNext');
	$(window).scrollTop(0);
	
	var currentPartial=$('input[name="section-slide-counter"]').val();
	currentPartial=parseInt(currentPartial);
	var sectionCount=$('input[name="section-count"]').val();
	sectionCount=parseInt(sectionCount);
	var currentForm=$('form.section-slide:nth-of-type('+(currentPartial)+')');
	var noForward='1';
	//console.log("currentpartial: "+currentPartial);
	
	var currentSaveButton=currentForm.find('[name="partial-save"]');	
	partialSave(currentSaveButton,0);
	
	while(true){
		if(currentForm.length<1 || noForward=='0'){
			break;
		}else{
			if(currentPartial==sectionCount){
				//console.log("currentPartial: "+currentPartial+" sectionCount: "+sectionCount);
				break;
			}else{
				currentPartial++;
				//console.log("currentpartial: "+currentPartial);
			}
			
			currentForm=$('form.section-slide:nth-of-type('+(currentPartial)+')');
			var nextFormLi=currentForm.find('ul.question').parent('li').length;
			var nextFormLiHidden=0;
			currentForm.find('ul.question').parent('li').each(function(){
				if($(this).css('display')=='none'){
					nextFormLiHidden++;
					//console.log($(this));
				}
			});
			if(nextFormLi!==nextFormLiHidden){
				noForward='0';
			}else{
				//dont save to get back whole section skip condition
				//currentSaveButton=currentForm.find('[name="partial-save"]');	
				//partialSave(currentSaveButton,0);
			}
			//console.log(currentForm.find('input[name="section_title_url"]').val());
			if(currentPartial==sectionCount && nextFormLi==nextFormLiHidden){
				system_end_survey=1;
			}
		}
	}
	if(currentPartial<=sectionCount){
		$('input[name="section-slide-counter"]').val(currentPartial);
	}
	partialSet('next');
	partialLoad('');	

}	
function partialNextTill(section_id){
	//console.log("partial next until");
	if(section_id!=''){
		$(window).scrollTop(0);
		$('input[name="section-slide-counter"]').val(section_id);
		var currentPartial=$('input[name="section-slide-counter"]').val();
		//console.log(" current partial: "+currentPartial);
		partialSet('next');
	}
}
function partialLoad(is_first){
//log2('partialLoad '+is_first);	
	var survey_case_id=$('input[name="survey_case_id"]').val();
	var currentPartial=$('input[name="section-slide-counter"]').val();
	var form_data=$('form.section-slide:nth-of-type('+currentPartial+')').serializeArray();
	var survey_case=localStorage.getItem("case");
	if(survey_case=="Old"){
		$.ajax({
			url: '<?php echo base_url()."survey/partial/load/";?>'+survey_case_id, // url where to submit the request
			type : "POST", // type of action POST || GET
			data : form_data, // post data || get data
			dataType : 'json',
			success : function(result) {
				if(typeof result =='object'){
					result2=result;
					result=result.all_values;
					//result=JSON.parse(result);
					for (var key in result) {
						if (result.hasOwnProperty(key)) {
							var val = result[key];
							var type=$('[name='+key+']').attr('type');
							var type1=$('[name='+key+']').prop('tagName');
							//log2(key+" "+val+" "+type+" "+type1);
							if(type=="text"){
								$('input[name="'+key+'"]').val(val);
							}
							if(type=="radio"){
								$('input[name="'+key+'"][value="'+val+'"]').prop('checked',true);
							}
							if(type=="checkbox"){
								$('input[name="'+key+'"][value="'+val+'"]').prop('checked',true);
							}
							if(type==undefined){
								if(type1=="SELECT"){
									$('select[name="'+key+'"]').val(val);
								}
							}
						}
					}	
					if(is_first!=''){
						//console.log('first time');
						partialNextTill(result2.till_section);
					}else{
						//console.log('second time');
					}					
				}
			},error: function(xhr, resp, text) {log2(xhr, resp, text);
			}
		});	
	}
}
function partialSave(currentButton,mesg){
//console.log('partialSave: '+system_partial_save);
	if(system_partial_save==0){
		system_partial_save=1;
		$(currentButton).addClass('disabled');
		//console.log($(currentButton));
		var proceed=true;
		var currentElement;
		var survey_case_id=$('input[name="survey_case_id"]').val();

		//check all validation of particular section before partial save
		if(proceed===false){
			$('[tabindex=' + currentElement.attr('tabindex') + ']').focus();
			return false;
		}else{
			fill_vals_save();
			var survey_case_id=$('input[name="survey_case_id"]').val();
			var form_data=$(currentButton).closest('form').serializeArray();
			callAjaxPost('<?php echo base_url()."survey/partial/save/";?>'+survey_case_id,form_data,'');
			if(mesg==1){
				$.ajax({
					url: '<?php echo base_url()."survey/newcase/";?>', // url where to submit the request
					type : "GET", // type of action POST || GET
					success : function(result) {
						result=JSON.parse(result);
						//console.log("new case after partial save: "+result.key);
						setSurveyCase2(result.key,"New");
						alert('Partially Saved!!');
						system_partial_save=0;
						system_finish_save=0;						
					},error: function(xhr, resp, text) {log2(xhr, resp, text);}
				});			
			}
			//log2('partially saved');
			return true;
		}
	}
}
function finishSave(currentButton){
	var proceed=true;
	var currentElement;
	var survey_case_id=$('input[name="survey_case_id"]').val();

	if(confirm("Are You Sure! You Want To Save!!") == false) {
		proceed=false;
		system_finish_save=0;
	} 	
	//check all validation of particular section before partial save
	/*$(currentButton).closest('form').find(':input').each(function (i) { 
		//log2($(this));
		system_return="";
		if($(this).closest('ul.question').parent('li').css('display')!='none'){
			currentElement=$(this);
			var func_name=$(this).attr('name');
			fn = window[func_name];
			//console.log(fn);
			if (typeof fn == 'function') { 
					if(last_function!=func_name){
						//log2("checking validation again "+fn.toString());
						eval(func_name+"()");					//function for that question is executedif
						collectElements();
						//log2("question with "+func_name+" gives "+system_return);
					last_function=func_name;
					}
			}else{
				//log2(func_name+" function not found");
			}
			//log2(func_name+" "+system_return);
			if(system_return=="false"){
				proceed=false;
				//return false;
			}
		}
	});*/
	if(proceed===false){
		//$('[tabindex=' + currentElement.attr('tabindex') + ']').focus();
		//return false;
	}else{
		system_finish_save=1;
		var survey_case_id=$('input[name="survey_case_id"]').val();
		var form_data=$(currentButton).closest('form').serializeArray();
		//console.log(form_data);
		fill_vals_save();
		$.post('<?php echo base_url()."survey/partial/save/";?>'+survey_case_id,{'formData':form_data})
		.then(function(){
			var formData=$(currentButton).closest('form').serializeArray();
			var survey_case_id=$('input[name="survey_case_id"]').val();			
		   return $.post('<?php echo base_url()."survey/final/save/";?>'+survey_case_id,{'formData':formData}) //second ajax call
		})
		.then(function(duplicateEntryCheck){
			if(parseInt(duplicateEntryCheck)>0){
				alert("Warning! Duplicate Entry!!");
			}
			return 1;
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
/*function finishSave(currentButton){
//log2('finishSave');	
	var complete=partialSave(currentButton,0);
	if(complete===true){
		var formData=$(currentButton).closest('form').serializeArray();
		var survey_case_id=$('input[name="survey_case_id"]').val();
		$.ajax({
			url: '<?php echo base_url()."survey/final/save/";?>'+survey_case_id, // url where to submit the request
			type : "POST", // type of action POST || GET
			data : {formData},
			success : function(result) {
				//log2(result);
				alert('Finally Saved!!');
				localStorage.removeItem("survey_case_id");
				window.location.reload();
			},error: function(xhr, resp, text) {log2(xhr, resp, text);}
		});
	}
}	*/
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
/*function modify_db_list(element){
	var element_name=element.attr('name'); 
	var element_value;
	if(element.prop('tagName')=="SELECT"){
		element_value=element.val();
		db_list[element_name]=element_value;
	}
	else if(element.prop('tagName')=="TEXTAREA"){
		element_value=element.val();
		db_list[element_name]=element_value;
	}
	else if(element.attr('type')=="text"){
		element_value=element.val();
		db_list[element_name]=element_value;
	}
	else if(element.attr('type')=="radio"){
		if(element.filter(':checked').length==0){
			element_value=element.filter(':first-child').val();
			if (!db_list.hasOwnProperty(element_name)) {
				db_list[element_name]=element_value;
			}
		}else{
			element_value=element.filter(':checked').val();
			db_list[element_name]=element_value;
		}
	}
	else if(element.attr('type')=="checkbox"){
		$('input[type="checkbox"][data-id="'+element.data('id')+'"]').each(function (i) { 
			db_list[element.attr('name')]=element.val();
		});
	}
	else if(element.attr('type')=="file"){
		element_value=element.val();
		db_list[element_name]=element_value;
	}
	else if(element.attr('type')=="submit"){
		element_value=element.val();
		db_list[element_name]=element_value;
	}
	else{}	
	//console.log(db_list);
}*/
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
function ready2(){
	$(".fixTable").tableHeadFixer({"head" : true, "left" : 1}); 
	$('input[type="text"][class="extratext"]').hide();
    $('input[type="text"]').keyup(function(event){					//auto enter on max length passed of input field
		code=event.which || event.keyCode;
		if($(this).attr("maxlength")!="" && ($(this).val().length)!=0 && code!=38){		//for up arrow
			if(($(this).val().length)==$(this).attr("maxlength") && code!=13){
				$(this).trigger($.Event('keydown', { keyCode: 13 }));
			}
		}
	});
	$('.fill-survey').find('input[type="text"]').each(function(){
		var maxlength=$(this).attr('maxlength');
		$(this).attr('size',maxlength);
		
		if(maxlength>=50){
			$(this).attr('word-break','break-word');
		}
	});
}	
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
	
	$('input[type="text"],input[type="radio"],input[type="checkbox"],select,textarea').on("keydown", function(event) {
		collect_fill_vals(event,$(this));
	});		//work other on select
	$("select").on("change", function(event) {
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
	$(":radio").on("change", function(event) {
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
	$(":checkbox").on("change", function(event) {
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
		var el=$(this).parent('select');
		el.trigger('change');
		var e = jQuery.Event("keydown");
		e.which = 13; // some value (backspace = 8)	
		el.trigger(e);
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
function ready4(){
	$('.fill-survey form').on('keydown', 'input[type="radio"],input[type="checkbox"],input[type="text"],textarea', function(event) {
		code=event.which || event.keyCode;
		//console.log("code: "+code);
		if(code=='9' || code=='13' || code=='40'){		//tab enter down-arrow
			event.preventDefault();
			//console.log("system_return: "+system_return+"stop_next: "+stop_next);

			//checking default required
			if($(this).prop('required')==true){
				var name=$(this).attr('name');
				//console.log(name+" running required");
				eval("isRequired('"+name+"')");
			}
			//checking default required

			var func_name=$(this).attr('name');
			fn = window[func_name];
			if (typeof fn == 'function') { 
				var fn_string=fn.toString();
				//setTimeout(function(){
					log2("going to run "+fn_string);
					eval(func_name+"()");
					//setTabIndexAll();
				//}, 1);					
			}
			if(stop_next=="true"){
				stop_next="";
			}
			if(system_return=="" && stop_next!="true"){
				var tabindex=getTabIndexByName($(this));
				goNext(tabindex);
			}
			if(system_return!=""){
				system_return="";
			}
		}
		if(code=='38'){								//up-arrow
			event.preventDefault();
			var tabindex=getTabIndexByName($(this));
			stop_next="true";
			goPrev(tabindex);
		}
	});	
	$('.fill-survey form').on('keydown', 'select', function(event) {
		var sel=$(this);
		var optsel = $(this).find('option:selected').val();
		var tabindex=getTabIndexByName($(this));
		code=event.which || event.keyCode;
		if(code=='9' || code=='13'){		//tab enter
			event.preventDefault();

			//checking default required
			if($(this).prop('required')==true){
				var name=$(this).attr('name');
				//console.log(name+" running required");
				eval("isRequired('"+name+"')");
			}
			//checking default required

			var func_name=$(this).attr('name');
			fn = window[func_name];
			if (typeof fn == 'function') { 
				log2("going to run "+fn.toString());
				eval(func_name+"()");
				//setTabIndexAll();
			}
			if(stop_next=="true"){
				stop_next="";
			}
			if(system_return=="" && stop_next!="true"){
				var tabindex=getTabIndexByName($(this));
				goNext(tabindex);
			}
		}
		if(code=='40'){								//down-arrow
			setTimeout(function(){
				sel.find('option[value="' + optsel +'"]').prop("selected", true);		
				goNext(tabindex);
			}, 10);		
		}	
		if(code=='38'){								//up-arrow
			setTimeout(function(){
				sel.find('option[value="' + optsel +'"]').prop("selected", true);		
				goPrev(tabindex);
			}, 10);		
		}
		if(code=='37'){								//left-arrow
			setTimeout(function(){
				sel.find('option[value="' + optsel +'"]').prev().prop("selected", true);		
				goPrev(tabindex);
			}, 10);	
		}	
		if(code=='39'){								//right-arrow
			setTimeout(function(){
				sel.find('option[value="' + optsel +'"]').next().prop("selected", true);		
				goPrev(tabindex);
			}, 10);	
		}
	});	
	$('.fill-survey form').on('focus', 'input[type="radio"],input[type="checkbox"],input[type="text"],textarea,select', function(event){
		event.preventDefault();
		//console.log("wnt to run pre"+focus_by_setqtext);
		if(focus_by_setqtext=='0'){
			if(stop_next!="true"){	
				var func_name="_"+$(this).attr('name');
				fn = window[func_name];
				if (typeof fn == 'function') { 
					log2("going to run "+fn.toString());
					eval(func_name+"()");
				}
			}
		}
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
	//console.log(system_elements);
	Object.keys(system_elements).forEach(function(key,index) {
		$('[name="'+key+'"]').attr('tabindex', (index+1));
	});	
	//console.log("tab indexing end: "+new Date());
}	
function goNext(tabIndex){
	//log2("system_finish_save: "+system_finish_save);
	//code for automatic next section click on last input of current
	var currentForm=$('form.section-slide:nth-of-type('+$('input[name="section-slide-counter"]').val()+')');
	var last_element=-1;
	currentForm.find('ul.question:visible').each(function(){
		if($(this).find(':input:visible:last').length>0){
			last_element=$(this).find(':input:visible:last').attr('tabindex');
		}
	});
	if(tabIndex===last_element){
		var nav_next=$('div.navigation-labels:first').find('a.fill-survey-anchor-next:visible:first');
		if(nav_next.length==1){
			nav_next.trigger('click');
			
			if(system_end_survey==1){
				system_end_survey=0;
				var button=$('form.section-slide:nth-of-type('+$('input[name="section-slide-counter"]').val()+')').find('.finish-survey:visible:first');
				button.trigger('click');
			}
		}else{
			if(system_finish_save==0){
				var button=$('form.section-slide:visible .finish-survey:visible:first');
				button.trigger('click');
				//system_finish_save=1;
			}
		}
	}else{
		var returnTabIndex=tabIndex;
		tabIndex++;	
		while($('[tabindex=' + tabIndex + ']').css('display')==='none' || $('[tabindex=' + tabIndex + ']').closest('ul.question').closest('li').css('display')==='none'){
			tabIndex++;
		}
		if($('[tabindex=' + tabIndex + ']').css('display')!='none'){
			setFocusOnTabIndex(tabIndex);
		}else{
			tabIndex=returnTabIndex;
		}
		return tabIndex;	
	}
}
function goPrev(tabIndex){
//log2("go prev");	
	//code for automatic prev section click on first input of current
	var currentForm=$('form.section-slide:nth-of-type('+$('input[name="section-slide-counter"]').val()+')');
	var first_element=-1;
	currentForm.find('ul.question:visible').each(function(){
		if($(this).find(':input:visible:first').length>0){
			if(first_element==-1){
				first_element=$(this).find(':input:visible:first').attr('tabindex');
				//console.log($(this).find(':input:visible:first'));
			}
		}
	});
	if(tabIndex===first_element){
		var nav_prev=$('div.navigation-labels:first').find('a.fill-survey-anchor-prev:visible:first');
		nav_prev.trigger('click');
	}
	
	focus_by_setqtext='0';
	var returnTabIndex=tabIndex;	
	
	var toShow=[];
	toShow.push(parseInt(tabIndex)); 
	tabIndex--;
	toShow.push(tabIndex); 
	
	while($('[tabindex=' + tabIndex + ']').css('display')==='none' || $('[tabindex=' + tabIndex + ']').closest('ul.question').closest('li').css('display')==='none'){
		toShow.push(tabIndex); 
		tabIndex--;
	}
	for(var i in toShow) {
		$('[tabindex=' + toShow[i] + ']').closest('ul.question').closest('li').css('display','list-item');
		$('[tabindex=' + toShow[i] + ']').not('.extratext').each(function(){
			$(this).parent().removeClass("published_selected_element");
			$(this).parent().show();
			$(this).show();
		});
		//$('[tabindex=' + toShow[i] + ']:not(.extratext)').css('display','inline-block');
		var lTag=$('[tabindex=' + toShow[i] + ']').closest('ul.question').find('.temp');
		if(lTag.length>0){
			lTag.remove();
		}		
	}	
	if($('[tabindex=' + tabIndex + ']').css('display')!='none'){
		setFocusOnTabIndex(tabIndex);
	}else{
		tabIndex=returnTabIndex;
	}	
	return tabIndex;		
}
function setFocusOnTabIndex(tabIndex){
	var e=$('[tabindex=' + tabIndex + ']');
	if(e.length>1){
		e.eq(0).focus();
	}else{
		e.focus();
	}
}
function getTabIndexByName(element_name){
	var tindex;
	if(element_name.attr('type')=="radio"){
		if(element_name.filter(':checked').length==0){
			tindex=element_name.filter('[tabindex]').attr('tabindex');
		}else{
			tindex=element_name.filter(':checked').attr('tabindex');
		}
	}else{
		tindex=element_name.attr('tabindex');
	}
	if(isNaN(tindex)){
		log2("error:trying to get index of  "+element_name.attr('name')+" "+element_name.attr('type')+" with value"+element_name.val());
	}
	return tindex;
}	
function fillSurveyLog(){
	//console.log("writing file");
}
$(document).ready(function() {														//for capitalize text box alphabets
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
			alert("Here you Go!");
			system_partial_save=0;
			system_finish_save=0;
		},error: function(xhr, resp, text) {log2(xhr, resp, text);}
	});
	//console.log("ready6 called");
}	
/*window.onload = function(){
  setTimeout(function(){
	console.log(performance);
	  var s=parseInt(performance.timing.navigationStart);
	  var e=parseInt(performance.timing.loadEventEnd);
    console.log("performance timming: "+(e-s));
  }, 0);
}*/
/*$(function() {
	$(document).ready(0);
});*/
/*window.onload = function(){	
	alert("Here you Go!");
}*/
</script>
	