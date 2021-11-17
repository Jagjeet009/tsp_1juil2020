<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Template extends CI_Controller {
	public function __construct(){
		parent::__construct();
        $this->load->model('Synclog_model');
        $this->load->model('Survey_model');
	}
	public function index($sector='',$country=''){
		if($sector==''){
			$sectorArr=unserialize(SECTOR);
			$sector=current($sectorArr);
			$sector=strtolower($sector);
			$sector=str_replace(' ','-',$sector);			
		}
		$data=array(
			'sector'=>$sector,
			'country'=>$country
		);
		$this->load->view('template_header',$data);
		$this->load->view('template',$data);
		$this->load->view('template_footer',$data);
	}
	public function view($sector='',$country='',$title='',$title_url=''){
		if($sector==''){
			$sectorArr=unserialize(SECTOR);
			$sector=current($sectorArr);
			$sector=strtolower($sector);
			$sector=str_replace(' ','-',$sector);			
		}
		$data=array(
			'sector'=>$sector,
			'country'=>$country,
			'title_url'=>$title_url,
			'title'=>$title
		);
		//$this->load->view('template_header',$data);
		$this->load->view('template_view',$data);
		//$this->load->view('template_footer',$data);
	}	
}

