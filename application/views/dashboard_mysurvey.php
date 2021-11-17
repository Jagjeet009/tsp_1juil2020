<?php
//print_r($surveys);
//print_r($surveys_list);
//print_r($user_data);
//print_r($surveys_design_list);
//print_r($surveys_fill_list);
//print_r($surveys_analytics_list);
//print_r($user_list);
//print_r($design_list);
//print_r($fill_list);
//print_r($analytics_list);
?>                   
<?php if(sizeof($surveys)<1){?>
	<div class="row">
		<div class="col-md-12 col-xl-12 mr-auto">
			<div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
				<i class="mdi mdi-alert font-32"></i><h3><strong class="pr-1"></strong> No surveys created yet</h3>
			</div>
		</div>
	</div><!-- end row -->	
<?php }else{ ?>
<div class="col-md-12 col-lg-12 col-xl-12">
	<div class="card mini-stat">
		<div class="mini-stat-icon text-right">
			<h6 class="text-uppercase mb-3">My Surveys</h6>
			<i class="mdi mdi-cube-outline"></i>
		</div>
		<div class="p-4">
			<table class="table  table-striped">
				<thead>
				<tr>
					<th colspan="6">List</th>
				</tr>
				</thead>
				<tbody>
				<?php $i=0;foreach($surveys as $survey){$i++; 	//logged		
					$available1='btn-danger';
					$available2='btn-danger';
					$available3='btn-danger';
					$available4='btn-danger';
					$availableCode1='javascript:void(0)';
					$availableCode2='javascript:void(0)';
					$availableCode3='javascript:void(0)';
					$availableCode4='javascript:void(0)';
				?>
				<?php if(in_array($survey['title_url'],$design_list)){$available1='btn-primary';$availableCode1="javascript:chooseSurvey('".$survey['title_url']."');";}?>
				<?php if(in_array($survey['title_url'],$fill_list)){$available2='btn-primary';$availableCode2="javascript:chooseSurveyAndFill('".$survey['title_url']."');";}?>
				<?php if(in_array($survey['title_url'],$analytics_list)){$available3='btn-primary';$availableCode3="javascript:chooseSurveyAndAnalytics('".$survey['title_url']."');";}?>
				<?php if(in_array($survey['title_url'],$user_list)){$available4='btn-primary';$availableCode4="javascript:shareSurvey('".$survey['title_url']."');";}?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $survey['title']; ?></td>
						<td width="10%"><a class="btn <?php echo $available1; ?>" href="<?php echo $availableCode1; ?>">Design</a></td>
						<td width="10%"><a class="btn <?php echo $available2; ?>" href="<?php echo $availableCode2; ?>">Enter</a></td>
						<td width="10%"><a class="btn <?php echo $available3; ?>" href="<?php echo $availableCode3; ?>">Analyze</a></td>
						<td width="10%"><a class="btn <?php echo $available4; ?>" href="<?php echo $availableCode4; ?>">Share</a></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php } ?>
