<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php //echo current_url();?>  
<?php
$data = array(
	'survey_id' => $survey_id,
	'type' => $type,
	'key' => $key
);
if($type=="pie"){
	$this->view("analytics-pie",$data);	
}else if($type=="table"){
	$this->view("analytics-table",$data);	
}else if($type=="chart"){
	$this->view("analytics-chart",$data);	
}else{
	$this->view("analytics-map",$data);	
}
?>