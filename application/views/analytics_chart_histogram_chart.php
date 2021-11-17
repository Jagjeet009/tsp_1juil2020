<?php
$rows=$data['rows'][0];
$columns=$data['columns'][0];
$survey_id=$data['survey_id'];
$indicators=$data['indicators'];
$indicators_dataid=$data['indicators_dataid'];

//print_r($indicators);
//print_r($rows);
//print_r($columns);
//print_r($row_percent);
//print_r($col_percent);
$row_array=array();
$col_array=array();
$distinct_rows=array();
$distinct_columns=array();
$rows_total=0;
$row_options=array();
$col_options=array();

$CI =& get_instance();
$CI->load->model('Analytics_model');
$row_options=$CI->Analytics_model->survey_data_options($indicators_dataid[$rows],$rows);
//print_r($row_options);
$col_options=$CI->Analytics_model->survey_data_options($indicators_dataid[$columns],$columns);
//print_r($col_options);
$row_array=$CI->Analytics_model->survey_data_rowarray($indicators_dataid[$rows],$survey_id,$rows);
//print_r($row_array);
$col_array=$CI->Analytics_model->survey_data_rowarray($indicators_dataid[$columns],$survey_id,$columns);
//print_r($col_array);

$distinct_rows=array_unique($row_array);
$distinct_columns=array_unique($col_array);
sort($distinct_rows);
sort($distinct_columns);

$new_rows=$CI->Analytics_model->survey_data_new_columns($indicators_dataid[$rows],$survey_id,$rows);
//print_r($new_rows);
$new_cols=$CI->Analytics_model->survey_data_new_columns($indicators_dataid[$columns],$survey_id,$columns);
//print_r($new_cols);
$row_col_data=$CI->Analytics_model->survey_data_data($survey_id,$new_rows,$new_cols,$distinct_rows,$distinct_columns);
//print_r($row_col_data);

$d1="['Element',";
foreach($distinct_columns as $dc){
	if(isset($col_options[$dc])){
		$d1.="'".$col_options[$dc]."',";
	}else{
		$d1.="'".$dc."',";
	}
}
//$d1.="],\r\n";
$d1.="],";
foreach($row_col_data as $rd_k=>$rd_v){
	if(isset($row_options[$rd_k])){
		$d1.=" ['".$row_options[$rd_k]."', ";
	}else{
		$d1.=" ['".$rd_k."', ";
	}
	foreach($rd_v as $cd_k=>$cd_v){
		$d1.=" $cd_v, ";
	}
	//$d1.=" ],\r\n ";
	$d1.=" ], ";
}
$d1=trim($d1);
$d1=str_replace(PHP_EOL,"",$d1);
$d1=str_replace("\r","",$d1);
$d1=str_replace("\n","",$d1);
$d1=str_replace("\r\n","",$d1);
$d1=nl2br($d1);
$d1=str_replace("<br />","",$d1);

//print_r($distinct_rows);
//print_r($row_options);
//print_r($distinct_columns);
//print_r($col_options);
//print_r($row_col_data);
//echo $d1;
//die;
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
		<div id="<?php echo $rand ?>" class="columnchart_values" style="width: 99%; height: 99%;">Chart</div>
		
		<script type="text/javascript">
			//google.charts.load('current', {packages: ['corechart']});
			google.charts.setOnLoadCallback(drawMultSeries<?php echo $rand ?>);

			function drawMultSeries<?php echo $rand ?>() {
				var data = google.visualization.arrayToDataTable([
					<?php echo $d1; ?>
					/*['Element', 'energy','motivation','shade','size','more'],
					['jhon', 8.94,20,4,10,15],
					['rey', 10.49,43,7,8,20],
					['heinc', 19.30,23,10,6,33],
					['patric', 21.45,45,8,4,40],*/
				]);

				var options = {
					//title: 'Motivation and Energy Level Throughout the Day',
					hAxis: {
						title: '<?php echo $rows." ".$indicators[$rows]; ?>'
					},
					vAxis: {
						title: '<?php echo $columns." ".$indicators[$columns]; ?>'
					},
				};
				var c=document.getElementById('<?php echo $rand ?>');
				var chart = new google.visualization.Histogram(c);

				chart.draw(data, options);
				c.innerHTML=c.innerHTML+'<img style="display:none" src="' + chart.getImageURI() + '">';
			}
		</script>
