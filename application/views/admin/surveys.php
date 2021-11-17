  <div id="page-wrapper">
	<div class="row">
      <div class="col-lg-12 report-survey">
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>Id</th>
						<th>Owner</th>
						<th>Survey Name</th>
						<th>Total No Of Sections</th>
						<th>Total No Of Questions</th>
						<th>Total No Of Entries</th>
						<th>Designers</th>
						<th>Fillers</th>
						<th>Analyzers</th>
						<th>Operations</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				if(sizeof($surveys)>0){
					foreach($surveys as $s){ 
						$sections=array();
						$questions='0';
						$entries='0';
						$s['owner']='';
						if($s['section_sort_id']!=''){
							$sections=$s['section_sort_id'];
							$sections=explode(',',$sections);
							$questions=$this->db->query("select count(id) as total from survey_data where survey_id in (select title_url from survey_section where id in ('".implode("','",$sections)."'))");
							if($questions->num_rows()>0){
								$questions=$questions->result_array();
								$questions=$questions[0]['total'];
							}
							$entries=$this->db->query("select count(id) as total from survey_values where survey_id='".$s['title_url']."'");
							if($entries->num_rows()>0){
								$entries=$entries->result_array();
								$entries=$entries[0]['total'];
							}
						}
						if($s['user_id']!='0' && $s['user_id']!=0){
							$owner_q=$this->db->query("select username from users where id='".$s['user_id']."'");
							if($owner_q->num_rows()>0){
								$owner=$owner_q->result_array();
								$owner=$owner[0]['username'];
								if($owner!=''){
									$s['owner']=$owner;
								}
							}else{
									$s['owner']='';
							}							
						}
						if($s['permission_design']!=''){
							$s['permission_design']=(array) json_decode($s['permission_design']);
							$s['permission_design']=implode(', ',$s['permission_design']);
						}						
						if($s['permission_fill']!=''){
							$s['permission_fill']=(array) json_decode($s['permission_fill']);
							$s['permission_fill']=implode(', ',$s['permission_fill']);
						}						
						if($s['permission_analytics']!=''){
							$s['permission_analytics']=(array) json_decode($s['permission_analytics']);
							$s['permission_analytics']=implode(', ',$s['permission_analytics']);
						}						
				?>
					<tr>
						<td><?php echo $s['id']; ?></td>
						<td><?php echo $s['owner']; ?></td>
						<td><?php echo $s['title']; ?> [ <?php echo $s['title_url']; ?> ]</td>
						<td><?php echo sizeof($sections); ?></td>
						<td><?php echo $questions; ?></td>
						<td><?php echo $entries; ?></td>
						<td><?php echo $s['permission_design']; ?></td>
						<td><?php echo $s['permission_fill']; ?></td>
						<td><?php echo $s['permission_analytics']; ?></td>
						<td><a href="<?php echo base_url()."admin/survey/delete/".$s['id']; ?>">Delete</a></td>
					</tr>
				<?php }} ?>
				</tbody>
			</table>
      </div>
    </div>
  </div>