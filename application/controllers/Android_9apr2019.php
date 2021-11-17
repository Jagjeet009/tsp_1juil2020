<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Android extends CI_Controller {
	public $function_list=array();
	public $get;
	public $post;
	public function __construct(){
		$this->function_list=array('getVal'=>'1','setVal'=>'2','isRequired'=>'1','isNum'=>'1','isAlpha'=>'1','toCaps'=>'1','isAlphaNum'=>'1','isRange'=>'2','isFixed'=>'2','doHide'=>'2','doShow'=>'2','msg'=>'1','doJumpForward'=>'2','openBox'=>'3','dateDiff'=>'3','today'=>'1','now'=>'1','gps'=>'2','doColumnHide'=>'2','doColumnShow'=>'2','random'=>'1','getStates'=>'1','getDistricts'=>'2','skip'=>'2','endSurvey'=>'1','toFocus'=>'1','doMax'=>'1','doMin'=>'1','doBlock'=>'1','doUnblock'=>'1','doCheck'=>'2','doUncheck'=>'2','doPlus'=>'2','doMinus'=>'2','doMultiply'=>'2','doDivide'=>'2','doConcat'=>'2','doRowHide'=>'2','doRowShow'=>'2','setQtext'=>'2','getLabel'=>'1','isMobile'=>'3');		
		parent::__construct();
		//$this->logAndroid();
        $this->load->model('User_model');
	}
	public function logAndroid($rd=''){
		$local_version_file='logAndroid.txt';
		if(!file_exists($local_version_file)) {
			@file_put_contents($local_version_file, 'Android Logs'); 
		}else{
			$date=date('d-m-Y ');
			$time=date('h:i:sa');
			$url=current_url();
			$get=json_encode($this->get);
			$post=json_encode($this->post);
			$return_data=ob_get_contents();
			if($rd!=''){
				$return_data=$rd;
			}
			@file_put_contents($local_version_file, PHP_EOL." ".PHP_EOL.$date." ".$time,FILE_APPEND); 
			@file_put_contents($local_version_file, PHP_EOL.$url,FILE_APPEND); 
			@file_put_contents($local_version_file, PHP_EOL.'Get: '.$get,FILE_APPEND); 
			@file_put_contents($local_version_file, PHP_EOL.'Post: '.$post,FILE_APPEND); 
			@file_put_contents($local_version_file, PHP_EOL.'Return Data: '.$return_data,FILE_APPEND); 
		}
	}
	public function readAndroidLog($command){
		$local_version_file='logAndroid.txt';
		if(file_exists($local_version_file)) {
			if($command==='delete'){
				@file_put_contents($local_version_file, 'Android Logs'); 
			}else{
				$androidLog = file_get_contents(base_url()."logAndroid.txt");
				echo "<!doctype html>
				<html>
				<head>
				<title>Android Logs</title>
				</head>
				<body>
				<pre>".$androidLog."</pre>
				<script type=text/javascript>window.scrollTo(0,document.body.scrollHeight)</script>
				</body>
				</html>";
			}
		}
	}
	public function index(){
		echo "No function Called";
		$this->logAndroid();
	}
	public function func($func,$p=''){
		if($func=="register"){
			$this->get=$this->input->get();
			$this->post=$this->input->post();
			$this->register();
		}else if($func=="login"){
			$this->get=$this->input->get();
			$this->post=$this->input->post();
			$this->login();
		}else if($func=="forgotpass"){
			$this->get=$this->input->get();
			$this->post=$this->input->post();
			$this->forgotpass();
		}else if($func=="sync"){
			$this->get=$this->input->get();
			$this->post=$this->input->post();
			$this->sync($p);
		}else if($func=="syncsend"){
			$this->get=$this->input->get();
			$this->post=$this->input->post();
			$this->syncsend($p);
		}else if($func=="syncget"){
			$this->get=$this->input->get();
			$this->post=$this->input->post();
			$this->syncget();
		}else if($func=="sync_for_login"){
			$this->get=$this->input->get();
			$this->post=$this->input->post();
			$this->sync_for_login($p);
		}else if($func=="user_dashboard"){
			$this->get=$this->input->get();
			$this->post=$this->input->post();
			$this->user_dashboard($p);
		}else if($func=="user_dashboard_analytics_track"){
			$this->get=$this->input->get();
			$this->post=$this->input->post();			
			$this->user_dashboard_analytics_track($p);			
		}else if($func=="readAndroidLog"){
			$this->readAndroidLog($p);
		}else if($func=="sync_surveys"){
			$this->get=$this->input->get();
			$this->post=$this->input->post();
			$this->sync_surveys();
		}else if($func=="sync_entries"){
			$this->get=$this->input->get();
			$this->post=$this->input->post();
			$this->sync_entries();
		}else if($func=="syncsendsingle"){
			$this->get=$this->input->get();
			$this->post=$this->input->post();
			$this->syncsendsingle($p);
		}else if($func=="syncreceive"){
			$this->get=$this->input->get();
			$this->post=$this->input->post();
			$this->syncreceive($p);
		}else{
			echo "No function Called";
			$this->logAndroid();
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
	public function rejson($arr){
		if(isset($arr['section_sort_id'])){
			if(empty($arr['section_sort_id'])){
				$arr['section_sort_id']=array();
				return $arr['section_sort_id'];
			}else{
				$arr['section_sort_id']=json_decode($arr['section_sort_id']);
				return $arr['section_sort_id'];
			}
		}		
		if(isset($arr['question_sort_id'])){
			if(empty($arr['question_sort_id'])){
				$arr['question_sort_id']=array();
				return $arr['question_sort_id'];
			}else{
				$arr['question_sort_id']=json_decode($arr['question_sort_id']);
				return $arr['question_sort_id'];
			}
		}			
		if(isset($arr['permission_design'])){
			if(empty($arr['permission_design'])){
				$arr['permission_design']=array();
				return $arr['permission_design'];
			}else{
				$arr['permission_design']=json_decode($arr['permission_design']);
				return $arr['permission_design'];
			}
		}
		if(isset($arr['permission_fill'])){
			if(empty($arr['permission_fill'])){
				$arr['permission_fill']=array();
				return $arr['permission_fill'];
			}else{
				$arr['permission_fill']=json_decode($arr['permission_fill']);
				return $arr['permission_fill'];
			}
		}
		if(isset($arr['permission_analytics'])){
			if(empty($arr['permission_analytics'])){
				$arr['permission_analytics']=array();
				return $arr['permission_analytics'];
			}else{
				$arr['permission_analytics']=json_decode($arr['permission_analytics']);
				return $arr['permission_analytics'];
			}
		}		
		if(isset($arr['languages'])){
			if(empty($arr['languages'])){
				$arr['languages']=array();
				return $arr['languages'];
			}else{
				$arr['languages']=json_decode($arr['languages']);
				return $arr['languages'];
			}
		}
		if(isset($arr['elements'])){
			if(empty($arr['elements'])){
				$arr['elements']=array();
				return $arr['elements'];
			}else{
				$arr['elements']=json_decode($arr['elements']);
				return $arr['elements'];
			}
		}
		if(isset($arr['style'])){
			if(empty($arr['style'])){
				$arr['style']=(object) array();
				return $arr['style'];
			}else{
				$arr['style']=json_decode($arr['style']);
				return $arr['style'];
			}
		}
		if(isset($arr['indicator'])){
			if(empty($arr['indicator'])){
				$arr['indicator']=(object) array();
				return $arr['indicator'];
			}else{
				$arr['indicator']=json_decode($arr['indicator']);
				return $arr['indicator'];
			}
		}
		if(isset($arr['json_data'])){
			if(empty($arr['json_data'])){
				$arr['json_data']=(object) array();
				return $arr['json_data'];
			}else{
				$arr['json_data']=json_decode($arr['json_data']);
				return $arr['json_data'];
			}
		}
		if(isset($arr['lengths'])){
			if(empty($arr['lengths'])){
				$arr['lengths']=(object) array();
				return $arr['lengths'];
			}else{
				$arr['lengths']=json_decode($arr['lengths']);
				return $arr['lengths'];
			}
		}
		if(isset($arr['code_name'])){
			if(empty($arr['code_name'])){
				$arr['code_name']=(object) array();
				return $arr['code_name'];
			}else{
				$arr['code_name']=json_decode($arr['code_name']);
				return $arr['code_name'];
			}
		}
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
	//url : http://www.thesurveypoint.com/android_api/register/
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
		$this->logAndroid();		
	}
	//url : http://www.thesurveypoint.com/android_api/login/
	function login(){
		$post_data=$this->check_mandatory(array('username','password'));
		$query=$this->db->query("select * from users where username='".$post_data['username']."' and password='".$post_data['password']."' ");
		$query=$query->result_array();
		if(sizeof($query)>0){
			$data1=array(
				'last_login_date' => time()
			);
			$this->User_model->update_user($query[0]['id'],$data1);
			
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
		$this->logAndroid();
	}
	//url : http://www.thesurveypoint.com/android_api/forgotpass/
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
		$this->logAndroid();
	}
	//url : http://www.thesurveypoint.com/android_api/sync/7
	function sync($p){
		$last_time='';
		$q0=$this->db->query("select donetime from synclog where tablename='synclog' order by id desc limit 0,1");
		if($q0->num_rows()>0){
			$q0=$q0->result_array();
			$last_time=$q0[0]['donetime'];
			$d=array(
				'tablename' => 'synclog',
				'donetime' => time()
			);
			$this->db->insert('synclog', $d);
			//$this->db->query("insert into synclog set tablename='synclog', donetime='".time()."' ");
		}else{
			$d=array(
				'tablename' => 'synclog',
				'donetime' => time()
			);
			$this->db->insert('synclog', $d);
			//$this->db->query("insert into synclog set tablename='synclog', donetime='".time()."' ");
		}
		$table_key=array(
			'survey'=>'title_url',
			'survey_section'=>'title_url',
			'survey_data'=>'data_id',
			'survey_values'=>'survey_case_id',
			'users'=>'username'
		);
		if($last_time!=''){
			$q1=$this->db->query("select id,tablename as tn,columnname as cn,meta_primary_key as mpk, donetime as dt from synclog where tablename!='synclog' and ( donetime>'".$last_time."' or donetime='0' ) order by id asc ");
		}else{
			$q1=$this->db->query("select id,tablename as tn,columnname as cn,meta_primary_key as mpk, donetime as dt from synclog where tablename!='synclog' order by id asc ");
		}
		$total=$q1->num_rows();
		if($total>0){
			$q_data=$q1->result_array();
			///print_r($q_data);
			$sync_data=array();
			foreach($q_data as $qd){
				//print_r($qd);
				$q2=$this->db->query("select ".$qd['cn']." from ".$qd['tn']." where ".$table_key[$qd['tn']]." = '".$qd['mpk']."' order by id desc limit 0,1");
				if($q2->num_rows()>0){
					$q2=$q2->result_array();
					//print_r($q2);
					$qd['data']=base64_encode($q2[0][$qd['cn']]);
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
		$this->logAndroid();		
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
				if($nd['dt']!="0"){
					$q1=$this->db->query("select donetime from synclog where tablename='".$nd['tn']."' and columnname='".$nd['cn']."' and meta_primary_key='".$nd['mpk']."' order by id desc limit 0,1 ");
					if($q1->num_rows()>0){
						//has last edited time
						$q1=$q1->result_array();
						if($nd['dt']>=$q1[0]['donetime']){
							//mine is new
							$this->db->query("update ".$nd['tn']." set ".$nd['cn']."='".addslashes(base64_decode($nd['data']))."' where ".$table_key[$nd['tn']]."='".$nd['mpk']."' ");
							$nd['changed']="0";
							$nd['changes']="Old";
						}else{
							//mine is old and collect new to sync back
							$q2=$this->db->query("select ".$nd['cn']." from ".$nd['tn']." where ".$table_key[$nd['tn']]."='".$nd['mpk']."' ");
							if($q2->num_rows()>0){
								$q2=$q2->result_array();
								//print_r($q2);
							}
							$nd['data']=base64_encode($q2[0][$nd['cn']]);
							$nd['changed']="1";
							$nd['changes']="Old";
							//print_r($nd);
						}
					}else{			
						//first time editing
						$q3=$this->db->query("select * from ".$nd['tn']." where ".$table_key[$nd['tn']]."='".$nd['mpk']."' ");
						if(!$q3->num_rows()>0){
							$d=array(
								$nd['cn'] => addslashes(base64_decode($nd['data'])),
								'add_date' => time()
							);
							$this->db->insert($nd['tn'], $d);
							//$this->db->query("insert into ".$nd['tn']." set ".$nd['cn']."='".addslashes(base64_decode($nd['data']))."', add_date='".time()."' ");
						}else{
							$this->db->query("update ".$nd['tn']." set ".$nd['cn']."='".addslashes(base64_decode($nd['data']))."' where ".$table_key[$nd['tn']]."='".$nd['mpk']."' ");
							
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
									$q5=$this->db->query("select * from survey where title_url='".base64_decode($nd['data'])."' limit 0,1 ");
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
										$this->db->query("update survey set section_sort_id='".$q5['section_sort_id']."' where title_url='".base64_decode($nd['data'])."' ");
									}
								}
							}

							if($nd['tn']=="survey_data" && $nd['cn']=="survey_id"){
								$q4=$this->db->query("select * from survey_data where data_id='".$nd['mpk']."' limit 0,1 ");
								if($q4->num_rows()>0){
									$q4=$q4->result_array();
									$q4=$q4[0];
									$insert_id=$q4['id'];
									$q5=$this->db->query("select * from survey_section where title_url='".base64_decode($nd['data'])."' limit 0,1 ");
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
										$this->db->query("update survey_section set question_sort_id='".$q5['question_sort_id']."' where title_url='".base64_decode($nd['data'])."' ");
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
			$q4=$this->db->query("select id,tablename as tn,columnname as cn,meta_primary_key as mpk, donetime as dt from synclog where tablename!='synclog' and ( donetime>'".$last_time."' or donetime='0' ) order by id asc ");
		}else{
			$q4=$this->db->query("select id,tablename as tn,columnname as cn,meta_primary_key as mpk, donetime as dt from synclog where tablename!='synclog' order by id asc ");
		}
		$q4_total=$q4->num_rows();
		$q4_sync_data=array();
		if($q4_total>0){
			$q4_data=$q4->result_array();
			foreach($q4_data as $qd){
				if($qd['dt']!="0"){
					//print_r($qd);
					$q2=$this->db->query("select ".$qd['cn']." from ".$qd['tn']." where ".$table_key[$qd['tn']]." = '".$qd['mpk']."' order by id desc limit 0,1");
					if($q2->num_rows()>0){
						$q2=$q2->result_array();
						//print_r($q2);
						$qd['data']=base64_encode($q2[0][$qd['cn']]);
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
		$this->logAndroid();		
	}
	function syncget(){
		$table_key=array(
			'survey'=>'title_url',
			'survey_section'=>'title_url',
			'survey_data'=>'data_id',
			'survey_values'=>'survey_case_id',
			'users'=>'username'
		);
		$new_data=(array) json_decode($this->input->post('data'));
		//print_r($new_data);die;
		foreach($new_data as $nd){
			$nd=(array) $nd;
			if($nd['changed']=="1"){
				if($nd['changes']=="New"){
					//print_r($nd);
					//echo "select * from ".$nd['tn']." where ".$table_key[$nd['tn']]."='".$nd['mpk']."' ";
					$q3=$this->db->query("select * from ".$nd['tn']." where ".$table_key[$nd['tn']]."='".$nd['mpk']."' ");
					if(!$q3->num_rows()>0){
						$d=array(
							$nd['cn'] => addslashes(base64_decode($nd['data'])),
							'add_date' => time()
						);
						$this->db->insert($nd['tn'], $d);
						//echo $this->db->last_query();
						//$this->db->query("insert into ".$nd['tn']." set ".$nd['cn']."='".addslashes(base64_decode($nd['data']))."', add_date='".time()."' ");
					}else{
						$this->db->query("update ".$nd['tn']." set ".$nd['cn']."='".addslashes(base64_decode($nd['data']))."' where ".$table_key[$nd['tn']]."='".$nd['mpk']."' ");
						//echo "update ".$nd['tn']." set ".$nd['cn']."='".addslashes(base64_decode($nd['data']))."' where ".$table_key[$nd['tn']]."='".$nd['mpk']."' ";
						
						if($nd['tn']=="survey_section" && $nd['cn']=="survey_id"){
							$q4=$this->db->query("select * from survey_section where title_url='".$nd['mpk']."' limit 0,1 ");
							if($q4->num_rows()>0){
								$q4=$q4->result_array();
								$q4=$q4[0];
								$insert_id=$q4['id'];
								$q5=$this->db->query("select * from survey where title_url='".base64_decode($nd['data'])."' limit 0,1 ");
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
									$this->db->query("update survey set section_sort_id='".$q5['section_sort_id']."' where title_url='".base64_decode($nd['data'])."' ");
								}
							}
						}
						if($nd['tn']=="survey_data" && $nd['cn']=="survey_id"){
							$q4=$this->db->query("select * from survey_data where data_id='".$nd['mpk']."' limit 0,1 ");
							if($q4->num_rows()>0){
								$q4=$q4->result_array();
								$q4=$q4[0];
								$insert_id=$q4['id'];
								$q5=$this->db->query("select * from survey_section where title_url='".base64_decode($nd['data'])."' limit 0,1 ");
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
									$this->db->query("update survey_section set question_sort_id='".$q5['question_sort_id']."' where title_url='".base64_decode($nd['data'])."' ");
								}
							}
						}
						
						
					}
				}
				if($nd['changes']=="Old"){
					$this->db->query("update ".$nd['tn']." set ".$nd['cn']."='".addslashes(base64_decode($nd['data']))."' where ".$table_key[$nd['tn']]."='".$nd['mpk']."' ");
				}
				if($nd['changes']=="Remove"){
					//deletion case
					$this->db->query("delete from ".$nd['tn']." where ".$table_key[$nd['tn']]."='".$nd['mpk']."' ");
				}
			}
		}
		//echo json_decode($this->input->post('data'));
		$this->logAndroid();		
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
		$this->logAndroid();
	}	
	//url : http://www.thesurveypoint.com/android_api/sync_surveys/
	/*public function sync_surveys(){
		$data=$this->input->post('data');
		$data=json_decode($data);
		$survey_data=$data->survey_data;
		$survey_section=$data->survey_section;
		$survey=$data->survey;
		
		//creating survey questions
		if(sizeof($survey_data)>0){
			foreach($survey_data as $sd){
				$sd=(array) $sd;
				$sd['json_data']->title_url=$sd['question_id'];
				$sd['json_data']->qtype=$sd['qtype'];
				$sd['json_data']->question=$sd['json_data']->question_name;
				$data = array(
					'data_id' => $sd['question_id'],
					'survey_id' => $sd['section_id'],
					'qtype' => $sd['qtype'],
					'json_data' => json_encode($sd['json_data']),
					//'code' => $sd['code'],
					'elements' => json_encode($sd['elements']),
					//'lengths' => $sd['lengths'],
					//'code_name' => $sd['code_name'],
					//'style' => $sd['style'],
					'add_date' => time(),
					'status' => '1',
					'complete' => '1'
				);
				//unset($sd['question_id']);		//necessary to remove
				//unset($sd['json_data']->question_name);	//necessary to remove
				//print_r($data);die;
				$this->db->insert('survey_data', $data);
				$sdi=$this->db->insert_id();
				if(isset($sda[$sd['section_id']])){
					$sda[$sd['section_id']]=$sda[$sd['section_id']].",".$sdi;
				}else{
					$sda[$sd['section_id']]=$sdi;
				}
			}
		}
		//creating sections
		if(sizeof($survey_section)>0){
			foreach($survey_section as $ss){
				$ss=(array) $ss;
				$data = array(
					'survey_id' => $ss['survey_id'],
					'title' => $ss['title'],
					'title_url' => $ss['section_id'],
					'add_date' => time(),
					//'style' => $ss['style'],
					'status' => '1'
				);
				$this->db->insert('survey_section', $data);
				$ssi=$this->db->insert_id();
				if(isset($ssa[$ss['survey_id']])){
					$ssa[$ss['survey_id']]=$ssa[$ss['survey_id']].",".$ssi;
				}else{
					$ssa[$ss['survey_id']]=$ssi;
				}
			}
		}
		//creating surveys
		if(sizeof($survey)>0){
			foreach($survey as $s){
				$s=(array) $s;
				
				$this->db->where('username',$s['username']);
				$user_data=$this->db->get('users');
				if($user_data->num_rows()>0){
				$user_data=$user_data->result_array();
				$user_data=$user_data[0];
				}
				
				$data = array(
					'user_id' => $user_data['id'],
					'title' => $s['title'],
					'title_url' => $s['survey_id'],
					//'style' => $s['style'],
					//'indicator' => $s['indicator'],
					//'permission_design' => $s['permission_design'],
					//'permission_fill' => $s['permission_fill'],
					//'languages' => $s['languages'],
					'add_date' => time(),
					'publish_date' => time(),
					'status' => '1'
				);
				$this->db->insert('survey', $data);
			}
		}	
		
		//creating nested for sections and questions in surveys
		if(sizeof($sda)>0){
			foreach($sda as $sda_k=>$sda_v){
				$data=array(
					'question_sort_id'=>$sda_v
				);
				$this->db->where('title_url',$sda_k);
				$this->db->update('survey_section',$data);
			}
		}
		if(sizeof($ssa)>0){
			foreach($ssa as $ssa_k=>$ssa_v){
				$data=array(
					'section_sort_id'=>$ssa_v
				);
				$this->db->where('title_url',$ssa_k);
				$this->db->update('survey',$data);					
			}
		}		
		echo json_encode(array('success'=>'1','message'=>sizeof($survey)." surveys added successfully"));
		$this->logAndroid();			
	}*/
	//url : http://www.thesurveypoint.com/android_api/sync_entries/
	public function sync_entries(){
		$total_entries_added=0;
		$data=$this->input->post('data');
		$data=json_decode($data);
		$entries=$data->entries;
		
		//creating entries
		foreach($entries as $e){
			$data=array(
				'survey_case_id'=>$e->survey_case_id,
				'username'=>$e->username,
				'survey_id'=>$e->survey_id,
				'add_date'=>time(),
				'status'=>'1'
			);
			$json_data=array();
			$e_size=sizeof($e->question_keys);
			for($i=0;$i<$e_size;$i++){
				$json_data[$e->question_keys[$i]]=$e->answers_keys[$i];
			}
			$json_data=json_encode($json_data);
			$data['json_data']=$json_data;
			$this->db->insert('survey_values', $data);
			$total_entries_added++;
		}
		echo json_encode(array('success'=>'1','message'=>$total_entries_added." entries added successfully"));
		$this->logAndroid();	
	}
	
	public function syncsendsingle($u){
		$table_key=array(
			'survey'=>'title_url',
			'survey_section'=>'title_url',
			'survey_data'=>'data_id',
			'survey_values'=>'survey_case_id',
			'users'=>'username'
		);
		$new_data=$this->input->post('data');
		$new_data=(array) json_decode($new_data);
		$last_time=$new_data['last_time'];
		$username=$new_data['username'];
		$new_data['data']=(array) $new_data['data'];
		//print_r($new_data);
		//$this->logAndroid();
		//die;
		
		$new_back_data=array();
		if(isset($new_data['data']) && is_array($new_data['data'])){
			$new_data=$new_data['data'];
			foreach($new_data as $nd){
				$nd=(array) $nd;
				
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
						//first time editing
						$q3=$this->db->query("select * from ".$nd['tn']." where ".$table_key[$nd['tn']]."='".$nd['mpk']."' ");
						if(!$q3->num_rows()>0){
							if(!isset($nd['data'])){$nd['data']="For Deleting";}
							$d=array(
								$nd['cn'] => addslashes(json_encode($nd['data'])),
								'add_date' => time()
							);
							$this->db->insert($nd['tn'], $d);
							//echo $this->db->last_query();die;
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
		$this->logAndroid();
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
				$queryu=$queryu[0]['id'];
					$this->db->where('user_id', $queryu);
					$querys = $this->db->get('survey');		
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
			//echo "select id,tablename as tn,columnname as cn,meta_primary_key as mpk, donetime as dt from synclog where tablename!='synclog' and donetime>'".$last_time."' order by id asc ";
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
					$qd_new['work']=$qd['work'];
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
		echo json_encode($q4_sync_data);
		$this->logAndroid();
	}	
	function statementsToJson($statement){
		if(strlen($statement)>5){
			$pre_code_new=array();
			foreach($this->function_list as $fl_k=>$fl_v){		//search for functions in line
				if(strstr($statement,$fl_k)){
					$pcn=preg_split('/'.$fl_k.'/',$statement);
					//print_r($pcn);
					$pcn[0]=str_replace('var ','',$pcn[0]);
					$pcn[0]=str_replace('=','',$pcn[0]);
					$pcn[1]=str_replace('(','',$pcn[1]);
					$pcn[1]=str_replace(')','',$pcn[1]);
					$pcn[1]=str_replace(';','',$pcn[1]);
					$pcn[1]=str_replace("'",'',$pcn[1]);
					$pcn[1]=explode(',',$pcn[1]);
					$pre_code_new['function']=$fl_k;
					if($pre_code_new['function']=="getVal"){
						$pre_code_new['parameters']=array("id"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="setVal"){
						$pre_code_new['parameters']=array("id"=>$pcn[1][0],"value"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="isRequired"){
						$pre_code_new['parameters']=array("id"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="isNum"){
						$pre_code_new['parameters']=array("id"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="isAlpha"){
						$pre_code_new['parameters']=array("id"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="isAlphaNum"){
						$pre_code_new['parameters']=array("id"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="isRange"){
						$value_array=array();
						for($i=1;$i<sizeof($pcn[1]);$i++){
							$va=$pcn[1][$i];
							$va=str_replace('[','',$va);
							$va=str_replace(']','',$va);
							/*if(strstr($va,'-')){
								$va=explode('-',$va);
								for($j=$va[0];$j<=$va[1];$j++){
									array_push($value_array,$j);
								}
							}else{
								array_push($value_array,$va);
							}*/
							array_push($value_array,$va);
						}
						$pre_code_new['parameters']=array("id"=>$pcn[1][0],"value_array"=>$value_array);
					}else if($pre_code_new['function']=="isFixed"){
						$pre_code_new['parameters']=array("id"=>$pcn[1][0],"value"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="doHide"){
						$pre_code_new['parameters']=array("from_id"=>$pcn[1][0],"to_id"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="doShow"){
						$pre_code_new['parameters']=array("from_id"=>$pcn[1][0],"to_id"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="msg"){
						$pre_code_new['parameters']=array("message"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="doJumpForward"){
						$pre_code_new['parameters']=array("from_id"=>$pcn[1][0],"to_id"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="openBox"){
						$pre_code_new['parameters']=array("id"=>$pcn[1][0],"id_array"=>$pcn[1][1],"message"=>$pcn[1][2]);
					}else if($pre_code_new['function']=="dateDiff"){
						$pre_code_new['parameters']=array("start_date"=>$pcn[1][0],"end_date"=>$pcn[1][1],"datekey"=>$pcn[1][2]);
					}else if($pre_code_new['function']=="today"){
						$pre_code_new['parameters']=array("key"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="now"){
						$pre_code_new['parameters']=array("key"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="gps"){
						$pre_code_new['parameters']=array("key"=>$pcn[1][0],"id"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="doColumnHide"){
						$pre_code_new['parameters']=array("id"=>$pcn[1][0],"Nos"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="doColumnShow"){
						$pre_code_new['parameters']=array("id"=>$pcn[1][0],"Nos"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="random"){
						$pre_code_new['parameters']=array("id_array"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="getStates"){
						$pre_code_new['parameters']=array("id"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="getDistricts"){
						$pre_code_new['parameters']=array("id"=>$pcn[1][0],"state_id"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="skip"){
						$pre_code_new['parameters']=array("from_id"=>$pcn[1][0],"to_id"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="endSurvey"){
						$pre_code_new['parameters']=array("from_id"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="toFocus"){
						$pre_code_new['parameters']=array("id"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="doMax"){
						$pre_code_new['parameters']=array("id_array"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="doMin"){
						$pre_code_new['parameters']=array("id_array"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="doBlock"){
						$pre_code_new['parameters']=array("id"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="doUnblock"){
						$pre_code_new['parameters']=array("id"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="doCheck"){
						$pre_code_new['parameters']=array("id"=>$pcn[1][0],"value"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="doUncheck"){
						$pre_code_new['parameters']=array("id"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="toCaps"){
						$pre_code_new['parameters']=array("id"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="doPlus"){
						$pre_code_new['parameters']=array("id_array"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="doMinus"){
						$pre_code_new['parameters']=array("value1"=>$pcn[1][0],"value2"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="doMultiply"){
						$pre_code_new['parameters']=array("value1"=>$pcn[1][0],"value2"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="doDivide"){
						$pre_code_new['parameters']=array("value1"=>$pcn[1][0],"value2"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="doConcat"){
						$pre_code_new['parameters']=array("value1"=>$pcn[1][0],"value2"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="doRowHide"){
						$pre_code_new['parameters']=array("id"=>$pcn[1][0],"Nos"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="doRowShow"){
						$pre_code_new['parameters']=array("id"=>$pcn[1][0],"Nos"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="setQtext"){
						$pre_code_new['parameters']=array("id"=>$pcn[1][0],"res_object"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="getLabel"){
						$pre_code_new['parameters']=array("id"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="isMobile"){
						$pre_code_new['parameters']=array("id"=>$pcn[1][0],"digits"=>$pcn[1][1],"minimum_digit"=>$pcn[1][2]);
					}else{}
					//$pre_code_new['parameters']=$pcn[1];
					
					$pcn[0]=str_replace("\r",'',$pcn[0]);
					$pcn[0]=str_replace("\n",'',$pcn[0]);
					$pcn[0]=str_replace("\t",'',$pcn[0]);
					$pre_code_new['returns']=$pcn[0];
					//break;
				}
			}			
			//print_r($pre_code_new);
			$statement=$pre_code_new;
		}
		return $statement;
	}
	function constantStatementsToJson($statement){
		$new_statement=array();
		if(strlen($statement)>5){
			$statement=str_replace("\r",'',$statement);
			$statement=str_replace("\n",'',$statement);
			$statement=str_replace("\t",'',$statement);
			$statement=str_replace(';',';'.PHP_EOL,$statement);
			$statement=explode(PHP_EOL,$statement);
			array_pop($statement);
			foreach($statement as $s){
				$ns=array();
				if($s!=''){
					$s=explode('=',$s);
					$s[0]=str_replace('var ','',$s[0]);
					$s[1]=str_replace(';','',$s[1]);
					$ns['variable']=$s[0];
					if(strstr($s[1],'+')){
						$ns['value_array']=explode('+',$s[1]);
						$ns['id_array']="[]";
						$ns['value']="";
						$ns['value_object']="{}";
					}else if(strstr($s[1],'[')){
						$s[1]=json_decode($s[1]);
						$ns['id_array']=$s[1];
						$ns['value_array']="";
						$ns['value']="";
						$ns['value_object']="{}";
					}else if(strstr($s[1],'{')){
						$s[1]=json_decode($s[1]);
						$s[1]=(array) $s[1];
						$ns['id_array']="[]";
						$ns['value_array']="";
						$ns['value']="";
						$ns['value_object']=$s[1];
					}else{
						$ns['id_array']="[]";
						$ns['value_array']="";
						$ns['value']=$s[1];
						$ns['value_object']="{}";
					}
				}
				array_push($new_statement,$ns);
			}
			//print_r($statement);
		}
		//return $statement;
		//return $new_statement;
		if(sizeof($new_statement)>0){
			$new_statement=$new_statement[0];
		}
		return $new_statement;
	}
	function codeToJson($code=''){
		$all_code=array();
		if($code!=''){
			//print_r($code);
			$elements_name=array();
			//$code=str_replace(PHP_EOL,'',$code);
			$code=preg_split('/\/\//',$code);
			//$code=explode('//',$code);
			//print_r($code);
			$odd = array();
			$even = array();
			foreach ($code as $k => $v) {
				if ($k % 2 == 0) {
					$even[] = str_replace(PHP_EOL,'',$v);
				}
				else {
					$odd[] = str_replace(PHP_EOL,'',$v);
				}
			}
			array_shift($even);
			//print_r($odd);
			//print_r($even);
			for($z=0;$z<sizeof($odd);$z++){
				$pre_code='';
				$post_code='';
				$even_code=$even[$z];
				if(strstr($even_code,"/*preproc*/")){
					$even_code=explode("/*preproc*/",$even_code);
					array_shift($even_code);
					//print_r($even_code);
					if(sizeof($even_code)>0){
						if(isset($even_code[0])){
							$pre_code=$even_code[0];
						}
						if(isset($even_code[1])){
							$post_code=$even_code[1];
						}
					}
				}else{
					$post_code=$even_code;					
				}
				//print_r($pre_code);
				//print_r($post_code);
					
				//calculating pre code
				$pre_code_new=array();
				$pre_code=preg_split('/if[(]/',$pre_code);
				//preparing code line by line
				for($i=0;$i<sizeof($pre_code);$i++){
					if($i!=0){
						$pre_code[$i]="if(".$pre_code[$i];
					}
				}
				for($i=0;$i<sizeof($pre_code);$i++){
					if(strstr($pre_code[$i],"if(")){							//if  and else with functions
						$pre_code[$i]=explode('}',$pre_code[$i]);
						$bigif=array();
						for($j=0;$j<sizeof($pre_code[$i]);$j++){			//if with inside and outside statements
							if($j!= (sizeof($pre_code[$i])-1 )){					//inside if brackets
								if(strstr($pre_code[$i][$j],'if(')){
									$if_array=array();
									$pre_code[$i][$j]=$pre_code[$i][$j]."}";
									$pre_code[$i][$j]=explode('{',$pre_code[$i][$j]);
									//$pre_code[$i][$j][0]		if condition
									//$pre_code[$i][$j][1]		function statements
									$pre_code[$i][$j][0]=str_replace('if(','',$pre_code[$i][$j][0]);
									$pre_code[$i][$j][0]=str_replace(')','',$pre_code[$i][$j][0]);
									$pre_code[$i][$j][0]=explode(' ',$pre_code[$i][$j][0]);

									$pre_code[$i][$j][1]=str_replace('}','',$pre_code[$i][$j][1]);
									$pre_code[$i][$j][1]=str_replace(';',';'.PHP_EOL,$pre_code[$i][$j][1]);
									$pre_code[$i][$j][1]=explode(PHP_EOL,$pre_code[$i][$j][1]);
									$if_array['conditions']=$pre_code[$i][$j][0];

									array_pop($pre_code[$i][$j][1]);
									//print_r($pre_code[$i][$j][1]);
									for($l=0;$l<sizeof($pre_code[$i][$j][1]);$l++){
										$found=false;
										$found_function='';
										foreach($this->function_list as $fl_k=>$fl_v){		//search for functions in line
											if(strstr($pre_code[$i][$j][1][$l],$fl_k)){								
												$found=true;
												$found_function=$fl_k;
												break;
											}
										}
										if($found==true && $found_function!=''){
											$pre_code[$i][$j][1][$l]=$this->statementsToJson($pre_code[$i][$j][1][$l]);
										}else{
											$pre_code[$i][$j][1][$l]=array('constant'=>$this->constantStatementsToJson($pre_code[$i][$j][1][$l]));
										}									
									}						
									//print_r($pre_code[$i][$j][1]);
									$if_array['statements']=$pre_code[$i][$j][1];
									//array_push($bigif,$if_array);
									$bigif['if']=$if_array;
								}else{
									$if_array=array();
									$pre_code[$i][$j]=$pre_code[$i][$j]."}";
									$pre_code[$i][$j]=explode('{',$pre_code[$i][$j]);
									//$pre_code[$i][$j][0]		if condition
									//$pre_code[$i][$j][1]		function statements
									$pre_code[$i][$j][0]=str_replace('else{','',$pre_code[$i][$j][0]);
									$pre_code[$i][$j][0]=explode(' ',$pre_code[$i][$j][0]);

									$pre_code[$i][$j][1]=str_replace('}','',$pre_code[$i][$j][1]);
									$pre_code[$i][$j][1]=str_replace(';',';'.PHP_EOL,$pre_code[$i][$j][1]);
									$pre_code[$i][$j][1]=explode(PHP_EOL,$pre_code[$i][$j][1]);
									//$if_array['conditions']=$pre_code[$i][$j][0];
									array_pop($pre_code[$i][$j][1]);
									//print_r($pre_code[$i][$j][1]);
									for($l=0;$l<sizeof($pre_code[$i][$j][1]);$l++){
										$found=false;
										$found_function='';
										foreach($this->function_list as $fl_k=>$fl_v){		//search for functions in line
											if(strstr($pre_code[$i][$j][1][$l],$fl_k)){								
												$found=true;
												$found_function=$fl_k;
												break;
											}
										}
										if($found==true && $found_function!=''){
											$pre_code[$i][$j][1][$l]=$this->statementsToJson($pre_code[$i][$j][1][$l]);
										}else{
											$pre_code[$i][$j][1][$l]=array('constant'=>$this->constantStatementsToJson($pre_code[$i][$j][1][$l]));
										}									
									}						
									//print_r($pre_code[$i][$j][1]);
									$if_array['statements']=$pre_code[$i][$j][1];
									//array_push($bigif,$if_array);
									$bigif['else']=$if_array;									
								}
							}else{												//outside if brackets
								$pre_code[$i][$j]=str_replace(';',';'.PHP_EOL,$pre_code[$i][$j]);
								$pre_code[$i][$j]=explode(PHP_EOL,$pre_code[$i][$j]);
								//array_pop($pre_code[$i][$j]);
								//print_r($pre_code[$i][$j]);
								for($l=0;$l<sizeof($pre_code[$i][$j]);$l++){
									if(strlen($pre_code[$i][$j][$l])>1){
										$found=false;
										$found_function='';
										foreach($this->function_list as $fl_k=>$fl_v){		//search for functions in line
											if(strstr($pre_code[$i][$j][$l],$fl_k)){								
												$found=true;
												$found_function=$fl_k;
												break;
											}
										}
										if($found==true && $found_function!=''){
											$pre_code[$i][$j][$l]=$this->statementsToJson($pre_code[$i][$j][$l]);
										}else{
											$pre_code[$i][$j][$l]=array('constant'=>$this->constantStatementsToJson($pre_code[$i][$j][$l]));
										}										
									}else{
										unset($pre_code[$i][$j][$l]);
									}
								}								
								//print_r($pre_code[$i][$j]);
								if(sizeof($pre_code[$i][$j])>1){
									$bigif['statements']=$pre_code[$i][$j];
								}
							}
						}
						array_push($pre_code_new,$bigif);
					}else{													//only functions or constants
						$pre_code[$i]=str_replace(';',';'.PHP_EOL,$pre_code[$i]);
						$pre_code[$i]=explode(PHP_EOL,$pre_code[$i]);
						for($k=0;$k<sizeof($pre_code[$i]);$k++){
							if(strlen($pre_code[$i][$k])>1){
								$found=false;
								$found_function='';
								foreach($this->function_list as $fl_k=>$fl_v){		//search for functions in line
									if(strstr($pre_code[$i][$k],$fl_k)){								
										$found=true;
										$found_function=$fl_k;
										break;
									}
								}
								if($found==true && $found_function!=''){
									$pre_code[$i][$k]=$this->statementsToJson($pre_code[$i][$k]);
								}else{
									$pre_code[$i][$k]=array('constant'=>$this->constantStatementsToJson($pre_code[$i][$k]));
								}
							}else{
								unset($pre_code[$i][$k]);
							}
						}
						//print_r($pre_code[$i]);
						array_push($pre_code_new,array('statements'=>$pre_code[$i]));
					}
				}
				
				//print_r($pre_code);
				//print_r($pre_code_new);
				//echo json_encode($pre_code_new);
				
				//calculating post code
				$post_code_new=array();
				$post_code=preg_split('/if[(]/',$post_code);
				//preparing code line by line
				for($i=0;$i<sizeof($post_code);$i++){
					if($i!=0){
						$post_code[$i]="if(".$post_code[$i];
					}
				}
				for($i=0;$i<sizeof($post_code);$i++){
					if(strstr($post_code[$i],"if(")){							//if  and else with functions
						$post_code[$i]=explode('}',$post_code[$i]);
						$bigif=array();
						for($j=0;$j<sizeof($post_code[$i]);$j++){			//if with inside and outside statements
							if($j!= (sizeof($post_code[$i])-1 )){					//inside if brackets
								if(strstr($post_code[$i][$j],'if(')){
									$if_array=array();
									$post_code[$i][$j]=$post_code[$i][$j]."}";
									$post_code[$i][$j]=explode('{',$post_code[$i][$j]);
									//$post_code[$i][$j][0]		if condition
									//$post_code[$i][$j][1]		function statements
									$post_code[$i][$j][0]=str_replace('if(','',$post_code[$i][$j][0]);
									$post_code[$i][$j][0]=str_replace(')','',$post_code[$i][$j][0]);
									$post_code[$i][$j][0]=explode(' ',$post_code[$i][$j][0]);

									$post_code[$i][$j][1]=str_replace('}','',$post_code[$i][$j][1]);
									$post_code[$i][$j][1]=str_replace(';',';'.PHP_EOL,$post_code[$i][$j][1]);
									$post_code[$i][$j][1]=explode(PHP_EOL,$post_code[$i][$j][1]);
									$if_array['conditions']=$post_code[$i][$j][0];
									array_pop($post_code[$i][$j][1]);
									//print_r($post_code[$i][$j][1]);
									for($l=0;$l<sizeof($post_code[$i][$j][1]);$l++){
										$found=false;
										$found_function='';
										foreach($this->function_list as $fl_k=>$fl_v){		//search for functions in line
											if(strstr($post_code[$i][$j][1][$l],$fl_k)){								
												$found=true;
												$found_function=$fl_k;
												break;
											}
										}
										if($found==true && $found_function!=''){
											$post_code[$i][$j][1][$l]=$this->statementsToJson($post_code[$i][$j][1][$l]);
										}else{
											$post_code[$i][$j][1][$l]=array('constant'=>$this->constantStatementsToJson($post_code[$i][$j][1][$l]));
										}									
									}						
									//print_r($post_code[$i][$j][1]);
									$if_array['statements']=$post_code[$i][$j][1];
									//array_push($bigif,$if_array);
									$bigif['if']=$if_array;
								}else{
									$if_array=array();
									$post_code[$i][$j]=$post_code[$i][$j]."}";
									$post_code[$i][$j]=explode('{',$post_code[$i][$j]);
									//$post_code[$i][$j][0]		if condition
									//$post_code[$i][$j][1]		function statements
									$post_code[$i][$j][0]=str_replace('else{','',$post_code[$i][$j][0]);
									$post_code[$i][$j][0]=explode(' ',$post_code[$i][$j][0]);

									$post_code[$i][$j][1]=str_replace('}','',$post_code[$i][$j][1]);
									$post_code[$i][$j][1]=str_replace(';',';'.PHP_EOL,$post_code[$i][$j][1]);
									$post_code[$i][$j][1]=explode(PHP_EOL,$post_code[$i][$j][1]);
									//$if_array['conditions']=$post_code[$i][$j][0];
									array_pop($post_code[$i][$j][1]);
									//print_r($post_code[$i][$j][1]);
									for($l=0;$l<sizeof($post_code[$i][$j][1]);$l++){
										$found=false;
										$found_function='';
										foreach($this->function_list as $fl_k=>$fl_v){		//search for functions in line
											if(strstr($post_code[$i][$j][1][$l],$fl_k)){								
												$found=true;
												$found_function=$fl_k;
												break;
											}
										}
										if($found==true && $found_function!=''){
											$post_code[$i][$j][1][$l]=$this->statementsToJson($post_code[$i][$j][1][$l]);
										}else{
											$post_code[$i][$j][1][$l]=array('constant'=>$this->constantStatementsToJson($post_code[$i][$j][1][$l]));
										}									
									}						
									//print_r($post_code[$i][$j][1]);
									$if_array['statements']=$post_code[$i][$j][1];
									//array_push($bigif,$if_array);
									$bigif['else']=$if_array;									
								}
							}else{												//outside if brackets
								$post_code[$i][$j]=str_replace(';',';'.PHP_EOL,$post_code[$i][$j]);
								$post_code[$i][$j]=explode(PHP_EOL,$post_code[$i][$j]);
								//array_pop($post_code[$i][$j]);
								//print_r($post_code[$i][$j]);
								for($l=0;$l<sizeof($post_code[$i][$j]);$l++){
									if(strlen($post_code[$i][$j][$l])>1){
										$found=false;
										$found_function='';
										foreach($this->function_list as $fl_k=>$fl_v){		//search for functions in line
											if(strstr($post_code[$i][$j][$l],$fl_k)){								
												$found=true;
												$found_function=$fl_k;
												break;
											}
										}
										if($found==true && $found_function!=''){
											$post_code[$i][$j][$l]=$this->statementsToJson($post_code[$i][$j][$l]);
										}else{
											$post_code[$i][$j][$l]=array('constant'=>$this->constantStatementsToJson($post_code[$i][$j][$l]));
										}										
									}else{
										unset($post_code[$i][$j][$l]);
									}
								}								
								//print_r($post_code[$i][$j]);
								if(sizeof($post_code[$i][$j])>1){
									$bigif['statements']=$post_code[$i][$j];
								}
							}
						}
						array_push($post_code_new,$bigif);
					}else{													//only functions or constants
						$post_code[$i]=str_replace(';',';'.PHP_EOL,$post_code[$i]);
						$post_code[$i]=explode(PHP_EOL,$post_code[$i]);
						for($k=0;$k<sizeof($post_code[$i]);$k++){
							if(strlen($post_code[$i][$k])>1){
								$found=false;
								$found_function='';
								foreach($this->function_list as $fl_k=>$fl_v){		//search for functions in line
									if(strstr($post_code[$i][$k],$fl_k)){	
										$found=true;
										$found_function=$fl_k;
										break;
									}
								}
								if($found==true && $found_function!=''){
									$post_code[$i][$k]=$this->statementsToJson($post_code[$i][$k]);
								}else{
									$post_code[$i][$k]=array('constant'=>$this->constantStatementsToJson($post_code[$i][$k]));
								}
							}else{
								unset($post_code[$i][$k]);
							}
						}
						array_push($post_code_new,array('statements'=>$post_code[$i]));
					}
				}
				
				//print_r($post_code);
				//print_r($post_code_new);
				//echo json_encode($post_code_new);
				
				array_push($all_code,array('element_name'=>$odd[$z],'data'=>array('preproc'=>$pre_code_new,'postproc'=>$post_code_new)));
				//array_push($all_code,array($odd[$z]=>array('preproc'=>$pre_code_new,'postproc'=>$post_code_new)));
				//$all_code[$odd[$z]]=array('preproc'=>$pre_code_new,'postproc'=>$post_code_new);
			}
			
		}
		//print_r($all_code);
		//echo json_encode($all_code);
		return $all_code;
	}
	function androidStringArray($data=''){
		$newdata=array();
		$data=(array) json_decode($data);
		foreach($data as $d_k=>$d_v){
			$nd=$d_k.":".$d_v;
			array_push($newdata,$nd);
		}
		return $newdata;
		//return json_encode($newdata);
	}
	//url : http://www.thesurveypoint.com/android_api/sync_for_login/ramesh
	function jsonToCode($json=''){
		//print_r($json);
		$all_code="";
		foreach($json as $j){
			$short_code="";
			$short_code.="//".$j->element_name."//\r\n";
			$pre_code=$j->data->preproc;
			//print_r($pre_code);
			$post_code=$j->data->postproc;
			$pre_short_code="";
			$post_short_code="";
			foreach($pre_code as $pc){
				$pc=(array) $pc;
				if(array_key_exists("statements",$pc)){		//statments outside if
					$pc_statement=$pc['statements'];
					foreach($pc_statement as $pcs){
						$pcs=(array) $pcs;
						if($pcs['returns']!=""){
							$pre_short_code.="var ".$pcs['returns']."=".$pcs['function']."('".implode("','",$pcs['parameters'])."');";
						}else{
							$pre_short_code.=$pcs['function']."('".implode("','",$pcs['parameters'])."');";
						}
						//print_r($pre_short_code);
					}
					
				}
				if(array_key_exists("if",$pc)){		//statments outside if
					$pc['if']=(array) $pc['if'];
					//print_r($pc['if']);
					$pc_conditions=implode(" ",$pc['if']['conditions']);
					$pre_short_code.="if(".$pc_conditions."){";
					
					$pc_statement=$pc['if']['statements'];
					foreach($pc_statement as $pcs){
						$pcs=(array) $pcs;
						if($pcs['returns']!=""){
							$pre_short_code.="var ".$pcs['returns']."=".$pcs['function']."('".implode("','",$pcs['parameters'])."');";
						}else{
							$pre_short_code.=$pcs['function']."('".implode("','",$pcs['parameters'])."');";
						}
					}
					$pre_short_code.="}";
					//print_r($pre_short_code);
				}				
			}
			foreach($post_code as $pc){
				$pc=(array) $pc;
				if(array_key_exists("statements",$pc)){		//statments outside if
					$pc_statement=$pc['statements'];
					foreach($pc_statement as $pcs){
						$pcs=(array) $pcs;
						if(array_key_exists("constant",$pcs)){
							foreach($pcs['constant'] as $pcsc){
								$pcsc=(array) $pcsc;
								$pcsc=(array) $pcsc;
								$post_short_code.="var ".$pcsc['variable']."=".$pcsc['value'];
							}
						}else{
							if($pcs['returns']!=""){
								$post_short_code.="var ".$pcs['returns']."=".$pcs['function']."('".implode("','",$pcs['parameters'])."');";
							}else{
								$post_short_code.=$pcs['function']."('".implode("','",$pcs['parameters'])."');";
							}
						}
						//print_r($post_short_code);
					}
					
				}
				if(array_key_exists("if",$pc)){		//statments outside if
					$pc['if']=(array) $pc['if'];
					//print_r($pc['if']);
					$pc_conditions=implode(" ",$pc['if']['conditions']);
					$post_short_code.="if(".$pc_conditions."){";
					
					$pc_statement=$pc['if']['statements'];
					foreach($pc_statement as $pcs){
						$pcs=(array) $pcs;
						if($pcs['returns']!=""){
							$post_short_code.="var ".$pcs['returns']."=".$pcs['function']."('".implode("','",$pcs['parameters'])."');";
						}else{
							$post_short_code.=$pcs['function']."('".implode("','",$pcs['parameters'])."');";
						}
					}
					$post_short_code.="}";
					//print_r($post_short_code);
				}				
			}
			//print_r($post_code);
			//echo $pre_short_code;
			//echo $post_short_code;
			$all_code.="//".$j->element_name."//\r\n";
			$all_code.="/*preproc*/\r\n";
			$all_code.=$pre_short_code;
			$all_code.="/*preproc*/\r\n";
			$all_code.=$post_short_code;
		}
		return $all_code;
	}
	public function sync_surveys(){
		$data=$this->input->post('data');
		$data=json_decode($data);
		$survey_data=$data->survey_data;
		$survey_section=$data->survey_section;
		$survey=$data->survey;
		$users=(array) $data->users;
		$users=array($users['username']=>$users['id']);
		//print_r($survey_data);
		
		//creating survey questions
		if(sizeof($survey_data)>0){
			foreach($survey_data as $sd){
				$sd=(array) $sd;
				$sd['data_id']=$sd['question_id'];
				$sd['json_data']->question=$sd['json_data']->question_name;
				$sd['survey_id']=$sd['section_id'];
				
				$sd['json_data']->title_url=$sd['question_id'];
				$sd['json_data']->qtype=$sd['qtype'];
				$sd['json_data']->question=$sd['json_data']->question_name;
				$data = array(
					'data_id' => $sd['question_id'],
					'survey_id' => $sd['section_id'],
					'qtype' => $sd['qtype'],
					'json_data' => json_encode($sd['json_data']),
					'code' => $this->jsonToCode($sd['code']),
					'elements' => json_encode($sd['elements']),
					'lengths' => json_encode($sd['lengths']),
					'code_name' => json_encode($sd['code_name']),
					//'style' => $sd['style'],
					'add_date' => time(),
					'status' => '1',
					'complete' => '1'
				);
				//unset($sd['question_id']);		//necessary to remove
				//unset($sd['json_data']->question_name);	//necessary to remove
				//print_r($data);die;
				$this->db->insert('survey_data', $data);
				$sdi=$this->db->insert_id();
				if(isset($sda[$sd['section_id']])){
					$sda[$sd['section_id']]=$sda[$sd['section_id']].",".$sdi;
				}else{
					$sda[$sd['section_id']]=$sdi;
				}
			}
		}
		//creating sections
		if(sizeof($survey_section)>0){
			foreach($survey_section as $ss){
				$ss=(array) $ss;
				$ss['title_url']=$ss['section_id'];
				$data = array(
					'survey_id' => $ss['survey_id'],
					'title' => $ss['title'],
					'title_url' => $ss['section_id'],
					'add_date' => time(),
					//'style' => $ss['style'],
					'status' => '1'
				);
				$this->db->insert('survey_section', $data);
				$ssi=$this->db->insert_id();
				if(isset($ssa[$ss['survey_id']])){
					$ssa[$ss['survey_id']]=$ssa[$ss['survey_id']].",".$ssi;
				}else{
					$ssa[$ss['survey_id']]=$ssi;
				}
			}
		}
		//creating surveys
		if(sizeof($survey)>0){
			foreach($survey as $s){
				$s=(array) $s;
				$s['title_url']=$s['survey_id'];
				
				$this->db->where('id',$users[$s['username']]);
				$user_data=$this->db->get('users');
				if($user_data->num_rows()>0){
					$user_data=$user_data->result_array();
					$user_data=$user_data[0];
				}
				$data = array(
					'user_id' => $user_data['id'],
					'title' => $s['title'],
					'title_url' => $s['survey_id'],
					//'style' => $s['style'],
					//'indicator' => $s['indicator'],
					'permission_design' => json_encode($s['permission_design']),
					'permission_fill' => json_encode($s['permission_fill']),
					'languages' => json_encode($s['languages']),
					'add_date' => time(),
					'publish_date' => time(),
					'status' => '1'
				);
				$this->db->insert('survey', $data);
			}
		}	
		
		//creating nested for sections and questions in surveys
		if(sizeof($sda)>0){
			foreach($sda as $sda_k=>$sda_v){
				$data=array(
					'question_sort_id'=>$sda_v
				);
				$this->db->where('title_url',$sda_k);
				$this->db->update('survey_section',$data);
			}
		}
		if(sizeof($ssa)>0){
			foreach($ssa as $ssa_k=>$ssa_v){
				$data=array(
					'section_sort_id'=>$ssa_v
				);
				$this->db->where('title_url',$ssa_k);
				$this->db->update('survey',$data);					
			}
		}		
		echo json_encode(array('success'=>'1','message'=>sizeof($survey)." surveys added successfully"));
		$this->logAndroid();
	}
	public function sync_for_login($username){
		//$sfd=array();
		//$sfd['survey']=array();
		//$sfd['survey_section']=array();
		//$sfd['survey_data']=array();

		$sfd_new=array();
		$this->db->where('username', $username);
		$this->db->where('status', '1');
		$query1 = $this->db->get('users');
		if($query1->num_rows()>0){
			$user_data=$query1->result_array();
			$this->db->where('user_id', $user_data[0]['id']);
			$this->db->or_where('permission_design like ','%'.$username.'%');
			$this->db->or_where('permission_fill like ','%'.$username.'%');
			$this->db->or_where('permission_analytics like ','%'.$username.'%');
			$this->db->where('status', '1');
			$this->db->order_by('id','asc');
			$query2 = $this->db->get('survey');

			if($query2->num_rows()>0){
				$survey=$query2->result_array();
				/*$sfd['survey']=$survey;
				$big_survey=array();
				for($i=0;$i<sizeof($sfd['survey']);$i++){
					$small_survey=array();
					if($sfd['survey'][$i]['user_id']==$user_data[0]['id']){
						$small_survey=$sfd['survey'][$i];
						$small_survey['user']="owner";
					}else{
						$small_survey=$sfd['survey'][$i];
						$small_survey['user']="permitted";
					}
					array_push($big_survey,$small_survey);
				}
				$sfd['survey']=$big_survey;
				$sfd['survey']=$big_survey;*/

				$temp_survey=array();
				foreach($survey as $s){
					if($s['user_id']==$user_data[0]['id']){
						$s['user']="owner";
					}else{
						$s['user']="permitted";
					}					
					$s['survey_id']=$s['title_url'];
					
					$temp_section=array();
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
									$ss['section_id']=$ss['title_url'];									
									$temp_data=array();
									//array_push($sfd['survey_section'],$ss);
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
													//array_push($sfd['survey_data'],$sd);
													$sd['section_id']=$sd['survey_id'];
													unset($sd['survey_id']);
													$sd['question_id']=$sd['data_id'];
													unset($sd['data_id']);
													$sd['json_data']=$this->rejson(array('json_data'=>$sd['json_data']));
													$sd['code']=$this->codeToJson($sd['code']);
													$sd['elements']=$this->rejson(array('elements'=>$sd['elements']));
													$sd['lengths']=$this->rejson(array('lengths'=>$sd['lengths']));
													$sd['code_name']=$this->rejson(array('code_name'=>$sd['code_name']));
													$sd['style']=$this->rejson(array('style'=>$sd['style']));
													array_push($temp_data,$sd);
												}
												$ss['surveyQuestionList']=$temp_data;	
											}								
										}
									}else{
										$this->db->where('id',$question_sort_ids);
										$query4 = $this->db->get('survey_data');
										//echo "query: ".$this->db->last_query()." num rows: ".$query3->num_rows();
										if($query4->num_rows()>0){
											$survey_data=$query4->result_array();
											foreach($survey_data as $sd){
												//array_push($sfd['survey_data'],$sd);
												$sd['section_id']=$sd['survey_id'];
												unset($sd['survey_id']);
												$sd['question_id']=$sd['data_id'];
												unset($sd['data_id']);												
												$sd['json_data']=$this->rejson(array('json_data'=>$sd['json_data']));
												$sd['code']=$this->codeToJson($sd['code']);
												$sd['elements']=$this->rejson(array('elements'=>$sd['elements']));
												$sd['lengths']=$this->rejson(array('lengths'=>$sd['lengths']));
												$sd['code_name']=$this->rejson(array('code_name'=>$sd['code_name']));
												$sd['style']=$this->rejson(array('style'=>$sd['style']));
												array_push($temp_data,$sd);
											}
											$ss['surveyQuestionList']=$temp_data;												
										}											
									}
									if($ss['question_sort_id']!=""){
										$ss['question_sort_id']=json_encode(explode(',',$ss['question_sort_id']));	
									}									

									$ss['question_sort_id']=$this->rejson(array('question_sort_id'=>$ss['question_sort_id']));										
									$ss['style']=$this->rejson(array('style'=>$ss['style']));
									unset($ss['title_url']);
									array_push($temp_section,$ss);
								}
								$s['surveySectionList']=$temp_section;
							}
						}
					}else{
						$this->db->where('id',$section_sort_ids);
						$query3 = $this->db->get('survey_section');
						//echo "query: ".$this->db->last_query()." num rows: ".$query3->num_rows();
						if($query3->num_rows()>0){
							$survey_section=$query3->result_array();
							foreach($survey_section as $ss){
								$ss['section_id']=$ss['title_url'];									
								$temp_data=array();
								//array_push($sfd['survey_section'],$ss);
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
												//array_push($sfd['survey_data'],$sd);
												$sd['section_id']=$sd['survey_id'];
												unset($sd['survey_id']);
												$sd['question_id']=$sd['data_id'];
												unset($sd['data_id']);												
												$sd['json_data']=$this->rejson(array('json_data'=>$sd['json_data']));
												$sd['code']=$this->codeToJson($sd['code']);
												$sd['elements']=$this->rejson(array('elements'=>$sd['elements']));
												$sd['lengths']=$this->rejson(array('lengths'=>$sd['lengths']));
												$sd['code_name']=$this->rejson(array('code_name'=>$sd['code_name']));
												$sd['style']=$this->rejson(array('style'=>$sd['style']));
												array_push($temp_data,$sd);													
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
											//array_push($sfd['survey_data'],$sd);
											$sd['section_id']=$sd['survey_id'];
											unset($sd['survey_id']);
											$sd['question_id']=$sd['data_id'];
											unset($sd['data_id']);											
											$sd['json_data']=$this->rejson(array('json_data'=>$sd['json_data']));
											$sd['code']=$this->codeToJson($sd['code']);
											$sd['elements']=$this->rejson(array('elements'=>$sd['elements']));
											$sd['lengths']=$this->rejson(array('lengths'=>$sd['lengths']));
											$sd['code_name']=$this->rejson(array('code_name'=>$sd['code_name']));
											$sd['style']=$this->rejson(array('style'=>$sd['style']));
											array_push($temp_data,$sd);													
										}
									}										
								}
								if($ss['question_sort_id']!=""){
									$ss['question_sort_id']=json_encode(explode(',',$ss['question_sort_id']));	
								}									

								$ss['question_sort_id']=$this->rejson(array('question_sort_id'=>$ss['question_sort_id']));
								$ss['style']=$this->rejson(array('style'=>$ss['style']));
								unset($ss['title_url']);
								array_push($temp_section,$ss);
							}
							$s['surveySectionList']=$temp_section;
						}
					}
					if($s['section_sort_id']!=""){
						$s['section_sort_id']=json_encode(explode(',',$s['section_sort_id']));
					}

					$s['section_sort_id']=$this->rejson(array('section_sort_id'=>$s['section_sort_id']));
					$s['style']=$this->rejson(array('style'=>$s['style']));
					$s['indicator']=$this->rejson(array('indicator'=>$s['indicator']));
					$s['permission_design']=$this->rejson(array('permission_design'=>$s['permission_design']));
					$s['permission_fill']=$this->rejson(array('permission_fill'=>$s['permission_fill']));
					$s['permission_analytics']=$this->rejson(array('permission_analytics'=>$s['permission_analytics']));
					$s['languages']=$this->rejson(array('languages'=>$s['languages']));
					unset($s['title_url']);					
					unset($s['indicator']);
					array_push($temp_survey,$s);
				}
				//print_r($temp_survey);
				$sfd_new['surveyList']=$temp_survey;
			}

		//echo json_encode($sfd);
		//print_r($sfd_new);
		echo json_encode($sfd_new);
		}
		$this->logAndroid();		
	}
	public function user_dashboard($username){
		$dashboard=array();
		$this->db->select('dashboard_name, dashboard_url as dashboard_id');
		$this->db->where('username', $username);
		$this->db->where('status', '1');
		$query = $this->db->get('dashboards');
		if($query->num_rows()>0){						//getting dashboards
			$query=$query->result_array();		
			foreach($query as $q){
				$dashboard_data=array();
				$dashboard_data['dashboard_name']=$q['dashboard_name'];
				$dashboard_data['dashboard_id']=$q['dashboard_id'];
				$query1='select a.survey_title_url as survey_id, b.title as survey_name from dashboard_surveys as a, survey as b where a.survey_title_url=b.title_url && a.dashboard_url="'.$q['dashboard_id'].'"';
				$query1 = $this->db->query($query1);
				if($query1->num_rows()>0){					//getting surveys
					$query1=$query1->result_array();
					$sd=array();
					foreach($query1 as $q1){
						$survey_data=array();
						$survey_data['survey_id']=$q1['survey_id'];
						$survey_data['survey_name']=$q1['survey_name'];
						
						array_push($sd,$survey_data);
					}
					$dashboard_data['surveys']=$sd;
				}				
				array_push($dashboard,$dashboard_data);
			}
		}
		$dashboards=array();
		$dashboards['dashboards']=$dashboard;
		echo json_encode($dashboards);
		$this->logAndroid();
	}
	public function user_dashboard_analytics_track($survey_id){
		$this->load->model('Analytics_model');
		$this->load->model('Survey_model');
		$sidc=$this->Survey_model->survey_indicators_dataid_codenames($survey_id);
		//print_r($sidc);
		
		$survey_data=array();
		//adding analytics dashboards
		$query2 = $this->db->query("select * from dashboard_analytics where survey_id='".$survey_id."' && analytic_or_track='0' ");
		//echo $this->db->last_query();
		if($query2->num_rows()>0){				//getting analytics charts
			$query2=$query2->result_array();
			$ad=array();
			foreach($query2 as $q2){
				$q22=(array) json_decode($q2['analytics_post_data']);
				$analytics_data=array();
				$analytics_data_entry_keys=array();
				$analytics_data['id']=$q2['id'];
				$analytics_data_rows_indicators=array();
				$analytics_data_cols_indicators=array();
				$analytics_data_layer_indicators=array();
				$analytics_data_rows_options=array();
				$analytics_data_cols_options=array();
				$analytics_data_layer_options=array();
				if(strstr($q2['analytics_graph_url'],"frequency")){
					$analytics_data['type']="frequency";
				}else if(strstr($q2['analytics_graph_url'],"table")){
					$analytics_data['type']="table";
				}else if(strstr($q2['analytics_graph_url'],"table_layer")){
					$analytics_data['type']="table_layer";
				}else if(strstr($q2['analytics_graph_url'],"chart")){
					$analytics_data['type']="chart";
				}else{}
				//$analytics_data['analytics_graph_url']=$q2['analytics_graph_url'];
				if(isset($q22['chartType'])){
					$analytics_data['chartType']=$q22['chartType'];
				}
				if(isset($q22['rows'])){
					$analytics_data['rows']=$q22['rows'];
					if(sizeof($q22['rows'])>0){
						foreach($q22['rows'] as $q22rows){
							array_push($analytics_data_entry_keys,$q22rows);
							if(array_key_exists($q22rows,$sidc['indicators'])){
								array_push($analytics_data_rows_indicators,array($q22rows=>$sidc['indicators'][$q22rows]));
							}
							if(array_key_exists($q22rows,$sidc['indicators_dataid'])){
								$row_options=$this->Analytics_model->survey_data_options($sidc['indicators_dataid'][$q22rows],$q22['rows']);
								array_push($analytics_data_rows_options,array($q22rows=>$row_options));
							}							
						}
					}
					$analytics_data['rows_indicators']=$analytics_data_rows_indicators;
					$analytics_data['rows_options']=$analytics_data_rows_options;
				}
				if(isset($q22['columns'])){
					$analytics_data['columns']=$q22['columns'];
					if(sizeof($q22['columns'])>0){
						foreach($q22['columns'] as $q22columns){
							array_push($analytics_data_entry_keys,$q22columns);
							if(array_key_exists($q22columns,$sidc['indicators'])){
								array_push($analytics_data_cols_indicators,array($q22columns=>$sidc['indicators'][$q22columns]));
							}	
							if(array_key_exists($q22columns,$sidc['indicators_dataid'])){
								$col_options=$this->Analytics_model->survey_data_options($sidc['indicators_dataid'][$q22columns],$q22['columns']);
								array_push($analytics_data_cols_options,array($q22columns=>$col_options));
							}							
						}
					}
					$analytics_data['columns_indicators']=$analytics_data_cols_indicators;
					$analytics_data['cols_options']=$analytics_data_cols_options;
				}
				if(isset($q22['layer'])){
					$analytics_data['layer']=$q22['layer'];
					if(sizeof($q22['layer'])>0){
						foreach($q22['layer'] as $q22layer){
							array_push($analytics_data_entry_keys,$q22layer);
							if(array_key_exists($q22layer,$sidc['indicators'])){
								array_push($analytics_data_layer_indicators,array($q22layer=>$sidc['indicators'][$q22layer]));
							}	
							if(array_key_exists($q22layer,$sidc['indicators_dataid'])){
								$layer_options=$this->Analytics_model->survey_data_options($sidc['indicators_dataid'][$q22layer],$q22['layer']);
								array_push($analytics_data_layer_options,array($q22layer=>$layer_options));
							}								
						}
					}	
					$analytics_data['layer_indicators']=$analytics_data_layer_indicators;
					$analytics_data['layer_options']=$analytics_data_layer_options;					
				}
				//$analytics_data['analytics_data_entry_keys']=$analytics_data_entry_keys;
				if(sizeof($analytics_data_entry_keys)>0){
					$analytics_data_entry_values=array();
					for($adek=0;$adek<sizeof($analytics_data_entry_keys);$adek++){
						$query3 = $this->db->query("select ".$analytics_data_entry_keys[$adek]." from analytics_".$survey_id." ");
						//echo $this->db->last_query()."\r\n";
						if($query3->num_rows()>0){
							$query3=$query3->result_array();
							$analytics_data_entry_values_temp=array();
							foreach($query3 as $q33){
								array_push($analytics_data_entry_values_temp,$q33[$analytics_data_entry_keys[$adek]]);
							}
							$key=0;
							if(in_array($analytics_data_entry_keys[$adek],$q22['rows'])){
								$key=array_search($analytics_data_entry_keys[$adek],$q22['rows']);
								$key++;
								$analytics_data_entry_values["rows".$key]=$analytics_data_entry_values_temp;
							}else if(in_array($analytics_data_entry_keys[$adek],$q22['columns'])){
								$key=array_search($analytics_data_entry_keys[$adek],$q22['columns']);
								$key++;
								$analytics_data_entry_values["columns".$key]=$analytics_data_entry_values_temp;
							}else if(in_array($analytics_data_entry_keys[$adek],$q22['layer'])){	
								$key=array_search($analytics_data_entry_keys[$adek],$q22['layer']);
								$key++;
								$analytics_data_entry_values["layer".$key]=$analytics_data_entry_values_temp;
							}else{}
						}
					}
					$analytics_data['entries']=$analytics_data_entry_values;
				}
				array_push($ad,$analytics_data);
			}
			$survey_data['analytics']=$ad;
		}else{
			$ad=array();
			$survey_data['analytics']=$ad;
		}	
		
		//adding track dashboards
		$query2 = $this->db->query("select * from dashboard_analytics where survey_id='".$survey_id."' && analytic_or_track='1' ");
		//echo $this->db->last_query();
		if($query2->num_rows()>0){				//getting analytics charts
			$query2=$query2->result_array();
			$ad=array();
			foreach($query2 as $q2){
				$q22=(array) json_decode($q2['analytics_post_data']);
				$analytics_data=array();
				$analytics_data_entry_keys=array();
				$analytics_data['id']=$q2['id'];
				$analytics_data_rows_indicators=array();
				$analytics_data_cols_indicators=array();
				$analytics_data_layer_indicators=array();
				$analytics_data_rows_options=array();
				$analytics_data_cols_options=array();
				$analytics_data_layer_options=array();
				if(strstr($q2['analytics_graph_url'],"frequency")){
					$analytics_data['type']="frequency";
				}else if(strstr($q2['analytics_graph_url'],"table")){
					$analytics_data['type']="table";
				}else if(strstr($q2['analytics_graph_url'],"table_layer")){
					$analytics_data['type']="table_layer";
				}else if(strstr($q2['analytics_graph_url'],"chart")){
					$analytics_data['type']="chart";
				}else{}
				//$analytics_data['analytics_graph_url']=$q2['analytics_graph_url'];
				if(isset($q22['chartType'])){
					$analytics_data['chartType']=$q22['chartType'];
				}
				if(isset($q22['rows'])){
					$analytics_data['rows']=$q22['rows'];
					if(sizeof($q22['rows'])>0){
						foreach($q22['rows'] as $q22rows){
							array_push($analytics_data_entry_keys,$q22rows);
							if(array_key_exists($q22rows,$sidc['indicators'])){
								array_push($analytics_data_rows_indicators,array($q22rows=>$sidc['indicators'][$q22rows]));
							}
							if(array_key_exists($q22rows,$sidc['indicators_dataid'])){
								$row_options=$this->Analytics_model->survey_data_options($sidc['indicators_dataid'][$q22rows],$q22['rows']);
								array_push($analytics_data_rows_options,array($q22rows=>$row_options));
							}							
						}
					}
					$analytics_data['rows_indicators']=$analytics_data_rows_indicators;
					$analytics_data['rows_options']=$analytics_data_rows_options;
				}
				if(isset($q22['columns'])){
					$analytics_data['columns']=$q22['columns'];
					if(sizeof($q22['columns'])>0){
						foreach($q22['columns'] as $q22columns){
							array_push($analytics_data_entry_keys,$q22columns);
							if(array_key_exists($q22columns,$sidc['indicators'])){
								array_push($analytics_data_cols_indicators,array($q22columns=>$sidc['indicators'][$q22columns]));
							}	
							if(array_key_exists($q22columns,$sidc['indicators_dataid'])){
								$col_options=$this->Analytics_model->survey_data_options($sidc['indicators_dataid'][$q22columns],$q22['columns']);
								array_push($analytics_data_cols_options,array($q22columns=>$col_options));
							}							
						}
					}
					$analytics_data['columns_indicators']=$analytics_data_cols_indicators;
					$analytics_data['cols_options']=$analytics_data_cols_options;
				}
				if(isset($q22['layer'])){
					$analytics_data['layer']=$q22['layer'];
					if(sizeof($q22['layer'])>0){
						foreach($q22['layer'] as $q22layer){
							array_push($analytics_data_entry_keys,$q22layer);
							if(array_key_exists($q22layer,$sidc['indicators'])){
								array_push($analytics_data_layer_indicators,array($q22layer=>$sidc['indicators'][$q22layer]));
							}	
							if(array_key_exists($q22layer,$sidc['indicators_dataid'])){
								$layer_options=$this->Analytics_model->survey_data_options($sidc['indicators_dataid'][$q22layer],$q22['layer']);
								array_push($analytics_data_layer_options,array($q22layer=>$layer_options));
							}								
						}
					}	
					$analytics_data['layer_indicators']=$analytics_data_layer_indicators;
					$analytics_data['layer_options']=$analytics_data_layer_options;					
				}
				//$analytics_data['analytics_data_entry_keys']=$analytics_data_entry_keys;
				if(sizeof($analytics_data_entry_keys)>0){
					$analytics_data_entry_values=array();
					for($adek=0;$adek<sizeof($analytics_data_entry_keys);$adek++){
						$query3 = $this->db->query("select ".$analytics_data_entry_keys[$adek]." from analytics_".$survey_id." ");
						//echo $this->db->last_query()."\r\n";
						if($query3->num_rows()>0){
							$query3=$query3->result_array();
							$analytics_data_entry_values_temp=array();
							foreach($query3 as $q33){
								array_push($analytics_data_entry_values_temp,$q33[$analytics_data_entry_keys[$adek]]);
							}
							$key=0;
							if(in_array($analytics_data_entry_keys[$adek],$q22['rows'])){
								$key=array_search($analytics_data_entry_keys[$adek],$q22['rows']);
								$key++;
								$analytics_data_entry_values["rows".$key]=$analytics_data_entry_values_temp;
							}else if(in_array($analytics_data_entry_keys[$adek],$q22['columns'])){
								$key=array_search($analytics_data_entry_keys[$adek],$q22['columns']);
								$key++;
								$analytics_data_entry_values["columns".$key]=$analytics_data_entry_values_temp;
							}else if(in_array($analytics_data_entry_keys[$adek],$q22['layer'])){	
								$key=array_search($analytics_data_entry_keys[$adek],$q22['layer']);
								$key++;
								$analytics_data_entry_values["layer".$key]=$analytics_data_entry_values_temp;
							}else{}
						}
					}
					$analytics_data['entries']=$analytics_data_entry_values;
				}
				array_push($ad,$analytics_data);
			}
			$survey_data['track']=$ad;
		}else{
			$ad=array();
			$survey_data['track']=$ad;
		}			
		
		$dashboards=array();
		$dashboards['dashboard_detail']=$survey_data;
		echo json_encode($dashboards);
		$this->logAndroid();
	}
	
	
}

