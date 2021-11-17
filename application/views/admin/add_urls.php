<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php print_r($heading);?> </h1>
		</div>
		<!-- /.row -->
		<div class="row">
			<div class="col-lg-12">
				<div class="panel-body">
					<form role="form" action="<?php echo base_url().'admin/urls/save';?>" method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="form-group">
								<label>Url</label>
								<input type="text" name="url" class="form-control" required>
							</div>
							<div class="form-group">
								<label>Head Tags</label>
								<textarea name="tags" class="form-control" rows="15"></textarea>
							</div>										
						</div>
						<div class="row">
							<input class="btn btn-success" type="submit" value="Submit"/>
							<input class="btn btn-warning" type="reset" value="Reset"/>
						</div>					
					</form>
				</div>
			</div>
		</div>
	</div>
</div>