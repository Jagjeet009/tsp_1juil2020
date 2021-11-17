<?php 
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
<!--<script type = "text/javascript" src = "https://www.gstatic.com/charts/loader.js"></script>
<script type = "text/javascript">
google.charts.load('current', {packages: ['corechart']});     
</script>-->
<div id="<?php echo $rand ?>" class="columnchart_values" style="width: 99%; height: 99%;">Chart</div>
<!--<div id="legend_div"></div>-->
<script language = "JavaScript">
    google.charts.setOnLoadCallback(drawChart<?php echo $rand ?>);
	function drawChart<?php echo $rand ?>() {
			var colorPallette = ['#273746','#707B7C','#dc7633','#f1c40f','#1e8449','#2874a6','#6c3483','#922b21'];
			 
            // Define the chart to be drawn.
            var data = google.visualization.arrayToDataTable([
               ['Variables', 'Regression', { role: "style" } ],
               ['Model Intercept',  -0.184144496412591, "#b87333"],
               ['B.Other specialist (MD/MS in filed other than obstetrics and gynaecologist) (12 days CAC training) - Total number posted at present',  0.0481722445800298, "silver"],
               ['C.Medical Officers/ lady medical officer i.e. LMO (non-specialist, MBBS)/ ( 12 days CAC training) - Total number posted at present',  0.0670869294389704, "gold"],
               ['D.AYUSH  - Total number posted at present',  -0.158435624130615, "color: #e5e4e2"],
               ['E.Staff nurses (4 days CAC training) - Total number posted at present',  0.069512513252151, "#b87333"],
               ['F.ANMs/LHVs   - Total number posted at present',  -0.0578182293940985, "silver"],
               ['G.Pharmacist - Total number posted at present',  0.151415148949154, "gold"],
               ['H.Laboratory technician - Total number posted at present',  0.0251265152614402, "color: #e5e4e2"]
            ]);
			var view = new google.visualization.DataView(data);
			view.setColumns([0, 1,
			   { calc: "stringify",
				 sourceColumn: 1,
				 type: "string",
				 role: "annotation" },
			   2]);

            //var options = {title: 'Population (in millions)'}; 
			  var options = {
				title: 'Linear Regression Model on dependent variable: Q309A1',
				chartArea: {
				  //bottom: 24,
				  //height: '100%',
				  //left: 200,
				  //right: 200,
				  //top: 100,
				  //width: '100%'
				},
				height:'500',
				width:'100%',
				colors: colorPallette,
				//colors: ['blue','red'],
				/*hAxis: {
				  title: 'Variables'
				},*/
				hAxis: { 
					title: 'Variables',
					//direction:-1, 
					//slantedText:true, 
					//slantedTextAngle:20
					
					//count: -1, 
					//viewWindowMode: 'pretty', 
					//slantedText: false,
					//textPosition : 'none'
				},				  
				vAxis: {
				  title: 'Coefficient Values'
				}/*,
				legend: { position: "none" }*/
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
				  console.log(legend);
				  legend.insertAdjacentHTML('beforeEnd', 'LEGEND');
				  
				  
/*//increase legend height and decrese legend top
legend.setAttribute('y', parseInt(legend.getAttribute('y'))-6);    
legend.setAttribute('height', parseInt(legend.getAttribute('height'))+12);
legend.setAttribute('style', "fill:#ebebeb;stroke:black;stroke-width:1;fill-opacity:1;stroke-opacity:1;");*/

/*//move the colored squares a little to the right    
var legendTitles = document.querySelector('.columnchart_values')
                           .querySelector('g')
                           .children;
for (var i=1;i<legendTitles.length;i++) {
    var rects = legendTitles[i].querySelectorAll('rect');
    rects[0].setAttribute('x', parseInt(rects[1].getAttribute('x'))+3);
}*/				  
				  

				c.innerHTML=c.innerHTML+'<img class="columnchart_image" style="display:none" src="' + chart.getImageURI() + '">';
				  
			  });
             chart.draw(view, options);			 
         }
	
    </script>
