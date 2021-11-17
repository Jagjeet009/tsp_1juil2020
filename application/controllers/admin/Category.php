<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Category extends CI_Controller{
    private $structureData;
	function __construct(){
		parent::__construct();
		$this->load->model('Admin_category_model');
	}
	function generateSlug($string, $space="-", $dot = null) {
		if (function_exists('iconv')) {
			$string = @iconv('UTF-8', 'ASCII//TRANSLIT', $string);
		}
		if (!$dot) {
			$string = preg_replace("/[^a-zA-Z0-9 \-]/", "", $string);
		} else {
			$string = preg_replace("/[^a-zA-Z0-9 \-\.]/", "", $string);
		}
		$string = trim(preg_replace("/\\s+/", " ", $string));
		$string = strtolower($string);
		$string = str_replace(" ", $space, $string);
		return $string;
	} 
    function countChildren($parentId = 0){
        $childCount = 0;
        foreach($this->structureData as $row){
            if((int)$row['parent']===(int)$parentId) {
                $childCount += 1;
            }
        }
        return $childCount;
    }
    function generateStructure($parentId = 0) {
        $html = '';
		$display='';
        foreach($this->structureData as $row){
            if((int)$row['parent']==(int)$parentId){
				$count=0;
				$count=$this->countChildren($row['id']);
				if($row['parent']==0){
					if($row['display']==1){
						$display=' <i class="fa fa-eye fa-fw"></i> ';
					}else{
						$display=' <i class="fa fa-eye-slash fa-fw"></i> ';
					}
				}else{
					$display='';
				}
				$html .= '<li id="list_'.$row['id'].'"><div><span class="disclose"><span></span></span>'.$row['name'].'<a href="'.base_url().'admin/category/edit/'.$row['id'].'"><i class="fa fa-pencil fa-fw"></i></a><a href="'.base_url().'admin/category/inverse/'.$row['id'].'">'.$display.'</a></div>';
                if($count>0){
                    $html .= '<ol>';
                    $html .= $this->generateStructure($row['id']);
                    $html .= '</ol>';
                }
                $html .= '</li>';
            }
        }
        return $html;
    }
	public function index(){
		$config = array();
		$config["base_url"] = base_url() . "admin/category/index";
		$total_rows=$this->Admin_category_model->record_category_count();
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

		$query=$this->Admin_category_model->getcategory($config["per_page"], $data['page']);
		$this->structureData=$query;
		$category_list='<ol class="sortable">'.$this->generateStructure().'</ol>';
		
		$data = array(
		'title' => 'Category',
		'heading' => 'Category',
		'query' => $query,
		'category_list'=> $category_list
		); 
		
		$this->load->view('admin/header',$data);
		$this->load->view('admin/topleft',$data);
		$this->load->view('admin/category',$data);
		$this->load->view('admin/footer',$data);
	}
	public function delete($delete){  
		$this->Admin_category_model->delete($delete);
		redirect('admin/category');
	} 
	public function add(){
		$data = array(
			'title' => 'Add Category',
			'heading' => 'Add Category'
		);
		if($this->session->has_userdata('admin')){
			$this->load->view('admin/header',$data);
			$this->load->view('admin/topleft',$data);
			$this->load->view('admin/add_category',$data);
			$this->load->view('admin/footer',$data);
		}else{
			redirect('admin/login');
		}
	}
	public function edit($edit){  
		$data = array(
			'title' => 'Edit Category',
			'heading' => 'Edit Category',
			'query' => $this->Admin_category_model->edit($edit)
		);
		if($this->session->has_userdata('admin')){
			$this->load->view('admin/header',$data);
			$this->load->view('admin/topleft',$data);
			$this->load->view('admin/edit_category',$data);
			$this->load->view('admin/footer',$data);
		}else{
			redirect('admin/login');
		}
	}
	public function save(){
		if($this->input->post('id')!=''){
			$query = $this->db->query("update category set name='".$this->input->post('name')."', name_url='".$this->generateSlug($this->input->post('name'))."' where id='".$this->input->post('id')."' ");
			redirect("admin/category");
		}else{
			$query = $this->db->query("insert into category set name='".$this->input->post('name')."', name_url='".$this->generateSlug($this->input->post('name'))."', add_date='".time()."', status='1'");	
			$new_id=$this->db->insert_id();
			$q=$this->db->query("select category_order from home_setting order by id desc limit 0,1");
			if($q->num_rows()>0){
				$q=$q->result_array();
				$q=$q[0];
				if($q['category_order']!=""){
				$data=array(
					'category_order'=>$q['category_order'].",".$new_id
				);
				}else{
				$data=array(
					'category_order'=>$new_id
				);
				}				
				$data=array(
					'category_order'=>$q['category_order'].",".$new_id
				);
				$this->db->where('id','1');
				$this->db->update('home_setting',$data);
			}
			redirect("admin/category");
		}
	}
	public function display(){
		$list=$this->input->post('list');
		print_r($list);
		$i=0;
		foreach($list as $k=>$v){
			$i++;
			if($v==null){$v=0;}
			$this->db->query("update category set parent='".$v."', menu_order='".$i."' where id='".$k."' ");
		}
	}
	public function home_order($order=''){
		echo $order;
	}
	public function inverse($id){
		$q=$this->db->query("select display from category where id='".$id."' limit 0,1");
		if($q->num_rows()>0){
			$q=$q->result_array();
			$q=$q[0];
			if($q['display']=='1'){
				$inverse='0';
			}else{
				$inverse='1';
			}
			$data=array(
				'display'=>$inverse
			);
			$this->db->where('id',$id);
			$this->db->update('category',$data);
		}
		redirect("admin/category");
	}
}