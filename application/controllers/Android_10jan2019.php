<?php
//ob_implicit_flush();
//set_time_limit(0);
//ini_set('memory_limit', '80000M');

defined('BASEPATH') OR exit('No direct script access allowed');
class Android extends CI_Controller {
	public $function_list=array();
	public $get;
	public $post;
	public $all_operators=array();
	public $relationship_operators=array();
	public function __construct(){
		$this->function_list=array('getVal'=>'1','setVal'=>'2','isRequired'=>'1','isNum'=>'1','isAlpha'=>'1','toCaps'=>'1','isAlphaNum'=>'1','isRange'=>'2','isFixed'=>'2','doHide'=>'2','doShow'=>'2','msg'=>'1','doJumpForward'=>'2','openBox'=>'3','dateDiff'=>'3','today'=>'1','now'=>'1','gps'=>'2','doColumnHide'=>'2','doColumnShow'=>'2','random'=>'1','getStates'=>'1','getDistricts'=>'2','skip'=>'2','endSurvey'=>'1','toFocus'=>'1','doMax'=>'1','doMin'=>'1','doBlock'=>'1','doUnblock'=>'1','doCheck'=>'2','doUncheck'=>'2','doPlus'=>'2','doMinus'=>'2','doMultiply'=>'2','doDivide'=>'2','doConcat'=>'2','doRowHide'=>'2','doRowShow'=>'2','setQtext'=>'2','getLabel'=>'1','isMobile'=>'3');		
		$this->all_operators=array('==','>=','<=','!=','&&', '||', '>', '<');		
		$this->relationship_operators=array('&&', '||');		
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
          }else if($func=="user_dashboard_timeline"){
			$this->get=$this->input->get();
			$this->post=$this->input->post();			
			$this->user_dashboard_timeline($p);			
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
		}else if($func=="survey_records"){
			$this->get=$this->input->get();
			$this->post=$this->input->post();
			$this->survey_records($p);			
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
				$arr['json_data']=(array) json_decode($arr['json_data']);
				if(isset($arr['json_data']['type'])){
					for($i=0;$i<sizeof($arr['json_data']['type']);$i++){
						if($arr['json_data']['type'][$i]==""){
							$arr['json_data']['type'][$i]="Textbox";
						}
					}
				$arr['json_data']=(object) $arr['json_data'];
				}
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
		if($this->input->post('data')){
			$total_entries_added=0;
			$data=$this->input->post('data');
			$data=json_decode($data);
			$entries=$data->data->entries;
			//creating entries
			foreach($entries as $e){
				$exist=$this->db->query("select count(*) as total from survey_values where survey_case_id='".$e->survey_case_id."' ");
				if($exist->num_rows()>0){
					$exist=$exist->result_array();
					$exist=$exist[0]['total'];
					if($exist<1){
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
				}
			}
			if($total_entries_added>0){
				echo json_encode(array('success'=>'1','message'=>$total_entries_added." entries added successfully"));
			}else{
				echo json_encode(array('success'=>'1','message'=>"No entries added"));
			}
		}else{
			echo json_encode(array('success'=>'0','message'=>"No entries posted"));
		}
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
	function getFromToListIds($parameters,$all_element_ids_linewise,$all_code_name_ids_linewise,$function_name){
		$new_parameters=array();
		
		if(isset($parameters['from_id']) && !isset($parameters['to_id'])){
			$parameters['to_id']=end($all_element_ids_linewise);
		}
		$parameters['from_id']=trim(str_replace('"','',$parameters['from_id']));
		$parameters['to_id']=trim(str_replace('"','',$parameters['to_id']));
		
		$new_parameters['from_id']=$parameters['from_id'];
		$new_parameters['to_id']=$parameters['to_id'];

		$return_ids=array();
		$from_index='';
		$to_index='';
		if(in_array($new_parameters['from_id'],$all_element_ids_linewise)){
			$from_index=array_search($new_parameters['from_id'],$all_element_ids_linewise);
		}else{
			if(array_key_exists($new_parameters['from_id'],$all_code_name_ids_linewise)){
				$from_index=array_search($all_code_name_ids_linewise[$new_parameters['from_id']],$all_element_ids_linewise);
			}else{
				//echo "not exist ".$new_parameters['from_id']."\r\n";
				//print_r($new_parameters);
			}
		}
		if(in_array($new_parameters['to_id'],$all_element_ids_linewise)){
			$to_index=array_search($new_parameters['to_id'],$all_element_ids_linewise);
		}else{
			if(array_key_exists($new_parameters['to_id'],$all_code_name_ids_linewise)){
				$to_index=array_search($all_code_name_ids_linewise[$new_parameters['to_id']],$all_element_ids_linewise);
			}else{
				//print_r($new_parameters);
			}
		}
		if($from_index!='' && $to_index!=''){				//this could be possibly gives error because 
			for($i=$from_index;$i<=$to_index;$i++){			//anyone 1 could be blank check it
				array_push($return_ids,$all_element_ids_linewise[$i]);
			}
		}else if($from_index!=''){
			array_push($return_ids,$all_element_ids_linewise[$from_index]);
		}else{
			//print_r($new_parameters);
		}
		$new_parameters['ids']=$return_ids;
		//$new_parameters['ids']=$parameters;
		if($function_name=="skip"){
			//print_r($new_parameters);
			for($i=0;$i<sizeof($new_parameters['ids']);$i++){
				if($new_parameters['ids'][$i]==$new_parameters['from_id']){
					unset($new_parameters['ids'][$i]);
				}
			}
			$new_parameters['ids'] = array_values($new_parameters['ids']);
			//print_r($new_parameters);			
			for($i=0;$i<sizeof($new_parameters['ids']);$i++){
				if($new_parameters['ids'][$i]==$new_parameters['to_id']){
					unset($new_parameters['ids'][$i]);
				}
			}
			$new_parameters['ids'] = array_values($new_parameters['ids']);
			//print_r($new_parameters);
		}
		return $new_parameters;
	}
	function getIdsFromCountListIds($parameters,$all_element_ids_linewise,$all_code_name_ids_linewise,$function_name){
		//print_r($all_element_ids_linewise);die;
		//print_r($all_code_name_ids_linewise);die;
		$parameters['Nos']=trim($parameters['Nos']);
		if(array_key_exists($parameters['id'],$all_code_name_ids_linewise)){				//necesary to convert code name to auto names
			$parameters['id']=$all_code_name_ids_linewise[$parameters['id']];
		}
		if(in_array($parameters['id'],$all_element_ids_linewise)){
			$from_index=array_search($parameters['id'],$all_element_ids_linewise);			//necessary to get start index
		}
		if($function_name=="doColumnHide" || $function_name=="doColumnShow"){
			//$parameters['id']="answer_b00_0$6";
			//$parameters['Nos']="1";		//0,3,-1			
			if($parameters['Nos']=="0"){
				if (strpos($parameters['id'], 'answer_') !== false) {
					if (strpos($parameters['id'], 'dd_') !== false) {
						$new_parameters_id=str_replace("answer_dd_","",$parameters['id']);					
					}else if (strpos($parameters['id'], 'mm_') !== false) {
						$new_parameters_id=str_replace("answer_mm_","",$parameters['id']);	
					}else if (strpos($parameters['id'], 'yyyy_') !== false) {
						$new_parameters_id=str_replace("answer_yyyy_","",$parameters['id']);	
					}else{
						$new_parameters_id=str_replace("answer_","",$parameters['id']);					
					}
					//echo $new_parameters_id."\r\n";														//b00_0$0
					$new_parameters_id=substr($new_parameters_id,0,strripos($new_parameters_id,"$"));		//b00_0
					$ids=array();
					foreach($all_element_ids_linewise as $aeil){
						if (strpos($aeil, $new_parameters_id) !== false) {
							array_push($ids,$aeil);
						}
					}
				}
				//removing starting id incase of zero
				unset($ids[0]);	
				$ids = array_values($ids);
				$parameters['ids']=$ids;				
			}else if($parameters['Nos']=="-1"){
				$ids=array($parameters['id']);
				$parameters['ids']=$ids;				
			}else{
				if (strpos($parameters['id'], 'answer_') !== false) {
					if (strpos($parameters['id'], 'dd_') !== false) {
						$new_parameters_id=str_replace("answer_dd_","",$parameters['id']);					
					}else if (strpos($parameters['id'], 'mm_') !== false) {
						$new_parameters_id=str_replace("answer_mm_","",$parameters['id']);	
					}else if (strpos($parameters['id'], 'yyyy_') !== false) {
						$new_parameters_id=str_replace("answer_yyyy_","",$parameters['id']);	
					}else{
						$new_parameters_id=str_replace("answer_","",$parameters['id']);					
					}
					//echo $new_parameters_id."\r\n";														//b00_0$0
					$new_parameters_id=substr($new_parameters_id,0,strripos($new_parameters_id,"$"));		//b00_0
					$ids=array();
					foreach($all_element_ids_linewise as $aeil){
						if (strpos($aeil, $new_parameters_id) !== false) {
							array_push($ids,$aeil);
						}
					}
					//print_r($ids);
					$start_index=array_search($parameters['id'],$ids);
					//echo "start_index: ".$start_index."\r\n";
					$new_parameters_id_2=substr($parameters['id'],0,strripos($parameters['id'],"$"))."$";	//answer_b00_0$
					$col_no=str_replace($new_parameters_id_2,"",$parameters['id']);
					$search_text=$new_parameters_id."$".($parameters['Nos']+$col_no);						//b00_0$17
					//echo $search_text."\r\n";
					$new_ids=array();
					foreach($all_element_ids_linewise as $aeil){
						if (strpos($aeil, $search_text) !== false) {
							array_push($new_ids,$aeil);
						}
					}				
					//print_r($ids);	
					$last_id=end($new_ids);		
					//echo "last id: ".$last_id."\r\n";															//answer_m_b00_0$17
					$end_index=array_search($last_id,$ids);
					//echo "end_index: ".$end_index."\r\n";
					$new_ids2=array_slice($ids,($start_index+1),($end_index-$start_index));
					$parameters['ids']=$new_ids2;
				}
			}
			//print_r($parameters['ids']);die;
		}
		if($function_name=="doRowHide" || $function_name=="doRowShow"){
			//$parameters['id']="answer_b00_0$0";
			//$parameters['Nos']="-1";		//0,3,-1			
			if($parameters['Nos']=="0"){
				if (strpos($parameters['id'], 'answer_') !== false) {
					if (strpos($parameters['id'], 'dd_') !== false) {
						$new_parameters_id=str_replace("answer_dd_","",$parameters['id']);					
					}else if (strpos($parameters['id'], 'mm_') !== false) {
						$new_parameters_id=str_replace("answer_mm_","",$parameters['id']);	
					}else if (strpos($parameters['id'], 'yyyy_') !== false) {
						$new_parameters_id=str_replace("answer_yyyy_","",$parameters['id']);	
					}else{
						$new_parameters_id=str_replace("answer_","",$parameters['id']);					
					}
					//echo $new_parameters_id."\r\n";														//b00_0$0
					$new_parameters_id=substr($new_parameters_id,0,strripos($new_parameters_id,"$"));		//b00_0
					$ids_tobe_excluded=array();
					foreach($all_element_ids_linewise as $aeil){
						if (strpos($aeil, $new_parameters_id) !== false) {
							array_push($ids_tobe_excluded,$aeil);
						}
					}
					$new_parameters_id2=substr($new_parameters_id,0,strripos($new_parameters_id,"_"));		//b00
					$ids_all_matrix=array();
					foreach($all_element_ids_linewise as $aeil){
						if (strpos($aeil, $new_parameters_id2) !== false) {
							array_push($ids_all_matrix,$aeil);
						}
					}	
					$start_index=(array_search(end($ids_tobe_excluded),$ids_all_matrix)+1);	
					$end_count=(sizeof($ids_all_matrix)-$start_index);	
					$new_ids2=array_slice($ids_all_matrix,$start_index,$end_count);
					$parameters['ids']=$new_ids2;
				}
			}else if($parameters['Nos']=="-1"){
				if (strpos($parameters['id'], 'answer_') !== false) {
					if (strpos($parameters['id'], 'dd_') !== false) {
						$new_parameters_id=str_replace("answer_dd_","",$parameters['id']);					
					}else if (strpos($parameters['id'], 'mm_') !== false) {
						$new_parameters_id=str_replace("answer_mm_","",$parameters['id']);	
					}else if (strpos($parameters['id'], 'yyyy_') !== false) {
						$new_parameters_id=str_replace("answer_yyyy_","",$parameters['id']);	
					}else{
						$new_parameters_id=str_replace("answer_","",$parameters['id']);					
					}
					//echo $new_parameters_id."\r\n";														//b00_0$0
					$new_parameters_id=substr($new_parameters_id,0,strripos($new_parameters_id,"$"));		//b00_0
					$ids=array();
					foreach($all_element_ids_linewise as $aeil){
						if (strpos($aeil, $new_parameters_id) !== false) {
							array_push($ids,$aeil);
						}
					}
				}
				$parameters['ids']=$ids;
			}else{
				if (strpos($parameters['id'], 'answer_') !== false) {
					if (strpos($parameters['id'], 'dd_') !== false) {
						$new_parameters_id=str_replace("answer_dd_","",$parameters['id']);					
					}else if (strpos($parameters['id'], 'mm_') !== false) {
						$new_parameters_id=str_replace("answer_mm_","",$parameters['id']);	
					}else if (strpos($parameters['id'], 'yyyy_') !== false) {
						$new_parameters_id=str_replace("answer_yyyy_","",$parameters['id']);	
					}else{
						$new_parameters_id=str_replace("answer_","",$parameters['id']);					
					}
					//echo $new_parameters_id."\r\n";														//b00_0$0
					$new_parameters_id=substr($new_parameters_id,0,strripos($new_parameters_id,"$"));		//b00_0
					$ids_tobe_excluded=array();
					foreach($all_element_ids_linewise as $aeil){
						if (strpos($aeil, $new_parameters_id) !== false) {
							array_push($ids_tobe_excluded,$aeil);
						}
					}
					$new_parameters_id2=substr($new_parameters_id,0,strripos($new_parameters_id,"_"));		//b00
					$ids_all_matrix=array();
					foreach($all_element_ids_linewise as $aeil){
						if (strpos($aeil, $new_parameters_id2) !== false) {
							array_push($ids_all_matrix,$aeil);
						}
					}	
					$start_index=(array_search(end($ids_tobe_excluded),$ids_all_matrix)+1);	
					$end_count=(sizeof($ids_all_matrix)-$start_index);	
					$new_ids2=array_slice($ids_all_matrix,$start_index,$end_count);
					$new_parameters_id_3=substr($parameters['id'],0,strripos($parameters['id'],"$"));			//answer_b00_1
					$new_parameters_id_4=substr($new_parameters_id_3,0,strripos($new_parameters_id_3,"_"))."_";		//answer_b00_		
					$row_no=str_replace($new_parameters_id_4,"",$new_parameters_id_3);	
					$search_text=$new_parameters_id2."_".($parameters['Nos']+$row_no);
					$last_ids_array=array();
					foreach($new_ids2 as $ni2){
						if (strpos($ni2, $search_text) !== false) {
							array_push($last_ids_array,$ni2);
						}
					}	
					$last_id=end($last_ids_array);
					$end_index=array_search($last_id,$new_ids2);
					$new_ids3=array_slice($new_ids2,0,($end_index+1));
					$parameters['ids']=$new_ids3;
				}
			}	
		}
		return $parameters;
	}	
	function statementsToJson($statement,$all_element_ids_linewise,$all_code_name_ids_linewise){
		if(strlen($statement)>5){
			$pre_code_new=array();
			foreach($this->function_list as $fl_k=>$fl_v){		//search for functions in line
				if(strstr($statement,$fl_k)){
					$pcn=preg_split('/'.$fl_k.'/',$statement);
					$pcn[0]=str_replace('var ','',$pcn[0]);
					$pcn[0]=str_replace('=','',$pcn[0]);
					$pcn[1]=str_replace('(','',$pcn[1]);
					$pcn[1]=str_replace(')','',$pcn[1]);
					$pcn[1]=str_replace(';','',$pcn[1]);

					//$pcn[1]=str_replace("'",'',$pcn[1]);
					$pcn[1]=explode(',',$pcn[1]);
					$pcn[1][0]=str_replace("\r",'',$pcn[1][0]);
					$pcn[1][0]=str_replace("\t",'',$pcn[1][0]);					
					$pre_code_new['function']=$fl_k;
					if($pre_code_new['function']=="getVal"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));
						$pre_code_new['parameters']=array("id"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="setVal"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));						
						$pcn[1][1]=trim($pcn[1][1]);
						if(strstr($pcn[1][1],"'")){
							$pcn[1]=str_replace("'",'',$pcn[1]);
							$pre_code_new['parameters']=array("id"=>$pcn[1][0],"value"=>$pcn[1][1],"type_value"=>"text");
						}else{
							$pre_code_new['parameters']=array("id"=>$pcn[1][0],"value"=>$pcn[1][1],"type_value"=>"reference");
						}
					}else if($pre_code_new['function']=="isRequired"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));						
						$pre_code_new['parameters']=array("id"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="isNum"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));						
						$pre_code_new['parameters']=array("id"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="isAlpha"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));						
						$pre_code_new['parameters']=array("id"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="isAlphaNum"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));						
						$pre_code_new['parameters']=array("id"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="isRange"){
						$pcn[1]=str_replace("'",'',$pcn[1]);
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
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));	
						$pcn[1][1]=str_replace("'",'',trim($pcn[1][1]));		
						$pre_code_new['parameters']=array("id"=>$pcn[1][0],"value"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="doHide"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));						
						$pcn[1][1]=str_replace("'",'',trim($pcn[1][1]));			
						$pre_code_new['parameters']=array("from_id"=>$pcn[1][0],"to_id"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="doShow"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));
						$pcn[1][1]=str_replace("'",'',trim($pcn[1][1]));
						$pre_code_new['parameters']=array("from_id"=>$pcn[1][0],"to_id"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="msg"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));						
						$pre_code_new['parameters']=array("message"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="doJumpForward"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));						
						$pcn[1][1]=str_replace("'",'',trim($pcn[1][1]));						
						$pre_code_new['parameters']=array("from_id"=>$pcn[1][0],"to_id"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="openBox"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));
						$pcn[1][2]=str_replace("'",'',trim($pcn[1][2]));
						$pre_code_new['parameters']=array("id"=>$pcn[1][0],"id_array"=>$pcn[1][1],"message"=>$pcn[1][2]);
					}else if($pre_code_new['function']=="dateDiff"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));						
						$pcn[1][1]=str_replace("'",'',trim($pcn[1][1]));							
						$pcn[1][2]=str_replace("'",'',trim($pcn[1][2]));							
						$pre_code_new['parameters']=array("start_date"=>$pcn[1][0],"end_date"=>$pcn[1][1],"datekey"=>$pcn[1][2]);
					}else if($pre_code_new['function']=="today"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));
						$pre_code_new['parameters']=array("key"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="now"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));
						$pre_code_new['parameters']=array("key"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="gps"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));
						$pcn[1][1]=str_replace("'",'',trim($pcn[1][1]));						
						$pre_code_new['parameters']=array("key"=>$pcn[1][0],"id"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="doColumnHide"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));						
						$pre_code_new['parameters']=array("id"=>$pcn[1][0],"Nos"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="doColumnShow"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));						
						$pre_code_new['parameters']=array("id"=>$pcn[1][0],"Nos"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="random"){
						$pre_code_new['parameters']=array("id_array"=>trim($pcn[1][0]));
					}else if($pre_code_new['function']=="getStates"){
						$pcn[1][0]=str_replace("'",'',$pcn[1][0]);						
						$pre_code_new['parameters']=array("id"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="getDistricts"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));						
						$pre_code_new['parameters']=array("id"=>$pcn[1][0],"state_id"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="skip"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));						
						$pcn[1][1]=str_replace("'",'',trim($pcn[1][1]));							
						$pre_code_new['parameters']=array("from_id"=>$pcn[1][0],"to_id"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="endSurvey"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));						
						$pre_code_new['parameters']=array("from_id"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="toFocus"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));						
						$pre_code_new['parameters']=array("id"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="doMax"){
						$pre_code_new['parameters']=array("id_array"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="doMin"){
						$pre_code_new['parameters']=array("id_array"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="doBlock"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));						
						$pre_code_new['parameters']=array("id"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="doUnblock"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));						
						$pre_code_new['parameters']=array("id"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="doCheck"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));		
						$pcn[1][1]=str_replace("'",'',trim($pcn[1][1]));	
						$pre_code_new['parameters']=array("id"=>$pcn[1][0],"value"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="doUncheck"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));						
						$pre_code_new['parameters']=array("id"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="toCaps"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));						
						$pre_code_new['parameters']=array("id"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="doPlus"){
						$pre_code_new['parameters']=array("id_array"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="doMinus"){
						$pcn_v1='';
						$pcn_v2='';
						if(strstr($pcn[1][0],"'")){
							$pcn[1][0]=trim(str_replace("'","",$pcn[1][0]));
							$pcn_v1="text";
						}else{
							$pcn_v1="reference";
						}	
						if(strstr($pcn[1][1],"'")){
							$pcn[1][1]=trim(str_replace("'","",$pcn[1][1]));
							$pcn_v2="text";
						}else{
							$pcn_v2="reference";
						}					
						$pcn[1][0]=trim($pcn[1][0]);
						$pcn[1][1]=trim($pcn[1][1]);						
						$pre_code_new['parameters']=array("value1"=>$pcn[1][0],"value2"=>$pcn[1][1],"type_value1"=>$pcn_v1,"type_value2"=>$pcn_v2);
					}else if($pre_code_new['function']=="doMultiply"){
						$pcn_v1='';
						$pcn_v2='';
						if(strstr($pcn[1][0],"'")){
							$pcn[1][0]=trim(str_replace("'","",$pcn[1][0]));
							$pcn_v1="text";
						}else{
							$pcn_v1="reference";
						}	
						if(strstr($pcn[1][1],"'")){
							$pcn[1][1]=trim(str_replace("'","",$pcn[1][1]));
							$pcn_v2="text";
						}else{
							$pcn_v2="reference";
						}					
						$pcn[1][0]=trim($pcn[1][0]);

						$pcn[1][1]=trim($pcn[1][1]);						
						$pre_code_new['parameters']=array("value1"=>$pcn[1][0],"value2"=>$pcn[1][1],"type_value1"=>$pcn_v1,"type_value2"=>$pcn_v2);
					}else if($pre_code_new['function']=="doDivide"){
						$pcn_v1='';
						$pcn_v2='';
						if(strstr($pcn[1][0],"'")){
							$pcn[1][0]=trim(str_replace("'","",$pcn[1][0]));
							$pcn_v1="text";
						}else{
							$pcn_v1="reference";
						}	
						if(strstr($pcn[1][1],"'")){
							$pcn[1][1]=trim(str_replace("'","",$pcn[1][1]));
							$pcn_v2="text";
						}else{
							$pcn_v2="reference";
						}					
						$pcn[1][0]=trim($pcn[1][0]);
						$pcn[1][1]=trim($pcn[1][1]);
						$pre_code_new['parameters']=array("value1"=>$pcn[1][0],"value2"=>$pcn[1][1],"type_value1"=>$pcn_v1,"type_value2"=>$pcn_v2);
					}else if($pre_code_new['function']=="doConcat"){
						//$pre_code_new['parameters']=array("value1"=>$pcn[1][0],"value2"=>$pcn[1][1]);
						$pre_code_new['parameters']=array("id_array"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="doRowHide"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));						
						$pre_code_new['parameters']=array("id"=>$pcn[1][0],"Nos"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="doRowShow"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));						
						$pre_code_new['parameters']=array("id"=>$pcn[1][0],"Nos"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="setQtext"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));						
						$pre_code_new['parameters']=array("id"=>$pcn[1][0],"res_object"=>$pcn[1][1]);
					}else if($pre_code_new['function']=="getLabel"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));						
						$pre_code_new['parameters']=array("id"=>$pcn[1][0]);
					}else if($pre_code_new['function']=="isMobile"){
						$pcn[1][0]=str_replace("'",'',trim($pcn[1][0]));						
						$pre_code_new['parameters']=array("id"=>$pcn[1][0],"digits"=>$pcn[1][1],"minimum_digit"=>$pcn[1][2]);
					}else{}
					//$pre_code_new['parameters']=$pcn[1];
					
					/*testing*/
					if($pre_code_new['function']=="skip" || $pre_code_new['function']=="doHide" || $pre_code_new['function']=="doShow" || $pre_code_new['function']=="doJumpForward"){
						$pre_code_new['parameters']=$this->getFromToListIds($pre_code_new['parameters'],$all_element_ids_linewise,$all_code_name_ids_linewise,$pre_code_new['function']);
						//$pre_code_new['parameters']='';
						//die;
					}
					if($pre_code_new['function']=="endSurvey"){
						$pre_code_new['parameters']=$this->getFromToListIds($pre_code_new['parameters'],$all_element_ids_linewise,$all_code_name_ids_linewise,$pre_code_new['function']);
						//$pre_code_new['parameters']='';
						//print_r($pre_code_new);
						//die;
					}
					if($pre_code_new['function']=="doRowHide" || $pre_code_new['function']=="doRowShow" || $pre_code_new['function']=="doColumnHide" || $pre_code_new['function']=="doColumnShow"){
						$pre_code_new['parameters']=$this->getIdsFromCountListIds($pre_code_new['parameters'],$all_element_ids_linewise,$all_code_name_ids_linewise,$pre_code_new['function']);
					}
					/*testing*/
					
					$pcn[0]=str_replace("\r",'',$pcn[0]);


					$pcn[0]=str_replace("\n",'',$pcn[0]);
					$pcn[0]=str_replace("\t",'',$pcn[0]);
					$pcn[0]=trim($pcn[0]);
					
					//temporary returns filter
					if($pre_code_new['function']=="doShow" || $pre_code_new['function']=="doHide"){
						$pcn[0]="";
					}


					/* very tough to find out that's why replacing whenever occur*/
					if(strstr($pcn[0],'else{')){
						$pcn[0]='';
					}
					/* very tough to find out that's why replacing whenever occur*/
					$pre_code_new['returns']=$pcn[0];
					//break;
				}
			}			
			//print_r($pre_code_new);
			$statement=$pre_code_new;
		}
		return $statement;
	}
	function constantStatementsToJson($statement,$all_element_ids_linewise,$all_code_name_ids_linewise){
		//print_r($all_element_ids_linewise);
		//print_r($all_code_name_ids_linewise);
		//die;
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
					$s[1]=str_replace("' '",'@@@',$s[1]);
					$s[1]=str_replace(' ','',$s[1]);
					$s[1]=str_replace("@@@","' '",$s[1]);
					$s[1]=str_replace("'",'"',$s[1]);
					$ns['variable']=trim($s[0]);
					if(strstr($s[1],'[')){
						$s[1]=json_decode($s[1]);
						$ns['array']=$s[1];
						$ns['type_array']=array();
						if($ns['variable']=="mm"){
							if(is_array($ns['array'])){
								for($i=0;$i<sizeof($ns['array']);$i++){
									if(array_key_exists(strtolower($ns['array'][$i]),$all_code_name_ids_linewise)){
										$ns['array'][$i]=$all_code_name_ids_linewise[strtolower($ns['array'][$i])];
									}									
								}
							}
						}
						foreach($ns['array'] as $nsa){
							if(in_array($nsa,$all_element_ids_linewise)){
								array_push($ns['type_array'],"id");
							}else{
								array_push($ns['type_array'],"text");
							}
						}
					}else if(strstr($s[1],'{')){
						$s[1]=str_replace('{','',$s[1]);
						$s[1]=str_replace('}','',$s[1]);
						$s[1]=explode(',',$s[1]);
						//print_r($s[1]);
						$s1=array();
						$s1_object='';
						foreach($s[1] as $s1new){
							$s1new=explode(":",$s1new);
							if(strstr($s1new[0],'object')){
								$s1_object=$s1new[1];
							}
						}
						//echo $s1_object."\r\n";
						$ns['type_object']=array();
						$array_object=array();
						foreach($s[1] as $s1_inner){
							$s1_inner=explode(':',$s1_inner);
							//print_r($s1_inner);
							$s1_inner[0]=str_replace('"','',$s1_inner[0]);
							$s1_inner[0]=str_replace("'",'',$s1_inner[0]);
							$s1_inner[1]=str_replace('"','',$s1_inner[1]);
							$s1_inner[1]=str_replace("'",'',$s1_inner[1]);
							if($s1_inner[0]!='object'){
								if(strstr($s1_inner[1],'.')){
									$s1_inner[1]=$s1_object.$s1_inner[1];
									array_push($ns['type_object'],"reference");
								}else{
									array_push($ns['type_object'],"text");
								}
								$inner_arr=array(
									"append_key"=>$s1_inner[0],
									"data"=>$s1_inner[1]								
								);
								array_push($array_object,$inner_arr);
							}
						}
						$ns['object']=$array_object;
					}else if(strstr($s[1],'+')){
						$s[1]=explode('+',$s[1]);
						$ns['array']=array();
						$ns['type_array']=array();
						foreach($s[1] as $nsa){
							if(strstr($nsa,'"')){
								array_push($ns['type_array'],"text");
							}else{
								array_push($ns['type_array'],"reference");
							}							
							$nsa=str_replace('"','',$nsa);
							array_push($ns['array'],$nsa);
						}						
					}else{
						if($s[1]!=''){
							if(strstr($s[1],'"')){
								$ns['type_array']=array("text");
							}else{
								$ns['type_array']=array("reference");
							}
							$s[1]=str_replace('"','',$s[1]);							
							$ns['array']=array($s[1]);
						}
					}
				}
				array_push($new_statement,$ns);
			}
			//print_r($new_statement);
		}
		//return $statement;
		//return $new_statement;
		if(sizeof($new_statement)>0){
			$new_statement=$new_statement[0];
		}
		return $new_statement;
	}
	function invertCodeNames($c,$code_name_array){
		$c=str_replace('"',"'",$c);			//replacing double quotes to single ones
		foreach($code_name_array as $sqcn_k=>$sqcn_v){
			$c=str_replace("'".$sqcn_v."'","'".$sqcn_k."'",$c);	//inner code
			$c=str_replace("//".$sqcn_v."//","//".$sqcn_k."//",$c);	//main element names with double slashes
		}
		return $c;
	}	
	function codeToJson($code='',$all_element_ids_linewise,$all_code_name_ids_linewise){
		$all_code=array();
		if($code!=''){
			//print_r($code);
			$all_code_name_ids_linewise=array_flip($all_code_name_ids_linewise);
			$code=$this->invertCodeNames($code,$all_code_name_ids_linewise);
			$all_code_name_ids_linewise=array_flip($all_code_name_ids_linewise);
			
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
				$pre_code_list=array();
				$pre_statements=array();
				if(strstr($pre_code,"else if")){				
					$pre_code=preg_split('/else if[(]/',$pre_code);
					for($i=0;$i<sizeof($pre_code);$i++){
						if($i!=0){
							$pre_code[$i]="ilse ef(".$pre_code[$i];
						}
						if(strstr($pre_code[$i],"if")){
							$pre_code[$i]=preg_split('/if[(]/',$pre_code[$i]);
							for($j=0;$j<sizeof($pre_code[$i]);$j++){
								if($j!=0){
									$pre_code[$i][$j]="if(".$pre_code[$i][$j];
									array_push($pre_code_list,$pre_code[$i][$j]);
								}	
							}	
							//print_r($pre_code[$i]);
							for($j=0;$j<sizeof($pre_code[$i]);$j++){	//should only work for non conditional statements
								if(!is_array($pre_code[$i][$j]) && !(strstr($pre_code[$i][$j],"if("))){
									$pre_code[$i][$j]=str_replace(';',';'.PHP_EOL,$pre_code[$i][$j]);
									$pre_code[$i][$j]=explode(PHP_EOL,$pre_code[$i][$j]);
									for($l=0;$l<sizeof($pre_code[$i][$j]);$l++){
										if($pre_code[$i][$j][$l]!=''){
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
												$pre_code[$i][$j][$l]=$this->statementsToJson($pre_code[$i][$j][$l],$all_element_ids_linewise,$all_code_name_ids_linewise);
											}else{
												$pre_code[$i][$j][$l]=array('constant'=>$this->constantStatementsToJson($pre_code[$i][$j][$l],$all_element_ids_linewise,$all_code_name_ids_linewise));
											}	
											array_push($pre_statements,$pre_code[$i][$j][$l]);
										}else{
											unset($pre_code[$i][$j][$l]);
										}
									}	
								}
							}
						}
						if(!is_array($pre_code[$i]) && strstr($pre_code[$i],"else")){	
							$pre_code[$i]=preg_split('/else/',$pre_code[$i]);
							for($j=0;$j<sizeof($pre_code[$i]);$j++){
								if(strstr($pre_code[$i][$j],"ilse ef")){
									$pre_code[$i][$j]=str_replace("ilse ef","else if",$pre_code[$i][$j]);
									array_push($pre_code_list,$pre_code[$i][$j]);
								}
								if($j!=0){
									$pre_code[$i][$j]="else".$pre_code[$i][$j];
									array_push($pre_code_list,$pre_code[$i][$j]);
								}
							}
						}
						if(!is_array($pre_code[$i]) && strstr($pre_code[$i],"ilse ef(")){
							$pre_code[$i]=preg_split('/ilse ef[(]/',$pre_code[$i]);
							for($j=0;$j<sizeof($pre_code[$i]);$j++){
								if($j!=0){
									$pre_code[$i][$j]="ilse ef(".$pre_code[$i][$j];
									array_push($pre_code_list,$pre_code[$i][$j]);
								}	
							}	
							//print_r($pre_code[$i]);
							for($j=0;$j<sizeof($pre_code[$i]);$j++){
								if(!is_array($pre_code[$i][$j]) && strstr($pre_code[$i][$j],"var ")){
									$pre_code[$i][$j]=str_replace(';',';'.PHP_EOL,$pre_code[$i][$j]);
									$pre_code[$i][$j]=explode(PHP_EOL,$pre_code[$i][$j]);
									for($l=0;$l<sizeof($pre_code[$i][$j]);$l++){
										if($pre_code[$i][$j][$l]!=''){
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
												$pre_code[$i][$j][$l]=$this->statementsToJson($pre_code[$i][$j][$l],$all_element_ids_linewise,$all_code_name_ids_linewise);
											}else{
												$pre_code[$i][$j][$l]=array('constant'=>$this->constantStatementsToJson($pre_code[$i][$j][$l],$all_element_ids_linewise,$all_code_name_ids_linewise));
											}	
											array_push($pre_statements,$pre_code[$i][$j][$l]);
										}else{
											unset($pre_code[$i][$j][$l]);
										}
									}	
								}
							}
						}
					}
				}else if(strstr($pre_code,"if")){
					$pre_code=preg_split('/if[(]/',$pre_code);
					for($i=0;$i<sizeof($pre_code);$i++){
						if($i!=0){
							$pre_code[$i]="if(".$pre_code[$i];
						}
					}
					for($i=0;$i<sizeof($pre_code);$i++){
						if(strstr($pre_code[$i],"else")){
							$pre_code[$i]=preg_split('/else/',$pre_code[$i]);
							for($j=0;$j<sizeof($pre_code[$i]);$j++){
								if($j!=0){
									$pre_code[$i][$j]="else".$pre_code[$i][$j];
								}	
								array_push($pre_code_list,$pre_code[$i][$j]);
							}	
						}
						if(!is_array($pre_code[$i]) && strstr($pre_code[$i],"var ")){
							$pre_code[$i]=str_replace(';',';'.PHP_EOL,$pre_code[$i]);
							$pre_code[$i]=explode(PHP_EOL,$pre_code[$i]);
							
							for($l=0;$l<sizeof($pre_code[$i]);$l++){
								if($pre_code[$i][$l]!=''){
									$found=false;
									$found_function='';
									foreach($this->function_list as $fl_k=>$fl_v){		//search for functions in line
										if(strstr($pre_code[$i][$l],$fl_k)){								
											$found=true;
											$found_function=$fl_k;
											break;
										}
									}
									if($found==true && $found_function!=''){
										$pre_code[$i][$l]=$this->statementsToJson($pre_code[$i][$l],$all_element_ids_linewise,$all_code_name_ids_linewise);
									}else{
										$pre_code[$i][$l]=array('constant'=>$this->constantStatementsToJson($pre_code[$i][$l],$all_element_ids_linewise,$all_code_name_ids_linewise));
									}	
									array_push($pre_statements,$pre_code[$i][$l]);
								}else{
									unset($pre_code[$i][$l]);
								}
							}	
						}
					}				
				}else{
					$pre_code=str_replace(';',';'.PHP_EOL,$pre_code);
					$pre_code=explode(PHP_EOL,$pre_code);	
					for($l=0;$l<sizeof($pre_code);$l++){
						if($pre_code[$l]!=''){
							$found=false;
							$found_function='';
							foreach($this->function_list as $fl_k=>$fl_v){		//search for functions in line
								if(strstr($pre_code[$l],$fl_k)){								
									$found=true;
									$found_function=$fl_k;
									break;
								}
							}
							if($found==true && $found_function!=''){
								$pre_code[$l]=$this->statementsToJson($pre_code[$l],$all_element_ids_linewise,$all_code_name_ids_linewise);
							}else{
								$pre_code[$l]=array('constant'=>$this->constantStatementsToJson($pre_code[$l],$all_element_ids_linewise,$all_code_name_ids_linewise));
							}	
							array_push($pre_statements,$pre_code[$l]);
						}else{
							unset($pre_code[$l]);
						}
					}					
				}
				$pre_code=$pre_code_list;
				for($i=0;$i<sizeof($pre_code);$i++){
					$pre_code[$i]=str_replace("ilse ef(","else if(",$pre_code[$i]);
					if(strstr($pre_code[$i],"else if(")){							//if  and else with functions
						$pre_code[$i]=explode('}',$pre_code[$i]);
						$bigif=array();
						for($j=0;$j<sizeof($pre_code[$i]);$j++){			//if with inside and outside statements
							if($j!= (sizeof($pre_code[$i])-1 )){					//inside if brackets
								if(strstr($pre_code[$i][$j],'else if(')){
									$if_array=array();
									$pre_code[$i][$j]=$pre_code[$i][$j]."}";
									$pre_code[$i][$j]=explode('{',$pre_code[$i][$j]);
									//$pre_code[$i][$j][0]		if condition
									//$pre_code[$i][$j][1]		function statements
									$pre_code[$i][$j][0]=str_replace('else if(','',$pre_code[$i][$j][0]);
									$pre_code[$i][$j][0]=str_replace(')','',$pre_code[$i][$j][0]);
									foreach($this->relationship_operators as $ro){
										$pre_code[$i][$j][0]=str_replace($ro,"@@@".$ro."@@@",$pre_code[$i][$j][0]);
									}
									$pre_code[$i][$j][0]=str_replace(' ','',$pre_code[$i][$j][0]);									
									foreach($this->relationship_operators as $ro){
										$pre_code[$i][$j][0]=str_replace("@@@".$ro."@@@"," ".$ro." ",$pre_code[$i][$j][0]);
									}									
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
											$pre_code[$i][$j][1][$l]=$this->statementsToJson($pre_code[$i][$j][1][$l],$all_element_ids_linewise,$all_code_name_ids_linewise);
										}else{
											$pre_code[$i][$j][1][$l]=array('constant'=>$this->constantStatementsToJson($pre_code[$i][$j][1][$l],$all_element_ids_linewise,$all_code_name_ids_linewise));
										}									
									}						
									//print_r($pre_code[$i][$j][1]);
									$if_array['statements']=$pre_code[$i][$j][1];
									//array_push($bigif,$if_array);
									$bigif['else if']=$if_array;
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
											$pre_code[$i][$j][$l]=$this->statementsToJson($pre_code[$i][$j][$l],$all_element_ids_linewise,$all_code_name_ids_linewise);
										}else{
											$pre_code[$i][$j][$l]=array('constant'=>$this->constantStatementsToJson($pre_code[$i][$j][$l],$all_element_ids_linewise,$all_code_name_ids_linewise));
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
					}else if(strstr($pre_code[$i],"if(")){							//if  and else with functions
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
									foreach($this->relationship_operators as $ro){
										$pre_code[$i][$j][0]=str_replace($ro,"@@@".$ro."@@@",$pre_code[$i][$j][0]);
									}
									$pre_code[$i][$j][0]=str_replace(' ','',$pre_code[$i][$j][0]);									
									foreach($this->relationship_operators as $ro){
										$pre_code[$i][$j][0]=str_replace("@@@".$ro."@@@"," ".$ro." ",$pre_code[$i][$j][0]);
									}
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
											$pre_code[$i][$j][1][$l]=$this->statementsToJson($pre_code[$i][$j][1][$l],$all_element_ids_linewise,$all_code_name_ids_linewise);
										}else{
											$pre_code[$i][$j][1][$l]=array('constant'=>$this->constantStatementsToJson($pre_code[$i][$j][1][$l],$all_element_ids_linewise,$all_code_name_ids_linewise));
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
											$pre_code[$i][$j][1][$l]=$this->statementsToJson($pre_code[$i][$j][1][$l],$all_element_ids_linewise,$all_code_name_ids_linewise);
										}else{
											$pre_code[$i][$j][1][$l]=array('constant'=>$this->constantStatementsToJson($pre_code[$i][$j][1][$l],$all_element_ids_linewise,$all_code_name_ids_linewise));
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
											$pre_code[$i][$j][$l]=$this->statementsToJson($pre_code[$i][$j][$l],$all_element_ids_linewise,$all_code_name_ids_linewise);
										}else{
											$pre_code[$i][$j][$l]=array('constant'=>$this->constantStatementsToJson($pre_code[$i][$j][$l],$all_element_ids_linewise,$all_code_name_ids_linewise));
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
					}else{		
						//only functions or constants
						$pre_code[$i]=str_replace('else {','',$pre_code[$i]);
						$pre_code[$i]=str_replace('}',''.PHP_EOL,$pre_code[$i]);
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
									$pre_code[$i][$k]=$this->statementsToJson($pre_code[$i][$k],$all_element_ids_linewise,$all_code_name_ids_linewise);
								}else{
									$pre_code[$i][$k]=array('constant'=>$this->constantStatementsToJson($pre_code[$i][$k],$all_element_ids_linewise,$all_code_name_ids_linewise));
								}

							}else{
								unset($pre_code[$i][$k]);
							}
						}
						$pre_code[$i] = array_values($pre_code[$i]);
						if(sizeof($pre_code[$i])>0){
							$pre_code[$i][0]=str_replace("\r","",$pre_code[$i][0]);
							$pre_code[$i][0]=str_replace("\n","",$pre_code[$i][0]);
							$pre_code[$i][0]=str_replace(PHP_EOL,"",$pre_code[$i][0]);
							if(empty($pre_code[$i][0])){
								unset($pre_code[$i]);
								$pre_code[$i]=array();
							}							
						}					
						
						//removing empty arrays from else
						for($n=0;$n<sizeof($pre_code[$i]);$n++){
							$pre_code[$i][$n]=str_replace("\r","",$pre_code[$i][$n]);
							$pre_code[$i][$n]=str_replace("\n","",$pre_code[$i][$n]);							
							if(empty($pre_code[$i][$n])){
								unset($pre_code[$i][$n]);
							}
						}
						//print_r($pre_code[$i]);
						$else_array=array("else"=>array('statements'=>$pre_code[$i]));
						array_push($pre_code_new,$else_array);
					}
				}
				
				//calculating post code
				$post_code_new=array();
				$post_code_list=array();
				$post_statements=array();
				if(strstr($post_code,"else if")){				
					$post_code=preg_split('/else if[(]/',$post_code);
					for($i=0;$i<sizeof($post_code);$i++){
						if($i!=0){
							$post_code[$i]="ilse ef(".$post_code[$i];
						}
						if(strstr($post_code[$i],"if")){
							$post_code[$i]=preg_split('/if[(]/',$post_code[$i]);
							for($j=0;$j<sizeof($post_code[$i]);$j++){
								if($j!=0){
									$post_code[$i][$j]="if(".$post_code[$i][$j];
									array_push($post_code_list,$post_code[$i][$j]);
								}	
							}	
							//print_r($post_code[$i]);
							for($j=0;$j<sizeof($post_code[$i]);$j++){
								if(!is_array($post_code[$i][$j]) && strstr($post_code[$i][$j],"var ")){
									$post_code[$i][$j]=str_replace(';',';'.PHP_EOL,$post_code[$i][$j]);

									$post_code[$i][$j]=explode(PHP_EOL,$post_code[$i][$j]);
									for($l=0;$l<sizeof($post_code[$i][$j]);$l++){
										if($post_code[$i][$j][$l]!=''){
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
												$post_code[$i][$j][$l]=$this->statementsToJson($post_code[$i][$j][$l],$all_element_ids_linewise,$all_code_name_ids_linewise);
											}else{
												$post_code[$i][$j][$l]=array('constant'=>$this->constantStatementsToJson($post_code[$i][$j][$l],$all_element_ids_linewise,$all_code_name_ids_linewise));
											}	
											array_push($post_statements,$post_code[$i][$j][$l]);
										}else{
											unset($post_code[$i][$j][$l]);
										}
									}	
								}
							}
						}
						if(!is_array($post_code[$i]) && strstr($post_code[$i],"else")){	
							$post_code[$i]=preg_split('/else/',$post_code[$i]);
							for($j=0;$j<sizeof($post_code[$i]);$j++){
								if(strstr($post_code[$i][$j],"ilse ef")){
									$post_code[$i][$j]=str_replace("ilse ef","else if",$post_code[$i][$j]);
									array_push($post_code_list,$post_code[$i][$j]);
								}
								if($j!=0){
									$post_code[$i][$j]="else".$post_code[$i][$j];
									array_push($post_code_list,$post_code[$i][$j]);
								}
							}
						}
						if(!is_array($post_code[$i]) && strstr($post_code[$i],"ilse ef(")){
							$post_code[$i]=preg_split('/ilse ef[(]/',$post_code[$i]);
							for($j=0;$j<sizeof($post_code[$i]);$j++){
								if($j!=0){
									$post_code[$i][$j]="ilse ef(".$post_code[$i][$j];
									array_push($post_code_list,$post_code[$i][$j]);
								}	
							}	
							//print_r($post_code[$i]);
							for($j=0;$j<sizeof($post_code[$i]);$j++){
								if(!is_array($post_code[$i][$j]) && strstr($post_code[$i][$j],"var ")){
									$post_code[$i][$j]=str_replace(';',';'.PHP_EOL,$post_code[$i][$j]);
									$post_code[$i][$j]=explode(PHP_EOL,$post_code[$i][$j]);
									for($l=0;$l<sizeof($post_code[$i][$j]);$l++){
										if($post_code[$i][$j][$l]!=''){
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
												$post_code[$i][$j][$l]=$this->statementsToJson($post_code[$i][$j][$l],$all_element_ids_linewise,$all_code_name_ids_linewise);
											}else{
												$post_code[$i][$j][$l]=array('constant'=>$this->constantStatementsToJson($post_code[$i][$j][$l],$all_element_ids_linewise,$all_code_name_ids_linewise));
											}	
											array_push($pre_statements,$post_code[$i][$j][$l]);
										}else{
											unset($post_code[$i][$j][$l]);
										}
									}	
								}
							}
						}
					}
				}else if(strstr($post_code,"if")){
					$post_code=preg_split('/if[(]/',$post_code);
					for($i=0;$i<sizeof($post_code);$i++){
						if($i!=0){
							$post_code[$i]="if(".$post_code[$i];
						}
					}
					for($i=0;$i<sizeof($post_code);$i++){
						if(strstr($post_code[$i],"else")){
							$post_code[$i]=preg_split('/else/',$post_code[$i]);
							for($j=0;$j<sizeof($post_code[$i]);$j++){
								if($j!=0){
									$post_code[$i][$j]="else".$post_code[$i][$j];
								}	
								array_push($post_code_list,$post_code[$i][$j]);
							}	
						}
						if(!is_array($post_code[$i]) && strstr($post_code[$i],"var ")){
							$post_code[$i]=str_replace(';',';'.PHP_EOL,$post_code[$i]);
							$post_code[$i]=explode(PHP_EOL,$post_code[$i]);
							
							for($l=0;$l<sizeof($post_code[$i]);$l++){
								if($post_code[$i][$l]!=''){
									$found=false;
									$found_function='';
									foreach($this->function_list as $fl_k=>$fl_v){		//search for functions in line
										if(strstr($post_code[$i][$l],$fl_k)){								
											$found=true;
											$found_function=$fl_k;
											break;
										}
									}
									if($found==true && $found_function!=''){
										$post_code[$i][$l]=$this->statementsToJson($post_code[$i][$l],$all_element_ids_linewise,$all_code_name_ids_linewise);
									}else{
										$post_code[$i][$l]=array('constant'=>$this->constantStatementsToJson($post_code[$i][$l],$all_element_ids_linewise,$all_code_name_ids_linewise));
									}	
									array_push($post_statements,$post_code[$i][$l]);
								}else{
									unset($post_code[$i][$l]);
								}
							}	
						}
					}				
				}else{
					$post_code=str_replace(';',';'.PHP_EOL,$post_code);
					$post_code=explode(PHP_EOL,$post_code);	
					for($l=0;$l<sizeof($post_code);$l++){
						if($post_code[$l]!=''){
							$found=false;
							$found_function='';
							foreach($this->function_list as $fl_k=>$fl_v){		//search for functions in line
								if(strstr($post_code[$l],$fl_k)){								
									$found=true;
									$found_function=$fl_k;
									break;
								}
							}
							if($found==true && $found_function!=''){
								$post_code[$l]=$this->statementsToJson($post_code[$l],$all_element_ids_linewise,$all_code_name_ids_linewise);
							}else{
								$post_code[$l]=array('constant'=>$this->constantStatementsToJson($post_code[$l],$all_element_ids_linewise,$all_code_name_ids_linewise));
							}	
							array_push($post_statements,$post_code[$l]);
						}else{
							unset($post_code[$l]);
						}
					}					
				}
				$post_code=$post_code_list;
				for($i=0;$i<sizeof($post_code);$i++){
					$post_code[$i]=str_replace("ilse ef(","else if(",$post_code[$i]);
					if(strstr($post_code[$i],"else if(")){							//if  and else with functions
						$post_code[$i]=explode('}',$post_code[$i]);
						$bigif=array();
						for($j=0;$j<sizeof($post_code[$i]);$j++){			//if with inside and outside statements
							if($j!= (sizeof($post_code[$i])-1 )){					//inside if brackets
								if(strstr($post_code[$i][$j],'else if(')){
									$if_array=array();
									$post_code[$i][$j]=$post_code[$i][$j]."}";
									$post_code[$i][$j]=explode('{',$post_code[$i][$j]);
									//$post_code[$i][$j][0]		if condition
									//$post_code[$i][$j][1]		function statements
									$post_code[$i][$j][0]=str_replace('else if(','',$post_code[$i][$j][0]);
									$post_code[$i][$j][0]=str_replace(')','',$post_code[$i][$j][0]);
									foreach($this->relationship_operators as $ro){
										$post_code[$i][$j][0]=str_replace($ro,"@@@".$ro."@@@",$post_code[$i][$j][0]);
									}
									$post_code[$i][$j][0]=str_replace(' ','',$post_code[$i][$j][0]);									
									foreach($this->relationship_operators as $ro){
										$post_code[$i][$j][0]=str_replace("@@@".$ro."@@@"," ".$ro." ",$post_code[$i][$j][0]);
									}									
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
											$post_code[$i][$j][1][$l]=$this->statementsToJson($post_code[$i][$j][1][$l],$all_element_ids_linewise,$all_code_name_ids_linewise);
										}else{
											$post_code[$i][$j][1][$l]=array('constant'=>$this->constantStatementsToJson($post_code[$i][$j][1][$l],$all_element_ids_linewise,$all_code_name_ids_linewise));
										}									
									}						
									//print_r($post_code[$i][$j][1]);
									$if_array['statements']=$post_code[$i][$j][1];
									//array_push($bigif,$if_array);
									$bigif['else if']=$if_array;
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
											$post_code[$i][$j][$l]=$this->statementsToJson($post_code[$i][$j][$l],$all_element_ids_linewise,$all_code_name_ids_linewise);
										}else{
											$post_code[$i][$j][$l]=array('constant'=>$this->constantStatementsToJson($post_code[$i][$j][$l],$all_element_ids_linewise,$all_code_name_ids_linewise));
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
					}else if(strstr($post_code[$i],"if(")){							//if  and else with functions
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
									foreach($this->relationship_operators as $ro){
										$post_code[$i][$j][0]=str_replace($ro,"@@@".$ro."@@@",$post_code[$i][$j][0]);
									}
									$post_code[$i][$j][0]=str_replace(' ','',$post_code[$i][$j][0]);									
									foreach($this->relationship_operators as $ro){
										$post_code[$i][$j][0]=str_replace("@@@".$ro."@@@"," ".$ro." ",$post_code[$i][$j][0]);
									}
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
											$post_code[$i][$j][1][$l]=$this->statementsToJson($post_code[$i][$j][1][$l],$all_element_ids_linewise,$all_code_name_ids_linewise);
										}else{
											$post_code[$i][$j][1][$l]=array('constant'=>$this->constantStatementsToJson($post_code[$i][$j][1][$l],$all_element_ids_linewise,$all_code_name_ids_linewise));
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
											$post_code[$i][$j][1][$l]=$this->statementsToJson($post_code[$i][$j][1][$l],$all_element_ids_linewise,$all_code_name_ids_linewise);
										}else{
											$post_code[$i][$j][1][$l]=array('constant'=>$this->constantStatementsToJson($post_code[$i][$j][1][$l],$all_element_ids_linewise,$all_code_name_ids_linewise));
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
											$post_code[$i][$j][$l]=$this->statementsToJson($post_code[$i][$j][$l],$all_element_ids_linewise,$all_code_name_ids_linewise);
										}else{
											$post_code[$i][$j][$l]=array('constant'=>$this->constantStatementsToJson($post_code[$i][$j][$l],$all_element_ids_linewise,$all_code_name_ids_linewise));
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
					}else{		
						//only functions or constants
						$post_code[$i]=str_replace('else {','',$post_code[$i]);
						$post_code[$i]=str_replace('}',''.PHP_EOL,$post_code[$i]);
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
									$post_code[$i][$k]=$this->statementsToJson($post_code[$i][$k],$all_element_ids_linewise,$all_code_name_ids_linewise);
								}else{
									$post_code[$i][$k]=array('constant'=>$this->constantStatementsToJson($post_code[$i][$k],$all_element_ids_linewise,$all_code_name_ids_linewise));
								}

							}else{
								unset($post_code[$i][$k]);
							}
						}
						$post_code[$i] = array_values($post_code[$i]);
						if(sizeof($post_code[$i])>0){
							$post_code[$i][0]=str_replace("\r","",$post_code[$i][0]);
							$post_code[$i][0]=str_replace("\n","",$post_code[$i][0]);
							$post_code[$i][0]=str_replace(PHP_EOL,"",$post_code[$i][0]);
							if(empty($post_code[$i][0])){
								unset($post_code[$i]);
								$post_code[$i]=array();
							}							
						}		
						
						//removing empty arrays from else
						for($n=0;$n<sizeof($post_code[$i]);$n++){
							$post_code[$i][$n]=str_replace("\r","",$post_code[$i][$n]);
							$post_code[$i][$n]=str_replace("\n","",$post_code[$i][$n]);							
							if(empty($post_code[$i][$n])){
								unset($post_code[$i][$n]);
							}
						}
						
						//print_r($pre_code[$i]);						
						$else_array=array("else"=>array('statements'=>$post_code[$i]));
						array_push($post_code_new,$else_array);
					}
				}

				$pre_code_new2=array();
				$pre_code_new2['statements']=$pre_statements;
				$pre_code_new2['conditional']=$pre_code_new;
				$pre_code_new=$pre_code_new2;

				$post_code_new2=array();
				$post_code_new2['statements']=$post_statements;
				$post_code_new2['conditional']=$post_code_new;
				$post_code_new=$post_code_new2;
					
				array_push($all_code,array('element_name'=>$odd[$z],'data'=>array('preproc'=>$pre_code_new,'postproc'=>$post_code_new)));
				//array_push($all_code,array($odd[$z]=>array('preproc'=>$pre_code_new,'postproc'=>$post_code_new)));
				//$all_code[$odd[$z]]=array('preproc'=>$pre_code_new,'postproc'=>$post_code_new);
			}
			
		}
		//print_r($all_code);
		if(sizeof($all_code)>0){
		//echo json_encode($all_code);die;
		}
		$all_code=$this->modifyMoreCode($all_code);
		if(sizeof($all_code)>0){
		//echo json_encode($all_code);die;
		}
		return $all_code;
	}
	function modifyMoreCode($all_code){
		//print_r($all_code);die;
		//$all_operators=array('==','>=','<=','!=','&&', '||', '>', '<');
		if(sizeof($all_code)>0){
			//echo json_encode($all_code);die;
			for($i=0;$i<sizeof($all_code);$i++){
				$element_name=$all_code[$i]['element_name'];
				$data=$all_code[$i]['data'];
				if(isset($all_code[$i]['data']['preproc']['conditional'])){
					$new_preproc=array();
					$preproc=$all_code[$i]['data']['preproc']['conditional'];
					foreach($preproc as $pc){
						//print_r($pc);
						if(array_key_exists("if",$pc)){
							$new_preproc_inner=array();
							$if_code=$pc['if'];
							$pre_if_conditions=$if_code['conditions'];
							$pre_if_statements=$if_code['statements'];
							$input_elements=array();
							$input_values=array();
							$input_operators=array();
							foreach($pre_if_conditions as $pre_condition){
								if($pre_condition!=''){
									foreach($this->all_operators as $ao){
									if(strstr($pre_condition,$ao)){
										$pre_condition_inner=explode($ao,$pre_condition);
										if($pre_condition_inner[0]!='' && $pre_condition_inner[1]!=''){
											array_push($input_elements,$pre_condition_inner[0]);
											array_push($input_values,$pre_condition_inner[1]);
											array_push($input_operators,$ao);
										}else{
											array_push($input_operators,$ao);
										}
										break;
									}
								}
								}
							}
							$new_preproc_inner['key']='if';
							$new_preproc_inner['input_elements']=$input_elements;
							$new_preproc_inner['input_values']=$input_values;
							$new_preproc_inner['input_operators']=$input_operators;
							$new_preproc_inner['statements']=$pre_if_statements;
							array_push($new_preproc,$new_preproc_inner);
						}
						if(array_key_exists("else if",$pc)){
							$new_preproc_inner=array();
							$elseif_code=$pc['else if'];
							$pre_elseif_conditions=$elseif_code['conditions'];
							$pre_elseif_statements=$elseif_code['statements'];
							$input_elements=array();
							$input_values=array();
							$input_operators=array();
							foreach($pre_elseif_conditions as $pre_condition){
								if($pre_condition!=''){
									foreach($this->all_operators as $ao){
									if(strstr($pre_condition,$ao)){
										$pre_condition_inner=explode($ao,$pre_condition);
										if($pre_condition_inner[0]!='' && $pre_condition_inner[1]!=''){
											array_push($input_elements,$pre_condition_inner[0]);
											array_push($input_values,$pre_condition_inner[1]);
											array_push($input_operators,$ao);
										}else{
											array_push($input_operators,$ao);
										}
										break;
									}
								}
								}
							}
							$new_preproc_inner['key']='else if';
							$new_preproc_inner['input_elements']=$input_elements;
							$new_preproc_inner['input_values']=$input_values;
							$new_preproc_inner['input_operators']=$input_operators;
							$new_preproc_inner['statements']=$pre_elseif_statements;
							array_push($new_preproc,$new_preproc_inner);
						}					
						if(array_key_exists("else",$pc)){
							$new_preproc_inner=array();
							$else_code=$pc['else'];
							$pre_else_statements=$else_code['statements'];
							$new_preproc_inner['key']='else';
							$new_preproc_inner['statements']=$pre_else_statements;
							//print_r($new_preproc_inner);
							array_push($new_preproc,$new_preproc_inner);						
						}
					}
					$all_code[$i]['data']['preproc']['conditional']=$new_preproc;
				}
				if(isset($all_code[$i]['data']['postproc']['conditional'])){
					$new_postproc=array();
					$postproc=$all_code[$i]['data']['postproc']['conditional'];
					foreach($postproc as $pc){
						//print_r($pc);
						if(array_key_exists("if",$pc)){
							$new_postproc_inner=array();
							$if_code=$pc['if'];
							$post_if_conditions=$if_code['conditions'];
							$post_if_statements=$if_code['statements'];
							$input_elements=array();
							$input_values=array();
							$input_operators=array();
							foreach($post_if_conditions as $post_condition){
								if($post_condition!=''){
									//echo $post_condition."\r\n";
									foreach($this->all_operators as $ao){
										if(strstr($post_condition,$ao)){
											$post_condition_inner=explode($ao,$post_condition);
											if($post_condition_inner[0]!='' && $post_condition_inner[1]!=''){
												array_push($input_elements,$post_condition_inner[0]);
												array_push($input_values,$post_condition_inner[1]);
												array_push($input_operators,$ao);
											}else{
												array_push($input_operators,$ao);
											}
											break;
										}
									}
								}
							}
							$new_postproc_inner['key']='if';
							$new_postproc_inner['input_elements']=$input_elements;
							$new_postproc_inner['input_values']=$input_values;
							$new_postproc_inner['input_operators']=$input_operators;
							$new_postproc_inner['statements']=$post_if_statements;
							array_push($new_postproc,$new_postproc_inner);
						}
						if(array_key_exists("else if",$pc)){
							$new_postproc_inner=array();
							$elseif_code=$pc['else if'];
							$post_elseif_conditions=$elseif_code['conditions'];
							$post_elseif_statements=$elseif_code['statements'];
							$input_elements=array();
							$input_values=array();
							$input_operators=array();
							foreach($post_elseif_conditions as $post_condition){
								if($post_condition!=''){
									foreach($this->all_operators as $ao){
									if(strstr($post_condition,$ao)){
										$post_condition_inner=explode($ao,$post_condition);
										if($post_condition_inner[0]!='' && $post_condition_inner[1]!=''){
											array_push($input_elements,$post_condition_inner[0]);
											array_push($input_values,$post_condition_inner[1]);
											array_push($input_operators,$ao);
										}else{
											array_push($input_operators,$ao);
										}
										break;
									}
								}
								}
							}
							$new_postproc_inner['key']='else if';
							$new_postproc_inner['input_elements']=$input_elements;
							$new_postproc_inner['input_values']=$input_values;
							$new_postproc_inner['input_operators']=$input_operators;
							$new_postproc_inner['statements']=$post_elseif_statements;
							array_push($new_postproc,$new_postproc_inner);
						}					
						if(array_key_exists("else",$pc)){
							$new_postproc_inner=array();
							$else_code=$pc['else'];
							$post_else_statements=$else_code['statements'];
							$new_postproc_inner['key']='else';
							$new_postproc_inner['statements']=$post_else_statements;
							//print_r($new_postproc_inner);
							array_push($new_postproc,$new_postproc_inner);						
						}
					}				
					$all_code[$i]['data']['postproc']['conditional']=$new_postproc;
				}
			}
			//die;
		}
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
	function getLineWiseCodenameIds($survey_id){
		//print_r($survey_id);
		$codenames=array();
		$this->db->select('section_sort_id');
		$this->db->where('title_url', $survey_id);
		$s_query = $this->db->get('survey');
		//echo $this->db->last_query();
		if($s_query->num_rows()>0){
			$s=$s_query->result_array();
			foreach($s as $s2){
				$section_sort_id=explode(",",$s2['section_sort_id']);
				foreach($section_sort_id as $ssi){
					$this->db->select('question_sort_id');
					$this->db->where('id', $ssi);
					$ss_query = $this->db->get('survey_section');					
					if($ss_query->num_rows()>0){
						$ss=$ss_query->result_array();	
						foreach($ss as $ss2){
							$question_sort_id=explode(",",$ss2['question_sort_id']);
							foreach($question_sort_id as $qsi){
								$this->db->select('code_name');
								$this->db->where('id', $qsi);
								$sq_query = $this->db->get('survey_data');	
								if($sq_query->num_rows()>0){
									$sq=$sq_query->result_array();	
									foreach($sq as $sq2){
										if($sq2['code_name']!=""){
											$sq2=(array) json_decode($sq2['code_name']);
											//print_r($sq2);die;
											foreach($sq2 as $sq2_k=>$sq2_v){
												//array_push($codenames,$sq22);
												$codenames[$sq2_v]=$sq2_k;
											}
										}
									}
								}
								
							}
							//print_r($question_sort_id);
						}
					}
						
				}
				//print_r($section_sort_id);
			}
		}	
		//print_r($codenames);
		return $codenames;
	}
	function getLineWiseElementIds($survey_id){
		//print_r($survey_id);
		$elements=array();
		$this->db->select('section_sort_id');
		$this->db->where('title_url', $survey_id);
		$s_query = $this->db->get('survey');
		//echo $this->db->last_query();
		if($s_query->num_rows()>0){
			$s=$s_query->result_array();
			foreach($s as $s2){
				$section_sort_id=explode(",",$s2['section_sort_id']);
				foreach($section_sort_id as $ssi){
					$this->db->select('question_sort_id');
					$this->db->where('id', $ssi);
					$ss_query = $this->db->get('survey_section');					
					if($ss_query->num_rows()>0){
						$ss=$ss_query->result_array();	
						foreach($ss as $ss2){
							$question_sort_id=explode(",",$ss2['question_sort_id']);
							foreach($question_sort_id as $qsi){
								$this->db->select('elements');
								$this->db->where('id', $qsi);
								$sq_query = $this->db->get('survey_data');					
								if($sq_query->num_rows()>0){
									$sq=$sq_query->result_array();	
									foreach($sq as $sq2){
										if($sq2['elements']!=""){
											$sq2=json_decode($sq2['elements']);
											foreach($sq2 as $sq22){
												array_push($elements,$sq22);
											}
										}
									}
								}
								
							}
							//print_r($question_sort_id);
						}
					}
						
				}
				//print_r($section_sort_id);
			}
		}	
		//print_r($elements);
		return $elements;
	}
	function getLineWiseElementIdsWithType($survey_id){
		//print_r($survey_id);
		$elements=array();
		$this->db->select('section_sort_id');
		$this->db->where('title_url', $survey_id);
		$s_query = $this->db->get('survey');
		//echo $this->db->last_query();
		if($s_query->num_rows()>0){
			$s=$s_query->result_array();
			foreach($s as $s2){
				$section_sort_id=explode(",",$s2['section_sort_id']);
				foreach($section_sort_id as $ssi){
					$this->db->select('question_sort_id');
					$this->db->where('id', $ssi);
					$ss_query = $this->db->get('survey_section');					
					if($ss_query->num_rows()>0){
						$ss=$ss_query->result_array();	
						foreach($ss as $ss2){
							$question_sort_id=explode(",",$ss2['question_sort_id']);
							foreach($question_sort_id as $qsi){
								$this->db->select('qtype,elements,json_data');
								$this->db->where('id', $qsi);
								$sq_query = $this->db->get('survey_data');					
								if($sq_query->num_rows()>0){
									$sq=$sq_query->result_array();	
									foreach($sq as $sq2){
										$question_details=$sq2;
										if($sq2['elements']!=""){
											$sq2=json_decode($sq2['elements']);
											foreach($sq2 as $sq22){
												if($question_details['qtype']=="Dropdown Matrix Question"){
													$elements[$sq22]=1;
													////$elements['element_name']=$sq22;
													//$element['in_matrix']=1;
												}else{
													$elements[$sq22]=0;
													//$elements['element_name']=$sq22;
													//$element['in_matrix']=0;
												}
												//array_push($elements,$element);
												//array_push($elements,$element);
											}
										}
									}
								}
								
							}
							//print_r($question_sort_id);
						}
					}
						
				}
				//print_r($section_sort_id);
			}
		}	
		//print_r($elements);
		return $elements;
	}	
	public function sync_for_login($username){
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
				$temp_survey=array();
				foreach($survey as $s){
					if($s['user_id']==$user_data[0]['id']){
						$s['user']="owner";
					}else{
						$s['user']="permitted";
					}					
					$s['survey_id']=$s['title_url'];
					$all_element_ids_linewise=$this->getLineWiseElementIds($s['survey_id']);
					$all_code_name_ids_linewise=$this->getLineWiseCodenameIds($s['survey_id']);
					$ids_with_type=$this->getLineWiseElementIdsWithType($s['survey_id']);
					
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
													$sd['code']=$this->codeToJson($sd['code'],$all_element_ids_linewise,$all_code_name_ids_linewise);
													$sd['elements']=$this->rejson(array('elements'=>$sd['elements']));
													$sd['lengths']=$this->rejson(array('lengths'=>$sd['lengths']));
													$sd['code_name']=$this->rejson(array('code_name'=>$sd['code_name']));
													$sd['style']=$this->rejson(array('style'=>$sd['style']));
													unset($sd['style']);
													unset($sd['code2']);
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
												$sd['code']=$this->codeToJson($sd['code'],$all_element_ids_linewise,$all_code_name_ids_linewise);
												$sd['elements']=$this->rejson(array('elements'=>$sd['elements']));
												$sd['lengths']=$this->rejson(array('lengths'=>$sd['lengths']));
												$sd['code_name']=$this->rejson(array('code_name'=>$sd['code_name']));
												$sd['style']=$this->rejson(array('style'=>$sd['style']));
												unset($sd['style']);
												unset($sd['code2']);
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
									unset($ss['style']);
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
												$sd['code']=$this->codeToJson($sd['code'],$all_element_ids_linewise,$all_code_name_ids_linewise);
												$sd['elements']=$this->rejson(array('elements'=>$sd['elements']));
												$sd['lengths']=$this->rejson(array('lengths'=>$sd['lengths']));
												$sd['code_name']=$this->rejson(array('code_name'=>$sd['code_name']));
												$sd['style']=$this->rejson(array('style'=>$sd['style']));
												unset($sd['style']);
												unset($sd['code2']);
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
											$sd['code']=$this->codeToJson($sd['code'],$all_element_ids_linewise,$all_code_name_ids_linewise);
											$sd['elements']=$this->rejson(array('elements'=>$sd['elements']));
											$sd['lengths']=$this->rejson(array('lengths'=>$sd['lengths']));
											$sd['code_name']=$this->rejson(array('code_name'=>$sd['code_name']));
											$sd['style']=$this->rejson(array('style'=>$sd['style']));
											unset($sd['style']);
											unset($sd['code2']);
											array_push($temp_data,$sd);													
										}
									}										
								}
								if($ss['question_sort_id']!=""){
									$ss['question_sort_id']=json_encode(explode(',',$ss['question_sort_id']));	
								}									

								$ss['question_sort_id']=$this->rejson(array('question_sort_id'=>$ss['question_sort_id']));
								$ss['style']=$this->rejson(array('style'=>$ss['style']));
								unset($ss['style']);
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
					$s['ids_in_matrix']=$ids_with_type;
					unset($s['style']);					
					unset($s['title_url']);					
					unset($s['indicator']);
					array_push($temp_survey,$s);
				}
				//print_r($temp_survey);
				$sfd_new['surveyList']=$temp_survey;
			}
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
				if(isset($q22['row_percent'])){
					$analytics_data['row_percent']="true";
				}
				if(isset($q22['col_percent'])){
					$analytics_data['col_percent']="true";
				}
				if(isset($q22['chartDrawType'])){
					$analytics_data['chartDrawType']=$q22['chartDrawType'];
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
				if(isset($q22['row_percent'])){
					$analytics_data['row_percent']="true";
				}
				if(isset($q22['col_percent'])){
					$analytics_data['col_percent']="true";
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
     public function user_dashboard_timeline($survey_id){
          $salt = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
          $rand = '';
          $i = 0;
          $length = 5;
          while ($i < $length) { // Loop until you have met the length
          $num = rand() % strlen($salt);
          $tmp = substr($salt, $num, 1);
          $rand = $rand . $tmp;
          $i++;
          }
          $start_record_data='';
          $start_record=$this->db->query("select DISTINCT(DATE(FROM_UNIXTIME(add_date))) as d, YEAR(FROM_UNIXTIME(add_date)) as Year, MONTH(FROM_UNIXTIME(add_date)) as Month, DAY(FROM_UNIXTIME(add_date)) as Day, HOUR(FROM_UNIXTIME(add_date)) as Hour, MINUTE(FROM_UNIXTIME(add_date)) as Minute, SECOND(FROM_UNIXTIME(add_date)) as Second from survey where title_url='".$survey_id."'");
          if($start_record->num_rows()>0){
                  $start_record=$start_record->result_array();
                  $start_record_data=$start_record[0];
          }
          //echo $rand;
          $records=array();
          $q=$this->db->query("select DISTINCT(DATE(FROM_UNIXTIME(add_date))) as d, YEAR(FROM_UNIXTIME(add_date)) as Year, MONTH(FROM_UNIXTIME(add_date)) as Month, DAY(FROM_UNIXTIME(add_date)) as Day, HOUR(FROM_UNIXTIME(add_date)) as Hour, MINUTE(FROM_UNIXTIME(add_date)) as Minute, SECOND(FROM_UNIXTIME(add_date)) as Second, count(*) as total from survey_values where survey_id='".$survey_id."' group by d");
          //$q=$this->db->query("select DISTINCT(DATE_FORMAT(FROM_UNIXTIME(`add_date`), '%Y-%m-%d %H:%i:%s')) AS d, YEAR(FROM_UNIXTIME(add_date)) as Year, MONTH(FROM_UNIXTIME(add_date)) as Month, DAY(FROM_UNIXTIME(add_date)) as Day, HOUR(FROM_UNIXTIME(add_date)) as Hour, MINUTE(FROM_UNIXTIME(add_date)) as Minute, SECOND(FROM_UNIXTIME(add_date)) as Second, count(*) as total from survey_values where survey_id='".$survey_id."' group by d");
          //echo $this->db->last_query();
          if($q->num_rows()>0){
               $records=$q->result_array();
          }
          //print_r($start_record_data);
          //print_r($records);  
          $table=array();
          $temp_table=array(
          'Day'=>$start_record_data['Day'],
          'Month'=>$start_record_data['Month'],
          'Year'=>$start_record_data['Year'],
          'Hour'=>$start_record_data['Hour'],
          'Minute'=>$start_record_data['Minute'],
          'Second'=>$start_record_data['Second'],
          'total'=>'0'
          );
          array_push($table,$temp_table);   
          foreach($records as $r){
              $temp_table=array(
              'Day'=>$r['Day'],
              'Month'=>$r['Month'],
              'Year'=>$r['Year'],
              'Hour'=>$r['Hour'],
              'Minute'=>$r['Minute'],
              'Second'=>$r['Second'],
              'total'=>$r['total']
              );
              array_push($table,$temp_table);             
          }
          //print_r($table);
          echo json_encode($table);  
     }
     //plR32QEwKXOVA1eUOYZ4
     public function survey_records($survey_id){
     	$this->Survey_model->createBackupForAnalytics($survey_id);
     	$records=$this->db->query("select * from analytics_".$survey_id);
     	if($records->num_rows()>0){
     		$records=$records->result_array();
     		//echo json_encode($records);
     		$total_records=array();
	     	foreach($records as $r){
	     		$single_record=array(
	     			'id'=>$r['id'],
	     			'survey_case_id'=>$r['survey_case_id'],	  
	     			'username'=>$r['username'],	
	     			'add_date'=>$r['add_date'],		     				     			   			
	     		);
	     		unset($r['id']);
	     		unset($r['survey_case_id']);
	     		unset($r['username']);
	     		unset($r['add_date']);
	     		//print_r($r);
	     		$single_data_record=array();
	     		foreach($r as $r_k=>$r_v){
	     			$single_data_record_temp=array(
	     				'question_name'=>$r_k,
	     				'answer'=>$r_v
	     			);
	     			//print_r($single_data_record_temp);
	     			array_push($single_data_record,$single_data_record_temp);
	     		}
	     		$single_record['data']=$single_data_record;
	     		array_push($total_records,$single_record);
	     	}
	     	//print_r($total_records);	   
	     	echo json_encode($total_records);  	
     	}

     }
}
