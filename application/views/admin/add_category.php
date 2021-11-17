<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php print_r($heading);?> </h1>
		</div>
		<!-- /.row -->
		<div class="row">
			<div class="col-lg-12">
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">
							<form role="form" action="<?php echo base_url().'admin/category/save';?>" method="post" enctype="multipart/form-data">
								<div class="form-group">
									<label>Name</label>
									<input name="name" id="name" class="form-control" value="<?php echo set_value('name'); ?>">
									<?php echo form_error('name', '<div style="color: red;">', '</div>'); ?>
								</div>
								<input class="btn btn-success" type="submit" value="Submit"/>
								<input class="btn btn-warning" type="reset" value="Reset"/>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>