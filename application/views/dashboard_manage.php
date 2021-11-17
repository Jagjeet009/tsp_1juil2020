<?php
//print_r($surveys);
$survey_title_urls=array();
foreach($surveys as $s){
	array_push($survey_title_urls,$s['title_url']);
}
?>        
<div class="col-md-12 col-lg-6 col-xl-6">
	<div class="card mini-stat index2">
		<div class="mini-stat-icon text-right">
			<h6 class="text-uppercase mb-3">Dashboard</h6>
			<i class="mdi mdi-clipboard-text"></i>
		</div>
		<div class="p-4">
		   <?php
			$q=$this->db->query("select * from dashboards where username='".$this->session->userdata('user_logged_username')."' ");
			if($q->num_rows()>0){
				$q=$q->result_array();
				foreach($q as $qq){
					$q2=$this->db->query("select a.*,b.dashboard_name,c.title from dashboard_surveys as a,dashboards as b,survey as c where a.dashboard_url=b.dashboard_url && a.survey_title_url=c.title_url && a.dashboard_url='".$qq['dashboard_url']."' ");
					if($q2->num_rows()>0){
						$q2=$q2->result_array();
						echo '<div class="dashboard-list" data-dashboard="'.$qq['dashboard_url'].'">';
						echo '<h5>'.$qq['dashboard_name'].'</h5>';
						foreach($q2 as $qq2){
							echo '<p data-survey="'.$qq2['survey_title_url'].'" class="active-1">'.$qq2['title'].' <i class="fa fa-times"></i></p>';
						}
						echo '</div>';
					}else{
						echo '<div class="dashboard-list" data-dashboard="'.$qq['dashboard_url'].'">';
						echo '<h5>'.$qq['dashboard_name'].'</h5>';
						echo '</div>';
					}

				}
			}
			?>
		</div>
	</div>
</div>
<div class="col-md-12 col-lg-6 col-xl-6">
	<div class="card mini-stat index2">
		<div class="mini-stat-icon text-right">
			<h6 class="text-uppercase mb-3">Assign</h6>
			<p style="position: absolute;top: 50px;left: 35px;text-align: left;right: 100px;">Drag and Drop to assign surveys to respective dashboards </p>
			<i class="mdi mdi-format-list-bulleted"></i>
		</div>
		<div class="p-4">
			<ul id="survey-list">
			   <?php
				$q=$this->db->query("select * from survey where title_url in ('".implode("','",$survey_title_urls)."') ");
				//echo $this->db->last_query();
				if($q->num_rows()>0){
					$q=$q->result_array();
					foreach($q as $qq){
						$q2=$this->db->query("select * from dashboard_surveys where survey_title_url='".$qq['title_url']."' ");
						if($q2->num_rows()>0){
							echo '<li class="draggable" data-survey="'.$qq['title_url'].'" style="display:none;">'.$qq['title'].'</li>';
						}else{
							echo '<li class="draggable" data-survey="'.$qq['title_url'].'">'.$qq['title'].'</li>';
						}
					}
				}
				?>                                            
				<!--<li class="draggable">Survey list 1</li>
				<li class="draggable">Survey list number 2</li>
				<li class="draggable">Survey list number third 3</li>
				<li class="draggable">Survey list 4 long name than other.</li>
				<li class="draggable">Survey list 5 with little longer name than others</li>
				<li class="draggable">Survey 6</li>
				<li class="draggable">Survey list 7 longer name after a short name</li>
				<li class="draggable">Survey list 8 is the list item with the longest name in comparison of any other list item</li>-->
			</ul>
		</div>
	</div>
</div>
