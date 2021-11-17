<style type="text/css">
ul.typeahead, .autocomplete-suggestions { border: 1px solid #999; background: #fff; cursor: default; width:669px;overflow: auto;padding:0;border-radius:0px;margin-top:0;}
ul.typeahead .dropdown-item,.autocomplete-suggestion { padding: 5px 5px; font-size:17px; white-space: nowrap; overflow: hidden; border:none;font-weight:100 !important;}
.autocomplete-selected { background: #f0f0f0; }
ul.typeahead strong, .autocomplete-suggestions strong { font-weight: normal; color: #ed7d28; }
select[name="functionSelect"]{display:none;}
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
?>
<div class="design-container">
	<ul class="design-fixed">
        <li class="design-title">
            <a href="javascript:void(0)" onClick="duplicateSurvey('<?php echo $survey[0]['title_url'];?>')"><span class="edit-button">Duplicate</span></a>
            <a href="javascript:void(0)" onClick="controlSurvey('<?php echo $survey[0]['title_url'];?>')"><span class="edit-button">Control</span></a>
            <a href="javascript:void(0)" onClick="lengthsSurvey('<?php echo $survey[0]['title_url'];?>')"><span class="edit-button">Lengths</span></a>
            <a href="javascript:void(0)" onClick="compileSurvey('<?php echo $survey[0]['title_url'];?>')"><span class="edit-button">Compile Code</span></a>
            <a href="javascript:void(0)" onClick="editSurveyStyle('<?php echo $survey[0]['title_url'];?>')"><span class="edit-button">Style</span></a>
            <a href="javascript:void(0)" onClick="editSurvey('<?php echo $survey[0]['title_url'];?>')"><span class="edit-button">Edit</span></a>
            <?php echo $survey[0]['title'];?>
        </li>
    </ul>
	<ul class="dragndrop">
   	<?php foreach($sections as $sec){?>
        <li id="<?php echo $sec['id'];?>" class="design-section">
        	<div>
			<a href="javascript:void(0)" onClick="toggleSection(this)"><i class="fa fa-caret-down"></i></a>
			<!--<img src="<?php echo base_url(); ?>theme/images/section_logo.png" title="SECTION" />-->
            <a href="javascript:void(0)" onClick="editSectionStyle('<?php echo $sec['title_url'];?>')"><span class="edit-button">Style</span></a>
			<a href="javascript:void(0)" onClick="delSection('<?php echo $sec['title_url'];?>')"><span class="edit-button">Del</span></a>
			<a href="javascript:void(0)" onClick="editSection('<?php echo $sec['title_url'];?>')"><span class="edit-button">Edit</span></a>
			<a href="javascript:void(0)" onClick="duplicateSection('<?php echo $sec['title_url'];?>')"><span class="edit-button">Duplicate</span></a>
        	<?php echo $sec['title'];?>
            </div>
            <ul class="dragndrop1">
                <?php foreach($sec['questions'] as $sec_question){?>
            	<li id="<?php echo $sec_question['id'];?>" data-section="<?php echo $sec['title_url'];?>" class="design-question">
            		<div class="qpanel">
					<?php if($sec_question['complete']=="0"){?>
					<a class="done_question" href="javascript:void(0)" onClick="completeQuestion(this,'<?php echo $sec_question['id'];?>')"><span class="edit-question-button">Complete</span></a>
					<?php }else{ ?>
						<a href="javascript:void(0)" onClick="codeQuestion(this,'<?php echo $sec_question['id'];?>')"><span class="edit-question-button">Code</span></a>
						<a href="javascript:void(0)" onClick="lengthQuestion(this,'<?php echo $sec_question['id'];?>')"><span class="edit-question-button">Length</span></a>
						<a href="javascript:void(0)" onClick="editQuestionStyle('<?php echo $sec_question['id'];?>')"><span class="edit-question-button">Style</span></a>
						<a href="javascript:void(0)" onClick="delQuestion('<?php echo $sec_question['id'];?>','<?php echo $sec['title_url'];?>')"><span class="edit-question-button">Del</span></a>
						<a href="javascript:void(0)" onClick="editQuestion('<?php echo $sec_question['id'];?>')"><span class="edit-question-button">Edit</span></a>
						<a href="javascript:void(0)" onClick="duplicateQuestion('<?php echo $sec_question['id'];?>')"><span class="edit-question-button">Duplicate</span></a>
					<?php } ?>
           		
            		</div>
                    <div class="question">
						<?php
                        $data=array(
                            'sd'=>$sec_question
                        );
                        $this->load->view('design_question',$data);
                        ?>
                    </div>
                </li>
                <?php } ?>
            </ul>
            <ul class="design-fixed">
            	<li class="design-question">
			        <a href="javascript:void(0)" onClick="chooseQuestionFrom('<?php echo $sec['title_url'];?>')"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Question</a>
                </li>
            </ul>
        </li>
	<?php }?>
	</ul>
	<ul class="design-fixed">
        <li class="design-section">
	        <a href="javascript:void(0)" onClick="createSection('<?php echo $survey[0]['title_url'];?>')"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Section</a>
        </li>
    </ul>
</div>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!--<script src="<?php echo base_url(); ?>theme/js/bootstrap3-typeahead.min.js"></script>  -->
<script type="text/javascript">
$(document).ready(function(){
	$("ul.dragndrop").sortable({
		start: function(e, ui) {
			// creates a temporary attribute on the element with the old index
			$(this).attr('data-previndex', ui.item.index());
		},
		update: function(e, ui) {
			var column1IdArray = [];
			var list=$(this).find("li.design-section").each(function(i){
				column1IdArray.push($(this).attr('id'));
			})
			//alert(column1IdArray);
			var urll='<?php echo base_url();?>survey/ajxsort2/<?php echo get_cookie('design_survey');?>/'+column1IdArray;
			$.ajax({
				url: urll, // url where to submit the request
				type : "GET", // type of action POST || GET
				success : function(result) {
					//$('#comm').append(result);
					//console.log(result);
					//alert(result);
				},
				error: function(xhr, resp, text) {console.log(xhr, resp, text);}
			})
		}
	});
	$("ul.dragndrop1").sortable({
		start: function(e, ui) {
			// creates a temporary attribute on the element with the old index
			$(this).attr('data-previndex', ui.item.index());
		},
		update: function(e, ui) {
			var column2IdArray = [];
			var section_id='';
			var list=$(this).find("li.design-question").each(function(i){
				column2IdArray.push($(this).attr('id'));
				section_id=$(this).data('section');
			})
			//alert(column2IdArray);
			var urll='<?php echo base_url();?>survey/ajxsort1/'+section_id+'/'+column2IdArray;
			//alert(urll);
			$.ajax({
				url: urll, // url where to submit the request
				type : "GET", // type of action POST || GET
				success : function(result) {
					//$('#comm').append(result);
					//console.log(result);
					//alert(result);
				},
				error: function(xhr, resp, text) {console.log(xhr, resp, text);}
			})
		}
	});
	setInterval(function () { 
		if($('#generateCodeQuestionModal').hasClass('in')){
			$('#generateCodeQuestionModal .loader').show();
			var comm_question_id=$('#comm_question_id').val();
			if(comm_question_id!=''){
				var jtext=$('#comm_panel').val();
				try{
					eval(jtext);
					//JSON.parse(jtext);
				}catch(e){
					mesg='<span class="message">Error: '+e.message+'</span>';
					mesg+='<span class="lineno">&nbsp;&nbsp;:'+e.lineNumber+'</span>';
					$('#comm_error').html(mesg);
					var coderror=e.message;
				}finally{
					$.ajax({
						url: '<?php echo base_url();?>survey/question/codesave/'+comm_question_id, // url where to submit the request
						type : "POST", // type of action POST || GET
						data : $("#form_data_code").serialize(), // post data || get data
						success : function(result) {
							console.log('Code Saved!!!');
							setTimeout(function(){
								$('#comm_error').html('');
								$('#generateCodeQuestionModal .loader').hide();
							}, 3000);
						},
						error: function(xhr, resp, text) {
							console.log(xhr, resp, text);
						}
					});	
				}
			}
		}
	}, 10*1000);

	$('body').on('submit', '#question_add', function(event){
		f=$(this);
		var noerror=true;
		f.find('input[type="text"]').not('.lang').each(function (i) {
			var e=$(this);
			var n=e.attr('name');
			//console.log(n);
			var v=$(this).val();
			if(n=="question_no"){
				var patt1 = /\s/g;
				if(v.match(patt1)){
					console.log("Question No cannot have space characters");
					alert("Question No cannot have space characters");
					noerror=false;
					e.focus();
				}
			}
			if(n=="answer[]"){
				var patt1 = /[|]/;
				if(v.match(patt1)){
					var strs = v.split("|");  
					if(strs[0].match(/\s/g)){
						console.log("Choice must not have space before | character");
						alert("Choice must not have space before | character");
						noerror=false;
						e.focus();
					}
				}else{
					console.log("Choice must have | character");
					alert("Choice must have | character");
					noerror=false;
					e.focus();
				}
			}
		});
		return noerror;
	});	
	$('body').on('submit', '#question_edit', function(event){
		f=$(this);
		var noerror=true;
		f.find('input[type="text"]').not('.lang').each(function (i) {
			var e=$(this);
			var n=e.attr('name');
			//console.log(n);
			var v=$(this).val();
			if(n=="question_no"){
				var patt1 = /\s/g;
				if(v.match(patt1)){
					console.log("Question No cannot have space characters");
					alert("Question No cannot have space characters");
					noerror=false;
					e.focus();
				}
			}
			if(n=="answer[]"){
				var patt1 = /[|]/;
				if(v.match(patt1)){
					var strs = v.split("|");  
					if(strs[0].match(/\s/g)){
						console.log("Choice must not have space before | character");
						alert("Choice must not have space before | character");
						noerror=false;
						e.focus();
					}
				}else{
					console.log("Choice must have | character");
					alert("Choice must have | character");
					noerror=false;
					e.focus();
				}
			}
		});
		return noerror;
	});	
	$('body').on('click', '.type_other_check', function(event){	
		if($(this).prop('checked')==true){
			$(this).parent().find(':hidden').val('1');
		}else{
			$(this).parent().find(':hidden').val('');
		}
	});	
});
</script>	
<script src="<?php echo base_url();?>theme/js/cspro_validation1.0_definition.js"></script>
<!--<script src="<?php echo base_url();?>theme/js/cspro_validation1.0.js"></script>-->
<script type="text/javascript">			//necessary for having same position while designing
$(window).scroll(function () {
	if($(window).scrollTop()!=0){
		//set scroll position in session storage
		sessionStorage.scrollPos = $(window).scrollTop();
		console.log(sessionStorage.scrollPos);
	}
});
var init = function () {
    //get scroll position in session storage
    $(window).scrollTop(sessionStorage.scrollPos || 0)
};
window.onload = init;
</script>
<script src="<?php echo base_url();?>theme/js/tableHeadFixer.js"></script>
<script>
var lastElement;	
$(document).ready(function() {
	$(".fixTable").tableHeadFixer({"head" : false, "left" : 1}); 
});
$(document).on('submit','#question_edit',function(){
	console.log($(this));
});	
$(document).on('click','#question_edit input[type="text"],textarea',function(){
	lastElement=$(this);
	//console.log(lastElement);
});	
$(document).on('change','.type-selector',function(){
	if($(this).val()=="Date"){
		$(this).closest('label').find('.date-options').show();
	}else{
		$(this).closest('label').find('.date-options').hide();
	}
});	
$(document).on('change','.date-option-check',function(){
	var checked=$(this).prop('checked');
	var check_input=$(this).closest('.date-option').find('[type="hidden"]');
	var v=$(this).val();
	if($(this).prop('checked')==true){
		check_input.val(v);
	}else{
		check_input.val('');
	}
});	
$(document).ready(function(){
	$('.modal').on('shown.bs.modal', function () {
		setTimeout(function(){
			$('body').addClass('modal-open');
			$('body').css('padding-right','0');
		}, 100);   		
	});
});
function doTextBreak(){
	$('#createQuestionModal,#editQuestionModal').find('input[type="text"],textarea').each(function(){
		editor= $(this);
		var u     = editor.val();
		var start = editor.get(0).selectionStart;
		var end   = editor.get(0).selectionEnd;
		
		if(lastElement!=undefined && editor.attr('tabindex')==lastElement.attr('tabindex')){
			console.log(start+" "+end);
			var value=[u.substring(0, start), u.substring(end), u.substring(start, end)];
			editor.val(value[0] + ''+ value[2] + '</BR>' + value[1]);
		}
	});
	
}
function doHighlight(){
	$('#createQuestionModal,#editQuestionModal').find('input[type="text"],textarea').each(function(){
		editor= $(this);
		var u     = editor.val();
		var start = editor.get(0).selectionStart;
		var end   = editor.get(0).selectionEnd;
		
		if(end!="0" && start!=end){
			console.log(start+" "+end+" working");
			var value=[u.substring(0, start), u.substring(end), u.substring(start, end)];
			editor.val(value[0] + '<HL>'+ value[2] + '</HL>' + value[1]);
		}else{
			console.log(start+" "+end+" not wokring");
		}
	});
	
}
function checkAll(anchorTD,anchorTdClass,checkedornot){
	if(checkedornot==true){
		$(anchorTD).closest('table').find('.'+anchorTdClass).prop('checked',true);
	}else{
		$(anchorTD).closest('table').find('.'+anchorTdClass).prop('checked',false);
	}
}
</script>
