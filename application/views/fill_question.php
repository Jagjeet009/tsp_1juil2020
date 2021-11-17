<?php
$sd['json_data']=json_decode($sd['json_data']);
$sd['json_data']->real_question_no = "_".strtolower(preg_replace("/[^A-Za-z0-9]/","",$sd['json_data']->question_no));
$sd['style']=(array) json_decode($sd['style']);
$sd['lengths']=(array) json_decode($sd['lengths']);

$sd['json_data']->question=str_replace('><','> <',$sd['json_data']->question);
if(isset($sd['json_data']->answer)){
	for($i=0;$i<sizeof($sd['json_data']->answer);$i++){
		$sd['json_data']->answer[$i]=str_replace('><','> <',$sd['json_data']->answer[$i]);
	}
}
if(isset($sd['json_data']->columns)){
	for($i=0;$i<sizeof($sd['json_data']->columns);$i++){
		$sd['json_data']->columns[$i]=str_replace('><','> <',$sd['json_data']->columns[$i]);
	}
}
if(isset($sd['json_data']->rows)){
	for($i=0;$i<sizeof($sd['json_data']->rows);$i++){
		$sd['json_data']->rows[$i]=str_replace('><','> <',$sd['json_data']->rows[$i]);
	}
}
if(isset($sd['json_data']->dropdown_choices)){
	for($i=0;$i<sizeof($sd['json_data']->dropdown_choices);$i++){
		for($j=0;$j<sizeof($sd['json_data']->dropdown_choices[$i]);$j++){
			if(isset($sd['json_data']->dropdown_choices[$i][$j])){
				$sd['json_data']->dropdown_choices[$i][$j]=str_replace('><','> <',$sd['json_data']->dropdown_choices[$i][$j]);
			}
		}
	}
}
if(!isset($sd['json_data']->question_note)){
	$sd['json_data']->question_note="";
}
if(!isset($sd['json_data']->question_note)){
	$sd['json_data']->question_note="";
}

$question_style='';
if(isset($sd['style']['question_font_size']) && $sd['style']['question_font_size']!=''){
	$question_style.="font-size:".$sd['style']['question_font_size']."px !important;";
}
if(isset($sd['style']['question_font_color']) && $sd['style']['question_font_color']!=''){
	$question_style.="color:".$sd['style']['question_font_color']." !important;";
}
if(isset($sd['style']['question_background']) && $sd['style']['question_background']!=''){
	$question_style.="background-color:".$sd['style']['question_background']." !important;";
}

if(isset($sd['style']['question_align']) && $sd['style']['question_align']!=''){
	$question_style.="text-align:".$sd['style']['question_align']." !important;";
}
if(isset($sd['style']['question_font_weight']) && $sd['style']['question_font_weight']!=''){
	$question_style.="font-weight:".$sd['style']['question_font_weight']." !important;";
}
if(isset($sd['style']['question_font_style']) && $sd['style']['question_font_style']!=''){
	$question_style.="font-style:".$sd['style']['question_font_style']." !important;";
}
if(isset($sd['style']['question_text_transform']) && $sd['style']['question_text_transform']!=''){
	$question_style.="text-transform:".$sd['style']['question_text_transform']." !important;";
}
if(isset($sd['style']['question_text_decoration']) && $sd['style']['question_text_decoration']!=''){
	$question_style.="text-decoration:".$sd['style']['question_text_decoration']." !important;";
}

if(isset($sd['style']['question_border_color']) && $sd['style']['question_border_color']!=''){
	$question_style.="border-color:".$sd['style']['question_border_color']." !important;";
}
if(isset($sd['style']['question_border_style']) && $sd['style']['question_border_style']!=''){
	$question_style.="border-style:".$sd['style']['question_border_style']." !important;";
}
if(isset($sd['style']['question_border_top']) && $sd['style']['question_border_top']!=''){
	$question_style.="border-top-width:".$sd['style']['question_border_top']."px !important;";
}
if(isset($sd['style']['question_border_right']) && $sd['style']['question_border_right']!=''){
	$question_style.="border-right-width:".$sd['style']['question_border_right']."px !important;";
}
if(isset($sd['style']['question_border_bottom']) && $sd['style']['question_border_bottom']!=''){
	$question_style.="border-bottom-width:".$sd['style']['question_border_bottom']."px !important;";
}
if(isset($sd['style']['question_border_left']) && $sd['style']['question_border_left']!=''){
	$question_style.="border-left-width:".$sd['style']['question_border_left']."px !important;";
}

if(isset($sd['style']['question_margin_top']) && $sd['style']['question_margin_top']!=''){
	$question_style.="margin-top:".$sd['style']['question_margin_top']."px !important;";
}
if(isset($sd['style']['question_margin_right']) && $sd['style']['question_margin_right']!=''){
	$question_style.="margin-right:".$sd['style']['question_margin_right']."px !important;";
}
if(isset($sd['style']['question_margin_bottom']) && $sd['style']['question_margin_bottom']!=''){
	$question_style.="margin-bottom:".$sd['style']['question_margin_bottom']."px !important;";
}
if(isset($sd['style']['question_margin_left']) && $sd['style']['question_margin_left']!=''){
	$question_style.="margin-left:".$sd['style']['question_margin_left']."px !important;";
}
if(isset($sd['style']['question_padding_top']) && $sd['style']['question_padding_top']!=''){
	$question_style.="padding-top:".$sd['style']['question_padding_top']."px !important;";
}
if(isset($sd['style']['question_padding_right']) && $sd['style']['question_padding_right']!=''){
	$question_style.="padding-right:".$sd['style']['question_padding_right']."px !important;";
}
if(isset($sd['style']['question_padding_bottom']) && $sd['style']['question_padding_bottom']!=''){
	$question_style.="padding-bottom:".$sd['style']['question_padding_bottom']."px !important;";
}
if(isset($sd['style']['question_padding_left']) && $sd['style']['question_padding_left']!=''){
	$question_style.="padding-left:".$sd['style']['question_padding_left']."px !important;";
}
//print_r($sd['lengths']);
?>
	<?php if($sd['qtype']=="Multiple Choice Question"){ ?>	
		<li id="<?php echo $sd['id']; ?>" style="<?php echo $question_style; ?>" class="clearfix">
		<label class="question-text clearfix"><span class="question-no"><?php echo $sd['json_data']->question_no; ?></span> <?php echo $sd['json_data']->question; ?></label>
		<label class="question-text clearfix question_note"><span class="question-no">&nbsp;</span> <?php echo $sd['json_data']->question_note; ?></label>
		<?php if(isset($sd['json_data']->multiple_answer) && $sd['json_data']->multiple_answer=='1'){?>
			<?php $i=0;foreach($sd['json_data']->answer as $ans){$i++;
			$ans=explode('|',$ans);
			?>
			<label class="question-detail option">
				<input type="checkbox" <?php if(isset($sd['json_data']->other_specify_box) && $sd['json_data']->other_specify_box=='1' && $i==sizeof($sd['json_data']->answer)){ ?> class="setOther" <?php } ?> data-id="answer<?php echo $sd['json_data']->real_question_no; ?>" name="answer<?php echo $sd['json_data']->real_question_no."_".$ans[0]; ?>" value="<?php echo $ans[0]; ?>" /><span class="option-value">[<?php echo $ans[0]; ?>]</span>  <?php echo $ans[1]; ?>
				<?php if(isset($sd['json_data']->other_specify_box) && $sd['json_data']->other_specify_box=='1' && $i==sizeof($sd['json_data']->answer)){ ?>
					<input class="extratext" maxlength="<?php if(isset($sd['lengths']['length_answer'.$sd['json_data']->real_question_no.'_oth'])){echo $sd['lengths']['length_answer'.$sd['json_data']->real_question_no.'_oth'];}?>" name="answer<?php echo $sd['json_data']->real_question_no;?>_oth" placeholder="Enter Your Answer" type="text" data-format="<?php if(isset($sd['lengths']['format_answer'.$sd['json_data']->real_question_no.'_oth'])){echo $sd['lengths']['format_answer'.$sd['json_data']->real_question_no.'_oth'];}?>" >
				<?php } ?>
			</label>
			<?php } ?>
		<?php }else{?>
			<?php if(isset($sd['json_data']->answer)){ ?>
				<?php $i=0;foreach($sd['json_data']->answer as $ans){$i++;
				$ans=explode('|',$ans);
				?>
				<label class="question-detail option">
					<input type="radio" <?php if(isset($sd['json_data']->other_specify_box) && $sd['json_data']->other_specify_box=='1' && $i==sizeof($sd['json_data']->answer)){ ?>  class="setOther" <?php } ?> name="answer<?php echo $sd['json_data']->real_question_no; ?>" value="<?php echo $ans[0]; ?>" /><span class="option-value">[<?php echo $ans[0]; ?>]</span> <?php echo $ans[1]; ?>
					<?php if(isset($sd['json_data']->other_specify_box) && $sd['json_data']->other_specify_box=='1' && $i==sizeof($sd['json_data']->answer)){ ?>
						<input class="extratext" maxlength="<?php if(isset($sd['lengths']['length_answer'.$sd['json_data']->real_question_no.'_oth'])){echo $sd['lengths']['length_answer'.$sd['json_data']->real_question_no.'_oth'];}?>" name="answer<?php echo $sd['json_data']->real_question_no;?>_oth" placeholder="Enter Your Answer" type="text"  data-format="<?php if(isset($sd['lengths']['format_answer'.$sd['json_data']->real_question_no.'_oth'])){echo $sd['lengths']['format_answer'.$sd['json_data']->real_question_no.'_oth'];}?>" >
					<?php } ?>
				</label>
				<?php } ?>
			<?php } ?>
		<?php } ?>
		</li>				
	<?php }?>	
	<?php if($sd['qtype']=="Dropdown Question"){ ?>		
		<li id="<?php echo $sd['id']; ?>" style="<?php echo $question_style; ?>" class="clearfix">
		<label class="question-text clearfix"><span class="question-no"><?php echo $sd['json_data']->question_no; ?></span> <?php echo $sd['json_data']->question; ?></label>
		<label class="question-text clearfix question_note"><span class="question-no">&nbsp;</span> <?php echo $sd['json_data']->question_note; ?></label>
		<label class="question-detail option">
			<select name="answer<?php echo $sd['json_data']->real_question_no; ?>" <?php if(isset($sd['json_data']->other_specify_box) && $sd['json_data']->other_specify_box=='1'){echo 'class="setOther"';} ?>>
			<option value="">Select</option>
			<?php foreach($sd['json_data']->answer as $ans){
			if($ans!=''){
				$ans=explode('|',$ans);
			?>
				<option data-lang="<?php echo $ans[1]; ?>" value="<?php echo $ans[0]; ?>"><?php echo $ans[1]; ?></option>
			<?php }} ?>
			</select>
			<?php if(isset($sd['json_data']->other_specify_box) && $sd['json_data']->other_specify_box=='1'){ ?>
				<input class="extratext" maxlength="<?php if(isset($sd['lengths']['length_answer'.$sd['json_data']->real_question_no.'_oth'])){echo $sd['lengths']['length_answer'.$sd['json_data']->real_question_no.'_oth'];}?>" name="answer<?php echo $sd['json_data']->real_question_no;?>_oth" placeholder="Enter Your Answer" type="text" data-format="<?php if(isset($sd['lengths']['format_answer'.$sd['json_data']->real_question_no.'_oth'])){echo $sd['lengths']['format_answer'.$sd['json_data']->real_question_no.'_oth'];}?>" >
			<?php } ?>			
		</label>	
		</li>				
	<?php }?>	
	<?php if($sd['qtype']=="Dropdown Matrix Question"){ ?>
		<li id="<?php echo $sd['id']; ?>" style="<?php echo $question_style; ?>" class="clearfix DDM">
		<label class="question-text clearfix"><span class="question-no"><?php echo $sd['json_data']->question_no; ?></span> <?php echo $sd['json_data']->question; ?></label>
		<label class="question-text clearfix question_note"><span class="question-no">&nbsp;</span> <?php echo $sd['json_data']->question_note; ?></label>
		<label class="question-detail question-answer-text answer">
			<div class="table-wrapper">
			<table class="fixTable table" border="0" cellpadding="5">
			<thead>
				<tr>
					<th></th>
					<?php foreach($sd['json_data']->columns as $jdc){ ?>
					<th><?php echo $jdc; ?></th>
					<?php } ?>
				</tr>									
			</thead>
			<?php for($i=0;$i<sizeof($sd['json_data']->rows);$i++){ ?>
			<tr>
				<?php
				foreach($survey as $s){
					$languages=array('English');
					if(isset($_COOKIE['fill_survey'])){
						if($s['title_url']==$_COOKIE['fill_survey']){
							$l=(array) json_decode($s['languages']);
							foreach($l as $ll){
								array_push($languages,$ll);
							}
						}
					}
				}
				foreach($languages as $l){
					$matches='';
					preg_match("#<".$l.">(.*?)</".$l.">#", trim($sd['json_data']->rows[$i]), $matches);
					if(sizeof($matches)>0){
						$matches[1]=trim($matches[1]);
						if(empty($matches[1])){
							$sd['json_data']->rows[$i]=trim($sd['json_data']->rows[$i]);
							$sd['json_data']->rows[$i]=str_replace("<".$l."> </".$l.">","",$sd['json_data']->rows[$i]);
							$sd['json_data']->rows[$i]=trim($sd['json_data']->rows[$i]);
						}
					}
				}
				?>								
				<th><?php if(trim($sd['json_data']->rows[$i])!=''){echo $sd['json_data']->rows[$i];} ?></th>
				<?php for($j=0;$j<sizeof($sd['json_data']->columns);$j++){ ?>
				<td>
				<?php
				if(isset($sd['json_data']->type)){
				if($sd['json_data']->type[$j]=="Select"){
					if($sd['json_data']->dropdown_choices[$j]!=''){
					?>
					<label class="option">
						<select name="answer<?php echo $sd['json_data']->real_question_no; ?>_<?php echo $i.'$'.$j;?>" <?php if(isset($sd['json_data']->type_other[$j]) && $sd['json_data']->type_other[$j]=='1'){ ?> class="setOther" <?php } ?>>
						<option value="">Select</option>
						<?php 
						$dropdown_choices=$sd['json_data']->dropdown_choices[$j];
						//$dropdown_choices=explode(PHP_EOL,$sd['json_data']->dropdown_choices[$j]);
						$k=0;foreach($dropdown_choices as $dc){$k++;
						$dc=explode('|',$dc);
						?>
						<option data-lang="<?php echo $dc[1]; ?>" value="<?php echo $dc[0]; ?>">[<?php echo $dc[0]; ?>] <?php echo $dc[1]; ?></option>											
						<?php }?>
						</select>
						<?php if(isset($sd['json_data']->type_other[$j]) && $sd['json_data']->type_other[$j]=='1' && $k==sizeof($dropdown_choices)){ ?>
							<input class="extratext" maxlength="<?php if(isset($sd['lengths']['length_answer'.$sd['json_data']->real_question_no."_".$i.'$'.$j."_oth"])){echo $sd['lengths']['length_answer'.$sd['json_data']->real_question_no."_".$i.'$'.$j."_oth"];}?>" name="answer<?php echo $sd['json_data']->real_question_no."_".$i.'$'.$j;?>_oth" placeholder="Enter Your Answer" type="text"  data-format="<?php if(isset($sd['lengths']['format_answer'.$sd['json_data']->real_question_no."_".$i.'$'.$j."_oth"])){echo $sd['lengths']['format_answer'.$sd['json_data']->real_question_no."_".$i.'$'.$j."_oth"];}?>">											
						<?php } ?>
					</label>
					<?php }										
				}else if($sd['json_data']->type[$j]=="Checkbox"){
					if($sd['json_data']->dropdown_choices[$j]!=''){
						$dropdown_choices=$sd['json_data']->dropdown_choices[$j];
						//$dropdown_choices=explode(PHP_EOL,$sd['json_data']->dropdown_choices[$j]);
						$k=0;foreach($dropdown_choices as $dc){$k++;
						$dc=explode('|',$dc);
						?>
						<label class="option">
							<input type="checkbox" <?php if(isset($sd['json_data']->type_other[$j]) && $sd['json_data']->type_other[$j]=='1' && $k==sizeof($dropdown_choices)){ ?> class="setOther" <?php } ?>  data-id="answer<?php echo $sd['json_data']->real_question_no."_".$i.'$'.$j; ?>"  name="answer<?php echo $sd['json_data']->real_question_no."_".$i.'$'.$j."_".$dc[0]; ?>" value="<?php echo $dc[0]; ?>" /><span class="option-value">[<?php echo $dc[0]; ?>]</span>  <?php echo $dc[1]; ?>
							<?php if(isset($sd['json_data']->type_other[$j]) && $sd['json_data']->type_other[$j]=='1' && $k==sizeof($dropdown_choices)){ ?>
								<input class="extratext" maxlength="<?php if(isset($sd['lengths']['length_answer'.$sd['json_data']->real_question_no."_".$i.'$'.$j."_oth"])){echo $sd['lengths']['length_answer'.$sd['json_data']->real_question_no."_".$i.'$'.$j."_oth"];}?>" name="answer<?php echo $sd['json_data']->real_question_no."_".$i.'$'.$j;?>_oth" placeholder="Enter Your Answer" type="text" data-format="<?php if(isset($sd['lengths']['format_answer'.$sd['json_data']->real_question_no."_".$i.'$'.$j."_oth"])){echo $sd['lengths']['format_answer'.$sd['json_data']->real_question_no."_".$i.'$'.$j."_oth"];}?>">											
							<?php } ?>
						</label>
						<?php }?>
					<?php }													
				}else if($sd['json_data']->type[$j]=="Radio"){
					if($sd['json_data']->dropdown_choices[$j]!=''){
						$dropdown_choices=$sd['json_data']->dropdown_choices[$j];
						//$dropdown_choices=explode(PHP_EOL,$sd['json_data']->dropdown_choices[$j]);
						$k=0;foreach($dropdown_choices as $dc){$k++;
						$dc=explode('|',$dc);
						?>
						<label class="option">
							<input type="radio" <?php if(isset($sd['json_data']->type_other[$j]) && $sd['json_data']->type_other[$j]=='1' && $k==sizeof($dropdown_choices)){ ?> class="setOther" <?php } ?> name="answer<?php echo $sd['json_data']->real_question_no."_".$i.'$'.$j; ?>" value="<?php echo $dc[0]; ?>" /><span class="option-value">[<?php echo $dc[0]; ?>]</span>  <?php echo $dc[1]; ?>
							<?php if(isset($sd['json_data']->type_other[$j]) && $sd['json_data']->type_other[$j]=='1' && $k==sizeof($dropdown_choices)){ ?>
								<input class="extratext" maxlength="<?php if(isset($sd['lengths']['length_answer'.$sd['json_data']->real_question_no."_".$i.'$'.$j."_oth"])){echo $sd['lengths']['length_answer'.$sd['json_data']->real_question_no."_".$i.'$'.$j."_oth"];}?>" name="answer<?php echo $sd['json_data']->real_question_no."_".$i.'$'.$j;?>_oth" placeholder="Enter Your Answer" type="text" data-format="<?php if(isset($sd['lengths']['format_answer'.$sd['json_data']->real_question_no."_".$i.'$'.$j."_oth"])){echo $sd['lengths']['format_answer'.$sd['json_data']->real_question_no."_".$i.'$'.$j."_oth"];}?>">											
							<?php } ?>
						</label>
						<?php }?>
					<?php }													
				}else if($sd['json_data']->type[$j]=="Date"){
					/*echo $j;
					$count_date=$sd['json_data']->type;
					$count_date=array_count_values($count_date);
					print_r($count_date);
					//print_r($count_date['Date']);
					$count_j=0;
					if($count_date['Date']==1){
						$count_j=$j;
					}else if($count_date['Date']>1){
						$count_j=$j-1;
					}else{}		
					echo $count_j;*/
					?>
					<?php if(isset($sd['json_data']->answer_dd[$j]) && $sd['json_data']->answer_dd[$j]=="dd"){?>
					<input class="option_dd" type="text" maxlength="<?php if(isset($sd['lengths']['length_answer_dd'.$sd['json_data']->real_question_no."_".$i.'$'.$j])){echo $sd['lengths']['length_answer_dd'.$sd['json_data']->real_question_no."_".$i.'$'.$j];}?>"  name="answer_dd<?php echo $sd['json_data']->real_question_no."_".$i.'$'.$j; ?>" placeholder="DD" data-format="<?php if(isset($sd['lengths']['format_answer_dd'.$sd['json_data']->real_question_no."_".$i.'$'.$j])){echo $sd['lengths']['format_answer_dd'.$sd['json_data']->real_question_no."_".$i.'$'.$j];}?>"   />
					<?php } ?>
					<?php if(isset($sd['json_data']->answer_mm[$j]) && $sd['json_data']->answer_mm[$j]=="mm"){?>
					<input class="option_mm" type="text" maxlength="<?php if(isset($sd['lengths']['length_answer_mm'.$sd['json_data']->real_question_no."_".$i.'$'.$j])){echo $sd['lengths']['length_answer_mm'.$sd['json_data']->real_question_no."_".$i.'$'.$j];}?>"  name="answer_mm<?php echo $sd['json_data']->real_question_no."_".$i.'$'.$j; ?>" placeholder="MM" data-format="<?php if(isset($sd['lengths']['format_answer_mm'.$sd['json_data']->real_question_no."_".$i.'$'.$j])){echo $sd['lengths']['format_answer_mm'.$sd['json_data']->real_question_no."_".$i.'$'.$j];}?>"   />
					<?php } ?>
					<?php if(isset($sd['json_data']->answer_yyyy[$j]) && $sd['json_data']->answer_yyyy[$j]=="yyyy"){?>
					<input class="option_yyyy" type="text" maxlength="<?php if(isset($sd['lengths']['length_answer_yyyy'.$sd['json_data']->real_question_no."_".$i.'$'.$j])){echo $sd['lengths']['length_answer_yyyy'.$sd['json_data']->real_question_no."_".$i.'$'.$j];}?>"  name="answer_yyyy<?php echo $sd['json_data']->real_question_no."_".$i.'$'.$j; ?>" placeholder="YYYY" data-format="<?php if(isset($sd['lengths']['format_answer_yyyy'.$sd['json_data']->real_question_no."_".$i.'$'.$j])){echo $sd['lengths']['format_answer_yyyy'.$sd['json_data']->real_question_no."_".$i.'$'.$j];}?>"   />
					<?php } ?>
					<?php if(isset($sd['json_data']->answer_h[$j]) && $sd['json_data']->answer_h[$j]=="h"){?>
					<input class="option_h" type="text" maxlength="<?php if(isset($sd['lengths']['length_answer_h'.$sd['json_data']->real_question_no."_".$i.'$'.$j])){echo $sd['lengths']['length_answer_h'.$sd['json_data']->real_question_no."_".$i.'$'.$j];}?>"  name="answer_h<?php echo $sd['json_data']->real_question_no."_".$i.'$'.$j; ?>" placeholder="H" data-format="<?php if(isset($sd['lengths']['format_answer_h'.$sd['json_data']->real_question_no."_".$i.'$'.$j])){echo $sd['lengths']['format_answer_h'.$sd['json_data']->real_question_no."_".$i.'$'.$j];}?>"   />
					<?php } ?>
					<?php if(isset($sd['json_data']->answer_m[$j]) && $sd['json_data']->answer_m[$j]=="m"){?>
					<input class="option_m" type="text" maxlength="<?php if(isset($sd['lengths']['length_answer_m'.$sd['json_data']->real_question_no."_".$i.'$'.$j])){echo $sd['lengths']['length_answer_m'.$sd['json_data']->real_question_no."_".$i.'$'.$j];}?>"  name="answer_m<?php echo $sd['json_data']->real_question_no."_".$i.'$'.$j; ?>" placeholder="M" data-format="<?php if(isset($sd['lengths']['format_answer_m'.$sd['json_data']->real_question_no."_".$i.'$'.$j])){echo $sd['lengths']['format_answer_m'.$sd['json_data']->real_question_no."_".$i.'$'.$j];}?>"   />
					<?php } ?>
					<?php
				}else{?>
					<input type="text" maxlength="<?php if(isset($sd['lengths']['length_answer'.$sd['json_data']->real_question_no."_".$i.'$'.$j])){echo $sd['lengths']['length_answer'.$sd['json_data']->real_question_no."_".$i.'$'.$j];}?>" name="answer<?php echo $sd['json_data']->real_question_no."_".$i.'$'.$j;?>" placeholder="Enter Your Answer" data-format="<?php if(isset($sd['lengths']['format_answer'.$sd['json_data']->real_question_no."_".$i.'$'.$j])){echo $sd['lengths']['format_answer'.$sd['json_data']->real_question_no."_".$i.'$'.$j];}?>" />										
				<?php } ?>
				</td>
				<?php }}?>
			</tr>
			<?php } ?>
		</table>
			</div>
		</label>
		</li>
	<?php }?>	
	<?php if($sd['qtype']=="File Upload"){ ?>		
		<li id="<?php echo $sd['id']; ?>" style="<?php echo $question_style; ?>" class="clearfix">
		<label class="question-text clearfix"><span class="question-no"><?php echo $sd['json_data']->question_no; ?></span> <?php echo $sd['json_data']->question; ?></label>
		<label class="question-text clearfix question_note"><span class="question-no">&nbsp;</span> <?php echo $sd['json_data']->question_note; ?></label>
		<label class="question-detail option">
			<input type="file" name="answer<?php echo $sd['json_data']->real_question_no; ?>" accept="<?php echo ".".implode(',.',$sd['json_data']->aft); ?>" />
		</label>
		<h6>
			<label class="question-detail option"><?php echo $sd['json_data']->instructions_for_respondent; ?></label>
		</h6>
		</li>
	<?php }?>	
	<?php if($sd['qtype']=="Ranking"){ ?>					
		<li id="<?php echo $sd['id']; ?>" style="<?php echo $question_style; ?>" class="clearfix">
		<label class="question-text clearfix"><span class="question-no"><?php echo $sd['json_data']->question_no; ?></span> <?php echo $sd['json_data']->question; ?></label>
		<label class="question-text clearfix question_note"><span class="question-no">&nbsp;</span> <?php echo $sd['json_data']->question_note; ?></label>
		<?php foreach($sd['json_data']->answer as $ans){
		$ans=explode('|',$ans);
		?>
		<label class="question-detail option">
			<input type="radio" name="answer<?php echo $sd['json_data']->real_question_no; ?>" value="<?php echo $ans[0]; ?>" /><span class="option-value">[<?php echo $ans[0]; ?>]</span> <?php echo $ans[1]; ?>
		</label>
		<?php } ?>
		</li>
	<?php }?>	
	<?php if($sd['qtype']=="Textbox"){ ?>					
		<li id="<?php echo $sd['id']; ?>" style="<?php echo $question_style; ?>" class="clearfix">
		<label class="question-text clearfix"><span class="question-no"><?php echo $sd['json_data']->question_no; ?></span> <?php echo $sd['json_data']->question; ?></label>
		<label class="question-text clearfix question_note"><span class="question-no">&nbsp;</span> <?php echo $sd['json_data']->question_note; ?></label>
		<label class="question-detail option">
			<input type="text" maxlength="<?php if(isset($sd['lengths']['length_answer'.$sd['json_data']->real_question_no])){echo $sd['lengths']['length_answer'.$sd['json_data']->real_question_no];}?>" name="answer<?php echo $sd['json_data']->real_question_no; ?>" placeholder="Enter Your Answer" data-format="<?php if(isset($sd['lengths']['format_answer'.$sd['json_data']->real_question_no])){echo $sd['lengths']['format_answer'.$sd['json_data']->real_question_no];}?>" />
		</label>
		</li>
	<?php }?>	
	<?php if($sd['qtype']=="Multiple Textbox"){ ?>					
		<li id="<?php echo $sd['id']; ?>" style="<?php echo $question_style; ?>" class="clearfix">
		<label class="question-text clearfix"><span class="question-no"><?php echo $sd['json_data']->question_no; ?></span> <?php echo $sd['json_data']->question; ?></label>
		<label class="question-text clearfix question_note"><span class="question-no">&nbsp;</span> <?php echo $sd['json_data']->question_note; ?></label>
		<label class="question-detail question-answer-text answer">
			<table cellpadding="5">
			<?php for($i=0;$i<sizeof($sd['json_data']->rows);$i++){ ?>
			<tr>
				<td><?php echo $sd['json_data']->rows[$i]; ?></td>
				<td>
					<input type="text" maxlength="<?php if(isset($sd['lengths']['length_answer'.$sd['json_data']->real_question_no.'_'.$i])){echo $sd['lengths']['length_answer'.$sd['json_data']->real_question_no.'_'.$i];}?>" name="answer<?php echo $sd['json_data']->real_question_no."_".$i; ?>" placeholder="Enter Your Answer" data-format="<?php if(isset($sd['lengths']['format_answer'.$sd['json_data']->real_question_no.'_'.$i])){echo $sd['lengths']['format_answer'.$sd['json_data']->real_question_no.'_'.$i];}?>"  />
				</td>
			</tr>
			<?php } ?>
			</table>
		</label>
		</li>
	<?php }?>	
	<?php if($sd['qtype']=="Textbox Matrix Question"){ ?>
		<li id="<?php echo $sd['id']; ?>" style="<?php echo $question_style; ?>" class="clearfix TBM">
		<label class="question-text clearfix"><span class="question-no"><?php echo $sd['json_data']->question_no; ?></span> <?php echo $sd['json_data']->question; ?></label>
		<label class="question-text clearfix question_note"><span class="question-no">&nbsp;</span> <?php echo $sd['json_data']->question_note; ?></label>
		<label class="question-detail question-answer-text answer">
			<div class="table-wrapper">
				<table class="fixTable table" border="0" cellpadding="5">
				<tr>
					<th></th>
					<?php foreach($sd['json_data']->columns as $jdc){ ?>
					<th><?php echo $jdc; ?></th>
					<?php } ?>
				</tr>
				<?php for($i=0;$i<sizeof($sd['json_data']->rows);$i++){ ?>
				<tr>
					<td><?php echo $sd['json_data']->rows[$i]; ?></td>
					<?php for($j=0;$j<sizeof($sd['json_data']->columns);$j++){ ?>
					<td>
						<input type="text" maxlength="<?php if(isset($sd['lengths']['length_answer'.$sd['json_data']->real_question_no.'_'.$i.'$'.$j])){echo $sd['lengths']['length_answer'.$sd['json_data']->real_question_no.'_'.$i.'$'.$j];}?>" name="answer<?php echo $sd['json_data']->real_question_no; ?>_<?php echo $i.'$'.$j; ?>" placeholder="Enter Your Answer" data-format="<?php if(isset($sd['lengths']['format_answer'.$sd['json_data']->real_question_no.'_'.$i.'$'.$j])){echo $sd['lengths']['format_answer'.$sd['json_data']->real_question_no.'_'.$i.'$'.$j];}?>"  />
					</td>
					<?php }?>
				</tr>
				<?php } ?>
				</table>
			</div>
		</label>
		</li>
	<?php }?>	
	<?php if($sd['qtype']=="Date/Time"){ ?>					
		<li id="<?php echo $sd['id']; ?>" style="<?php echo $question_style; ?>" class="clearfix">
		<label class="question-text clearfix"><span class="question-no"><?php echo $sd['json_data']->question_no; ?></span> <?php echo $sd['json_data']->question; ?></label>
		<label class="question-text clearfix question_note"><span class="question-no">&nbsp;</span> <?php echo $sd['json_data']->question_note; ?></label>
		<label class="question-detail">
			<table cellpadding="5">
			<tr>
			<?php if(in_array("dd",(array) $sd['json_data']->answer)){ ?>
				<td><input class="option_dd" type="text" maxlength="<?php if(isset($sd['lengths']['length_answer_dd'.$sd['json_data']->real_question_no])){echo $sd['lengths']['length_answer_dd'.$sd['json_data']->real_question_no];}?>" name="answer_dd<?php echo $sd['json_data']->real_question_no; ?>" placeholder="DD" data-format="<?php if(isset($sd['lengths']['format_answer_dd'.$sd['json_data']->real_question_no])){echo $sd['lengths']['format_answer_dd'.$sd['json_data']->real_question_no];}?>"  /></td>
				<td>&nbsp;/&nbsp;</td>
			<?php } ?>
			<?php if(in_array("mm",(array) $sd['json_data']->answer)){ ?>
				<td><input class="option_mm" type="text" maxlength="<?php if(isset($sd['lengths']['length_answer_mm'.$sd['json_data']->real_question_no])){echo $sd['lengths']['length_answer_mm'.$sd['json_data']->real_question_no];}?>" name="answer_mm<?php echo $sd['json_data']->real_question_no; ?>" placeholder="MM" data-format="<?php if(isset($sd['lengths']['format_answer_mm'.$sd['json_data']->real_question_no])){echo $sd['lengths']['format_answer_mm'.$sd['json_data']->real_question_no];}?>"  /></td>
				<td>&nbsp;/&nbsp;</td>
			<?php } ?>
			<?php if(in_array("yyyy",(array) $sd['json_data']->answer)){ ?>
				<td><input class="option_yyyy" type="text" maxlength="<?php if(isset($sd['lengths']['length_answer_yyyy'.$sd['json_data']->real_question_no])){echo $sd['lengths']['length_answer_yyyy'.$sd['json_data']->real_question_no];}?>" name="answer_yyyy<?php echo $sd['json_data']->real_question_no; ?>" placeholder="YYYY" data-format="<?php if(isset($sd['lengths']['format_answer_yyyy'.$sd['json_data']->real_question_no])){echo $sd['lengths']['format_answer_yyyy'.$sd['json_data']->real_question_no];}?>"  /></td>
				<td>&nbsp;&nbsp;&nbsp;</td>
			<?php } ?>
			<?php if(in_array("h",(array) $sd['json_data']->answer)){ ?>
				<td><input class="option_h" type="text" maxlength="<?php if(isset($sd['lengths']['length_answer_h'.$sd['json_data']->real_question_no])){echo $sd['lengths']['length_answer_h'.$sd['json_data']->real_question_no];}?>" name="answer_h<?php echo $sd['json_data']->real_question_no; ?>" placeholder="H" data-format="<?php if(isset($sd['lengths']['format_answer_h'.$sd['json_data']->real_question_no])){echo $sd['lengths']['format_answer_h'.$sd['json_data']->real_question_no];}?>"  /></td>
				<td>&nbsp;-&nbsp;</td>
			<?php } ?>
			<?php if(in_array("m",(array) $sd['json_data']->answer)){ ?>
				<td><input class="option_m" type="text" maxlength="<?php if(isset($sd['lengths']['length_answer_m'.$sd['json_data']->real_question_no])){echo $sd['lengths']['length_answer_m'.$sd['json_data']->real_question_no];}?>" name="answer_m<?php echo $sd['json_data']->real_question_no; ?>" placeholder="M" data-format="<?php if(isset($sd['lengths']['format_answer_m'.$sd['json_data']->real_question_no])){echo $sd['lengths']['format_answer_m'.$sd['json_data']->real_question_no];}?>"  /></td>
			<?php } ?>
			</tr>
		</table>
		</label>
		</li>
	<?php }?>	
	<?php if($sd['qtype']=="Textarea"){ ?>					
		<li id="<?php echo $sd['id']; ?>" style="<?php echo $question_style; ?>" class="clearfix">
		<label class="question-text clearfix"><span class="question-no"><?php echo $sd['json_data']->question_no; ?></span> <?php echo $sd['json_data']->question; ?></label>
		<label class="question-text clearfix question_note"><span class="question-no">&nbsp;</span> <?php echo $sd['json_data']->question_note; ?></label>
		<label class="question-detail option">
			<textarea name="answer<?php echo $sd['json_data']->real_question_no; ?>" placeholder="Enter Your Answer"  maxlength="<?php if(isset($sd['lengths']['length_answer'.$sd['json_data']->real_question_no])){echo $sd['lengths']['length_answer'.$sd['json_data']->real_question_no];}?>" ></textarea>
		</label>
		</li>
	<?php }?>	
	<?php if($sd['qtype']=="Static Image"){ ?>					
		<li id="<?php echo $sd['id']; ?>" style="<?php echo $question_style; ?>" class="clearfix">
		<label class="question-text clearfix"><span class="question-no"><?php echo $sd['json_data']->question_no; ?></span> <?php echo $sd['json_data']->question; ?></label>
		<label class="question-text clearfix question_note"><span class="question-no">&nbsp;</span> <?php echo $sd['json_data']->question_note; ?></label>
		<?php if(isset($sd['json_data']->answer_file) && $sd['json_data']->answer_file!=''){?>
			<img src="<?php echo $sd['json_data']->answer_file; ?>" />
		<?php }else{ ?>
			<img src="<?php echo $sd['json_data']->answer_url; ?>" />
		<?php } ?>
		</li>
	<?php }?>	
