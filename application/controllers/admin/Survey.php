<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Survey extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
	public function index(){
		$surveys=array();
		$this->db->order_by('id','desc');
		$surveys = $this->db->get('survey');
		if($surveys->num_rows()>0){
			$surveys=$surveys->result_array();
		}else{
			$surveys=array();
		}
		$data=array(
			'surveys'=>$surveys
		);
		$this->load->view('admin/header');
		$this->load->view('admin/topleft');
		$this->load->view('admin/surveys',$data);
		$this->load->view('admin/footer');
	}
	public function delete($id){
		//echo $id;
		$surveys_id=array();
		$surveys_sections_id=array();
		$surveys_questions_id=array();
		$surveys_entries_id=array();
		$this->db->select('id,title,title_url,section_sort_id');
		$this->db->where('id',$id);
		$surveys = $this->db->get('survey');
		if($surveys->num_rows()>0){
			$surveys=$surveys->result_array();
			//print_r($surveys);
			foreach($surveys as $s){
				array_push($surveys_id,$s['id']);
				$section_sort_id=$s['section_sort_id'];
				$section_sort_id=explode(',',$section_sort_id);
				foreach($section_sort_id as $ssi){
					array_push($surveys_sections_id,$ssi);
					$this->db->select('id,title,title_url,question_sort_id');
					$this->db->where('id',$ssi);
					$sections = $this->db->get('survey_section');
					if($sections->num_rows()>0){
						$sections=$sections->result_array();
						//print_r($sections);
						foreach($sections as $sec){
							$question_sort_id=$sec['question_sort_id'];
							$question_sort_id=explode(',',$question_sort_id);
							foreach($question_sort_id as $qsi){
								array_push($surveys_questions_id,$qsi);
							}
						}
					}
				}
				$this->db->select('id');
				$this->db->where('survey_id',$s['title_url']);
				$values = $this->db->get('survey_values');
				if($values->num_rows()>0){
					$values=$values->result_array();
					foreach($values as $val){
						array_push($surveys_entries_id,$val['id']);
					}
				}
			}
		}	
		foreach($surveys_entries_id as $sei){
			$this->db->where('id', $sei);
			$this->db->delete('survey_values');			
		}
		foreach($surveys_questions_id as $sqi){
			$this->db->where('id', $sqi);
			$this->db->delete('survey_data');			
		}
		foreach($surveys_sections_id as $ssi){
			$this->db->where('id', $ssi);
			$this->db->delete('survey_section');			
		}
		foreach($surveys_id as $si){
			$this->db->where('id', $si);
			$this->db->delete('survey');			
		}		
		redirect($_SERVER['HTTP_REFERER']);
	}
}