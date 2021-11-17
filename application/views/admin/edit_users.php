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
		  <form role="form" action="<?php echo base_url().'admin/users/save';?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="id" id="id" class="form-control" value="<?php echo $field->id; ?>">
			<div class="form-group">
				<label>Name</label>
				<input name="name" class="form-control" value="<?php echo $field->name; ?>">
				<?php echo form_error('name', '<div style="color: red;">', '</div>'); ?>
			</div>
			<div class="form-group">
				<label>Email</label>
				<input name="email" class="form-control" value="<?php echo $field->email; ?>">
				<?php echo form_error('email', '<div style="color: red;">', '</div>'); ?>
			</div>
			<div class="form-group">
				<label>Username</label>
				<input name="username"  class="form-control" value="<?php echo $field->username; ?>" readonly>
				<?php echo form_error('username', '<div style="color: red;">', '</div>'); ?>
			</div>
			<div class="form-group">
				<label>Password</label>
				<input type="text" name="password" class="form-control" value="<?php echo $field->password; ?>" />
				<?php echo form_error('password', '<div style="color: red;">', '</div>'); ?>
			</div>
			<div class="form-group">
				<label>Contact</label>
				<input type="text" name="contact" class="form-control" value="<?php echo $field->contact; ?>" />
				<?php echo form_error('contact', '<div style="color: red;">', '</div>'); ?>
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
