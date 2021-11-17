<?php
class Survey_model extends CI_Model{
    public function __construct()
    {
        $this->load->database();
    }
	public function get_survey_by_title_url($title_url){
		$this->db->select('*');
		$this->db->from('survey');
		$this->db->where('title_url', $title_url);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array(); 
		}else{
			return array();
		}		
	}
	public function get_survey_by_id($id){
		$this->db->select('*');
		$this->db->from('survey');
		$this->db->where('id', $id);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array(); 
		}else{
			return array();
		}
	}
	public function update_survey_by_id($id,$data){
		$this->db->where('id', $id);
		$this->db->update('survey', $data);
		//echo $this->db->last_query();
	}
	public function update_survey_by_title_url($title_url,$data){
		$this->db->where('title_url', $title_url);
		$this->db->update('survey', $data);
		//echo $this->db->last_query();
	}
	public function get_survey_section_by_id($id){
		$this->db->select('*');
		$this->db->from('survey_section');
		$this->db->where('id', $id);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array(); 
		}else{
			return array();
		}		
	}
	public function get_survey_section_by_title_url($title_url){
		$this->db->select('*');
		$this->db->from('survey_section');
		$this->db->where('title_url', $title_url);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows()>0){
			return $query->result_array(); 
		}else{
			return array();
		}		
	}
	public function get_survey_data_files_by_title_url($survey_id){
		$this->db->select('*');
		$this->db->from('survey_data_file_to_import');
		$this->db->where('survey_id', $survey_id);
		$this->db->where('status', '1');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array(); 
		}else{
			return array();
		}		
	}
	public function get_survey_sections_by_title_url($title_url){
		$this->db->select('*');
		$this->db->from('survey_section');
		$this->db->where('survey_id', $title_url);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array(); 
		}else{
			return array();
		}		
	}
	public function get_survey_data_by_title_url($title_url){
		$this->db->select('*');
		$this->db->from('survey_data');
		$this->db->where('survey_id', $title_url);
		$this->db->order_by('id','asc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows()>0){
			return $query->result_array(); 
		}else{
			return array();
		}		
	}
	public function get_survey_data_by_id($id){
		$this->db->select('*');
		$this->db->from('survey_data');
		$this->db->where('id', $id);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array(); 
		}else{
			return array();
		}		
	}
	public function get_survey_data_by_ids($id1,$id2){
		$this->db->select('sort_id');
		$this->db->from('survey_data');
		$this->db->where('sort_id >=', $id1);
		$this->db->where('sort_id <=', $id2);
		$this->db->order_by('sort_id', 'asc');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array(); 
		}else{
			return array();
		}		
	}
	public function update_section_by_id($id,$data){
		$this->db->where('id', $id);
		$this->db->update('survey_section', $data);
		//echo $this->db->last_query();
	}
	public function update_section_by_title_url($title_url,$data){
		$this->db->where('title_url', $title_url);
		$this->db->update('survey_section', $data);
		//echo $this->db->last_query();
	}
	public function update_survey_data_by_id($id,$data){
		$this->db->where('id', $id);
		$this->db->update('survey_data', $data);
		//echo $this->db->last_query();
	}
	public function update_survey_data_by_sort_id($data,$old_id){
		$this->db->where('sort_id', $old_id);
		$this->db->update('survey_data', $data);
	}
	public function update_data_file_import($data,$file_name){
		$this->db->like('data_file', $file_name);
		$this->db->update('survey_data_file_to_import', $data);
		//echo $this->db->last_query();
	}
	public function delete_survey_data_by_id($id){
		$this->db->where('id', $id);
		$this->db->delete('survey_data');
	}
	public function list_surveys_all(){
		$this->db->select('*');
		$this->db->from('survey');
		//$this->db->where('user_id', $user_id);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows()>0){
			return $query->result_array(); 
		}else{
			return array();
		}		
	}
	public function list_surveys($user_id){
		$this->db->select('*');
		$this->db->from('survey');
		$this->db->where('user_id', $user_id);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array(); 
		}else{
			return array();
		}		
	}
	public function list_questions(){
		$this->db->select('id');
		$this->db->from('survey_data');
		$this->db->order_by('id', 'desc');
		return $this->db->get();
	}
	public function list_questions_all($query){
		$this->db->select('*');
		$this->db->from('survey_data');
		$this->db->where('data_id!=', "");		
		$this->db->like('json_data', $query);		
		$this->db->order_by('id', 'desc');
		return $this->db->get();
	}
    function store_survey($data)
    {
		$insert = $this->db->insert('survey', $data);
	    return $this->db->insert_id();
	}
    function store_survey_section($data)
    {
		$insert = $this->db->insert('survey_section', $data);
	    return $this->db->insert_id();
	}
	public function store_survey_data($data){
		$insert = $this->db->insert('survey_data', $data);
	    return $this->db->insert_id();
	}
	public function store_survey_data_ajx($data){
		$this->db->insert('survey_data', $data);
	    return $this->db->insert_id();
	}
	public function store_survey_values($data){
		$insert = $this->db->insert('survey_values', $data);
	    return $insert;
	}
	public function store_survey_import_datafile($data){
		$insert = $this->db->insert('survey_data_file_to_import', $data);
	    return $insert;
	}
    function publish_survey($id, $data='')
    {
		$data=array(
			'publish_date' => time()
		);
		$this->db->where('id', $id);
		$this->db->update('survey', $data);
		$report = array();
		//$report['error'] = $this->db->_error_number();
		//$report['message'] = $this->db->_error_message();
		$report['error']=$this->db->error()['code'];
		$report['message']=	$this->db->error()['message'];
		
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}
	function delete_survey($title_url){
		$this->db->where('title_url', $title_url);
		$this->db->delete('survey'); 
		$this->db->where('survey_id', $title_url);
		$this->db->delete('survey_data'); 
		$this->db->where('survey_id', $title_url);
		$this->db->delete('survey_section'); 
		$this->db->where('survey_id', $title_url);
		$this->db->delete('survey_values'); 
	}
	function delete_section_by_title_url($title_url){
		$this->db->where('survey_id', $title_url);
		$this->db->delete('survey_data'); 
		$this->db->where('title_url', $title_url);
		$this->db->delete('survey_section'); 
	}
    function activate_survey($title_url, $data=array('status' => '1'))
    {
		$this->db->where('title_url', $title_url);
		$this->db->update('survey', $data);
		$report = array();
		//$report['error'] = $this->db->_error_number();
		//$report['message'] = $this->db->_error_message();
		$report['error']=$this->db->error()['code'];
		$report['message']=	$this->db->error()['message'];
		
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}
    function deactivate_survey($title_url, $data=array('status' => '0'))
    {
		$this->db->where('title_url', $title_url);
		$this->db->update('survey', $data);
		$report = array();
		//$report['error'] = $this->db->_error_number();
		//$report['message'] = $this->db->_error_message();
		$report['error']=$this->db->error()['code'];
		$report['message']=	$this->db->error()['message'];
		
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	} 
    function count_surveys($search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from('survey');
		if($search_string){
			$this->db->like('title', $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('id', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }	
    public function get_surveys($search_string=null, $order=null, $order_type='Asc', $limit_start=null, $limit_end=null)
    {
	    
		$this->db->select('*');
		$this->db->from('survey');

		if($search_string){
			$this->db->like('title', $search_string);
		}
		$this->db->group_by('id');

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('id', $order_type);
		}

        if($limit_start && $limit_end){
          $this->db->limit($limit_start, $limit_end);	
        }

        if($limit_start != null){
          $this->db->limit($limit_start, $limit_end);    
        }
        
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array(); 
		}else{
			return array();
		}		
    }
	public function get_survey_values_by_title_url($title_url){
		$this->db->select('*');
		$this->db->from('survey_values');
		$this->db->where('survey_id', $title_url);
		$this->db->order_by('id','asc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows()>0){
			return $query->result_array(); 
		}else{
			return array();
		}		
	}
	public function store_survey_partial_values($data){
		$insert = $this->db->insert('survey_partial_values', $data);
	    return $insert;
	}
	public function get_partial_by_ids($survey_case_id,$survey_id,$section_id){
		$this->db->select('*');
		$this->db->from('survey_partial_values');
		$this->db->where('survey_case_id', $survey_case_id);
		$this->db->where('survey_id', $survey_id);
		$this->db->where('section_id', $section_id);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows()>0){
			return $query->result_array(); 
		}else{
			return array();
		}		
	}
	function delete_partial_by_ids($survey_case_id,$survey_id,$section_id){
		$this->db->where('survey_id', $survey_id);
		$this->db->where('section_id', $section_id);
		$this->db->where('survey_case_id', $survey_case_id);
		$this->db->delete('survey_partial_values'); 
	}
	function delete_partial_by_id($survey_case_id,$survey_id){
		$this->db->where('survey_id', $survey_id);
		$this->db->where('survey_case_id', $survey_case_id);
		$this->db->delete('survey_partial_values'); 
		//echo $this->db->last_query();
	}
	public function get_partial_by_id($survey_case_id,$survey_id){
		$this->db->select('*');
		$this->db->from('survey_partial_values');
		$this->db->where('survey_case_id', $survey_case_id);
		$this->db->where('survey_id', $survey_id);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows()>0){
			return $query->result_array(); 
		}else{
			return array();
		}		
	}
	public function get_case_ids_by_survey_title_url($survey_title_url){
		$query=$this->db->query("select id,username,json_data,survey_case_id,add_date as ad from survey_partial_values where survey_id='".$survey_title_url."' group by survey_case_id order by id desc ");
		//echo $this->db->last_query();
		if($query->num_rows()>0){
			return $query->result_array(); 
		}else{
			return array();
		}		
	}
	public function survey_indicators_dataid_codenames($survey_title_url){
		$indicators=array();
		$indicators_dataid=array();
		$survey_id=$survey_title_url;
		$code_names=array();
		$query=$this->db->query("select data_id,qtype,json_data,code_name from survey_data where survey_id in (select title_url from survey_section where survey_id = '$survey_id' ) ");
		if($query->num_rows()>0){
			$query=$query->result_array();
			foreach($query as $q){
				$q['code_name']=(array) json_decode($q['code_name']);
				$code_names=array_merge($code_names,$q['code_name']);
				//print_r($q['code_name']);
				if($q['qtype']=="Textbox"){
					$q['json_data']=(array) json_decode($q['json_data']);
					$question_no=strtolower($q['json_data']['question_no']);
					$question=$q['json_data']['question'];
					$matches='';
					preg_match("#<English>(.*?)</English>#", trim($question), $matches);
					$question=$matches[1];
						$question_no=strtolower($question_no);
						if(array_key_exists("answer_".$question_no,$q['code_name'])){
							$indicators[strtoupper($q['code_name']["answer_".$question_no])]=strip_tags($question);
							$indicators_dataid[strtoupper($q['code_name']["answer_".$question_no])]=$q['data_id'];
						}else{			
							$indicators[strtoupper($question_no)]=strip_tags($question);
							$indicators_dataid[strtoupper($question_no)]=$q['data_id'];
						}
				}
				if($q['qtype']=="Multiple Choice Question"){
					$q['json_data']=(array) json_decode($q['json_data']);
					$question_no=$q['json_data']['question_no'];
					$question=$q['json_data']['question'];
					$matches='';
					preg_match("#<English>(.*?)</English>#", trim($question), $matches);
					$question=$matches[1];
						$question_no=strtolower($question_no);
						if(array_key_exists("answer_".$question_no,$q['code_name'])){
							$indicators[strtoupper($q['code_name']["answer_".$question_no])]=strip_tags($question);
							$indicators_dataid[strtoupper($q['code_name']["answer_".$question_no])]=$q['data_id'];
						}else{			
							$indicators[strtoupper($question_no)]=strip_tags($question);
							$indicators_dataid[strtoupper($question_no)]=$q['data_id'];
						}
				}
				if($q['qtype']=="Dropdown Question"){
					$q['json_data']=(array) json_decode($q['json_data']);
					$question_no=$q['json_data']['question_no'];
					$question=$q['json_data']['question'];
					$matches='';
					preg_match("#<English>(.*?)</English>#", trim($question), $matches);
					$question=$matches[1];
						$question_no=strtolower($question_no);
						if(array_key_exists("answer_".$question_no,$q['code_name'])){
							$indicators[strtoupper($q['code_name']["answer_".$question_no])]=strip_tags($question);
							$indicators_dataid[strtoupper($q['code_name']["answer_".$question_no])]=$q['data_id'];
						}else{			
							$indicators[strtoupper($question_no)]=strip_tags($question);
							$indicators_dataid[strtoupper($question_no)]=$q['data_id'];
						}
				}
				if($q['qtype']=="Textbox Matrix Question"){
					$q['json_data']=(array) json_decode($q['json_data']);
					if(isset($q['json_data']['rows']) && isset($q['json_data']['columns'])){
						for($i=0;$i<sizeof($q['json_data']['rows']);$i++){
							$matches='';
							preg_match("#<English>(.*?)</English>#", trim($q['json_data']['rows'][$i]), $matches);
							$question0=$matches[1];
							for($j=0;$j<sizeof($q['json_data']['columns']);$j++){
								$question_no=$q['json_data']['question_no']."_".$i.$j;
								$matches='';
								preg_match("#<English>(.*?)</English>#", trim($q['json_data']['columns'][$j]), $matches);
								$question=strip_tags($question0)." - ".strip_tags($matches[1]);
									$question_no=strtolower($question_no);
									if(array_key_exists("answer_".$question_no,$q['code_name'])){
										$indicators[strtoupper($q['code_name']["answer_".$question_no])]=strip_tags($question);
										$indicators_dataid[strtoupper($q['code_name']["answer_".$question_no])]=$q['data_id'];
									}else{			
										$indicators[strtoupper($question_no)]=strip_tags($question);
										$indicators_dataid[strtoupper($question_no)]=$q['data_id'];
									}
							}
						}
					}
				}
				if($q['qtype']=="Multiple Textbox"){
					$q['json_data']=(array) json_decode($q['json_data']);
					if(isset($q['json_data']['rows'])){
						for($i=0;$i<sizeof($q['json_data']['rows']);$i++){
							$question_no=$q['json_data']['question_no']."_".$i;
							$matches='';
							preg_match("#<English>(.*?)</English>#", trim($q['json_data']['rows'][$i]), $matches);
							$question=$matches[1];
								$question_no=strtolower($question_no);
								if(array_key_exists("answer_".$question_no,$q['code_name'])){
									$indicators[strtoupper($q['code_name']["answer_".$question_no])]=strip_tags($question);
									$indicators_dataid[strtoupper($q['code_name']["answer_".$question_no])]=$q['data_id'];
								}else{			
									$indicators[strtoupper($question_no)]=strip_tags($question);
									$indicators_dataid[strtoupper($question_no)]=$q['data_id'];
								}
						}
					}
				}		
				/*if($q['qtype']=="Date/Time"){
					$q['json_data']=(array) json_decode($q['json_data']);
					$question=$q['json_data']['question'];
					$matches='';
					preg_match("#<English>(.*?)</English>#", trim($question), $matches);
					$question=$matches[1];
					foreach($q['json_data']['answer'] as $qjda){
						$question_no=$qjda."_".$q['json_data']['question_no'];
						$indicators[$question_no]=strip_tags($question);
						$indicators_dataid[$question_no]=$q['data_id'];
					}
				}*/
				if($q['qtype']=="Textarea"){
					$q['json_data']=(array) json_decode($q['json_data']);
					$question_no=$q['json_data']['question_no'];
					$question=$q['json_data']['question'];
					$matches='';
					preg_match("#<English>(.*?)</English>#", trim($question), $matches);
					$question=$matches[1];
						$question_no=strtolower($question_no);
						if(array_key_exists("answer_".$question_no,$q['code_name'])){
							$indicators[strtoupper($q['code_name']["answer_".$question_no])]=strip_tags($question);
							$indicators_dataid[strtoupper($q['code_name']["answer_".$question_no])]=$q['data_id'];
						}else{			
							$indicators[strtoupper($question_no)]=strip_tags($question);
							$indicators_dataid[strtoupper($question_no)]=$q['data_id'];
						}
				}
				if($q['qtype']=="Dropdown Matrix Question"){
					$q['json_data']=(array) json_decode($q['json_data']);
					if(isset($q['json_data']['rows']) && isset($q['json_data']['columns'])){
						for($i=0;$i<sizeof($q['json_data']['rows']);$i++){
							$matches='';
							preg_match("#<English>(.*?)</English>#", trim($q['json_data']['rows'][$i]), $matches);
							$question0=$matches[1];
							for($j=0;$j<sizeof($q['json_data']['columns']);$j++){
								$question_no=$q['json_data']['question_no']."_".$i.$j;
								$matches='';
								preg_match("#<English>(.*?)</English>#", trim($q['json_data']['columns'][$j]), $matches);
								$question=strip_tags($question0)." - ".strip_tags($matches[1])."<br>";	
									$question_no=strtolower($question_no);
									if($q['json_data']['type'][$j]!="Checkbox"){
										if(array_key_exists("answer_".$question_no,$q['code_name'])){
											$indicators[strtoupper($q['code_name']["answer_".$question_no])]=strip_tags($question);
											$indicators_dataid[strtoupper($q['code_name']["answer_".$question_no])]=$q['data_id'];
										}else{			
											$indicators[strtoupper($question_no)]=strip_tags($question);
											$indicators_dataid[strtoupper($question_no)]=$q['data_id'];
										}
									}else{		// dropdown checkbox condition for indicator
										$question_no_for_checkbox='';
										foreach($q['code_name'] as $cn_k=>$cn_v){
											if(strstr($cn_k,$question_no)){
												$cn_v=explode('_',$cn_v);
												$question_no_for_checkbox=$cn_v[0]."_".$cn_v[1];
												$indicators[strtoupper($question_no_for_checkbox)]=strip_tags($question);
												$indicators_dataid[strtoupper($question_no_for_checkbox)]=$q['data_id'];
												break;
											}
										}
									}
							}
						}
					}
				}		
			}
		//echo '<pre>';	
		//print_r($indicators);
		//print_r($code_names);
		//print_r($indicators_dataid);
		}
		return array("indicators"=>$indicators,"indicators_dataid"=>$indicators_dataid,"code_names"=>$code_names);
	}
	public function createBackupForAnalytics($survey_title_url){
		$database=$this->db->database;
		$tablename="analytics_".$survey_title_url;
		$table_count=0;
		$query=$this->db->query("SELECT count(*) as table_count FROM information_schema.TABLES WHERE (TABLE_SCHEMA = '".$database."') AND (TABLE_NAME = 'analytics_".$survey_title_url."')");
		if($query->num_rows()>0){
			$query=$query->result_array();
			$table_count=$query[0]['table_count'];
			//print_r($table_count);
			
			$survey_code_name=$this->db->query("select code_name from survey_data where survey_id in (select title_url from survey_section where survey_id='".$survey_title_url."') ");
			$survey_code_name=$survey_code_name->result_array();
			$code_name=array();
			foreach($survey_code_name as $scn){
				$scn=(array) json_decode($scn['code_name']);
				foreach($scn as $k=>$v){
					$code_name[$k]=$v;
				}
			}
			//print_r($code_name);die;

			$survey_columns=array();
			$this->db->where('title_url', $survey_title_url);
			$this->db->where('status', '1');
			$this->db->order_by('id','asc');
			$query2 = $this->db->get('survey');
			if($query2->num_rows()>0){
				$survey=$query2->result_array();
				//$sfd['survey']=$survey;
				foreach($survey as $s){
					$section_sort_ids=$s['section_sort_id'];
					$section_sort_ids=explode(',',$section_sort_ids);
					if(is_array($section_sort_ids)){
						foreach($section_sort_ids as $sec_arr){
							$this->db->where('id',$sec_arr);
							$query3 = $this->db->get('survey_section');
							//echo "query: ".$this->db->last_query()." num rows: ".$query3->num_rows();
							if($query3->num_rows()>0){
								$survey_section=$query3->result_array();
								foreach($survey_section as $ss){
									//array_push($sfd['survey_section'],$ss);

									$question_sort_ids=$ss['question_sort_id'];
									$question_sort_ids=explode(',',$question_sort_ids);
									if(is_array($question_sort_ids)){
										foreach($question_sort_ids as $ques_arr){
											$this->db->where('id',$ques_arr);
											$query4 = $this->db->get('survey_data');
											//echo "query: ".$this->db->last_query()." num rows: ".$query3->num_rows();
											if($query4->num_rows()>0){
												$survey_data=$query4->result_array();
												foreach($survey_data as $sd){
													//array_push($sfd['survey_data'],$sd);
													array_push($survey_columns,$sd);
												}
											}								
										}
									}else{
										$this->db->where('id',$question_sort_ids);
										$query4 = $this->db->get('survey_data');
										//echo "query: ".$this->db->last_query()." num rows: ".$query3->num_rows();
										if($query4->num_rows()>0){
											$survey_data=$query4->result_array();
											foreach($survey_data as $sd){
												//array_push($sfd['survey_data'],$sd);
												array_push($survey_columns,$sd);
											}
										}											
									}
								}
							}
						}
					}else{
						$this->db->where('id',$section_sort_ids);
						$query3 = $this->db->get('survey_section');
						//echo "query: ".$this->db->last_query()." num rows: ".$query3->num_rows();
						if($query3->num_rows()>0){
							$survey_section=$query3->result_array();
							foreach($survey_section as $ss){
								//array_push($sfd['survey_section'],$ss);

								$question_sort_ids=$ss['question_sort_id'];
								$question_sort_ids=explode(',',$question_sort_ids);
								if(is_array($question_sort_ids)){
									foreach($question_sort_ids as $ques_arr){
										$this->db->where('id',$ques_arr);
										$query4 = $this->db->get('survey_data');
										//echo "query: ".$this->db->last_query()." num rows: ".$query3->num_rows();
										if($query4->num_rows()>0){
											$survey_data=$query4->result_array();
											foreach($survey_data as $sd){
												//array_push($sfd['survey_data'],$sd);
												array_push($survey_columns,$sd);
											}
										}								
									}
								}else{
									$this->db->where('id',$question_sort_ids);
									$query4 = $this->db->get('survey_data');
									//echo "query: ".$this->db->last_query()." num rows: ".$query3->num_rows();
									if($query4->num_rows()>0){
										$survey_data=$query4->result_array();
										foreach($survey_data as $sd){
											//array_push($sfd['survey_data'],$sd);
											array_push($survey_columns,$sd);
										}
									}										
								}
							}
						}
					}
				}
			}			
			//print_r($survey_columns);die;
			$excel_columns_array=array();
			foreach($survey_columns as $sv1){
				$json_data=(array) json_decode($sv1['elements']);
				foreach($json_data as $val1){
					if(!in_array($val1,$excel_columns_array)){
						array_push($excel_columns_array,$val1);
					}
				}
			}
			$excel_columns_array=array_unique($excel_columns_array);
			//print_r($excel_columns_array);die;
			$before_field='';
			if($table_count<1){
				if(sizeof($excel_columns_array)>0){
					$create_analytics_table_query="
					CREATE TABLE `".$tablename."` (
					  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
					  `survey_case_id` varchar(255) NOT NULL,";
					foreach($excel_columns_array as $eca){
						if(isset($code_name[$eca]) && $code_name[$eca]!=''){
							$create_analytics_table_query.="`".strtoupper($code_name[$eca])."` text NULL,";
						}else{
							$create_analytics_table_query.="`".strtoupper(str_replace('answer_','',$eca))."` text NULL,";
						}
					}
					$create_analytics_table_query.="
					`username` varchar(255) NOT NULL,
					`add_date` varchar(255) NOT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;
					";
				//echo $create_analytics_table_query;
				$this->db->query($create_analytics_table_query);
				}					
			}
			$excel_columns_array_new=array();
			foreach($excel_columns_array as $eca){
				if(isset($code_name[$eca])){
					$field_name=strtoupper($code_name[$eca]);
				}else{
					$field_name=strtoupper(str_replace('answer_','',$eca));
				}
				array_push($excel_columns_array_new,$field_name);
				if (!$this->db->field_exists($field_name, $tablename)){
					if($before_field==''){
						$this->db->query("ALTER TABLE `".$tablename."` ADD `".$field_name."` text NULL COMMENT 'New' AFTER `survey_case_id` ");
					}else{
						$this->db->query("ALTER TABLE `".$tablename."` ADD `".$field_name."` text NULL COMMENT 'New' AFTER `".$before_field."` ");
					}
				}
				$before_field=$field_name;
			}			
			//print_r($excel_columns_array_new);
			$all_fields=$this->db->list_fields($tablename);

			$comments=array();
			$fields_data = $this->db->query("SHOW FULL COLUMNS FROM `".$tablename."` ");
			if($fields_data->num_rows()>0){
				$fields_data=$fields_data->result_array();
				foreach($fields_data as $fd){
					$comments[$fd['Field']]=$fd['Comment'];
				}
			}
			///print_r($comments);
			///print_r($all_fields);
			//print_r($excel_columns_array_new);
			//die;
			for($i=2;$i<(sizeof($all_fields)-2);$i++){
				if(!in_array($all_fields[$i],$excel_columns_array_new)){
					if($comments[$all_fields[$i]]==""){
						$this->db->query("ALTER TABLE `".$tablename."` CHANGE  `".$all_fields[$i]."` `".$all_fields[$i]."` text NULL COMMENT 'Removed' ");						
					}
				}
			}
		}
		$survey_values=$this->Survey_model->get_survey_values_by_title_url($survey_title_url);
		foreach($survey_values as $sv){
			//print_r($sv['json_data']);die;
			$sv['json_data']=(array) json_decode($sv['json_data']);
			$entry=$this->db->query("select count(*) as total from ".$tablename." where survey_case_id='".$sv['survey_case_id']."'");
			if($entry->num_rows()>0){
				$entry=$entry->result_array();
				$entry=$entry[0]['total'];
				if($entry<1){
					$insert_analytics_row_query="INSERT INTO `".$tablename."` (`id`, `survey_case_id`, ";
					foreach($excel_columns_array as $eca){
						if(isset($code_name[$eca])){
							$insert_analytics_row_query.="`".strtoupper($code_name[$eca])."`, ";
						}else{
							$insert_analytics_row_query.="`".strtoupper(str_replace('answer_','',$eca))."`, ";
						}					
					}				
					//$insert_analytics_row_query.="`A01A`, ";
					$insert_analytics_row_query.="`username`,`add_date`) VALUES (NULL, '".$sv['survey_case_id']."', ";

					//print_r($sv['json_data']);
					//print_r($excel_columns_array);
					foreach($excel_columns_array as $eca){
						
						//necessary to remove for desktop but add for mobile
						//but actual problem is in getting sync entries from other device is in incorrect format
						//$eca=str_replace("answer_","",$eca);
						
						if(array_key_exists(strtolower($eca),$sv['json_data'])){
							$eca=strtolower($eca);
							//echo $eca."lower\r\n";
							$sv['json_data'][$eca]=str_replace("'","",$sv['json_data'][$eca]);
							$sv['json_data'][$eca]=str_replace('"','',$sv['json_data'][$eca]);
							$sv['json_data'][$eca]=stripslashes($sv['json_data'][$eca]);
							$sv['json_data'][$eca]=str_replace('\'','',$sv['json_data'][$eca]);
							$insert_analytics_row_query.="'".$sv['json_data'][$eca]."', ";
						}else if(array_key_exists(strtoupper($eca),$sv['json_data'])){
							$eca=strtoupper($eca);
							//echo $eca."upper\r\n";
							$sv['json_data'][$eca]=str_replace("'","",$sv['json_data'][$eca]);
							$sv['json_data'][$eca]=str_replace('"','',$sv['json_data'][$eca]);
							$sv['json_data'][$eca]=stripslashes($sv['json_data'][$eca]);
							$sv['json_data'][$eca]=str_replace('\'','',$sv['json_data'][$eca]);
							$insert_analytics_row_query.="'".$sv['json_data'][$eca]."', ";							
						}else{
							//echo $eca."\r\n";
							$insert_analytics_row_query.="'', ";
						}
					}				
					$insert_analytics_row_query.="'".$sv['username']."','".time()."');";
					//echo $insert_analytics_row_query."\r\n";
					$this->db->query($insert_analytics_row_query);
				}
			}
		}
	}
}
?>