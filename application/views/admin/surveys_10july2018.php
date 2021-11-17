  <div id="page-wrapper">
	<div class="row">
      <div class="col-lg-12 report-survey">
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>Id</th>
						<th>Survey Name</th>
						<th>Total No Of Sections</th>
						<th>Total No Of Questions</th>
						<th>Total No Of Entries</th>
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
				?>
					<tr>
						<td><?php echo $s['id']; ?></td>
						<td><?php echo $s['title']; ?> [ <?php echo $s['title_url']; ?> ]</td>
						<td><?php echo sizeof($sections); ?></td>
						<td><?php echo $questions; ?></td>
						<td><?php echo $entries; ?></td>
						<td><a href="<?php echo base_url()."admin/survey/delete/".$s['id']; ?>">Delete</a></td>
					</tr>
				<?php }} ?>
				</tbody>
			</table>
      </div>
    </div>
  </div>