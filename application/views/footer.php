<?php
$constants=get_defined_constants();
$codeArrAvailable=unserialize($constants['codeArrAvailable']);
$codeArr=unserialize($constants['codeArr']);
?>
<!--<input type="text" class="jscolor"  value="#4fc8db" />-->
		
    </section>
  </div>
</div>
<div class="dashor-footer">
	<div class="icons">
							<a href="https://www.facebook.com/thesurveypoint" target="_blank"><i class="fa fa-facebook"></i></a>
							<a href="https://twitter.com/sambodhi" target="_blank"><i class="fa fa-twitter"></i></a> 
							<a href="https://www.linkedin.com/in/thesurveypoint/" target="_blank"><i class="fa fa-linkedin"></i></a> 
							<a href="https://www.instagram.com/thesurveypoint/" target="_blank"><i class="fa fa-instagram"></i></a> 
							<a href="https://plus.google.com/u/0/115478327721066879463" target="_blank"><i class="fa fa-google-plus"></i></a> 
	</div>
	<p>COPYRIGHT © 2018 <a href="http:www.sambodhi.co.in">Sambodhi Research &amp; Communications Pvt Ltd</a></p>
</div>

<iframe id="survey_copy" src="javascript:void(0)"></iframe>
<modals>
<div id="codeWizardModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:98%;">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title"><strong>Code Wizard</strong></h4>
	  </div>
	  <div class="modal-body">
		  <form class="codeWizardForm" name="codeWizardForm" data-survey-id="<?php echo $_COOKIE['design_survey']; ?>">
		  <?php $this->load->view('code_wizard'); ?>
		  </form>
		  <?php $this->load->view('code_wizard_helper'); ?>		  
		  <span class="codeWizardDisplayForm">
		  </span>
	  </div>
	</div>
  </div>
</div>	
<div id="computeRecodeModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:800px">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Compute and Recode Variables</h4>
	  </div>
	  <div class="modal-body">
			<form name="compute-form" id="compute-form" method="post" action="">
				<input type="hidden" name="survey_title_url" value="" />
				<input type="hidden" name="variable_property" value="none" />
				<div class="row">
					<div class="col-6">
						<label>Target Variable</label>
						<input name="target_variable" type="text" value="">
						<label>Label</label>
						<input name="target_label" type="text" value="">
						<!--<label>Variable Property</label>
						<input name="variable_property" type="radio" value="same" /> Same Variable
						<input name="variable_property" type="radio" value="new" checked /> Different Variable-->
						<label>All Variables</label>
						<select name="all_variable" size="9">
							<option onDblClick="insertAtCursor($('#numerical_expression'),'ID01')" value="ID01">ID01 - Text</option>
							<option onDblClick="insertAtCursor($('#numerical_expression'),'ID02')" value="ID02">ID02 - Text</option>
							<option onDblClick="insertAtCursor($('#numerical_expression'),'ID03')" value="ID03">ID03 - Text</option>
							<option onDblClick="insertAtCursor($('#numerical_expression'),'ID04')" value="ID04">ID04 - Text</option>
							<option onDblClick="insertAtCursor($('#numerical_expression'),'ID05')" value="ID05">ID05 - Text</option>
							<option onDblClick="insertAtCursor($('#numerical_expression'),'ID06')" value="ID06">ID06 - Text</option>
							<option onDblClick="insertAtCursor($('#numerical_expression'),'ID07')" value="ID07">ID07 - Text</option>
							<option onDblClick="insertAtCursor($('#numerical_expression'),'ID08')" value="ID08">ID08 - Text</option>
							<option onDblClick="insertAtCursor($('#numerical_expression'),'ID09')" value="ID09">ID09 - Text</option>
						</select>
						<input value="Save" type="button" onClick="saveComputeRecode(this)">
					</div>
				  <div class="col-6">
						<label>Numerical Expression</label>
					<textarea id="numerical_expression" name="numerical_expression"></textarea>
					<label>Operator Panel</label>
						<table class="operator-panel" border="0" cellspacing="0" cellpadding="0">
							<tbody>
								<tr>
								  <td align="left"><input class="operator-buttons" type="button" value="+" onClick="insertAtCursor($('#numerical_expression'),'+')" /></td>
								  <td align="center"><input class="operator-buttons" type="button" value="<" onClick="insertAtCursor($('#numerical_expression'),'<')" /></td>
								  <td align="right"><input class="operator-buttons" type="button" value=">" onClick="insertAtCursor($('#numerical_expression'),'>')" /></td>
								  <td>&nbsp;</td>
								  <td><input class="operator-buttons" type="button" value="7" onClick="insertAtCursor($('#numerical_expression'),'7')" /></td>
								  <td><input class="operator-buttons" type="button" value="8" onClick="insertAtCursor($('#numerical_expression'),'8')" /></td>
								  <td><input class="operator-buttons" type="button" value="9" onClick="insertAtCursor($('#numerical_expression'),'9')" /></td>
								</tr>
								<tr>
								  <td align="left"><input class="operator-buttons" type="button" value="-" onClick="insertAtCursor($('#numerical_expression'),'-')" /></td>
								  <td align="center"><input class="operator-buttons" type="button" value="<=" onClick="insertAtCursor($('#numerical_expression'),'<=')" /></td>
								  <td align="right"><input class="operator-buttons" type="button" value=">=" onClick="insertAtCursor($('#numerical_expression'),'>=')" /></td>
								  <td>&nbsp;</td>
								  <td><input class="operator-buttons" type="button" value="4" onClick="insertAtCursor($('#numerical_expression'),'4')" /></td>
								  <td><input class="operator-buttons" type="button" value="5" onClick="insertAtCursor($('#numerical_expression'),'5')" /></td>
								  <td><input class="operator-buttons" type="button" value="6" onClick="insertAtCursor($('#numerical_expression'),'6')" /></td>
								</tr>
								<tr>
								  <td align="left"><input class="operator-buttons" type="button" value="*" onClick="insertAtCursor($('#numerical_expression'),'*')" /></td>
								  <td align="center"><input class="operator-buttons" type="button" value="==" onClick="insertAtCursor($('#numerical_expression'),'==')" /></td>
								  <td align="right"><input class="operator-buttons" type="button" value="!=" onClick="insertAtCursor($('#numerical_expression'),'!=')" /></td>
								  <td>&nbsp;</td>
								  <td><input class="operator-buttons" type="button" value="1" onClick="insertAtCursor($('#numerical_expression'),'1')" /></td>
								  <td><input class="operator-buttons" type="button" value="2" onClick="insertAtCursor($('#numerical_expression'),'2')" /></td>
								  <td><input class="operator-buttons" type="button" value="3" onClick="insertAtCursor($('#numerical_expression'),'3')" /></td>
								</tr>
								<tr>
								  <td align="left"><input class="operator-buttons" type="button" value="/" onClick="insertAtCursor($('#numerical_expression'),'/')" /></td>
								  <td align="center"><input class="operator-buttons" type="button" value="&&" onClick="insertAtCursor($('#numerical_expression'),'&&')" /></td>
								  <td align="right"><input class="operator-buttons" type="button" value="||" onClick="insertAtCursor($('#numerical_expression'),'||')" /></td>
								  <td>&nbsp;</td>
								  <td><input class="operator-buttons" type="button" value="0" onClick="insertAtCursor($('#numerical_expression'),'0')" /></td>
								  <td align="right"><input class="operator-buttons" type="button" value="." onClick="insertAtCursor($('#numerical_expression'),'.')" /></td>
								  <td><!--<input class="operator-buttons" type="button" value="Del" />--></td>
								</tr>
								<tr>
								  <td align="left">&nbsp;</td>
								  <td align="center"><input class="operator-buttons" type="button" value="!" onClick="insertAtCursor($('#numerical_expression'),'!')" /></td>
								  <td align="right"><input class="operator-buttons" type="button" value="()" onClick="insertAtCursor($('#numerical_expression'),'()')" /></td>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
								  <td align="right">&nbsp;</td>
								  <td>&nbsp;</td>
							  </tr>									
							  </tbody>
						</table>
					</div>
				</div>
			</form>              
	  </div>
	</div>
  </div>
</div>	
<div id="LoaderModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:120px;">
    <div class="modal-content">
     <!-- <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4 class="modal-title">Please Wait!!!</h4>
      </div> -->
      <div class="modal-body">
      <img src="<?php echo base_url()."theme/images/syncloader.gif"; ?>" />
      <div id="syncprogress">0%</div>
      <div id="syncstatus">&nbsp;</div>
      </div>
    </div>
  </div>
</div>	
</modals>
<?php 
if($this->session->has_userdata('user_logged_id')){
	$user_data=$this->User_model->get_user_by_id($this->session->userdata('user_logged_id'));
	//print_r($user_data);
?>
<modals>
<div id="TrialModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
     <div class="modal-header">
       <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
       <h4 class="modal-title">Trial Expired!!!</h4>
      </div>
      <div class="modal-body">
			<form name="license-form" id="license-form" method="post" action="<?php echo base_url();?>login/profile/save/">
			<label>Please Enter Your License Key</label>
			<input name="license_key" required type="text" pattern="[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}" placeholder="AB12-EF34-IJ56-MN78">
			<input name="username" type="hidden" required value="<?php echo $user_data[0]['username'] ?>" />
			<input value="Save" type="button" onClick="license_check()">
			</form>              
      </div>
    </div>
  </div>
</div>	
<div id="themeModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:700px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Change Your Theme</h4>
      </div>
      <div class="modal-body">
			<form name="theme-form" id="theme-form" method="post" action="<?php echo base_url();?>login/theme/save">
				<input name="username" required type="hidden" value="<?php echo $user_data[0]['username'];?>">
				<div class="row theme-box-big">
						<label class="theme-box-cover">
							<div class="theme-box-small">
								<div class="theme-box-small-inner">
									<img src="<?php echo base_url()."userthemes/no-image.png"; ?>" alt="No Theme" />
									<input <?php if($user_data[0]['theme']==""){echo "checked";}?> type="radio" name="theme" value="" /> Default
								</div>
							</div>
						</label>				
						<label class="theme-box-cover">
							<div class="theme-box-small">
								<div class="theme-box-small-inner">
									<img src="<?php echo base_url()."userthemes/ocean.jpg"; ?>" />
									<input <?php if($user_data[0]['theme']=="ocean"){echo "checked";}?> type="radio" name="theme" value="ocean" /> Ocean
								</div>
							</div>
						</label>
						<label class="theme-box-cover">
							<div class="theme-box-small">
								<div class="theme-box-small-inner">
									<img src="<?php echo base_url()."userthemes/nature.jpg"; ?>" />
									<input <?php if($user_data[0]['theme']=="nature"){echo "checked";}?> type="radio" name="theme" value="nature" /> Nature
								</div>
							</div>
						</label>						
				</div>
				<input value="Save" type="submit">
			</form>               
      </div>
    </div>
  </div>
</div>
<div id="profileModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Your Profile</h4>
      </div>
      <div class="modal-body">
			<form name="profile-form" id="profile-form" method="post" action="<?php echo base_url();?>login/profile/save/<?php echo $user_data[0]['username'];?>">
			<label>Username</label>
			<input name="username" required type="text" disabled value="<?php echo $user_data[0]['username'];?>">
			<label>Email</label>
			<input name="email" required type="email" value="<?php echo $user_data[0]['email'];?>" autocomplete="email">
			<label>Password</label>
			<input name="password" required type="text" value="<?php echo $user_data[0]['password'];?>">
			<label>Name</label>
			<input name="name" required type="text" value="<?php echo $user_data[0]['name'];?>" autocomplete="name">
			<label>Contact</label>
			<input name="contact" required type="text" value="<?php echo $user_data[0]['contact'];?>">
			<input value="Save" type="submit">
			</form>              
      </div>
    </div>
  </div>
</div>
<div id="permissionModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:400px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Give Survey Permissions</h4>
      </div>
      <div class="modal-body">
			<form name="permission-form" id="permission-form" method="post" action="">
			<label>Username</label>
			<input name="username" class="permission_check typeahead2" required type="text" value="" autocomplete="off">
			<label>Survey</label>
			<input name="survey" class="permission_check typeahead3" required type="text" value="" autocomplete="off">
			<input name="survey_id" required type="hidden" value="" />
			<label>Design Permission <input name="design_permission" type="checkbox" value="1" /></label>
			<label>Fill Permission <input name="fill_permission" type="checkbox" value="1" /></label>
			<label>Analytics Permission <input name="analytics_permission" type="checkbox" value="1" /></label>
			<input value="Save" type="button" onClick="savePermission(this)">
			<input value="Edit Permissions" type="button" onClick="editPermissions()">
			</form>              
      </div>
    </div>
  </div>
</div>
<div id="permissionsModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:400px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Survey Permissions</h4>
      </div>
      <div class="modal-body">
        <?php //print_r($surveys_list);?>
        <table border="1" width="100%">
			<?php 
			foreach($surveys_list as $sl){
				if($sl['permission_design']!='' or $sl['permission_fill']!='' or sizeof(json_decode($sl['permission_design']))>0 or sizeof(json_decode($sl['permission_fill']))>0	){
			?>
					<tr>
						<td align="center" colspan="4"><strong><?php echo $sl['title']; ?></strong></td>
					</tr>
					<tr>
						<th><strong>Username</strong></th>
						<th><strong>Design</strong></th>
						<th><strong>Fill</strong></th>
						<th><strong>Analytics</strong></th>
					</tr>
					<?php 
					$dfa=array();
					$pd=(array) json_decode($sl['permission_design']);
					$pf=(array) json_decode($sl['permission_fill']);
					$pa=(array) json_decode($sl['permission_analytics']);
					
					$dfa=array_merge($dfa,$pd,$pf,$pa);
					$dfa=array_unique($dfa);
					//print_r($dfa);
					if(sizeof($dfa)>0){
						foreach($dfa as $pdfa){
					?>
						<tr>
							<td><?php echo $pdfa;?></td>
							<td><?php if(in_array($pdfa,$pd)){?><i class="fa fa-check" aria-hidden="true"></i> <a onClick="removePermission(this,'<?php echo $sl['title_url']; ?>','permission_design','<?php echo $pdfa;?>')" href="javascript:void(0)">Remove</a><?php } ?></td>
							<td><?php if(in_array($pdfa,$pf)){?><i class="fa fa-check" aria-hidden="true"></i> <a onClick="removePermission(this,'<?php echo $sl['title_url']; ?>','permission_fill','<?php echo $pdfa;?>')" href="javascript:void(0)">Remove</a><?php } ?></td>
							<td><?php if(in_array($pdfa,$pa)){?><i class="fa fa-check" aria-hidden="true"></i> <a onClick="removePermission(this,'<?php echo $sl['title_url']; ?>','permission_analytics','<?php echo $pdfa;?>')" href="javascript:void(0)">Remove</a><?php } ?></td>
						</tr>
			<?php }}}} ?>
		</table>
			<input value="Save" type="button" onClick="closePermission()">
<!--			<form name="permission-form" id="permission-form" method="post" action="">
			<label>Username</label>
			<input name="username" class="typeahead2" required type="text" value="" autocomplete="off">
			<label>Survey</label>
			<input name="survey" class="typeahead3" required type="text" value="" autocomplete="off">
			<input name="survey_id" required type="hidden" value="" />
			<label>Design Permission <input name="design_permission" type="checkbox" value="1" /></label>
			<label>Fill Permission <input name="fill_permission" type="checkbox" value="1" /></label>
			<input value="Save" type="button" onClick="savePermission(this)">
			<input value="Edit Permissions" type="button">
			</form>              
-->      </div>
    </div>
  </div>
</div>
<div id="createOrExistSurveyModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Choose</h4>
      </div>
      <div class="modal-body">
      	<input type="button" value="Create New" onClick="javascript:createSurvey()" />
      	<input type="button" value="Select Existing" onClick="javascript:selectSurvey()" />
      </div>
    </div>
  </div>
</div>
<div id="createSurveyModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Create Survey</h4>
      </div>
      <div class="modal-body">
		<form method="post" action="<?php echo base_url();?>survey/save">
			<label>Name Your Survey</label>
			<input name="title" type="text">
			<input value="Create" type="submit">
		</form>       
      </div>
    </div>
  </div>
</div>
<div id="duplicateSurveyModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Create Survey</h4>
      </div>
      <div class="modal-body">
		<form method="post" action="<?php echo base_url();?>survey/duplicate">
			<label>Name Your Survey</label>
			<input name="title" type="text">
			<input name="id" type="hidden" value="" />
			<input value="Create" type="submit">
		</form>       
      </div>
    </div>
  </div>
</div>	
<div id="editSurveyModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong>Your Survey</strong></h4>
      </div>
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>
<div id="styleSurveyModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:1000px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong>Your Survey Style</strong></h4>
      </div>
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>
<div id="compileModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:1000px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong>Compile Report</strong></h4>
      </div>
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>
<div id="createSectionModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title">Your Section</h4>
      </div>
      <div class="modal-body">
		<form method="post" action="<?php echo base_url();?>survey/section/save/<?php echo $survey[0]['title_url'];?>">
			<label>Name Your Section</label>
			<input name="title" type="text">
			<input value="Create" type="submit">
		</form>       
      </div>
    </div>
  </div>
</div>
<div id="editSectionModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong>Your Section</strong></h4>
      </div>
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>
<div id="styleSectionModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:1000px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong>Your Section Style</strong></h4>
      </div>
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>
<div id="chooseQuestionFromModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:250px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title">Choose</h4>
		  <input type="hidden" name="section_name" />
      </div>
      <div class="modal-body">
      	<input type="button" value="New" onClick="javascript:chooseQuestion()" />
      	<input type="button" value="Existing" onClick="javascript:chooseQuestionExisting()" />
      </div>
    </div>
  </div>
</div>
<div id="chooseQuestionExistingModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:700px;min-height:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title">Enter Question Text to Search...</h4>
      </div>
      <div class="modal-body" style="overflow-y:visible">
      	<form method="post" action="">
			<input type="hidden" name="section_id" />
			<input type="hidden" value="" name="question_id" />
			<input type="text" class="typeahead" id="question_text_search" name="question_text_search" value="" placeholder="Type..." />
			<input type="button" name="question_search" value="Insert" onClick="createQuestionFromExisting(this)" />
      	</form>
      </div>
    </div>
  </div>
</div>
<div id="chooseQuestionModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:350px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title">Choose Your Question Type</h4>
		  <input type="hidden" name="section_name" />
      </div>
      <div class="modal-body">
		<a href="javascript:void(0)" onclick="createQuestion('MC')">
			<img src="<?php echo base_url(); ?>theme/images/mc.jpg">
			<strong>Multiple Choice</strong> 
		</a>				
		<a href="javascript:void(0)" onclick="createQuestion('DD')">
			<img src="<?php echo base_url(); ?>theme/images/dd.jpg">
			<strong>Dropdown</strong> 
		</a>				
		<a href="javascript:void(0)" onclick="createQuestion('DM')">
			<img src="<?php echo base_url(); ?>theme/images/dm.jpg">
			<strong>Dropdown Matrix</strong> 
		</a>				
		<a href="javascript:void(0)" onclick="createQuestion('FU')">
			<img src="<?php echo base_url(); ?>theme/images/fu.jpg">
			<strong>File Upload</strong> 
		</a>				
		<a href="javascript:void(0)" onclick="createQuestion('RK')">
			<img src="<?php echo base_url(); ?>theme/images/rk.jpg">
			<strong>Ranking</strong> 
		</a>				
		<a href="javascript:void(0)" onclick="createQuestion('TB')">
			<img src="<?php echo base_url(); ?>theme/images/tb.jpg">
			<strong>Textbox</strong> 
		</a>				
		<a href="javascript:void(0)" onclick="createQuestion('MT')">
			<img src="<?php echo base_url(); ?>theme/images/mt.jpg">
			<strong>Multiple Textbox</strong> 
		</a>				
		<a href="javascript:void(0)" onclick="createQuestion('TM')">
			<img src="<?php echo base_url(); ?>theme/images/tm.jpg">
			<strong>Textbox Matrix</strong> 
		</a>				
		<a href="javascript:void(0)" onclick="createQuestion('DT')">
			<img src="<?php echo base_url(); ?>theme/images/dt.jpg">
			<strong>Date/Time</strong> 
		</a>				
		<a href="javascript:void(0)" onclick="createQuestion('TA')">
			<img src="<?php echo base_url(); ?>theme/images/ta.jpg">
			<strong>Textarea</strong> 
		</a>				
		<a href="javascript:void(0)" onclick="createQuestion('SI')">
			<img src="<?php echo base_url(); ?>theme/images/si.jpg">
			<strong>Static Image</strong> 
		</a>				      
      </div>
    </div>
  </div>
</div>
<div id="createQuestionModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:600px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title"><strong>Your Question</strong>  <a class="highlight-text-button" href="javascript:void(0)" onClick="doHighlight();">HIGHLIGHT TEXT</a> <a class="highlight-text-button" href="javascript:void(0)" onClick="doTextBreak();">Text Break</a></h4>
      </div>
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>
<div id="editQuestionModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title"><strong>Your Question</strong> <a class="highlight-text-button" href="javascript:void(0)" onClick="doHighlight();">HIGHLIGHT TEXT</a> <a class="highlight-text-button" href="javascript:void(0)" onClick="doTextBreak();">Text Break</a></h4>
      </div>
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>
<div id="styleQuestionModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:1000px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong>Your Question Style</strong></h4>
      </div>
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>
<div id="collectCodeQuestionModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong>Select Functions</strong></h4>
      </div>
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>
<div id="collectCodeNameModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:900px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong>Give Custom Names</strong></h4>
      </div>
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>
<div id="collectLengthModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:900px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong>Format & Lengths for SPSS</strong></h4>
      </div>
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>
<div id="collectLengthsModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:900px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong>Format & Lengths for SPSS for All</strong></h4>
      </div>
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>
<div id="generateCodeQuestionModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">
        <strong>Your Code</strong>
			<select name="functionSelect" class="close" onChange="printFunction(this)" title="select function to insert code">
				<?php foreach($codeArr as $ca_key=>$ca_value){ ?>					
				<option value="<?php echo $ca_value;?>"><?php echo $ca_key;?></option>
				<?php } ?>
			</select>
			<input name="default_question_no" type="hidden" value="" />
			<input type="checkbox" checked id="saveBeforeClose" name="saveBeforeClose" value="1" />
       <button id="format_coding">Format</button>
        </h4>
      </div>
      <div class="modal-body">
      </div>
    </div>
    <!--<span id="autoSaveDisplay" class="autosaved">Saved</span>-->
  </div>
</div>
<div id="selectSurveyModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:700px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong>Select Survey To Design</strong></h4>
      </div>
      <div class="modal-body">
		<?php foreach($surveys_design_list as $sl){?>
        <a href="javascript:chooseSurvey('<?php echo $sl['title_url']; ?>')"><?php echo $sl['title']; ?></a>
        <?php }?>
      </div>
    </div>
  </div>
</div>
<div id="fillSurveyModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:700px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong>Select Survey To Fill</strong></h4>
      </div>
      <div class="modal-body">
		<?php foreach($surveys_fill_list as $sl){?>
        <a href="javascript:chooseSurveyAndFill('<?php echo $sl['title_url']; ?>')"><?php echo $sl['title']; ?></a>
        <?php }?>
      </div>
    </div>
  </div>
</div>
<div id="analyticsSurveyModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong>Select Survey To Analyse</strong></h4>
      </div>
      <div class="modal-body">
		<?php foreach($surveys_analytics_list as $sl){?>
        	<a href="javascript:chooseSurveyAndAnalytics('<?php echo $sl['title_url']; ?>')"><?php echo $sl['title']; ?></a>
        <?php }?>
      </div>
    </div>
  </div>
</div>
<div id="prepareAnalyticsSurveyModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:600px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong>Set Indicators - <span class="title"></span></strong></h4>
      </div>
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>
<div id="analyticsMoreIndicatorsSurveyModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong>Select Indicator</strong></h4>
      </div>
      <div class="modal-body" style="max-height: 520px;overflow-y: auto;">
      </div>
    </div>
  </div>
</div>
<div id="selectSurveyCaseToCompleteModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong>Select Survey Case To Complete</strong></h4>
      </div>
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>
<div id="BoxModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>	
<div id="controlModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong>Survey Control</strong></h4>
      </div>
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>
<div id="analyticsDashboardInfoModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:400px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong>Save Data In Your Dashboard</strong></h4>
      </div>
      <div class="modal-body">
      	<h5><a href="javascript:void(0);" onClick="afterSaveAnalyticsGraph('0')">Analytics Dashboard</a></h5>
      	<h5><a href="javascript:void(0);" onClick="afterSaveAnalyticsGraph('1')">Track Dashboard</a></h5>
      </div>
    </div>
  </div>
</div>	
<div id="analyticsExcelUploadModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:600px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload Your Excel</h4>
      </div>
      <div class="modal-body">
			<form name="upload-form" id="upload-form" method="post" action="<?php echo base_url();?>survey/excel/upload" enctype="multipart/form-data">
			<input name="survey_id" required type="hidden" value="">
			<label>select your file</label>
			<input type="file" name="excel_file" />
			<input value="Save" type="submit">
			</form>              
      </div>
    </div>
  </div>
</div>	
<div id="attachSurveyModal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Attach Survey</h4>
      </div>
      <div class="modal-body">
      	<ul>
      		<?php 
				if(isset($analytics_list) && $analytics_list!='' && sizeof($analytics_list)>0){
					foreach($analytics_list as $al){
						if($al!=$survey[0]['title_url']){
							$q=$this->db->query("select title from survey where title_url='".$al."' ");
							if($q->num_rows()>0){
								$q=$q->result_array();
								$q=$q[0];
								
								$table_query=$this->db->query("SELECT count(*) as table_count FROM information_schema.TABLES WHERE (TABLE_SCHEMA = '".$this->db->database."') AND (TABLE_NAME = 'analytics_".$al."')");
								//echo $this->db->last_query();
								if($table_query->num_rows()>0){
									$table_query=$table_query->result_array();
									$table_count=$table_query[0]['table_count'];
									//print_r($table_count);
									if($table_count>0){
						?>
							<li>
								<a onclick="attachSurveyGet('<?php echo $survey[0]['title_url']; ?>','<?php echo $al; ?>')" href="javascript:void(0);"><?php echo $q['title']; ?></a>
							</li>
      		<?php }}}}}} ?>
      	</ul>
      </div>
    </div>
  </div>
</div>	
</modals>
<?php } ?>
<!--loader on process-->
<div id="procesing-loader">
	<div class="loader-container">
		<img src="<?php echo base_url();?>theme/images/busyload.gif" />
		<div class="process-text">
			<p>this is a simple text.</p>
			<p>this is a simple text.</p>
			<p>this is a simple text.</p>
			<p>this is a simple text.</p>
			<p>this is a simple text.</p>
			
		</div>
	</div>
</div>

<?php if($this->session->has_userdata('user_logged_id') && (!get_cookie('fill_survey')!="")){ ?>
<script src="<?php echo base_url();?>assets/js/waves.js"></script>
<script src="<?php echo base_url();?>theme/js/jquery.minicolors.js"></script>
<script src="<?php echo base_url();?>theme/js/skel.min.js"></script> 
<script src="<?php echo base_url();?>theme/js/util.js"></script> 
<script src="<?php echo base_url();?>theme/js/main.js"></script>
<?php } ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/js-beautify/1.10.0/beautify.js"></script>
<script type="text/javascript">
function calculateRowColumnPercent(row_percent,col_percent){
	//console.log("called calculateRowColumnPercent");
	var row_percent=row_percent;
	$('.row-percent').each(function(){
		var row_percent_td=$(this);
		var v1=row_percent_td.prev('td').text();
		var v2=row_percent_td.closest('tr').find('.row-total').text();
		var v3=((parseInt(v1)/parseInt(v2))*100).toFixed(2);
		//var v3=((parseInt(v1)/parseInt(v2))*100);
		if(v3=="NaN"){v3='0';}
		row_percent_td.html(v3);
	});
	$('.col-percent').each(function(){
		var col_percent_td=$(this);
		//console.log("row_percent: "+row_percent);
		if(row_percent=="1"){
			var v1=col_percent_td.prev('td').prev('td').text();
			var cellindex=col_percent_td.prev('td').prev('td').index();
		}else{
			var v1=col_percent_td.prev('td').text();
			var cellindex=col_percent_td.prev('td').index();
		}
		var v2=col_percent_td.closest('table').find('tr:last>td:eq('+cellindex+')').text();
		//console.log(v1+" "+v2);
		var v3=((parseInt(v1)/parseInt(v2))*100).toFixed(2);
		//var v3=((parseInt(v1)/parseInt(v2))*100);
		if(v3=="NaN"){v3='0';}
		col_percent_td.html(v3);
	});
}
function calculateWidthsHeights(tablekey){
	//console.log("called calculateWidthsHeights");

	//setting first same column widths to all tables
	var tr_second_td_first_width=0;
	$('#'+tablekey).find('table.inner').each(function(){
		var ti=$(this);
		var tr_second_td_first=ti.find('tr:eq(1)>td:first-child');
		if(tr_second_td_first_width<=tr_second_td_first.innerWidth()){
			tr_second_td_first_width=tr_second_td_first.innerWidth();

		}
	});	
	$('#'+tablekey).find('table.inner').each(function(){
		ti=$(this);
		var tr_second_td_first=ti.find('tr:eq(1)>td:first-child');
		tr_second_td_first.innerWidth(tr_second_td_first_width);
	});	

	//insert colgroup in all tables
	$('#'+tablekey).find('table.inner').each(function(){
		ti=$(this);
		var tbodyText='<colgroup>';
		ti.find('tr:first-child>td').each(function(){
			var td=$(this);
			//console.log(td.innerWidth());
			tbodyText=tbodyText+'<col width="'+td.innerWidth()+'px">';	
		});
		tbodyText=tbodyText+'</colgroup>';
		ti.html(tbodyText+ti.html());
		//ti.css('table-layout','fixed');
	});

	//hiding row and columns accordingly
	$('#'+tablekey).find('table.inner').each(function(){
		var ti=$(this);
		if(ti.hasClass('firstColumn')){
			var td=ti.find('tr>td:first-child');
			var tdi=td.index();
			ti.find('colgroup col:eq('+tdi+')').remove();
			td.hide();
		}
		if(ti.hasClass('firstRow')){
			var td=ti.find('tr:first-child>td');
			td.hide();
		}
	});	

	$('#'+tablekey).find('table.inner').each(function(){
		ti=$(this);
		ti.css('table-layout','fixed');
	});

}		
function changeTheme(){
	$('#themeModal').modal('show');
}
function editProfile(){
	$('#profileModal').modal('show');
}
function editPermission(){
	$('#permissionModal').modal('show');
}	
function toggleSection(anchor){
	$(anchor).parent().parent().find('ul.dragndrop1').toggle();
	$(anchor).find('i').toggleClass(function(){
		return $(this).is('.fa-caret-right, .fa-caret-down') ? 'fa-caret-right fa-caret-down' : 'fa-caret-right';
	});
}	
function callAjaxGet(ajaxUrl,modalId){
	$.ajax({
		url: ajaxUrl, // url where to submit the request
		type : "GET", // type of action POST || GET
		success : function(result) {
			if(modalId!=''){
				$('#'+modalId+" .modal-body").html(result);
				//console.log(result);
			}
		},
		error: function(xhr, resp, text) {
			console.log(xhr, resp, text);
		}
	})		
}	
function callAjaxPost(ajaxUrl,formData,modalId){
	$.ajax({
		url: ajaxUrl, // url where to submit the request
		type : "POST", // type of action POST || GET
		data : {formData},
		success : function(result) {
			if(modalId!=''){
				$('#'+modalId+" .modal-body").html(result);
				//console.log(result);
			}
		},
		error: function(xhr, resp, text) {
			console.log(xhr, resp, text);
		}
	})		
}	
function primaryDashboard(survey_title_url=''){
	document.cookie = "design_survey="+survey_title_url+";path=/;";
	document.cookie = "fill_survey="+survey_title_url+";path=/;";
	document.cookie = "analytics_survey="+survey_title_url+";path=/;";
	setTimeout(function(){
		window.location='<?php echo base_url(); ?>';
	}, 1000);
}		
function createOrExistSurvey(){
	$('#createOrExistSurveyModal').modal('show');
}	
function createSurvey(){
	$('#createOrExistSurveyModal').modal('hide');
	$('#createSurveyModal').modal('show');
}	
function editSurvey(survey_title_url){
	$('#editSurveyModal').modal('show');
	callAjaxGet('<?php echo base_url()."survey/edit/";?>'+survey_title_url,'editSurveyModal');
}	
function editSurveyStyle(survey_title_url){
	$('#styleSurveyModal').modal('show');
	callAjaxGet('<?php echo base_url()."survey/style/";?>'+survey_title_url,'styleSurveyModal');
	setTimeout(function(){
		$('.jscolor').minicolors();
	}, 1000);
}	
function compileSurvey(survey_title_url){
	$('#compileModal').modal('show');
	var mesg='';
	var errorList=[];
	$.ajax({
		url: '<?php echo base_url()."survey/compile/";?>'+survey_title_url, // url where to submit the request
		type : "GET", // type of action POST || GET
		//data : {"elements":columnArray1},
		success : function(result) {
			result=JSON.parse(result);
			for (i = 0; i < result.length; i++) {
				//console.log(eval(result[i]));
				try{
					eval(result[i]);
				}catch(e){
					//mesg+=e.message+" at "+e.lineNumber+" in "+result[i];
					var jsonError={"Error":e.message,"Line":e.lineNumber,"In":result[i]};
					errorList.push(jsonError);
				}finally{
					
				}
			} 	
			for (i = 0; i < errorList.length; i++) {
				//console.log(errorList[i]);
				mesg+="Error: "+errorList[i].Error+'<br>';
				mesg+="Line No: "+errorList[i].Line+'<br>';
				mesg+="In: "+errorList[i].In+'<br><br>';
			}			
			//console.log(mesg);
			//alert(mesg);
			if(mesg==""){
				mesg="No Compilation Errors!";
			}
			$('#compileModal .modal-body').html(mesg);
		},
		error: function(xhr, resp, text) {console.log(xhr, resp, text);}
	});
}	
function duplicateSurvey(survey_title_url){
	$('#duplicateSurveyModal').modal('show');
	$('#duplicateSurveyModal h4').html('Using this template');
	$('#duplicateSurveyModal input[name="id"]').val(survey_title_url);
}		
/*function duplicateSurvey(survey_title_url){
	$.ajax({
		url: '<?php echo base_url()."survey/duplicate/";?>'+survey_title_url, // url where to submit the request
		type : "GET", // type of action POST || GET
		//data : {"elements":columnArray1},
		success : function(result) {
			result=JSON.parse(result);
			console.log(result.survey_id);
			$('#duplicateSurveyModal').modal('show');
			$('#duplicateSurveyModal input[name="id"]').val(result.survey_id);
		},
		error: function(xhr, resp, text) {console.log(xhr, resp, text);}
	});
}		*/
function createSection(){
	$('#createSectionModal').modal('show');
}	
function editSection(section_title_url){
	$('#editSectionModal').modal('show');
	callAjaxGet('<?php echo base_url()."survey/section/edit/";?>'+section_title_url,'editSectionModal');
}	
function duplicateSection(section_title_url){
	callAjaxGet('<?php echo base_url()."survey/section/duplicate/";?>'+section_title_url);
	setTimeout(function(){
		window.location.reload();
	}, 3000);
}	
function delSection(section_title_url){
	if(confirm("Are You Sure! You Want To Delete!!") == true) {
		callAjaxGet('<?php echo base_url()."survey/section/delete/";?>'+section_title_url,'');
		setTimeout(function(){
			window.location.reload();
		}, 1000);
	} 	
}	
function editSectionStyle(section_title_url){
	$('#styleSectionModal').modal('show');
	callAjaxGet('<?php echo base_url()."survey/section/style/";?>'+section_title_url,'styleSectionModal');
	setTimeout(function(){
		$('.jscolor').minicolors();
	}, 1000);
}	
function chooseQuestionFrom(section_title_url){
	$('#chooseQuestionFromModal').modal('show');
	$('#chooseQuestionFromModal input[name="section_name"]').val(section_title_url);
}	
function chooseQuestion(){
	var section_title_url=$('#chooseQuestionFromModal input[name="section_name"]').val();
	$('#chooseQuestionFromModal').modal('hide');
	$('#chooseQuestionModal').modal('show');
	$('#chooseQuestionModal input[name="section_name"]').val(section_title_url);
}	
function chooseQuestionExisting(){
	var section_title_url=$('#chooseQuestionFromModal input[name="section_name"]').val();
	$('#chooseQuestionExistingModal').modal('show');
	$('#chooseQuestionExistingModal input[name="section_id"]').val(section_title_url);
	$('#chooseQuestionFromModal').modal('hide');
}
function createQuestion(qtype){
	var section_title_url=$('#chooseQuestionModal input[name="section_name"]').val();
	$('#chooseQuestionModal').modal('hide');
	$('#createQuestionModal').modal('show');
	$('#createQuestionModal input[name="section_name"]').val(section_title_url);
	callAjaxGet('<?php echo base_url()."survey/question/add/";?>'+qtype+"/"+section_title_url,'createQuestionModal');
	setTimeout(function(){
		var ind=1;
		var fields=$('#createQuestionModal').find('input[type="text"],textarea,input[type="checkbox"],input[type="submit"]').each(function (i) {
			$(this).attr('tabindex', (ind++));
		});	
	}, 2000);		
}	
function createQuestionFromExisting(insertButton){
	var section_id=$('#chooseQuestionExistingModal input[name="section_id"]').val();
	var question_id=$('#chooseQuestionExistingModal input[name="question_id"]').val();
	callAjaxGet('<?php echo base_url()."survey/question/copy/";?>'+section_id+"/"+question_id,'');
	$('#chooseQuestionExistingModal').modal('hide');
	setTimeout(function(){
		window.location.reload();
	}, 1000);
}
function editQuestion(question_id){
	$('#editQuestionModal').modal('show');
	callAjaxGet('<?php echo base_url()."survey/question/edit/";?>'+question_id,'editQuestionModal');
	setTimeout(function(){
		var ind=1;
		var fields=$('#editQuestionModal').find('input[type="text"],textarea,input[type="checkbox"],input[type="submit"]').each(function (i) {
			$(this).attr('tabindex', (ind++));
		});	
	}, 2000);	
}	
function duplicateQuestion(question_id){
	callAjaxGet('<?php echo base_url()."survey/question/duplicate/";?>'+question_id);
	setTimeout(function(){
		window.location.reload();
	}, 2000);	
}		
function editQuestionStyle($question_id){
	$('#styleQuestionModal').modal('show');
	callAjaxGet('<?php echo base_url()."survey/question/style/";?>'+$question_id,'styleQuestionModal');
	setTimeout(function(){
		$('.jscolor').minicolors();
	}, 1000);
}	
function delQuestion(question_id,section_title_url){
	if(confirm("Are You Sure! You Want To Delete!!") == true) {
		callAjaxGet('<?php echo base_url()."survey/question/delete/";?>'+question_id+"/"+section_title_url,'');
		setTimeout(function(){
			window.location.reload();
		}, 1000);
	} 	
}	
function codeQuestion(codeAnchor,question_id){
	var columnArray1 = [];
	$(codeAnchor).parent().parent().find('.question').find(":input:not([name=''])").each(function(i) {
		columnArray1.push($(this).attr('name'));
	});
	//alert(columnArray1);
	url1='<?php echo base_url(); ?>survey/elements/'+question_id;
	$.ajax({
		url: url1, // url where to submit the request
		type : "POST", // type of action POST || GET
		data : {"elements":columnArray1},
		success : function(result) {
			$('#collectCodeNameModal').modal('show');
			callAjaxGet('<?php echo base_url()."survey/question/collectname/";?>'+question_id,'collectCodeNameModal');
		},
		error: function(xhr, resp, text) {console.log(xhr, resp, text);}
	});
}	
function lengthQuestion(lengthAnchor,question_id){
	var columnArray1 = [];
	$(lengthAnchor).parent().parent().find('.question').find(":input:not([name=''])").each(function(i) {
		columnArray1.push($(this).attr('name'));
	});
	url1='<?php echo base_url(); ?>survey/elements/'+question_id;
	$.ajax({
		url: url1, // url where to submit the request
		type : "POST", // type of action POST || GET
		data : {"elements":columnArray1},
		success : function(result) {
			$('#collectLengthModal').modal('show');
			callAjaxGet('<?php echo base_url()."survey/question/lengths/";?>'+question_id,'collectLengthModal');
		},
		error: function(xhr, resp, text) {console.log(xhr, resp, text);}
	});
}
function lengthsSurvey(survey_title_url){
	$('#collectLengthsModal').modal('show');
	callAjaxGet('<?php echo base_url()."survey/lengths/";?>'+survey_title_url,'collectLengthsModal');
}
function completeQuestion(completeAnchor,question_id){
	var columnArray1 = [];
	$(completeAnchor).parent().parent().find('.question').find(":input:not([name=''])").each(function(i) {
		columnArray1.push($(this).attr('name'));
	});
	url1='<?php echo base_url(); ?>survey/elements/'+question_id;
	$.ajax({
		url: url1, // url where to submit the request
		type : "POST", // type of action POST || GET
		data : {"elements":columnArray1},
		success : function(result) {
			console.log(result);
			callAjaxGet('<?php echo base_url()."survey/question/completequestion/";?>'+question_id,'');
			setTimeout(function(){
				window.location.reload();
			}, 1000);			
		},
		error: function(xhr, resp, text) {console.log(xhr, resp, text);}
	});	
}	
function saveCodename(savebutton){
	var duplicate=true;
	var arr = [];
	$("#formCodeName").find('input[type="text"]').each(function(){
		var value = $(this).val();
		if(arr.indexOf(value) == -1){
			if(value!=""){
				arr.push(value);
			}
		}else{
			duplicate=false;
			$(this).addClass("duplicate_codename");
		}
	});	

	if(duplicate==true){
		var question_id=$('#question_id').val();
		var form_serialized_data=$("#formCodeName").serialize();
		$.ajax({
			url: '<?php echo base_url()."survey/question/savecodename/";?>'+question_id, // url where to submit the request
			type : "POST", // type of action POST || GET
			data : $("#formCodeName").serialize(), // post data || get data
			success : function(result) {
				//console.log(result);
				$('#collectCodeNameModal').modal('hide');
				$('#collectCodeQuestionModal').modal('show');
				callAjaxGet('<?php echo base_url()."survey/question/collectcode/";?>'+question_id,'collectCodeQuestionModal');
			},
			error: function(xhr, resp, text) {
				console.log(xhr, resp, text);
			}
		});	
	}else{
		alert('Duplicate Detected!');
	}
}	
function saveLengths(savebutton){
	var all='true';
	//var question_id=$('#question_id').val();
	var question_id=$('#collectLengthModal').find('input[name="question_id"]').val();
	var form_lengths_fields=$('#formLengths input[type="text"]').each(function(){
		if($(this).val()==""){
			all='false';
		}
	});
	console.log(all);
	if(all==='true'){
		$.ajax({
			url: '<?php echo base_url()."survey/question/savelengths/";?>'+question_id, // url where to submit the request
			type : "POST", // type of action POST || GET
			data : $("#formLengths").serialize(), // post data || get data
			success : function(result) {
				alert("Format & Lengths saved sucessfully");
				$('#collectLengthModal').modal('hide');
			},
			error: function(xhr, resp, text) {
				console.log(xhr, resp, text);
			}
		});	
	}else{
		alert("Please fill all lengths");
	}
}	
function saveLengthsAll(survey_title_url){
	var forms=$('form[name="formLengths"]');
	var i=[];
	//console.log(forms);
	
	var all='true';	
	var form_lengths_fields=$('form[name="formLengths"] input[type="text"]').each(function(){
		if($(this).val()==""){
			all='false';
		}
	});
	//console.log(all);
	forms.each(function(){
		var question_id=$(this).find('input[name="question_id"]').val();
		var formData=$(this).serialize();
		i.push({question_id: question_id, formData: formData});
	});
	//console.log(i);
	i=JSON.stringify(i);
	all='true';
	if(all==='true'){
		$.ajax({
			url: '<?php echo base_url()."survey/savelengths/";?>'+survey_title_url, // url where to submit the request
			type : "POST", // type of action POST || GET
			data : {i}, // post data || get data
			success : function(result) {
				alert("Format & Lengths saved sucessfully");
				$('#collectLengthsModal').modal('hide');
			},
			error: function(xhr, resp, text) {
				console.log(xhr, resp, text);
			}
		});			
	}else{
		alert("Please fill all lengths");
	}
}	
function generateCode(generateButton){
	$('#collectCodeQuestionModal').modal('hide');
	var form_data=$(generateButton).closest('form').serializeArray();
	var question_id=$('#collectCodeQuestionModal').find('input[name="question_id"]').val();
	//alert(form_data);
	$('#saveBeforeClose').attr('checked',true);
	$('#generateCodeQuestionModal').modal('show');
	callAjaxPost('<?php echo base_url()."survey/question/generatecode/";?>',form_data,'generateCodeQuestionModal');
		setTimeout(function(){
			$('#comm_panel').numberedtextarea();
			
			$.ajax({
				url: '<?php echo base_url();?>survey/question/default_name/'+question_id, // url where to submit the request
				type : "GET", // type of action POST || GET
				//data : $("#form_data_code").serialize(), // post data || get data
				success : function(result) {
					//console.log(result);
					$('input[name="default_question_no"]').val(result);
				},
				error: function(xhr, resp, text) {
					console.log(xhr, resp, text);
				}
			});				
		}, 2000);
}	
function saveCode(saveButton){
	$('#generateCodeQuestionModal .loader').show();
	var comm_question_id=$('#comm_question_id').val();
	$.ajax({
		url: '<?php echo base_url();?>survey/question/codesave/'+comm_question_id, // url where to submit the request
		type : "POST", // type of action POST || GET
		data : $("#form_data_code").serialize(), // post data || get data
		success : function(result) {
			$('#saveBeforeClose').attr('checked',false);
			$('#generateCodeQuestionModal').modal('hide');
			alert('Saved Successfully');
			setTimeout(function(){
				window.location.reload();
			}, 1000);
		},
		error: function(xhr, resp, text) {
			console.log(xhr, resp, text);
		}
	});	
}	
function printFunction(selectButton){
	var t=$('#comm_panel');
	var default_question_no=$('#generateCodeQuestionModal .modal-title input[name="default_question_no"]').val();
	var current_question_no=$(selectButton).val();
	default_question_no=$.trim(default_question_no);
	current_question_no=current_question_no.replace('{id}',default_question_no);
	current_question_no=current_question_no.replace("'{id}'","'"+default_question_no+"'");
	t.val(t.val()+current_question_no);
	//$('#comm_panel').numberedtextarea();
}	
function increaseDiv(a){
	var parentdiv=$(a).parent().parent();
	var childdiv=$(parentdiv).find('.acc').get(0);
	$(childdiv).clone().appendTo($(parentdiv));
}	
function decreaseDiv(a){
	var parentdiv=$(a).parent().parent().find('.acc').length;
	if(parentdiv>1){
		var parentchilddiv=$(a).parent();
		$(parentchilddiv).remove();
	}else{
		alert('You must have atleast one answer choice');
	}
}
function increaseLanguage(a){
	var parentdiv=$(a).parent().parent();
	var childdiv=$(parentdiv).find('.acc').get(0);
	$(childdiv).clone().appendTo($(parentdiv));
}	
function decreaseLanguage(a){
	var parentdiv=$(a).parent().parent().find('.acc').length;
	if(parentdiv>1){
		var parentchilddiv=$(a).parent();
		$(parentchilddiv).remove();
	}else{
		$(a).parent().find('input').val('');
		//alert('You must have atleast one choice');
	}
}
function take_answer_choices(a){
	var textarea=$(a).parent().find('textarea');
	$(textarea).toggle();
}
function selectSurvey(){
	$('#createOrExistSurveyModal').modal('hide');
	$('#selectSurveyModal').modal('show');
}	
function chooseSurvey(survey_title_url){
	document.cookie = "fill_survey="+survey_title_url+"; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
	document.cookie = "analytics_survey="+survey_title_url+"; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
	document.cookie = "design_survey="+survey_title_url+";path=/;";
	$('#selectSurveyModal').modal('hide');
	setTimeout(function(){
		window.location.reload();
	}, 1000);
}
function fillSurvey(){
	$('#fillSurveyModal').modal('show');
}	
function chooseSurveyAndFill(survey_title_url){
	//var survey=$('[name="survey_title_url"]:first');
	//console.log(survey_title_url+" "+survey.val());
	
	document.cookie = "design_survey="+survey_title_url+"; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
	document.cookie = "analytics_survey="+survey_title_url+"; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
	document.cookie = "fill_survey="+survey_title_url+";path=/;";
	$('#fillSurveyModal').modal('hide');
	$('#selectSurveyCaseToCompleteModal').modal('show');
	callAjaxGet('<?php echo base_url()."survey/cases/";?>'+survey_title_url,'selectSurveyCaseToCompleteModal');
}
function setSurveyCase(survey_case_id,survey_case){
	localStorage.setItem("survey_case_id", survey_case_id);
	localStorage.setItem("case", survey_case);
	setTimeout(function(){
		window.location.reload();
	}, 1);
}
function setSurveyCase2(survey_case_id,survey_case){
	fill_vals_save();
	var survey_copy=$('#survey_copy');
	localStorage.setItem("survey_case_id", survey_case_id);
	localStorage.setItem("case", survey_case);
	if(survey_copy.length>0){
		if(survey_case=="New"){
			$('#survey_carbon').html($('#survey_copy').html());
			$('#selectSurveyCaseToCompleteModal').modal('hide');
			ready1();
			ready2();
			ready3();
			ready5();
			ready4();
			ready6();
		}else if(survey_case=="Old"){
			$('#survey_carbon').html($('#survey_copy').html());
			$('#selectSurveyCaseToCompleteModal').modal('hide');
			ready1();
			ready2();
			ready3();
			ready5();
			ready4();
			ready6();
		}else{}		
	}else{
		setTimeout(function(){
			window.location.reload();
		}, 1);		
	}
	//console.log($('#survey_copy').html());
}
function analyticsSurvey(){
	$('#analyticsSurveyModal').modal('show');
}	
function chooseSurveyAndAnalytics(survey_title_url){
	document.cookie = "design_survey="+survey_title_url+"; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
	document.cookie = "fill_survey="+survey_title_url+"; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
	document.cookie = "analytics_survey="+survey_title_url+";path=/;";
	$('#analyticsSurveyModal').modal('hide');
	setTimeout(function(){
		window.location.reload();
	}, 1000);
}
function prepareSurveyAnalytics(survey_title_url,survey_text){
	$('#analyticsSurveyModal').modal('hide');
	$('#prepareAnalyticsSurveyModal').modal('show');
	$('#prepareAnalyticsSurveyModal .modal-title').html('<strong>Set Indicators - <span class="title">'+survey_text+'</span></strong>');
	callAjaxGet('<?php echo base_url()."survey/indicators/";?>'+survey_title_url,'prepareAnalyticsSurveyModal');
}	
function saveIndicators(saveIndicatorsButton){
	var formData=$(saveIndicatorsButton).closest('form').serializeArray();
	$.ajax({
		url: '<?php echo base_url();?>survey/indicators/save', // url where to submit the request
		type : "POST", // type of action POST || GET
		data : formData, // post data || get data
		success : function(result) {
			setTimeout(function(){
				//$('#generateCodeQuestionModal .loader').hide();
				window.location.reload();
			}, 1000);
		},error: function(xhr, resp, text) {console.log(xhr, resp, text);}
	});	
}	
function selectMoreIndicators(){
	$('#analyticsMoreIndicatorsSurveyModal').modal('show');
	var survey_id=$('input[name="analytics-survey"]').val();
	callAjaxGet('<?php echo base_url()."survey/list/indicators/";?>'+survey_id,'analyticsMoreIndicatorsSurveyModal');
}
function savePermission(savePermissionButton){
	var formData=$(savePermissionButton).closest('form').serializeArray();
	$.ajax({
		url: '<?php echo base_url();?>survey/permission/save', // url where to submit the request
		type : "POST", // type of action POST || GET
		data : formData, // post data || get data
		success : function(result) {
			alert('Permission Saved Sucessfully!');
			$('#permissionModal').modal('hide');
			setTimeout(function(){
				window.location.reload();
			}, 1000);
		},error: function(xhr, resp, text) {console.log(xhr, resp, text);}
	});	
}	
function editPermissions(){
	$('#permissionModal').modal('hide');
	$('#permissionsModal').modal('show');	
	
}	
function removePermission(permission_remove_link,survey_id,value,username){
	//console.log(survey_id+" "+value+" "+username);
	callAjaxGet('<?php echo base_url()."survey/permission/update/";?>'+survey_id+"/"+value+"/"+username,'');
	$(permission_remove_link).parent().html('');
}	
function closePermission(){
	$('#permissionsModal').modal('hide');	
	setTimeout(function(){
		window.location.reload();
	}, 1000);
}	
function duplicate_question(){
	var arr = [];
	$("input.duplicate_question_check").each(function(){
		var value = $(this).val();
		if (arr.indexOf(value) == -1)
			arr.push(value);
		else
			$(this).closest('li').addClass("duplicate_question");
	});	
}
function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
function languageExist(JSONObject,v){
	for (i=0; i < JSONObject.length; i++) {
		if (JSONObject[i] == v)
			return true;
	}
	return false;	
}
function checkLanguage(language_checkbox){
	var language_checked=$(language_checkbox).prop('checked');
	var language_value=$(language_checkbox).val();
	//console.log(language_value+" "+language_checked);
	if(language_checked){
		//alert("language is true");
		if(document.cookie.indexOf("survey_language=")==-1){
			//alert("cookie not exist but created");
			var json_array = [""+language_value+""];
			var json_string = JSON.stringify(json_array);
			document.cookie = "survey_language="+json_string+";path=/;";
			showLanguage(language_value);
		}else{
			//alert("cookie already created");
			var json_string=readCookie("survey_language");
			var json_array=JSON.parse(json_string);
			if(languageExist(json_array,language_value)){
				//alert("language exist");				
				showLanguage(language_value);
			}else{
				json_array.push(language_value);
				json_string = JSON.stringify(json_array);
				document.cookie = "survey_language="+json_string+";path=/;";
				//alert("language not exist but added");				
				showLanguage(language_value);
			}
		}
	}else{
		//alert("language is false");
		if(document.cookie.indexOf("survey_language=")==-1){
			//alert("cookie not exist");
		}else{
			//alert("cookie already created");
			var json_string=readCookie("survey_language");
			var json_array=JSON.parse(json_string);
			if(json_array.length<2){
				//document.cookie = "survey_language=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";	
				alert("You must have atleast One Language");
				return false;
			}else{
				if(languageExist(json_array,language_value)){
					//alert("language exist and deleted");				
					for (i=0; i < json_array.length; i++) {
						if (json_array[i] == language_value)
							json_array.splice(i,1);
					}
					json_string = JSON.stringify(json_array);
					document.cookie = "survey_language="+json_string+";path=/;";
					hideLanguage(language_value);
				}else{
					//alert("language not exist");				
				}
			}
		}
	}
	//alert(document.cookie);
	//console.log(document.cookie);
	return true;
}
function controlSurvey(survey_title_url){
	$('#controlModal').modal('show');
	callAjaxGet('<?php echo base_url()."survey/control/";?>'+survey_title_url,'controlModal');
}		
$(document).on("blur", ".check_username",function(){
	var obj=$(this);
	var v=obj.val();
	if(v!=""){
		$.ajax({
			url: '<?php echo ONLINE_URL;?>login/check_username/'+obj.val(), // url where to submit the request
			type : "GET", // type of action POST || GET
			success : function(result) {
				if(result == 1){
					$('#username_checked').html('<i class="fa fa-times fa-1" aria-hidden="true"></i>');
					//alert('Username Not Available');
					obj.val('');
				}else{
					$('#username_checked').html('<i class="fa fa-check fa-1" aria-hidden="true"></i>');
					//alert('Username Available');
				}
			}
		});
	}else{
		alert('Please Enter Something!');
		$("#register-form").find('input[name="username"]').focus();
	}
});
$(".no-work").hover(function(){
	var obj=$(this);
	obj.parent().attr('href','javascript:void(0)');
});
$("#generateCodeQuestionModal").on("hide.bs.modal", function (e) {
	if($('#saveBeforeClose').is(':checked')){
		if(confirm("Do You Want To Save!") == true) {
			e.preventDefault();
			e.stopPropagation();
			$('#generateCodeQuestionModal .loader').show();
			var comm_question_id=$('#comm_question_id').val();
			$.ajax({
				url: '<?php echo base_url();?>survey/question/codesave/'+comm_question_id, // url where to submit the request
				type : "POST", // type of action POST || GET
				data : $("#form_data_code").serialize(), // post data || get data
				success : function(result) {
					$('#saveBeforeClose').attr('checked',false);
					$('#generateCodeQuestionModal').modal('hide');
					alert('Saved Successfully');
				},
				error: function(xhr, resp, text) {
					console.log(xhr, resp, text);
				}
			});	
		}
	}
});	
$("#format_coding").on("click", function (e) {	
	var text=$('#comm_panel').val();
    var b_text=js_beautify(text,{
	  "indent_size": "0",
	  "indent_char": " ",
	  "max_preserve_newlines": "0",
	  "preserve_newlines": true,
	  "keep_array_indentation": false,
	  "break_chained_methods": false,
	  "indent_scripts": "separate",
	  "brace_style": "collapse",
	  "space_before_conditional": false,
	  "unescape_strings": false,
	  "jslint_happy": false,
	  "end_with_newline": false,
	  "wrap_line_length": "0",
	  "indent_inner_html": false,
	  "comma_first": false,
	  "e4x": true,
	  "indent_empty_lines": false
	});	
	$('#comm_panel').val(b_text);
	//console.log(b_text);
});
</script>

<?php if($this->session->has_userdata('user_logged_id')){ ?>
<script src="<?php echo base_url(); ?>theme/js/bootstrap3-typeahead.min.js"></script>  
<?php } ?>

<script src="<?php echo base_url(); ?>theme/js/jquery-ui.min.js"></script>
<script type="text/javascript">	
$(document).ready(function(){
/*drag drop function*/

	var count=0;
	var classArray=[];
	var indexNumber;
	
	$(".draggable").draggable({
		revert: true
	});

	$("#droppableRow").droppable({
		activeClass: "active",
		drop: function (event, ui) {
			var content=ui.draggable.text();
			
			var graph_view=$('input[name="graph-view"]:checked').val();
			var arrayLength=classArray.length;
			var classNumber=0;
			count=count+1;
			if(arrayLength==0){
				classNumber=classNumber+1;
				classArray.push(classNumber);
			}else{
				for(var i=1;i<=count;i++){
					for(var j=0;j<arrayLength;j++){
						if(classArray[j]==i){
							classNumber=0;
							break;
						}else{
							classNumber=i;
						}
					}
					if(classNumber!=0){
						classArray.push(classNumber);
						break;
					}
				}
			}
			if(graph_view==="map"){
				$(this).find('.fa-times-circle').trigger('click');
				$(this).html('<li class="active-'+classNumber+'">'+content+' <i class="fa fa-times-circle"></i></li>');
				$(this).parent().children('.rows-input').html('<p class="active-'+classNumber+'">'+content+'</p>');
				ui.draggable.addClass('active-'+classNumber).hide();
				indexNumber=ui.draggable.index();
				$('#legend-lable-list').children().eq(indexNumber).hide();
				generateGraph();
			}else{
				$(this).append('<li class="active-'+classNumber+'">'+content+' <i class="fa fa-times-circle"></i></li>');
				$(this).parent().children('.rows-input').append('<p class="active-'+classNumber+'">'+content+'</p>');
				ui.draggable.addClass('active-'+classNumber).hide();
				indexNumber=ui.draggable.index();
				$('#legend-lable-list').children('li').eq(indexNumber).hide();
				generateGraph();
			}
		}
	});
	
	$("#droppableColumn").droppable({
		activeClass: "active",
		drop: function (event, ui) {
			var content=ui.draggable.text();
			
			var arrayLength=classArray.length;
			var classNumber=0;
			count=count+1;
			if(arrayLength==0){
				classNumber=classNumber+1;
				classArray.push(classNumber);
			}else{
				for(var i=1;i<=count;i++){
					for(var j=0;j<arrayLength;j++){
						if(classArray[j]==i){
							classNumber=0;
							break;
						}else{
							classNumber=i;
						}
					}
					if(classNumber!=0){
						classArray.push(classNumber);
						break;
					}
				}
			}
			$(this).append('<li class="active-'+classNumber+'">'+content+' <i class="fa fa-times-circle"></i></li>');
			$(this).parent().children('.column-input').append('<p class="active-'+classNumber+'">'+content+'</p>');
			ui.draggable.addClass('active-'+classNumber).hide();
			indexNumber=ui.draggable.index();
			$('#legend-lable-list').children().eq(indexNumber).hide();
			generateGraph();
		}
	});
	
	$("#droppableLayer").droppable({
		activeClass: "active",
		drop: function (event, ui) {
			var content=ui.draggable.text();
			
			var arrayLength=classArray.length;
			var classNumber=0;
			count=count+1;
			if(arrayLength==0){
				classNumber=classNumber+1;
				classArray.push(classNumber);
			}else{
				for(var i=1;i<=count;i++){
					for(var j=0;j<arrayLength;j++){
						if(classArray[j]==i){
							classNumber=0;
							break;
						}else{
							classNumber=i;
						}
					}
					if(classNumber!=0){
						classArray.push(classNumber);
						break;
					}
				}
			}
			$(this).find('.fa-times-circle').trigger('click');
			$(this).html('<li class="active-'+classNumber+'">'+content+' <i class="fa fa-times-circle"></i></li>');
			$(this).parent().children('.layer-input').html('<p class="active-'+classNumber+'">'+content+'</p>');
			ui.draggable.addClass('active-'+classNumber).hide();
			indexNumber=ui.draggable.index();
			$('#legend-lable-list').children().eq(indexNumber).hide();
			generateGraph();
		}
	});
	
	$(document).on('click','.fa-times-circle',function(){
		var className=$(this).parent().attr('class');
		var arrayLength=classArray.length;
		var listItem='active-';
		for(var i=1;i<=count;i++){
			if(listItem+i==className){
				indexNumber=$('.'+className).index();
				$('.rows-input').children('p.'+listItem+i).remove();
				$('.column-input').children('p.'+listItem+i).remove();
				$('.layer-input').children('p.'+listItem+i).remove();
				$('.'+className).show().removeClass(className);
				$('#legend-lable-list').children().eq(indexNumber).show();
				for(var j=0;j<arrayLength;j++){
					if(classArray[j]==i){
						classArray.splice(j, 1);
					}
					break;
				}
				break;
			}
		}
		$(this).parent('li').remove();
		generateGraph();
	});
	
	/*drag drop function end*/
	
	<?php if($this->session->has_userdata('user_logged_id')){ ?>	
	$(".typeahead2").typeahead({
		source: function(query, process) {
			return $.get('<?php echo ONLINE_URL."login/users/search/".$user_data[0]['username'];?>', { query: query }, function (data) {
				data=JSON.parse(data);
				//console.log(data);
				objects = [];
				map = {};
				//var data = [{"label":"System Administrator","value":"1"},{"label":"Software Tester","value":"3"},{"label":" Software Developer","value":"4"},{"label":"Senior Developer","value":"5"},{"label":"Cloud Developer","value":"6"},{"label":"Wordpress Designer","value":"7"}] // Or get your JSON dynamically and load it into this variable
				//console.log(data);
				$.each(data, function(i, object) {
					map[object.value] = object;
					objects.push(object.value);
				});
				return process(objects);
				//console.log(data);
				//return process(data);
			});			
		},
	   items : 10,
	   minLength : 0,
	   updater: function(item){
		   //console.log(item);
		   selectedKey = map[item].data;
		   //console.log(selectedKey);
		   $('input[name="username"]').val(selectedKey);
		   return item;
	   }		
	});	
	$(".typeahead3").typeahead({
		source: function(query, process) {
			return $.get('<?php echo base_url()."survey/search/".$user_data[0]['username'];?>', { query: query }, function (data) {
				data=JSON.parse(data);
				//console.log(data);
				objects = [];
				map = {};
				//var data = [{"label":"System Administrator","value":"1"},{"label":"Software Tester","value":"3"},{"label":" Software Developer","value":"4"},{"label":"Senior Developer","value":"5"},{"label":"Cloud Developer","value":"6"},{"label":"Wordpress Designer","value":"7"}] // Or get your JSON dynamically and load it into this variable
				//console.log(data);
				$.each(data, function(i, object) {
					map[object.value] = object;
					objects.push(object.value);
				});
				return process(objects);
				//console.log(data);
				//return process(data);
			});			
		},
	   items : 10,
	   minLength : 0,
	   updater: function(item){
		   //console.log(item);
		   selectedKey = map[item].data;
		   //console.log(selectedKey);
		   $('input[name="survey_id"]').val(selectedKey);
		   return item;
	   }		
	});	
	$(".typeahead").typeahead({
		source: function(query, process) {
			return $.get('<?php echo base_url()."survey/question/search/";?>', { query: query }, function (data) {
				data=JSON.parse(data);
				console.log(data);
				objects = [];
				map = {};
				//var data = [{"label":"System Administrator","value":"1"},{"label":"Software Tester","value":"3"},{"label":" Software Developer","value":"4"},{"label":"Senior Developer","value":"5"},{"label":"Cloud Developer","value":"6"},{"label":"Wordpress Designer","value":"7"}] // Or get your JSON dynamically and load it into this variable
				//console.log(data);
				$.each(data, function(i, object) {
					map[object.value] = object;
					objects.push(object.value);
				});
				return process(objects);
				//console.log(data);
				//return process(data);
			});			
		},
	   items : 10,
	   minLength : 0,
	   updater: function(item){
		   //console.log(item);
		   selectedKey = map[item].data;
		   //console.log(selectedKey);
		   $('input[name="question_id"]').val(selectedKey);
		   return item;
	   }		
	});	
	<?php } ?>
	
	<?php if($this->session->has_userdata('user_logged_id') && (!get_cookie('fill_survey')!="")){ ?>	
	duplicate_question();
	<?php } ?>
	
	<?php if($this->session->has_userdata('user_logged_id')){ ?>	
		<?php if($TRIAL_EXPIRED && $user_data[0]['license_key_date']==0){?>
			//$('#TrialModal').modal({backdrop: 'static', keyboard: false}, 'show');		
		<?php } ?>	
	<?php } ?>	
	
	$('#permissionModal').on("blur", ".permission_check",function(){
		var p1=$('#permissionModal').find('input[name="username"]').val();
		var p2=$('#permissionModal').find('input[name="survey_id"]').val();
		if(p1!='' && p2!=''){
			$.ajax({
				url: '<?php echo base_url();?>survey/permission/check/'+p1+'/'+p2, // url where to submit the request
				type : "GET", // type of action POST || GET
				//data : $("#form_data_code").serialize(), // post data || get data
				success : function(result) {
					if(result!=''){
						result=JSON.parse(result);
						if(result.permission_design=='1'){
							$('#permissionModal').find('input[name="design_permission"]').prop('checked',true);
						}else{
							$('#permissionModal').find('input[name="design_permission"]').prop('checked',false);
						}
						if(result.permission_fill=='1'){
							$('#permissionModal').find('input[name="fill_permission"]').prop('checked',true);
						}else{
							$('#permissionModal').find('input[name="fill_permission"]').prop('checked',false);
						}
						if(result.permission_analytics=='1'){
							$('#permissionModal').find('input[name="analytics_permission"]').prop('checked',true);
						}else{
							$('#permissionModal').find('input[name="analytics_permission"]').prop('checked',false);
						}
						console.log(result);
					}
				},
				error: function(xhr, resp, text) {
					console.log(xhr, resp, text);
				}
			});
		}
	});	
});
//editSurveyModal	
$('.modal').on('shown.bs.modal', function () {
	$('.datepicker').datepicker();
	setTimeout(function(){
		$('body').addClass('modal-open');
		$('body').css('padding-right','0');
		$('html').css('overflow-x','unset');		//for removing double scrollbar in modals
	}, 1000);   	
});	
function license_check(){
	var pattern=/[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}/g;
	var license=$('input[name="license_key"]').val();
	var username=$('input[name="username"]').val();
	if(pattern.test(license)){

	<?php if(base_url()!=ONLINE_URL){?>		
		$.post('<?php echo ONLINE_URL."desktop_api/license_check/";?>',{'license_key':license,'username':username}).then( function(result) {
			result=JSON.parse(result);
			console.log(result.license_key);
			return $.post('<?php echo base_url()."desktop_api/license_check/";?>',{'license_key':result.license_key,'username':result.username});
		}).then(function(result2) {			
			alert('License Sucessful!!!');
			setTimeout(function(){
				window.location.reload();
			}, 1000);
		}).fail(console.log.bind(console));			
	<?php }else{ ?>
		$.post('<?php echo base_url()."desktop_api/license_check/";?>',{'license_key':license,'username':username}).then( function(result) {
		}).then(function(result2) {			
			alert('License Sucessful!!!');
			setTimeout(function(){
				window.location.reload();
			}, 1000);
		}).fail(console.log.bind(console));
		<?php }?>
	}else{
		alert('Please Enter Correct License Key');
	}
}		
function execSync(anchor){
	var a=$(anchor);
	if(a.hasClass('disabled')){
		alert("Please Wait!");
	}else{
		$(a).addClass('disabled');
		checkQueue();
		goSync();
	}
}	

</script>
	<?php if($this->session->has_userdata('user_logged_id') && (!get_cookie('fill_survey')!="")){ ?>
	<script src="<?php echo base_url(); ?>theme/js/jquery.numberedtextarea.js"></script>
	<?php } ?>
</body>
</html>
