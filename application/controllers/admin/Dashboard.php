<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
	public function index(){
		$data = array(
			'title' => 'Dashboard',
			'heading' => 'Admin Dashboard'
		);
		if($this->session->has_userdata('admin')){
			$this->load->view('admin/header',$data);
			$this->load->view('admin/topleft',$data);
			$this->load->view('admin/dashboard',$data);
			$this->load->view('admin/footer',$data);
		}else{
			redirect('admin/login');
		}
	}
	public function home_setting(){
		//print_r($this->input->post());
		//die;
		if(sizeof($this->input->post()>0)){
			$data = array(
				'category_order' => $this->input->post('category_order'),
				'listing_order' => $this->input->post('listing_order'),
				'video_order' => $this->input->post('video_order'),
				'add_date' => time()
			);  
			if($this->session->has_userdata('admin')){
				$this->db->empty_table('home_setting');
				$this->db->insert('home_setting',$data);
				redirect('admin/dashboard');
			}else{
				redirect('admin/dashboard');
			}
		}else{
			$this->db->empty_table('home_setting');
		}
	}
	public function category_setting($order=''){
			$listing_order=$this->input->post('listing_order');
			$listing_order=explode(",",$listing_order);
		
			$query0=$this->db->query("select * from home_setting order by id desc limit 0,1");
			if($query0->num_rows()>0){
				$query0=$query0->result_array();
				$query0=$query0[0];
				$query0=$query0['listing_order'];
				$query0=explode(',',$query0);
				//print_r($query0);
			}else{
				$query0=array();
			}
		
			$order=explode(',',$order);
			//print_r($order);
			$temp_lis=array();
			$temp_list=array();
			foreach($order as $o){
				if(isset($listing_order) && $listing_order!=''){
					$query=$this->db->query("select * from listing where id not in ('".implode("','",$listing_order)."') and find_in_set('".$o."',category_id) ");
				}else{
					$query=$this->db->query("select * from listing where id not in ('".implode("','",$query0)."') and find_in_set('".$o."',category_id) ");
				}
			if($query->num_rows()>0){
				$query=$query->result_array();
				//print_r($query);
				foreach($query as $q){
					if(!in_array($q['id'],$temp_list) && !in_array($q['id'],$query0)){
						array_push($temp_list,$q['id']);
						array_push($temp_lis,$q);
					}
					
				}
			}
		}
		//print_r($temp_lis);
		foreach($temp_lis as $tl){
			echo '<li class="ui-state-default" data-id="'.$tl['id'].'">'.$tl['name'].'</li>';
		}
		die;
	}
	public function listing_setting($order=''){
		$video_order=$this->input->post('video_order');
		$video_order=explode(',',$video_order);
		$order=explode(',',$order);
		$temp_vid=array();
		$temp_vido=array();
		
		$query0=$this->db->query("select * from home_setting order by id desc limit 0,1");
		if($query0->num_rows()>0){
			$query0=$query0->result_array();
			$query0=$query0[0];
			$query0=$query0['video_order'];
			$query0=explode(',',$query0);
			//print_r($query0);
		}else{
			$query0=array();
		}
		
		foreach($order as $o){
			if(isset($video_order) && $video_order!=''){
				//print_r($video_order);
				$query=$this->db->query("select * from video where id not in ('".implode("','",$video_order)."') and find_in_set('".$o."',listing_id) ");
			}else{
				$query=$this->db->query("select * from video where id not in ('".implode("','",$query0)."') and find_in_set('".$o."',listing_id) ");
			}
			if($query->num_rows()>0){
				$query=$query->result_array();
				foreach($query as $q){
					if(!in_array($q['id'],$temp_vido)){
						array_push($temp_vido,$q['id']);
						array_push($temp_vid,$q);
					}
				}				
			}
		}
		//print_r($temp_vid);
		foreach($temp_vid as $v){
			echo '<li class="ui-state-default" data-id="'.$v['id'].'">'.$v['name'].'</li>';
		}
		die;
	}
}