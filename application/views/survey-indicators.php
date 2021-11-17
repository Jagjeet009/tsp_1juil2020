<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<form name="indicators_form" id="indicators_form" method="post" action="" >
	<?php
	echo "<input type='hidden' name='survey_id' value='".$survey['title_url']."' />";
	$survey_indicators=array();
	//print_r($survey['indicator']);
	if(isset($survey['indicator'])){
		$survey_indicators=(array) json_decode($survey['indicator']);
	}
	//print_r($survey_indicators);
		//echo "<h1>".$survey['title']."</h1>";
		foreach($sections as $sec){
			echo "<h3>".$sec['title']."</h3>";
			$this->db->select('*');
			$this->db->from('survey_data');
			$this->db->where('survey_id', $sec['title_url']);
			$query = $this->db->get();
			$question_data=$query->result_array(); 
			$sec_elements=array();
			foreach($question_data as $qd){
				$qd_elements=$qd['elements'];
				$qd_elements=json_decode($qd_elements);
				//print_r($qd_elements);
				if($qd_elements!='' && is_array($qd_elements) && sizeof($qd_elements)>0){
					foreach($qd_elements as $qde){
						array_push($sec_elements,$qde);
					}
				}
			}
			$sec_elements_indi=array();
			//print_r($survey_indicators);
			echo "<div class='tablespace'>";
			echo "<table cellpadding='0' cellspacing='0'>";
			echo "<tr><th width='40%' align='center'>Elements</th><th width='60%' align='center'>Indicators Text</th></tr>";
			$indicator_class="";
			foreach($sec_elements as $qd2e){
				$prev_value="";
				$new_name=str_replace('answer_','indicator_',$qd2e);
				$i_name=$new_name;
				//echo $new_name."<br>";
				if(array_key_exists($new_name,$survey_indicators)){
					$prev_value=$survey_indicators[$new_name];
				}

				if(!in_array($i_name,$sec_elements_indi)){
					if($indicator_class=="cover"){
						$indicator_class="";
					}else{
						$indicator_class="cover";
					}
					echo "<tr class='".$indicator_class."'>";
					echo "<td>".strtoupper($qd2e)."</td>";
					echo "<td><input type='text' name='".$i_name."' value='".$prev_value."' /></td>";
					echo "</tr>";
				}else{					//check elements that need not to be set indicators
					//echo "<tr class='".$indicator_class."'>";
					//echo "<td>".strtoupper($qd2e)."</td>";
					//echo "<td>&nbsp;</td>";
					//echo "</tr>";
				}

				array_push($sec_elements_indi,$i_name);
			}
			echo "</table></div>";
		}
	?>
	<input class="saveindicator" type="button" value="Save Indicators" onClick="saveIndicators(this)" />
</form>