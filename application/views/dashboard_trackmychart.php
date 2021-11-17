<?php if(!isset($surveys)){?>
	<div class="row small-cards">
		<div class="col-md-12 col-xl-12 mr-auto">
			<div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
				<i class="mdi mdi-alert font-32"></i><h3><strong class="pr-1"></strong> No surveys have been assigned to this dashboard</h3>
			</div>
		</div>
	</div><!-- end row -->	
<?php }else{ ?>
<div class="row small-cards">
	<h6>
		<a href="<?php echo base_url()."dashboard/records/".$dashboard_url; ?>" class="btn btn-primary">Records</a>
	</h6>
	<h6>
		<a href="<?php echo base_url()."dashboard/trackmytable/".$dashboard_url; ?>" class="btn btn-success">My Tables</a>
	</h6>	
	<h6>
		<div class="dropdown survey-selector">
		  <a class="btn btn-info dropdown-toggle" href="javascript:void(0)" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Select a survey
		  </a>

		  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
		  	<?php foreach($surveys as $survey){?>
		  	<a class="dropdown-item <?php if($survey_id==$survey['title_url']){echo 'active';} ?>" href="<?php echo base_url()."dashboard/trackmychart/".$dashboard_url."/".$survey['title_url']; ?>"><?php echo $survey['title']; ?></a>
		  	<?php } ?>
		  </div>
		</div>		
	</h6>
</div>
	<?php
	//print_r($surveys);
	$surveys_title_urls=array();
	foreach($surveys as $s){
		array_push($surveys_title_urls,$s['title_url']);
	}
	if(isset($survey_id) && $survey_id!=''){
		$table_query=$this->db->query("select * from dashboard_analytics where survey_id = '".$survey_id."' and ( analytics_graph_url like '%chart%' || analytics_graph_url like '%word_cloud%' ) and analytic_or_track='1' ");
	}else{
		$table_query=$this->db->query("select * from dashboard_analytics where survey_id in ('".implode("','",$surveys_title_urls)."') and ( analytics_graph_url like '%chart%' || analytics_graph_url like '%word_cloud%' ) and analytic_or_track='1' ");
	}
	//echo $this->db->last_query();
	?>
<div class="container">	
		<?php if($table_query->num_rows()>0){$table_query=$table_query->result_array(); ?>

			<?php foreach($table_query as $tq){?>
		<div class="row">
			<div class="col-1"></div>				
			<div class="col-10">

				<div class="card" style="height:400px;">
					<div class="card-body ajaxgraph" id="chart<?php echo $tq['id']; ?>">
					<textarea style="display:none" type="text" name="analytics_graph_url"><?php echo $tq['analytics_graph_url']; ?></textarea>
					<textarea style="display:none" type="text" name="analytics_post_data"><?php echo $tq['analytics_post_data']; ?></textarea>
					</div>
				</div>
			</div>
			<div class="col-1"></div>
		</div><!-- end row-->	
			<?php } ?>

		<?php } ?>
</div>	
<style type="text/css">
.ajaxgraph .loader-box{position: absolute;background-color:#fff;width: 100%;height: 100%;top: 0px;}
.ajaxgraph .loader{position: absolute;top: 30%;}
.ajaxgraph img:not(.loader){display:none;}
</style>	

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>	
	<script type="text/javascript">
	//google.charts.load('current', {packages: ['corechart', 'bar']});	
	google.charts.load('current', {packages: ['corechart', 'bar', 'table', 'gauge', 'controls']});
	$(document).ready(function(){
		$('.ajaxgraph').each(function(){
			var container=$(this);
			var box_name=$(this).attr('id');
			var box=$('#'+box_name); 
			var analytics_graph_url=box.find('[name="analytics_graph_url"]').val();
			//console.log(analytics_graph_url);
			var analytics_post_data=box.find('[name="analytics_post_data"]').val();
			//console.log(analytics_post_data);
			var chartType=JSON.parse(analytics_post_data).chartType;
			var chartDrawType=JSON.parse(analytics_post_data).chartDrawType;	
			var analytics_post_data=JSON.parse(analytics_post_data);
			var rows=JSON.stringify(analytics_post_data.rows);
			var columns=JSON.stringify(analytics_post_data.columns);
			var layer=JSON.stringify(analytics_post_data.layer);
			var indicators=JSON.stringify(analytics_post_data.indicators);
			var indicators_dataid=JSON.stringify(analytics_post_data.indicators_dataid);
			//console.log(indicators_dataid);
			
			container.html('<div class="loader-box"><img src="<?php echo base_url()."theme/images/ajax-loader.gif"; ?>" class="loader" /></div>');
			$.ajax({
				url: "<?php echo base_url(); ?>"+analytics_graph_url, 
				type : "POST", 
				data :{"chartType":chartType, "rows":rows, "columns":columns, "layer":layer, "indicators":indicators, "indicators_dataid":indicators_dataid, "chartDrawType":chartDrawType}
			}) //first ajax call
			.then(function(data1){
				container.html(data1);
				container.find('.loader-box').remove();
					/*chart_id=container.find('.columnchart_values').attr('id');
					if(chart_id.includes("wc_")){
						var word_array=container.find('.columnchart_values').data('word_array');
						if(typeof word_array !== "undefined") {
							$('#'+chart_id).jQCloud(word_array);
						}
					}*/				
			})
			.then(function(){
				var chart=container.find('.columnchart_values');		
				if(chart.hasClass('word-cloud')){
					var jQCloud_div=chart;
					var word_array=jQCloud_div.data('word_array');
					if(typeof word_array !== "undefined") {
						$(jQCloud_div).jQCloud(word_array);
					}							
					setTimeout(function(){
						//console.log(jQCloud_div.html());
						var rect = chart[0].getBoundingClientRect();
						html2canvas(chart[0],{height:rect.height, width:rect.width}).then(function(canvas) {
							var data_url=canvas.toDataURL();
							var c=container.find('.tmp_image_container')[0];
							var img=document.createElement('img');
							img.src=canvas.toDataURL();
							img.className='tmp_img';
							c.appendChild(img);	
							c.setAttribute('data-image', data_url);	
							createImageFromDataurl2(chart);		
						});											
					},500);
				}else{
					setTimeout(function(){
						createImageFromDataurl2(chart);			
					},500);
				}		
			
			})
			/*.done(function(resp){
			   //handle final response here
			 })*/
		});
	});
	/*$(document).on('DOMSubtreeModified', ".columnchart_values", function() {
		var chart=$(this);
		console.log('columnchart_values updating ');
		//createImageFromDataurl2(chart);
	});	*/
function createImageFromDataurl2(chart){
	var tmp_image_container=chart.find('.tmp_image_container');
	//console.log(tmp_image_container);
	var data_url=$(tmp_image_container).data('image');
	//console.log(data_url);
	tmp_image_container.removeData();
	var id=chart.attr('id');
	var container=chart.closest('.ajaxgraph');
	if(id!=""){
		$.post("<?php echo base_url(); ?>survey/analytics/png2/"+id,{"data_url":data_url}).then(function(data){
			container.find('.copy_img').remove();
			var img=document.createElement('img');
			img.src='<?php echo base_url()."uploads/chart_" ?>'+id+'.png'+'?'+new Date().getTime();
			img.className='copy_img';
			container.append(img);			
		});
	}
}	
	</script>                            
	<script type="text/javascript">
	$.noConflict();
	jQuery(document).ready(function(){
		jQuery.contextMenu({
			selector: '.ajaxgraph', 
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
						var img=gc.find('.copy_img');
						//console.log(img);
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
					}
				}
			}
		});
	});	
	</script>
<?php } ?>		                
		