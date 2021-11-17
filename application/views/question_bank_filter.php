<div class="page-title-box">
	<div class="float-right">
		<div class="dropdown">
			<select class="form-control select-country">
				<option disabled selected>Select Country</option>		
				<?php
				$country=$this->db->query("SELECT * FROM questionbank_countries order by country asc");
				if($country->num_rows()>0){
					$country=$country->result_array();
					foreach($country as $c){
						$thematica_ids=array();
						$thematica=$this->db->query("SELECT thematica_id FROM questionbank where country_id='".$c['id']."' ");
						if($thematica->num_rows()>0){
							$thematica=$thematica->result_array();
							foreach($thematica as $thema){
								if(!in_array($thema['thematica_id'],$thematica_ids)){
									array_push($thematica_ids,$thema['thematica_id']);
								}
							}
						}
						if(sizeof($thematica_ids)>0){
						$thematica_ids=" thematic-".implode(" thematic-",$thematica_ids);
						}else{
							$thematica_ids='';
						}
						//print_r($thematica_ids);
				?>
				<option id="country-<?php echo $c['id']; ?>" class="<?php echo $thematica_ids; ?>"><?php echo $c['country']; ?></option>
				<?php }} ?>
			</select>
		</div>
	</div>
	<h4 class="page-title">Thematic List</h4>
</div>
