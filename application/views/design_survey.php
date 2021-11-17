<style type="text/css">
	ul.typeahead, .autocomplete-suggestions {
		border: 1px solid #999;
		background: #fff;
		cursor: default;
		width: 669px;
		overflow: auto;
		padding: 0;
		border-radius: 0px;
		margin-top: 0;
	}
	ul.typeahead .dropdown-item, .autocomplete-suggestion {
		padding: 5px 5px;
		font-size: 17px;
		white-space: nowrap;
		overflow: hidden;
		border: none;
		font-weight: 100 !important;
	}
	.autocomplete-selected {
		background: #f0f0f0;
	}
	ul.typeahead strong, .autocomplete-suggestions strong {
		font-weight: normal;
		color: #ed7d28;
	}
	select[name="functionSelect"] {
		display: none;
	}
</style>
<style type="text/css">
	.wizard {
		min-height: 500px;
	}
	.wizard a {
		text-decoration: none !important;
		outline: 0;
		border: none;
		-moz-outline-style: none;
	}
	.wizard>div:first-child {
	}
	.wizard>div:last-child {
		padding-left: 0 !important;
	}
	.wizard .nav li {
		width: 100% !important;
	}
	.wizard ul.nav {
		padding: 0 !important;
	}
	.wizard ul.nav>li {
		padding: 0 !important;
	}
	.wizard ul.nav>li>a {
		font-size: 15px !important;
		font-weight: normal !important;
		color: #000 !important;
		line-height: 30px !important;
	}
	.wizard .tab-content {
		font-size: 15px !important;
		color: #000 !important;
		padding: 0 !important;
	}
	.wizard .tab-content>div {
		padding: 0 !important;
	}
	.wizard .tab-content .panel-group {
		padding: 0 !important;
	}
	.wizard .tab-content .panel-default {
		padding: 0 !important;
	}
	.wizard .tab-content .panel-heading {
		padding: 0 !important;
	}
	.wizard .tab-content h4.panel-title {
		padding: 0 !important;
	}
	.wizard .tab-content h4.panel-title>a {
		width: 100%;
		text-decoration: none !important;
		outline: 0;
		border: none;
		-moz-outline-style: none;
	}
	.wizard .tab-content .panel-body {
		padding: 0 !important;
	}
	.wizard fieldset {
		padding: 5px !important;
		border: 1px solid /*#e5e5e5*/#000;
	}
	.wizard legend {
		width: auto;
		border: none;
		position: relative;
		line-height:20px;
	}
	.wizard .panel-collapse .panel-body {
	}
	.wizard fieldset.functions {
		position: relative;
	}
	.wizard fieldset.rule {
		border: 1px dashed green;
	}
	.wizard legend a, legend a i {
		padding: 0 !important;
	}
	#code_wizard_helper, #code_wizard_elseif_helper, #code_wizard_conditional_helper, #code_wizard_procedure_helper {
		display: none;
	}
	.wizard .scrollable-menu {
		height: auto;
		max-height: 200px;
		overflow-x: hidden;
	}
	.codeWizardForm {
		width: 60%;
		display: inline-block;
		vertical-align: top;
	}
	.codeWizardDisplayForm {
		width: 39%;
		display: inline-block;
		vertical-align: top;
	}
	.codeWizardDisplayForm textarea {
		height: 480px;
		padding-left: 50px !important;
	}
	.wizard .nav-tabs > li.active > a, .wizard .nav-tabs > li.active > a:focus, .wizard .nav-tabs > li.active > a:hover {
		background-color: #ddd;
	}
	.codeWizardDisplayForm .numberedtextarea-line-numbers {
		padding-left: 10px !important;
		width: 50px !important;
	}
	.wizard fieldset.condition fieldset.rule .conditional-operators.hidden {
		display: none !important;
	}
	.wizard fieldset.preproc, fieldset.postproc {
		border: none;
	}
	.wizard fieldset.no-class {
		border: none;
		padding: 0 !important;
	}
	.wizard .bs-select-hidden{display:none;}
	.wizard .bootstrap-select{color:#000 !important;height:35px !important;border: 1px solid #000 !important;border-radius:0px !important;/*margin-bottom:5px !important;*/}
	.wizard .bootstrap-select button{color:#000 !important;height:33px !important;border:none !important;padding-left: 5px !important;}
	.wizard .bootstrap-select .dropdown-menu{padding:0px 5px !important;}
	.wizard .bootstrap-select .dropdown-menu ul li{font-size:15px !important;}
	.wizard .bootstrap-select li,.wizard .bootstrap-select a,.wizard .bootstrap-select span{padding:0px !important;}
	.wizard .bootstrap-select .bs-caret{display:none !important;}
	.wizard fieldset.functions>fieldset:hover{background-color:#ccc;}
</style>
<style type="text/css">
	.wizard select, .wizard input[type="text"], .wizard input[type="button"] {
		/*width: 80px;*/
		display: inline-block;
		border: 1px solid #000 !important;
		/*margin: 0;*/
		border-radius: 0;
		height:35px;
		padding-left:5px !important;
		padding-right:5px !important;
		vertical-align: top;
	}
	.wizard select option{
		padding:0 5px !important;
	}
	.wizard select[multiple]{
		height:50px;
		padding:0;
	}
	.wizard input[type="text"].hidden{
		display:none;
	}
	.wizard input[type="text"].separator{
		width: 20px;
	}
	.wizard input[type="button"]:not('.save-button') {
		background-color: #000;
		color: #fff;
		font-weight: bold;
		margin-top: 10px;
	}
	.wizard input[type="button"]:hover{
		color:#000;
		background-color: #FFF;
		border: 1px solid #000 !important;
	}
	.wizard .save-wizard-code {
		width: 99% !important;
		background-color: #000;
		color: #fff;
		font-weight: bold;
		margin-top: 10px;
		text-align:center;
	}
	.wizard .save-button {
		width: 50px;
		background-color: #000;
		color: #fff;
		font-weight: bold;
		margin: 0 !important;
	}

	.wizard ul.variables {
		/*display: none;*/
		display:inline-block;
		width:100%;
		margin:0;
		padding:0;
	}
	.wizard ul.variables li {
		list-style: none;
		float: left;
		line-height: 20px;
		padding-left:5px;
		padding-right:5px;     
	}
	.wizard ul.variables li:first-child::before {
		content: "Vars ";
		padding-left:15px;
	}
	.wizard ul.variables li::after {
		content: ",";
	}
	.wizard ul.variables li:last-of-type::after{
		display: none;
	}

.wizard .dateDiff .variable_ids{width: 22% !important;}	
.wizard .dateDiff .keys{width: 18% !important;}	
.wizard .dateDiff .returns{width: 18% !important;}	
.wizard .doCheck .element_ids{width: 49% !important;}	
.wizard .doCheck .constant{width: 50% !important;}	
.wizard .doColumnHide .element_ids{width: 49% !important;}	
.wizard .doColumnHide .nos{width: 50% !important;}	
.wizard .doColumnShow .element_ids{width: 49% !important;}	
.wizard .doColumnShow .nos{width: 50% !important;}	
.wizard .doHide .element_ids{width: 49% !important;}
.wizard .doShow .element_ids{width: 49% !important;}	
.wizard .doJumpForward .element_ids{width: 49% !important;}	
.wizard .doDivide .variable_ids{width: 49% !important;}	
.wizard .doMinus .variable_ids{width: 49% !important;}	
.wizard .doMultiply .variable_ids{width: 49% !important;}	
.wizard .doRowShow .element_ids{width: 49% !important;}	
.wizard .doRowShow .nos{width: 50% !important;}	
.wizard .doRowHide .element_ids{width: 49% !important;}	
.wizard .doRowHide .nos{width: 50% !important;}	
.wizard .getDistricts .element_ids{width: 49% !important;}	
.wizard .getLabel .element_ids{width: 49% !important;}	
.wizard .getLabel .returns{width: 40% !important;}	
.wizard .getVal .element_ids{width: 49% !important;}	
.wizard .getVal .returns{width: 40% !important;}
.wizard .gps .element_ids{width: 49% !important;}	
.wizard .gps .keys{width: 49% !important;}	
.wizard .isFixed .element_ids{width: 49% !important;}	
.wizard .isFixed .variable_ids{width: 49% !important;}	
.wizard .isMobile .element_ids{width: 40% !important;}	
.wizard .isMobile .digit{width: 29% !important;}	
.wizard .isMobile .mindigit{width: 29% !important;}	
.wizard .isRange .element_ids{width: 49% !important;}	
.wizard .isRange .range{width: 49% !important;}
.wizard .now .keys{width: 49% !important;}	
.wizard .now .returns{width: 40% !important;}	
.wizard .openBox .element_ids{width: 34% !important;}	
.wizard .openBox .element_ids{width: 34% !important;}
.wizard .openBox .openbox{width: 30% !important;}	
.wizard .setQtext .element_ids{width: 49% !important;}	
.wizard .setQtext .variable_ids{width: 49% !important;}	
.wizard .setVal .element_ids{width: 49% !important;}	
.wizard .setVal .variable_ids{width: 49% !important;}	
.wizard .skip .element_ids{width: 49% !important;}	
.wizard .skip .element_ids{width: 49% !important;}	
.wizard .today .keys{width: 49% !important;}	
.wizard .today .returns{width: 40% !important;}	

.wizard .rule .conditional-operators{width: 24% !important;}
.wizard .rule .variable_ids{width: 24% !important;}
.wizard .rule .conditionValue{width: 24% !important;}
.wizard .rule .operators{width: 24% !important;}
.wizard .languages_text{font-size:15px;color:red;padding:0;font-weight:normal;}
</style>
<?php
$new_sections = array();
$sections = array();
if ( $survey[ 0 ][ 'section_sort_id' ] != "" ) {
     $sort = explode( ',', $survey[ 0 ][ 'section_sort_id' ] );
     foreach ( $sort as $s ) {
          $sec_data = $this->Survey_model->get_survey_section_by_id( $s );
          if ( sizeof( $sec_data ) > 0 ) {
               if ( $sec_data[ 0 ][ 'question_sort_id' ] != "" ) {
                    $questions = array();
                    $sort1 = explode( ',', $sec_data[ 0 ][ 'question_sort_id' ] );
                    foreach ( $sort1 as $s1 ) {
                         $ques_data = $this->Survey_model->get_survey_data_by_id( $s1 );
                         if ( sizeof( $ques_data ) > 0 ) {
                              array_push( $questions, $ques_data[ 0 ] );
                         }
                    }
                    $sec_data[ 0 ][ 'questions' ] = $questions;
               } else {
                    $questions = array();
                    $questions = $this->Survey_model->get_survey_data_by_title_url( $sec_data[ 0 ][ 'title_url' ] );
                    $sec_data[ 0 ][ 'questions' ] = $questions;
               }
               array_push( $new_sections, $sec_data[ 0 ] );
          }
     }
} else {
     $sections = $this->Survey_model->get_survey_sections_by_title_url( $survey[ 0 ][ 'title_url' ] );
     foreach ( $sections as $sec ) {
          if ( $sec[ 'question_sort_id' ] != "" ) {
               $questions = array();
               $sort1 = explode( ',', $sec[ 'question_sort_id' ] );
               foreach ( $sort1 as $s1 ) {
                    $ques_data = $this->Survey_model->get_survey_data_by_id( $s1 );
                    if ( sizeof( $ques_data ) > 0 ) {
                         array_push( $questions, $ques_data[ 0 ] );
                    }
               }
               $sec[ 'questions' ] = $questions;
          } else {
               $questions = array();
               $questions = $this->Survey_model->get_survey_data_by_title_url( $sec[ 'title_url' ] );
               $sec[ 'questions' ] = $questions;
          }
          array_push( $new_sections, $sec );
     }
}
$sections = $new_sections;
?>
<div class="design-container">
     <ul class="design-fixed">
          <li class="design-title"> <a href="javascript:void(0)" onClick="duplicateSurvey('<?php echo $survey[0]['title_url'];?>')"><span class="edit-button">Duplicate</span></a> <a href="javascript:void(0)" onClick="controlSurvey('<?php echo $survey[0]['title_url'];?>')"><span class="edit-button">Control</span></a> <a href="javascript:void(0)" onClick="lengthsSurvey('<?php echo $survey[0]['title_url'];?>')"><span class="edit-button">Lengths</span></a> <a href="javascript:void(0)" onClick="compileSurvey('<?php echo $survey[0]['title_url'];?>')"><span class="edit-button">Compile Code</span></a> <a href="javascript:void(0)" onClick="editSurveyStyle('<?php echo $survey[0]['title_url'];?>')"><span class="edit-button">Style</span></a> <a href="javascript:void(0)" onClick="editSurvey('<?php echo $survey[0]['title_url'];?>')"><span class="edit-button">Edit</span></a> <?php echo $survey[0]['title'];?> </li>
     </ul>
     <ul class="dragndrop">
          <?php foreach($sections as $sec){?>
          <li id="<?php echo $sec['id'];?>" class="design-section">
               <div> <a href="javascript:void(0)" onClick="toggleSection(this)"><i class="fa fa-caret-down"></i></a> 
                    <!--<img src="<?php echo base_url(); ?>theme/images/section_logo.png" title="SECTION" />--> 
                    <a href="javascript:void(0)" onClick="editSectionStyle('<?php echo $sec['title_url'];?>')"><span class="edit-button">Style</span></a> <a href="javascript:void(0)" onClick="delSection('<?php echo $sec['title_url'];?>')"><span class="edit-button">Del</span></a> <a href="javascript:void(0)" onClick="editSection('<?php echo $sec['title_url'];?>')"><span class="edit-button">Edit</span></a> <a href="javascript:void(0)" onClick="duplicateSection('<?php echo $sec['title_url'];?>')"><span class="edit-button">Duplicate</span></a> <?php echo $sec['title'];?> </div>
               <ul class="dragndrop1">
                    <?php foreach($sec['questions'] as $sec_question){?>
                    <li id="<?php echo $sec_question['id'];?>" data-section="<?php echo $sec['title_url'];?>" class="design-question">
                         <div class="qpanel">
                              <?php if($sec_question['complete']=="0"){?>
                              <a class="done_question" href="javascript:void(0)" onClick="completeQuestion(this,'<?php echo $sec_question['id'];?>')"><span class="edit-question-button">Complete</span></a>
                              <?php }else{ ?>
                              <a href="javascript:void(0)" onClick="codeQuestionWizard(this,'<?php echo $sec_question['id'];?>')"><span class="edit-question-button">Wizard</span></a> <a href="javascript:void(0)" onClick="codeQuestion(this,'<?php echo $sec_question['id'];?>')"><span class="edit-question-button">Code</span></a> <a href="javascript:void(0)" onClick="lengthQuestion(this,'<?php echo $sec_question['id'];?>')"><span class="edit-question-button">Length</span></a> <a href="javascript:void(0)" onClick="editQuestionStyle('<?php echo $sec_question['id'];?>')"><span class="edit-question-button">Style</span></a> <a href="javascript:void(0)" onClick="delQuestion('<?php echo $sec_question['id'];?>','<?php echo $sec['title_url'];?>')"><span class="edit-question-button">Del</span></a> <a href="javascript:void(0)" onClick="editQuestion('<?php echo $sec_question['id'];?>')"><span class="edit-question-button">Edit</span></a> <a href="javascript:void(0)" onClick="duplicateQuestion('<?php echo $sec_question['id'];?>')"><span class="edit-question-button">Duplicate</span></a>
                              <?php } ?>
                         </div>
                         <div class="question">
                              <?php
                              $data = array(
                                   'sd' => $sec_question
                              );
                              $this->load->view( 'design_question', $data );
                              ?>
                         </div>
                    </li>
                    <?php } ?>
               </ul>
               <ul class="design-fixed">
                    <li class="design-question"> <a href="javascript:void(0)" onClick="chooseQuestionFrom('<?php echo $sec['title_url'];?>')"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Question</a> </li>
               </ul>
          </li>
          <?php }?>
     </ul>
     <ul class="design-fixed">
          <li class="design-section"> <a href="javascript:void(0)" onClick="createSection('<?php echo $survey[0]['title_url'];?>')"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Section</a> </li>
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
					//console.log($("#form_data_code").serialize());
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
<script src="<?php echo base_url();?>theme/js/code_wizard.js<?php echo "?".time(); ?>"></script> 
<script src="<?php echo base_url();?>theme/js/cspro_validation1.0_definition.js"></script> 
<!--<script src="<?php echo base_url();?>theme/js/cspro_validation1.0.js"></script>--> 
<script type="text/javascript">			//necessary for having same position while designing
$(window).scroll(function () {
	if($(window).scrollTop()!=0){
		//set scroll position in session storage
		sessionStorage.scrollPos = $(window).scrollTop();
		//console.log(sessionStorage.scrollPos);
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
<!--<link href="<?php echo base_url(); ?>theme/bootstrap4/bootstrap.min.css" rel="stylesheet" />-->
<!--<script src="<?php echo base_url(); ?>theme/bootstrap4/bootstrap.min.js"></script> -->

<!--<link href="<?php echo base_url(); ?>theme/bootstrap4/bootstrap-select.min.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>theme/bootstrap4/bootstrap-select.min.js"></script> 
<script>
	$(document).ready(function() {
		$('.selectpicker').selectpicker('refresh');
	});
</script>-->