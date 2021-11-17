<?php defined('BASEPATH') OR exit('No direct script access allowed');
class urls extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('Admin_urls_model');
	}
	public function index(){
		$config = array();
		$config["base_url"] = base_url() . "admin/urls/index";
		$total_rows=$this->Admin_urls_model->record_url_count();
		$config["total_rows"] = $total_rows;
		$config['per_page'] = "50";
		$config["uri_segment"] = 4;
		$choice = $config["total_rows"] / $config["per_page"];
		$config["num_links"] = floor($choice);
		$config['first_url'] = '0'; 
		$config['full_tag_open'] = '<ul class="pagination pagination-small pagination-centered">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = 'First';
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		$data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$query=$this->Admin_urls_model->geturl($config["per_page"], $data['page']);
		$data = array(
		'title' => 'urls',
		'heading' => 'urls',
		'query' => $query
		); 
		$this->load->view('admin/header',$data);
		$this->load->view('admin/topleft',$data);
		$this->load->view('admin/urls',$data);
		$this->load->view('admin/footer',$data);
	}
	public function delete($delete){  
		$this->Admin_urls_model->delete($delete);
		redirect('admin/urls');
	} 
	public function add(){
		$data = array(
			'title' => 'Add urls',
			'heading' => 'Add urls'
		);
		if($this->session->has_userdata('admin')){
			$this->load->view('admin/header',$data);
			$this->load->view('admin/topleft',$data);
			$this->load->view('admin/add_urls',$data);
			$this->load->view('admin/footer',$data);
		}else{
			redirect('admin/login');
		}
	}
	public function edit($edit){  
		$data = array(
			'title' => 'Edit urls',
			'heading' => 'Edit urls',
			'query' => $this->Admin_urls_model->edit($edit)
		);
		if($this->session->has_userdata('admin')){
			$this->load->view('admin/header',$data);
			$this->load->view('admin/topleft',$data);
			$this->load->view('admin/edit_urls',$data);
			$this->load->view('admin/footer',$data);
		}else{
			redirect('admin/login');
		}
	}
	public function save(){
		//print_r($this->input->post());
		if($this->input->post('id')!=''){
			$data=array(
				'url'=> $this->input->post('url'),
				'tags'=> $this->input->post('tags')
			);
			$data['edit_date']=time();
			$this->db->where('id',$this->input->post('id'));
			$this->db->update('urls',$data);
			redirect("admin/urls");
		}else{
			$data=array(
				'url'=> $this->input->post('url'),
				'tags'=> $this->input->post('tags'),
				'add_date'=>time()
			);		
			$this->db->insert('urls',$data);
			redirect("admin/urls");
		}
	}
	/*public function checkuser($username=''){
		//ob_clean();
		if($username!=''){
			$q=$this->db->query("select count(*) as total from urls where username='".$username."' ");
			if($q->num_rows()>0){
				$q=$q->result_array();
				$q=$q[0]['total'];
				if($q==0){
					echo 1;			//go
				}else{
					echo 0;			//dont go
				}
			}else{
				echo 1;			//go
			}
		}else{
			echo 0;			//dont go
		}
	}*/
}