<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <div class="login-panel panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title text-center">Admin<img src="<?php echo base_url().'assests';?>/image/login.png" width="50px;"  alt="Logo"></h3>
        </div>
        <div class="panel-body">
          <form role="form" action="<?php echo base_url().'admin/login/login';?>" method="post">
            <fieldset>
              <div class="form-group">
                <input class="form-control" placeholder="Username" name="username" id="username" type="text" autofocus>
              </div>
              <div class="form-group">
                <input class="form-control" placeholder="Password" name="password" id="password" type="password" value="">
              </div>
              <!--
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div> -->
              <!-- Change this to a button or input when using this as a form -->
              <input type="submit" class="btn btn-lg btn-success btn-block" name="submit" id="submit" value="Login" />
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
