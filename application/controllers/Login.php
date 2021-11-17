<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
	public function __construct(){
		parent::__construct();
        $this->load->model('Synclog_model');
        $this->load->model('Survey_model');
	}
	public function index(){
		if($this->session->userdata('user_logged_id')){
			redirect('login/myaccount');
		}else{
			$this->load->view('header');
			$this->load->view('login');
			$this->load->view('footer');
		}
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
	public function success(){
		$this->load->view('header');
		$this->load->view('login-success');
		$this->load->view('footer');
	}
	public function myaccount(){
		if($this->session->userdata('user_logged_id')){
			$data=array(
				'user_data' => $this->User_model->get_user_by_id($this->session->userdata('user_logged_id'))[0]
			);
			$this->load->view('header');
			$this->load->view('login-myaccount',$data);
			$this->load->view('footer');
		}else{
			redirect('login');
		}
	}
	public function edit_name(){
		if($this->session->userdata('user_logged_id')){
			$data=array(
				'user_data' => $this->User_model->get_user_by_id($this->session->userdata('user_logged_id'))[0]
			);
			$this->load->view('header');
			$this->load->view('edit_name',$data);
			$this->load->view('footer');
		}else{
			redirect('login');
		}
	}
	public function edit_password(){
		if($this->session->userdata('user_logged_id')){
			$data=array(
				'user_data' => $this->User_model->get_user_by_id($this->session->userdata('user_logged_id'))[0]
			);
			$this->load->view('header');
			$this->load->view('edit_password',$data);
			$this->load->view('footer');
		}else{
			redirect('login');
		}
	}
	public function check_username($username=''){
		if($username!=""){
			$query=$this->User_model->get_user_by_username($username);
			echo sizeof($query);
			//print_r($query);
		}else{
			echo "1";
		}
	}
	public function register(){
			$data=array(
				'username' => $this->input->post('username'), 
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'password' => 'SaMbOdHi',
				'contact' => $this->input->post('contact'),
				'user_ip' => $_SERVER['REMOTE_ADDR'],
				'add_date' => time()
			);
			if($query = $this->User_model->store_user($data)){
				
				$html_mail='
					<p>Dear '.$this->input->post('name').',</p>
					<p>Username '.$this->input->post('username').',</p>
					<p>Password SaMbOdHi</p>
					<!--<p><a href="'.base_url()."login/setpassword/".md5($this->input->post('email')).'">Plz Click Here To Set Your Password For Login on Sambodhi Survey </a></p>-->
					';

				$this->email->from("jagjeet.singh@sambodhi.co.in", 'Thesurveypoint.com');
				$this->email->to($query['email']);
				$this->email->subject("Thesurveypoint.com Registration");
				$this->email->message($html_mail);
				$this->email->set_mailtype("html");
				$this->email->send();

				redirect($_SERVER["HTTP_REFERER"]);
			}			
	}
	public function savelocal(){
		//print_r($this->input->post());
		$d=$this->input->post('data');
		$d=$d[0];
		$data=array(
			'username' => $d['username'], 
			'name' => $d['name'],
			'email' => $d['email'],
			'password' => $d['password'],
			'contact' => $d['contact'],
			'user_ip' => '',
			'add_date' => $d['add_date'],
			'last_login_date' => '',
			'status' => "1"
		);		
		//print_r($data);

		$this->db->where('username', $d['username']);
		$this->db->where('email', $d['email']);
		$this->db->where('status', '1');
		$query = $this->db->get('users');
		//print_r($query->result());die;
		if($query->num_rows() != 1){
			$this->User_model->store_user($data);
		}
	}
	public function login(){
		if($query = $this->User_model->validate_user($this->input->post('username'),$this->input->post('password'))){

		/*// create curl resource 
        $ch = curl_init(); 
        // set url 
        curl_setopt($ch, CURLOPT_URL, ONLINE_URL."login/syncfirstdata.".$this->input->post('username')); 
        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        // $output contains the output string 
        $output = curl_exec($ch); 
			print_r($output);
        // close curl resource to free up system resources 
        curl_close($ch);  */
			
			//redirect($_SERVER["HTTP_REFERER"]);
		}else{
			redirect($_SERVER["HTTP_REFERER"]);
		}
	}
	public function logout(){
		$this->session->sess_destroy();
		foreach($_COOKIE as $ck_key=>$ck_value){
			unset($_COOKIE[$ck_key]);
		}
		setcookie('design_survey', '', time()-1000, '/');
		setcookie('fill_survey', '', time()-1000, '/');
		setcookie('analytics_survey', '', time()-1000, '/');
		//print_r($_COOKIE);
		redirect(base_url());
	}
	public function setpassword($email_md5){
		$data=array(
			'email' => $email_md5
		);
		$this->load->view('header');
		$this->load->view('setpassword',$data);
		$this->load->view('footer');
	}
	public function savepassword(){
		//print_r($this->input->post());
		if($this->input->post('new_password')==$this->input->post('confirm_password')){
			$query=$this->db->query("update users set password='".$this->input->post('new_password')."' where md5(email)='".$this->input->post('email')."' ");
			redirect('login');
		}else{
			redirect('login');
		}
	}
	public function theme_save(){
		$username=$this->input->post('username');
		$data=array(
			'theme' => $this->input->post('theme')
		);
		$query = $this->User_model->update_user_by_username($username,$data);
		redirect($_SERVER["HTTP_REFERER"]);
	}	
	public function profile_save($username){
		if($this->input->post('name')!=''){
			/* recording events*/
			$data_sync = array(
				'tablename' => 'users',
				'columnname' => 'name',
				'meta_primary_key' => $username,
				'donetime' => time()
			);
			$this->Synclog_model->store_synclog($data_sync);
			/* recording events*/
		}
		if($this->input->post('password')!=''){
			/* recording events*/
			$data_sync = array(
				'tablename' => 'users',
				'columnname' => 'password',
				'meta_primary_key' => $username,
				'donetime' => time()
			);
			$this->Synclog_model->store_synclog($data_sync);
			/* recording events*/
		}
		if($this->input->post('contact')!=''){
			/* recording events*/
			$data_sync = array(
				'tablename' => 'users',
				'columnname' => 'contact',
				'meta_primary_key' => $username,
				'donetime' => time()
			);
			$this->Synclog_model->store_synclog($data_sync);
			/* recording events*/
		}
		
		$data=array(
			'name' => $this->input->post('name'),
			//'email' => $this->input->post('email'),
			'password' => $this->input->post('password'),
			'contact' => $this->input->post('contact')
		);
		$query = $this->User_model->update_user_by_username($username,$data);
		redirect($_SERVER["HTTP_REFERER"]);
	}
	public function forgot(){
		$username=$this->input->post('username');
		$email=$this->input->post('email');
		if($this->input->post('username')!=''){
			$query = $this->User_model->get_user_by_username($username);
		}
		if($this->input->post('email')!=''){
			$query = $this->User_model->get_user_by_email($email);
		}
		$query=$query[0];
		
		$subject = "Welcome to thesurveypoint.com";
		$message = "Hello  ".$query['name'].",<br/> 
		Thanks for using thesurveypoint.com and welcome:<br/><br/>
		Please check your login details below:<br/><br/>";
		$message .= "<table width='100%' border='0' cellspacing='0' cellpadding='0'>
				<tr>
					<td width='10%'><strong>Email:</strong></td>
					<td width='90%'>".stripslashes($query['email'])."</td>
				</tr>
				<tr>
					<td width='10%'><strong>Username:</strong></td>
					<td width='90%'>".stripslashes($query['username'])."</td>
				</tr>
				<tr>
					<td><strong>Password:</strong></td>
					<td>".stripslashes($query['password'])."</td>
				</tr>
				<tr>
				<td  colspan='2' style='padding-top:10px;'>We look forward to seeing you there,</td>
				</tr>
				</table>";
		$message .= "<br/><br/><strong>Warm Regards,</strong><br/>";
		$message .= "<br/><strong>Team - Customer Support</strong><br/>";
		$message .= "<br/>thesurveypoint.com<br/>";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=windows-1254" . "\r\n";
		$headers .= "From: thesurveypoint.com <".$this->config->item('admin_email')."> \r\n";
		@mail($query['email'], $subject, $message, $headers);	
		
		redirect($_SERVER["HTTP_REFERER"]);
	}
	public function users_search($u=''){
		
		$this->db->select('username');
		$this->db->like('username', $this->input->get('query'));
		$this->db->where('username!=',$u);
		$query = $this->db->get('users');
		//echo $this->db->last_query();
		$user_arr=array();
		if($query->num_rows()>0){
			$query=$query->result_array();
			foreach($query as $q){
				$username=$q['username'];
				array_push($user_arr,array('value'=>$username,'data'=>$username));
			}
		}
		print_r(json_encode($user_arr));
		
		/*$user_arr=array();
		$users=$this->User_model->list_users();
		//$users=$users->result_array();
		//print_r($users);die;
		foreach($users as $us){
			$username=$us['username'];
			$username=preg_replace("/[^a-zA-Z0-9 ]/", "",$username);
			//$question_arr[$id]=$q_text;
			array_push($user_arr,array('value'=>$username,'data'=>$username));
		}
		//$question_arr=array_flip($question_arr);
		$user_arr=json_encode($user_arr);
		print_r($user_arr);*/
	}
	public function syncfirstdata($username){
		//print_r($username);
		$sfd=array();
		$sfd['survey']=array();
		$sfd['survey_section']=array();
		$sfd['survey_data']=array();
		$this->db->where('username', $username);
		$this->db->where('status', '1');
		$query1 = $this->db->get('users');
		//echo "query: ".$this->db->last_query()." num rows: ".$query1->num_rows();
		if($query1->num_rows()>0){
			$user_data=$query1->result_array();
			//print_r($user_data);
			$sfd['users']=$user_data[0];
			
			$this->db->where('user_id', $sfd['users']['id']);
			$this->db->or_where('permission_design like ','%'.$username.'%');
			$this->db->or_where('permission_fill like ','%'.$username.'%');
			$this->db->where('status', '1');
			$this->db->order_by('id','asc');
			$query2 = $this->db->get('survey');
			//echo "query: ".$this->db->last_query();die;
			//echo "query: ".$this->db->last_query()." num rows: ".$query2->num_rows();die;
			
			
			if($query2->num_rows()>0){
				$survey=$query2->result_array();
				$sfd['survey']=$survey;
				$big_survey=array();
				for($i=0;$i<sizeof($sfd['survey']);$i++){
					$small_survey=array();
					if($sfd['survey'][$i]['user_id']==$sfd['users']['id']){
						$small_survey=$sfd['survey'][$i];
						$small_survey['user']="owner";
					}else{
						$small_survey=$sfd['survey'][$i];
						$small_survey['user']="permitted";
					}
					array_push($big_survey,$small_survey);
				}
				$sfd['survey']=$big_survey;
				
				foreach($survey as $s){
					$section_sort_ids=$s['section_sort_id'];
					$section_sort_ids=explode(',',$section_sort_ids);
					if(is_array($section_sort_ids)){
						foreach($section_sort_ids as $sec_arr){
							$this->db->where('id',$sec_arr);
							$query3 = $this->db->get('survey_section');
							//echo "query: ".$this->db->last_query()." num rows: ".$query3->num_rows();
							if($query3->num_rows()>0){
								$survey_section=$query3->result_array();
								foreach($survey_section as $ss){
									array_push($sfd['survey_section'],$ss);

									$question_sort_ids=$ss['question_sort_id'];
									$question_sort_ids=explode(',',$question_sort_ids);
									if(is_array($question_sort_ids)){
										foreach($question_sort_ids as $ques_arr){
											$this->db->where('id',$ques_arr);
											$query4 = $this->db->get('survey_data');
											//echo "query: ".$this->db->last_query()." num rows: ".$query3->num_rows();
											if($query4->num_rows()>0){
												$survey_data=$query4->result_array();
												foreach($survey_data as $sd){
													array_push($sfd['survey_data'],$sd);
												}
											}								
										}
									}else{
										$this->db->where('id',$question_sort_ids);
										$query4 = $this->db->get('survey_data');
										//echo "query: ".$this->db->last_query()." num rows: ".$query3->num_rows();
										if($query4->num_rows()>0){
											$survey_data=$query4->result_array();
											foreach($survey_data as $sd){
												array_push($sfd['survey_data'],$sd);
											}
										}											
									}
								}
							}
						}
					}else{
						$this->db->where('id',$section_sort_ids);
						$query3 = $this->db->get('survey_section');
						//echo "query: ".$this->db->last_query()." num rows: ".$query3->num_rows();
						if($query3->num_rows()>0){
							$survey_section=$query3->result_array();
							foreach($survey_section as $ss){
								array_push($sfd['survey_section'],$ss);

								$question_sort_ids=$ss['question_sort_id'];
								$question_sort_ids=explode(',',$question_sort_ids);
								if(is_array($question_sort_ids)){
									foreach($question_sort_ids as $ques_arr){
										$this->db->where('id',$ques_arr);
										$query4 = $this->db->get('survey_data');
										//echo "query: ".$this->db->last_query()." num rows: ".$query3->num_rows();
										if($query4->num_rows()>0){
											$survey_data=$query4->result_array();
											foreach($survey_data as $sd){
												array_push($sfd['survey_data'],$sd);
											}
										}								
									}
								}else{
									$this->db->where('id',$question_sort_ids);
									$query4 = $this->db->get('survey_data');
									//echo "query: ".$this->db->last_query()." num rows: ".$query3->num_rows();
									if($query4->num_rows()>0){
										$survey_data=$query4->result_array();
										foreach($survey_data as $sd){
											array_push($sfd['survey_data'],$sd);
										}
									}										
								}
							}
						}
					}
				}
			}
		}
		echo json_encode($sfd);
	}
	public function syncfirstdataupdate($username){
		$d=array(
			'tablename' => 'synclog',
			'donetime' => time()
		);
		$this->db->insert('synclog', $d);
		
		$data=(array) json_decode($this->input->post('data'));
		if(isset($data['survey'])){
			$survey=$data['survey'];
		}
		if(isset($data['survey_section'])){
			$survey_section=$data['survey_section'];
		}
		if(isset($data['survey_data'])){
			$survey_data=$data['survey_data'];
		}
		if(isset($data['users'])){
			$online_user_data=(array) $data['users'];
		}
		$sda=array();
		$ssa=array();
		if(isset($online_user_data['username'])){
			$username=$online_user_data['username'];
		}

		if(isset($online_user_data['name'])){
			$name=$online_user_data['name'];
		}

		if(isset($online_user_data['email'])){
			$email=$online_user_data['email'];
		}

		if(isset($online_user_data['password'])){
			$password=$online_user_data['password'];
		}

		if(isset($online_user_data['contact'])){
			$contact=$online_user_data['contact'];
		}

		if(isset($online_user_data['user_ip'])){
			$user_ip=$online_user_data['user_ip'];
		}

		if(isset($online_user_data['add_date'])){
			$add_date=$online_user_data['add_date'];
		}

		if(isset($online_user_data['edit_date'])){
			$edit_date=$online_user_data['edit_date'];
		}

		if(isset($online_user_data['status'])){
			$status=$online_user_data['status'];
		}

		if(isset($online_user_data['license_key'])){
			$license_key=$online_user_data['license_key'];
		}

		if(isset($online_user_data['license_key_date'])){
			$license_key_date=$online_user_data['license_key_date'];
		}

		$this->db->where('username', $username);
		$this->db->where('status', '1');
		$query1 = $this->db->get('users');
		if(!$query1->num_rows()>0){
			$ud=array(
				'username' => $username,
				'name' => $name,
				'email' => $email,
				'password' => $password,
				'contact' => $contact,
				'user_ip' => $user_ip,
				'add_date' => $add_date,
				'edit_date' => $edit_date,
				'last_login_date' => time(),
				'status' => $status,
				'license_key' => $license_key,
				'license_key_date' => $license_key_date
			);
			$this->db->insert('users', $ud);			
		}
		
		$this->db->where('username', $username);
		$this->db->where('status', '1');
		$query1 = $this->db->get('users');
		if($query1->num_rows()>0){
			$user_data=$query1->result_array();
			$user_data=$user_data[0];
			
			if(sizeof($survey_data)>0){
				foreach($survey_data as $sd){
					$sd=(array) $sd;
					$data = array(
						'data_id' => $sd['data_id'],
						'survey_id' => $sd['survey_id'],
						'qtype' => $sd['qtype'],
						'json_data' => $sd['json_data'],
						'code' => $sd['code'],
						'elements' => $sd['elements'],
						'lengths' => $sd['lengths'],
						'code_name' => $sd['code_name'],
						'style' => $sd['style'],
						'add_date' => $sd['add_date'],
						'status' => $sd['status'],
						'complete' => $sd['complete']
					);
					$sdi=$this->Survey_model->store_survey_data($data);
					if(isset($sda[$sd['survey_id']])){
						$sda[$sd['survey_id']]=$sda[$sd['survey_id']].",".$sdi;
					}else{
						$sda[$sd['survey_id']]=$sdi;
					}
				}
			}
			if(sizeof($survey_section)>0){
				foreach($survey_section as $ss){
					$ss=(array) $ss;
					$data = array(
						'survey_id' => $ss['survey_id'],
						'title' => $ss['title'],
						'title_url' => $ss['title_url'],
						'add_date' => $ss['add_date'],
						'style' => $ss['style'],
						'status' => $ss['status']
					);
					$ssi=$this->Survey_model->store_survey_section($data);
					if(isset($ssa[$ss['survey_id']])){
						$ssa[$ss['survey_id']]=$ssa[$ss['survey_id']].",".$ssi;
					}else{
						$ssa[$ss['survey_id']]=$ssi;
					}
				}
			}
			if(sizeof($survey)>0){
				foreach($survey as $s){
					$s=(array) $s;
					$data = array(
						//'user_id' => $user_data['id'],
						'title' => $s['title'],
						'title_url' => $s['title_url'],
						'style' => $s['style'],
						'indicator' => $s['indicator'],
						'permission_design' => $s['permission_design'],
						'permission_fill' => $s['permission_fill'],
						'permission_analytics' => $s['permission_analytics'],
						'languages' => $s['languages'],
						'control' => $s['control'],
						'add_date' => $s['add_date'],
						'publish_date' => $s['publish_date'],
						'status' => $s['status'],
						'survey_sample' => $s['survey_sample'],
						'start_date' => $s['start_date'],
						'end_date' => $s['end_date'],
						'gps_enabled' => $s['gps_enabled'],
						'gps_lat_col' => $s['gps_lat_col'],
						'gps_long_col' => $s['gps_long_col'],
						'sector' => $s['sector'],
						'country' => $s['country'],
						'access' => $s['access']
						
					);
					if($s['user']=="owner"){
						$data['user_id']=$user_data['id'];
					}else{
						$data['user_id']="0";
					}
					$this->Survey_model->store_survey($data);
				}
			}
			if(sizeof($sda)>0){
				foreach($sda as $sda_k=>$sda_v){
					$data=array(
						'question_sort_id'=>$sda_v
					);
					$this->Survey_model->update_section_by_title_url($sda_k,$data);
					//echo $this->db->last_query();
				}
			}
			if(sizeof($ssa)>0){
				foreach($ssa as $ssa_k=>$ssa_v){
					$data=array(
						'section_sort_id'=>$ssa_v
					);
					$this->Survey_model->update_survey_by_title_url($ssa_k,$data);
					//echo $this->db->last_query();
				}
			}
			
		}
		echo json_encode(array("username"=>$username,"downloaded"=>"yes"));
	}
	public function syncseconddata($u){
		$table_key=array(
			'survey'=>'title_url',
			'survey_section'=>'title_url',
			'survey_data'=>'data_id',
			'survey_values'=>'survey_case_id',
			'users'=>'username'
		);
		$new_data=$this->input->post('data');
		//print_r($new_data);die;
		$last_time=$new_data['last_time'];
		$username=$new_data['username'];
		$old_surveys=$new_data['surveys'];
		//$new_back_data=array();
		
		/* collect updates that is new from online to desktop*/
		$survey_section_question_ids=array();
			$this->db->where('username', $username);
			$this->db->where('status', '1');
			$queryu = $this->db->get('users');		
			if($queryu->num_rows()>0){
				$queryu=$queryu->result_array();
					
					$querys=$this->db->query("select * from survey where user_id='".$queryu[0]['id']."' || permission_design like '%".$queryu[0]['username']."%' ");
					//echo $this->db->last_query();	
					//$queryu=$queryu[0]['id'];
					//$this->db->where('user_id', $queryu);
					//$querys = $this->db->get('survey');	
				
					if($querys->num_rows()>0){
						$querys=$querys->result_array();
						foreach($querys as $qs){
							array_push($survey_section_question_ids,$qs['title_url']);
							$this->db->where('survey_id', $qs['title_url']);
							$queryss = $this->db->get('survey_section');		
							if($queryss->num_rows()>0){
								$queryss=$queryss->result_array();
								foreach($queryss as $qss){
									array_push($survey_section_question_ids,$qss['title_url']);			
									$this->db->where('survey_id', $qss['title_url']);
									$querysd = $this->db->get('survey_data');		
									if($querysd->num_rows()>0){
										$querysd=$querysd->result_array();
										foreach($querysd as $qsd){
											array_push($survey_section_question_ids,$qsd['data_id']);	
										}
									}
								}
							}
						}
					}
			}
		//print_r($survey_section_question_ids);
		if($last_time!=''){
			$q4=$this->db->query("select id,tablename as tn,columnname as cn,meta_primary_key as mpk, donetime as dt from synclog where tablename!='synclog' and donetime>'".$last_time."' order by id asc ");
		}else{
			$q4=$this->db->query("select id,tablename as tn,columnname as cn,meta_primary_key as mpk, donetime as dt from synclog where tablename!='synclog' order by id asc ");
		}
		$q4_sync_data=array();
		if($q4->num_rows()>0){
			$q4_data=$q4->result_array();
			foreach($q4_data as $qd){
				$qd_new=array();
				if($qd['dt']!="0"){
					//print_r($qd);
					if(in_array($qd['mpk'],$survey_section_question_ids)){
						$q2=$this->db->query("select ".$qd['cn']." from ".$qd['tn']." where ".$table_key[$qd['tn']]." = '".$qd['mpk']."' order by id desc limit 0,1");
						if($q2->num_rows()>0){
							$q2=$q2->result_array();
							//print_r($q2);
							$qd_new['id']=$qd['id'];
							$qd_new['tn']=$qd['tn'];
							$qd_new['cn']=$qd['cn'];
							$qd_new['mpk']=$qd['mpk'];
							$qd_new['dt']=$qd['dt'];
							$qd_new['data']=$q2[0][$qd['cn']];
							$qd_new['changed']="1";
							$qd_new['changes']="New";
						}
					}
				}else{
					//deletion case
					$qd_new['id']=$qd['id'];
					$qd_new['tn']=$qd['tn'];
					$qd_new['cn']=$qd['cn'];
					$qd_new['mpk']=$qd['mpk'];
					$qd_new['dt']=$qd['dt'];
					$qd_new['changed']="1";
					$qd_new['changes']="Remove";
				}
				if(sizeof($qd_new)>0){
					if($qd_new['id']!=''){
						array_push($q4_sync_data,$qd_new);
					}
				}
			}
			//echo json_encode($q4_sync_data);	
		}
		//$new_back_data=array_merge($new_back_data,$q4_sync_data);
		//echo json_encode($q4_sync_data);
		$syncseconddata['updates']=$q4_sync_data;
		
		//collecting new permission surveys in second login
		$old_surveys=explode(',',$old_surveys);
		//print_r($old_surveys);
		
		$sfd=array();
		$sfd['survey']=array();
		$sfd['survey_section']=array();
		$sfd['survey_data']=array();
		$this->db->where('username', $username);
		$this->db->where('status', '1');
		$query1 = $this->db->get('users');
		//echo "query: ".$this->db->last_query()." num rows: ".$query1->num_rows();
		if($query1->num_rows()>0){
			$user_data=$query1->result_array();
			//print_r($user_data);
			$sfd['users']=$user_data[0];
			$query2=$this->db->query("select * from survey where status='1' && title_url NOT IN('".implode("','",$old_surveys)."') && (user_id='".$sfd['users']['id']."' || permission_design like '%".$username."%' || permission_fill like '%".$username."%' ) ");
			if($query2->num_rows()>0){
				$survey=$query2->result_array();
				$sfd['survey']=$survey;
				$big_survey=array();
				for($i=0;$i<sizeof($sfd['survey']);$i++){
					$small_survey=array();
					if($sfd['survey'][$i]['user_id']==$sfd['users']['id']){
						$small_survey=$sfd['survey'][$i];
						$small_survey['user']="owner";
					}else{
						$small_survey=$sfd['survey'][$i];
						$small_survey['user']="permitted";
					}
					array_push($big_survey,$small_survey);
				}
				$sfd['survey']=$big_survey;
				
				foreach($survey as $s){
					$section_sort_ids=$s['section_sort_id'];
					$section_sort_ids=explode(',',$section_sort_ids);
					if(is_array($section_sort_ids)){
						foreach($section_sort_ids as $sec_arr){
							$this->db->where('id',$sec_arr);
							$query3 = $this->db->get('survey_section');
							//echo "query: ".$this->db->last_query()." num rows: ".$query3->num_rows();
							if($query3->num_rows()>0){
								$survey_section=$query3->result_array();
								foreach($survey_section as $ss){
									array_push($sfd['survey_section'],$ss);

									$question_sort_ids=$ss['question_sort_id'];
									$question_sort_ids=explode(',',$question_sort_ids);
									if(is_array($question_sort_ids)){
										foreach($question_sort_ids as $ques_arr){
											$this->db->where('id',$ques_arr);
											$query4 = $this->db->get('survey_data');
											//echo "query: ".$this->db->last_query()." num rows: ".$query3->num_rows();
											if($query4->num_rows()>0){
												$survey_data=$query4->result_array();
												foreach($survey_data as $sd){
													array_push($sfd['survey_data'],$sd);
												}
											}								
										}
									}else{
										$this->db->where('id',$question_sort_ids);
										$query4 = $this->db->get('survey_data');
										//echo "query: ".$this->db->last_query()." num rows: ".$query3->num_rows();
										if($query4->num_rows()>0){
											$survey_data=$query4->result_array();
											foreach($survey_data as $sd){
												array_push($sfd['survey_data'],$sd);
											}
										}											
									}
								}
							}
						}
					}else{
						$this->db->where('id',$section_sort_ids);
						$query3 = $this->db->get('survey_section');
						//echo "query: ".$this->db->last_query()." num rows: ".$query3->num_rows();
						if($query3->num_rows()>0){
							$survey_section=$query3->result_array();
							foreach($survey_section as $ss){
								array_push($sfd['survey_section'],$ss);

								$question_sort_ids=$ss['question_sort_id'];
								$question_sort_ids=explode(',',$question_sort_ids);
								if(is_array($question_sort_ids)){
									foreach($question_sort_ids as $ques_arr){
										$this->db->where('id',$ques_arr);
										$query4 = $this->db->get('survey_data');
										//echo "query: ".$this->db->last_query()." num rows: ".$query3->num_rows();
										if($query4->num_rows()>0){
											$survey_data=$query4->result_array();
											foreach($survey_data as $sd){
												array_push($sfd['survey_data'],$sd);
											}
										}								
									}
								}else{
									$this->db->where('id',$question_sort_ids);
									$query4 = $this->db->get('survey_data');
									//echo "query: ".$this->db->last_query()." num rows: ".$query3->num_rows();
									if($query4->num_rows()>0){
										$survey_data=$query4->result_array();
										foreach($survey_data as $sd){
											array_push($sfd['survey_data'],$sd);
										}
									}										
								}
							}
						}
					}
				}
			}
		}		
		//print_r($sfd);
		$syncseconddata['surveys']=$sfd;
		echo json_encode($syncseconddata);
	}


}

