<?php
//escapting if layer is selected in starting to layer file
if(isset($data['layer']) && sizeof($data['layer'])>0){
	$this->load->view("analytics_chart_stack_chart_percent_layer",$data);
	die;
}

$CI =& get_instance();
$CI->load->model('Analytics_model');
//print_r($data);

$all_data_columns=array();
if(isset($data['layer'])){
	$all_data_columns=array_merge($data['rows'],$data['columns'],$data['layer']);
}else if(isset($data['columns'])){
	$all_data_columns=array_merge($data['rows'],$data['columns']);	
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

$columns_options=array();
if(isset($data['columns'])){
	$columns_options=$CI->Analytics_model->survey_data_options($data['indicators_dataid'][$data['columns'][0]],$data['columns'][0]);
}
//print_r($columns_options);

$entries=$CI->Analytics_model->survey_data_entries($data['survey_id'],$all_data_columns);
//print_r($entries);

if(sizeof($rows_options)<1){
	$rows_options=$CI->Analytics_model->fake_options($entries,$data['rows']);
	//print_r($rows_options);
}
if(sizeof($columns_options)<1){
	$columns_options=$CI->Analytics_model->fake_options($entries,$data['columns']);
	//print_r($columns_options);
}

$columns_options_count=array();
foreach($columns_options as $co){
	$columns_options_count[$co]=0;
}
//print_r($columns_options_count);

$rows_options_count=array();
foreach($rows_options as $ro){
	$rows_options_count[$ro]=0;

}
//print_r($rows_options_count);

$row_col_entries=array();
$temp_row=array();
foreach($rows_options as $ro_k=>$ro_v){
	$temp_col=array();
	$r_count=0;
	foreach($columns_options as $co_k=>$co_v){
		$count=0;
		foreach($entries as $e){
			if($e[$data['columns'][0]]==$co_k && $e[$data['rows'][0]]==$ro_k){
				$count++;
				$r_count++;
			}
		}
		$temp_col[$co_v]=$count;
		if(array_key_exists($co_v,$columns_options_count)){
			$columns_options_count[$co_v]=($columns_options_count[$co_v]+$count);
		}
	}
	if(array_key_exists($ro_v,$rows_options_count)){
		$rows_options_count[$ro_v]=($rows_options_count[$ro_v]+$r_count);
	}	
	$temp_row[$ro_v]=$temp_col;
}
$row_col_entries=$temp_row;
//print_r($rows_options_count);
//print_r($row_col_entries);

$d1=array();
$temp_arr=array($data['rows'][0]);
foreach($columns_options as $co){
	array_push($temp_arr,$co);
}
//print_r($temp_arr);
array_push($d1,$temp_arr);

//print_r($columns_options_count);
//print_r($row_col_entries);

$tmp_c=array();
foreach($row_col_entries as $rce_k=>$rce_v){
	$tmp_r=array();
	foreach($rce_v as $rce_v_k=>$rce_v_v){
		//echo $rce_v_v."\r\n";
		if(array_key_exists($rce_k,$rows_options_count)){
			if($rows_options_count[$rce_k]>0){
				$tmp_r[$rce_v_k]=(($rce_v_v/$rows_options_count[$rce_k])*100);
				$tmp_r[$rce_v_k]=(float) number_format($tmp_r[$rce_v_k],1);
			}else{
				$tmp_r[$rce_v_k]=0;
				$tmp_r[$rce_v_k]=(float) number_format($tmp_r[$rce_v_k],1);				
			}
	
		}
	}
	$tmp_c[$rce_k]=$tmp_r;
}
//print_r($tmp_c);
$row_col_entries_percent=$tmp_c;

foreach($row_col_entries_percent as $entry_k=>$entry_v){
	$temp_arr=array();
	array_push($temp_arr,$entry_k);
	foreach($entry_v as $ev_k=>$ev_v){
		array_push($temp_arr,$ev_v);
		/*if(is_numeric($ev_v)){
			array_push($temp_arr,(int) $ev_v);
		}else{
			array_push($temp_arr,$ev_v);
		}*/
	}
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
		var column_color_index_table=[1,3,5,7,9,11,13,15,17,19,21,23,25,27,29,31,33,35,37,39];
		
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
			'filterColumnIndex': 2,
			'ui': {
			  'labelStacking': 'horizontal',	//vertical,horizontal
			  'label': '<?php if(isset($data['layer'])){echo $data['indicators'][$data['layer'][0]];} ?>:',
			  'allowTyping': false,
			  'allowMultiple': false
			}
		  }
		});
		<?php } ?>		

		var area = new google.visualization.ChartWrapper({
		  'chartType': 'BarChart',
		  'containerId': 'chart_div<?php echo $rand ?>',
		  'options': {
			'colors': default_colors,
			hAxis: {
				title: '<?php echo $data['rows'][0]." ".$data['indicators'][$data['rows'][0]]; ?>'
				//viewWindow: {max: 100},
				//format: "###'%'"
			},
			vAxis: {
				title: '<?php echo $data['columns'][0]." ".$data['indicators'][$data['columns'][0]]; ?>'
			},	
			//'width': 300,
			'height': 350,
			'legend': 'right',
			tooltip: {trigger: 'none'},
			isStacked: 'percent'
			//'chartArea': {'left': 15, 'top': 15, 'right': 0, 'bottom': 0},
			//'title': '<?php echo $data['rows'][0]." ".$data['indicators'][$data['rows'][0]]; ?>',
			//'pieSliceText': 'percent',
			//'pieHole':0.4,
		  },
		  //'view': {'columns': [0, 1 <?php if(isset($data['layer'])){ echo ',3 ';}else{echo ',2 ';}?>]}
		});		

		var data = google.visualization.arrayToDataTable(<?php echo $d1; ?>);
		
		var totalColumns=data.getNumberOfColumns();
		var view = new google.visualization.DataView(data); 
		var columns = [];
		for (var i = 0; i < totalColumns ; i++) {
			if (i > 0) {
				columns.push(i);
				columns.push({
					sourceColumn: i,
					type: "number",
					role: "annotation",
				});
			} else {
				columns.push(i);
			}
		}
		view.setColumns(columns);
		
		dashboard.bind([<?php if(sizeof($layer_options)<1){?>slider<?php }else{ ?>categoryPicker<?php } ?>], [area]);	///slider, categoryPicker
		dashboard.draw(view, data);
		
		google.visualization.events.addListener(area, 'select', function () {
			var chart=area.getChart();
			var selectedItem = chart.getSelection()[0];
			var color=document.querySelectorAll('#select_color')[0].value;
			if(color!=''){
				var col_no=column_color_index_table.indexOf(selectedItem.column);
				default_colors[col_no]=color;
				//alert("listener called");
				area.setOption('colors', default_colors);
				area.draw();
			}
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
