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
                        <th>id</th>
                        <th>Name</th>
                        <th>Email Id</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Contact</th>
						<th>Operations</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php foreach($query as $user) { ?>
                      <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['name']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['password']; ?></td>
                        <td><?php echo $user['contact']; ?></td>
						<td>
							<a href="<?php echo base_url().'admin/users/edit/'.$user['id'];?>">
								<i class="fa fa-pencil fa-fw"></i>
							</a>
							<a href="<?php echo base_url().'admin/users/delete/'.$user['id'];?>" onclick="return confirm('Are you sure');">
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