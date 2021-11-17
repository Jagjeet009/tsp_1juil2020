<?php
//print_r($rows);
//print_r($survey_id);
//print_r($indicators);
//print_r($indicators_dataid[$rows]);
//die;
$valid=0;
$missing=0;
$total=0;
$row_array=array();
$row_array1=array();
$distinct=array();
$frequencies=array();
$options=array();
if(isset($indicators_dataid[$rows])){
	$question_query=$this->db->query("select qtype,json_data,elements,code_name from survey_data where data_id='".$indicators_dataid[$rows]."'");
	if($question_query->num_rows()>0){
		$question_query=$question_query->result_array();
		$question_query=$question_query[0];
		$qtype=$question_query['qtype'];
		$json_data=(array) json_decode($question_query['json_data']);
		$elements=(array) json_decode($question_query['elements']);
		$code_name=(array) json_decode($question_query['code_name']);
		if($qtype=="Multiple Choice Question" && isset($json_data['multiple_answer']) && $json_data['multiple_answer']=='1'){
			if($json_data['other_specify_box']=='1'){
				array_pop($elements);
			}
			$new_elements=array();
			foreach($elements as $e){
				if(array_key_exists($e,$code_name)){
					array_push($new_elements,$code_name[$e]);
				}else{
					$e=str_replace('answer_','',$e);
					$e=strtoupper($e);
					array_push($new_elements,$e);
				}
			}
			$query1=$this->db->query("select ".implode(',',$new_elements)." from analytics_".$survey_id);
			if($query1->num_rows()>0){
				$query1=$query1->result_array();
				foreach($query1 as $query){
					foreach($query as $q_k=>$q_v){
						array_push($row_array,$q_v);
					}
				}
				//print_r($row_array);
				$total=sizeof($row_array);
				for($i=0;$i<=$total;$i++){
					if(isset($row_array[$i])){
						if($row_array[$i]==''){
							unset($row_array[$i]);
						}else{
							$valid++;
						}
					}
				}	
				$total=sizeof($row_array);
				$distinct=array_unique($row_array);
				sort($distinct);
				$frequencies=array_count_values($row_array);				
				
			}			
		}else if($qtype=="Dropdown Matrix Question"){
			$json_data=(array) json_decode($question_query['json_data']);
			$elements=(array) json_decode($question_query['elements']);
			$code_name=(array) json_decode($question_query['code_name']);
			$new_elements=array();
			$newn_elements=array();
			foreach($elements as $e){
				if(array_key_exists($e,$code_name)){
					if(!strstr(strtolower($code_name[$e]),"_oth")){
						array_push($new_elements,strtoupper($code_name[$e]));
					}
				}else{
					$e=str_replace('answer_','',$e);
					$e=strtoupper($e);
					if(!strstr(strtolower($e),"_oth")){
						array_push($new_elements,$e);
					}
				}
			}			
			for($i=0;$i<sizeof($new_elements);$i++){
				if(strstr($new_elements[$i],$rows)){
					array_push($newn_elements,$new_elements[$i]);
				}
			}
			$query1=$this->db->query("select ".implode(',',$newn_elements)." from analytics_".$survey_id);
			if($query1->num_rows()>0){
				$query1=$query1->result_array();
				foreach($query1 as $query){
					foreach($query as $q_k=>$q_v){
						array_push($row_array,$q_v);
					}
				}
				//print_r($row_array);
				$total=sizeof($row_array);
				for($i=0;$i<=$total;$i++){
					if(isset($row_array[$i])){
						if($row_array[$i]==''){
							unset($row_array[$i]);
						}else{
							$valid++;
						}
					}
				}	
				$total=sizeof($row_array);
				$distinct=array_unique($row_array);
				sort($distinct);
				$frequencies=array_count_values($row_array);				
				
			}		
			if(isset($json_data['rows']) && isset($json_data['columns'])){
				for($i=0;$i<sizeof($json_data['rows']);$i++){
					for($j=0;$j<sizeof($json_data['columns']);$j++){
						if(isset($json_data['dropdown_choices'][$j])){
							$option=array();
							foreach($json_data['dropdown_choices'][$j] as $jddc){
								if($jddc!=""){
									$jddc=explode("|",$jddc);
									$matches='';
									preg_match("#<English>(.*?)</English>#", trim($jddc[1]), $matches);
									$option[$jddc[0]]=strip_tags($matches[1]);
								}
							}
							$options[$i.$j]=$option;								
						}
					}
				}
			}
			$options_copy=$options;
			foreach($code_name as $cn_k=>$cn_v){
				$cn_kk=$cn_k;
				$cn_k=explode('_',$cn_k);
				if(strtoupper($cn_v)==$rows){
					$options=$options_copy;
					foreach($options as $options_k=>$options_v){
						if(isset($cn_k[2]) && $cn_k[2]==$options_k){
							$options=$options[$options_k];
						}
					}
				}else if(strstr($cn_v,strtolower($rows))){
					$options=$options_copy;
					foreach($options as $options_k=>$options_v){
						if(isset($cn_k[2]) && $cn_k[2]==$options_k){
							$options=$options[$options_k];
						}
					}
				}else{}
			}
		}else{
			$query1=$this->db->query("select ".$rows." from analytics_".$survey_id);
			if($query1->num_rows()>0){
				$query1=$query1->result_array();
				foreach($query1 as $query){
					array_push($row_array,$query[$rows]);
				}
			}
			$row_array1=$row_array;
			$total=sizeof($row_array);
			for($i=0;$i<=$total;$i++){
				if(isset($row_array[$i])){
					if($row_array[$i]==''){
						$missing++;
						unset($row_array[$i]);
					}else{
						$valid++;
					}
				}
			}
			$distinct=array_unique($row_array);
			sort($distinct);
			$frequencies=array_count_values($row_array1);
		}
		if(isset($json_data['answer'])){
			//print_r($json_data['answer']);
			foreach($json_data['answer'] as  $sqt_a){
				$sqt_a=explode("|",$sqt_a);
				$matches='';
				preg_match("#<English>(.*?)</English>#", trim($sqt_a[1]), $matches);
				$options[$sqt_a[0]]=strip_tags($matches[1]);
			}
		}
	}
}else{
	$query1=$this->db->query("select ".$rows." from analytics_".$survey_id);
	//echo $this->db->last_query();
	if($query1->num_rows()>0){
		$query1=$query1->result_array();
		foreach($query1 as $query){
			array_push($row_array,$query[$rows]);
		}
	}
	$row_array1=$row_array;
	$total=sizeof($row_array);
	for($i=0;$i<=$total;$i++){
		if(isset($row_array[$i])){
			if($row_array[$i]==''){
				$missing++;
				unset($row_array[$i]);
			}else{
				$valid++;
			}
		}
	}
	$distinct=array_unique($row_array);
	sort($distinct);
	$frequencies=array_count_values($row_array1);
//print_r($missing);	
}
//print_r($options);
//print_r($distinct);

//print_r($rows);
//print_r($indicators[$rows]);
//print_r($valid);
//print_r($missing);
//print_r($distinct);
//print_r($options);
//print_r($frequencies);
//print_r($total);
//die;
?>
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td align="center"><table width="300" border="0" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
            <td align="center"><strong>Statistics</strong></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="center"><?php echo $rows; ?> <?php echo $indicators[$rows]; ?></td>
          </tr>
          <tr>
            <td><table width="100%" border="1" cellpadding="0" cellspacing="0">
              <tbody>
                <tr>
                  <td>N</td>
                  <td>Valid</td>
                  <td><?php echo $valid; ?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Missing</td>
                  <td><?php echo $missing; ?></td>
                </tr>
              </tbody>
            </table></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellpadding="10">
        <tbody>
          <tr>
            <td align="center"><table width="700" border="1" cellspacing="0" cellpadding="0">
              <tbody>
                <tr>
                  <td align="center"><strong><?php echo $rows; ?> <?php echo $indicators[$rows]; ?></strong></td>
                </tr>
                <tr>
                  <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
                    <tbody>
                      <tr>
                        <td width="20%" align="center" valign="bottom">&nbsp;</td>
                        <td width="20%" align="center" valign="bottom">&nbsp;</td>
                        <td width="20%" align="center" valign="bottom">Frequency</td>
                        <td width="20%" align="center" valign="bottom">Percent</td>
                        <?php if($valid!=0){ ?>
                        <td width="20%" align="center" valign="bottom">Valid Percent</td>
                        <?php } ?>
                        </tr>
				<?php if($valid!=0){ ?>                          
                      <?php foreach($distinct as $dist){?>
                      <tr>
                        <td align="center">Valid</td>
                        <td align="center"><?php if(isset($options[$dist])){echo $options[$dist];}else{echo $dist;} ?></td>
                        <td align="center"><?php echo $frequencies[$dist]; ?></td>
                        <td align="center"><?php echo number_format(($frequencies[$dist]/$total)*100,1); ?></td>
                        <?php if($valid!=0){ ?>
                        <td align="center"><?php echo number_format(($frequencies[$dist]/$valid)*100,1); ?></td>
                        <?php } ?>
                        </tr>                      
                      <?php } ?>
                      <tr>
                        <td align="center">Valid</td>
                        <td align="center"><strong>Total</strong></td>
                        <td align="center"><strong><?php echo $valid; ?></strong></td>
                        <td align="center"><strong><?php echo number_format(($valid/$total)*100,1); ?></strong></td>
                        <?php if($valid!=0){ ?>
                        <td align="center"><strong><?php if($valid!=0){echo number_format(($valid/$valid)*100,1);}else{echo number_format($valid*100,1);} ?></strong></td>
                        <?php } ?>
                        </tr> 
				<?php } ?>                        
				<?php if($missing!=0){ ?>                                               
                      <tr>
                        <td align="center">Missing</td>
                        <td align="center">System</td>
                        <td align="center"><?php if(isset($frequencies[''])){echo $frequencies[''];}; ?></td>
                        <td align="center"><?php if(isset($frequencies[''])){echo number_format(($frequencies['']/$total)*100,1);} ?></td>
                        <?php if($valid!=0){ ?>
                        <td align="center">&nbsp;</td>
                        <?php } ?>
                        </tr>
                      <tr>
                        <td align="center"><strong>Total</strong></td>
                        <td align="center">&nbsp;</td>
                        <td align="center"><strong><?php echo $total; ?></strong></td>
                        <td align="center"><strong><?php echo number_format(($total/$total)*100,1); ?></strong></td>
                        <?php if($valid!=0){ ?>
                        <td align="center">&nbsp;</td>
                        <?php } ?>
                        </tr>
				<?php } ?>                        
                    </tbody>
                  </table></td>
                </tr>
              </tbody>
            </table></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
  </tbody>
</table>
