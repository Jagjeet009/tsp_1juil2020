<?php
//print_r($indicators);
//print_r($rows);
//print_r($columns);
//print_r($layer);
//print_r($row_percent);
//print_r($col_percent);
$row_array=array();
$col_array=array();
$layer_array=array();
$distinct_rows=array();
$distinct_columns=array();
$rows_total=0;
$row_options=array();
$col_options=array();
$layer_options=array();

$CI =& get_instance();
$CI->load->model('Analytics_model');
$row_options=$CI->Analytics_model->survey_data_options($indicators_dataid[$rows],$rows);
//print_r($row_options);
$col_options=$CI->Analytics_model->survey_data_options($indicators_dataid[$columns],$columns);
//print_r($col_options);
$layer_options=$CI->Analytics_model->survey_data_options($indicators_dataid[$layer],$layer);
//print_r($layer_options);
$row_array=$CI->Analytics_model->survey_data_rowarray($indicators_dataid[$rows],$survey_id,$rows);
//print_r($row_array);
$col_array=$CI->Analytics_model->survey_data_rowarray($indicators_dataid[$columns],$survey_id,$columns);
//print_r($col_array);
$layer_array=$CI->Analytics_model->survey_data_rowarray($indicators_dataid[$layer],$survey_id,$layer);
//print_r($layer_array);

$distinct_rows=array_unique($row_array);
$distinct_columns=array_unique($col_array);
$distinct_layer=array_unique($layer_array);
sort($distinct_rows);
sort($distinct_columns);
sort($distinct_layer);

$new_rows=$CI->Analytics_model->survey_data_new_columns($indicators_dataid[$rows],$survey_id,$rows);
//print_r($new_rows);
$new_cols=$CI->Analytics_model->survey_data_new_columns($indicators_dataid[$columns],$survey_id,$columns);
//print_r($new_cols);
$new_layer=$CI->Analytics_model->survey_data_new_columns($indicators_dataid[$layer],$survey_id,$layer);
//print_r($new_layer);
$row_col_data=$CI->Analytics_model->survey_data_data($survey_id,$new_rows,$new_cols,$distinct_rows,$distinct_columns);
//print_r($row_col_data);
//print_r($distinct_rows);
//print_r($distinct_columns);
//print_r($distinct_layer);

$size_distinct_columns=sizeof($distinct_columns);
if($row_percent==1){
	$size_distinct_columns=$size_distinct_columns+sizeof($distinct_columns);
}
if($col_percent==1){
	$size_distinct_columns=$size_distinct_columns+sizeof($distinct_columns);
}
//print_r($distinct_rows);
//print_r($new_rows);

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
<link rel="stylesheet" type="text/css" href="<?php echo base_url()."theme/css/"; ?>table_tempate1.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()."theme/css/"; ?>table_tempate2.css"/>

<table id="<?php echo $rand ?>" class="outer compact nowrap" width="100%" border="1" cellspacing="0" cellpadding="10">
  <tbody>
    <tr>
      <td><strong><?php echo $rows." ".$indicators[$rows]; ?></strong></td>
      <td>&nbsp;</td>
      <td><strong><?php echo $columns." ".$indicators[$columns]; ?></strong></td>
    </tr>
	<?php 
	  foreach($distinct_rows as $dr){
		  $rows_total=0;
		  $cols_total_array=array();
	?>
	<?php
		if($dr!=''){
			$row_where='';
			for($i=0;$i<sizeof($new_rows);$i++){
				if($i==0){
					$row_where.=" ".$new_rows[$i]."='".$dr."' ";
				}else{
					$row_where.=" || ".$new_rows[$i]."='".$dr."' ";
				}
			}	
		}
	?>
	<tr>
	  <td><?php if(isset($row_options[$dr])){echo $row_options[$dr];}else{echo $dr;} ?></td>
	  <td><strong><?php echo $layer." ".$indicators[$layer]; ?></strong></td>
	  <td class="nested">
		<table class="inner" width="100%" border="1" cellspacing="0" cellpadding="0">
		  <tbody>
			<tr>
			  <td>&nbsp;</td>
				<?php 
				foreach($distinct_columns as $dc){ 
				$cols_total_array[$dc]=0;
				?>
			  <td><?php if(isset($col_options[$dc])){echo $col_options[$dc];}else{echo $dc;} ?></td>
			  <?php if($row_percent==1){ ?><td>Row %</td><?php } ?>
			  <?php if($col_percent==1){ ?><td>Col %</td><?php } ?>
			  <?php } ?>
			  <td><strong>Total</strong></td>
			  <?php if($row_percent==1){ ?><td>Row %</td><?php } ?>
			  <?php if($col_percent==1){ ?><td>Col %</td><?php } ?>
			</tr>
			<?php foreach($distinct_layer as $dl){ ?>
			<?php
				if($dl!=''){
					$layer_where='';
					for($k=0;$k<sizeof($new_layer);$k++){
						if($k==0){
							$layer_where.=" ".$new_layer[$k]."='".$dl."' ";
						}else{
							$layer_where.=" || ".$new_layer[$k]."='".$dl."' ";
						}
					}	
				}
			?>
			<tr>
			  <td><?php if(isset($layer_options[$dl])){echo $layer_options[$dl];}else{echo $dl;}; ?></td>
				<?php 
				$row_total=0;
				foreach($distinct_columns as $dc){
					if($dc!=''){
						$col_where='';
						for($j=0;$j<sizeof($new_cols);$j++){
							if($j==0){
								$col_where.=" ".$new_cols[$j]."='".$dc."' ";
							}else{
								$col_where.=" || ".$new_cols[$j]."='".$dc."' ";
							}
						}	
					}
					$count_query=$this->db->query("select count(*) as total,".implode(',',$new_rows).",".implode(',',$new_cols).",".implode(',',$new_layer)." from analytics_".$survey_id." where 1=1 && (".$row_where.") && (".$col_where.") && (".$layer_where.")");
					if($count_query->num_rows()>0){
						$count_query=$count_query->result_array();
						if(!$count_query[0]['total']<1){
							$row_total=($row_total+$count_query[0]['total']);
							$cols_total_array[$dc]=($cols_total_array[$dc]+$count_query[0]['total']);
							echo '<td>'.$count_query[0]['total'].'</td>';
						}else{
							echo '<td>0</td>';
						}
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
				foreach($distinct_columns as $dc){
					echo '<td class="col-total">'.$cols_total_array[$dc].'</td>';
					/*$row_total=0;
					$count_query=$this->db->query("select count(*) as total,".implode(',',$new_rows).",".implode(',',$new_cols)." from analytics_".$survey_id." where 1=1 && (".$row_where.") && (".$col_where.")");
					if($count_query->num_rows()>0){
						$count_query=$count_query->result_array();
						if(!$count_query[0]['total']<1){
							$row_total=($row_total+$count_query[0]['total']);
							echo '<td class="col-total"><strong>'.$count_query[0]['total'].'</strong></td>';
						}else{
							echo '<td>0</td>';
						}
					}*/
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
		<?php //print_r($cols_total_array);?>		  	
	  </td>
	</tr>
	<?php } ?>
  </tbody>
</table>


