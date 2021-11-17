<?php
$languages=$this->db->query("select languages from survey where title_url in (select survey_id from survey_section where title_url='".$title_url."' ) ");
$languages=$languages->result_array();
if(sizeof($languages)>0){
	$languages=$languages[0]['languages'];
	$languages=(array) json_decode($languages);
	//print_r($languages);
}
?>
<form name="question_add" id="question_add" method="post" action="<?php echo base_url(); ?>survey/question/save/<?php echo $title_url;?>" enctype="multipart/form-data">
	<?php if($qtype=="MC"){?>
	<div id="MC">
		<h2>Multiple Choice Question</h2>
		<label>Question No (Alphanumeric Characters Only)</label>
		<input type="text" name="question_no" placeholder="Question No" />
		<input type="hidden" name="qtype" value="Multiple Choice Question" />
		<label>Question</label>
		<input type="text" name="question" placeholder="Enter Your Question" />
		<?php foreach($languages as $l){?>
        <input type="text" class="lang" name="question_<?php echo $l;?>" placeholder="Enter Your Question in <?php echo $l;?>" />
        <?php } ?>
		<label class="note">Note</label>
		<input type="text" name="question_note" placeholder="Note: " />
		<h5>Answer Choices (key|value)</h5>
		<div class="ac">
			<div class="acc">
				<input class="input-class-80" type="text" name="answer[]" placeholder="Enter an answer choice" />
				<?php foreach($languages as $l){?>
				<input class="input-class-80 lang" type="text" name="answer_<?php echo $l;?>[]" placeholder="Enter an answer choice in <?php echo $l;?>" />
                <?php } ?>
				<a href="javascript:void(0);" onclick="increaseDiv(this)"><i class="fa fa-plus" aria-hidden="true"></i></a>
				<a href="javascript:void(0);" onclick="decreaseDiv(this)"><i class="fa fa-times" aria-hidden="true"></i></a>
			</div>
		</div>
			<label>
				<input type="checkbox" name="multiple_answer" value="1" />
				Allow more than one answer to use this question (Use Checkboxes)
			</label>
			<label>
				<input type="checkbox" name="other_specify_box" value="1" />
				Other Specify Box
			</label>
		<input type="submit" value="Save" />
		<a href="javascript:void(0)" onClick="$('#createQuestionModal').modal('hide');">Cancel</a>
	</div>
	<?php } ?>	
	<?php if($qtype=="DD"){?>
	<div id="DD">
		<h2>Dropdown Question</h2>
		<label>Question No (Alphanumeric Characters Only)</label>
		<input type="text" name="question_no" placeholder="Question No" />
		<input type="hidden" name="qtype" value="Dropdown Question" />
		<label>Question</label>
		<input type="text" name="question" placeholder="Enter Your Question" />
		<?php foreach($languages as $l){?>
        <input type="text" class="lang" name="question_<?php echo $l;?>" placeholder="Enter Your Question in <?php echo $l;?>" />
        <?php } ?>
		<label class="note">Note</label>
		<input type="text" name="question_note" placeholder="Note: " />		
		<h5>Answer Choices (key|value)</h5>
		<div class="ac">
			<div class="acc">
				<input class="input-class-80" type="text" name="answer[]" placeholder="Enter an answer choice" />
				<?php foreach($languages as $l){?>
				<input class="input-class-80 lang" type="text" name="answer_<?php echo $l;?>[]" placeholder="Enter an answer choice in <?php echo $l;?>" />
                <?php } ?>
				<a href="javascript:void(0);" onclick="increaseDiv(this)"><i class="fa fa-plus" aria-hidden="true"></i></a>
				<a href="javascript:void(0);" onclick="decreaseDiv(this)"><i class="fa fa-times" aria-hidden="true"></i></a>
			</div>
		</div>
			<label>
				<input type="checkbox" name="other_specify_box" value="1" />
				Other Specify Box
			</label>
		<input type="submit" value="Save" />
		<a href="javascript:void(0)" onClick="$('#createQuestionModal').modal('hide');">Cancel</a>
	</div>
	<?php } ?>	
	<?php if($qtype=="DM"){?>
	<div id="DM">
		<h2>Dropdown Matrix Question</h2>
		<label>Question No (Alphanumeric Characters Only)</label>
		<input type="text" name="question_no" placeholder="Question No" />
		<input type="hidden" name="qtype" value="Dropdown Matrix Question" />
		<label>Question</label>
		<input type="text" name="question" placeholder="Enter Your Question" />
		<?php foreach($languages as $l){?>
        <input type="text" class="lang" name="question_<?php echo $l;?>" placeholder="Enter Your Question in <?php echo $l;?>" />
        <?php } ?>
		<label class="note">Note</label>
		<input type="text" name="question_note" placeholder="Note: " />		
		<h5>Rows</h5>
		<div class="ac">
			<div class="acc">
				<input class="input-class-80" type="text" name="rows[]" placeholder="Enter a row label" />
				<?php foreach($languages as $l){?>
				<input class="input-class-80 lang" type="text" name="rows_<?php echo $l;?>[]" placeholder="Enter a row label in <?php echo $l;?>" />
                <?php } ?>
				<a href="javascript:void(0);" onclick="increaseDiv(this)"><i class="fa fa-plus" aria-hidden="true"></i></a>
				<a href="javascript:void(0);" onclick="decreaseDiv(this)"><i class="fa fa-times" aria-hidden="true"></i></a>
			</div>
		</div>
		<h5>Columns</h5>
		<div class="ac">
			<div class="acc">
				<input class="input-class-80" type="text" name="columns[]" placeholder="Enter a column label" />
				<?php foreach($languages as $l){?>
				<input class="input-class-80 lang" type="text" name="columns_<?php echo $l;?>[]" placeholder="Enter a column label in <?php echo $l;?>" />
                <?php } ?>
				<a href="javascript:void(0);" onclick="increaseDiv(this)"><i class="fa fa-plus" aria-hidden="true"></i></a>
				<a href="javascript:void(0);" onclick="decreaseDiv(this)"><i class="fa fa-times" aria-hidden="true"></i></a>
				<label>Field Type
					<select class="type-selector" name="type[]">
						<option value="">Empty</option>
						<option value="Date">Date and Time</option>
						<option value="Select">Select</option>
						<option value="Checkbox">Checkbox</option>
						<option value="Radio">Radio</option>
					</select>
					<span>
						<span class="date-options" style="display:none;">
							<span class="date-option">
								Day <input type="checkbox" value="dd" class="date-option-check" />
								<input type="hidden" name="answer_dd[]" />
							</span>
							<span class="date-option">
								Month <input type="checkbox" value="mm" class="date-option-check" />
								<input type="hidden" name="answer_mm[]" />
							</span>
							<span class="date-option">
								Year <input type="checkbox" value="yyyy" class="date-option-check" />
								<input type="hidden" name="answer_yyyy[]" />
							</span>
							<span class="date-option">
								Hour <input type="checkbox" value="h" class="date-option-check" />
								<input type="hidden" name="answer_h[]" />
							</span>
							<span class="date-option">
								Minute <input type="checkbox" value="m" class="date-option-check" />
								<input type="hidden" name="answer_m[]" />
							</span>
						</span>
					<input type="hidden" name="type_other[]"/>
						<span class="other-options">
						Other <input class="type_other_check" type="checkbox" value="1" />
						</span>
					</span>					
				</label>
				<a class="eac" href="javascript:void(0)" onclick="take_answer_choices(this)">Enter Answer Choices (key|value) Enter answers on a separate line</a>
				<textarea name="dropdown_choices[]" placeholder="Dropdown Menu"></textarea>
				<?php foreach($languages as $l){?>
				<textarea class="lang" name="dropdown_choices_<?php echo $l;?>[]" placeholder="Dropdown Menu in <?php echo $l;?>"></textarea>
                <?php } ?>
			</div>
		</div>
		<input type="submit" value="Save" />
		<a href="javascript:void(0)" onClick="$('#createQuestionModal').modal('hide');">Cancel</a>
	</div>
	<?php } ?>	
	<?php if($qtype=="FU"){?>
	<div id="FU">
		<h2>File Upload</h2>
		<label>Question No (Alphanumeric Characters Only)</label>
		<input type="text" name="question_no" placeholder="Question No" />
		<input type="hidden" name="qtype" value="File Upload" />
		<label>Question</label>
		<input type="text" name="question" placeholder="Enter Your Question" />
		<?php foreach($languages as $l){?>
        <input type="text" class="lang" name="question_<?php echo $l;?>" placeholder="Enter Your Question in <?php echo $l;?>" />
        <?php } ?>
		<label class="note">Note</label>
		<input type="text" name="question_note" placeholder="Note: " />		
		<label>Instructions For Respondent</label>
		<input type="text" name="instructions_for_respondent" placeholder="Instructions For Respondent" />
		<?php foreach($languages as $l){?>
		<input type="text" class="lang" name="instructions_for_respondent_<?php echo $l;?>" placeholder="Instructions For Respondent in <?php echo $l;?>" />
        <?php } ?>
		<label>Allowable File Types</label>
		<div>
			<input checked type="checkbox" name="aft[]" value="gif" />&nbsp; GIF
			<input checked type="checkbox" name="aft[]" value="jpg" />&nbsp; JPG
			<input checked type="checkbox" name="aft[]" value="png" />&nbsp; PNG
			<input checked type="checkbox" name="aft[]" value="doc" />&nbsp; DOC
			<input checked type="checkbox" name="aft[]" value="pdf" />&nbsp; PDF
			<br><br>
		</div>						
		<input type="submit" value="Save" />
		<a href="javascript:void(0)" onClick="$('#createQuestionModal').modal('hide');">Cancel</a>
	</div>
	<?php } ?>	
	<?php if($qtype=="RK"){?>
	<div id="RK">
		<h2>Ranking</h2>
		<label>Question No (Alphanumeric Characters Only)</label>
		<input type="text" name="question_no" placeholder="Question No" />
		<input type="hidden" name="qtype" value="Ranking" />
		<label>Question</label>
		<input type="text" name="question" placeholder="Enter Your Question" />
		<?php foreach($languages as $l){?>
        <input type="text" class="lang" name="question_<?php echo $l;?>" placeholder="Enter Your Question in <?php echo $l;?>" />
        <?php } ?>
		<label class="note">Note</label>
		<input type="text" name="question_note" placeholder="Note: " />		
		<h5>Ranking Choices</h5>
		<div class="ac">
			<div class="acc">
				<input class="input-class-80" type="text" name="answer[]" placeholder="Enter a row label" />
				<?php foreach($languages as $l){?>
				<input class="input-class-80 lang" type="text" name="answer_<?php echo $l;?>[]" placeholder="Enter a row label in <?php echo $l;?>" />
                <?php } ?>
				<a href="javascript:void(0);" onclick="increaseDiv(this)"><i class="fa fa-plus" aria-hidden="true"></i></a>
				<a href="javascript:void(0);" onclick="decreaseDiv(this)"><i class="fa fa-times" aria-hidden="true"></i></a>
			</div>
		</div>
		<input type="submit" value="Save" />
		<a href="javascript:void(0)" onClick="$('#createQuestionModal').modal('hide');">Cancel</a>
	</div>
	<?php } ?>	
	<?php if($qtype=="TB"){?>
	<div id="TB">
		<h2>Textbox</h2>
		<label>Question No (Alphanumeric Characters Only)</label>
		<input type="text" name="question_no" placeholder="Question No" />
		<input type="hidden" name="qtype" value="Textbox" />
		<label>Question</label>
		<input type="text" name="question" placeholder="Enter Your Question" />
		<?php foreach($languages as $l){?>
        <input type="text" class="lang" name="question_<?php echo $l;?>" placeholder="Enter Your Question in <?php echo $l;?>" />
        <?php } ?>
		<label class="note">Note</label>
		<input type="text" name="question_note" placeholder="Note: " />		
		<input type="submit" value="Save" />
		<a href="javascript:void(0)" onClick="$('#createQuestionModal').modal('hide');">Cancel</a>
	</div>
	<?php } ?>	
	<?php if($qtype=="MT"){?>
	<div id="MT">
		<h2>Multiple Textbox</h2>
		<label>Question No (Alphanumeric Characters Only)</label>
		<input type="text" name="question_no" placeholder="Question No" />
		<input type="hidden" name="qtype" value="Multiple Textbox" />
		<label>Question</label>
		<input type="text" name="question" placeholder="Enter Your Question" />
		<?php foreach($languages as $l){?>
        <input type="text" class="lang" name="question_<?php echo $l;?>" placeholder="Enter Your Question in <?php echo $l;?>" />
        <?php } ?>
		<label class="note">Note</label>
		<input type="text" name="question_note" placeholder="Note: " />		
		<h5>Textboxes Rows</h5>
		<div class="ac">
			<div class="acc">
				<input class="input-class-80" type="text" name="rows[]" placeholder="Enter a row label" />
				<?php foreach($languages as $l){?>
				<input class="input-class-80 lang" type="text" name="rows_<?php echo $l;?>[]" placeholder="Enter a row label  in <?php echo $l;?>" />
                <?php } ?>
				<a href="javascript:void(0);" onclick="increaseDiv(this)"><i class="fa fa-plus" aria-hidden="true"></i></a>
				<a href="javascript:void(0);" onclick="decreaseDiv(this)"><i class="fa fa-times" aria-hidden="true"></i></a>
			</div>
		</div>
		<input type="submit" value="Save" />
		<a href="javascript:void(0)" onClick="$('#createQuestionModal').modal('hide');">Cancel</a>
	</div>
	<?php } ?>	
	<?php if($qtype=="TM"){?>
	<div id="TM">
		<h2>Textbox Matrix Question</h2>
		<label>Question No (Alphanumeric Characters Only)</label>
		<input type="text" name="question_no" placeholder="Question No" />
		<input type="hidden" name="qtype" value="Textbox Matrix Question" />
		<label>Question</label>
		<input type="text" name="question" placeholder="Enter Your Question" />
			<?php foreach($languages as $l){?>
			<input type="text" class="lang" name="question_<?php echo $l;?>" placeholder="Enter Your Question in <?php echo $l;?>" />
			<?php } ?>
		<label class="note">Note</label>
		<input type="text" name="question_note" placeholder="Note: " />		
		<h5>Rows</h5>
		<div class="ac">
			<div class="acc">
				<input class="input-class-80" type="text" name="rows[]" placeholder="Enter a row label" />
				<?php foreach($languages as $l){?>
				<input class="input-class-80 lang" type="text" name="rows_<?php echo $l;?>[]" placeholder="Enter a row label  in <?php echo $l;?>" />
                <?php } ?>
				<a href="javascript:void(0);" onclick="increaseDiv(this)"><i class="fa fa-plus" aria-hidden="true"></i></a>
				<a href="javascript:void(0);" onclick="decreaseDiv(this)"><i class="fa fa-times" aria-hidden="true"></i></a>
			</div>
		</div>
		<h5>Columns</h5>
		<div class="ac">
			<div class="acc">
				<input class="input-class-80" type="text" name="columns[]" placeholder="Enter a column label" />
				<?php foreach($languages as $l){?>
				<input class="input-class-80 lang" type="text" name="columns_<?php echo $l;?>[]" placeholder="Enter a column label in <?php echo $l;?>" />
                <?php } ?>
				<a href="javascript:void(0);" onclick="increaseDiv(this)"><i class="fa fa-plus" aria-hidden="true"></i></a>
				<a href="javascript:void(0);" onclick="decreaseDiv(this)"><i class="fa fa-times" aria-hidden="true"></i></a>
			</div>
		</div>
		<input type="submit" value="Save" />
		<a href="javascript:void(0)" onClick="$('#createQuestionModal').modal('hide');">Cancel</a>
	</div>
	<?php } ?>	
	<?php if($qtype=="DT"){?>
	<div id="DT">
		<h2>Date/Time</h2>
		<label>Question No (Alphanumeric Characters Only)</label>
		<input type="text" name="question_no" placeholder="Question No" />
		<input type="hidden" name="qtype" value="Date/Time" />
		<label>Question</label>
		<input type="text" name="question" placeholder="Enter Your Question" />
		<?php foreach($languages as $l){?>
		<input type="text" class="lang" name="question_<?php echo $l;?>" placeholder="Enter Your Question in <?php echo $l;?>" />
		<?php } ?>
		<label class="note">Note</label>
		<input type="text" name="question_note" placeholder="Note: " />		
		<!--<label>Rows</label>-->
		<label>
		Day <input type="checkbox" value="dd" name="answer[]" />
		Month <input type="checkbox" value="mm" name="answer[]" />
		Year <input type="checkbox" value="yyyy" name="answer[]" />
		Hour <input type="checkbox" value="h" name="answer[]" />
		Minute <input type="checkbox" value="m" name="answer[]" />
		</label>
		<input type="submit" value="Save" />
		<a href="javascript:void(0)" onClick="$('#createQuestionModal').modal('hide');">Cancel</a>
	</div>
	<?php } ?>	
	<?php if($qtype=="TA"){?>
	<div id="TA">
		<h2>Textarea</h2>
		<label>Question No (Alphanumeric Characters Only)</label>
		<input type="text" name="question_no" placeholder="Question No" />
		<input type="hidden" name="qtype" value="Textarea" />
		<label>Question</label>
		<input type="text" name="question" placeholder="Enter Your Question" />
		<?php foreach($languages as $l){?>
		<input type="text" class="lang" name="question_<?php echo $l;?>" placeholder="Enter Your Question in <?php echo $l;?>" />
		<?php } ?>
		<label class="note">Note</label>
		<input type="text" name="question_note" placeholder="Note: " />		
		<input type="submit" value="Save" />
		<a href="javascript:void(0)" onClick="$('#createQuestionModal').modal('hide');">Cancel</a>
	</div>
	<?php } ?>	
	<?php if($qtype=="SI"){?>
	<div id="SI">
		<h2>Static Image</h2>
		<label>Question No (Alphanumeric Characters Only)</label>
		<input type="text" name="question_no" placeholder="Question No" />
		<input type="hidden" name="qtype" value="Static Image" />
		<label>Question / Label</label>
		<input type="text" name="question" placeholder="Enter Your Question" />
		<?php foreach($languages as $l){?>
		<input type="text" class="lang" name="question_<?php echo $l;?>" placeholder="Enter Your Question in <?php echo $l;?>" />
		<?php } ?>
		<label class="note">Note</label>
		<input type="text" name="question_note" placeholder="Note: " />		
		<label>Upload File</label>
		<input type="file" name="answer_file" />
		<label>Online Url</label>
		<input type="text" name="answer_url" placeholder="Enter Online Url of Image with http://" />
		<input type="submit" value="Save" />
		<a href="javascript:void(0)" onClick="$('#createQuestionModal').modal('hide');">Cancel</a>
	</div>
	<?php } ?>	
</form>
