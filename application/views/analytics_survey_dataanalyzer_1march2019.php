<?php
$indicators=array();
$indicators_dataid=array();
$survey_id=$survey[0]['title_url'];
$code_names=array();
$sidc=$this->Survey_model->survey_indicators_dataid_codenames($survey_id);
$indicators=$sidc['indicators'];
$indicators_dataid=$sidc['indicators_dataid'];
$code_names=$sidc['code_names'];
$survey_detail=$this->Survey_model->get_survey_by_title_url($survey_id);
//print_r($survey_detail);
$comment_arr=array();
$query = $this->db->query("SELECT COLUMN_NAME,COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".$this->db->database."' AND TABLE_NAME = 'analytics_".$survey_id."'");
if($query->num_rows()>0){
	$query=$query->result_array();
	foreach($query as $q){
		if($q['COLUMN_COMMENT']!=''){
			$comment_arr[$q['COLUMN_NAME']]=$q['COLUMN_COMMENT'];
		}
	}
}
//print_r($comment_arr);
$all_with_computed=$this->db->list_fields('analytics_'.$survey_id);
unset($all_with_computed[sizeof($all_with_computed)-1]);
unset($all_with_computed[sizeof($all_with_computed)-1]);
unset($all_with_computed[0]);
unset($all_with_computed[1]);
//print_r($all_with_computed);
foreach($all_with_computed as $awc){
	if(!array_key_exists($awc,$indicators)){
		if(isset($comment_arr[$awc]) && $comment_arr[$awc]!="Computed" && $comment_arr[$awc]!="Removed"){
			$indicators[$awc]=$comment_arr[$awc];
		}else{
			$indicators[$awc]="&nbsp;";
		}
	}
}
unset($indicators[$survey_detail[0]['gps_lat_col']]);
unset($indicators[$survey_detail[0]['gps_long_col']]);
//print_r($indicators);
?>
<textarea name="indicators" style="display:none;"><?php echo json_encode($indicators); ?></textarea>
<textarea name="indicators_dataid" style="display:none;"><?php echo json_encode($indicators_dataid); ?></textarea>
<textarea name="analytics_graph_url" style="display:none;"></textarea>
<textarea name="analytics_post_data" style="display:none;"></textarea>
<input type="hidden" name="survey_id" value="<?php echo $survey_id; ?>"/>
   
    <div class="disp-table active clearfix">
      <div class="sur-data disp-table-cell">
        <!--<h3>Survey Lables</h3>-->
        <div class="clearfix">
        	<div><h3>Indicators</h3></div>
        	<div><h3>Labels</h3></div>
		</div>
        <div class="clearfix analytics-indicator-panel">
          <div>
			<ul id="indicator_list" ondrop="drop(event)" ondragover="allowDrop(event)">
             <?php foreach($indicators as $indi_key => $indi_value){ ?>
             <li id="<?php echo $indi_key; ?>" title="<?php echo $indi_value; ?>" class="draggable"><?php echo $indi_key; ?></li>
             <?php } ?>
            </ul>            
          </div>
          <div>
            <ul id="legend-lable-list">
              <?php foreach($indicators as $indi_key => $indi_value){ ?>
             <li title="<?php echo $indi_value; ?>"><?php echo substr($indi_value,0,15); ?></li>
             <?php } ?>
            </ul>
          </div>
        </div>
      </div>
      <div class="sur-graph disp-table-cell">
        <div class="lable-selector clearfix">
       		<div class="clearfix layer">
				<h3>Layer : </h3>
				<ul id="droppableLayer"></ul>	
      			<div class="layer-input"></div>
       		</div>
        	<div class="clearfix rows">
				<h3>Rows : </h3>
				<ul id="droppableRow"></ul>
				<div class="rows-input"></div>
			</div>
			<div class="clearfix column">
				<h3>Columns : </h3>
				<ul id="droppableColumn"></ul>
				<div class="column-input"></div>
			</div>
       		<button class="btn btn-primary save-analyttics" onclick="saveAnalyticsGraph()">Save In The Dashboard</button>
        </div>
        <div id="graph-container" class="graph-container"></div>
      </div>
      <div class="sur-graph-type disp-table-cell">
        <h3>Graph</h3>
        <form>
          <label>
            <input type="radio" name="graph-view" value="frequency" /> Frequency View 
          </label>
          <div class="table-view">
			  <label>
				<input type="radio" name="graph-view" value="table" /> Table View 
			  </label> 
			  <ul class="table-more-options">
			  	<li><label><input name="graph-view-row-percent" type="checkbox" onclick="generateGraph()" />Row %</label></li>
			  	<li><label><input name="graph-view-col-percent" type="checkbox" onclick="generateGraph()" />column %</label></li>
			  </ul>        
		  </div>
          <div class="chart-view">
			  <label>
				<input type="radio" name="graph-view" value="chart" /> Chart View 
			  </label> 
			  <ul class="chart-more-options">
			  	<li><label><input data-row="1" data-col="0" name="chart-view" type="radio" value="donut_chart" />Donut Chart</label></li>
			  	<li><label><input data-row="1" data-col="0" name="chart-view" type="radio" value="pie_chart" />Pie Chart</label></li>
			  	<li><label><input data-row="1" data-col="1" name="chart-view" type="radio" value="area_chart" />Area Chart</label></li>
			  	<li><label><input data-row="1" data-col="1" name="chart-view" type="radio" value="bar_chart" />Bar Chart</label></li>

			  	<li><label><input data-row="2" data-col="2" name="chart-view" type="radio" value="bubble_chart" />Bubble Chart</label></li>
			  	<li><label><input data-row="2" data-col="2" name="chart-view" type="radio" value="candlestick_chart" />Candlestick </label></li>
			  	<li><label><input data-row="1" data-col="1" name="chart-view" type="radio" value="column_chart" />Column Chart</label></li>
			  	<li><label><input data-row="1" data-col="1" name="chart-view" type="radio" value="combo_chart" />Combo Chart</label></li>
			  	<li><label><input data-row="1" data-col="1" name="chart-view" type="radio" value="histogram_chart" />Histogram</label></li>
			  	<li><label><input data-row="1" data-col="1" name="chart-view" type="radio" value="line_chart" />Line Chart</label></li>
			  	<li><label><input data-row="1" data-col="1" name="chart-view" type="radio" value="scatter_chart" />Scatter Chart</label></li>
			  	<li><label><input data-row="1" data-col="1" name="chart-view" type="radio" value="stack_chart" />Stack Chart</label></li>
			  </ul>        
		  </div>
          <div class="map-view">
			  <label>
				<input type="radio" name="graph-view" value="map" /> Map View 
			  </label> 
			  <ul class="map-more-options">
			  	<li><label><input name="map-view" type="radio" value="Topographic" /> Topographic</label></li>
			  	<li><label><input name="map-view" type="radio" value="Streets" /> Streets</label></li>
			  	<li><label><input name="map-view" type="radio" value="NationalGeographic" /> National Geographic</label></li>
			  	<li><label><input name="map-view" type="radio" value="Oceans" /> Oceans</label></li>
			  	<li><label><input name="map-view" type="radio" value="Gray" /> Gray</label></li>
			  	<li><label><input name="map-view" type="radio" value="DarkGray" /> Dark Gray</label></li>
			  	<li><label><input name="map-view" type="radio" value="Imagery" /> Imagery</label></li>
			  	<!--<li><label><input name="map-view" type="radio" value="ImageryClarity" /> Imagery (Clarity)</label></li>-->
			  	<!--<li><label><input name="map-view" type="radio" value="ImageryFirefly" /> Imagery (Firefly)</label></li>-->
			  	<li><label><input name="map-view" type="radio" value="ShadedRelief" /> Shaded Relief</label></li>
			  	<li><label><input name="map-view" type="radio" value="Terrain" /> Terrain</label></li>
			  	<!--<li><label><input name="map-view" type="radio" value="Physical" /> Physical</label></li>-->
			  </ul>        
		  </div>       
        </form>
      </div>
    </div>
<style type="text/css">
.dot{height: 15px;width: 15px;border-radius: 50%;display: inline-block;	}
.legend {
	background-color:#fff;
    line-height: 18px;
    color: #555;
	box-shadow: 0 1px 5px rgba(0,0,0,0.65);
	border-radius: 4px;
	padding: 5px;
	text-align: left;
}
.legend i {
    width: 18px;
    height: 18px;
    float: left;
    margin-right: 0px;
    opacity: 0.7;
}	
</style>    
	<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
	<!-- Load the Leaflet from CDN. More info at: http://leafletjs.com/examples/quick-start.html-->
	<script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
	<!-- Load jQuery from CDN. jQuery is used to put the GeoJSON points on the map-->
	<!--<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>-->		<!-- second jquery load-->
	
	<!-- Load the Esri Leaflet plugin from CDN.  For more info: https://esri.github.io/esri-leaflet/examples/ -->
	<script src="//cdn.jsdelivr.net/leaflet.esri/1.0.0/esri-leaflet.js"></script>   

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<!--<script src="<?php echo base_url()."theme/js/"; ?>jquery-ui.min.js"></script>-->
<script type="text/javascript">
google.charts.load('current', {packages: ['corechart', 'bar']});	
$(document).ready(function() {
	//default graph options
	$('input[name="graph-view"][value="frequency"]').prop('checked',true);
	$('input[name="graph-view"]').trigger('change');
});
$('input[name="graph-view"]').on('change',function(){
	var val=$('input[name="graph-view"]:checked').val();
	var d=$('.lable-selector>div:eq(2)');
	if(val==="frequency"){
		$('#graph-container').removeClass('mapContainer');
		$('.ui-droppable').find('.fa-times-circle').trigger('click');
		d.hide();
		$('.table-more-options').hide();
		$('.chart-more-options').hide();
		$('.map-more-options').hide();
		$("#droppableLayer").closest('div').addClass('disabled');
		$('.lable-selector').children('div').css({'width':'100%'});
	}else if(val==="table"){
		$('#graph-container').removeClass('mapContainer');
		$('.ui-droppable').find('.fa-times-circle').trigger('click');
		d.show();
		$('.table-more-options').show();
		$('.chart-more-options').hide();
		$('.map-more-options').hide();
		$("#droppableLayer").closest('div').removeClass('disabled');
		$('.lable-selector').children('div').css({'width':'75%'});
	}else if(val==="chart"){
		$('#graph-container').removeClass('mapContainer');
		$('.ui-droppable').find('.fa-times-circle').trigger('click');
		d.show();
		$('.table-more-options').hide();
		$('.chart-more-options').show();
		$('.map-more-options').hide();
		$("#droppableLayer").closest('div').addClass('disabled');
		$('.lable-selector').children('div').css({'width':'100%'});
		$('input[name="chart-view"][value="donut_chart"]').prop('checked',true);		
	}else if(val==="map"){
		$('#graph-container').addClass('mapContainer');
		d.hide();
		$('.table-more-options').hide();
		$('.chart-more-options').hide();
		$('.map-more-options').show();
		$("#droppableLayer").closest('div').addClass('disabled');
		$('.lable-selector').children('div').css({'width':'100%'});
		$('input[name="map-view"][value="Topographic"]').prop('checked',true);		
	}else{
		$('#graph-container').removeClass('mapContainer');
	}	
});
$('input[name="graph-view"],input[name="chart-view"],input[name="map-view"]').on('change',function(){
	generateGraph();
});

$('#graph-container').on('dblclick',function(){
	//copyToClipboard($(this));
});
function generateGraph(){
	//console.log("generating.");
	$('#graph-container').html('Loading...');
	var graphType=$('input[name="graph-view"]:checked').val();
	var rows_arr=[];
	var rows=$('.rows-input p');
	var columns_arr=[];
	var columns=$('.column-input p');
	var layer_arr=[];
	var layer=$('.layer-input p');
	
	var survey_id=$('input[name="survey_id"]').val();
	var indicators=$('textarea[name="indicators"]').val();
	var indicators_dataid=$('textarea[name="indicators_dataid"]').val();
	var row_percent=$('input[name="graph-view-row-percent"]').prop('checked');
	var col_percent=$('input[name="graph-view-col-percent"]').prop('checked');
	if($('input[name="chart-view"]:checked').length<1){
		if($('input[name="chart-view"]').not(':disabled').length>1){
			$('input[name="chart-view"]').not(':disabled').first().prop('checked',true);
		}
	}
	var chartType=$('input[name="chart-view"]:checked').val();
	
	rows.each(function(){
		rows_arr.push($(this).html());
	});
	columns.each(function(){
		columns_arr.push($(this).html());
	});
	layer.each(function(){
		layer_arr.push($(this).html());
	});
	rows_arr_l=rows_arr.length;
	columns_arr_l=columns_arr.length;
	layer_arr_l=layer_arr.length;
	rows_arr=JSON.stringify(rows_arr);
	columns_arr=JSON.stringify(columns_arr);
	layer_arr=JSON.stringify(layer_arr);
	if(graphType=="frequency"){
		$('[name="analytics_graph_url"]').val("survey/analytics/frequency/"+survey_id);
		$('[name="analytics_post_data"]').val('{"rows":'+rows_arr+',"indicators":'+indicators+',"indicators_dataid":'+indicators_dataid+'}');
		$.ajax({
			url: "<?php echo base_url(); ?>survey/analytics/frequency/"+survey_id, // url where to submit the request
			type : "POST", // type of action POST || GET
			data : {"rows":rows_arr,"indicators":indicators,"indicators_dataid":indicators_dataid},
			success : function(result) {
				$('#graph-container').html(result);
			},
			error: function(xhr, resp, text) {
				console.log(xhr, resp, text);
			}
		})			
	}else if(graphType=="table"){
		$("#droppableLayer").closest('div').removeClass('disabled');
		$('.lable-selector').children('div').css({'width':'75%'});
		if(rows_arr_l>0 && rows_arr_l<2 && columns_arr_l>0 && columns_arr_l<2){
			if(layer_arr_l<1){
		$('[name="analytics_graph_url"]').val("survey/analytics/table/"+survey_id);
		$('[name="analytics_post_data"]').val('{"rows":'+rows_arr+',"columns":'+columns_arr+',"indicators":'+indicators+',"indicators_dataid":'+indicators_dataid+',"row_percent":'+row_percent+',"col_percent":'+col_percent+'}');
				$.ajax({
					url: "<?php echo base_url(); ?>survey/analytics/table/"+survey_id, // url where to submit the request
					type : "POST", // type of action POST || GET
					data : {"rows":rows_arr,"columns":columns_arr,"indicators":indicators,"indicators_dataid":indicators_dataid,"row_percent":row_percent,"col_percent":col_percent},
					success : function(result) {
						$('#graph-container').html(result);
						calculateRowColumnPercent();
					},
					error: function(xhr, resp, text) {
						console.log(xhr, resp, text);
					}
				});
			}else{
		$('[name="analytics_graph_url"]').val("survey/analytics/table_layer/"+survey_id);
		$('[name="analytics_post_data"]').val('{"rows":'+rows_arr+',"columns":'+columns_arr+',"layer":'+layer_arr+',"indicators":'+indicators+',"indicators_dataid":'+indicators_dataid+',"row_percent":'+row_percent+',"col_percent":'+col_percent+'}');
				$.ajax({
					url: "<?php echo base_url(); ?>survey/analytics/table_layer/"+survey_id, // url where to submit the request
					type : "POST", // type of action POST || GET
					data : {"rows":rows_arr,"columns":columns_arr,"layer":layer_arr,"indicators":indicators,"indicators_dataid":indicators_dataid,"row_percent":row_percent,"col_percent":col_percent},
					success : function(result) {
						$('#graph-container').html(result);
						calculateRowColumnPercent();
					},
					error: function(xhr, resp, text) {
						console.log(xhr, resp, text);
					}
				});
			}
		}else if(rows_arr_l>1 || columns_arr_l>1){
			$("#droppableLayer").closest('div').addClass('disabled');
			$('.lable-selector').children('div').css({'width':'100%'});
			$('#droppableLayer').find('.fa-times-circle').trigger('click');
		$('[name="analytics_graph_url"]').val("survey/analytics/table2x2/"+survey_id);
		$('[name="analytics_post_data"]').val('{"rows":'+rows_arr+',"columns":'+columns_arr+',"indicators":'+indicators+',"indicators_dataid":'+indicators_dataid+',"row_percent":'+row_percent+',"col_percent":'+col_percent+'}');
			$.ajax({
				url: "<?php echo base_url(); ?>survey/analytics/table2x2/"+survey_id, // url where to submit the request
				type : "POST", // type of action POST || GET
				data : {"rows":rows_arr,"columns":columns_arr,"indicators":indicators,"indicators_dataid":indicators_dataid,"row_percent":row_percent,"col_percent":col_percent},
				success : function(result) {
					$('#graph-container').html(result);
					calculateWidthsHeights();
					calculateRowColumnPercent();
				},
				error: function(xhr, resp, text) {
					console.log(xhr, resp, text);
				}
			});
		}
	}else if(graphType=="chart"){
		$('input[name="chart-view"]').closest('li').each(function(){
			$(this).addClass('disabled');
		});
		$('input[name="chart-view"]').each(function(){
			$(this).prop('disabled',true);
		});		
		if(rows_arr_l==1 && columns_arr_l==0){
			$('input[name="chart-view"][data-row="1"][data-col="0"]').closest('li').each(function(){
				$(this).removeClass('disabled');
			});
			$('input[name="chart-view"][data-row="1"][data-col="0"]').each(function(){
				$(this).prop('disabled',false);
			});				
			if($('input[name="chart-view"]:checked').prop('disabled')==true){
				$('input[name="chart-view"]').not(':disabled').first().prop('checked',true);
			}	
		}else if(rows_arr_l==1 && columns_arr_l==1){
			$('input[name="chart-view"][data-row="1"][data-col="1"]').closest('li').each(function(){
				$(this).removeClass('disabled');
			});
			$('input[name="chart-view"][data-row="1"][data-col="1"]').each(function(){
				$(this).prop('disabled',false);
			});
			if($('input[name="chart-view"]:checked').prop('disabled')==true){
				$('input[name="chart-view"]').not(':disabled').first().prop('checked',true);
			}
		}else{
			
		}
		if(rows_arr_l==0 && columns_arr_l==0){
			$('#graph-container').html('No Variable Selected');
		}else if(rows_arr_l==0 && columns_arr_l==1){
			$('#graph-container').html('No Variable Selected');
		}else{
			var chartType=$('input[name="chart-view"]:checked').val();
			console.log(chartType);
		$('[name="analytics_graph_url"]').val("survey/analytics/chart/"+survey_id);
		$('[name="analytics_post_data"]').val('{"chartType":"'+chartType+'","rows":'+rows_arr+',"columns":'+columns_arr+',"indicators":'+indicators+',"indicators_dataid":'+indicators_dataid+'}');
			var container=$('#graph-container');
			var data_url;
			$.post("<?php echo base_url(); ?>survey/analytics/chart/"+survey_id,{"chartType":chartType,"rows":rows_arr,"columns":columns_arr,"indicators":indicators,"indicators_dataid":indicators_dataid}).then(function(data){
				container.html(data);
				//console.log(data);
			}).then(function(){
				setTimeout(function(){
					data_url=container.find('img:last-child').attr('src');
					$.post("<?php echo base_url(); ?>survey/analytics/png",{"data_url":data_url}).then(function(data){
					});
				},1000)		//time for creating analytics chart image on server uploads
			});
		}
	}else if(graphType=="map"){
		var mapType=$('input[name="map-view"]:checked').val();
		if(mapType==""){mapType="Topographic";}
		//console.log(mapType);
		$('[name="analytics_graph_url"]').val("survey/analytics/map/"+survey_id);
		$('[name="analytics_post_data"]').val('{"mapType":"'+mapType+'","rows":'+rows_arr+',"columns":'+columns_arr+',"indicators":'+indicators+',"indicators_dataid":'+indicators_dataid+'}');
		var container=$('#graph-container');
		container.html('<div id="map" style="width:100%;height:100%;overflow:hidden;"></div>');
		var map = L.map('map', {
			zoomControl: false
		//... other options
		});
		//var data_url;
		//console.log(indicators);
		//console.log(indicators_dataid);
		$.post("<?php echo base_url(); ?>survey/analytics/map/"+survey_id,{"mapType":mapType,"rows":rows_arr,"columns":columns_arr,"indicators":indicators,"indicators_dataid":indicators_dataid}).then(function(data){
			//container.html(data);
			//console.log(data);
			return data;
		}).then(function(data){
			data=JSON.parse(data);
			//console.log(data.lat);

			map.setView([data.lat, data.long], data.zoom);  
			//L.esri.basemapLayer('Topographic').addTo(map);
			//L.esri.basemapLayer(mapType).addTo(map);
			var layer = L.esri.basemapLayer(mapType).addTo(map);
			var layerLabels;	
			if (layer) {
				map.removeLayer(layer);
			}
			layer = L.esri.basemapLayer(mapType);
			//console.log(mapType);
			map.addLayer(layer);
			if (layerLabels) {
				map.removeLayer(layerLabels);
			}	
			if (mapType === 'ShadedRelief' || mapType === 'Oceans' || mapType === 'Gray' || mapType === 'DarkGray' || mapType === 'Terrain') {
				layerLabels = L.esri.basemapLayer(mapType + 'Labels');
				//console.log(mapType + 'Labels');
				map.addLayer(layerLabels);
			} else if (mapType.includes('Imagery')) {
				layerLabels = L.esri.basemapLayer('ImageryLabels');
				//console.log('ImageryLabels');
				map.addLayer(layerLabels);
			}			
			
			L.control.zoom({
				 position:'bottomright'
			}).addTo(map);			
			
			var legend = L.control({position: 'topleft'});			
			legend.onAdd=function(map){
				//console.log(data.legendLabels);
				var div=L.DomUtil.create('div','legend');
				var labels=["test1","test2","test3"];
				var grades = [1,2,3];
				var h;
				if (data.hasOwnProperty("indicator")) {
					h='<div><b>'+data['indicator']+'</b></div>';
				}else{
					h='<div><b>Legend</b></div>';
				}
				for (var key in data.legend) {
					if (data.legend.hasOwnProperty(key)) {
						if (data.legendLabels.hasOwnProperty(key)) {
							h+='<i style="background-color:'+data.legend[key]+'">&nbsp;</i>&nbsp;&nbsp;'+data.legendLabels[key]+'<br/>';
						}else{
							h+='<i style="background-color:'+data.legend[key]+'">&nbsp;</i>&nbsp;&nbsp;'+key+'<br/>';
						}
						//console.log('key', key);
						//console.log('value', data.legend[key]);
					}
				}				
				/*Object.keys(data.legend).forEach(key => {
					h+='<i style="background:'+data.legend[key]+'>&nbsp;</i>&nbsp;&nbsp;'+key+'<br/>';
					console.log('key', key);     
					console.log('value', data.legend[key]);     
				});				
				for(var i=0; i <grades.length; i++){
					console.log(grades[i]+" "+labels[i]);
					//div.innerHTML+='<i style="background:'+getCountyColor(grades[i])+'>&nbsp;</i>&nbsp;&nbsp;'+labels[i]+'<br/>';
					h+='<i style="background:'+grades[i]+'>&nbsp;</i>&nbsp;&nbsp;'+labels[i]+'<br/>';
				}*/
				div.innerHTML=h;
				return div;
			}
			legend.addTo(map);
			
			//var myIcon = L.divIcon({className: 'my-div-icon', html:'<i class="fa fa-circle-o"></i>'});
			//Create bike icon to style points
			var bikeIcon = L.icon({
			//Replace URL on the next line to point to your icon
			iconUrl: 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/131702/bikeCrash.png',
			iconSize: [30,40]
			});
			// add GeoJSON layer to the map once the file is loaded
			L.geoJson(data.marker,{
				pointToLayer: function(feature,latlng){
				//Create Bike Icon Marker
				//var marker = L.marker(latlng,{icon: bikeIcon});
				var marker = L.marker(latlng,{icon: 
					L.divIcon({className: 'my-div-icon', html:'<span class="dot" style="background-color:'+feature.properties.color+'"></span>'})
				});
				//To show the fields in your data, replace the field names in the {} to match your data
				//marker.bindPopup(feature.properties.bikeage_gr + '<br/>' + feature.properties.bike_sex + '<br/>' + feature.properties.crash_type);
				//marker.bindPopup(feature.properties.name);
				return marker;
				}
			//add data layer containing bike crash data to the map
			}).addTo(map);
		}).then(function(){
		}).then(function(){
			//console.log("map updated");
			/*setTimeout(function(){
				data_url=container.find('img:last-child').attr('src');
				$.post("<?php echo base_url(); ?>survey/analytics/png",{"data_url":data_url}).then(function(data){
				});
			},1000)		//time for creating analytics chart image on server uploads*/
		});
	}else{
		alert("not yet created");
	}
}

function copyToClipboard(element) {
	var $temp = $("<input>");
	$("body").append($temp);
	$temp.val($(element).html()).select(); //Note the use of html() rather than text()
	document.execCommand("copy");
	alert('Copyed To Clipboard!');
	$temp.remove();
}	
function afterSaveAnalyticsGraph(analytic_or_track){
	$('#analyticsDashboardInfoModal').modal('hide');
	var analytics_graph_url=$('[name="analytics_graph_url"]').val();
	var analytics_post_data=$('[name="analytics_post_data"]').val();
	var survey_id=$('input[name="survey_id"]').val();
	
	$.ajax({
		url: "<?php echo base_url(); ?>survey/analytics/save/"+survey_id, // url where to submit the request
		type : "POST", // type of action POST || GET
		data : {"analytics_graph_url":analytics_graph_url,"analytics_post_data":analytics_post_data,"analytic_or_track":analytic_or_track},
		success : function(result) {
			alert('Graph Saved!');
		},
		error: function(xhr, resp, text) {
			console.log(xhr, resp, text);
		}
	})	

}		
function saveAnalyticsGraph(){
	var rows_input_length=$('div.rows-input p').length;
	if(rows_input_length>0){
		$('#analyticsDashboardInfoModal').modal('show');
	}else{
		alert("No analytics graph to save!!");
	}
}	
</script>
<link href="<?php echo base_url(); ?>theme/css/jquery.contextMenu.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url(); ?>theme/js/jquery.contextMenu.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$.contextMenu({
		selector: '.graph-container', 
		callback: function(key, options) {
			var message = "global: " + key;
		},
		items: {
			"copy": {
				name: "Copy", 
				//icon: "fa-edit",
				className: 'context-menu-item',
				callback: function(itemKey, opt, rootMenu, originalEvent){
					var gc=opt.$trigger;
					//console.log(gc);
					var gval=$('input[name="graph-view"]:checked').val();
					//console.log(gval);
					
					if(gval=="chart"){
						$('#graph-container img').remove();
						//var data_url=$('#graph-container').find('[class="columnchart_values"]').data('url');
						//console.log(data_url);
						var img=document.createElement('img');
						img.src='<?php echo base_url()."uploads/chart.png" ?>';
						$('#graph-container').append(img);
						//document.body.appendChild(img);
						var img=$('#graph-container img');
						var r = document.createRange();
						r.setStartBefore(img.first()[0]);
						r.setEndAfter(img.last()[0]);
						r.selectNode(img.first()[0]);
						window.getSelection().removeAllRanges();
						var sel = window.getSelection();
						sel.addRange(r);
						document.execCommand('Copy');	
						img.hide();
						alert('Copied To Clipboard!');
					}else{
						var $temp = $("<input>");
						$("body").append($temp);
						$temp.val(gc.html()).select();
						document.execCommand("copy");
						alert('Copied To Clipboard!');
						$temp.remove();							
					}
				}
			},
			"save": {
				name: "Save In The Dashboard", 
				//icon: "fa-edit",
				className: 'context-menu-item',
				callback: function(itemKey, opt, rootMenu, originalEvent){
					saveAnalyticsGraph();
				}
			}

		}
	});

		
});
</script>








