<?php 
//echo $sector." ".$country; 
$countryArr=unserialize(COUNTRY);
$sectorArr=unserialize(SECTOR);
if($sector!='' && $country==''){
	foreach($sectorArr as $s_k=>$s_v){
		$s_v_key=strtolower($s_v);
		$s_v_key=str_replace(' ','-',$s_v_key);
		if($s_v_key==$sector){
			$sector=$s_k;
		}
	}
	$q="select * from survey where access='1' && sector='".$sector."'";
}else if($sector!='' && $country!=''){
	foreach($sectorArr as $s_k=>$s_v){
		$s_v_key=strtolower($s_v);
		$s_v_key=str_replace(' ','-',$s_v_key);
		if($s_v_key==$sector){
			$sector=$s_k;
		}
	}	
	foreach($countryArr as $c_k=>$c_v){
		$c_v_key=strtolower($c_v);
		$c_v_key=str_replace(' ','-',$c_v_key);
		if($c_v_key==$country){
			$country=$c_k;
		}
	}		
	$q="select * from survey where access='1' && sector='".$sector."' && country='".$country."' ";
}else{}
$q=$this->db->query($q);
//echo $this->db->last_query();
if($q->num_rows()>0){
	$q=$q->result_array();
?>
	<div class="row">
	<?php foreach($q as $qq){?>
		<?php
			foreach($sectorArr as $s_k=>$s_v){
				$s_v_key=strtolower($s_v);
				$s_v_key=str_replace(' ','-',$s_v_key);
				if($qq['sector']==$s_k){
					$qq['sector']=$s_v_key;
				}
			}	
			foreach($countryArr as $c_k=>$c_v){
				$c_v_key=strtolower($c_v);
				$c_v_key=str_replace(' ','-',$c_v_key);
				if($qq['country']==$c_k){
					$qq['country']=$c_v_key;
				}
			}
			$s_v_key=strtolower($s_v);
			$s_v_key=str_replace(' ','-',$s_v_key);		
		?>
		<div class="col-lg-4 country-50">
			<div class="card m-b-30 text-white bg-dark">
				<div class="tab-btn"> 
				<a href="javascript:void(0)" onclick="duplicateSurvey('<?php echo $qq['title_url']; ?>')" class="btn btn-outline-success waves-effect waves-light">Use this template</a> 
				<a href="<?php echo base_url()."template/view/".$qq['sector']."/".$qq['country']."/".$qq['title']."/".$qq['title_url']; ?>" class="btn btn-outline-info waves-effect waves-light" target="_blank">View template</a> 
				</div>
				<div class="card-body">
					<blockquote class="card-blockquote">
						<h6><?php echo $qq['title']; ?></h6>
						<!--<footer>Source : <cite> Metagenics</cite> </footer>-->
					</blockquote>
				</div>
			</div>
		</div>
	<?php } ?>
	</div>
<?php }else{?>
	<div class="row">
		<div class="col-md-12 col-xl-12 mr-auto">
			<div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
				<i class="mdi mdi-alert font-32"></i><h3><strong class="pr-1"></strong> No templates for this sector</h3>
			</div>
		</div>
	</div><!-- end row -->		
<?php } ?>
