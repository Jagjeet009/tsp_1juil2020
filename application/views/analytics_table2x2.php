<?php
//print_r($indicators);
//print_r($indicators_dataid);
//print_r($rows);
//print_r($columns);

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

 <table id="<?php echo $rand ?>" class="outer compact nowrap" width="100%" border="1" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td>&nbsp;</td>
      <?php foreach($columns as $c){ ?>
      <td><strong><?php echo $c." ".$indicators[$c]; ?></strong></td>
      <?php } ?>
    </tr>
    <?php for($i=0;$i<sizeof($rows);$i++){ ?>
    <tr>
		<td style="vertical-align:middle"><strong><?php echo $rows[$i]." ".$indicators[$rows[$i]]; ?></strong></td>
		<?php for($j=0;$j<sizeof($columns);$j++){ ?>
			<?php
			$innerClass='';
			if($i==0 && $j==0){
				$innerClass='  ';
			}else if($i==0 && $j>0){
				$innerClass=' firstColumn ';
			}else if($i>0 && $j==0){
				$innerClass=' firstRow ';
			}else if($i>0 && $j>0){
				$innerClass=' firstColumn firstRow ';
			}else{$innerClass='';}
			?>
			<td class="nested"><?php
				$data=array(
					'innerClass' => $innerClass,
					'rows' => $rows[$i],
					'columns' => $columns[$j],
					'survey_id' => $survey_id,
					'indicators' => $indicators,
					'indicators_dataid' => $indicators_dataid,
					'row_percent' => $row_percent,
					'col_percent' => $col_percent
				);	
				$this->load->view('analytics_tableinner',$data);
			?></td>
		<?php } ?>
    </tr>
    <?php } ?>
  </tbody>
</table>
