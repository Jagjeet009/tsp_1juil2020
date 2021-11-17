<div class="tab-content content-block thematic-content">
<?php
$thematica_content=$this->db->query("SELECT * FROM questionbank_thematica where id not in (select distinct(parent_thematica) from questionbank_thematica) order by id asc");
if($thematica_content->num_rows()>0){
	$thematica_content=$thematica_content->result_array();
	$m=0;
	foreach($thematica_content as $tc){
	$m++;
?>
<div class="tab-pane p-3 <?php if($m==1){echo ' active show ';} ?>" id="<?php echo $tc['thematica_code']; ?>" role="tabpanel">
	<div class="row">
	<?php
	$thematica_questionbank=$this->db->query("SELECT * FROM questionbank where thematica_id='".$tc['id']."' order by id asc");
	if($thematica_questionbank->num_rows()>0){
		$thematica_questionbank=$thematica_questionbank->result_array();
		foreach($thematica_questionbank as $tqb){
	?>	
		<div class="col-lg-4 country-<?php echo $tqb['country_id']; ?>">
			<div class="card m-b-30 text-white bg-dark">
				<div class="tab-btn"> 
					<a href="<?php echo base_url()."questionbank/".$tqb['filename1']; ?>" class="btn btn-outline-danger waves-effect waves-light" download>Download</a> 
					<!--<a href="<?php echo $tqb['website_link']; ?>" class="btn btn-outline-info waves-effect waves-light" target="_blank">View</a> -->
					<a href="https://docs.google.com/viewer?url=<?php echo base_url()."questionbank/".$tqb['filename1']; ?>&embedded=true" class="btn btn-outline-info waves-effect waves-light" target="_blank">View</a> 
				</div>
				<div class="card-body">
					<blockquote class="card-blockquote">
						<h6> <?php echo $tqb['title']; ?> </h6>
						<footer>Source : <cite> <?php echo $tqb['source']; ?> </cite> </footer>
					</blockquote>
				</div>
			</div>
		</div>									   
	<?php }} ?>
	</div>
</div>
<?php }} ?>
</div>