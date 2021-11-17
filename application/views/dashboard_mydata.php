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
		<div class="col-md-12 col-lg-12 col-xl-12">
			<div class="card mini-stat">
				<div class="mini-stat-icon text-right">
					<h6 class="text-uppercase mb-3">Statistic</h6>
					<i class="mdi mdi-cube-outline"></i>
				</div>
				<div class="p-4">
					<table class="table  table-striped">
						<thead>
						<tr>
							<th>Survey</th>
							<th>Sample</th>
							<th>Achivements</th>
							<th>Start-Date</th>
							<th>End-Date</th>
						</tr>
						</thead>
						<tbody>
						<?php 
							$achievement=0;
							foreach($surveys as $survey){ 
								$achievement=$this->db->query("select count(*) as total from survey_values where survey_id='".$survey['title_url']."' ");
								//echo $this->db->last_query();
								if($achievement->num_rows()>0){
									$achievement=$achievement->result_array();
									$achievement=$achievement[0]['total'];
									$start_date=0;
									$end_date=0;
									if($start_date!=''){
										$start_date=date('d M, Y',$survey['start_date']);
									}
									if($start_date!=''){
										$end_date=date('d M, Y',$survey['end_date']);
									}
								}
						?>
						<tr>
							<td><?php echo $survey['title']; ?></td>
							<td><?php echo $survey['survey_sample']; ?></td>
							<td><?php echo $achievement; ?></td>
							<td><?php echo $start_date; ?></td>
							<td><?php echo $end_date; ?></td>
						</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div><!-- end row -->
<?php } ?>
