<?php
$data=array(
	'rows' => $rows,
	'survey_id' => $survey_id,
	'indicators' => $indicators,
	'indicators_dataid' => $indicators_dataid
);
//escapting if layer is selected in starting to layer file
if(isset($data['layer']) && sizeof($data['layer'])>0){
	$this->load->view("analytics_chart_donut_chart_count_layer",$data);
	die;
}
$CI =& get_instance();
$CI->load->model('Analytics_model');
//print_r($data);

$all_data_columns=array();
if(isset($data['layer'])){
	$all_data_columns=array_merge($data['rows'],$data['layer']);
}else{
	$all_data_columns=$data['rows'];	
}


$rows_options=array();
if(isset($data['rows']) && sizeof($data['rows'])>0){
	$rows_options=$CI->Analytics_model->survey_data_options($data['indicators_dataid'][$data['rows'][0]],$data['rows'][0]);
}
//print_r($rows_options);

$entries=$CI->Analytics_model->survey_data_entries($data['survey_id'],$all_data_columns);
	//print_r($entries);	

if(sizeof($rows_options)<1 && sizeof($all_data_columns)>0){
	$ro=array();
	foreach($entries as $e_k=>$e_v){
		foreach($e_v as $e_v_k=>$e_v_v){
			if($e_v_v!=""){
				array_push($ro,$e_v_v);
			}
		}
	}
	//print_r($ro);
	$ro=array_unique($ro);
	//print_r($ro);	
	foreach($ro as $r){
		$rows_options[$r]=$r;
	}
	//print_r($rows_options);	
}

$row_col_entries=array();
$temp_row=array();
foreach($rows_options as $ro_k=>$ro_v){
	$count=0;
	foreach($entries as $e){
		if($e[$data['rows'][0]]==$ro_k){
			$count++;
		}
	}
	$temp_row[$ro_v]=$count;
}
$row_col_entries=$temp_row;
//print_r($row_col_entries);

$d1=array();
foreach($row_col_entries as $rce_k=>$rce_v){
	$temp_arr=array("text"=>$rce_k,"weight"=>$rce_v);
	array_push($d1,$temp_arr);
}
$d1=json_encode($d1);
//print_r($d1);die;

$salt = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
$rand = '';
$i = 0;
$length = 5;
while ($i < $length) { // Loop until you have met the length
$num = rand() % strlen($salt);
$tmp = substr($salt, $num, 1);
$rand = $rand . $tmp;
$i++;
}
//echo $rand;
?>	
<style type="text/css">
div.jqcloud span.w10 {color:#6b2060;}
div.jqcloud span.w9 {color:#721d60;}
div.jqcloud span.w8 {color:#473862;}
div.jqcloud span.w7 {color:#3c672d;}
div.jqcloud span.w6 {color:#567a7c;}
div.jqcloud span.w5 {color:#5c3d47;}
div.jqcloud span.w4 {color:#5c2f4b;}
div.jqcloud span.w3 {color:#a78297;}
div.jqcloud span.w2 {color:#365952;}
div.jqcloud span.w1 {color:#96b1ac;}
</style>
<div id="<?php echo "wc_".$rand ?>" style="position:relative !important;width: 900px; height: 400px;" class="columnchart_values"></div>    
<script type="text/javascript">
	/*var word_array = [
		{text: "mark", weight: 8},
		{text: "zuckerberg", weight: 4},
		{text: "money", weight: 2},
		{text: "man", weight: 2},
		{text: "and", weight: 7},
		{text: "having", weight: 1},
		{text: "apart", weight: 8},
		{text: "rich", weight: 2},
		{text: "of", weight: 3},
		{text: "world", weight: 2},
		{text: "less", weight: 1}		      
	];*/
	/*var word_array = [{"text":"DHDJDID","weight":1},{"text":"FUNGI","weight":1},{"text":"SJSJSS","weight":1},{"text":"DAKTAR","weight":1},{"text":"RAJA","weight":1},{"text":"DEEPU","weight":1},{"text":"SITA","weight":1},{"text":"ARUN","weight":1},{"text":"SEEMA","weight":1},{"text":"NAMAN","weight":1},{"text":"ARPIT","weight":1},{"text":"GITA","weight":1},{"text":"BABU","weight":1},{"text":"SENA","weight":1},{"text":"KING","weight":1},{"text":"KALPANA","weight":1},{"text":"KABIR","weight":1},{"text":"MUNESH","weight":1},{"text":"NAVED","weight":1},{"text":"MANU","weight":1},{"text":"SHSHSH","weight":1},{"text":"RAMAKANTAPRADAHAN","weight":1},{"text":"HARIHARBHOI","weight":1},{"text":"KAMALAKANTAPRADHAN","weight":1},{"text":"SISIRAPRADHAN","weight":1},{"text":"RASUKPRADHAN","weight":1}];*/
	var word_array = <?php echo $d1;?>;
	word_array=JSON.stringify(word_array);	
	var el=document.getElementById("<?php echo "wc_".$rand ?>");
	el.setAttribute('data-word_array', word_array);	
</script>