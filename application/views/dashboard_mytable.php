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
		<a href="<?php echo base_url()."dashboard/mychart/".$dashboard_url; ?>" class="btn btn-success">My Charts</a>
	</h6>
	<h6>
		<div class="dropdown survey-selector">
		  <a class="btn btn-info dropdown-toggle" href="javascript:void(0)" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Select a survey
		  </a>

		  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
		  	<?php foreach($surveys as $survey){?>
		  	<a class="dropdown-item <?php if($survey_id==$survey['title_url']){echo 'active';} ?>" href="<?php echo base_url()."dashboard/mytable/".$dashboard_url."/".$survey['title_url']; ?>"><?php echo $survey['title']; ?></a>
		  	<?php } ?>
		  </div>
		</div>		
	</h6>
</div>
	<script>
	function calculateRowColumnPercent(row_percent,col_percent){
		//console.log("called calculateRowColumnPercent");
		var row_percent=row_percent;
		$('.row-percent').each(function(){
			var row_percent_td=$(this);
			var v1=row_percent_td.prev('td').text();
			var v2=row_percent_td.closest('tr').find('.row-total').text();
			var v3=((parseInt(v1)/parseInt(v2))*100).toFixed(2);
			//var v3=((parseInt(v1)/parseInt(v2))*100);
			if(v3=="NaN"){v3='0';}
			row_percent_td.html(v3);
		});
		$('.col-percent').each(function(){
			var col_percent_td=$(this);
			//console.log("row_percent: "+row_percent);
			if(row_percent=="1"){
				var v1=col_percent_td.prev('td').prev('td').text();
				var cellindex=col_percent_td.prev('td').prev('td').index();
			}else{
				var v1=col_percent_td.prev('td').text();
				var cellindex=col_percent_td.prev('td').index();
			}
			var v2=col_percent_td.closest('table').find('tr:last>td:eq('+cellindex+')').text();
			//console.log(v1+" "+v2);
			var v3=((parseInt(v1)/parseInt(v2))*100).toFixed(2);
			//var v3=((parseInt(v1)/parseInt(v2))*100);
			if(v3=="NaN"){v3='0';}
			col_percent_td.html(v3);
		});
	}
	function calculateWidthsHeights(tablekey){
		//console.log("called calculateWidthsHeights");

		//setting first same column widths to all tables
		var tr_second_td_first_width=0;
		$('#'+tablekey).find('table.inner').each(function(){
			var ti=$(this);
			var tr_second_td_first=ti.find('tr:eq(1)>td:first-child');
			if(tr_second_td_first_width<=tr_second_td_first.innerWidth()){
				tr_second_td_first_width=tr_second_td_first.innerWidth();
			}
		});	
		$('#'+tablekey).find('table.inner').each(function(){
			ti=$(this);
			var tr_second_td_first=ti.find('tr:eq(1)>td:first-child');
			tr_second_td_first.innerWidth(tr_second_td_first_width);
		});	

		//insert colgroup in all tables
		$('#'+tablekey).find('table.inner').each(function(){
			ti=$(this);
			var tbodyText='<colgroup>';
			ti.find('tr:first-child>td').each(function(){
				var td=$(this);
				//console.log(td.innerWidth());
				tbodyText=tbodyText+'<col width="'+td.innerWidth()+'px">';	
			});
			tbodyText=tbodyText+'</colgroup>';
			ti.html(tbodyText+ti.html());
			//ti.css('table-layout','fixed');
		});

		//hiding row and columns accordingly
		$('#'+tablekey).find('table.inner').each(function(){
			var ti=$(this);
			if(ti.hasClass('firstColumn')){
				var td=ti.find('tr>td:first-child');
				var tdi=td.index();
				ti.find('colgroup col:eq('+tdi+')').remove();
				td.hide();
			}
			if(ti.hasClass('firstRow')){
				var td=ti.find('tr:first-child>td');
				td.hide();
			}
		});	

		$('#'+tablekey).find('table.inner').each(function(){
			ti=$(this);
			ti.css('table-layout','fixed');
		});

	}	
	</script>
	<?php
	//print_r($surveys);
	$surveys_title_urls=array();
	foreach($surveys as $s){
		array_push($surveys_title_urls,$s['title_url']);
	}
	if(isset($survey_id) && $survey_id!=''){
		$table_query=$this->db->query("select * from dashboard_analytics where survey_id = '".$survey_id."' and analytics_graph_url like '%table%' and analytic_or_track='0' ");
	}else{
		$table_query=$this->db->query("select * from dashboard_analytics where survey_id in ('".implode("','",$surveys_title_urls)."') and analytics_graph_url like '%table%' and analytic_or_track='0' ");
	}
	//echo $this->db->last_query();
	?>
		<!--<div class="row">
			<div class="col-sm-12">
				<div class="page-title-box">
					<div class="float-right">
						<div class="dropdown">
							<button class="btn btn-secondary btn-round dropdown-toggle px-3" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="mdi mdi-settings mr-1"></i>Select Survey
							</button>
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
								<a class="dropdown-item" href="#">This is an experimental awesome solution for responsive tables with complex data.</a>
								<a class="dropdown-item" href="#">This is an experimental awesome solution for responsive tables with complex data.This is an experimental awesome solution for responsive tables with complex data.</a>
								<a class="dropdown-item" href="#">This is an experimental awesome solution for responsive tables with complex data.This is an experimental awesome solution for responsive tables with complex data.</a>
							</div>
						</div>
					</div>
					<h4 class="page-title">Saved Tables</h4>
				</div>
			</div>
		</div>-->
		<?php if($table_query->num_rows()>0){$table_query=$table_query->result_array(); ?>
		<div class="row">
			<?php 
			foreach($table_query as $tq){
				$row_percent=0;
				$col_percent=0;
				$tq_new=(array) json_decode($tq['analytics_post_data']);
				if(isset($tq_new['row_percent']) && $tq_new['row_percent']=="1"){
					$row_percent="1";
				}
				if(isset($tq_new['col_percent']) && $tq_new['col_percent']=="1"){
					$col_percent="1";
				}
				//echo $row_percent." ".$col_percent;
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
			<div class="col-md-12 col-xl-12">
				<div class="card">
					<div class="card-body ajaxgraph" id="<?php echo $rand; ?>">
					<textarea style="display:none" type="text" name="analytics_graph_url"><?php echo $tq['analytics_graph_url']; ?></textarea>
					<textarea style="display:none" type="text" name="analytics_post_data"><?php echo $tq['analytics_post_data']; ?></textarea>
					</div>
				</div>
			</div> 
			<?php 
			if(strstr($tq['analytics_graph_url'],"table2x2")){
				echo '<script type="text/javascript">function func'.$rand.'(){calculateRowColumnPercent("'.$row_percent.'","'.$col_percent.'");}</script>';
			}else if(strstr($tq['analytics_graph_url'],"table_layer")){
				echo '<script type="text/javascript">function func'.$rand.'(){calculateRowColumnPercent("'.$row_percent.'","'.$col_percent.'");}</script>';
			}else if(strstr($tq['analytics_graph_url'],"table")){
				echo '<script type="text/javascript">function func'.$rand.'(){calculateRowColumnPercent("'.$row_percent.'","'.$col_percent.'");}</script>';
			}else{}
			?>
			<?php } ?>
		</div><!-- end row-->
		<?php } ?>
	<script type="text/javascript">
	$(document).ready(function(){
		$('.ajaxgraph').each(function(){
			var box=$(this);
			var fid="func"+box.attr('id');
			var analytics_graph_url=box.find('[name="analytics_graph_url"]').val();
			//console.log(analytics_graph_url);
			var analytics_post_data=box.find('[name="analytics_post_data"]').val();
			//console.log(analytics_post_data);
			//var chartType=JSON.parse(analytics_post_data).chartType;
			var analytics_post_data=JSON.parse(analytics_post_data);
			var rows=JSON.stringify(analytics_post_data.rows);
			var columns=JSON.stringify(analytics_post_data.columns);
			var layer=JSON.stringify(analytics_post_data.layer);
			var indicators=JSON.stringify(analytics_post_data.indicators);
			var indicators_dataid=JSON.stringify(analytics_post_data.indicators_dataid);
			var row_percent=JSON.stringify(analytics_post_data.row_percent);
			var col_percent=JSON.stringify(analytics_post_data.col_percent);
			//console.log(indicators_dataid);
			$.ajax({
				url: "<?php echo base_url(); ?>"+analytics_graph_url, // url where to submit the request
				type : "POST", // type of action POST || GET
				data :{"rows":rows, "columns":columns, "layer":layer, "indicators":indicators, "indicators_dataid":indicators_dataid, "row_percent":row_percent, "col_percent":col_percent},
				success : function(result) {
					box.html(result);
					//console.log("calling:"+fid);
					setTimeout(function(){
						box.find('.outer').addClass('table');
						fn = window[fid];
						//console.log(fn);
						if (typeof fn == 'function') { 
						eval(fid+"()");
						}					
					},1000)
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
						var $temp = $("<input>");
						$("body").append($temp);
						$temp.val(gc.html()).select();
						document.execCommand("copy");
						alert('Copied To Clipboard!');
						$temp.remove();	
					}
				}
			}
		});
	});	
	</script>
<?php } ?>
