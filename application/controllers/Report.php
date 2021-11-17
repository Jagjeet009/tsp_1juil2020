<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Report extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}
	public function index($survey_id){
		if($this->session->userdata('user_logged_id')){
			$survey_values=$this->Survey_model->get_survey_values_by_title_url($survey_id);
			
			$survey_columns=array();
			$this->db->where('title_url', $survey_id);
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
			//print_r($survey_columns);
				
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
			//print_r($excel_columns_array);
			
			$data=array(
				'excel_columns_array'=>$excel_columns_array,
				'survey_values'=>$survey_values
			);
			$this->load->view('header');
			$this->load->view('report',$data);
			//$this->load->view('footer');
		}
	}
}
