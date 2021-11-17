<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Logout extends CI_Controller
{
 
  function __construct()
  {
    parent::__construct();
  }
 
  public function index()
  {
	$this->load->helper('url');
	$this->load->library('session');
	unset($_SESSION['admin']);
	redirect('admin/login');
  }
}