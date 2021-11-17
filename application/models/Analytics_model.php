<?php
class Analytics_model extends CI_Model{
    public function __construct()
    {
        $this->load->database();
    }
	public function survey_data_options($data_id,$columns){
		$options=array();
		$question_query=$this->db->query("select qtype,json_data,elements,code_name from survey_data where data_id='".$data_id."'");
		//echo $this->db->last_query();
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
					if(strstr($new_elements[$i],$columns)){
						array_push($newn_elements,$new_elements[$i]);
					}
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
					if(strtoupper($cn_v)==$columns){
						$options=$options_copy;
						foreach($options as $options_k=>$options_v){
							if(isset($cn_k[2]) && $cn_k[2]==$options_k){
								$options=$options[$options_k];
							}
						}
					}else if(strstr($cn_v,strtolower($columns))){
						$options=$options_copy;
						foreach($options as $options_k=>$options_v){
							if(isset($cn_k[2]) && $cn_k[2]==$options_k){
								$options=$options[$options_k];
							}
						}
					}else{}
				}
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
		return $options;
	}
	public function survey_data_rowarray($data_id,$survey_id,$rows){
		$row_array=array();
		$valid='';
		$missing='';
		$question_query=$this->db->query("select qtype,json_data,elements,code_name from survey_data where data_id='".$data_id."'");
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
							if($q_v!=''){
								array_push($row_array,$q_v);
							}
						}
					}
					//print_r($row_array);
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
							if($q_v!=''){
								array_push($row_array,$q_v);
							}
						}
					}
					//print_r($row_array);
				}		
			}else{
				$query1=$this->db->query("select ".$rows." from analytics_".$survey_id);
				if($query1->num_rows()>0){
					$query1=$query1->result_array();
					foreach($query1 as $query){
						if($query[$rows]!=''){
							array_push($row_array,$query[$rows]);
						}
					}
				}
			}
		}
		return $row_array;
	}
	public function survey_data_new_columns($data_id,$survey_id,$rows){
		$new_columns=array();
		$question_query=$this->db->query("select qtype,json_data,elements,code_name from survey_data where data_id='".$data_id."'");
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
				$new_columns=$new_elements;
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
				$new_columns=$newn_elements;
			}else{
				array_push($new_columns,$rows);
			}
		}
		return $new_columns;
	}
	public function survey_data_data($survey_id,$rows,$column,$distinct_rows,$distinct_columns){
		//print_r($survey_id);
		//print_r($rows);
		//print_r($column);
		//print_r($distinct_rows);
		//print_r($distinct_columns);
		$data_array=array();
		foreach($distinct_rows as $dr){
			if($dr!=''){
				$row_where='';
				for($i=0;$i<sizeof($rows);$i++){
					if($i==0){
						$row_where.=" ".$rows[$i]."='".$dr."' ";
					}else{
						$row_where.=" || ".$rows[$i]."='".$dr."' ";
					}
				}
				$data_col_array=array();
				foreach($distinct_columns as $dc){
					if($dc!=''){
						$col_where='';
						for($j=0;$j<sizeof($column);$j++){
							if($j==0){
								$col_where.=" ".$column[$j]."='".$dc."' ";
							}else{
								$col_where.=" || ".$column[$j]."='".$dc."' ";
							}
						}
						$q=$this->db->query("select count(*) as total,".implode(',',$rows).",".implode(',',$column)." from analytics_".$survey_id." where 1=1 && (".$row_where.") && (".$col_where.") ");
						if($q->num_rows()>0){
							$q=$q->result_array();
							$q=$q[0]['total'];
							$data_col_array[$dc]=$q;
						}
					}
				}
			}
			$data_array[$dr]=$data_col_array;
		}
		//print_r($data_array);
		return $data_array;
	}
	public function survey_data_entries($survey_id,$columns){
		if(sizeof($columns)>0){
			//print_r($columns);
			$q=$this->db->query("select ".implode(',',$columns)." from analytics_".$survey_id." order by id asc ");
			//echo $this->db->last_query();
			if($q->num_rows()>0){
				$q=$q->result_array();
				return $q;
				/*$result=array();
				foreach($columns as $c){
					${$c}=array();
					foreach($q as $qq){
						array_push(${$c},$qq[$c]);
					}
					$result[$c]=${$c};
				}
				return $result;*/
			}		
		}
	}
	public function collect_columns($rows,$columns,$layer){
		$all_data_columns=array();
		if(isset($layer)){
			$all_data_columns=array_merge($rows,$columns,$layer);
		}else if(isset($columns)){
			$all_data_columns=array_merge($rows,$columns);	
		}else{
			$all_data_columns=$rows;	
		}
		return $all_data_columns;
	}
	public function fake_options($entries,$rows){
		//print_r($rows);
		if(sizeof($entries)>0){
			$rows_options=array();
			$ro=array();
			foreach($entries as $e_k=>$e_v){
				foreach($e_v as $e_v_k=>$e_v_v){
					//echo $e_v_k."\r\n";
					if(in_array($e_v_k,$rows)){
						//echo $e_v_k."\r\n";					
						if($e_v_v!=""){
							array_push($ro,$e_v_v);
						}
					}
				}
			}
			$ro=array_unique($ro);
			foreach($ro as $r){
				$rows_options[$r]=$r;
			}
			return $rows_options;
		}	
	}
}

?>