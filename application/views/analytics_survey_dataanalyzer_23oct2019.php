<?php
$indicators=array();
$indicators_dataid=array();
$survey_id=$survey[0]['title_url'];
$code_names=array();
$sidc=$this->Survey_model->survey_indicators_dataid_codenames($survey_id);
//print_r($sidc);
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
<style type="text/css">
#graph-container .loader-box{position: absolute;background-color:#fff;width: 100%;height: 100%;top: 0px;}
#graph-container .loader{position: absolute;top: 30%;}
#graph-container img:not(.loader){display:none;}
</style>	
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
		<div class="clearfix analytics-search-indicator-panel">
			<input type="text" name="search_filter" placeholder="Search..." />
		</div>       
        <div class="clearfix analytics-indicator-panel">
          <div>
			<ul id="indicator_list" ondrop="drop(event)" ondragover="allowDrop(event)">
             <?php $serial=0;foreach($indicators as $indi_key => $indi_value){$serial++; ?>
             <li data-serial="<?php echo $serial; ?>" id="<?php echo $indi_key; ?>" title="<?php echo $indi_value; ?>" class="draggable"><?php echo $indi_key; ?></li>
             <?php } ?>
            </ul>            
          </div>
          <div>
            <ul id="legend-lable-list">
              <?php $serial=0;foreach($indicators as $indi_key => $indi_value){$serial++; ?>
             <li data-serial="<?php echo $serial; ?>" title="<?php echo $indi_value; ?>"><?php echo substr($indi_value,0,15); ?></li>
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
       		<!--<button class="btn btn-primary save-analyttics" onclick="saveAnalyticsGraph()">Save In The Dashboard</button>-->
			<span id="color_pallete">
				<input type="text" id="select_color" value="" readonly />
				<button id="palette_selector">
					<img src="<?php echo base_url()."theme/images/color-palette.png"; ?>" width="50" height="50" alt="Choose Color" title="Choose Color" />
				</button>
				<div id="color_pallete_box"></div>
			</span>       		
			<span id="table_template">
				<input type="hidden" id="select_template" value="" readonly />
				<button id="template_selector">
					<img src="<?php echo base_url()."theme/images/table_template_chooser.png"; ?>" width="50" height="50" alt="Choose Color" title="Choose Template" />
				</button>
				<div id="template_box">
					<img class="table_template_selector" data-template="template1" src="<?php echo base_url()."theme/images/table_template1.png"; ?>" width="50" height="50" alt="Template1" title="Template1" />
					<img class="table_template_selector" data-template="template2" src="<?php echo base_url()."theme/images/table_template2.png"; ?>" width="50" height="50" alt="Template2" title="Template2" />
				</div>
			</span>       		
        </div>
        <div id="graph-container" class="graph-container"></div>
      </div>
      <div class="sur-graph-type disp-table-cell">
        <h3>Graph</h3>
        <form>
          <label>
            <input type="radio" name="graph-view" value="frequency" class="graph-view" /> Frequency View 
          </label>
          <div class="table-view">
			  <label>
				<input type="radio" name="graph-view" value="table" class="graph-view" /> Table View 
			  </label> 
			  <ul class="table-more-options">
			  	<li><label><input name="graph-view-row-percent" type="checkbox" onclick="generateGraph()" />Row %</label></li>
			  	<li><label><input name="graph-view-col-percent" type="checkbox" onclick="generateGraph()" />column %</label></li>
			  </ul>        
		  </div>
          <div class="chart-view">
			  <label>
				<input type="radio" name="graph-view" value="chart" class="graph-view" /> Chart View 
			  </label> 
			  <ul class="chart-draw-options">
			  	<li>
			  		<select name="chart-draw-view">
			  			<option value="count">Count Info</option>
			  			<option value="percent">Percent Info</option>
			  		</select>
			  	</li>
			  </ul>
			  <ul class="chart-more-options">
			  	<li><label><input data-row="1" data-col="0" name="chart-view" type="radio" value="donut_chart" />Donut Chart</label></li>
			  	<li><label><input data-row="1" data-col="0" name="chart-view" type="radio" value="pie_chart" />Pie Chart</label></li>
			  	
			  	<li><label><input data-row="1" data-col="1" name="chart-view" type="radio" value="column_chart" />Column Chart</label></li>
			  	<li><label><input data-row="1" data-col="1" name="chart-view" type="radio" value="area_chart" />Area Chart</label></li>
			  	<li><label><input data-row="1" data-col="1" name="chart-view" type="radio" value="bar_chart" />Bar Chart</label></li>
			  	<li><label><input data-row="1" data-col="1" name="chart-view" type="radio" value="line_chart" />Line Chart</label></li>
			  	<li><label><input data-row="1" data-col="1" name="chart-view" type="radio" value="scatter_chart" />Scatter Chart</label></li>
			  	<li><label><input data-row="1" data-col="1" name="chart-view" type="radio" value="stack_chart" />Stack Chart</label></li>

			  	<!--<li><label><input data-row="1" data-col="1" name="chart-view" type="radio" value="combo_chart" /><i class="fa fa-times" aria-hidden="true"></i> Combo Chart</label></li>
			  	<li><label><input data-row="1" data-col="1" name="chart-view" type="radio" value="histogram_chart" /><i class="fa fa-times" aria-hidden="true"></i> Histogram</label></li>
			  	<li><label><input data-row="2" data-col="2" name="chart-view" type="radio" value="bubble_chart" /><i class="fa fa-times" aria-hidden="true"></i> Bubble Chart</label></li>
			  	<li><label><input data-row="2" data-col="2" name="chart-view" type="radio" value="candlestick_chart" /><i class="fa fa-times" aria-hidden="true"></i> Candlestick </label></li>-->
			  	
			  </ul>        
		  </div>
          <div class="map-view">
			  <label>
				<input type="radio" name="graph-view" value="map" class="graph-view" /> Map View 
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

          <div class="regression-view">
			  <label>
				<input type="radio" name="graph-view" value="regression" class="graph-view" /> Regression View 
			  </label>
			  <ul class="regression-more-options">
			  	<li><label><input name="regression-view" type="radio" value="linear" />Linear</label></li>
			  	<li><label><input name="regression-view" type="radio" value="multinomial" />Multinomial</label></li>
			  	<li><label><input name="regression-view" type="radio" value="logistic" />Logistic</label></li>
			  	<li><label><input name="regression-view" type="radio" value="logit" />Logit</label></li>
			  	<li><label><input  name="regression-view" type="radio" value="probit" />Probit</label></li>				  
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

<!--<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
<script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
<script src="//cdn.jsdelivr.net/leaflet.esri/1.0.0/esri-leaflet.js"></script>-->
<link rel="stylesheet" href="<?php echo base_url()."theme/css/"; ?>leaflet.css" />
<script src="<?php echo base_url()."theme/js/"; ?>leaflet.js"></script>
<script src="<?php echo base_url()."theme/js/"; ?>esri-leaflet.js"></script>

<script type="text/javascript" src="<?php echo base_url()."theme/js/"; ?>datatables.min.js"></script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<!--<script src="<?php echo base_url()."theme/js/"; ?>jquery-ui.min.js"></script>-->
<script type="text/javascript">
google.charts.load('current', {packages: ['corechart', 'bar', 'table', 'gauge', 'controls']});	
$('input[name="graph-view"]').on('change',function(){	
//$(document).on('change','.graph-view',function(){
	var val=$('input[name="graph-view"]:checked').val();
	var d=$('.lable-selector>div:eq(2)');
	var cdv=$('select[name="chart-draw-view"]');
	if(val==="frequency"){
		$('#graph-container').removeClass('mapContainer');
		$('.ui-droppable').find('.fa-times-circle').trigger('click');
		d.hide();
		$('.table-more-options').hide();
		$('.chart-more-options').hide();
		$('.map-more-options').hide();
		$("#droppableLayer").closest('div').addClass('disabled');
		$('.lable-selector').children('div').css({'width':'100%'});
		cdv.hide();
		$('.regression-more-options').hide();
	}else if(val==="table"){
		$('#graph-container').removeClass('mapContainer');
		$('.ui-droppable').find('.fa-times-circle').trigger('click');
		d.show();
		$('.table-more-options').show();
		$('.chart-more-options').hide();
		$('.map-more-options').hide();
		$("#droppableLayer").closest('div').removeClass('disabled');
		$('.lable-selector').children('div').css({'width':'75%'});
		cdv.hide();
		$('.regression-more-options').hide();
	}else if(val==="chart"){
		$('#graph-container').removeClass('mapContainer');
		$('.ui-droppable').find('.fa-times-circle').trigger('click');
		d.show();
		$('.table-more-options').hide();
		$('.chart-more-options').show();
		$('.map-more-options').hide();
		//$("#droppableLayer").closest('div').addClass('disabled');
		$("#droppableLayer").closest('div').removeClass('disabled');
		//$('.lable-selector').children('div').css({'width':'100%'});
		$('.lable-selector').children('div').css({'width':'75%'});
		$('input[name="chart-view"][value="donut_chart"]').prop('checked',true);
		$('select[name="chart-draw-view"]').find('option[value="count"]').prop('selected',true);
		cdv.show();
		$('.regression-more-options').hide();
	}else if(val==="map"){
		$('#graph-container').addClass('mapContainer');
		d.hide();
		$('.table-more-options').hide();
		$('.chart-more-options').hide();
		$('.map-more-options').show();
		$("#droppableLayer").closest('div').addClass('disabled');
		$('.lable-selector').children('div').css({'width':'100%'});
		$('input[name="map-view"][value="Topographic"]').prop('checked',true);	
		cdv.hide();
		$('.regression-more-options').hide();
	}else if(val==="regression"){
		$('#graph-container').removeClass('mapContainer');
		$('.ui-droppable').find('.fa-times-circle').trigger('click');
		d.show();
		$('.table-more-options').hide();
		$('.chart-more-options').hide();
		$('.map-more-options').hide();
		$("#droppableLayer").closest('div').addClass('disabled');
		$('.lable-selector').children('div').css({'width':'100%'});
		cdv.hide();
		$('.regression-more-options').show();
	}else{
		$('#graph-container').removeClass('mapContainer');
	}	
});	
$(document).ready(function() {
	//default graph options
	$('input[name="graph-view"][value="frequency"]').prop('checked',true);
	$('input[name="graph-view"]')[1].click();
});	

$('input[name="graph-view"],input[name="chart-view"],input[name="map-view"],select[name="chart-draw-view"],input[name="regression-view"]').on('change',function(){
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
	if($('input[name="regression-view"]:checked').length<1){
		if($('input[name="regression-view"]').not(':disabled').length>1){
			$('input[name="regression-view"]').not(':disabled').first().prop('checked',true);
		}
	}	
	var chartType=$('input[name="chart-view"]:checked').val();
	var chartDrawType=$('select[name="chart-draw-view"]').val();
	var regressionType=$('input[name="regression-view"]:checked').val();	
	
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
		$('#color_pallete').hide();
		$('#table_template').hide();
	}else if(graphType=="table"){
		$("#droppableLayer").closest('div').removeClass('disabled');
		$('.lable-selector').children('div').css({'width':'75%'});
		if(rows_arr_l>0 && rows_arr_l<2 && columns_arr_l>0 && columns_arr_l<2){		//row=1 col=1
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
		}else if(rows_arr_l>1 || columns_arr_l>1){		//row=1,2,3 col=1,2,3
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
		$('#color_pallete').hide();
		$('#table_template').show();
	}else if(graphType=="chart"){
		$('input[name="chart-view"]').closest('li').each(function(){
			$(this).addClass('disabled');
		});
		$('input[name="chart-view"]').each(function(){
			$(this).prop('disabled',true);
		});		
		if(rows_arr_l==1 && columns_arr_l==0){		//row-1 col=0
			$('input[name="chart-view"][data-row="1"][data-col="0"]').closest('li').each(function(){
				$(this).removeClass('disabled');
			});
			$('input[name="chart-view"][data-row="1"][data-col="0"]').each(function(){
				$(this).prop('disabled',false);
			});				
			if($('input[name="chart-view"]:checked').prop('disabled')==true){
				$('input[name="chart-view"]').not(':disabled').first().prop('checked',true);
			}	
		}else if(rows_arr_l==1 && columns_arr_l==1){		//row-1 col=1
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
		if(rows_arr_l==0 && columns_arr_l==0){			//row-0 col=0
			$('#graph-container').html('No Variable Selected');
		}else if(rows_arr_l==0 && columns_arr_l==1){	//row-0 col=1
			$('#graph-container').html('No Variable Selected');
		}else if(rows_arr_l>1 || columns_arr_l>1){	//row-2,3,4 col=2,3,4 
			$('#graph-container').html('Excess Variables Selected');
		}else{											//row-1 col=1
			var chartType=$('input[name="chart-view"]:checked').val();
			var post_data_string='';
			var post_data_json='';
			//console.log(chartType);
			$('[name="analytics_graph_url"]').val("survey/analytics/chart/"+survey_id);
			if(layer_arr_l<1){		//layer=0
				post_data_string='{"chartType":"'+chartType+'","rows":'+rows_arr+',"columns":'+columns_arr+',"indicators":'+indicators+',"indicators_dataid":'+indicators_dataid+',"chartDrawType":"'+chartDrawType+'"}';
				post_data_json={"chartType":chartType,"rows":rows_arr,"columns":columns_arr,"indicators":indicators,"indicators_dataid":indicators_dataid,"chartDrawType":chartDrawType};
			}else{					//layer=1
				post_data_string='{"chartType":"'+chartType+'","rows":'+rows_arr+',"columns":'+columns_arr+',"layer":'+layer_arr+',"indicators":'+indicators+',"indicators_dataid":'+indicators_dataid+',"chartDrawType":"'+chartDrawType+'"}';
				post_data_json={"chartType":chartType,"rows":rows_arr,"columns":columns_arr,"layer":layer_arr,"indicators":indicators,"indicators_dataid":indicators_dataid,"chartDrawType":chartDrawType};
			}
			$('[name="analytics_post_data"]').val(post_data_string);
			var container=$('#graph-container');
			var data_url;
			var chart_id;
			$.post("<?php echo base_url(); ?>survey/analytics/chart/"+survey_id,post_data_json).then(function(data){
				data+='<div class="loader-box"><img src="<?php echo base_url()."theme/images/ajax-loader.gif"; ?>" class="loader" /></div>';
				container.html(data);
				//console.log(data);
			}).then(function(){
				setTimeout(function(){
					chart_id=container.find('.columnchart_values').attr('id');
					//console.log(chart_id);
					data_url=container.find('img:last-child').attr('src');
					//console.log(data_url);
					$.post("<?php echo base_url(); ?>survey/analytics/png",{"data_url":data_url,"chart_id":chart_id}).then(function(data){
						container.find('.loader-box').remove();
						//console.log(data);
						container.find('img').remove();
						var img=document.createElement('img');
						img.src='<?php echo base_url()."uploads/chart_" ?>'+chart_id+'.png';
						container.append(img);
					});
				},5000)		//time for creating analytics chart image on server uploads
			});
		}
		$('#color_pallete').show();
		$('#table_template').hide();
	}else if(graphType=="regression"){
		var regressionType=$('input[name="regression-view"]:checked').val();
		//console.log(rows_arr_l+" "+columns_arr_l);
		if(rows_arr_l==0 && columns_arr_l==0){
			$('#graph-container').html('No Variable Selected');
		}else if(rows_arr_l==0 && columns_arr_l==1){
			$('#graph-container').html('No Variable Selected');	
		}else if(rows_arr_l==1 && columns_arr_l==0){
			$('#graph-container').html('No Variable Selected');
		}else{
			$('[name="analytics_graph_url"]').val("survey/analytics/regressionchart/"+survey_id);
			$('[name="analytics_post_data"]').val('{"rows":'+rows_arr+',"columns":'+columns_arr+',"indicators":'+indicators+',"indicators_dataid":'+indicators_dataid+',"regression_type":'+regressionType+'}');
			
			//calculate data for regression in json
			$.post("<?php echo base_url(); ?>survey/analytics/calculateregression/"+survey_id,{"rows":rows_arr,"columns":columns_arr,"indicators":indicators,"indicators_dataid":indicators_dataid,"regression_type":regressionType}).then( function(result1) {
				//console.log(result1);
				//$.post('<?php echo base_url()."survey/r_software"; ?>',{"data":result1}).then( function(result2) {
				$.post('<?php echo RSOFTWARE_URL; ?>',{"data":result1}).then( function(result2) {
					//console.log(result2);
					$.post("<?php echo base_url(); ?>survey/analytics/regressionchart/"+survey_id,{"data":result2}).then( function(result3) {
						//console.log(result3);
						var container=$('#graph-container');
						container.html(result3);
						
						//var svg_id=container.find('.columnchart_values').attr('id');
						//var svg = $("#"+svg_id).getSVG();
						//console.log(svg);						
						

						var si=setInterval(function(){
						 var l=container.find('div.columnchart_values>img').length;
							if(l>0){
								//console.log("found: "+l);
								clearInterval(si);
								var data_url=container.find('div.columnchart_values>img').last().attr('src');
								var image_name=container.find('.columnchart_values').attr('id');
								$.post('<?php echo base_url(); ?>survey/analytics/png2/'+image_name,{"data_url":data_url});
							}
						}, 1000);						
						

					});
				});
			});

		}		
		$('#color_pallete').hide();
		$('#table_template').hide();
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
		$('#color_pallete').hide();
		$('#table_template').hide();
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


<script type="text/javascript">
function createColorPalette(){
	var color_palette =	[["#000000","#434343","#666666","#999999","#b7b7b7","#cccccc","#d9d9d9","#efefef","#f3f3f3","#ffffff"],
						["#980000","#ff0000","#ff9900","#ffff00","#00ff00","#00ffff","#4a86e8","#0000ff","#9900ff","#ff00ff"],
						["#e6b8af","#f4cccc","#fce5cd","#fff2cc","#d9ead3","#d0e0e3","#c9daf8","#cfe2f3","#d9d2e9","#ead1dc"],
						["#dd7e6b","#ea9999","#f9cb9c","#ffe599","#b6d7a8","#a2c4c9","#a4c2f4","#9fc5e8","#b4a7d6","#d5a6bd"],
						["#cc4125","#e06666","#f6b26b","#ffd966","#93c47d","#76a5af","#6d9eeb","#6fa8dc","#8e7cc3","#c27ba0"],
						["#a61c00","#cc0000","#e69138","#f1c232","#6aa84f","#45818e","#3c78d8","#3d85c6","#674ea7","#a64d79"],
						["#85200c","#990000","#b45f06","#bf9000","#38761d","#134f5c","#1155cc","#0b5394","#351c75","#741b47"],
						["#5b0f00","#660000","#783f04","#7f6000","#274e13","#0c343d","#1c4587","#073763","#20124d","#4c1130"]];
	var palette_html='';
	for (var i = 0; i < color_palette.length; i++) { 
		palette_html+="<div class='color-row'>";
		for (var j = 0; j < color_palette[i].length; j++) { 
			palette_html+="<span class='color-column'>"+color_palette[i][j]+"</span>";
		}
		palette_html+="</div>";
	}
	var palette_box=document.getElementById('color_pallete_box');
	palette_box.innerHTML=palette_box.innerHTML+palette_html;	
	$('#color_pallete_box').find('.color-row').each(function(){
		var row=$(this);
		row.find('.color-column').each(function(){
			var column=$(this);
			var column_color=column.html();
			column.css('background-color',column_color);
		});
	});
	$('.color-column').on('click',function(){
		$('#select_color').val($(this).html());
		$('#select_color').css('background-color',$(this).html());
		$('#color_pallete_box').hide();
	});
}	
	
$.extend($.expr[":"], {
	"containsIN": function(elem, i, match, array) {
		return (elem.textContent || elem.innerText || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
	}
});	
	
$(document).on("keyup", ".analytics-search-indicator-panel input[name='search_filter']",function(){
	var search_text=$(this).val();
	var ids_to_show=[];
	$('#legend-lable-list').find("li").each(function(){
		var text=$(this).attr('title');
		var patt = new RegExp(search_text, "i");
		var res = patt.test(text); 
		if(res){
			var li_no=$(this).data('serial');
			//console.log(li_no);
			ids_to_show.push(li_no);
		}
	});
	//console.log(ids_to_show);
	$('#legend-lable-list').find("li").hide();
	$('#indicator_list').find("li").hide();	
	for (index = 0; index < ids_to_show.length; index++) { 
		$('#legend-lable-list').find("li[data-serial='"+ids_to_show[index]+"']").show();
		$('#indicator_list').find("li[data-serial='"+ids_to_show[index]+"']").show();
	}
});
$(document).ready(function() {
	//setting up palette programitically
	createColorPalette();
	$('#palette_selector').on('click',function(){
		$('#color_pallete_box').toggle();
	});
	$('#template_selector').on('click',function(){
		$('#template_box').toggle();
	});		
});	
</script>


<link rel="stylesheet" type="text/css" href="<?php echo base_url()."theme/css/"; ?>datatables-white.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()."theme/css/"; ?>table_tempate1.css"/>
<!--<script type="text/javascript" src="<?php echo base_url()."theme/js/"; ?>jquery-3.3.1.min.js"></script>-->
<script type="text/javascript">
var jQuery_3_3_1 = $.noConflict(true);	
jQuery_3_3_1(document).ready(function() {
	jQuery_3_3_1('.table_template_selector').on('click',function(){
		jQuery_3_3_1('#template_box').hide();
		var template=jQuery_3_3_1(this).data('template');
		jQuery_3_3_1('#graph-container table').each(function(){
			jQuery_3_3_1(this).attr('border','0');
			jQuery_3_3_1(this).removeClass('template1');
			jQuery_3_3_1(this).removeClass('template2');
		});
		var table_id=jQuery_3_3_1('#graph-container table').attr('id');
		jQuery_3_3_1('#'+table_id).addClass(template);
		jQuery_3_3_1('#'+table_id).DataTable(
			//"paging":   false,
			//"ordering": false,
			//"info":     false		
		);		
	});	
});
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
						var img=$('#graph-container img');
						img.show();
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
					}else if(gval=="regression"){
						$('#graph-container img').remove();
						var graph_id=$('#graph-container').find('[class="columnchart_values"]').attr('id');
						var img=document.createElement('img');
						img.src='<?php echo base_url()."uploads/" ?>'+graph_id+'.png';
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