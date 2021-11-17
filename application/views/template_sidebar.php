<div class="sidebar-inner slimscrollleft" id="sidebar-main">
	<div id="sidebar-menu">
		<ul class="nav nav-tabs thematic-list active tab_1_menu" role="tablist">
			<?php if($this->session->userdata('user_logged_id')){ ?>
			<li>
				<a href="<?php echo base_url(); ?>" class="waves-effect waves-light"><i class="fa fa-tag"></i><span> Home  </span></a>
			</li>
			<?php } ?>			
			<li class="menu-title">Thematic Area</li>
			<?php
			$sectorArr=unserialize(SECTOR);
			foreach($sectorArr as $s_k=>$s_v){
				$total=0;
				$s_v_key=strtolower($s_v);
				$s_v_key=str_replace(' ','-',$s_v_key);
				$q=$this->db->query("select count(*) as total from survey where access='1' and sector='".$s_k."' and title!='' ");
				//echo $this->db->last_query();
				if($q->num_rows()>0){
					$q=$q->result_array();
					$total=$q[0]['total'];
				}
			?>
			<li class="active"> 
			<a href="<?php echo base_url()."template/".$s_v_key; ?>" role="tab" aria-selected="false" class="waves-effect waves-light <?php if($s_v_key==$sector){echo 'active';}?>"><i class="mdi mdi-calendar-clock"></i>
			<span> <?php echo $s_v; ?> </span>
			<span class="badge badge-pill badge-success float-right"><?php echo $total; ?></span>
			</a> </li>
			<?php } ?>
			<!--<li class="active" id="thematic-1"> <a data-toggle="tab" href="#public-health" role="tab" aria-selected="false" class="waves-effect waves-light active"><i class="mdi mdi-calendar-clock"></i><span> Public health </span><span class="badge badge-pill badge-success float-right">149</span></a> </li>
			<li class="" id="thematic-2"> <a data-toggle="tab" href="#wash" role="tab" aria-selected="false" class="waves-effect waves-light"><i class="mdi mdi-calendar-clock"></i><span> Wash </span><span class="badge badge-pill badge-success float-right">45</span></a> </li>
			<li class="" id="thematic-3"> <a data-toggle="tab" href="#nutrition" role="tab" aria-selected="false" class="waves-effect waves-light"><i class="mdi mdi-calendar-clock"></i><span> Nutrition </span><span class="badge badge-pill badge-success float-right">120</span></a> </li>-->
		</ul>
	</div>
	<div class="clearfix"></div>
</div>