<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Desktop extends CI_Controller {
	public function __construct(){
		parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Synclog_model');
	}
	public function index(){
			echo "No function Called";
		$this->logDesktop();
	}
	public function logDesktop(){
		$local_version_file='logDesktop.txt';
		if(!file_exists($local_version_file)) {
			@file_put_contents($local_version_file, 'Desktop Logs'); 
		}else{
			$date=date('d-m-Y ');
			$time=date('h:i:sa');
			$url=current_url();
			$get=json_encode($this->input->get());
			$post=json_encode($this->input->post());
			$return_data=ob_get_contents();
			@file_put_contents($local_version_file, PHP_EOL." ".PHP_EOL.$date." ".$time,FILE_APPEND); 
			@file_put_contents($local_version_file, PHP_EOL.$url,FILE_APPEND); 
			@file_put_contents($local_version_file, PHP_EOL.'Get: '.$get,FILE_APPEND); 
			@file_put_contents($local_version_file, PHP_EOL.'Post: '.$post,FILE_APPEND); 
			@file_put_contents($local_version_file, PHP_EOL.'Return Data: '.$return_data,FILE_APPEND); 
		}
	}	
	public function readDesktopLog($command){
		$local_version_file='logDesktop.txt';
		if(file_exists($local_version_file)) {
			if($command==='delete'){
				@file_put_contents($local_version_file, 'Desktop Logs'); 
			}else{
				$desktopLog = file_get_contents(base_url()."logDesktop.txt");
				echo "<!doctype html>
				<html>
				<head>
				<title>Desktop Logs</title>
				</head>
				<body>
				<pre>".$desktopLog."</pre>
				<script type=text/javascript>window.scrollTo(0,document.body.scrollHeight)</script>
				</body>
				</html>";
			}
		}
	}
	public function func($func,$p=''){
		if($func=="register"){
			$this->register();
		}else if($func=="login"){
			$this->login();
		}else if($func=="forgotpass"){
			$this->forgotpass();
		}else if($func=="sync"){
			$this->sync($p);
		}else if($func=="syncsend"){
			$this->syncsend($p);
		}else if($func=="syncget"){
			$this->syncget($p);
		}else if($func=="syncgetsecond"){
			$this->syncgetsecond($p);
		}else if($func=="syncstatusupdate"){
			$this->syncstatusupdate($p);
		}else if($func=="syncreceive"){
			$this->syncreceive($p);
		}else if($func=="syncsendsingle"){
			$this->syncsendsingle($p);
		}else if($func=="license_check"){
			$this->license_check($p);
		}else if($func=="logDesktop"){
			$this->logDesktop();
		}else if($func=="readDesktopLog"){
			$this->readDesktopLog($p);
		}else if($func=="registerDirectRespondent"){
			$this->registerDirectRespondent($p);
		}else{
			echo "No function Called";
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
	function check_mandatory($mandatory){
		$data=array();
		$post_data=$this->input->post(NULL, TRUE);
		//print_r($post_data);
		$file_data=$_FILES;
		$error_list=array();
		$new_data=array();
		if(sizeof($post_data)>0){
			foreach($mandatory as $m){
				if(array_key_exists($m,$post_data)){
					if($post_data[$m]=="" || $post_data[$m]==null || $post_data[$m]==" "){
						array_push($error_list,$m);
					}else{
						$new_post_data=array();
						foreach($post_data as $pd_key=>$pd_value){
							$pd_value=addslashes($pd_value);
							$pd_value=trim($pd_value);
							$new_post_data[$pd_key]=$pd_value;
						}
						$new_data=array_merge($new_data,$new_post_data);
					}
				}
				if(array_key_exists($m,$file_data)){
					if($file_data[$m]=="" || $file_data[$m]==null || $file_data[$m]==" "){
						array_push($error_list,$m);
					}else{
						$new_file_data=array();
						foreach($file_data as $fd_key=>$fd_value){
							$new_file_data[$fd_key]=$fd_value['name'];
						}
						$new_data=array_merge($new_data,$new_file_data);
					}
				}
			}
			if(sizeof($error_list)>0){
				$data['success'] = 0;
				$data['message'] = "Following fields are required: ".implode(',',$error_list);
				echo json_encode($data);
				die;
			}else{
				return $new_data;
			}
		}else{
			$data['success'] = 0;
			$data['message'] = "No data posted";
			echo json_encode($data);
			die;
		}
	}
	//url : http://www.thesurveypoint.com/desktop_api/register/
	function register(){
		$post_data=$this->check_mandatory(array('username','name','email','contact'));
		$post_data['password']=$this->randomString(20,'');
		$query=$this->db->query("select * from users where username='".$post_data['username']."' order by id desc limit 0,1 ");
		$query=$query->result_array();
		if(!sizeof($query)>0){
			$this->db->query("insert into users set username='".$post_data['username']."', name='".$post_data['name']."', email='".$post_data['email']."', password='".$post_data['password']."', contact='".$post_data['contact']."', add_date='".time()."' ");
			$query=$this->db->query("select * from users where id='".$this->db->insert_id()."' ");
			$data['success'] = 1;
			$data['message'] = "Your account has been created please login.";
			$data['data']=$query->result_array();
			echo json_encode($data);
			
			$subject = "Welcome to thesurveypoint.com";
			$message = "Hello  ".$post_data['name'].",<br/> Thanks for signing up with us at thesurveypoint.com and welcome.:<br/><br/>Please check your login details below:<br/><br/>";
			$message .= "<table width='100%' border='0' cellspacing='0' cellpadding='0'>
					<tr>
						<td width='10%'><strong>Email:</strong></td>
						<td width='90%'>".stripslashes($post_data['email'])."</td>
					</tr>
					<tr>
						<td width='10%'><strong>Username:</strong></td>
						<td width='90%'>".stripslashes($post_data['username'])."</td>
					</tr>
					<tr>
						<td><strong>Password:</strong></td>
						<td>".stripslashes($post_data['password'])."</td>
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
			@mail($post_data['email'], $subject, $message, $headers);
		}else{
			$data['success'] = 0;
			$data['message'] = "User name exists";
			echo json_encode($data);
		}
		$this->logDesktop();
	}
	//url : http://www.thesurveypoint.com/desktop_api/login/
	function login(){
		$post_data=$this->check_mandatory(array('username','password'));
		$query=$this->db->query("select * from users where username='".$post_data['username']."' and password='".$post_data['password']."' ");
		$query=$query->result_array();
		if(sizeof($query)>0){
			$data1=array(
				'last_login_date' => time()
			);
			$this->User_model->update_user($query[0]['id'],$data1);
			
			$q=$this->db->query("select * from synclog where tablename='synclog' order by id desc limit 0,1 ");
			if($q->num_rows()>0){
				$q=$q->result_array();
				$data['synclog']=$q[0]['donetime'];
			}else{
				$data['synclog']='0';
			}
			
			$q1=$this->db->query("select title_url from survey order by id asc ");
			if($q1->num_rows()>0){
				$q1=$q1->result_array();


				$surveys=array();
				foreach($q1 as $q11){
					array_push($surveys,$q11['title_url']);
				}
				$data['surveys']=implode(',',$surveys);
			}else{
				$data['surveys']="";
			}			
			
			$data['last_login_date']=$query[0]['last_login_date'];
			$data['success'] = 1;
			$data['message'] = "You logged in sucessfully";
			$data['data']=$query;
			echo json_encode($data);

			$data = array(
				'user_logged_id' => $query[0]['id'],
				'user_logged_username' => $query[0]['username'],
				'user_logged' => $query[0]['name']
			);
			$this->session->set_userdata($data);
			//print_r($this->session->userdata());
		}else{
			$data['success'] = 0;
			$data['message'] = "Invalid user information";
			echo json_encode($data);
		}
		$this->logDesktop();
	}
	//url : http://www.thesurveypoint.com/desktop_api/forgotpass/
	function forgotpass(){
		$post_data=$this->check_mandatory(array('username'));
		$query=$this->db->query("select * from users where username='".$post_data['username']."' ");
		$query=$query->result_array();
		if(sizeof($query)>0){
			$data['success'] = 1;
			$data['message'] = "Your password has been sent to your mail";
			$data['data']=$query;
			echo json_encode($data);

			$subject = "Password retrieve from on thesurveypoint.com";
			$message = "Hello  ".$data['data'][0]['name'].",<br/> Welcome to thesurveypoint.com and welcome.:<br/><br/>Please find the login details below:<br/><br/>";
			$message .= "<table width='100%' border='0' cellspacing='0' cellpadding='0'>
					<tr>
						<td width='10%'><strong>Email:</strong></td>
						<td width='90%'>".stripslashes($data['data'][0]['email'])."</td>
					</tr>
					<tr>
						<td width='10%'><strong>Username:</strong></td>
						<td width='90%'>".stripslashes($data['data'][0]['username'])."</td>
					</tr>
					<tr>
						<td><strong>Password:</strong></td>
						<td>".stripslashes($data['data'][0]['email'])."</td>
					</tr>
					</table>";
			$message .= "<br/><br/><strong>Warm Regards,</strong><br/>";
			$message .= "<br/><strong>Team - Customer Support</strong><br/>";
			$message .= "<br/>thesurveypoint.com<br/>";
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=windows-1254" . "\r\n";
			$headers .= "From: thesurveypoint.com <".$this->config->item('admin_email')."> \r\n";
			@mail($data['data'][0]['email'], $subject, $message, $headers);
		}else{
			$data['success'] = 0;
			$data['message'] = "Invalid user information";
			echo json_encode($data);
		}
		$this->logDesktop();
	}
	//url : http://www.thesurveypoint.com/desktop_api/sync/7
	function sync($p){
		$last_time='';
		$last_id='';
		$q0=$this->db->query("select id,donetime,work from synclog where tablename='synclog' order by id desc limit 0,1");
		if($q0->num_rows()>0){
			$q0=$q0->result_array();
			$last_time=$q0[0]['donetime'];
			$last_id=$q0[0]['id'];
			$d=array(
				'tablename' => 'synclog',
				'donetime' => time()
			);
			$this->db->insert('synclog', $d);
		}else{
			$d=array(
				'tablename' => 'synclog',
				'donetime' => time()
			);
			$this->db->insert('synclog', $d);
		}
		$table_key=array(
			'survey'=>'title_url',
			'survey_section'=>'title_url',
			'survey_data'=>'data_id',
			'survey_values'=>'survey_case_id',
			'users'=>'username'
		);
		if($last_time!=''){
			$q1=$this->db->query("select id,tablename as tn,columnname as cn,meta_primary_key as mpk, donetime as dt, work from synclog where tablename!='synclog' and donetime > '".$last_time."' and status='0' order by id asc ");
		}else{
			$q1=$this->db->query("select id,tablename as tn,columnname as cn,meta_primary_key as mpk, donetime as dt, work from synclog where tablename!='synclog' and status='0' order by id asc ");
		}
		$total=$q1->num_rows();
		if($total>0){
			$q_data=$q1->result_array();
			///print_r($q_data);
			$sync_data=array();
			foreach($q_data as $qd){
				//print_r($qd);
				$q2=$this->db->query("select ".$qd['cn']." from ".$qd['tn']." where ".$table_key[$qd['tn']]." = '".$qd['mpk']."' order by id asc limit 0,1");
				if($q2->num_rows()>0){
					$q2=$q2->result_array();
					//print_r($q2);
					$qd['data']=$q2[0][$qd['cn']];
					$new_sort_id=array();
					if($qd['cn']=="question_sort_id"){
						$temp_sort_id=$q2[0][$qd['cn']];
						$temp_sort_id=explode(',',$temp_sort_id);
						foreach($temp_sort_id as $tsi){
							$tmp=$this->db->query("select data_id from survey_data where id= '".$tsi."' ");
							if($tmp->num_rows()>0){
								$tmp=$tmp->result_array();
								array_push($new_sort_id,$tmp[0]['data_id']);
							}
						}
						$new_sort_id=implode(',',$new_sort_id);
						$qd['data']=$new_sort_id;
					}
				}
				array_push($sync_data,$qd);
			}
			if($last_time!=''){
				$data=array("username"=>$p,"last_time"=>$last_time,"data"=>$sync_data);
			}else{
				$data=array("username"=>$p,"last_time"=>"","data"=>$sync_data);
			}
			echo json_encode($data);
		}else{
			if($last_time!=''){
				$data=array("username"=>$p,"last_time"=>$last_time,"data"=>"");
			}else{
				$data=array("username"=>$p,"last_time"=>"","data"=>"");
			}
			echo json_encode($data);
		}
		$this->logDesktop();
	}
	function syncsend($u){
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
		$new_back_data=array();
		if(isset($new_data['data']) && is_array($new_data['data'])){
			$new_data=$new_data['data'];
			foreach($new_data as $nd){
				//$nd=(array) $nd;
				if($nd['work']!="delete"){
					$q1=$this->db->query("select donetime from synclog where tablename='".$nd['tn']."' and columnname='".$nd['cn']."' and meta_primary_key='".$nd['mpk']."' order by id desc limit 0,1 ");
					if($q1->num_rows()>0){
						//has last edited time
						$q1=$q1->result_array();
						if($nd['dt']>=$q1[0]['donetime']){
							//mine is new
							$this->db->query("update ".$nd['tn']." set ".$nd['cn']."='".addslashes($nd['data'])."' where ".$table_key[$nd['tn']]."='".$nd['mpk']."' ");
							$nd['changed']="0";
							$nd['changes']="Old";
						}else{
							//mine is old and collect new to sync back
							$q2=$this->db->query("select ".$nd['cn']." from ".$nd['tn']." where ".$table_key[$nd['tn']]."='".$nd['mpk']."' ");
							if($q2->num_rows()>0){
								$q2=$q2->result_array();
								//print_r($q2);
							}
							$nd['data']=$q2[0][$nd['cn']];
							$nd['changed']="1";
							$nd['changes']="Old";
							//print_r($nd);
						}
					}else{			
						//first time editing
						$q3=$this->db->query("select * from ".$nd['tn']." where ".$table_key[$nd['tn']]."='".$nd['mpk']."' ");
						if(!$q3->num_rows()>0){
							$d=array(
								$nd['cn'] => addslashes($nd['data']),
								'add_date' => time()
							);
							$this->db->insert($nd['tn'], $d);
						}else{
							$this->db->query("update ".$nd['tn']." set ".$nd['cn']."='".addslashes($nd['data'])."' where ".$table_key[$nd['tn']]."='".$nd['mpk']."' ");
							
							if($nd['tn']=="survey" && $nd['cn']=="user_id"){
								$q4=$this->db->query("select * from users where username='".$username."' limit 0,1 ");
								if($q4->num_rows()>0){
									$q4=$q4->result_array();
									$q4=$q4[0];
									$this->db->query("update survey set ".$nd['cn']."='".$q4['id']."' where title_url='".$nd['mpk']."' ");
								}
							}

							if($nd['tn']=="survey_section" && $nd['cn']=="survey_id"){
								$q4=$this->db->query("select * from survey_section where title_url='".$nd['mpk']."' limit 0,1 ");
								if($q4->num_rows()>0){
									$q4=$q4->result_array();
									$q4=$q4[0];
									$insert_id=$q4['id'];
									$q5=$this->db->query("select * from survey where title_url='".$nd['data']."' limit 0,1 ");
									if($q5->num_rows()>0){
										$q5=$q5->result_array();
										$q5=$q5[0];
										if($q5['section_sort_id']!=''){
											$q5['section_sort_id']=explode(",",$q5['section_sort_id']);
											if(!in_array($insert_id,$q5['section_sort_id'])){
												array_push($q5['section_sort_id'],$insert_id);
											}
											$q5['section_sort_id']=implode(",",$q5['section_sort_id']);
										}else{
											$q5['section_sort_id']=$insert_id;
										}
										$this->db->query("update survey set section_sort_id='".$q5['section_sort_id']."' where title_url='".$nd['data']."' ");
									}
								}
							}

							if($nd['tn']=="survey_data" && $nd['cn']=="survey_id"){
								$q4=$this->db->query("select * from survey_data where data_id='".$nd['mpk']."' limit 0,1 ");
								if($q4->num_rows()>0){
									$q4=$q4->result_array();
									$q4=$q4[0];
									$insert_id=$q4['id'];
									$q5=$this->db->query("select * from survey_section where title_url='".$nd['data']."' limit 0,1 ");
									if($q5->num_rows()>0){
										$q5=$q5->result_array();
										$q5=$q5[0];
										if($q5['question_sort_id']!=''){
											$q5['question_sort_id']=explode(",",$q5['question_sort_id']);
											if(!in_array($insert_id,$q5['question_sort_id'])){
												array_push($q5['question_sort_id'],$insert_id);
											}
											$q5['question_sort_id']=implode(",",$q5['question_sort_id']);
										}else{
											$q5['question_sort_id']=$insert_id;
										}
										$this->db->query("update survey_section set question_sort_id='".$q5['question_sort_id']."' where title_url='".$nd['data']."' ");
									}
								}
							}

						}
						$nd['changed']="0";
						$nd['changes']="Old";
					}
					$nd=(object) $nd;
					array_push($new_back_data,$nd);
				}else{
					//deletion case
					$this->db->query("delete from ".$nd['tn']." where ".$table_key[$nd['tn']]."='".$nd['mpk']."' ");
					$nd['changed']="0";
					$nd['changes']="Remove";
				}
			}
		}
		/* collect updates that is new from online to desktop*/
		if($last_time!=''){
			$q4=$this->db->query("select id from synclog where donetime>'".$last_time."' order by id asc limit 0,1 ");
			if($q4->num_rows()>0){
				$q4=$q4->result_array();
				$last_id=$q4[0]['id'];
			}
			
			$q4=$this->db->query("select id,tablename as tn,columnname as cn,meta_primary_key as mpk, donetime as dt, work from synclog where id> '".$last_id."' order by id asc ");
		}else{
			$q4=$this->db->query("select id,tablename as tn,columnname as cn,meta_primary_key as mpk, donetime as dt, work from synclog where tablename!='synclog' order by id asc ");
		}
		$q4_total=$q4->num_rows();
		$q4_sync_data=array();
		if($q4_total>0){
			$q4_data=$q4->result_array();
			foreach($q4_data as $qd){
				if($qd['work']!="delete"){
					//print_r($qd);
					$q2=$this->db->query("select ".$qd['cn']." from ".$qd['tn']." where ".$table_key[$qd['tn']]." = '".$qd['mpk']."' order by id desc limit 0,1");
					if($q2->num_rows()>0){
						$q2=$q2->result_array();
						//print_r($q2);
						$qd['data']=$q2[0][$qd['cn']];
						$qd['changed']="1";
						$qd['changes']="New";
					}
				}else{
					//deletion case
					$qd['changed']="1";
					$qd['changes']="Remove";
				}
				array_push($q4_sync_data,$qd);
			}
			//echo json_encode($q4_sync_data);	
		}
		$new_back_data=array_merge($new_back_data,$q4_sync_data);
		echo json_encode($new_back_data);
		$this->logDesktop();
	}
	function syncget($username){
		$d=array(
			'tablename' => 'synclog',
			'donetime' => time()
		);
		//$this->db->insert('synclog', $d);
		
		$table_key=array(
			'survey'=>'title_url',
			'survey_section'=>'title_url',
			'survey_data'=>'data_id',
			'survey_values'=>'survey_case_id',
			'users'=>'username'
		);
		$post_data=(array) json_decode($this->input->post('data'));
		$new_data= $post_data['updates'];
		$new_surveys= $post_data['surveys'];
		if(sizeof($new_data)>0){
			foreach($new_data as $nd){
				$nd=(array) $nd;
				$nd['data']=str_replace("'",'"',$nd['data']);
			
				if($nd['changed']=="1"){
					if($nd['changes']=="New"){
						//print_r($nd);
						$q3=$this->db->query("select * from ".$nd['tn']." where ".$table_key[$nd['tn']]."='".$nd['mpk']."' ");
						if(!$q3->num_rows()>0){
							$d=array(
								$nd['cn'] => addslashes($nd['data']),
								'add_date' => time()
							);
							$this->db->insert($nd['tn'], $d);
							//echo $this->db->last_query();

							if($nd['tn']=="survey_section" && $nd['cn']=="survey_id"){
								$q4=$this->db->query("select * from survey_section where title_url='".$nd['mpk']."' limit 0,1 ");
								if($q4->num_rows()>0){
									$q4=$q4->result_array();
									$q4=$q4[0];
									$insert_id=$q4['id'];
									$q5=$this->db->query("select * from survey where title_url='".$nd['data']."' limit 0,1 ");
									if($q5->num_rows()>0){
										$q5=$q5->result_array();
										$q5=$q5[0];
										if($q5['section_sort_id']!=''){
											$q5['section_sort_id']=explode(",",$q5['section_sort_id']);
											if(!in_array($insert_id,$q5['section_sort_id'])){
												array_push($q5['section_sort_id'],$insert_id);
											}
											$q5['section_sort_id']=implode(",",$q5['section_sort_id']);
										}else{
											$q5['section_sort_id']=$insert_id;
										}
										$this->db->query("update survey set section_sort_id='".$q5['section_sort_id']."' where title_url='".$nd['data']."' ");
										echo $this->db->last_query();
									}
								}
							}
							if($nd['tn']=="survey_data" && $nd['cn']=="survey_id"){
								$q4=$this->db->query("select * from survey_data where data_id='".$nd['mpk']."' limit 0,1 ");
								if($q4->num_rows()>0){
									$q4=$q4->result_array();
									$q4=$q4[0];
									$insert_id=$q4['id'];
									$q5=$this->db->query("select * from survey_section where title_url='".$nd['data']."' limit 0,1 ");
									if($q5->num_rows()>0){
										$q5=$q5->result_array();
										$q5=$q5[0];
										if($q5['question_sort_id']!=''){
											$q5['question_sort_id']=explode(",",$q5['question_sort_id']);
											if(!in_array($insert_id,$q5['question_sort_id'])){
												array_push($q5['question_sort_id'],$insert_id);
											}
											$q5['question_sort_id']=implode(",",$q5['question_sort_id']);
										}else{
											$q5['question_sort_id']=$insert_id;
										}
										$this->db->query("update survey_section set question_sort_id='".$q5['question_sort_id']."' where title_url='".$nd['data']."' ");
										echo $this->db->last_query();
									}
								}
							}

						}else{
							$nd['data']=$nd['data'];
							$data = array(
								$nd['cn']=>$nd['data']
							);
							$this->db->where($table_key[$nd['tn']],$nd['mpk']);
							$this->db->update($nd['tn'],$data);	
							//echo $this->db->last_query();

							if($nd['tn']=="survey_section" && $nd['cn']=="survey_id"){
								$q4=$this->db->query("select * from survey_section where title_url='".$nd['mpk']."' limit 0,1 ");
								if($q4->num_rows()>0){
									$q4=$q4->result_array();
									$q4=$q4[0];
									$insert_id=$q4['id'];
									$q5=$this->db->query("select * from survey where title_url='".$nd['data']."' limit 0,1 ");
									if($q5->num_rows()>0){
										$q5=$q5->result_array();
										$q5=$q5[0];
										if($q5['section_sort_id']!=''){
											$q5['section_sort_id']=explode(",",$q5['section_sort_id']);
											if(!in_array($insert_id,$q5['section_sort_id'])){
												array_push($q5['section_sort_id'],$insert_id);
											}
											$q5['section_sort_id']=implode(",",$q5['section_sort_id']);
										}else{
											$q5['section_sort_id']=$insert_id;
										}
										$this->db->query("update survey set section_sort_id='".$q5['section_sort_id']."' where title_url='".$nd['data']."' ");
										echo $this->db->last_query();
									}
								}
							}
							if($nd['tn']=="survey_data" && $nd['cn']=="survey_id"){
								$q4=$this->db->query("select * from survey_data where data_id='".$nd['mpk']."' limit 0,1 ");
								if($q4->num_rows()>0){
									$q4=$q4->result_array();
									$q4=$q4[0];
									$insert_id=$q4['id'];
									$q5=$this->db->query("select * from survey_section where title_url='".$nd['data']."' limit 0,1 ");
									if($q5->num_rows()>0){
										$q5=$q5->result_array();
										$q5=$q5[0];
										if($q5['question_sort_id']!=''){
											$q5['question_sort_id']=explode(",",$q5['question_sort_id']);
											if(!in_array($insert_id,$q5['question_sort_id'])){
												array_push($q5['question_sort_id'],$insert_id);
											}
											$q5['question_sort_id']=implode(",",$q5['question_sort_id']);
										}else{
											$q5['question_sort_id']=$insert_id;
										}
										$this->db->query("update survey_section set question_sort_id='".$q5['question_sort_id']."' where title_url='".$nd['data']."' ");
										echo $this->db->last_query();
									}
								}
							}
							if($nd['tn']=="survey_section" && $nd['cn']=="question_sort_id"){
								$temp_sort_id=$nd['data'];
								$temp_sort_id=explode(',',$temp_sort_id);
								$new_sort_id=array();	
								foreach($temp_sort_id as $tsi){
									$tmp=$this->db->query("select id from survey_data where data_id='".$tsi."' ");
									if($tmp->num_rows()>0){
										$tmp=$tmp->result_array();
										array_push($new_sort_id,$tmp[0]['id']);
									}
								}	
								$new_sort_id=implode(',',$new_sort_id);	
								$this->db->query("update survey_section set question_sort_id='".$new_sort_id."' where title_url='".$nd['mpk']."' ");
							}
						}
					}
					if($nd['changes']=="Old"){
						$nd['data']=$nd['data'];
						if($nd['cn']=="code"){
							$nd['data']=str_replace("'",'"',$nd['data']);	
						}
						$data = array(
							$nd['cn']=>$nd['data']
						);
						$this->db->where($table_key[$nd['tn']],$nd['mpk']);
						$this->db->update($nd['tn'],$data);
						echo $this->db->last_query();
					}
					if($nd['changes']=="Remove"){
						//deletion case

						if($nd['tn']=="survey_section" && $nd['cn']=="title_url"){
							$q4=$this->db->query("select * from survey_section where title_url='".$nd['mpk']."' limit 0,1 ");
							if($q4->num_rows()>0){
								$q4=$q4->result_array();
								$q4=$q4[0];
								$insert_id=$q4['id'];
								$q5=$this->db->query("select * from survey where title_url='".$q4['survey_id']."' limit 0,1 ");
								if($q5->num_rows()>0){
									$q5=$q5->result_array();
									$q5=$q5[0];
									if($q5['section_sort_id']!=''){
										$q5['section_sort_id']=explode(",",$q5['section_sort_id']);
										if(in_array($insert_id,$q5['section_sort_id'])){
											$q5ssi_new=array();
											foreach($q5['section_sort_id'] as $q5ssi){
												if($q5ssi!=$insert_id){
													array_push($q5ssi_new,$q5ssi);
												}
											}
											$q5['section_sort_id']=implode(",",$q5ssi_new);
										}
									}
									$this->db->query("update survey set section_sort_id='".$q5['section_sort_id']."' where title_url='".$q4['survey_id']."' ");
									echo $this->db->last_query();
								}
							}
						}
						if($nd['tn']=="survey_data" && $nd['cn']=="data_id"){
							$q4=$this->db->query("select * from survey_data where data_id='".$nd['mpk']."' limit 0,1 ");
							if($q4->num_rows()>0){
								$q4=$q4->result_array();
								$q4=$q4[0];
								$insert_id=$q4['id'];
								$q5=$this->db->query("select * from survey_section where title_url='".$q4['survey_id']."' limit 0,1 ");
								if($q5->num_rows()>0){
									$q5=$q5->result_array();
									$q5=$q5[0];
									if($q5['question_sort_id']!=''){
										$q5['question_sort_id']=explode(",",$q5['question_sort_id']);
										if(in_array($insert_id,$q5['question_sort_id'])){
											$q5qsi_new=array();
											foreach($q5['question_sort_id'] as $q5qsi){
												if($q5qsi!=$insert_id){
													array_push($q5qsi_new,$q5qsi);
												}
											}
											$q5['question_sort_id']=implode(",",$q5qsi_new);
										}
									}
									$this->db->query("update survey_section set question_sort_id='".$q5['question_sort_id']."' where title_url='".$q4['survey_id']."' ");
									echo $this->db->last_query();
								}
							}
						}					

						$this->db->query("delete from ".$nd['tn']." where ".$table_key[$nd['tn']]."='".$nd['mpk']."' ");
						echo $this->db->last_query();
					}
				}else{
					//print_r($nd);
				}
			}
		}
		if(sizeof($new_surveys)>0){
			//updating new surveys with permissions
			$survey=$new_surveys->survey;
			$survey_section=$new_surveys->survey_section;
			$survey_data=$new_surveys->survey_data;
			$sda=array();
			$ssa=array();		

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
							'status' => $s['status']
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
		}
		echo json_encode(array("username"=>$username,"updated"=>"yes"));
		$this->logDesktop();
	}
	function syncgetsecond($username){
		$d=array(
			'tablename' => 'synclog',
			'donetime' => time()
		);
		//$this->db->insert('synclog', $d);
		
		$table_key=array(
			'survey'=>'title_url',
			'survey_section'=>'title_url',
			'survey_data'=>'data_id',
			'survey_values'=>'survey_case_id',
			'users'=>'username'
		);
		$post_data=(array) json_decode($this->input->post('data'));
		$new_data= $post_data['updates'];
		$new_surveys= $post_data['surveys'];
		if(sizeof($new_data)>0){
			foreach($new_data as $nd){
				$nd=(array) $nd;
				$nd['data']=str_replace("'",'"',$nd['data']);
			
				if($nd['changed']=="1"){
					if($nd['changes']=="New"){
						//print_r($nd);
						$q3=$this->db->query("select * from ".$nd['tn']." where ".$table_key[$nd['tn']]."='".$nd['mpk']."' ");
						if(!$q3->num_rows()>0){
							$d=array(
								$nd['cn'] => addslashes($nd['data']),
								'add_date' => time()
							);
							$this->db->insert($nd['tn'], $d);
							//echo $this->db->last_query();

							if($nd['tn']=="survey_section" && $nd['cn']=="survey_id"){
								$q4=$this->db->query("select * from survey_section where title_url='".$nd['mpk']."' limit 0,1 ");
								if($q4->num_rows()>0){
									$q4=$q4->result_array();
									$q4=$q4[0];
									$insert_id=$q4['id'];
									$q5=$this->db->query("select * from survey where title_url='".$nd['data']."' limit 0,1 ");
									if($q5->num_rows()>0){
										$q5=$q5->result_array();
										$q5=$q5[0];
										if($q5['section_sort_id']!=''){
											$q5['section_sort_id']=explode(",",$q5['section_sort_id']);
											if(!in_array($insert_id,$q5['section_sort_id'])){
												array_push($q5['section_sort_id'],$insert_id);
											}
											$q5['section_sort_id']=implode(",",$q5['section_sort_id']);
										}else{
											$q5['section_sort_id']=$insert_id;
										}
										$this->db->query("update survey set section_sort_id='".$q5['section_sort_id']."' where title_url='".$nd['data']."' ");
										echo $this->db->last_query();
									}
								}
							}
							if($nd['tn']=="survey_data" && $nd['cn']=="survey_id"){
								$q4=$this->db->query("select * from survey_data where data_id='".$nd['mpk']."' limit 0,1 ");
								if($q4->num_rows()>0){
									$q4=$q4->result_array();
									$q4=$q4[0];
									$insert_id=$q4['id'];
									$q5=$this->db->query("select * from survey_section where title_url='".$nd['data']."' limit 0,1 ");
									if($q5->num_rows()>0){
										$q5=$q5->result_array();
										$q5=$q5[0];
										if($q5['question_sort_id']!=''){
											$q5['question_sort_id']=explode(",",$q5['question_sort_id']);
											if(!in_array($insert_id,$q5['question_sort_id'])){
												array_push($q5['question_sort_id'],$insert_id);
											}
											$q5['question_sort_id']=implode(",",$q5['question_sort_id']);
										}else{
											$q5['question_sort_id']=$insert_id;
										}
										$this->db->query("update survey_section set question_sort_id='".$q5['question_sort_id']."' where title_url='".$nd['data']."' ");
										echo $this->db->last_query();
									}
								}
							}

						}else{
							$nd['data']=$nd['data'];
							$data = array(
								$nd['cn']=>$nd['data']
							);
							$this->db->where($table_key[$nd['tn']],$nd['mpk']);
							$this->db->update($nd['tn'],$data);	
							//echo $this->db->last_query();

							if($nd['tn']=="survey_section" && $nd['cn']=="survey_id"){
								$q4=$this->db->query("select * from survey_section where title_url='".$nd['mpk']."' limit 0,1 ");
								if($q4->num_rows()>0){
									$q4=$q4->result_array();
									$q4=$q4[0];
									$insert_id=$q4['id'];
									$q5=$this->db->query("select * from survey where title_url='".$nd['data']."' limit 0,1 ");
									if($q5->num_rows()>0){
										$q5=$q5->result_array();
										$q5=$q5[0];
										if($q5['section_sort_id']!=''){
											$q5['section_sort_id']=explode(",",$q5['section_sort_id']);
											if(!in_array($insert_id,$q5['section_sort_id'])){
												array_push($q5['section_sort_id'],$insert_id);
											}
											$q5['section_sort_id']=implode(",",$q5['section_sort_id']);
										}else{
											$q5['section_sort_id']=$insert_id;
										}
										$this->db->query("update survey set section_sort_id='".$q5['section_sort_id']."' where title_url='".$nd['data']."' ");
										echo $this->db->last_query();
									}
								}
							}
							if($nd['tn']=="survey_data" && $nd['cn']=="survey_id"){
								$q4=$this->db->query("select * from survey_data where data_id='".$nd['mpk']."' limit 0,1 ");
								if($q4->num_rows()>0){
									$q4=$q4->result_array();
									$q4=$q4[0];
									$insert_id=$q4['id'];
									$q5=$this->db->query("select * from survey_section where title_url='".$nd['data']."' limit 0,1 ");
									if($q5->num_rows()>0){
										$q5=$q5->result_array();
										$q5=$q5[0];
										if($q5['question_sort_id']!=''){
											$q5['question_sort_id']=explode(",",$q5['question_sort_id']);
											if(!in_array($insert_id,$q5['question_sort_id'])){
												array_push($q5['question_sort_id'],$insert_id);
											}
											$q5['question_sort_id']=implode(",",$q5['question_sort_id']);
										}else{
											$q5['question_sort_id']=$insert_id;
										}
										$this->db->query("update survey_section set question_sort_id='".$q5['question_sort_id']."' where title_url='".$nd['data']."' ");
										echo $this->db->last_query();
									}
								}
							}
							if($nd['tn']=="survey_section" && $nd['cn']=="question_sort_id"){
								$temp_sort_id=$nd['data'];
								$temp_sort_id=explode(',',$temp_sort_id);
								$new_sort_id=array();	
								foreach($temp_sort_id as $tsi){
									$tmp=$this->db->query("select id from survey_data where data_id='".$tsi."' ");
									if($tmp->num_rows()>0){
										$tmp=$tmp->result_array();
										array_push($new_sort_id,$tmp[0]['id']);
									}
								}	
								$new_sort_id=implode(',',$new_sort_id);	
								$this->db->query("update survey_section set question_sort_id='".$new_sort_id."' where title_url='".$nd['mpk']."' ");
							}
						}
					}
					if($nd['changes']=="Old"){
						$nd['data']=$nd['data'];
						if($nd['cn']=="code"){
							$nd['data']=str_replace("'",'"',$nd['data']);	
						}
						$data = array(
							$nd['cn']=>$nd['data']
						);
						$this->db->where($table_key[$nd['tn']],$nd['mpk']);
						$this->db->update($nd['tn'],$data);
						echo $this->db->last_query();
					}
					if($nd['changes']=="Remove"){
						//deletion case

						if($nd['tn']=="survey_section" && $nd['cn']=="title_url"){
							$q4=$this->db->query("select * from survey_section where title_url='".$nd['mpk']."' limit 0,1 ");
							if($q4->num_rows()>0){
								$q4=$q4->result_array();
								$q4=$q4[0];
								$insert_id=$q4['id'];
								$q5=$this->db->query("select * from survey where title_url='".$q4['survey_id']."' limit 0,1 ");
								if($q5->num_rows()>0){
									$q5=$q5->result_array();
									$q5=$q5[0];
									if($q5['section_sort_id']!=''){
										$q5['section_sort_id']=explode(",",$q5['section_sort_id']);
										if(in_array($insert_id,$q5['section_sort_id'])){
											$q5ssi_new=array();
											foreach($q5['section_sort_id'] as $q5ssi){
												if($q5ssi!=$insert_id){
													array_push($q5ssi_new,$q5ssi);
												}
											}
											$q5['section_sort_id']=implode(",",$q5ssi_new);
										}
									}
									$this->db->query("update survey set section_sort_id='".$q5['section_sort_id']."' where title_url='".$q4['survey_id']."' ");
									echo $this->db->last_query();
								}
							}
						}
						if($nd['tn']=="survey_data" && $nd['cn']=="data_id"){
							$q4=$this->db->query("select * from survey_data where data_id='".$nd['mpk']."' limit 0,1 ");
							if($q4->num_rows()>0){
								$q4=$q4->result_array();
								$q4=$q4[0];
								$insert_id=$q4['id'];
								$q5=$this->db->query("select * from survey_section where title_url='".$q4['survey_id']."' limit 0,1 ");
								if($q5->num_rows()>0){
									$q5=$q5->result_array();
									$q5=$q5[0];
									if($q5['question_sort_id']!=''){
										$q5['question_sort_id']=explode(",",$q5['question_sort_id']);
										if(in_array($insert_id,$q5['question_sort_id'])){
											$q5qsi_new=array();
											foreach($q5['question_sort_id'] as $q5qsi){
												if($q5qsi!=$insert_id){
													array_push($q5qsi_new,$q5qsi);
												}
											}
											$q5['question_sort_id']=implode(",",$q5qsi_new);
										}
									}
									$this->db->query("update survey_section set question_sort_id='".$q5['question_sort_id']."' where title_url='".$q4['survey_id']."' ");
									echo $this->db->last_query();
								}
							}
						}					

						$this->db->query("delete from ".$nd['tn']." where ".$table_key[$nd['tn']]."='".$nd['mpk']."' ");
						echo $this->db->last_query();
					}
				}else{
					//print_r($nd);
				}
			}
		}
		if(sizeof((array) $new_surveys)>0){
			//updating new surveys with permissions
			$survey=$new_surveys->survey;
			$survey_section=$new_surveys->survey_section;
			$survey_data=$new_surveys->survey_data;
			$sda=array();
			$ssa=array();		

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
							'status' => $s['status']
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
		}
		echo json_encode(array("username"=>$username,"updated"=>"yes"));		
		$this->logDesktop();
	}
	function syncstatusupdate($id){
		$data=array(
			'status' => '1'
		);
		$this->Synclog_model->update_synclog_by_id($id,$data);	
		echo $this->db->last_query();
		$this->logDesktop();
	}
	function syncsendsingle($u){
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
		$new_back_data=array();
		if(isset($new_data['data']) && is_array($new_data['data'])){
			$new_data=$new_data['data'];
			foreach($new_data as $nd){
				if(!(isset($nd['data']))){$nd['data']="Blank";}
				//$nd=(array) $nd;
				if($nd['work']!="delete"){
					$q1=$this->db->query("select donetime from synclog where tablename='".$nd['tn']."' and columnname='".$nd['cn']."' and meta_primary_key='".$nd['mpk']."' order by id desc limit 0,1 ");
					if($q1->num_rows()>0){
						//has last edited time
						$q1=$q1->result_array();
						if($nd['dt']>=$q1[0]['donetime']){
							//mine is new
							$nd['data']=$nd['data'];
							if($nd['cn']=="code"){
							$nd['data']=str_replace("'",'"',$nd['data']);	
							}
							$data = array(
								$nd['cn']=>$nd['data']
							);
							$this->db->where($table_key[$nd['tn']],$nd['mpk']);
							$this->db->update($nd['tn'],$data);							
							$nd['changed']="0";
							$nd['changes']="Old";
						}else{
							//mine is old and collect new to sync back
							$q2=$this->db->query("select ".$nd['cn']." from ".$nd['tn']." where ".$table_key[$nd['tn']]."='".$nd['mpk']."' ");
							if($q2->num_rows()>0){
								$q2=$q2->result_array();
								//print_r($q2);
							}
							$nd['data']=$q2[0][$nd['cn']];
							$nd['changed']="1";
							$nd['changes']="Old";
							//print_r($nd);
						}
					}else{			
						//first time adding
						$q3=$this->db->query("select * from ".$nd['tn']." where ".$table_key[$nd['tn']]."='".$nd['mpk']."' ");
						if(!$q3->num_rows()>0){
							if(!isset($nd['data'])){$nd['data']="For Deleting";}
							$d=array(
								$nd['cn'] => addslashes($nd['data']),
								'add_date' => time()
							);
							$this->db->insert($nd['tn'], $d);
							
							if($nd['tn']=="survey_section" && $nd['cn']=="question_sort_id"){
								$temp_sort_id=$nd['data'];
								$temp_sort_id=explode(',',$temp_sort_id);
								$new_sort_id=array();	
								foreach($temp_sort_id as $tsi){
									$tmp=$this->db->query("select id from survey_data where data_id='".$tsi."' ");
									if($tmp->num_rows()>0){
										$tmp=$tmp->result_array();
										array_push($new_sort_id,$tmp[0]['id']);
									}
								}	
								$new_sort_id=implode(',',$new_sort_id);
								$this->db->query("update survey_section set question_sort_id='".$new_sort_id."' where title_url='".$nd['mpk']."' ");								
							}
							
						}else{
							$nd['data']=$nd['data'];
							if($nd['cn']=="code"){
							$nd['data']=str_replace("'",'"',$nd['data']);	
							}
							$data = array(
								$nd['cn']=>$nd['data']
							);
							$this->db->where($table_key[$nd['tn']],$nd['mpk']);
							$this->db->update($nd['tn'],$data);	
							if($nd['cn']=="qtype"){
								//echo $this->db->last_query();
							}
							
							if($nd['tn']=="survey" && $nd['cn']=="user_id"){
								$q4=$this->db->query("select * from users where username='".$username."' limit 0,1 ");
								if($q4->num_rows()>0){
									$q4=$q4->result_array();
									$q4=$q4[0];
									$this->db->query("update survey set ".$nd['cn']."='".$q4['id']."' where title_url='".$nd['mpk']."' ");
								}
							}

							if($nd['tn']=="survey_section" && $nd['cn']=="survey_id"){
								$q4=$this->db->query("select * from survey_section where title_url='".$nd['mpk']."' limit 0,1 ");
								if($q4->num_rows()>0){
									$q4=$q4->result_array();
									$q4=$q4[0];
									$insert_id=$q4['id'];
									$q5=$this->db->query("select * from survey where title_url='".$nd['data']."' limit 0,1 ");
									if($q5->num_rows()>0){
										$q5=$q5->result_array();
										$q5=$q5[0];
										if($q5['section_sort_id']!=''){
											$q5['section_sort_id']=explode(",",$q5['section_sort_id']);
											if(!in_array($insert_id,$q5['section_sort_id'])){
												array_push($q5['section_sort_id'],$insert_id);
											}
											$q5['section_sort_id']=implode(",",$q5['section_sort_id']);
										}else{
											$q5['section_sort_id']=$insert_id;
										}
										$this->db->query("update survey set section_sort_id='".$q5['section_sort_id']."' where title_url='".$nd['data']."' ");
									}
								}
							}

							if($nd['tn']=="survey_data" && $nd['cn']=="survey_id"){
								$q4=$this->db->query("select * from survey_data where data_id='".$nd['mpk']."' limit 0,1 ");
								if($q4->num_rows()>0){
									$q4=$q4->result_array();
									$q4=$q4[0];
									$insert_id=$q4['id'];
									$q5=$this->db->query("select * from survey_section where title_url='".$nd['data']."' limit 0,1 ");
									if($q5->num_rows()>0){
										$q5=$q5->result_array();
										$q5=$q5[0];
										if($q5['question_sort_id']!=''){
											$q5['question_sort_id']=explode(",",$q5['question_sort_id']);
											if(!in_array($insert_id,$q5['question_sort_id'])){
												array_push($q5['question_sort_id'],$insert_id);
											}
											$q5['question_sort_id']=implode(",",$q5['question_sort_id']);
										}else{
											$q5['question_sort_id']=$insert_id;
										}
										$this->db->query("update survey_section set question_sort_id='".$q5['question_sort_id']."' where title_url='".$nd['data']."' ");
									}
								}
							}

							if($nd['tn']=="survey_section" && $nd['cn']=="question_sort_id"){
								$temp_sort_id=$nd['data'];
								$temp_sort_id=explode(',',$temp_sort_id);
								$new_sort_id=array();	
								foreach($temp_sort_id as $tsi){
									$tmp=$this->db->query("select id from survey_data where data_id='".$tsi."' ");
									if($tmp->num_rows()>0){
										$tmp=$tmp->result_array();
										array_push($new_sort_id,$tmp[0]['id']);
									}
								}	
								$new_sort_id=implode(',',$new_sort_id);
								$this->db->query("update survey_section set question_sort_id='".$new_sort_id."' where title_url='".$nd['mpk']."' ");								
							}
							
						}
						$nd['changed']="0";
						$nd['changes']="Old";
					}
					$nd=(object) $nd;
					array_push($new_back_data,$nd);
				}else{
					//deletion case
					if($nd['tn']=="survey_section" && $nd['cn']=="title_url"){
						$q4=$this->db->query("select * from survey_section where title_url='".$nd['mpk']."' limit 0,1 ");
						if($q4->num_rows()>0){
							$q4=$q4->result_array();
							$q4=$q4[0];
							$insert_id=$q4['id'];
							$q5=$this->db->query("select * from survey where title_url='".$q4['survey_id']."' limit 0,1 ");
							if($q5->num_rows()>0){
								$q5=$q5->result_array();
								$q5=$q5[0];
								if($q5['section_sort_id']!=''){
									$q5['section_sort_id']=explode(",",$q5['section_sort_id']);
									if(in_array($insert_id,$q5['section_sort_id'])){
										$q5ssi_new=array();
										foreach($q5['section_sort_id'] as $q5ssi){
											if($q5ssi!=$insert_id){
												array_push($q5ssi_new,$q5ssi);
											}
										}
										$q5['section_sort_id']=implode(",",$q5ssi_new);
									}
								}
								$this->db->query("update survey set section_sort_id='".$q5['section_sort_id']."' where title_url='".$q4['survey_id']."' ");
							}
						}
					}
					if($nd['tn']=="survey_data" && $nd['cn']=="data_id"){
						$q4=$this->db->query("select * from survey_data where data_id='".$nd['mpk']."' limit 0,1 ");
						if($q4->num_rows()>0){
							$q4=$q4->result_array();
							$q4=$q4[0];
							$insert_id=$q4['id'];
							$q5=$this->db->query("select * from survey_section where title_url='".$q4['survey_id']."' limit 0,1 ");
							if($q5->num_rows()>0){
								$q5=$q5->result_array();
								$q5=$q5[0];
								if($q5['question_sort_id']!=''){
									$q5['question_sort_id']=explode(",",$q5['question_sort_id']);
									if(in_array($insert_id,$q5['question_sort_id'])){
										$q5qsi_new=array();
										foreach($q5['question_sort_id'] as $q5qsi){
											if($q5qsi!=$insert_id){
												array_push($q5qsi_new,$q5qsi);
											}
										}
										$q5['question_sort_id']=implode(",",$q5qsi_new);
									}
								}
								$this->db->query("update survey_section set question_sort_id='".$q5['question_sort_id']."' where title_url='".$q4['survey_id']."' ");
							}
						}
					}					

					$this->db->query("delete from ".$nd['tn']." where ".$table_key[$nd['tn']]."='".$nd['mpk']."' ");
					$nd['changed']="0";
					$nd['changes']="Remove";
					
					$nd=(object) $nd;
					array_push($new_back_data,$nd);					
				}
			}
		}
		echo json_encode($new_back_data);
		$this->logDesktop();
	}
	public function syncreceive($u){
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
		//$new_back_data=array();
		
		/* collect updates that is new from online to desktop*/
		$survey_section_question_ids=array();
			$this->db->where('username', $username);
			$this->db->where('status', '1');
			$queryu = $this->db->get('users');		
			if($queryu->num_rows()>0){
				$queryu=$queryu->result_array();
					$querys=$this->db->query("select * from survey where user_id='".$queryu[0]['id']."' || permission_design like '%".$queryu[0]['username']."%' || permission_fill like '%".$queryu[0]['username']."%' || permission_analytics like '%".$queryu[0]['username']."%'  ");
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
			$q4=$this->db->query("select id,tablename as tn,columnname as cn,meta_primary_key as mpk, donetime as dt, work from synclog where tablename!='synclog' and donetime>'".$last_time."' order by id asc ");
		}else{
			$q4=$this->db->query("select id,tablename as tn,columnname as cn,meta_primary_key as mpk, donetime as dt, work from synclog where tablename!='synclog' order by id asc ");
		}
		$q4_sync_data=array();
		if($q4->num_rows()>0){
			$q4_data=$q4->result_array();
			foreach($q4_data as $qd){
				$qd_new=array();
				if($qd['work']!="delete"){
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
							$qd_new['work']=$qd['work'];
							//$qd_new['data']=$q2[0][$qd['cn']];
							
							$qd_new['data']=$q2[0][$qd['cn']];
							if($qd['cn']=="question_sort_id"){
								$temp_sort_id=$q2[0][$qd['cn']];
								$temp_sort_id=explode(',',$temp_sort_id);
								$new_sort_id=array();
								foreach($temp_sort_id as $tsi){
									$tmp=$this->db->query("select data_id from survey_data where id= '".$tsi."' ");
									if($tmp->num_rows()>0){
										$tmp=$tmp->result_array();
										array_push($new_sort_id,$tmp[0]['data_id']);
									}
								}
								$new_sort_id=implode(',',$new_sort_id);
								$qd_new['data']=$new_sort_id;							
							}
							
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
					$qd_new['work']=$qd['work'];
					$qd_new['data']=$qd['mpk'];		//added data for remove
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
		echo json_encode(array('updates'=>$q4_sync_data,'surveys'=>array()));
		$this->logDesktop();
	}	
	public function license_check($license){
		$data=array(
			'license_key' => $this->input->post('license_key'),
			'license_key_date' => time()
		);
		$this->User_model->update_user_by_username($this->input->post('username'),$data);
		
		/* recording events*/
		$data_sync = array(
			'tablename' => 'users',
			'columnname' => 'license_key',
			'meta_primary_key' => $this->input->post('username'),
			'donetime' => time()
		);
		$this->Synclog_model->store_synclog($data_sync);
		$data_sync = array(
			'tablename' => 'users',
			'columnname' => 'license_key_date',
			'meta_primary_key' => $this->input->post('username'),
			'donetime' => time()
		);
		$this->Synclog_model->store_synclog($data_sync);
		/* recording events*/
		
		$data['username']=$this->input->post('username');
		echo json_encode($data);
		$this->logDesktop();
	}
	function registerDirectRespondent(){
		$post_data=$this->check_mandatory(array('username','name','email','contact','age','gender','location'));
		$post_data['password']=$this->randomString(20,'');
		$query=$this->db->query("select * from users where username='".$post_data['username']."' order by id desc limit 0,1 ");
		$query=$query->result_array();
		if(!sizeof($query)>0){
			$this->db->query("insert into users set username='".$post_data['username']."', name='".$post_data['name']."', email='".$post_data['email']."', password='".$post_data['password']."', contact='".$post_data['contact']."', age='".$post_data['age']."', gender='".$post_data['gender']."', location='".$post_data['location']."', add_date='".time()."' ");
			$query=$this->db->query("select * from users where id='".$this->db->insert_id()."' ");
			$data['success'] = 1;
			$data['message'] = "Your account has been created please login.";
			$query=$query->result_array();
			$data['data']=$query;
			echo json_encode($data);
			//print_r($query);
			$data1 = array(
				'user_logged_id' => $query[0]['id'],
				'user_logged_username' => $query[0]['username'],
				'user_logged' => $query[0]['name']
			);
			$this->session->set_userdata($data1);			
			
			$subject = "Welcome to thesurveypoint.com";
			$message = "Hello  ".$post_data['name'].",<br/> Thanks for signing up with us at thesurveypoint.com and welcome.:<br/><br/>Please check your login details below:<br/><br/>";
			$message .= "<table width='100%' border='0' cellspacing='0' cellpadding='0'>
					<tr>
						<td width='10%'><strong>Email:</strong></td>
						<td width='90%'>".stripslashes($post_data['email'])."</td>
					</tr>
					<tr>
						<td width='10%'><strong>Username:</strong></td>
						<td width='90%'>".stripslashes($post_data['username'])."</td>
					</tr>
					<tr>
						<td><strong>Password:</strong></td>
						<td>".stripslashes($post_data['password'])."</td>
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
			@mail($post_data['email'], $subject, $message, $headers);
		}else{
			$data['success'] = 0;
			$data['message'] = "User name exists";
			echo json_encode($data);
		}
		$this->logDesktop();
	}	
}
