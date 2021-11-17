<div class="sidebar-inner slimscrollleft" id="sidebar-main">
	<div id="sidebar-menu">
		<ul>
			<li class="menu-title">Overview</li>
			<?php if($this->session->userdata('user_logged_id')){ ?>
			<li>
				<a href="javascript:void(0)" class="waves-effect waves-light" onclick="primaryDashboard()"><i class="fa fa fa-tag"></i><span> Home  </span></a>
			</li>
			<?php } ?>
			<li>
				<a href="<?php echo base_url()."dashboard/".$dashboard_url; ?>" class="waves-effect waves-light"><i class="fa fa fa-tag"></i><span> My Data  </span></a>
			</li>
			<li>
				<a href="<?php echo base_url()."dashboard/mychart/".$dashboard_url; ?>" class="waves-effect waves-light"><i class="fa fa fa-tag"></i><span> Analytics Dashboard </span></a>
			</li>
			<!--<li class="has_sub">
				<a href="javascript:void(0);" class="waves-effect waves-light"><i class="fa fa fa-tag"></i><span> Analytics </span><span class="float-right"><i class="fa fa-chevron-right"></i></span></a>
				<ul class="list-unstyled" style="display: none;">
					<li>
						<a href="<?php echo base_url()."dashboard/mytable/".$dashboard_url; ?>">My Tables</a>
					</li>
					<li>
						<a href="<?php echo base_url()."dashboard/mychart/".$dashboard_url; ?>">My Charts</a>
					</li>
				</ul>
			</li>-->
			<li>
				<a href="<?php echo base_url()."dashboard/records/".$dashboard_url; ?>" class="waves-effect waves-light"><i class="fa fa fa-tag"></i><span> Track Dashboard </span></a>
			</li>			
			<!--<li class="has_sub">
					<a href="javascript:void(0);" class="waves-effect waves-light"><i class="fa fa fa-tag"></i><span> Track </span><span class="float-right"><i class="fa fa-chevron-right"></i></span></a>
					<ul class="list-unstyled" style="display: none;">
						<li>
							<a href="<?php echo base_url()."dashboard/records/".$dashboard_url; ?>">Records</a>
						</li>
						<li>
							<a href="<?php echo base_url()."dashboard/mytable/".$dashboard_url; ?>">My Tables</a>
						</li>
						<li>
							<a href="<?php echo base_url()."dashboard/mychart/".$dashboard_url; ?>">My Charts</a>
						</li>
					</ul>
					</li>-->

			<?php if($this->session->userdata('user_logged_id')){ ?>
			<li>
				<a href="<?php echo base_url()."dashboard/sharedashboard/".$dashboard_url; ?>" class="waves-effect waves-light"><i class="fa fa fa-tag"></i><span> Share Dashboard </span></a>
			</li>
			<!--<li>
				<a href="<?php echo base_url()."dashboard/sharesurvey/".$dashboard_url; ?>" class="waves-effect waves-light"><i class="fa fa fa-tag"></i><span> Share Survey </span></a>
			</li>-->
			<?php } ?>
		</ul>
	</div>
	<div class="clearfix"></div>
</div> <!-- end sidebarinner -->
<script>
$(document).ready(function () {
	var a=$(".survey-selector .dropdown-menu a.active");
	var a_text=a.text();
	var b=a.closest('.survey-selector').find('a.btn');
	var b_text=b.text();
	b.text(a.text());
});
/*$(".survey-selector .dropdown-menu a ").click(function(){
	$(this).parents(".input-group-btn").find('.btn').text($(this).text());
});*/
</script>