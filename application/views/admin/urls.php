  <div id="page-wrapper">
	<div class="row">
      <div class="col-lg-12">
        <!-- /.panel -->
        <div class="panel panel-default">
          <!--<div class="panel-heading"> <i class="fa fa-user fa-fw"></i> User</div>-->
          <!-- /.panel-heading -->
          <div class="panel-body">
            <div class="row">
              <div class="col-lg-12">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover table-striped">
                    <thead>
                      <tr>
                        <th width="5%">id</th>
                        <th>Urls</th>
						<th width="15%">Operations</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php foreach($query as $url) { ?>
                      <tr>
                        <td><?php echo $url['id']; ?></td>
                        <td><?php echo $url['url']; ?></td>
						<td>
							<a href="<?php echo base_url().'admin/urls/edit/'.$url['id'];?>">
								<i class="fa fa-pencil fa-fw"></i>
							</a>
							<a href="<?php echo base_url().'admin/urls/delete/'.$url['id'];?>" onclick="return confirm('Are you sure');">
								<i class="fa fa-trash fa-fw"></i>
							</a>
                     	</td>
                      </tr>
					  <?php } ?>
                    </tbody>
                  </table>
				<tfoot>
				<?php echo $this->pagination->create_links(); ?>
				</tfoot>
                </div>
                <!-- /.table-responsive -->
              </div>
            </div>
            <!-- /.row -->
          </div>
          <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
        <!-- /.panel -->
      </div>
      <!-- /.col-lg-8 -->
      <!-- /.col-lg-4 -->
    </div>
    <!-- /.row -->
    <!-- /.row -->
    <!-- /.row -->
  </div>