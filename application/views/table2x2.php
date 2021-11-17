<?php
//print_r($indicators);
//print_r($rows);
//print_r($columns);
$row_array=array();
$col_array=array();
$distinct_rows=array();
$distinct_columns=array();
$rows_total=0;

$query1=$this->db->query("select ".$rows." from analytics_".$survey_id);
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
}
$distinct_rows=array_unique($row_array);
$distinct_columns=array_unique($col_array);
sort($distinct_rows);
sort($distinct_columns);
//print_r($distinct_rows);
//print_r($distinct_columns);
?>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tbody>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td align="center" colspan="<?php echo sizeof($distinct_columns); ?>"><strong><?php echo $columns." ".$indicators[$columns]; ?></strong></td>
	  <td><strong>Total</strong></td>
	</tr>
	<tr>
	  <td style="vertical-align:middle;width:100px;" rowspan="<?php echo (sizeof($distinct_rows)+1); ?>"><strong><?php echo $rows." ".$indicators[$rows]; ?></strong></td>
	  <td>&nbsp;</td>
	  <?php foreach($distinct_columns as $dc){ ?>
	  <td><?php echo $dc; ?></td>
	  <?php } ?>
	  <td>&nbsp;</td>
	</tr>
	<?php foreach($distinct_rows as $dr){ ?>
	<tr>
	  <td><?php echo $dr; ?></td>
		<?php 
		$row_total=0;
		$col_total=0;
		foreach($distinct_columns as $dc){
			$count_query=$this->db->query("select count(*) as total,$rows,$columns from analytics_".$survey_id." where ".$columns."='".$dc."' && ".$rows."='".$dr."'");
			if($count_query->num_rows()>0){
				$count_query=$count_query->result_array();
				if(!$count_query[0]['total']<1){
					$row_total=($row_total+$count_query[0]['total']);
					echo '<td>'.$count_query[0]['total'].'</td>';
				}else{
					echo '<td>0</td>';
				}
			}
		}
		echo '<td><strong>'.$row_total.'</strong></td>';
		$rows_total=($rows_total+$row_total);
		?>
	</tr>
	<?php } ?>
	<tr>
	  <td><strong>Total</strong></td>
	  <td>&nbsp;</td>
		<?php 
		foreach($distinct_columns as $dc){
			$count_query=$this->db->query("select count(*) as total,$rows,$columns from analytics_".$survey_id." where ".$columns."='".$dc."' && ".$rows." in ('".implode("','",$distinct_rows)."') ");
			if($count_query->num_rows()>0){
				$count_query=$count_query->result_array();
				if(!$count_query[0]['total']<1){
					$row_total=($row_total+$count_query[0]['total']);
					echo '<td><strong>'.$count_query[0]['total'].'</strong></td>';
				}else{
					echo '<td>0</td>';
				}
			}
		}
		echo '<td><strong>'.$rows_total.'</strong></td>';
		?>	  
	</tr>	
  </tbody>
</table>

