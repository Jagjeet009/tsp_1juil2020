<?php
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
if(sizeof($layer_options)<1){
	$layer_options=$CI->Analytics_model->fake_options($entries,$data['layer']);
	//print_r($layer_options);
}

$row_col_entries=array();
$temp_layer=array();
foreach($layer_options as $la_k=>$la_v){
	$temp_row=array();
	foreach($rows_options as $ro_k=>$ro_v){
		$temp_col=array();
		foreach($columns_options as $co_k=>$co_v){
			$count=0;
			foreach($entries as $e){
				if($e[$data['columns'][0]]!='' && $e[$data['rows'][0]]!='' && $e[$data['layer'][0]]!=''){
					if($e[$data['layer'][0]]==$la_k && $e[$data['columns'][0]]==$co_k && $e[$data['rows'][0]]==$ro_k){
						$count++;
					}
				}
			}
			$temp_col[$co_v]=$count;
		}
		$temp_row[$ro_v]=$temp_col;
	}
	$temp_layer[$la_k]=$temp_row;
}
$row_col_entries=$temp_layer;
//print_r($row_col_entries);

$d1=array();
$temp_arr=array($data['rows'][0]);
foreach($columns_options as $co){
	array_push($temp_arr,$co);
}
array_push($temp_arr,$data['layer'][0]);			//for adding layer head
//print_r($temp_arr);
array_push($d1,$temp_arr);

foreach($row_col_entries as $entry_k=>$entry_v){
	//array_push($temp_arr,$entry_k);
	foreach($entry_v as $ev_k=>$ev_v){
		$temp_arr=array();
		array_push($temp_arr,$ev_k);
		foreach($ev_v as $ev_v_k=>$ev_v_v){
			if(is_numeric($ev_v_v)){
				array_push($temp_arr,(int) $ev_v_v);
			}else{
				array_push($temp_arr,$ev_v_v);
			}
		}
		array_push($temp_arr,$layer_options[$entry_k]);
		array_push($d1,$temp_arr);
	}
}
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
		var column_color_index_table=[1,3,5,7,9,11,13,15,17,19,21,23,25,27,29,31,33,35,37,39];
		
		var data = google.visualization.arrayToDataTable(<?php echo $d1; ?>);
		var totalColumns=data.getNumberOfColumns();
		var layer_select_index=(((totalColumns-2)*2)+1);
		var view_columns = [];
		for (var i = 0; i < layer_select_index ; i++) {
			view_columns.push(i);
		}
		
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
			'filterColumnIndex': layer_select_index,
			'ui': {
			  'labelStacking': 'horizontal',	//vertical,horizontal
			  'label': '<?php if(isset($data['layer'])){echo $data['layer'][0]." ".$data['indicators'][$data['layer'][0]];} ?>:',
			  'allowTyping': false,
			  'allowMultiple': false,
			  'allowNone': false	
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
			},
			vAxis: {
				title: '<?php echo $data['columns'][0]." ".$data['indicators'][$data['columns'][0]]; ?>'
			},	
			//'width': 300,
			'height': 350,
			'legend': 'right',
			tooltip: {trigger: 'none'}
			//'chartArea': {'left': 15, 'top': 15, 'right': 0, 'bottom': 0},
			//'title': '<?php echo $data['rows'][0]." ".$data['indicators'][$data['rows'][0]]; ?>',
			//'pieSliceText': 'percent',
			//'pieHole':0.4,
		  },
		  'view': {'columns': view_columns}
		});		

		//var totalColumns=data.getNumberOfColumns();
		var view = new google.visualization.DataView(data); 
		var columns = [];
		for (var i = 0; i < totalColumns ; i++) {
			if (i > 0) {
				columns.push(i);
				columns.push({
					calc: "stringify",
					sourceColumn: i,
					type: "string",
					role: "annotation"
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
