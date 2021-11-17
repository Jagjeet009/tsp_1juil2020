<?php
class Synclog_model extends CI_Model{
    public function __construct()
    {
        $this->load->database();
    }
    function store_synclog($data)
    {
		//print_r($data);
		$insert = $this->db->insert('synclog', $data);
	    return $insert;
	}
	public function update_synclog_by_id($id,$data){
		$this->db->where('id', $id);
		$this->db->update('synclog', $data);
		//echo $this->db->last_query();
	}	
}?>