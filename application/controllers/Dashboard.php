<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller {
	public function __construct(){
		parent::__construct();
        $this->load->model('Synclog_model');
        $this->load->model('Survey_model');
	}
	public function index($dashboard){
		$data=array(
			'dashboard_url'=>$dashboard
		);
		$dashboard_data=$this->db->query("select * from dashboards where dashboard_url='".$dashboard."'");
		if($dashboard_data->num_rows()>0){
			$dashboard_data=$dashboard_data->result_array();
			$data['username']=$dashboard_data[0]['username'];
			$data['dashboard_name']=$dashboard_data[0]['dashboard_name'];
			$data['panel']='';
		}
		$surveys_data=$this->db->query("select * from survey where title_url in (select survey_title_url from dashboard_surveys where dashboard_url='".$dashboard."' )");
		if($surveys_data->num_rows()>0){
			$surveys_data=$surveys_data->result_array();
			$data['surveys']=$surveys_data;
		}		
		$this->load->view('blackhome3',$data);
	}
	public function panel($panel,$dashboard,$survey_id=''){
		$data=array(
			'dashboard_url'=>$dashboard,
			'survey_id'=>$survey_id
		);
		$dashboard_data=$this->db->query("select * from dashboards where dashboard_url='".$dashboard."'");
		if($dashboard_data->num_rows()>0){
			$dashboard_data=$dashboard_data->result_array();
			$data['username']=$dashboard_data[0]['username'];
			$data['dashboard_name']=$dashboard_data[0]['dashboard_name'];
			$data['panel']=$panel;
		}
		$surveys_data=$this->db->query("select * from survey where title_url in (select survey_title_url from dashboard_surveys where dashboard_url='".$dashboard."' )");
		if($surveys_data->num_rows()>0){
			$surveys_data=$surveys_data->result_array();
			$data['surveys']=$surveys_data;
		}		
		$this->load->view('blackhome3',$data);
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
	public function save(){
		$dashboard_url=$this->randomString(20,'');
		if($this->input->post('dashboard_name')!=''){
			/* recording events*/
			$data_sync = array(
				'tablename' => 'dashboards',
				'columnname' => 'username',
				'meta_primary_key' => $dashboard_url,
				'donetime' => time()
			);
			$this->Synclog_model->store_synclog($data_sync);
			$data_sync = array(
				'tablename' => 'dashboards',
				'columnname' => 'dashboard_name',
				'meta_primary_key' => $dashboard_url,
				'donetime' => time()
			);
			$this->Synclog_model->store_synclog($data_sync);
			$data_sync = array(
				'tablename' => 'dashboards',
				'columnname' => 'dashboard_url',
				'meta_primary_key' => $dashboard_url,
				'donetime' => time()
			);
			$this->Synclog_model->store_synclog($data_sync);
			/* recording events*/
		}
		
		$data=array(
			'username' => $this->input->post('username'),
			'dashboard_name' => $this->input->post('dashboard_name'),
			'dashboard_url' => $dashboard_url,
			'add_date' => time()
		);
		$query = $this->db->insert('dashboards',$data);
		redirect($_SERVER["HTTP_REFERER"]);
	}
	public function update($update,$dashboard_url,$survey_title_url){
		if($update=='1'){
			$data=array(
				'dashboard_url' => $dashboard_url,
				'survey_title_url' => $survey_title_url,
				'add_date' => time()
			);
			$query = $this->db->insert('dashboard_surveys',$data);			
		}
		if($update=='0'){
			$this->db->where('dashboard_url',$dashboard_url);
			$this->db->where('survey_title_url',$survey_title_url);
			$query = $this->db->delete('dashboard_surveys');			
		}		
	}
	public function email(){
		//$email_url=$this->input->post('email_url');
		$email_to=$this->input->post('email_to');
		$email_subject=$this->input->post('email_subject');
		$email_message=$this->input->post('email_message');
		/*$html_mail='
			<p>Dear '.$this->input->post('name').',</p>
			<p>Username '.$this->input->post('username').',</p>
			<p>Password SaMbOdHi</p>
			<!--<p><a href="'.base_url()."login/setpassword/".md5($this->input->post('email')).'">Plz Click Here To Set Your Password For Login on Sambodhi Survey </a></p>-->
			';*/
		$this->email->from("jagjeet.singh@sambodhi.co.in", 'Thesurveypoint.com');
		$this->email->to($email_to);
		$this->email->subject($email_subject);
		$this->email->message($email_message);
		$this->email->set_mailtype("html");
		$this->email->send();
		redirect($_SERVER["HTTP_REFERER"]);		
	}
}

