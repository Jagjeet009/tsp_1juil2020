<style type="text/css">
.addrem{font-size:20px;margin:5px 0 0 5px;}
.make-users tfoot{display:none;}
.username.success{background-color:#7af57c;font-weight:bold;}
.username.danger{background-color:#f77471;font-weight:bold;}
</style>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php print_r($heading);?> </h1>
		</div>
		<!-- /.row -->
		<div class="row">
			<div class="col-lg-12">
				<div class="panel-body">
					<form role="form" action="<?php echo base_url().'admin/users/save';?>" method="post" enctype="multipart/form-data" onsubmit="return checkForm(this)">
						<div class="row">
							<table class="make-users" width="100%" border="0" cellspacing="0" cellpadding="10">
							  <tbody>
								<tr>
								  <td>
										<div class="form-group">
											<label>Name</label>
											<input type="text" name="name[]" class="form-control">
										</div>
									</td>
								  <td>
										<div class="form-group">
											<label>Email</label>
											<input type="text" name="email[]" class="form-control">
										</div>

								  </td>
								  <td>
										<div class="form-group">
											<label>Username</label>
											<input type="text" name="username[]" class="form-control username">
										</div>
									</td>
								  <td>
										<div class="form-group">
											<label>Password</label>
											<input type="text" name="password[]" class="form-control" />
										</div>
									</td>
								  <td>
										<div class="form-group">
											<label>Contact</label>
											<input type="text" name="contact[]" class="form-control" />
										</div>
									</td>
								  <td>
								  	<!--<a href="javascript:void(0)" onclick="addRow(this)"><i class="addrem fa fa-plus text-success"></i></a>
								  	<a href="javascript:void(0)" onclick="remRow(this)"><i class="addrem fa fa-minus text-danger"></i></a>-->
								  </td>
								</tr>
								<tr>
								  <td>
										<div class="form-group">
											<input type="text" name="name[]" class="form-control">
										</div>
									</td>
								  <td>
										<div class="form-group">
											<input type="text" name="email[]" class="form-control">
										</div>

								  </td>
								  <td>
										<div class="form-group">
											<input type="text" name="username[]" class="form-control username">
										</div>
									</td>
								  <td>
										<div class="form-group">
											<input type="text" name="password[]" class="form-control" />
										</div>
									</td>
								  <td>
										<div class="form-group">
											<input type="text" name="contact[]" class="form-control" />
										</div>
									</td>
								  <td>
								  	<a href="javascript:void(0)" onclick="addRow(this)"><i class="addrem fa fa-plus text-success"></i></a>
								  	<a href="javascript:void(0)" onclick="remRow(this)"><i class="addrem fa fa-minus text-danger"></i></a>
								  </td>
								</tr>
							  </tbody>
							  <tfoot>
								<tr>
								  <td>
										<div class="form-group">
											<input type="text" name="name[]" class="form-control">
										</div>
									</td>
								  <td>
										<div class="form-group">
											<input type="text" name="email[]" class="form-control">
										</div>

								  </td>
								  <td>
										<div class="form-group">
											<input type="text" name="username[]" class="form-control username">
										</div>
									</td>
								  <td>
										<div class="form-group">
											<input type="text" name="password[]" class="form-control" />
										</div>
									</td>
								  <td>
										<div class="form-group">
											<input type="text" name="contact[]" class="form-control" />
										</div>
									</td>
								  <td>
								  	<a href="javascript:void(0)" onclick="addRow(this)"><i class="addrem fa fa-plus text-success"></i></a>
								  	<a href="javascript:void(0)" onclick="remRow(this)"><i class="addrem fa fa-minus text-danger"></i></a>
								  </td>
								</tr>
							  </tfoot>							  
							</table>
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
<script type="text/javascript">
function addRow(anchor){
	var newRow=$(anchor).closest('table').find('tfoot>tr').clone();
	$(anchor).closest('table>tbody').append(newRow);
}	
function remRow(anchor){
	var l=$(anchor).closest('table>tbody').find('tr').length;
	console.log(l);
	if(l>2){
		$(anchor).closest('tr').remove();
	}else{
		alert("Can't Remove More..");
	}
}	
function checkForm(form){
	var $return=true;
	$(form).find('table>tbody').find('.username').each(function(){
		if(!$(this).hasClass('success') || $(this).val()==""){
			$return=false;
		}
	});
	console.log($return);
	return $return;
}	
$(document).ready(function() {				//for user exist checking
    $('.username').on('blur', function() { 
        var $this = $(this), value = $this.val(); 
		$.ajax({
			url: '<?php echo base_url()."admin/users/checkuser/";?>'+value, // url where to submit the request
			type : "GET", // type of action POST || GET
			success : function(result) {
				//console.log(result);
					$this.removeClass('success');
					$this.removeClass('danger');
				if(result=='1'){
					$this.addClass('success');
				}else{
					$this.addClass('danger');
				}
			},error: function(xhr, resp, text) {log2(xhr, resp, text);}
		});		
    });
});	
</script>