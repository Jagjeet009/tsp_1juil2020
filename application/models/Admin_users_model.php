<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_users_model extends CI_Model{
	function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
	//insert into user table
	function getuser($limit, $start){
		$this->db->order_by("add_date", "desc"); 
		$query = $this->db->get('users', $limit, $start);
		return $query->result_array();
	}
	public function edit($edit){
		$query = $this->db->query("select * from users where id='".$edit."'");
		return $query;	
	}
	public function delete($delete){
		$query = $this->db->query("delete from users where id='".$delete."'");
		return $query;	
	}
	public function record_user_count() {
		return $this->db->count_all_results('users');
    }
}