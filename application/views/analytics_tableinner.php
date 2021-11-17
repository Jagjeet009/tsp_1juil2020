<?php
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
if(isset($indicators_dataid[$rows]) && isset($rows)){
	$row_options=$CI->Analytics_model->survey_data_options($indicators_dataid[$rows],$rows);
	//print_r($row_options);
}
if(isset($indicators_dataid[$columns]) && isset($columns)){
	$col_options=$CI->Analytics_model->survey_data_options($indicators_dataid[$columns],$columns);
	//print_r($col_options);
}
if(isset($indicators_dataid[$rows]) && isset($survey_id) && isset($rows)){
	$row_array=$CI->Analytics_model->survey_data_rowarray($indicators_dataid[$rows],$survey_id,$rows);
	//print_r($row_array);
}
if(isset($indicators_dataid[$columns]) && isset($survey_id) && isset($columns)){
	$col_array=$CI->Analytics_model->survey_data_rowarray($indicators_dataid[$columns],$survey_id,$columns);
	//print_r($col_array);
}

$distinct_rows=array_unique($row_array);
$distinct_columns=array_unique($col_array);
sort($distinct_rows);
sort($distinct_columns);

if(isset($indicators_dataid[$rows]) && isset($survey_id) && isset($rows)){
	$new_rows=$CI->Analytics_model->survey_data_new_columns($indicators_dataid[$rows],$survey_id,$rows);
	//print_r($new_rows);
}
if(isset($indicators_dataid[$columns]) && isset($survey_id) && isset($columns)){
	$new_cols=$CI->Analytics_model->survey_data_new_columns($indicators_dataid[$columns],$survey_id,$columns);
	//print_r($new_cols);
}
if(isset($survey_id) && isset($new_rows) && isset($new_cols) && isset($distinct_rows) && isset($distinct_columns)){
	$row_col_data=$CI->Analytics_model->survey_data_data($survey_id,$new_rows,$new_cols,$distinct_rows,$distinct_columns);
	//print_r($row_col_data);
}
/*$query1=$this->db->query("select ".$rows." from analytics_".$survey_id);
if($query1->num_rows()>0){
	$query1=$query1->result_array();
	foreach($query1 as $query11){
		if($query11[$rows]!=''){
			array_push($row_array,$query11[$rows]);
		}
	}
}
$query2=$this->db->query("select ".$columns." from analytics_".$survey_id);
if($query2->num_rows()>0){
	$query2=$query2->result_array();
	foreach($query2 as $query22){
		if($query22[$columns]!=''){
			array_push($col_array,$query22[$columns]);
		}
	}
}*/

//print_r($distinct_rows);
//print_r($distinct_columns);

$size_distinct_columns=sizeof($distinct_columns);
if($row_percent==1){
	$size_distinct_columns=$size_distinct_columns+sizeof($distinct_columns);
}
if($col_percent==1){
	$size_distinct_columns=$size_distinct_columns+sizeof($distinct_columns);
}
?>
<table class="inner <?php echo $innerClass; ?>" width="100%" border="1" cellspacing="0" cellpadding="0">
  <tbody>
	<tr>
	  <td>&nbsp;</td>
	  <?php foreach($distinct_columns as $dc){ ?>
	  <td><?php if(isset($col_options[$dc])){echo $col_options[$dc];}else{echo $dc;} ?></td>
	  <?php if($row_percent==1){ ?><td>Row %</td><?php } ?>
	  <?php if($col_percent==1){ ?><td>Col %</td><?php } ?>
	  <?php } ?>
	  <td><strong>Total</strong></td>
	  <?php if($row_percent==1){ ?><td>Row %</td><?php } ?>
	  <?php if($col_percent==1){ ?><td>Col %</td><?php } ?>
	</tr>
	<?php foreach($distinct_rows as $dr){ ?>
	<tr>
	  <td><?php if(isset($row_options[$dr])){echo $row_options[$dr];}else{echo $dr;} ?></td>
		<?php 
		$row_total=0;
		$col_total=0;
		foreach($distinct_columns as $dc){
			if($row_col_data[$dr][$dc]>0){
				$row_total=($row_total+$row_col_data[$dr][$dc]);
				echo '<td>'.$row_col_data[$dr][$dc].'</td>';
			}else{
				echo '<td>0</td>';
			}
			if($row_percent==1){echo '<td class="row-percent">rp</td>';}
			if($col_percent==1){echo '<td class="col-percent">cp</td>';}
		}
		echo '<td class="row-total"><strong>'.$row_total.'</strong></td>';
		$rows_total=($rows_total+$row_total);
		if($row_percent==1){echo '<td class="row-percent">rpt</td>';}
		if($col_percent==1){echo '<td class="col-percent">cpt</td>';}										 
		?>
	</tr>
	<?php } ?>
	<tr>
	  <td><strong>Total</strong></td>
		<?php 
		for($j=0;$j<sizeof($distinct_columns);$j++){
			$row_total=0;
			for($i=0;$i<sizeof($distinct_rows);$i++){
				$row_total=($row_total+$row_col_data[$distinct_rows[$i]][$distinct_columns[$j]]);
			}
			if($row_total>0){
				echo '<td class="col-total"><strong>'.$row_total.'</strong></td>';
			}else{
				echo '<td>0</td>';
			}
		if($row_percent==1){echo '<td class="row-percent">rptt</td>';}
		if($col_percent==1){echo '<td class="col-percent">cptt</td>';}				
		}
		echo '<td class="row-total col-total"><strong>'.$rows_total.'</strong></td>';
		if($row_percent==1){echo '<td class="row-percent">rpttt</td>';}
		if($col_percent==1){echo '<td class="col-percent">cpttt</td>';}			
		?>	  
	</tr>					
  </tbody>
</table>		

