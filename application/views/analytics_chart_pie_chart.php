<?php
$rows=$data['rows'][0];
$survey_id=$data['survey_id'];
$indicators=$data['indicators'];
$indicators_dataid=$data['indicators_dataid'];

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
$d1="['Element', 'Count'],";
foreach($distinct as $dist){
	if(isset($options[$dist]) && isset($frequencies[$dist])){
		$d1.="['".$options[$dist]."', ".$frequencies[$dist]."],";
	}else{
		$d1.="['".$dist."', ".$dist."],";
	}
}
$d1=trim($d1);
$d1=str_replace(PHP_EOL,"",$d1);
$d1=str_replace("\r","",$d1);
$d1=str_replace("\n","",$d1);
$d1=str_replace("\r\n","",$d1);
$d1=nl2br($d1);
$d1=str_replace("<br />","",$d1);
//print_r($frequencies);
//print_r($options);
//print_r($distinct);
//echo $d1;
//die;
$salt = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
$rand = '';
$i = 0;
$length = 5;
while ($i < $length) { // Loop until you have met the length
$num = rand() % strlen($salt);
$tmp = substr($salt, $num, 1);
$rand = $rand . $tmp;
$i++;
}
//echo $rand;
?>
		<div id="<?php echo $rand ?>" class="columnchart_values" style="width: 99%; height: 99%;">Chart</div>
		
		<script type="text/javascript">
			//google.charts.load('current', {packages: ['corechart', 'bar']});
			google.charts.setOnLoadCallback(drawMultSeries<?php echo $rand ?>);

			function drawMultSeries<?php echo $rand ?>() {
				var data = google.visualization.arrayToDataTable([
					<?php echo $d1; ?>
					/*['Element', 'energy'],
					['jhon', 8.94],
					['rey', 10.49],
					['heinc', 19.30],
					['patric', 21.45],*/
				]);

				var options = {
					title: '<?php echo $rows." ".$indicators[$rows]; ?>',
					is3D:true,
				};
				var c=document.getElementById('<?php echo $rand ?>');
				var chart = new google.visualization.PieChart(c);

				chart.draw(data, options);
				c.innerHTML=c.innerHTML+'<img style="display:none" src="' + chart.getImageURI() + '">';
			}
		</script>
