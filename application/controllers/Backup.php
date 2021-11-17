<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Backup extends CI_Controller {
	public $util;
	public function __construct(){
        parent::__construct();
        $this->load->model('Mail_model');  
	}	
	public function index(){
		$database=$this->db->database;
		$this->myutil = $this->load->dbutil($database, TRUE);
		$prefs = array(
		    'format' => 'zip',
		    'filename' => $database . '.sql'
		);
		$backup = $this->myutil->backup($prefs);
		$db_name = $database.'-backup-on-'.date("Y-m-d-H-i-s") . '.zip';
		$this->load->helper('file');
		$file=base_url().'databases/'.$db_name;
		write_file('databases/'.$db_name, $backup);
		echo 'Done...';
		$status=$this->Mail_model->mail("jagjeet.singh@sambodhi.co.in","Auto Database Backup",base_url(),$file);
		echo json_encode($status);
	}
}
