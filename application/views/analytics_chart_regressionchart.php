<?php 
$data=$this->input->post();
if(!isset($data['data'])){
	echo "Invalid Response!!";die;
}
$data=(array) json_decode($data['data']);
//print_r($data);
$chart_title=$data['title'][0];
$chart_data=$data['data'];
$html='';
$i=0;
//print_r($chart_data);
foreach($chart_data as $cd){
	$i++;
	$cd=(array) $cd;
	if(!isset($cd['Variable_description'])){$cd['Variable_description']="Missing";}
	if($i<sizeof($chart_data)){
		$html.="['".$cd['Variable_description']."', ".$cd['Coefficient_Values']."],"."\r\n";
	}else{
		$html.="['".$cd['Variable_description']."', ".$cd['Coefficient_Values']."]"."\r\n";
	}
}
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
?>
<style type="text/css">
#legend_div {
	text-align: center;
	width: 320px;
	border:1px solid #000;
}
.legend-marker {
	display: inline-block;
	padding: 16px 4px 8px 4px;
}
.legend-marker-color {
	display: inline-block;
	height: 12px;
	width: 12px;
}
</style>
<div id="<?php echo $rand ?>" class="columnchart_values" style="width: 99%; height: 99%;">Chart</div>
<script language = "JavaScript">
    google.charts.setOnLoadCallback(drawChart<?php echo $rand ?>);
	function drawChart<?php echo $rand ?>() {
			var colorPallette = ['#273746','#707B7C','#dc7633','#f1c40f','#1e8449','#2874a6','#6c3483','#922b21'];
			 
			var data = google.visualization.arrayToDataTable([
               ['Variables', 'Regression'],
				<?php echo $html;?>
            ]);		
		
			var view = new google.visualization.DataView(data);
			view.setColumns([0, 1,
			   { calc: "stringify",
				 sourceColumn: 1,
				 type: "string",
				 role: "annotation" }]);

			  var options = {
				title:'<?php echo $chart_title; ?>',
				height:'400',
				width:'100%',
				colors: colorPallette,
				hAxis: { 
					title: 'Variables',
				},				  
				vAxis: {
				  title: 'Coefficient Values'
				},
				isStacked: true
			  };			 

            // Instantiate and draw the chart.
            var chart = new google.visualization.ColumnChart(document.getElementById('<?php echo $rand ?>'));
			var c=document.getElementById('<?php echo $rand ?>');
			  // chart ready event
			  google.visualization.events.addListener(chart, 'ready', function () {
				//for image url
				  var legend = document.querySelector('svg')
                     .querySelector('g')
                     .querySelector('rect');
				  //console.log(legend);
				  legend.insertAdjacentHTML('beforeEnd', 'LEGEND');
				c.innerHTML=c.innerHTML+'<img class="columnchart_image" style="display:none" src="' + chart.getImageURI() + '">';
			  });
             chart.draw(view, options);			 
         }
	
    </script>
