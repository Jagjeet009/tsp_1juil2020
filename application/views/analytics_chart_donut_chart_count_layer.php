<?php

$CI =& get_instance();
$CI->load->model('Analytics_model');
//print_r($data);

$all_data_columns=array();
if(isset($data['layer'])){
	$all_data_columns=array_merge($data['rows'],$data['layer']);
}else{
	$all_data_columns=$data['rows'];	
}

$layer_options=array();
if(isset($data['layer'])){
	$layer_options=$CI->Analytics_model->survey_data_options($data['indicators_dataid'][$data['layer'][0]],$data['layer'][0]);
}
//print_r($layer_options);

$rows_options=array();
if(isset($data['rows'])){
	$rows_options=$CI->Analytics_model->survey_data_options($data['indicators_dataid'][$data['rows'][0]],$data['rows'][0]);
}
//print_r($rows_options);

$entries=$CI->Analytics_model->survey_data_entries($data['survey_id'],$all_data_columns);
//print_r($entries);

if(sizeof($layer_options)<1){
	$layer_options=$CI->Analytics_model->fake_options($entries,$data['layer']);
	//print_r($layer_options);
}
if(sizeof($rows_options)<1){
	$rows_options=$CI->Analytics_model->fake_options($entries,$data['rows']);
	//print_r($rows_options);
}

$row_col_entries=array();
$temp_row=array();
foreach($rows_options as $ro_k=>$ro_v){
	$temp_col=array();
	foreach($layer_options as $co_k=>$co_v){	
		$count=0;
		foreach($entries as $e){
			if($e[$data['layer'][0]]!='' && $e[$data['rows'][0]]!=''){
				if($e[$data['layer'][0]]==$co_k && $e[$data['rows'][0]]==$ro_k){
					$count++;
				}
			}
		}
		$temp_col[$co_v]=$count;
	}
	$temp_row[$ro_v]=$temp_col;
}
$row_col_entries=$temp_row;
//print_r($row_col_entries);

$d1=array();
$temp_arr=array();
array_push($temp_arr,array($data['rows'][0],$data['layer'][0],"Counts"));
foreach($row_col_entries as $rce_k=>$rce_v){
	foreach($rce_v as $rce_v_k=>$rce_v_v){
		$temp_row_arr=array();
		array_push($temp_row_arr,$rce_k."");
		array_push($temp_row_arr,$rce_v_k);
		array_push($temp_row_arr,$rce_v_v);
	array_push($temp_arr,$temp_row_arr);
	}
	
}
//print_r($temp_arr);
/*$d1=array();
$temp_arr=array($data['rows'][0]);
foreach($layer_options as $co){
	array_push($temp_arr,$co);
}
//print_r($temp_arr);
array_push($d1,$temp_arr);

foreach($row_col_entries as $entry_k=>$entry_v){
	$temp_arr=array();
	array_push($temp_arr,$entry_k);
	foreach($entry_v as $ev_k=>$ev_v){
		if(is_numeric($ev_v)){
			array_push($temp_arr,(int) $ev_v);
		}else{
			array_push($temp_arr,$ev_v);
		}
	}
	array_push($d1,$temp_arr);
}
*/
$d1=$temp_arr;
$d1=json_encode($d1);
//print_r($d1);
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
<?php if(!isset($data['layer'])){?>
<style type="text/css">#slider_div<?php echo $rand ?>{display:none;}</style>
<?php } ?>
<div id="<?php echo $rand ?>" class="columnchart_values">
    <div id="slider_div<?php echo $rand ?>"></div>
	<div id="categoryPicker_div<?php echo $rand ?>"></div>
	<div id="chart_div<?php echo $rand ?>"></div>
	<div class="tmp_image_container" id="tmp_image_container<?php echo $rand ?>"></div>
</div>
<script type="text/javascript">
	google.charts.setOnLoadCallback(drawMainDashboard<?php echo $rand ?>);
	function drawMainDashboard<?php echo $rand ?>() {
		var dashboard = new google.visualization.Dashboard(
			document.getElementById('<?php echo $rand ?>'));
		var default_colors = ['#3366CC','#DC3912','#FF9900','#109618','#990099','#3B3EAC','#0099C6','#DD4477','#66AA00','#B82E2E','#316395','#994499','#22AA99','#AAAA11','#6633CC','#E67300','#8B0707','#329262','#5574A6','#3B3EAC'];		
		
		<?php if(sizeof($layer_options)<1){?>		
		var slider = new google.visualization.ControlWrapper({
		  'controlType': 'NumberRangeFilter',
		  'containerId': 'slider_div<?php echo $rand ?>',
		  'options': {
			'filterColumnIndex': <?php if(!isset($data['layer'])){echo 1;}else{echo 2;}?>,
			'ui': {
			  'labelStacking': 'horizontal',//vertical,horizontal
			  'label': '<?php if(isset($data['layer'])){echo $data['indicators'][$data['layer'][0]];} ?>:'
			},
			hAxis: { 
				title: 'Variables'
				//direction:-1, 
				//slantedText:true, 
				//slantedTextAngle:20

				//count: -1, 
				//viewWindowMode: 'pretty', 
				//slantedText: false,
				//textPosition : 'none'
			},				
		  }
		});
		<?php } ?>	

		<?php if(isset($data['layer']) && sizeof($layer_options)>0){?>	
		var categoryPicker = new google.visualization.ControlWrapper({
		  'controlType': 'CategoryFilter',
		  'containerId': 'categoryPicker_div<?php echo $rand ?>',
		  'options': {
			'filterColumnIndex': 1,
			'ui': {
				'labelStacking': 'horizontal',	//vertical,horizontal
				'label': '<?php if(isset($data['layer'])){echo $data['layer'][0]." ".$data['indicators'][$data['layer'][0]];} ?>:',
				'allowTyping': false,
				'allowMultiple': false,
				'sortValues': false,
				'allowNone': false				
			}
		  }
		});
		<?php } ?>	

		var area = new google.visualization.ChartWrapper({
		  'chartType': 'PieChart',
		  'containerId': 'chart_div<?php echo $rand ?>',
		  'options': {
			'colors': default_colors,
			'width': '800',
			'height': '370',
			'legend': 'right',
			'title': '<?php echo $data['rows'][0]." ".$data['indicators'][$data['rows'][0]]; ?>',
			tooltip: {trigger: 'none'},	  
			//'chartArea': {'left': 15, 'top': 15, 'right': 0, 'bottom': 0},
			'chartArea': {'width': '100%', 'height': '80%'},
			'pieSliceText': 'value',		//value percentage
			'pieHole':0.4
		  },
		  'view': {'columns': [0, 2]}
		});		

		var data = google.visualization.arrayToDataTable(<?php echo $d1; ?>);
		
		dashboard.bind([<?php if(sizeof($layer_options)<1){?>slider<?php }else{ ?>categoryPicker<?php } ?>], [area]);	///slider, categoryPicker
		dashboard.draw( data);
		
		google.visualization.events.addListener(area, 'select', function () {
			var chart=area.getChart();
			var selectedItem = chart.getSelection()[0];
			var color=document.querySelectorAll('#select_color')[0].value;
			if(color!=''){
				default_colors[selectedItem.row]=color;
			}
			area.draw();
		});		
		google.visualization.events.addListener(area, 'ready', function () {
			//console.log('ready');
			var chart=area.getChart();
			var c=document.getElementById('tmp_image_container<?php echo $rand ?>');
			document.querySelectorAll(".tmp_img").forEach(e => e.parentNode.removeChild(e));
			var img=document.createElement('img');
			img.src=chart.getImageURI();
			img.className='tmp_img';
			c.appendChild(img);	
			c.setAttribute('data-image', chart.getImageURI());				

		});			
	}
</script>
