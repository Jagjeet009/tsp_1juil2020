<style type="text/css">
#attachSurveyModal .modal-body table.attach-table>td{height:20px !important;font-size:15px !important;}	
#attachSurveyModal .modal-body table.attach-table>th{margin:0;padding:0;}
#attachSurveyModal .modal-body input[type="text"]{margin:0;}
</style>
<?php
//print_r($surveys);
//print_r($surveys_list);
//print_r($user_data);
//print_r($surveys_design_list);
//print_r($surveys_fill_list);
//print_r($surveys_analytics_list);
//print_r($user_list);
//print_r($design_list);
//print_r($fill_list);
//print_r($analytics_list);
?>
<div class="analytics-container">
	<div class="analytics-panel">
		<ul class="tabs clearfix">
			<li <?php if($data_analytics=="" || $data_analytics=="dataview"){echo 'class="active"';} ?>><a href="<?php echo base_url()."dataview"; ?>">Data View</a></li>
			<li <?php if($data_analytics=="dataeditor"){echo 'class="active"';} ?>><a href="<?php echo base_url()."dataeditor"; ?>">Data Editor</a></li>
			<li <?php if($data_analytics=="dataanalyzer"){echo 'class="active"';} ?>><a href="<?php echo base_url()."dataanalyzer"; ?>">Analyser</a></li>
		</ul>
		<h2 class="analytics-head">Survey - <?php echo $survey[0]['title']; ?> 
			<?php if($data_analytics=="dataeditor"){ ?>
			<?php
			$q=$this->db->query("select filename from survey_values_backups where survey_id='".$survey[0]['title_url']."' && status='1' ");
			if($q->num_rows()>0){
				$q=$q->result_array();
				$q=$q[0]['filename'];
				$q=str_replace('.json','',$q);
				$q=str_replace($survey[0]['title_url'].'_','',$q);	
				$q=str_replace($user_data[0]['username']."_",'',$q);
				$q=str_replace('_',' ',$q);
			}else{
				$q='';
			}
			?>
			<?php if($q!=''){?>
			<span class="analytics-head-inner">[ Backup - <?php echo $q; ?> ]</span>
			<?php } ?>
			<ul class="analytics-options-new">
				<li><a href="javascript:void(0)" onclick="confirmExcelCsvJsonSps('<?php echo $survey[0]['title_url']; ?>')">Export</a></li>
				<li><a href="javascript:void(0)" onclick="analyticsExcelUpload('<?php echo $survey[0]['title_url']; ?>')">Upload</a></li>
				<li><a href="javascript:void(0)" onclick="attachSurvey('<?php echo $survey[0]['title_url']; ?>')">Attach</a></li>
				<li><a href="javascript:void(0)" onclick="saveAnalyticsTableInJson('<?php echo $survey[0]['title_url']; ?>')">Backup</a></li>
				<li class="i"><a href="javascript:void(0)">Load</a>
					<ul class="sub-menu">
						<?php
						$load_file=$this->db->query("select * from survey_values_backups where survey_id='".$survey[0]['title_url']."' order by id desc ");
						//echo $this->db->last_query();
						if($load_file->num_rows()>0){
							$load_file=$load_file->result_array();
							$nlf='';
							foreach($load_file as $lf){
								if(isset($lf['filename'])){
								//print_r($lf['filename']);
								$nlf=str_replace('.json','',$lf['filename']);
								//echo $nlf."\r\n";
								$nlf=str_replace($survey[0]['title_url'].'_','',$nlf);
								//echo $nlf."\r\n";
								}else{
									$nlf='';
								}
						?>
								<li>
								<a href="javascript:void(0)" onclick="loadAnalyticsTableFromJson('<?php echo $survey[0]['title_url']; ?>','<?php echo $lf['filename']; ?>')"><?php echo $nlf; ?></a>
								<a href="javascript:void(0)" onclick="removeAnalyticsTableJson('<?php echo $survey[0]['title_url']; ?>','<?php echo $lf['filename']; ?>')">Delete</a>
								</li>
						<?php }} ?>
					</ul>					
				</li>				
				<li><a href="javascript:void(0)" onclick="computeRecode('<?php echo $survey[0]['title_url']; ?>')">Compute & Recode</a></li>
			</ul>
			<?php } ?>
		</h2>
		<div class="analytics-frame">
			<?php 
			$data=array(
				'survey' => $survey
			);
			if($data_analytics=="" || $data_analytics=="dataview"){
				$this->load->view('analytics_survey_dataview',$data);
			}else if($data_analytics=="dataeditor"){
				$this->load->view('analytics_survey_dataeditor',$data);
			}else if($data_analytics=="dataanalyzer"){
				$this->load->view('analytics_survey_dataanalyzer',$data);
			}else{}
			?>
		</div>
	</div>
</div>
<script type="text/javascript">
function analyticsExcelUpload(survey_id){
	$('#analyticsExcelUploadModal').modal('show');
	$('#analyticsExcelUploadModal [name="survey_id"]').val(survey_id);
}	
function confirmExcelCsvJsonSps(url){
	var a=prompt("1 for CSV\n2 for Excel\n3 for JSON\n4 for Sps\n5 for Txt");
	if(a==="1"){
		window.location.href="<?php echo base_url().'survey/export/'; ?>"+url+"/CSV";
	}else if(a==="2"){
		window.location.href="<?php echo base_url().'survey/export/'; ?>"+url+"/Excel";
	}else if(a==="3"){
		window.location.href="<?php echo base_url().'survey/export/'; ?>"+url+"/Json";
	}else if(a==="4"){
		window.location.href="<?php echo base_url().'survey/export/'; ?>"+url+"/Sps";
	}else if(a==="5"){
		window.location.href="<?php echo base_url().'survey/export/'; ?>"+url+"/TXT";
	}else{
		alert("Invalid Option");
	}
}
function saveAnalyticsTableInJson(url){
	var a=prompt("Name Your File");
	if(a!==""){
		window.location.href="<?php echo base_url().'survey/analytics/savejson/'; ?>"+url+"/"+a;
	}else{
		alert("Must Not Be Empty!");
	}
}	
function loadAnalyticsTableFromJson(url,filename){
	window.location.href="<?php echo base_url().'survey/analytics/loadjson/'; ?>"+url+"/"+filename;
}	
function removeAnalyticsTableJson(url,filename){
	if(confirm("Are You Sure! You Want To Delete!!") == true) {
		window.location.href="<?php echo base_url().'survey/analytics/removejson/'; ?>"+url+"/"+filename;
	}
}	
function computeRecode(survey_title_url){
	$('#computeRecodeModal').modal('show');
	$('#computeRecodeModal input[name="survey_title_url"]').val(survey_title_url);
	$.ajax({
		url: "<?php echo base_url(); ?>survey/table_columns/"+survey_title_url, // url where to submit the request
		type : "GET", // type of action POST || GET
		success : function(result) {
			$('#computeRecodeModal select[name="all_variable"]').html(result);
		},
		error: function(xhr, resp, text) {console.log(xhr, resp, text);}
	});
}
function insertAtCursor(myField, myValue) {
	myField=myField[0];
    //IE support
    if (document.selection) {
        myField.focus();
        sel = document.selection.createRange();
        sel.text = myValue;
    }
    //MOZILLA and others
    else if (myField.selectionStart || myField.selectionStart == '0') {
        var startPos = myField.selectionStart;
        var endPos = myField.selectionEnd;
        myField.value = myField.value.substring(0, startPos)
            + myValue
            + myField.value.substring(endPos, myField.value.length);
        myField.selectionStart = startPos + myValue.length;
        myField.selectionEnd = startPos + myValue.length;
    } else {
        myField.value += myValue;
    }
}
function saveComputeRecode(saveButton){
	var survey_title_url=$('#computeRecodeModal input[name="survey_title_url"]').val();
	var target_variable=$('#computeRecodeModal input[name="target_variable"]').val();
	var target_label=$('#computeRecodeModal input[name="target_label"]').val();
	var variable_property=$('#computeRecodeModal input[name="variable_property"]').val();
	var numerical_expression=$('#computeRecodeModal textarea[name="numerical_expression"]').val();
	if(survey_title_url!='' && target_variable!='' && numerical_expression!=''){
		$.ajax({
			url: "<?php echo base_url(); ?>survey/compute/"+survey_title_url, // url where to submit the request
			type : "POST", // type of action POST || GET
			data : {"survey_title_url":survey_title_url,"target_variable":target_variable,"target_label":target_label,"variable_property":variable_property,"numerical_expression":numerical_expression},
			success : function(result) {
				result=JSON.parse(result);
				setTimeout(function(){
					alert(result.msg);
					window.location.reload();
				}, 1000);
			},
			error: function(xhr, resp, text) {console.log(xhr, resp, text);}
		});
	}else{
		alert("Invalid computing fields!! ");
	}
}
function attachSurvey(survey_id){
	$('#attachSurveyModal').modal('show');
}	
function attachSurveyGet(survey_id1,survey_id2){
	callAjaxGet('<?php echo base_url()."survey/attach/"; ?>'+survey_id1+'/'+survey_id2,'attachSurveyModal');
}	
</script>
