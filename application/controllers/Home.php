<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}
	public function randomString($length, $type = '') {
		// Select which type of characters you want in your random string
		switch($type) {
			case 'num':
				// Use only numbers
				$salt = '1234567890';
			break;
			case 'lower':
				// Use only lowercase letters
				$salt = 'abcdefghijklmnopqrstuvwxyz';
			break;
			case 'upper':
				// Use only uppercase letters
				$salt = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			break;
			default:
				// Use uppercase, lowercase, numbers, and symbols
				$salt = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
			break;
		}
		$rand = '';
		$i = 0;
		while ($i < $length) { // Loop until you have met the length
			$num = rand() % strlen($salt);
			$tmp = substr($salt, $num, 1);
			$rand = $rand . $tmp;
			$i++;
		}
		return $rand; // Return the random string
	}
	/*public function createBackupForAnalytics($survey_title_url){
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
	}*/
	public function index($data_analytics=''){
		$new_sections=array();
		$user_list=array();
		$design_list=array();
		$fill_list=array();
		$analytics_list=array();
		$surveys=array();
		if($this->session->userdata('user_logged_id')){
			$user_data=$this->User_model->get_user_by_id($this->session->userdata('user_logged_id'));
			$surveys_list=$this->db->query("select * from survey where user_id = '".$this->session->userdata('user_logged_id')."' ");
			if($surveys_list->num_rows()>0){
				$surveys_list=$surveys_list->result_array();
				foreach($surveys_list as $sl){
					array_push($user_list,$sl['title_url']);
				}
			}else{
				$surveys_list=array();
			}
			$surveys_design_list=$this->db->query("select * from survey where user_id = '".$this->session->userdata('user_logged_id')."' or permission_design like '%".$user_data[0]['username']."%' ");
			if($surveys_design_list->num_rows()>0){
				$surveys_design_list=$surveys_design_list->result_array();
				foreach($surveys_design_list as $sl){
					array_push($design_list,$sl['title_url']);
				}				
			}else{
				$surveys_design_list=array();
			}
			$surveys_fill_list=$this->db->query("select * from survey where title_url in (select survey_id from survey_section where title_url in (select survey_id as section_id from survey_data group by survey_id) group by survey_id) and user_id = '".$this->session->userdata('user_logged_id')."' or permission_fill like '%".$user_data[0]['username']."%'");
			if($surveys_fill_list->num_rows()>0){
				$surveys_fill_list=$surveys_fill_list->result_array();
				foreach($surveys_fill_list as $sl){
					array_push($fill_list,$sl['title_url']);
				}				
			}else{
				$surveys_fill_list=array();
			}
			$surveys_analytics_list=$this->db->query("select * from survey where title_url in (select survey_id from survey_values group by survey_id) and ( user_id = '".$this->session->userdata('user_logged_id')."' or permission_analytics like '%".$user_data[0]['username']."%' ) ");
			if($surveys_analytics_list->num_rows()>0){
				$surveys_analytics_list=$surveys_analytics_list->result_array();
				foreach($surveys_analytics_list as $sl){
					array_push($analytics_list,$sl['title_url']);
				}				
			}else{
				$surveys_analytics_list=array();
			}
			
			$TRIAL_EXPIRED=false;
			$trial_check=$this->db->query("select add_date from users where username='".$user_data[0]['username']."' order by add_date desc limit 0,1");
			if($trial_check->num_rows()>0){
				$trial_check=$trial_check->result_array();
				$trial_check=$trial_check[0];
				$trial_check=$trial_check['add_date'];
				//echo $trial_check." - ".date('d-m-Y',$trial_check)."<br>";
				//echo time()." - ".date('d-m-Y');
				$trial=(time()-$trial_check);
				if($trial>TRIAL_SECONDS){
					$TRIAL_EXPIRED=true;
				}
			}			
			
			$data=array(
				'randomstring'=>$this->randomString(20,''),
				'user_data'=>$user_data,
				'big_code'=>'',
				'surveys_list' => $surveys_list,
				'surveys_design_list'=>$surveys_design_list,
				'surveys_fill_list'=>$surveys_fill_list,
				'surveys_analytics_list'=>$surveys_analytics_list,
				'TRIAL_EXPIRED' => $TRIAL_EXPIRED,
				'data_analytics' => $data_analytics
			);
			if(get_cookie('design_survey')!=""){
				$data['survey']=$this->Survey_model->get_survey_by_title_url(get_cookie('design_survey'));
				$this->load->view('header');
				$this->load->view('design_survey',$data);
				$this->load->view('footer');
			}else if(get_cookie('fill_survey')!=""){
				$data['survey']=$this->Survey_model->get_survey_by_title_url(get_cookie('fill_survey'));
				$temp_sections=$this->Survey_model->get_survey_sections_by_title_url(get_cookie('fill_survey'));
				$data['section_count']=sizeof($temp_sections);
				$this->load->view('header');
				$this->load->view('fill_survey',$data);
				$this->load->view('footer');
			}else if(get_cookie('analytics_survey')!=""){
				//if($data_analytics=="dataeditor"){
					$this->Survey_model->createBackupForAnalytics(get_cookie('analytics_survey'));
					//$this->createBackupForAnalytics(get_cookie('analytics_survey'));
				//}
				$data['survey']=$this->Survey_model->get_survey_by_title_url(get_cookie('analytics_survey'));
				$data['analytics_list']=$analytics_list;
				$this->load->view('header');	
				$this->load->view('analytics_survey',$data);
				$this->load->view('footer');
			}else{
				$data['surveys_list']=$surveys_list;
				$data['TRIAL_EXPIRED']=$TRIAL_EXPIRED;
				$data['user_list']=$user_list;
				$data['design_list']=$design_list;
				$data['fill_list']=$fill_list;
				$data['analytics_list']=$analytics_list;
				//print_r($analytics_list);
				$surveys=array_merge($user_list,$design_list,$fill_list,$analytics_list);
				$surveys=array_unique($surveys);
				if(sizeof($surveys)>0){
					$surveys=$this->db->query("select * from survey where title_url in ('".implode("','",$surveys)."') ");
					if($surveys->num_rows()>0){
						$surveys=$surveys->result_array();
						$data['surveys']=$surveys;
					}
				}else{
					$data['surveys']=$surveys;
				}
				//$this->load->view('header');
				//$this->load->view('home',$data);
				//print_r($data);
				$this->load->view('blackhome2',$data);			//new dashboard
				//$this->load->view('blackhome',$data);
				//$this->load->view('footer');
			}
		}else{
			//$this->load->view('header');
			//$this->load->view('home');
			$this->load->view('blackhome');
			//$this->load->view('footer');
		}
	}
	public function contact(){
		//print_r($this->input->post());
		
		$this->email->from("jagjeet.singh@sambodhi.co.in", 'Thesurveypoint.com Contact Query');
		$this->email->to("jagjeet.singh@sambodhi.co.in");
		$this->email->subject($this->input->post('subject'));
		$this->email->message($this->input->post('message'));
		$this->email->send();

		$this->email->from("jagjeet.singh@sambodhi.co.in", 'Thesurveypoint.com');
		$this->email->to($this->input->post('email'));
		$this->email->subject("Thesurveypoint.com Contact Enquiry");
		$this->email->message("Thanks for contacting us");
		$this->email->send();

		extract($_POST);
		$this->db->query("insert into contact_query set name='".$name."', email='".$email."', subject='".$subject."', message='".$message."', add_date='".time()."' ");
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function page($page){
		$this->load->view('header');
		$this->load->view($page);
		$this->load->view('footer');
	}
	public function ajax_page($page,$id=''){
		if($page=="states"){
			$query=$this->db->query("select * from states order by name asc");
			$query=$query->result_array();
			$data = array(
				'states' => $query
			);
		}
		if($page=="districts"){
			$query=$this->db->query("select * from districts where state_id='".$id."' order by name asc");
			$query=$query->result_array();
			$data = array(
				'districts' => $query
			);
		}
		$this->load->view($page,$data);
	}
	public function db_check(){
		echo "select id,user_id,title,title_url from survey where user_id not in (select id from users)";
		$q=$this->db->query("select id,user_id,title,title_url from survey where user_id not in (select id from users)");
		if($q->num_rows()>0){
			//print_r($q->result_array());
			$q=$q->result_array();
			echo "<table border='1' width='100%'>";
			echo "<tr>";			
				echo "<td>id</td>";
				echo "<td>user_id</td>";
				echo "<td>title</td>";
				echo "<td>title_url</td>";
			echo "<tr>";			
			foreach($q as $q1){
				echo "<tr>";
				foreach($q1 as $q2_k=>$q2_v){
					echo "<td>".$q2_v."</td>";
				}
				echo "</tr>";
			}
			echo "</table>";
		}
		echo "<br>";
		echo "select id,survey_id,title,title_url from survey_section where survey_id not in (select title_url from survey)";
		$q=$this->db->query("select id,survey_id,title,title_url from survey_section where survey_id not in (select title_url from survey)");
		if($q->num_rows()>0){
			//print_r($q->result_array());
			$q=$q->result_array();
			echo "<table border='1' width='100%'>";
			echo "<tr>";			
				echo "<td>id</td>";
				echo "<td>survey_id</td>";
				echo "<td>title</td>";
				echo "<td>title_url</td>";
			echo "<tr>";			
			foreach($q as $q1){
				echo "<tr>";
				foreach($q1 as $q2_k=>$q2_v){
					echo "<td>".$q2_v."</td>";
				}
				echo "</tr>";
			}
			echo "</table>";
		}
		echo "<br>";
		echo "select id,data_id,survey_id,qtype,json_data from survey_data where survey_id not in (select title_url from survey_section)";
		$q=$this->db->query("select id,data_id,survey_id,qtype,json_data from survey_data where survey_id not in (select title_url from survey_section)");
		if($q->num_rows()>0){
			//print_r($q->result_array());
			$q=$q->result_array();
			echo "<table border='1' width='100%'>";
			echo "<tr>";			
				echo "<td>id</td>";
				echo "<td>data_id</td>";
				echo "<td>survey_id</td>";
				echo "<td>qtype</td>";
				echo "<td>json_data</td>";
			echo "<tr>";			
			foreach($q as $q1){
				echo "<tr>";
				foreach($q1 as $q2_k=>$q2_v){
					echo "<td>".$q2_v."</td>";
				}
				echo "</tr>";
			}
			echo "</table>";
		}
	
		
	}
}
