<div class="sidebar-inner slimscrollleft" id="sidebar-main">
	<div id="sidebar-menu">
		<ul class="nav nav-tabs thematic-list active tab_1_menu" role="tablist">
			<?php if($this->session->userdata('user_logged_id')){ ?>
			<li>
				<a href="javascript:void(0)" class="waves-effect waves-light" onclick="primaryDashboard()"><i class="fa fa-tag"></i><span> Home  </span></a>
			</li>
			<?php } ?>
			<li class="menu-title">Thematic Area</li>
<?php
$thematic_areas=$this->db->query("SELECT * FROM questionbank_thematica where parent_thematica='0' order by id asc");
if($thematic_areas->num_rows()>0){
	$thematic_areas=$thematic_areas->result_array();
	//print_r($thematic_areas);
	$i=0;
	foreach($thematic_areas as $ta){
		$i++;
		$total_thematica=$this->db->query("SELECT count(*) as total FROM questionbank where thematica_id='".$ta['id']."' ");
		if($total_thematica->num_rows()>0){
			$total_thematica=$total_thematica->result_array();
			$total_thematica=$total_thematica[0]['total'];
		}
		$has_inner=0;
		$has_inner=$this->db->query("SELECT count(*) as count_inner FROM questionbank_thematica where parent_thematica='".$ta['id']."' ");
		if($has_inner->num_rows()>0){
			$has_inner=$has_inner->result_array();
			$has_inner=$has_inner[0]['count_inner'];
		}
		if($has_inner<1){?>
		<li class="<?php if($i==1){echo 'active';} ?>" id="thematic-<?php echo $ta['id']; ?>">
			<a data-toggle="tab" href="#<?php echo $ta['thematica_code']; ?>" role="tab" aria-selected="false" class="waves-effect waves-light <?php if($i==1){echo 'active';} ?>">
			<i class="fa fa-tag"></i>
			<span> <?php echo $ta['thematica_name']; ?> </span>
			<span class="badge badge-pill badge-success float-right"><?php echo $total_thematica; ?></span>
			</a> 
		</li>		
		<?php }else{?>
		<li class="has_sub">
			<a href="javascript:void(0);" class="waves-effect waves-light menu-sub">
			<i class="fa fa-tag"></i>
			<span> <?php echo $ta['thematica_name']; ?> </span>
			<span class="float-right"><i class="fa fa-chevron-right"></i></span>
			</a> 
			<ul class="list-unstyled nav nav-tabs" role="tablist" style="display:none;">
			<?php 
			$thematic_areas2=$this->db->query("SELECT * FROM questionbank_thematica where parent_thematica='".$ta['id']."' order by id asc");
			if($thematic_areas2->num_rows()>0){
				$thematic_areas2=$thematic_areas2->result_array();
				$k=0;
				foreach($thematic_areas2 as $ta2){
					$k++;
					$total_thematica2=$this->db->query("SELECT count(*) as total FROM questionbank where thematica_id='".$ta2['id']."' ");
					if($total_thematica2->num_rows()>0){
						$total_thematica2=$total_thematica2->result_array();
						$total_thematica2=$total_thematica2[0]['total'];
					}		
			?>
				<li id="thematic-<?php echo $ta2['id']; ?>">
					<a data-toggle="tab" href="#<?php echo $ta2['thematica_code']; ?>" role="tab" aria-selected="false">
					<?php echo $ta2['thematica_name']; ?>
					<span class="badge badge-pill badge-success float-right"><?php echo $total_thematica2; ?></span>
					</a>
				</li>
			<?php }} ?>				
			</ul>
		</li>	
		<?php } ?>
<?php }} ?>
		</ul>
	</div>
	<div class="clearfix"></div>
</div>