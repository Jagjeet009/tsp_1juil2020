<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_urls_model extends CI_Model{
	function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
	//insert into url table
	function geturl($limit, $start){
		$this->db->order_by("add_date", "desc"); 
		$query = $this->db->get('urls', $limit, $start);
		return $query->result_array();
	}
	public function edit($edit){
		$query = $this->db->query("select * from urls where id='".$edit."'");
		return $query;	
	}
	public function delete($delete){
		$query = $this->db->query("delete from urls where id='".$delete."'");
		return $query;	
	}
	public function record_url_count() {
		return $this->db->count_all_results('urls');
    }
}