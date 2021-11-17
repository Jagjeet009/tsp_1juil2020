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
		<a href="<?php echo base_url()."dashboard/trackmytable/".$dashboard_url; ?>" class="btn btn-primary">My Tables</a>
	</h6>
	<h6>
		<a href="<?php echo base_url()."dashboard/trackmychart/".$dashboard_url; ?>" class="btn btn-success">My Charts</a>
	</h6>	
	<h6>
		<div class="dropdown survey-selector">
		  <a class="btn btn-info dropdown-toggle" href="javascript:void(0)" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Select a survey
		  </a>

		  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
		  	<?php foreach($surveys as $survey){?>
		  	<a class="dropdown-item <?php if($survey_id==$survey['title_url']){echo 'active';} ?>" href="<?php echo base_url()."dashboard/records/".$dashboard_url."/".$survey['title_url']; ?>"><?php echo $survey['title']; ?></a>
		  	<?php } ?>
		  </div>
		</div>		
	</h6>
</div>
<div class="row">
	<?php 
	if(isset($survey_id) && $survey_id!=''){
		foreach($surveys as $s){
			if($s['title_url']==$survey_id){
	?>
			<div class="col-md-12 col-xl-12">
				<div class="card" style="height:420px;">
					<div class="card-body ajaxgraph" id="<?php echo $s['title_url'] ?>">
						<h6 class="text-uppercase mb-3"><?php print_r($s['title']); ?></h6>
						<div></div>
					</div>
				</div>
			</div>	
	<?php 	}
		}
	}else{
		foreach($surveys as $s){?>
	<div class="col-md-12 col-xl-12">
		<div class="card" style="height:420px;">
			<div class="card-body ajaxgraph" id="<?php echo $s['title_url'] ?>">
				<h6 class="text-uppercase mb-3"><?php print_r($s['title']); ?></h6>
				<div></div>
			</div>
		</div>
	</div>
<?php }}} ?>		                
</div>	
	<!--<script type="text/javascript" src="https://www.google.com/jsapi"></script>	-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>	
	<script type="text/javascript">
	//google.load('visualization', '1', {packages: ['corechart','controls', 'charteditor']});
	google.charts.load('current', {packages: ['corechart', 'bar', 'table', 'gauge', 'controls', 'charteditor']});
	$(document).ready(function(){
		$('.ajaxgraph').each(function(){
			var container=$(this);
			var box_name=$(this).attr('id');
			var box_div=$('#'+box_name+'>div'); 
			var box=$('#'+box_name); 
			
			var queue = Promise.resolve(); 
			queue = queue.then(function(){
				//console.log("starting blank start");
				return $.get('<?php echo base_url()."survey/analytics/recordchart/"; ?>'+box_name);
			});
			queue.then(function(result){
				//console.log("getting first result");
				box_div.append(result);
				
				var si=setInterval(function(){
				 var l=box.find('div div.columnchart_values>img').length;
					if(l>0){
						//console.log("found: "+l);
						clearInterval(si);
						
						var data_url=box.find('div div.columnchart_values>img').last().attr('src');
						var image_name=container.find('.columnchart_values').attr('id');
						return $.post('<?php echo base_url(); ?>survey/analytics/png2/'+image_name,{"data_url":data_url});
					}else{
						//console.log("searching: "+l);
					}
				}, 1000);				
				
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
						var img=document.createElement('img');
						img.src='<?php echo base_url()."uploads/dashboard_chart_" ?>'+image_name+".png";
                                                console.log(img.src);
						gc.append(img);
						//console.log(gc);
						var img=gc.find('>img');
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