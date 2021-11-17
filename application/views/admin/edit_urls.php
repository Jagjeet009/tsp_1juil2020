<?php 
if($query->result_id->num_rows>0){
	foreach ($query->result() as $field){
	}
}
//print_r($field); 
?>
  <div id="page-wrapper">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header"><?php print_r($heading);?>   </h1>
      </div>
      <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
	<div class="row">
	  <div class="col-lg-12">
	<div class="panel-body">
	  <div class="row">
		<div class="col-lg-6">
		  <form role="form" action="<?php echo base_url().'admin/urls/save';?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="id" id="id" class="form-control" value="<?php echo $field->id; ?>">
			<div class="form-group">
				<label>Url</label>
				<input name="url" class="form-control" value="<?php echo $field->url; ?>">
				<?php echo form_error('url', '<div style="color: red;">', '</div>'); ?>
			</div>
			<div class="form-group">
				<label>Head Tags</label>
				<textarea name="tags" class="form-control" rows="15"><?php echo $field->tags; ?></textarea>
				<?php echo form_error('tags', '<div style="color: red;">', '</div>'); ?>
			</div>
			<input class="btn btn-success" type="submit" value="Submit" />
			<input class="btn btn-warning" type="reset" value="Reset" />
		  </form>
		</div>
		<!-- /.col-lg-6 (nested) -->
	  </div>
	  <!-- /.row (nested) -->
	</div>
		<!-- /.panel -->
	  </div>
	  <!-- /.col-lg-12 -->
	</div>
  </div>
