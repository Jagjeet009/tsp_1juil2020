<?php defined('BASEPATH') OR exit('No direct script access allowed');
class users extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('Admin_users_model');
	}
	public function index(){
		$config = array();
		$config["base_url"] = base_url() . "admin/users/index";
		$total_rows=$this->Admin_users_model->record_user_count();
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
		$query=$this->Admin_users_model->getuser($config["per_page"], $data['page']);
		$data = array(
		'title' => 'users',
		'heading' => 'users',
		'query' => $query
		); 
		$this->load->view('admin/header',$data);
		$this->load->view('admin/topleft',$data);
		$this->load->view('admin/users',$data);
		$this->load->view('admin/footer',$data);
	}
	public function delete($delete){  
		$this->Admin_users_model->delete($delete);
		redirect('admin/users');
	} 
	public function add(){
		$data = array(
			'title' => 'Add users',
			'heading' => 'Add users'
		);
		if($this->session->has_userdata('admin')){
			$this->load->view('admin/header',$data);
			$this->load->view('admin/topleft',$data);
			$this->load->view('admin/add_users',$data);
			$this->load->view('admin/footer',$data);
		}else{
			redirect('admin/login');
		}
	}
	public function edit($edit){  
		$data = array(
			'title' => 'Edit users',
			'heading' => 'Edit users',
			'query' => $this->Admin_users_model->edit($edit)
		);
		if($this->session->has_userdata('admin')){
			$this->load->view('admin/header',$data);
			$this->load->view('admin/topleft',$data);
			$this->load->view('admin/edit_users',$data);
			$this->load->view('admin/footer',$data);
		}else{
			redirect('admin/login');
		}
	}
	public function save(){
		//print_r($this->input->post());
		if($this->input->post('id')!=''){
			$data=array(
				'name'=> $this->input->post('name'),
				'email'=> $this->input->post('email'),
				'username'=> $this->input->post('username'),
				'password'=> $this->input->post('password'),
				'contact'=> $this->input->post('contact')
			);
			$data['add_date']=time();
			$this->db->where('id',$this->input->post('id'));
			$this->db->update('users',$data);
			redirect("admin/users");
		}else{
			$one_user=array();
			for($i=0;$i<sizeof($this->input->post('name'));$i++){
				$o_user=array(
					'name'=> $this->input->post('name')[$i],
					'email'=> $this->input->post('email')[$i],
					'username'=> $this->input->post('username')[$i],
					'password'=> $this->input->post('password')[$i],
					'contact'=> $this->input->post('contact')[$i]
				);
				array_push($one_user,$o_user);
			}
			foreach($one_user as $ou){
				if($ou['name']!='' && $ou['email']!='' && $ou['username']!='' && $ou['password']!='' && $ou['contact']!=''){
					$data=array(
						'name'=> $ou['name'],
						'email'=> $ou['email'],
						'username'=> $ou['username'],
						'password'=> $ou['password'],
						'contact'=> $ou['contact'],
						'add_date'=>time(),
						'status' => 1
					);		
					$this->db->insert('users',$data);
				}
			}
			redirect("admin/users");
		}
	}
	public function checkuser($username=''){
		//ob_clean();
		if($username!=''){
			$q=$this->db->query("select count(*) as total from users where username='".$username."' ");
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
	}
}