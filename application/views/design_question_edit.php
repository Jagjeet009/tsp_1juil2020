<?php
$matches='';
$sd['json_data']=json_decode($sd['json_data']);
$qno=$sd['id'];
$languages=$this->db->query("select languages from survey where title_url in (select survey_id from survey_section where title_url='".$sd['survey_id']."' ) ");
$languages=$languages->result_array();
if(sizeof($languages)>0){
	$languages=$languages[0]['languages'];
	$languages=(array) json_decode($languages);
}
if(isset($sd['json_data']->question)){
	foreach($languages as $l){
		$matches='';
		$sd['json_data']->{"question_".$l}='';
		preg_match("#<\s*?$l\b[^>]*>(.*?)</$l\b[^>]*>#s", $sd['json_data']->question, $matches);
		if(sizeof($matches)>0){
			$sd['json_data']->{"question_".$l}=strip_tags($matches[0],"<HL>");
			$sd['json_data']->question=str_replace($matches[0],"",$sd['json_data']->question);
		}
	}
	$matches='';
	preg_match("#<\s*?English\b[^>]*>(.*?)</English\b[^>]*>#s", $sd['json_data']->question, $matches);
	if(sizeof($matches)>0){
		$sd['json_data']->question=$matches[1];
	}
}
$matches='';
if(isset($sd['json_data']->answer)){
	foreach($languages as $l){
		$sd['json_data']->{"answer_".$l}='';
		//print_r($sd['json_data']->answer);
		for($i=0;$i<sizeof($sd['json_data']->answer);$i++){
			$matches='';
			preg_match("#<\s*?$l\b[^>]*>(.*?)</$l\b[^>]*>#s", $sd['json_data']->answer[$i], $matches);
			if(sizeof($matches)>0){
				$sd['json_data']->{"answer_".$l}[$i]=strip_tags($matches[0],"<HL>");
				$sd['json_data']->answer[$i]=str_replace($matches[0],"",$sd['json_data']->answer[$i]);
			}
		}
	}
	for($i=0;$i<sizeof($sd['json_data']->answer);$i++){
		$sd['json_data']->answer[$i]=strip_tags($sd['json_data']->answer[$i],"<HL>");
	}
}
$matches='';
if(isset($sd['json_data']->instructions_for_respondent)){
	foreach($languages as $l){
		$matches='';
		$sd['json_data']->{"instructions_for_respondent_".$l}='';
		preg_match("#<\s*?$l\b[^>]*>(.*?)</$l\b[^>]*>#s", $sd['json_data']->instructions_for_respondent, $matches);
		if(sizeof($matches)>0){
			$sd['json_data']->{"instructions_for_respondent_".$l}=strip_tags($matches[0]);
			$sd['json_data']->instructions_for_respondent=str_replace($matches[0],"",$sd['json_data']->instructions_for_respondent);
		}
	}
	$sd['json_data']->instructions_for_respondent=strip_tags($sd['json_data']->instructions_for_respondent);
}
$matches='';
if(isset($sd['json_data']->rows)){
	for($i=0;$i<sizeof($sd['json_data']->rows);$i++){
		foreach($languages as $l){
			$matches='';
			$sd['json_data']->{"rows_".$l}[$i]='';
			preg_match("#<\s*?$l\b[^>]*>(.*?)</$l\b[^>]*>#s", $sd['json_data']->rows[$i], $matches);
			if(sizeof($matches)>0){
				$sd['json_data']->{"rows_".$l}[$i]=strip_tags($matches[0]);
				$sd['json_data']->rows[$i]=str_replace($matches[0],"",$sd['json_data']->rows[$i]);
			}
		}
		$sd['json_data']->rows[$i]=strip_tags($sd['json_data']->rows[$i],"<HL>");
	}
}
$matches='';
if(isset($sd['json_data']->columns)){
	for($i=0;$i<sizeof($sd['json_data']->columns);$i++){
		foreach($languages as $l){
			$matches='';
			$sd['json_data']->{"columns_".$l}[$i]='';
			preg_match("#<\s*?$l\b[^>]*>(.*?)</$l\b[^>]*>#s", $sd['json_data']->columns[$i], $matches);
			if(sizeof($matches)>0){
				$sd['json_data']->{"columns_".$l}[$i]=str_replace('<br>',' ',$matches[1]);
				$sd['json_data']->columns[$i]=str_replace($matches[0],"",$sd['json_data']->columns[$i]);
			}
		}
		$sd['json_data']->columns[$i]=str_replace('<br>',' ',$sd['json_data']->columns[$i]);
		$sd['json_data']->columns[$i]=strip_tags($sd['json_data']->columns[$i],"<HL>");
	}
}
$matches='';
if(isset($sd['json_data']->dropdown_choices)){
	foreach($languages as $l){
		$sd['json_data']->{"dropdown_choices_".$l}=array();
		//print_r($sd['json_data']->answer);
		for($i=0;$i<sizeof($sd['json_data']->dropdown_choices);$i++){
			$new_choice=array();
			for($x=0;$x<sizeof($sd['json_data']->dropdown_choices[$i]);$x++){
				if(isset($sd['json_data']->dropdown_choices[$i][$x])){
					$matches='';
					preg_match("#<\s*?$l\b[^>]*>(.*?)</$l\b[^>]*>#s", $sd['json_data']->dropdown_choices[$i][$x], $matches);
					if(sizeof($matches)>0){
						$sd['json_data']->{"dropdown_choices_".$l}[$i][$x]=strip_tags($matches[0],"<HL>");
						$sd['json_data']->dropdown_choices[$i][$x]=str_replace($matches[0],"",$sd['json_data']->dropdown_choices[$i][$x]);
					}
				}
			}
			if(isset($sd['json_data']->{"dropdown_choices_".$l}[$i])){
				$sd['json_data']->{"dropdown_choices_".$l}[$i]=implode(PHP_EOL,$sd['json_data']->{"dropdown_choices_".$l}[$i]);
			}
		}
	}
	$new_big_choice=array();
	for($i=0;$i<sizeof($sd['json_data']->dropdown_choices);$i++){
		$new_choice=array();
		for($j=0;$j<sizeof($sd['json_data']->dropdown_choices[$i]);$j++){
			if(isset($sd['json_data']->dropdown_choices[$i][$j])){
				$sd['json_data']->dropdown_choices[$i][$j]=strip_tags($sd['json_data']->dropdown_choices[$i][$j],"<HL>");
			}
		}
		if(is_array($sd['json_data']->dropdown_choices[$i])){
			array_push($new_choice,implode(PHP_EOL,$sd['json_data']->dropdown_choices[$i]));
		}
		array_push($new_big_choice,$new_choice);
	}
	$sd['json_data']->dropdown_choices=$new_big_choice;
}
//print_r($sd['json_data']);
if(!isset($sd['json_data']->question_note)){
	$sd['json_data']->question_note="";
}
?>
				<form name="question_edit" id="question_edit" method="post" action="<?php echo base_url()."survey/question/editsave/".$sd['id']; ?>" name="published_form" id="published_form" enctype="multipart/form-data">
					<input type="hidden" name="title_url" value="<?php echo $sd['survey_id']; ?>" />	
					<input type="hidden" name="qtype" value="<?php echo $sd['qtype'];?>" />
					
						<?php if($sd['qtype']=="Multiple Choice Question"){ ?>					
						<h2>Multiple Choice Question</h2>
							<label>Question No (Alphanumeric Characters Only)</label>
							<input type="text" name="question_no" placeholder="Question No" value="<?php echo $sd['json_data']->question_no; ?>" />
							<label>Question</label>
							<input type="text" name="question" placeholder="Enter Your Question" value="<?php echo $sd['json_data']->question; ?>" />
							<?php foreach($languages as $l){?>
							<input type="text" class="lang" name="question_<?php echo $l;?>" placeholder="Enter Your Question in <?php echo $l;?>" value="<?php if(isset($sd['json_data']->{"question_".$l})){echo $sd['json_data']->{"question_".$l};}?>" />
							<?php } ?>
							<label class="note">Note</label>
							<input type="text" name="question_note" placeholder="Note: " value="<?php echo $sd['json_data']->question_note; ?>" />							
							<h5>Answer Choices (key|value)</h5>
							<div class="ac">
								<?php for($i=0;$i<sizeof($sd['json_data']->answer);$i++){ ?>
								<div class="acc">
									<input class="input-class-80" type="text" name="answer[]" placeholder="Enter an answer choice" value="<?php if(isset($sd['json_data']->answer[$i])){echo $sd['json_data']->answer[$i];} ?>" />
									<?php foreach($languages as $l){ ?>
										<input class="input-class-80 lang" type="text" name="answer<?php echo "_".$l;?>[]" placeholder="Enter an answer choice" value="<?php if(isset($sd['json_data']->{"answer_".$l}[$i])){echo $sd['json_data']->{"answer_".$l}[$i];} ?>" />
									<?php } ?>
									<a href="javascript:void(0);" onclick="increaseDiv(this)"><i class="fa fa-plus" aria-hidden="true"></i></a>
									<a href="javascript:void(0);" onclick="decreaseDiv(this)"><i class="fa fa-times" aria-hidden="true"></i></a>
								</div>
								<?php }?>
							</div>
								<label>
									<input <?php if(isset($sd['json_data']->multiple_answer) && $sd['json_data']->multiple_answer=='1'){echo "checked";} ?> type="checkbox" name="multiple_answer" value="1" />
									Allow more than one answer to use this question (Use Checkboxes)
								</label>
								<label>
									<input <?php if(isset($sd['json_data']->other_specify_box) && $sd['json_data']->other_specify_box=='1'){echo "checked";} ?> type="checkbox" name="other_specify_box" value="1" />
									Other Specify Box
								</label>
							<input class="editsave" type="submit" value="Save" />
						<?php }?>	
						
						<?php if($sd['qtype']=="Dropdown Question"){ ?>		
						<h2>Dropdown Question</h2>
							<label>Question No (Alphanumeric Characters Only)</label>
							<input type="text" name="question_no" placeholder="Question No" value="<?php echo $sd['json_data']->question_no; ?>" />
							<label>Question</label>
							<input type="text" name="question" placeholder="Enter Your Question" value="<?php echo $sd['json_data']->question; ?>" />
							<?php foreach($languages as $l){?>
							<input type="text" class="lang" name="question_<?php echo $l;?>" placeholder="Enter Your Question in <?php echo $l;?>" value="<?php if(isset($sd['json_data']->{"question_".$l})){echo $sd['json_data']->{"question_".$l};}?>" />
							<?php } ?>
							<label class="note">Note</label>
							<input type="text" name="question_note" placeholder="Note: " value="<?php echo $sd['json_data']->question_note; ?>" />							
							<h5>Answer Choices (key|value)</h5>
							<div class="ac">
								<?php for($i=0;$i<sizeof($sd['json_data']->answer);$i++){ ?>
								<div class="acc">
									<input class="input-class-80" type="text" name="answer[]" placeholder="Enter an answer choice" value="<?php if(isset($sd['json_data']->answer[$i])){echo $sd['json_data']->answer[$i];} ?>" />
									<?php foreach($languages as $l){ ?>
										<input class="input-class-80 lang" type="text" name="answer<?php echo "_".$l;?>[]" placeholder="Enter an answer choice" value="<?php if(isset($sd['json_data']->{"answer_".$l}[$i])){echo $sd['json_data']->{"answer_".$l}[$i];} ?>" />
									<?php } ?>
									<a href="javascript:void(0);" onclick="increaseDiv(this)"><i class="fa fa-plus" aria-hidden="true"></i></a>
									<a href="javascript:void(0);" onclick="decreaseDiv(this)"><i class="fa fa-times" aria-hidden="true"></i></a>
								</div>
								<?php }?>
							</div>
								<label>
									<input <?php if(isset($sd['json_data']->other_specify_box) && $sd['json_data']->other_specify_box=='1'){echo "checked";} ?> type="checkbox" name="other_specify_box" value="1" />
									Other Specify Box
								</label>
							<input class="editsave" type="submit" value="Save" />
						<?php }?>	
						
						<?php if($sd['qtype']=="Dropdown Matrix Question"){?>
						<h2>Dropdown Matrix Question</h2>
							<label>Question No (Alphanumeric Characters Only)</label>
							<input type="text" name="question_no" placeholder="Question No" value="<?php echo $sd['json_data']->question_no; ?>" />
							<label>Question</label>
							<input type="text" name="question" placeholder="Enter Your Question" value="<?php echo $sd['json_data']->question; ?>" />
							<?php foreach($languages as $l){?>
							<input type="text" class="lang" name="question_<?php echo $l;?>" placeholder="Enter Your Question in <?php echo $l;?>" value="<?php if(isset($sd['json_data']->{"question_".$l})){echo $sd['json_data']->{"question_".$l};}?>" />
							<?php } ?>
							<label class="note">Note</label>
							<input type="text" name="question_note" placeholder="Note: " value="<?php echo $sd['json_data']->question_note; ?>" />							
							<h5>Rows</h5>
							<div class="ac">
								<?php for($x=0;$x<sizeof($sd['json_data']->rows);$x++){?>
								<div class="acc">
									<input class="input-class-80" type="text" name="rows[]" placeholder="Enter a row label" value="<?php echo $sd['json_data']->rows[$x]; ?>" />
									<?php foreach($languages as $l){?>
									<input class="input-class-80 lang" type="text" name="rows_<?php echo $l;?>[]" placeholder="Enter a row label in <?php echo $l;?>" value="<?php if(isset($sd['json_data']->{"rows_".$l}[$x])){echo $sd['json_data']->{"rows_".$l}[$x];}?>" />
									<?php } ?>
									<a href="javascript:void(0);" onclick="increaseDiv(this)"><i class="fa fa-plus" aria-hidden="true"></i></a>
									<a href="javascript:void(0);" onclick="decreaseDiv(this)"><i class="fa fa-times" aria-hidden="true"></i></a>
								</div>
								<?php }?>
							</div>
							<h5>Columns</h5>
							<div class="ac">
								<?php for($i=0;$i<sizeof($sd['json_data']->columns);$i++){?>
								<div class="acc">
									<input class="input-class-80" type="text" name="columns[]" placeholder="Enter a column label" value="<?php echo $sd['json_data']->columns[$i]; ?>" />
									<?php foreach($languages as $l){?>
									<input class="input-class-80 lang" type="text" name="columns_<?php echo $l;?>[]" placeholder="Enter a column label in <?php echo $l;?>"  value="<?php if(isset($sd['json_data']->{"columns_".$l}[$i])){echo $sd['json_data']->{"columns_".$l}[$i];}?>" />
									<?php } ?>
									<a href="javascript:void(0);" onclick="increaseDiv(this)"><i class="fa fa-plus" aria-hidden="true"></i></a>
									<a href="javascript:void(0);" onclick="decreaseDiv(this)"><i class="fa fa-times" aria-hidden="true"></i></a>
									<label>Field Type
										<select class="type-selector" name="type[]">
											<option <?php if($sd['json_data']->type[$i]==""){echo "selected";} ?> value="">Empty</option>
											<option <?php if($sd['json_data']->type[$i]=="Date"){echo "selected";} ?> value="Date">Date and Time</option>
											<option <?php if($sd['json_data']->type[$i]=="Select"){echo "selected";} ?> value="Select">Select</option>
											<option <?php if($sd['json_data']->type[$i]=="Checkbox"){echo "selected";} ?> value="Checkbox">Checkbox</option>
											<option <?php if($sd['json_data']->type[$i]=="Radio"){echo "selected";} ?> value="Radio">Radio</option>
										</select>
										<span>
											<span class="date-options" <?php if($sd['json_data']->type[$i]=="Date"){}else{echo 'style="display:none;"';}?>>
												<span class="date-option">
													Day <input type="checkbox" class="date-option-check" value="dd" <?php if(isset($sd['json_data']->answer_dd[$i]) && $sd['json_data']->answer_dd[$i]!=''){echo "checked";}?> />
													<input type="hidden" name="answer_dd[]" value="<?php if(isset($sd['json_data']->answer_dd[$i]) && $sd['json_data']->answer_dd[$i]!=''){echo "dd";}?>" />
												</span>
												<span class="date-option">
													Month <input type="checkbox" class="date-option-check" value="mm" <?php if(isset($sd['json_data']->answer_mm[$i]) && $sd['json_data']->answer_mm[$i]!=''){echo "checked";}?> />
													<input type="hidden" name="answer_mm[]" value="<?php if(isset($sd['json_data']->answer_mm[$i]) && $sd['json_data']->answer_mm[$i]!=''){echo "mm";}?>" />
												</span>
												<span class="date-option">
													Year <input type="checkbox" class="date-option-check" value="yyyy" <?php if(isset($sd['json_data']->answer_yyyy[$i]) && $sd['json_data']->answer_yyyy[$i]!=''){echo "checked";}?> />
													<input type="hidden" name="answer_yyyy[]" value="<?php if(isset($sd['json_data']->answer_yyyy[$i]) && $sd['json_data']->answer_yyyy[$i]!=''){echo "yyyy";}?>" />
												</span>
												<span class="date-option">
													Hour <input type="checkbox" class="date-option-check" value="h" <?php if(isset($sd['json_data']->answer_h[$i]) && $sd['json_data']->answer_h[$i]!=''){echo "checked";}?> />
													<input type="hidden" name="answer_h[]" value="<?php if(isset($sd['json_data']->answer_h[$i]) && $sd['json_data']->answer_h[$i]!=''){echo "h";}?>" />
												</span>
												<span class="date-option">
													Minute <input type="checkbox" class="date-option-check" value="m" <?php if(isset($sd['json_data']->answer_m[$i]) && $sd['json_data']->answer_m[$i]!=''){echo "checked";}?> />										
													<input type="hidden" name="answer_m[]" value="<?php if(isset($sd['json_data']->answer_m[$i]) && $sd['json_data']->answer_m[$i]!=''){echo "m";}?>" />
												</span>
											</span>
										<input type="hidden" name="type_other[]" value="<?php if(isset($sd['json_data']->type_other[$i]) && $sd['json_data']->type_other[$i]=="1"){echo "1";} ?>" />
											<span class="other-options">
											Other <input class="type_other_check" <?php if(isset($sd['json_data']->type_other[$i]) && $sd['json_data']->type_other[$i]=="1"){echo "checked";} ?> type="checkbox" value="1" />
											<span>
										</span>
									</label>									
									<a class="eac" href="javascript:void(0)" onclick="take_answer_choices(this)">Enter Answer Choices (key|value) Enter answers on a separate line</a>
									<textarea name="dropdown_choices[]" placeholder="Dropdown Menu"><?php echo $sd['json_data']->dropdown_choices[$i][0]; ?></textarea>
									<?php foreach($languages as $l){?>
									<textarea class="lang" name="dropdown_choices_<?php echo $l;?>[]" placeholder="Dropdown Menu in <?php echo $l;?>"><?php if(isset($sd['json_data']->{"dropdown_choices_".$l}[$i])){ echo $sd['json_data']->{"dropdown_choices_".$l}[$i];} ?></textarea>
									<?php } ?>
								</div>
								<?php }?>
							</div>
							<input class="editsave" type="submit" value="Save" />
						<?php }?>	

						<?php if($sd['qtype']=="File Upload"){  ?>		
						<h2>File Upload</h2>
							<label>Question No (Alphanumeric Characters Only)</label>
							<input type="text" name="question_no" placeholder="Question No" value="<?php echo $sd['json_data']->question_no; ?>" />
							<label>Question</label>
							<input type="text" name="question" placeholder="Enter Your Question" value="<?php echo $sd['json_data']->question; ?>" />
							<?php foreach($languages as $l){?>
							<input type="text" class="lang" name="question_<?php echo $l;?>" placeholder="Enter Your Question in <?php echo $l;?>" value="<?php if(isset($sd['json_data']->{"question_".$l})){echo $sd['json_data']->{"question_".$l};}?>" />
							<?php } ?>
							<label class="note">Note</label>
							<input type="text" name="question_note" placeholder="Note: " value="<?php echo $sd['json_data']->question_note; ?>" />							
							<label>Instructions For Respondent</label>
							<input type="text" name="instructions_for_respondent" placeholder="Instructions For Respondent" value="<?php echo $sd['json_data']->instructions_for_respondent; ?>" />
							<?php foreach($languages as $l){?>
							<input type="text" class="lang" name="instructions_for_respondent_<?php echo $l;?>" placeholder="Instructions For Respondentin <?php echo $l;?>" value="<?php if(isset($sd['json_data']->{"instructions_for_respondent_".$l})){echo $sd['json_data']->{"instructions_for_respondent_".$l};} ?>" />
							<?php } ?>
							<label>Allowable File Types</label>
							<div>
								<input <?php if(in_array('gif',$sd['json_data']->aft)){echo "checked";} ?> type="checkbox" name="aft[]" value="gif" />&nbsp; GIF
								<input <?php if(in_array('jpg',$sd['json_data']->aft)){echo "checked";} ?>  type="checkbox" name="aft[]" value="jpg" />&nbsp; JPG
								<input <?php if(in_array('png',$sd['json_data']->aft)){echo "checked";} ?> type="checkbox" name="aft[]" value="png" />&nbsp; PNG
								<input <?php if(in_array('doc',$sd['json_data']->aft)){echo "checked";} ?> type="checkbox" name="aft[]" value="doc" />&nbsp; DOC
								<input <?php if(in_array('pdf',$sd['json_data']->aft)){echo "checked";} ?> type="checkbox" name="aft[]" value="pdf" />&nbsp; PDF
								<br><br>
							</div>						
							<input class="editsave" type="submit" value="Save" />
						<?php }?>	
						
						<?php if($sd['qtype']=="Ranking"){ ?>					
						<h2>Ranking</h2>
							<label>Question No (Alphanumeric Characters Only)</label>
							<input type="text" name="question_no" placeholder="Question No" value="<?php echo $sd['json_data']->question_no; ?>" />
							<label>Question</label>
							<input type="text" name="question" placeholder="Enter Your Question" value="<?php echo $sd['json_data']->question; ?>" />
							<?php foreach($languages as $l){?>
							<input type="text" class="lang" name="question_<?php echo $l;?>" placeholder="Enter Your Question in <?php echo $l;?>" value="<?php if(isset($sd['json_data']->{"question_".$l})){echo $sd['json_data']->{"question_".$l};}?>" />
							<?php } ?>
							<label class="note">Note</label>
							<input type="text" name="question_note" placeholder="Note: " value="<?php echo $sd['json_data']->question_note; ?>" />							
							<h5>Ranking Choices</h5>
							<div class="ac">
								<?php for($i=0;$i<sizeof($sd['json_data']->answer);$i++){ ?>
								<div class="acc">
									<input class="input-class-80" type="text" name="answer[]" placeholder="Enter an answer choice" value="<?php if(isset($sd['json_data']->answer[$i])){echo $sd['json_data']->answer[$i];} ?>" />
									<?php foreach($languages as $l){ ?>
										<input class="input-class-80 lang" type="text" name="answer<?php echo "_".$l;?>[]" placeholder="Enter an answer choice" value="<?php if(isset($sd['json_data']->{"answer_".$l}[$i])){echo $sd['json_data']->{"answer_".$l}[$i];} ?>" />
									<?php } ?>
									<a href="javascript:void(0);" onclick="increaseDiv(this)"><i class="fa fa-plus" aria-hidden="true"></i></a>
									<a href="javascript:void(0);" onclick="decreaseDiv(this)"><i class="fa fa-times" aria-hidden="true"></i></a>
								</div>
								<?php }?>
							</div>
							<input class="editsave" type="submit" value="Save" />
						<?php }?>	
						
						<?php if($sd['qtype']=="Textbox"){ ?>					
						<h2>Textbox</h2>
							<label>Question No (Alphanumeric Characters Only)</label>
							<input type="text" name="question_no" placeholder="Question No" value="<?php echo $sd['json_data']->question_no; ?>" />
							<label>Question</label>
							<input type="text" name="question" placeholder="Enter Your Question" value="<?php echo $sd['json_data']->question; ?>" />
							<?php foreach($languages as $l){?>
							<input type="text" class="lang" name="question_<?php echo $l;?>" placeholder="Enter Your Question in <?php echo $l;?>" value="<?php if(isset($sd['json_data']->{"question_".$l})){echo $sd['json_data']->{"question_".$l};}?>" />
							<?php } ?>
							<label class="note">Note</label>
							<input type="text" name="question_note" placeholder="Note: " value="<?php echo $sd['json_data']->question_note; ?>" />							
							<input class="editsave" type="submit" value="Save" />
						<?php }?>	
						
						<?php if($sd['qtype']=="Multiple Textbox"){ ?>					
						<h2>Multiple Textbox</h2>
							<label>Question No (Alphanumeric Characters Only)</label>
							<input type="text" name="question_no" placeholder="Question No" value="<?php echo $sd['json_data']->question_no; ?>" />
							<label>Question</label>
							<input type="text" name="question" placeholder="Enter Your Question" value="<?php echo $sd['json_data']->question; ?>" />
							<?php foreach($languages as $l){?>
							<input type="text" class="lang" name="question_<?php echo $l;?>" placeholder="Enter Your Question in <?php echo $l;?>" value="<?php if(isset($sd['json_data']->{"question_".$l})){ echo $sd['json_data']->{"question_".$l};}?>" />
							<?php } ?>
							<label class="note">Note</label>
							<input type="text" name="question_note" placeholder="Note: " value="<?php echo $sd['json_data']->question_note; ?>" />							
							<h5>Textboxes Rows</h5>
							<div class="ac">
								<?php for($i=0;$i<sizeof($sd['json_data']->rows);$i++){ ?>
								<div class="acc">
									<input class="input-class-80" type="text" name="rows[]" placeholder="Enter a row label"  value="<?php if(isset($sd['json_data']->rows[$i])){ echo $sd['json_data']->rows[$i];} ?>" />
									<?php foreach($languages as $l){?>
									<input class="input-class-80 lang" type="text" name="rows_<?php echo $l;?>[]" placeholder="Enter a row label  in <?php echo $l;?>"  value="<?php if(isset($sd['json_data']->{"rows_".$l}[$i])){echo $sd['json_data']->{"rows_".$l}[$i];} ?>" />
									<?php } ?>
									<a href="javascript:void(0);" onclick="increaseDiv(this)"><i class="fa fa-plus" aria-hidden="true"></i></a>
									<a href="javascript:void(0);" onclick="decreaseDiv(this)"><i class="fa fa-times" aria-hidden="true"></i></a>
								</div>
								<?php } ?>
							</div>
							<input class="editsave" type="submit" value="Save" />
						<?php }?>	
						
						<?php if($sd['qtype']=="Textbox Matrix Question"){?>
						<h2>Textbox Matrix Question</h2>
							<label>Question No (Alphanumeric Characters Only)</label>
							<input type="text" name="question_no" placeholder="Question No" value="<?php echo $sd['json_data']->question_no; ?>" />
							<label>Question</label>
							<input type="text" name="question" placeholder="Enter Your Question" value="<?php echo $sd['json_data']->question; ?>" />
							<?php foreach($languages as $l){?>
							<input type="text" class="lang" name="question_<?php echo $l;?>" placeholder="Enter Your Question in <?php echo $l;?>" value="<?php echo $sd['json_data']->{"question_".$l};?>" />
							<?php } ?>
							<label class="note">Note</label>
							<input type="text" name="question_note" placeholder="Note: " value="<?php echo $sd['json_data']->question_note; ?>" />							
							<h5>Rows</h5>
							<div class="ac">
								<?php for($i=0;$i<sizeof($sd['json_data']->rows);$i++){ ?>
								<div class="acc">
									<input class="input-class-80" type="text" name="rows[]" placeholder="Enter a row label"  value="<?php echo $sd['json_data']->rows[$i]; ?>" />
									<?php foreach($languages as $l){?>
									<input class="input-class-80 lang" type="text" name="rows_<?php echo $l;?>[]" placeholder="Enter a row label  in <?php echo $l;?>"  value="<?php echo $sd['json_data']->{"rows_".$l}[$i]; ?>" />
									<?php } ?>
									<a href="javascript:void(0);" onclick="increaseDiv(this)"><i class="fa fa-plus" aria-hidden="true"></i></a>
									<a href="javascript:void(0);" onclick="decreaseDiv(this)"><i class="fa fa-times" aria-hidden="true"></i></a>
								</div>
								<?php } ?>
							</div>
							<h5>Columns</h5>
							<div class="ac">
								<?php for($i=0;$i<sizeof($sd['json_data']->columns);$i++){ ?>
								<div class="acc">
									<input class="input-class-80" type="text" name="columns[]" placeholder="Enter a column label"  value="<?php echo $sd['json_data']->columns[$i]; ?>" />
									<?php foreach($languages as $l){?>
									<input class="input-class-80 lang" type="text" name="columns_<?php echo $l;?>[]" placeholder="Enter a column label  in <?php echo $l;?>"  value="<?php echo $sd['json_data']->{"columns_".$l}[$i]; ?>" />
									<?php } ?>
									<a href="javascript:void(0);" onclick="increaseDiv(this)"><i class="fa fa-plus" aria-hidden="true"></i></a>
									<a href="javascript:void(0);" onclick="decreaseDiv(this)"><i class="fa fa-times" aria-hidden="true"></i></a>
								</div>
								<?php } ?>
							</div>
							<input class="editsave" type="submit" value="Save" />
						<?php }?>	

						<?php if($sd['qtype']=="Date/Time"){ ?>					
						<h2>Date/Time</h2>
							<label>Question No (Alphanumeric Characters Only)</label>
							<input type="text" name="question_no" placeholder="Question No" value="<?php echo $sd['json_data']->question_no; ?>" />
							<label>Question</label>
							<input type="text" name="question" placeholder="Enter Your Question" value="<?php echo $sd['json_data']->question; ?>" />
							<?php foreach($languages as $l){?>
							<input type="text" class="lang" name="question_<?php echo $l;?>" placeholder="Enter Your Question in <?php echo $l;?>" value="<?php echo $sd['json_data']->{"question_".$l};?>" />
							<?php } ?>
							<label class="note">Note</label>
							<input type="text" name="question_note" placeholder="Note: " value="<?php echo $sd['json_data']->question_note; ?>" />							
							<!--<label>Rows</label>-->
							<!--<input type="text" name="answer" placeholder="Date / Time" value="<?php echo $sd['json_data']->answer; ?>" />-->
							<label>
							Day <input <?php if(in_array("dd",(array) $sd['json_data']->answer)){echo "checked";} ?> type="checkbox" value="dd" name="answer[]" />
							Month <input <?php if(in_array("mm",(array) $sd['json_data']->answer)){echo "checked";} ?> type="checkbox" value="mm" name="answer[]" />
							Year <input <?php if(in_array("yyyy",(array) $sd['json_data']->answer)){echo "checked";} ?> type="checkbox" value="yyyy" name="answer[]" />
							Hour <input <?php if(in_array("h",(array) $sd['json_data']->answer)){echo "checked";} ?> type="checkbox" value="h" name="answer[]" />
							Minute <input <?php if(in_array("m",(array) $sd['json_data']->answer)){echo "checked";} ?> type="checkbox" value="m" name="answer[]" />
							</label>
							<input class="editsave" type="submit" value="Save" />
						<?php }?>	
					
						<?php if($sd['qtype']=="Textarea"){  ?>					
						<h2>Textarea</h2>
							<label>Question No (Alphanumeric Characters Only)</label>
							<input type="text" name="question_no" placeholder="Question No" value="<?php echo $sd['json_data']->question_no; ?>" />
							<label>Question</label>
							<input type="text" name="question" placeholder="Enter Your Question" value="<?php echo $sd['json_data']->question; ?>" />
							<?php foreach($languages as $l){?>
							<input type="text" class="lang" name="question_<?php echo $l;?>" placeholder="Enter Your Question in <?php echo $l;?>" value="<?php echo $sd['json_data']->{"question_".$l};?>" />
							<?php } ?>
							<label class="note">Note</label>
							<input type="text" name="question_note" placeholder="Note: " value="<?php echo $sd['json_data']->question_note; ?>" />							
							<input class="editsave" type="submit" value="Save" />
						<?php }?>	
																											
						<?php if($sd['qtype']=="Static Image"){?>					
						<h2>Static Image</h2>
							<label>Question No (Alphanumeric Characters Only)</label>
							<input type="text" name="question_no" placeholder="Question No" value="<?php echo $sd['json_data']->question_no; ?>" />
							<label>Question / Label</label>
							<input type="text" name="question" placeholder="Enter Your Question" value="<?php echo $sd['json_data']->question; ?>" />
							<?php foreach($languages as $l){?>
							<input type="text" class="lang" name="question_<?php echo $l;?>" placeholder="Enter Your Question in <?php echo $l;?>" value="<?php echo $sd['json_data']->{"question_".$l};?>" />
							<?php } ?>
							<label class="note">Note</label>
							<input type="text" name="question_note" placeholder="Note: " value="<?php echo $sd['json_data']->question_note; ?>" />							
							<label>Upload File</label>
							<input type="file" name="answer_file" />
							<label>Online Url</label>
							<input type="text" name="answer_url" placeholder="Enter Online Url of Image with http://" value="<?php echo $sd['json_data']->answer_url; ?>" />
							<input class="editsave" type="submit" value="Save" />
						<?php }?>
																																																						
				</form>

