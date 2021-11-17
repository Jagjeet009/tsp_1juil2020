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
		<a href="<?php echo base_url()."dashboard/mytable/".$dashboard_url; ?>" class="btn btn-primary">My Tables</a>
	</h6>
	<h6>
		<div class="dropdown survey-selector">
		  <a class="btn btn-info dropdown-toggle" href="javascript:void(0)" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Select a survey
		  </a>

		  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
		  	<?php foreach($surveys as $survey){?>
		  	<a class="dropdown-item <?php if($survey_id==$survey['title_url']){echo 'active';} ?>" href="<?php echo base_url()."dashboard/mychart/".$dashboard_url."/".$survey['title_url']; ?>"><?php echo $survey['title']; ?></a>
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
		$table_query=$this->db->query("select * from dashboard_analytics where survey_id = '".$survey_id."' and analytics_graph_url like '%chart%' and analytic_or_track='0' ");
	}else{
		$table_query=$this->db->query("select * from dashboard_analytics where survey_id in ('".implode("','",$surveys_title_urls)."') and analytics_graph_url like '%chart%' and analytic_or_track='0' ");
	}
	//echo $this->db->last_query();
	?>
		<?php if($table_query->num_rows()>0){$table_query=$table_query->result_array(); ?>
		<div class="row">
			<?php foreach($table_query as $tq){?>
			<div class="col-md-12 col-xl-6">
				<div class="card" style="height:400px;">
					<div class="card-body ajaxgraph" id="chart<?php echo $tq['id']; ?>">
					<textarea style="display:none" type="text" name="analytics_graph_url"><?php echo $tq['analytics_graph_url']; ?></textarea>
					<textarea style="display:none" type="text" name="analytics_post_data"><?php echo $tq['analytics_post_data']; ?></textarea>
					</div>
				</div>
			</div>
			<?php } ?>
		</div><!-- end row-->
		<?php } ?>
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
			var analytics_post_data=JSON.parse(analytics_post_data);
			var rows=JSON.stringify(analytics_post_data.rows);
			var columns=JSON.stringify(analytics_post_data.columns);
			var layer=JSON.stringify(analytics_post_data.layer);
			var indicators=JSON.stringify(analytics_post_data.indicators);
			var indicators_dataid=JSON.stringify(analytics_post_data.indicators_dataid);
			//console.log(indicators_dataid);
			$.ajax({
				url: "<?php echo base_url(); ?>"+analytics_graph_url, // url where to submit the request
				type : "POST", // type of action POST || GET
				data :{"chartType":chartType, "rows":rows, "columns":columns, "layer":layer, "indicators":indicators, "indicators_dataid":indicators_dataid},
				success : function(result) {
					//console.log(box);
					//$('#'+box).html(result);
					box.html(result);

					setTimeout(function(){
						data_url=container.find('img:last-child').attr('src');
						var image_name=container.find('.columnchart_values').attr('id');
						//console.log(image_name);
						$.post("<?php echo base_url(); ?>survey/analytics/png2/"+image_name,{"data_url":data_url}).then(function(data){
						});
					},1000)		//time for creating analytics chart image on server uploads

				},
				error: function(xhr, resp, text) {
					console.log(xhr, resp, text);
				}
			});
		});
	});
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
						gc.find('img').remove();
						var image_name=gc.find('.columnchart_values').attr('id');
						//var data_url=$('#graph-container').find('[class="columnchart_values"]').data('url');
						//console.log(data_url);
						var img=document.createElement('img');
						img.src='<?php echo base_url()."uploads/" ?>'+image_name+".png";
						gc.append(img);
						//document.body.appendChild(img);
						var img=gc.find('>img');
						var r = document.createRange();
						//console.log(img.first()[0]);
						r.setStartBefore(img.first()[0]);
						r.setEndAfter(img.last()[0]);
						r.selectNode(img.first()[0]);
						window.getSelection().removeAllRanges();
						var sel = window.getSelection();
						sel.addRange(r);
						//console.log(sel);
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
		