<?php
class User_model extends CI_Model {
 
    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }

    /**
    * Get product by his is
    * @param int $product_id 
    * @return array
    */
    public function get_user_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('id', $id);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array(); 
		}else{
			return array();
		}
    }    
    public function get_user_by_username($username)
    {
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('username', $username);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array(); 
		}else{
			return array();
		}
    }    
    public function get_user_by_email($email)
    {
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('email', $email);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array(); 
		}else{
			return array();
		}
    }    

    /**
    * Fetch users data from the database
    * possibility to mix search, filter and order
    * @param string $search_string 
    * @param strong $order
    * @param string $order_type 
    * @param int $limit_start
    * @param int $limit_end
    * @return array
    */
    public function get_users($search_string=null, $order=null, $order_type='Asc', $limit_start=null, $limit_end=null)
    {
	    
		$this->db->select('*');
		$this->db->from('users');

		if($search_string){
			$this->db->like('name', $search_string);
		}
		$this->db->group_by('id');

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('id', $order_type);
		}

        if($limit_start && $limit_end){
          $this->db->limit($limit_start, $limit_end);	
        }

        if($limit_start != null){
          $this->db->limit($limit_start, $limit_end);    
        }
        
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array(); 
		}else{
			return array();
		}
    }

    /**
    * Count the number of rows
    * @param int $search_string
    * @param int $order
    * @return int
    */
    function count_users($search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from('users');
		if($search_string){
			$this->db->like('name', $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('id', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }

    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_user($data)
    {
		$insert = $this->db->insert('users', $data);
	    return $insert;
	}

    /**
    * Update user
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_user($id, $data)
    {
		$this->db->where('id', $id);
		$this->db->update('users', $data);
		$report = array();
		//$report['error'] = $this->db->_error_number();
		//$report['message'] = $this->db->_error_message();
		$report['error']=$this->db->error()['code'];
		$report['message']=	$this->db->error()['message'];
		
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}
    function update_user_by_username($username, $data)
    {
		$this->db->where('username', $username);
		$this->db->update('users', $data);
		$report = array();
		//$report['error'] = $this->db->_error_number();
		//$report['message'] = $this->db->_error_message();
		$report['error']=$this->db->error()['code'];
		$report['message']=	$this->db->error()['message'];
	}

    /**
    * Delete user
    * @param int $id - user id
    * @return boolean
    */
	function delete_user($id){
		$this->db->where('id', $id);
		$this->db->delete('users'); 
	}
    function activate_user($id, $data=array('status' => '1'))
    {
		$this->db->where('id', $id);
		$this->db->update('users', $data);
		$report = array();
		//$report['error'] = $this->db->_error_number();
		//$report['message'] = $this->db->_error_message();
		$report['error']=$this->db->error()['code'];
		$report['message']=	$this->db->error()['message'];
		
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}
    function deactivate_user($id, $data=array('status' => '0'))
    {
		$this->db->where('id', $id);
		$this->db->update('users', $data);
		$report = array();
		//$report['error'] = $this->db->_error_number();
		//$report['message'] = $this->db->_error_message();
		$report['error']=$this->db->error()['code'];
		$report['message']=	$this->db->error()['message'];
		
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	} 
	function validate_user($username,$password){
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$this->db->where('status', '1');
		$query = $this->db->get('users');
		//print_r($query->result());die;
		if($query->num_rows() == 1){
			$user_data=$query->result()[0];
			$is_valid=true;
		}else{
			$is_valid=false;
		}
		if($is_valid){
			$data = array(
				'user_logged_id' => $user_data->id,
				'user_logged_username' => $user_data->username,
				'user_logged' => $user_data->name
			);
			$data1=array(
				'last_login_date' => time()
			);
			$this->update_user($user_data->id,$data1);
			$this->session->set_userdata($data);
			return true;
		}else{
			return false;
		}
	}
    public function list_users()
    {
		$this->db->select('*');
		$this->db->from('users');
		//$this->db->where('id', $id);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows()>0){
			return $query->result_array(); 
		}else{
			return array();
		}
    }    
}
?>	
