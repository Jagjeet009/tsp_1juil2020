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
  <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Create Survey</h4>
      </div>
      <div class="modal-body">
		<form method="post" action="<?php echo base_url();?>survey/duplicate/save">
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
  <div class="modal-dialog" style="width:400px;">
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
  <div class="modal-dialog" style="width:600px;">
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
  <div class="modal-dialog" style="width:600px;">
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
  <div class="modal-dialog" style="width:250px;">
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
  <div class="modal-dialog" style="width:600px;">
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
			<!--<select name="functionSelect" class="close" onChange="printFunction(this)" title="select function to insert code">
				<option value="">Functions</option>
				<?php foreach($codeArr as $ca_key=>$ca_value){ ?>					
				<option value="<?php echo $ca_value;?>"><?php echo $ca_key;?></option>
				<?php } ?>
			</select>-->
			<input name="default_question_no" type="hidden" value="" />
			<input type="checkbox" checked id="saveBeforeClose" name="saveBeforeClose" value="1" />
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
