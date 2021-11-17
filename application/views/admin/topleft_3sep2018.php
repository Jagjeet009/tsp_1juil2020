<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
<div class="navbar-header">
<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
<a class="navbar-brand" href="<?php echo base_url().'admin/dashboard'; ?>"><?php echo strtoupper(basename(base_url()));?></a> </div>
<ul class="nav navbar-top-links navbar-right">
	<li class="dropdown"> <a class="dropdown-toggle" href="<?php echo base_url().'admin/dashboard';?>">Dashboard</a></li>
	<li class="dropdown"> <a class="dropdown-toggle" href="<?php echo base_url().'admin/survey';?>">Surveys</a></li>
	
	<!--<li class="dropdown"> <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)"> Category<i class="fa fa-caret-down"></i></a>
		<ul class="dropdown-menu dropdown-user">
			<li><a href="<?php echo base_url().'admin/category'; ?>">Categories</a> </li>
			<li><a href="<?php echo base_url().'admin/category/add'; ?>">Add Category</a> </li>
		</ul>
	</li>-->
	<li class="dropdown"> <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i> </a>
		<ul class="dropdown-menu dropdown-user">
			<li><a href="<?php echo base_url().'admin/logout';?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a> </li>
		</ul>
	</li>
</ul>
</nav>