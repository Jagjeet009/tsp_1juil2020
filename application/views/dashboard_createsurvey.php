<?php //print_r(SECTOR);
$countryArr=unserialize(COUNTRY);
$sectorArr=unserialize(SECTOR);
?>
<div class="col-lg-12">
	<div class="card m-b-30">
		<h4 class="card-header mt-0">Create Survey</h4>
		<div class="card-body">
			<form method="post" action="<?php echo base_url();?>survey/save" onSubmit="alert('Survey Created Successfully');return true;">
				<div class="row">
					<div class="col-lg-6">
						<label>Name Your Survey</label>
						<input name="title" type="text" required>
						<label>Sample</label>
						<input name="survey_sample" type="text">
						<label>Sector</label>
						<select name="sector" required>
							<option value="">Select</option>
							<?php foreach($sectorArr as $s_k=>$s_v){ ?>
							<option value="<?php echo $s_k; ?>"><?php echo $s_v; ?></option>
							<?php } ?>							
						</select>
						<label>Country</label>
						<select name="country" required>
							<option value="">Select</option>
							<?php foreach($countryArr as $c_k=>$c_v){ ?>
							<option value="<?php echo $c_k; ?>"><?php echo $c_v; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-lg-6">
						<label>Start Date</label>
						<input class="datepicker" name="start_date" type="text" required>
						<label>End Date</label>
						<input class="datepicker" name="end_date" type="text">
						<label>Access</label>
						<input type="radio" name="access" value="0" checked=""> Private
						<input type="radio" name="access" value="1"> Public						
					</div>
				</div>
				<input value="Create" tabindex="30" type="submit" class="btn btn-primary submit-btn">
			</form>
		</div>
	</div>
</div>
<div class="col-lg-6">
	<div class="card m-b-30">
		<h4 class="card-header mt-0">Question Bank</h4>
		<div class="card-body">
			<!--<h4 class="card-title font-20 mt-0">Go for the Survey Point Question Bank Help.</h4>-->
			<a href="<?php echo base_url()."survey/questionbank"; ?>" class="btn btn-primary">Go</a>
		</div>
	</div>
</div>
<div class="col-lg-6">
	<div class="card m-b-30">
		<h4 class="card-header mt-0">Templates</h4>
		<div class="card-body">
			<!--<h4 class="card-title font-20 mt-0">Templates link</h4>-->
			<a href="<?php echo base_url()."template"; ?>" class="btn btn-primary">Go</a>
		</div>
	</div>
</div>
