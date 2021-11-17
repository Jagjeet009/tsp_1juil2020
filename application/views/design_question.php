<?php
//print_r($sd['json_data']);
$sd['json_data']=json_decode($sd['json_data']);
//print_r($sd['json_data']);
$sd['json_data']->real_question_no = "_".strtolower(preg_replace("/[^A-Za-z0-9]/","",$sd['json_data']->question_no));
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
//print_r($sd['json_data']);
?>
    <?php if($sd['qtype']=="Multiple Choice Question"){ ?>	
        <input type="hidden" name="" class="duplicate_question_check" value="<?php echo $sd['json_data']->question_no; ?>" />
        <label><?php echo $sd['json_data']->question_no; ?> <?php echo $sd['json_data']->question; ?></label>
				<label class="question_note"><?php echo $sd['json_data']->question_note; ?></label>
        <span class="answer">
			<?php if(isset($sd['json_data']->multiple_answer) && $sd['json_data']->multiple_answer=='1'){?>
                <?php $i=0;foreach($sd['json_data']->answer as $ans){$i++;
                $ans=explode('|',$ans);
                ?>
                <label>
                    <input type="checkbox" <?php if(isset($sd['json_data']->other_specify_box) && $sd['json_data']->other_specify_box=='1' && $i==sizeof($sd['json_data']->answer)){ ?> class="setOther" <?php } ?> name="answer<?php echo $sd['json_data']->real_question_no."_".$ans[0]; ?>" value="<?php echo $ans[0]; ?>" />[<?php echo $ans[0]; ?>]  <?php echo $ans[1]; ?>
                    <?php if(isset($sd['json_data']->other_specify_box) && $sd['json_data']->other_specify_box=='1' && $i==sizeof($sd['json_data']->answer)){ ?>
                        <input class="extratext" name="answer<?php echo $sd['json_data']->real_question_no;?>_oth" placeholder="Enter Your Answer" type="text">
                    <?php } ?>
                </label>
                <?php } ?>
            <?php }else{?>
                <?php $i=0;foreach($sd['json_data']->answer as $ans){$i++;
                $ans=explode('|',$ans);
                ?>
                <label>
                    <input type="radio" <?php if(isset($sd['json_data']->other_specify_box) && $sd['json_data']->other_specify_box=='1' && $i==sizeof($sd['json_data']->answer)){ ?>  class="setOther" <?php } ?> name="answer<?php echo $sd['json_data']->real_question_no; ?>" value="<?php echo $ans[0]; ?>" />[<?php echo $ans[0]; ?>] <?php echo $ans[1]; ?>
                    <?php if(isset($sd['json_data']->other_specify_box) && $sd['json_data']->other_specify_box=='1' && $i==sizeof($sd['json_data']->answer)){ ?>
                        <input class="extratext" name="answer<?php echo $sd['json_data']->real_question_no;?>_oth" placeholder="Enter Your Answer" type="text">
                    <?php } ?>
                </label>
                <?php } ?>
            <?php } ?>
		</span>
    <?php }?>	
    <?php if($sd['qtype']=="Dropdown Question"){ ?>		
        <input type="hidden" name="" class="duplicate_question_check" value="<?php echo $sd['json_data']->question_no; ?>" />
        <label><?php echo $sd['json_data']->question_no; ?> <?php echo $sd['json_data']->question; ?></label>
		<label class="question_note"><?php echo $sd['json_data']->question_note; ?></label>
        <span class="answer">
        	<label>
                <select name="answer<?php echo $sd['json_data']->real_question_no; ?>" <?php if(isset($sd['json_data']->other_specify_box) && $sd['json_data']->other_specify_box=='1'){echo 'class="setOther"';} ?>>
                <option value="">Select</option>
                <?php foreach($sd['json_data']->answer as $ans){
                if($ans!=''){
                    $ans=explode('|',$ans);
                ?>
                    <option value="<?php echo $ans[0]; ?>">[<?php echo $ans[0]; ?>] <?php echo $ans[1]; ?></option>
                <?php }} ?>
                </select>
				<?php if(isset($sd['json_data']->other_specify_box) && $sd['json_data']->other_specify_box=='1'){ ?>
					<input class="extratext" name="answer<?php echo $sd['json_data']->real_question_no;?>_oth" placeholder="Enter Your Answer" type="text">
				<?php } ?>                
        	</label>
        </span>            
    <?php }?>	
    <?php if($sd['qtype']=="Dropdown Matrix Question"){ ?>
        <input type="hidden" name="" class="duplicate_question_check" value="<?php echo $sd['json_data']->question_no; ?>" />
        <label><?php echo $sd['json_data']->question_no; ?> <?php echo $sd['json_data']->question; ?></label>
		<label class="question_note"><?php echo $sd['json_data']->question_note; ?></label>
        <span class="answer">        
        	<div class="table-wrapper">
	        <table class="fixTable table" border="0">
            <tr>
                <th></th>
                <?php foreach($sd['json_data']->columns as $jdc){ ?>
                <th><?php echo $jdc; ?></th>
                <?php } ?>
            </tr>
            <?php for($i=0;$i<sizeof($sd['json_data']->rows);$i++){ ?>
            <tr>
				<?php
				foreach($survey as $s){
					$languages=array('English');
					if($s['title_url']==$_COOKIE['design_survey']){
						$l=(array) json_decode($s['languages']);
						foreach($l as $ll){
							array_push($languages,$ll);
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
                if($sd['json_data']->type[$j]=="Select"){
					if($sd['json_data']->dropdown_choices[$j]!=''){
                    ?>
						<label class="option">
                        <select name="answer<?php echo $sd['json_data']->real_question_no; ?>_<?php echo $i.'$'.$j;?>" <?php if(isset($sd['json_data']->type_other[$j]) && $sd['json_data']->type_other[$j]=='1'){ ?> class="setOther" <?php } ?>>
                        <?php 
                    	$dropdown_choices=$sd['json_data']->dropdown_choices[$j];
                        $k=0;foreach($dropdown_choices as $dc){$k++;
                        $dc=explode('|',$dc);
                        ?>
                        <option value="<?php echo $dc[0]; ?>">[<?php echo $dc[0]; ?>] <?php echo $dc[1]; ?></option>											
                        <?php }?>
                        </select>
						<?php if(isset($sd['json_data']->type_other[$j]) && $sd['json_data']->type_other[$j]=='1' && $k==sizeof($dropdown_choices)){ ?>
							<input class="extratext" name="answer<?php echo $sd['json_data']->real_question_no."_".$i.'$'.$j;?>_oth" placeholder="Enter Your Answer" type="text">											
						<?php } ?>  
                   		</label>
                    <?php }										
                }else if($sd['json_data']->type[$j]=="Checkbox"){
                    if($sd['json_data']->dropdown_choices[$j]!=''){
                    	$dropdown_choices=$sd['json_data']->dropdown_choices[$j];
                        $k=0;foreach($dropdown_choices as $dc){$k++;
                        $dc=explode('|',$dc);
                        ?>
                        <label>
                            <input type="checkbox" <?php if(isset($sd['json_data']->type_other[$j]) && $sd['json_data']->type_other[$j]=='1' && $k==sizeof($dropdown_choices)){ ?> class="setOther" <?php } ?> name="answer<?php echo $sd['json_data']->real_question_no."_".$i.'$'.$j."_".$dc[0]; ?>" value="<?php echo $dc[0]; ?>" />[<?php echo $dc[0]; ?>]  <?php echo $dc[1]; ?>
                            <?php if(isset($sd['json_data']->type_other[$j]) && $sd['json_data']->type_other[$j]=='1' && $k==sizeof($dropdown_choices)){ ?>
                                <input class="extratext" name="answer<?php echo $sd['json_data']->real_question_no."_".$i.'$'.$j;?>_oth" placeholder="Enter Your Answer" type="text">											
                            <?php } ?>
                        </label>
                        <?php }?>
                    <?php }													
                }else if($sd['json_data']->type[$j]=="Radio"){
                    if($sd['json_data']->dropdown_choices[$j]!=''){
						$dropdown_choices=$sd['json_data']->dropdown_choices[$j];
                        $k=0;foreach($dropdown_choices as $dc){$k++;
                        $dc=explode('|',$dc);
                        ?>
                        <label>
                            <input type="radio" <?php if(isset($sd['json_data']->type_other[$j]) && $sd['json_data']->type_other[$j]=='1' && $k==sizeof($dropdown_choices)){ ?> class="setOther" <?php } ?> name="answer<?php echo $sd['json_data']->real_question_no."_".$i.'$'.$j; ?>" value="<?php echo $dc[0]; ?>" />[<?php echo $dc[0]; ?>]  <?php echo $dc[1]; ?>
                            <?php if(isset($sd['json_data']->type_other[$j]) && $sd['json_data']->type_other[$j]=='1' && $k==sizeof($dropdown_choices)){ ?>
                                <input class="extratext" name="answer<?php echo $sd['json_data']->real_question_no."_".$i.'$'.$j;?>_oth" placeholder="Enter Your Answer" type="text">											
                            <?php } ?>
                        </label>
                        <?php }?>
                    <?php }													
                }else if($sd['json_data']->type[$j]=="Date"){
					$count_date=$sd['json_data']->type;
					$count_date=array_count_values($count_date);
					//print_r($count_date['Date']);
					$count_j=0;
					if($count_date['Date']==1){
						$count_j=$j;
					}else if($count_date['Date']>1){
						$count_j=$j-1;
					}else{}
                    ?>
                    <?php if(isset($sd['json_data']->answer_dd[$j]) && $sd['json_data']->answer_dd[$j]!=''){?>
                    <input class="answer_dd" type="text" name="answer_dd<?php echo $sd['json_data']->real_question_no."_".$i.'$'.$j; ?>" placeholder="DD" />
                    <?php } ?>
                    <?php if(isset($sd['json_data']->answer_mm[$j]) && $sd['json_data']->answer_mm[$j]!=''){?>
                    <input class="answer_mm" type="text" name="answer_mm<?php echo $sd['json_data']->real_question_no."_".$i.'$'.$j; ?>" placeholder="MM" />
                    <?php } ?>
                    <?php if(isset($sd['json_data']->answer_yyyy[$j]) && $sd['json_data']->answer_yyyy[$j]!=''){?>
                    <input class="answer_yyyy" type="text" name="answer_yyyy<?php echo $sd['json_data']->real_question_no."_".$i.'$'.$j; ?>" placeholder="YYYY" />
                    <?php } ?>
                    <?php if(isset($sd['json_data']->answer_h[$j]) && $sd['json_data']->answer_h[$j]!=''){?>
                    <input class="answer_h" type="text" name="answer_h<?php echo $sd['json_data']->real_question_no."_".$i.'$'.$j; ?>" placeholder="H" />
                    <?php } ?>
                    <?php if(isset($sd['json_data']->answer_m[$j]) && $sd['json_data']->answer_m[$j]!=''){?>
                    <input class="answer_m" type="text" name="answer_m<?php echo $sd['json_data']->real_question_no."_".$i.'$'.$j; ?>" placeholder="M" />
                    <?php } ?>
                    <?php
                }else{?>
                    <input type="text" name="answer<?php echo $sd['json_data']->real_question_no; ?>_<?php echo $i.'$'.$j;?>" placeholder="Enter Your Answer" />										
                <?php } ?>
                </td>
                <?php }?>
            </tr>
            <?php } ?>
        </table>
        	</div>
        </span>
    <?php }?>	
    <?php if($sd['qtype']=="File Upload"){ ?>		
        <input type="hidden" name="" class="duplicate_question_check" value="<?php echo $sd['json_data']->question_no; ?>" />
        <label><?php echo $sd['json_data']->question_no; ?> <?php echo $sd['json_data']->question; ?></label>
		<label class="question_note"><?php echo $sd['json_data']->question_note; ?></label>
        <span class="answer">        
        	<label>
                <input type="file" name="answer<?php echo $sd['json_data']->real_question_no; ?>" accept="<?php echo ".".implode(',.',$sd['json_data']->aft); ?>" />
                <h6><?php echo $sd['json_data']->instructions_for_respondent; ?></h6>
        	</label>
		</span>            
    <?php }?>	
    <?php if($sd['qtype']=="Ranking"){ ?>					
        <input type="hidden" name="" class="duplicate_question_check" value="<?php echo $sd['json_data']->question_no; ?>" />
        <label><?php echo $sd['json_data']->question_no; ?> <?php echo $sd['json_data']->question; ?></label>
		<label class="question_note"><?php echo $sd['json_data']->question_note; ?></label>
        <span class="answer">        
			<?php foreach($sd['json_data']->answer as $ans){
            $ans=explode('|',$ans);
            ?>
            <label>
                <input type="radio" name="answer<?php echo $sd['json_data']->real_question_no; ?>" value="<?php echo $ans[0]; ?>" />[<?php echo $ans[0]; ?>] <?php echo $ans[1]; ?>
            </label>
            <?php } ?>
		</span>            
    <?php }?>	
    <?php if($sd['qtype']=="Textbox"){ ?>					
        <input type="hidden" name="" class="duplicate_question_check" value="<?php echo $sd['json_data']->question_no; ?>" />
        <label><?php echo $sd['json_data']->question_no; ?> <?php echo $sd['json_data']->question; ?></label>
		<label class="question_note"><?php echo $sd['json_data']->question_note; ?></label>
        <span class="answer">        
        	<label>
	        	<input type="text" name="answer<?php echo $sd['json_data']->real_question_no; ?>" placeholder="Enter Your Answer" />
        	</label>
		</span>        
    <?php }?>	
    <?php if($sd['qtype']=="Multiple Textbox"){ ?>					
        <input type="hidden" name="" class="duplicate_question_check" value="<?php echo $sd['json_data']->question_no; ?>" />
        <label><?php echo $sd['json_data']->question_no; ?> <?php echo $sd['json_data']->question; ?></label>
		<label class="question_note"><?php echo $sd['json_data']->question_note; ?></label>
        <span class="answer">	        
	        <table border="0">
            <?php for($i=0;$i<sizeof($sd['json_data']->rows);$i++){ ?>
            <tr>
                <td><?php echo $sd['json_data']->rows[$i]; ?></td>
                <td>
                    <input type="text" name="answer<?php echo $sd['json_data']->real_question_no; ?>_<?php echo $i; ?>" placeholder="Enter Your Answer" />
                </td>
            </tr>
            <?php } ?>
        	</table>
        </span>    
    <?php }?>	
    <?php if($sd['qtype']=="Textbox Matrix Question"){ ?>
        <input type="hidden" name="" class="duplicate_question_check" value="<?php echo $sd['json_data']->question_no; ?>" />
        <label><?php echo $sd['json_data']->question_no; ?> <?php echo $sd['json_data']->question; ?></label>
		<label class="question_note"><?php echo $sd['json_data']->question_note; ?></label>
        <span class="answer">	        
	        <table border="0">
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
                    <input type="text" name="answer<?php echo $sd['json_data']->real_question_no; ?>_<?php echo $i.'$'.$j; ?>" placeholder="Enter Your Answer" />
                </td>
                <?php }?>
            </tr>
            <?php } ?>
        	</table>
        </span>
    <?php }?>	
    <?php if($sd['qtype']=="Date/Time"){ ?>					
        <input type="hidden" name="" class="duplicate_question_check" value="<?php echo $sd['json_data']->question_no; ?>" />
        <label><?php echo $sd['json_data']->question_no; ?> <?php echo $sd['json_data']->question; ?></label>
		<label class="question_note"><?php echo $sd['json_data']->question_note; ?></label>
        <span class="answer">        
            <table border="0">
                <tr>
                <?php if(in_array("dd",(array) $sd['json_data']->answer)){ ?>
                    <td><input class="answer_dd" type="text" name="answer_dd<?php echo $sd['json_data']->real_question_no; ?>" placeholder="DD" /></td>
                    <td>&nbsp;/&nbsp;</td>
                <?php } ?>
                <?php if(in_array("mm",(array) $sd['json_data']->answer)){ ?>
                    <td><input class="answer_mm" type="text" name="answer_mm<?php echo $sd['json_data']->real_question_no; ?>" placeholder="MM" /></td>
                    <td>&nbsp;/&nbsp;</td>
                <?php } ?>
                <?php if(in_array("yyyy",(array) $sd['json_data']->answer)){ ?>
                    <td><input class="answer_yyyy" type="text" name="answer_yyyy<?php echo $sd['json_data']->real_question_no; ?>" placeholder="YYYY" /></td>
                    <td>&nbsp;&nbsp;&nbsp;</td>
                <?php } ?>
                <?php if(in_array("h",(array) $sd['json_data']->answer)){ ?>
                    <td><input class="answer_h" type="text" name="answer_h<?php echo $sd['json_data']->real_question_no; ?>" placeholder="H" /></td>
                    <td>&nbsp;-&nbsp;</td>
                <?php } ?>
                <?php if(in_array("m",(array) $sd['json_data']->answer)){ ?>
                    <td><input class="answer_m" type="text" name="answer_m<?php echo $sd['json_data']->real_question_no; ?>" placeholder="M" /></td>
                <?php } ?>
                </tr>
            </table>
		</span>
    <?php }?>	
    <?php if($sd['qtype']=="Textarea"){ ?>					
        <input type="hidden" name="" class="duplicate_question_check" value="<?php echo $sd['json_data']->question_no; ?>" />
        <label><?php echo $sd['json_data']->question_no; ?> <?php echo $sd['json_data']->question; ?></label>
		<label class="question_note"><?php echo $sd['json_data']->question_note; ?></label>
        <span class="answer">        
			<label>
	        	<textarea name="answer<?php echo $sd['json_data']->real_question_no; ?>" placeholder="Enter Your Answer"></textarea>
			</label>
        </span>
    <?php }?>	
    <?php if($sd['qtype']=="Static Image"){ ?>					
        <input type="hidden" name="" class="duplicate_question_check" value="<?php echo $sd['json_data']->question_no; ?>" />
        <label><?php echo $sd['json_data']->question_no; ?> <?php echo $sd['json_data']->question; ?></label>
		<label class="question_note"><?php echo $sd['json_data']->question_note; ?></label>
        <?php if(isset($sd['json_data']->answer_file) && $sd['json_data']->answer_file!=''){?>
            <img src="<?php echo $sd['json_data']->answer_file; ?>" />
        <?php }else{ ?>
            <img src="<?php echo $sd['json_data']->answer_url; ?>" />
        <?php } ?>
    <?php }?>	

