<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
	public function index(){
		$data = array(
			'title' => 'Login',
			'heading' => 'Admin',
		);  
		$this->load->view('admin/header',$data);
		$this->load->view('admin/login',$data);
		$this->load->view('admin/footer',$data);
	}
	public function login(){
		$query = $this->db->query("SELECT username, password FROM user where username='".$this->input->post('username')."' and password='".$this->input->post('password')."' ");
		if($query->num_rows()>0){
			$this->session->set_userdata(array('admin'=>$query->result()));
			redirect('admin/dashboard');
		}else{
			redirect('admin/login');
		}
	}
}