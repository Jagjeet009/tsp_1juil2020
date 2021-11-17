<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Survey extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('Survey_model');
        $this->load->model('Synclog_model');
		$this->load->library('form_validation');
    }
	public function logFill(){
		$local_version_file='logFill.txt';
		if(!file_exists($local_version_file)) {
			@file_put_contents($local_version_file, 'Fill Logs'); 
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
	
	public function chunk_split_unicode($str, $l, $e) {
		$tmp = array_chunk(
			preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY), $l);
		$str = "";
		foreach ($tmp as $t) {
			$str .= join("", $t) . $e;
		}
		return $str;
	}	
	public function str_break($str,$chars){
		$str1=wordwrap($str,$chars,'<br>');
		//echo $str1;
		return $str1;
	}
	/*public function mb_wordwrap($str, $width, $break = "<br>", $cut = false, $charset = null) {
		if ($charset === null) $charset = mb_internal_encoding();

		$pieces = explode($break, $str);
		$result = array();
		foreach ($pieces as $piece) {
		  $current = $piece;
		  while ($cut && mb_strlen($current) > $width) {
			$result[] = mb_substr($current, 0, $width, $charset);
			$current = mb_substr($current, $width, 2048, $charset);
		  }
		  $result[] = $current;
		}
		return implode($break, $result);
	}	*/
	public function mb_wordwrap($str, $width, $break = "<br>", $cut = false) {
		$lines = explode($break, $str);
		foreach ($lines as &$line) {
			$line = rtrim($line);
			if (mb_strlen($line) <= $width)
				continue;
			$words = explode(' ', $line);
			$line = '';
			$actual = '';
			foreach ($words as $word) {
				if (mb_strlen($actual.$word) <= $width)
					$actual .= $word.' ';
				else {
					if ($actual != '')
						$line .= rtrim($actual).$break;
					$actual = $word;
					if ($cut) {
						while (mb_strlen($actual) > $width) {
							$line .= mb_substr($actual, 0, $width).$break;
							$actual = mb_substr($actual, $width);
						}
					}
					$actual .= ' ';
				}
			}
			$line .= trim($actual);
		}
		return implode($break, $lines);
	}	
	public function strip_tags_content($text, $tags = '', $invert = FALSE) {
		preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
		$tags = array_unique($tags[1]);
		if(is_array($tags) AND count($tags) > 0) {
			if($invert == FALSE) {
				return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
			}
			else {
				return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
			}
		}else if($invert == FALSE) {
			return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
		}
		return $text;
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
	public function index(){
	}
	public function create(){
        if($this->session->userdata('user_logged_id')){		
			$data = array(
				//'surveys' => $this->Survey_model->list_surveys($this->session->userdata('user_logged_id')),
				'surveys' => $this->Survey_model->list_surveys_all(),
			);
			$this->load->view('header');
			$this->load->view('survey-create',$data);
			$this->load->view('footer');
		}
		redirect('login');
	}
	public function survey_edit($title_url){
		$countryArr=unserialize(COUNTRY);
		$sectorArr=unserialize(SECTOR);
		//print_r($sectorArr);
        if($this->session->userdata('user_logged_id')){		
			$survey=$this->Survey_model->get_survey_by_title_url($title_url);
			$gps_enabled_1='';
			$gps_enabled_0='';
			if($survey[0]['gps_enabled']==0){
				$gps_enabled_0=" checked ";
			}
			if($survey[0]['gps_enabled']==1){
				$gps_enabled_1=" checked ";
			}
			if($survey[0]['start_date']!=0){
				$survey[0]['start_date']=date('m/d/Y',$survey[0]['start_date']);
			}
			if($survey[0]['end_date']!=0){
				$survey[0]['end_date']=date('m/d/Y',$survey[0]['end_date']);
			}
			$access_1='';
			$access_0='';
			if($survey[0]['access']==0){
				$access_0=" checked ";
			}
			if($survey[0]['access']==1){
				$access_1=" checked ";
			}			
			//print_r($survey);
			$questions=array();
			$sidc=$this->Survey_model->survey_indicators_dataid_codenames($title_url);
			//print_r($sidc);
			echo '<form method="post" action="'.base_url().'survey/editsave/'.$title_url.'">
				<div class="row">
					<div class="col-9">			
						<label>Name Your Survey</label>
						<input name="title" type="text" value="'.$survey[0]['title'].'">
					</div>
					<div class="col-3">						
						<label>Sample</label>
						<input name="survey_sample" type="text" value="'.$survey[0]['survey_sample'].'">
					</div>
					
					<div class="col-6">
						<label>Start Date</label>
						<input class="datepicker" name="start_date" type="text" value="'.$survey[0]['start_date'].'">
					</div>
					<div class="col-6">
						<label>End Date</label>
						<input class="datepicker" name="end_date" type="text" value="'.$survey[0]['end_date'].'">
					</div>
					
					<div class="col-12 gps-option">
						<label>Access</label>
						<input type="radio" name="access" value="1" '.$access_1.' /> Public
						<input type="radio" name="access" value="0" '.$access_0.' /> Private
					</div>';
					
				echo '<div class="col-6">
						<label>Sector</label>
						<select name="sector" required>
							<option value="">Select</option>';
							foreach($sectorArr as $s_k=>$s_v){
								if($survey[0]['sector']==$s_k){
									echo '<option selected value="'.$s_k.'">'.$s_v.'</option>';
								}else{
									echo '<option value="'.$s_k.'">'.$s_v.'</option>';
								}
							}
				echo '  </select>						
					</div>';
			
				echo '<div class="col-6">
						<label>Country</label>
						<select name="country" required>
							<option value="">Select</option>';
							foreach($countryArr as $c_k=>$c_v){
								if($survey[0]['country']==$c_k){
									echo '<option selected value="'.$c_k.'">'.$c_v.'</option>';
								}else{
									echo '<option value="'.$c_k.'">'.$c_v.'</option>';
								}
							}
				echo '  </select>						
					</div>
					
					<div class="col-12 gps-option">
						<label>Gps Enabled</label>
						<input type="radio" name="gps_enabled" value="1" '.$gps_enabled_1.' /> Yes
						<input type="radio" name="gps_enabled" value="0" '.$gps_enabled_0.' /> No
					</div>
					
					<div class="col-6">				
						<label>Gps Latitude</label>
						<select name="gps_lat_col">';
					foreach($sidc['indicators'] as $idci_k=>$idci_v){
						if($idci_k==$survey[0]['gps_lat_col']){
							echo '<option selected value="'.$idci_k.'">['.$idci_k.'] '.$idci_v.'</option>';
						}else{
							echo '<option value="'.$idci_k.'">['.$idci_k.'] '.$idci_v.'</option>';
						}
					}
					echo '</select>
					</div>
					<div class="col-6">					
						<label>Gps Longitude</label>
						<select name="gps_long_col">';
					foreach($sidc['indicators'] as $idci_k=>$idci_v){
						if($idci_k==$survey[0]['gps_long_col']){
							echo '<option selected value="'.$idci_k.'">['.$idci_k.'] '.$idci_v.'</option>';
						}else{
							echo '<option value="'.$idci_k.'">['.$idci_k.'] '.$idci_v.'</option>';
						}					}
					echo '</select>
					</div>
				</div>					

				<label>Languages</label>
				<label>English (Default)</label>
				<div class="ac">';
			foreach((array) json_decode($survey[0]['languages']) as $sl){
				echo '<div class="acc">
						<input class="input-class-80" type="text" name="languages[]" placeholder="Enter language name of your choice" value="'.$sl.'" />
						<a href="javascript:void(0);" onclick="increaseLanguage(this)"><i class="fa fa-plus" aria-hidden="true"></i></a>
						<a href="javascript:void(0);" onclick="decreaseLanguage(this)"><i class="fa fa-times" aria-hidden="true"></i></a>
					</div>';
			}
			echo '	<div class="acc">
						<input class="input-class-80" type="text" name="languages[]" placeholder="Enter language name of your choice" />
						<a href="javascript:void(0);" onclick="increaseLanguage(this)"><i class="fa fa-plus" aria-hidden="true"></i></a>
						<a href="javascript:void(0);" onclick="decreaseLanguage(this)"><i class="fa fa-times" aria-hidden="true"></i></a>
					</div>
					<div class="acc">
						<input class="input-class-80" type="text" name="languages[]" placeholder="Enter language name of your choice" />
						<a href="javascript:void(0);" onclick="increaseLanguage(this)"><i class="fa fa-plus" aria-hidden="true"></i></a>
						<a href="javascript:void(0);" onclick="decreaseLanguage(this)"><i class="fa fa-times" aria-hidden="true"></i></a>
					</div>
				</div>
				
				<input value="Save" type="submit">
			</form>';
		}else{
			redirect('login');
		}
	}
	public function save(){
        if($this->session->userdata('user_logged_id')){
			if($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('title', 'title', 'required');
				$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
				if ($this->form_validation->run()){
					$data_to_store = array(
						'user_id' => $this->session->userdata('user_logged_id'),
						'title' => $this->input->post('title'),
						'title_url' => $this->randomString(20,''),
						'add_date' => time()
					);
					//if the insert has returned true then we show the flash message
					if($this->Survey_model->store_survey($data_to_store)){
						$data['flash_message'] = TRUE; 
					}else{
						$data['flash_message'] = FALSE; 
					}
				}
			}
		}
		redirect($_SERVER[‘HTTP_REFERER’]);
	}
	public function survey_save(){
        if($this->session->userdata('user_logged_id')){
			if($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('title', 'title', 'required');
				$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
				if ($this->form_validation->run()){
					$str=$this->randomString(20,'');
					$data_to_store = array(
						'user_id' => $this->session->userdata('user_logged_id'),
						'title' => $this->input->post('title'),
						'title_url' => $str,
						'survey_sample' => $this->input->post('survey_sample'),
						'start_date' => strtotime($this->input->post('start_date')),
						'end_date' => strtotime($this->input->post('end_date')),
						'add_date' => time(),
						'sector' => $this->input->post('sector'),
						'country' => $this->input->post('country'),
						'access' => $this->input->post('access')
					);
					$this->Survey_model->store_survey($data_to_store);
					//setcookie('design_survey', $str, 0, '/');
					
					/* recording events*/
					if($this->input->post('title')){
						$data_sync = array(
							'tablename' => 'survey',
							'columnname' => 'title_url',
							'meta_primary_key' => $str,
							'donetime' => time(),
							'work' => 'add'
						);
						$this->Synclog_model->store_synclog($data_sync);
						$data_sync = array(
							'tablename' => 'survey',
							'columnname' => 'title',
							'meta_primary_key' => $str,
							'donetime' => time(),
							'work' => 'add'
						);
						$this->Synclog_model->store_synclog($data_sync);
						$data_sync = array(
							'tablename' => 'survey',
							'columnname' => 'user_id',
							'meta_primary_key' => $str,
							'donetime' => time(),
							'work' => 'add'
						);
						$this->Synclog_model->store_synclog($data_sync);
						$data_sync = array(
							'tablename' => 'survey',
							'columnname' => 'survey_sample',
							'meta_primary_key' => $str,
							'donetime' => time(),
							'work' => 'add'
						);
						$this->Synclog_model->store_synclog($data_sync);
						$data_sync = array(
							'tablename' => 'survey',
							'columnname' => 'start_date',
							'meta_primary_key' => $str,
							'donetime' => time(),
							'work' => 'add'
						);
						$this->Synclog_model->store_synclog($data_sync);
						$data_sync = array(
							'tablename' => 'survey',
							'columnname' => 'end_date',
							'meta_primary_key' => $str,
							'donetime' => time(),
							'work' => 'add'
						);
						$this->Synclog_model->store_synclog($data_sync);
						$data_sync = array(
							'tablename' => 'survey',
							'columnname' => 'sector',
							'meta_primary_key' => $str,
							'donetime' => time(),
							'work' => 'add'
						);
						$this->Synclog_model->store_synclog($data_sync);
						$data_sync = array(
							'tablename' => 'survey',
							'columnname' => 'country',
							'meta_primary_key' => $str,
							'donetime' => time(),
							'work' => 'add'
						);
						$this->Synclog_model->store_synclog($data_sync);
						$data_sync = array(
							'tablename' => 'survey',
							'columnname' => 'access',
							'meta_primary_key' => $str,
							'donetime' => time(),
							'work' => 'add'
						);
						$this->Synclog_model->store_synclog($data_sync);						
					}
					/* recording events*/
					
				}
			}
		}
		redirect($_SERVER[‘HTTP_REFERER’]);
	}
	public function survey_editsave($title_url){
        if($this->session->userdata('user_logged_id')){
			$languages=array();
			foreach($this->input->post('languages') as $l){
				if($l!=''){
					array_push($languages,$l);
				}
			}
			if(sizeof($languages)>0){
				$data_to_store = array(
					'title' => $this->input->post('title'),
					'languages' => json_encode($languages)
				);
			}else{
				$data_to_store = array(
					'title' => $this->input->post('title'),
					'languages' => ''
				);
			}
			$data_to_store['survey_sample']=$this->input->post('survey_sample');
			$data_to_store['start_date']=strtotime($this->input->post('start_date'));
			$data_to_store['end_date']=strtotime($this->input->post('end_date'));
			$data_to_store['gps_enabled']=$this->input->post('gps_enabled');
			$data_to_store['gps_lat_col']=$this->input->post('gps_lat_col');
			$data_to_store['gps_long_col']=$this->input->post('gps_long_col');
			$data_to_store['access']=$this->input->post('access');
			$data_to_store['sector']=$this->input->post('sector');
			$data_to_store['country']=$this->input->post('country');
			
			/* recording events*/
			if($this->input->post('title')){
				$data_sync = array(
					'tablename' => 'survey',
					'columnname' => 'title',
					'meta_primary_key' => $title_url,
					'donetime' => time(),
					'work' => 'edit'
				);
				$this->Synclog_model->store_synclog($data_sync);
			}
			if($this->input->post('languages')){
				$data_sync = array(
					'tablename' => 'survey',
					'columnname' => 'languages',
					'meta_primary_key' => $title_url,
					'donetime' => time(),
					'work' => 'edit'
				);
				$this->Synclog_model->store_synclog($data_sync);
			}

			if($this->input->post('survey_sample')){
				$data_sync = array(
					'tablename' => 'survey',
					'columnname' => 'survey_sample',
					'meta_primary_key' => $title_url,
					'donetime' => time(),
					'work' => 'edit'
				);
				$this->Synclog_model->store_synclog($data_sync);
			}			
			if($this->input->post('start_date')){
				$data_sync = array(
					'tablename' => 'survey',
					'columnname' => 'start_date',
					'meta_primary_key' => $title_url,
					'donetime' => time(),
					'work' => 'edit'
				);
				$this->Synclog_model->store_synclog($data_sync);
			}	
			if($this->input->post('end_date')){
				$data_sync = array(
					'tablename' => 'survey',
					'columnname' => 'end_date',
					'meta_primary_key' => $title_url,
					'donetime' => time(),
					'work' => 'edit'
				);
				$this->Synclog_model->store_synclog($data_sync);
			}
			if($this->input->post('gps_enabled')){
				$data_sync = array(
					'tablename' => 'survey',
					'columnname' => 'gps_enabled',
					'meta_primary_key' => $title_url,
					'donetime' => time(),
					'work' => 'edit'
				);
				$this->Synclog_model->store_synclog($data_sync);
			}			
			if($this->input->post('gps_lat_col')){
				$data_sync = array(
					'tablename' => 'survey',
					'columnname' => 'gps_lat_col',
					'meta_primary_key' => $title_url,
					'donetime' => time(),
					'work' => 'edit'
				);
				$this->Synclog_model->store_synclog($data_sync);
			}	
			if($this->input->post('gps_long_col')){
				$data_sync = array(
					'tablename' => 'survey',
					'columnname' => 'gps_long_col',
					'meta_primary_key' => $title_url,
					'donetime' => time(),
					'work' => 'edit'
				);
				$this->Synclog_model->store_synclog($data_sync);
			}			
			if($this->input->post('access')){
				$data_sync = array(
					'tablename' => 'survey',
					'columnname' => 'access',
					'meta_primary_key' => $title_url,
					'donetime' => time(),
					'work' => 'edit'
				);
				$this->Synclog_model->store_synclog($data_sync);
			}	
			if($this->input->post('sector')){
				$data_sync = array(
					'tablename' => 'survey',
					'columnname' => 'sector',
					'meta_primary_key' => $title_url,
					'donetime' => time(),
					'work' => 'edit'
				);
				$this->Synclog_model->store_synclog($data_sync);
			}	
			if($this->input->post('country')){
				$data_sync = array(
					'tablename' => 'survey',
					'columnname' => 'country',
					'meta_primary_key' => $title_url,
					'donetime' => time(),
					'work' => 'edit'
				);
				$this->Synclog_model->store_synclog($data_sync);
			}				
			/* recording events*/
			
			$this->Survey_model->update_survey_by_title_url($title_url,$data_to_store);
		}
		redirect($_SERVER[‘HTTP_REFERER’]);
	}
	public function section($title_url){
        if(!$this->session->userdata('user_logged_id')){
            redirect('login');
        }
		$data = array(
			'survey' => $this->Survey_model->get_survey_by_title_url($title_url)[0],
			'sections' => $this->Survey_model->get_survey_sections_by_title_url($title_url)
		);
		$this->load->view('header');
		$this->load->view('survey-section',$data);
		$this->load->view('footer');
	}
	public function section_edit($title_url){
        if($this->session->userdata('user_logged_id')){		
			$section=$this->Survey_model->get_survey_section_by_title_url($title_url);
			echo '<form method="post" action="'.base_url().'survey/section/editsave/'.$title_url.'">
				<label>Name Your Section</label>
				<input name="title" type="text" value="'.$section[0]['title'].'">
				<input value="Save" type="submit">
			</form>';
		}
	}
	public function section_editsave($title_url){
        if($this->session->userdata('user_logged_id')){
			/* recording events*/
			$data_sync = array(
				'tablename' => 'survey_section',
				'columnname' => 'title',
				'meta_primary_key' => $title_url,
				'donetime' => time(),
				'work' => 'edit'
			);
			$this->Synclog_model->store_synclog($data_sync);
			/* recording events*/

			$data_to_store = array(
				'title' => $this->input->post('title')
			);
			$this->Survey_model->update_section_by_title_url($title_url,$data_to_store);
		}
		redirect($_SERVER[‘HTTP_REFERER’]);
	}
	public function section_save($title_url){
        if($this->session->userdata('user_logged_id')){		
			
			$data_to_store = array(
				'survey_id' => $title_url,
				'title' => $this->input->post('title'),
				'title_url' => $this->randomString(20,''),
				'add_date' => time()
			);
			$insert_id=$this->Survey_model->store_survey_section($data_to_store);
			$survey=$this->Survey_model->get_survey_by_title_url($title_url);
			$section_sort_id=$survey[0]['section_sort_id'];
			$new_section_sort_id=array();
			if($section_sort_id!=''){
				foreach(explode(',',$section_sort_id) as $ssi){
					array_push($new_section_sort_id,$ssi);
				}
				array_push($new_section_sort_id,$insert_id);
			}else{
				$sections=$this->Survey_model->get_survey_sections_by_title_url($title_url);
				foreach($sections as $s){
					array_push($new_section_sort_id,$s['id']);
				}
			}
			//print_r($new_section_sort_id);
			$data1=array(
				'section_sort_id' => implode(',',$new_section_sort_id)
			);
			
			$this->Survey_model->update_survey_by_title_url($title_url,$data1);
			//echo $this->db->last_query();
			//die;
			/* recording events*/
			$data_sync = array(
				'tablename' => 'survey_section',
				'columnname' => 'title_url',
				'meta_primary_key' => $data_to_store['title_url'],
				'donetime' => time(),
				'work' => 'add'
			);
			$this->Synclog_model->store_synclog($data_sync);
			$data_sync = array(
				'tablename' => 'survey_section',
				'columnname' => 'survey_id',
				'meta_primary_key' => $data_to_store['title_url'],
				'donetime' => time(),
				'work' => 'add'
			);
			$this->Synclog_model->store_synclog($data_sync);
			$data_sync = array(
				'tablename' => 'survey_section',
				'columnname' => 'title',
				'meta_primary_key' => $data_to_store['title_url'],
				'donetime' => time(),
				'work' => 'add'
			);
			$this->Synclog_model->store_synclog($data_sync);
			$data_sync = array(
				'tablename' => 'survey_section',
				'columnname' => 'style',
				'meta_primary_key' => $data_to_store['title_url'],
				'donetime' => time(),
				'work' => 'add'
			);
			$this->Synclog_model->store_synclog($data_sync);
			/* recording events*/
			
		}
		redirect($_SERVER[‘HTTP_REFERER’]);
	}
	public function section_delete($title_url){
        if($this->session->userdata('user_logged_id')){
			$section=$this->Survey_model->get_survey_section_by_title_url($title_url);
			$survey=$this->Survey_model->get_survey_by_title_url($section[0]['survey_id']);
			$section_sort_id=$survey[0]['section_sort_id'];
			$new_section_sort_id=array();
			foreach(explode(',',$section_sort_id) as $ssi){
				if($ssi!=$section[0]['id']){
					array_push($new_section_sort_id,$ssi);
				}
			}
			$data1=array(
				'section_sort_id' => implode(',',$new_section_sort_id)
			);
			
			$questions=$this->Survey_model->get_survey_data_by_title_url($title_url);

			/* recording events*/
			foreach($questions as $q){
				$data_sync = array(
					'tablename' => 'survey_data',
					'columnname' => 'data_id',
					'meta_primary_key' => $q['data_id'],
					'donetime' => time(),
					'work' => 'delete'
				);
				$this->Synclog_model->store_synclog($data_sync);
			}
			/*$data_sync = array(
				'tablename' => 'survey',
				'columnname' => 'section_sort_id',
				'meta_primary_key' => $survey[0]['title_url'],
				'donetime' => time()
			);
			$this->Synclog_model->store_synclog($data_sync);*/
			$data_sync = array(
				'tablename' => 'survey_section',
				'columnname' => 'title_url',
				'meta_primary_key' => $title_url,
				'donetime' => time(),
				'work' => 'delete'
			);
			$this->Synclog_model->store_synclog($data_sync);
			/* recording events*/
			
			$this->Survey_model->update_survey_by_title_url($survey[0]['title_url'],$data1);
			$this->Survey_model->delete_section_by_title_url($title_url);	
        }
		//redirect($_SERVER[‘HTTP_REFERER’]);
	}
	public function section_duplicate($title_url){
        if($this->session->userdata('user_logged_id')){	
			$section=$this->Survey_model->get_survey_section_by_title_url($title_url);
			$new_section_title_url=$this->randomString(20,'');
			$data_to_store = array(
				'survey_id' => $section[0]['survey_id'],
				'title' => $section[0]['title'],
				'title_url' => $new_section_title_url,
				'add_date' => time()
			);
			$insert_id=$this->Survey_model->store_survey_section($data_to_store);
			$survey=$this->Survey_model->get_survey_by_title_url($section[0]['survey_id']);
			$section_sort_id=$survey[0]['section_sort_id'];
			$new_section_sort_id=array();
			if($section_sort_id!=''){
				foreach(explode(',',$section_sort_id) as $ssi){
					array_push($new_section_sort_id,$ssi);
				}
				array_push($new_section_sort_id,$insert_id);
			}else{
				$sections=$this->Survey_model->get_survey_sections_by_title_url($title_url);
				foreach($sections as $s){
					array_push($new_section_sort_id,$s['id']);
				}
			}
			//print_r($new_section_sort_id);
			$data1=array(
				'section_sort_id' => implode(',',$new_section_sort_id)
			);
			$this->Survey_model->update_survey_by_title_url($section[0]['survey_id'],$data1);
			
			/* recording events*/
			$data_sync = array(
				'tablename' => 'survey_section',
				'columnname' => 'title_url',
				'meta_primary_key' => $data_to_store['title_url'],
				'donetime' => time(),
				'work' => 'add'
			);
			$this->Synclog_model->store_synclog($data_sync);
			$data_sync = array(
				'tablename' => 'survey_section',
				'columnname' => 'survey_id',
				'meta_primary_key' => $data_to_store['title_url'],
				'donetime' => time(),
				'work' => 'add'
			);
			$this->Synclog_model->store_synclog($data_sync);
			$data_sync = array(
				'tablename' => 'survey_section',
				'columnname' => 'title',
				'meta_primary_key' => $data_to_store['title_url'],
				'donetime' => time(),
				'work' => 'add'
			);
			$this->Synclog_model->store_synclog($data_sync);
			$data_sync = array(
				'tablename' => 'survey_section',
				'columnname' => 'style',
				'meta_primary_key' => $data_to_store['title_url'],
				'donetime' => time(),
				'work' => 'add'
			);
			$this->Synclog_model->store_synclog($data_sync);
			/* recording events*/	
			
			$questions=$this->Survey_model->get_survey_data_by_title_url($title_url);
			foreach($questions as $q){
				$this->question_copy($new_section_title_url,$q['id']);
			}			
		}
	}
	public function question($title_url){
        if(!$this->session->userdata('user_logged_id')){
            redirect('login');
        }
		$data = array(
			'section' => $this->Survey_model->get_survey_section_by_title_url($title_url)[0]
		);
		$this->load->view('header');
		$this->load->view('survey-question',$data);
		$this->load->view('footer');
	}
	public function question_add($qtype,$title_url){
        if($this->session->userdata('user_logged_id')){		
			$data = array(
				'qtype' =>$qtype,
				'title_url'=>$title_url
			);
			$this->load->view('design_question_add',$data);
		}
	}
	public function question_edit($id){
        if($this->session->userdata('user_logged_id')){		
			$data = array(
				'sd' =>$this->Survey_model->get_survey_data_by_id($id)[0]
			);
			$this->load->view('design_question_edit',$data);
		}
	}
	public function question_editsave($id){
        if($this->session->userdata('user_logged_id')){		
			$languages=$this->db->query("select languages from survey where title_url in (select survey_id from survey_section where title_url='".$this->input->post('title_url')."' ) ");
			$languages=$languages->result_array();
			if(sizeof($languages)>0){
				$languages=$languages[0]['languages'];
				$languages=(array) json_decode($languages);
				//print_r($languages);
			}
			$json_data=$this->input->post();
			$json_data['question']="<English>".$json_data['question']."</English>";
			foreach($languages as $l){
				$json_data['question'].="<".$l.">".$json_data['question_'.$l]."</".$l.">";
				unset($json_data['question_'.$l]);
			}

			if(isset($json_data['answer'])){
				for($i=0;$i<sizeof($json_data['answer']);$i++){
					if(strstr($json_data['answer'][$i],'|')){
						$json_data['answer'][$i]=explode('|',$json_data['answer'][$i]);
						$json_data['answer'][$i]=$json_data['answer'][$i][0]."|"."<English>".$json_data['answer'][$i][1]."</English>";
						foreach($languages as $l){
							if(strstr($json_data['answer_'.$l][$i],'|')){
								$jda_l=explode('|',$json_data['answer_'.$l][$i]);
								$json_data['answer'][$i].="<".$l.">".$jda_l[1]."</".$l.">";
							}else{
								$json_data['answer'][$i].="<".$l.">".$json_data['answer_'.$l][$i]."</".$l.">";
							}
						}
					}
				}
				foreach($languages as $l){
					unset($json_data['answer_'.$l]);
				}
			}
			if(isset($json_data['instructions_for_respondent'])){
				$json_data['instructions_for_respondent']="<English>".$json_data['instructions_for_respondent']."</English>";
				foreach($languages as $l){
					$json_data['instructions_for_respondent'].="<".$l.">".$json_data['instructions_for_respondent_'.$l]."</".$l.">";
					unset($json_data['instructions_for_respondent_'.$l]);
				}
			}
			if(isset($json_data['rows'])){
				for($i=0;$i<sizeof($json_data['rows']);$i++){
					$json_data['rows'][$i]="<English>".$json_data['rows'][$i]."</English>";
				}
				foreach($languages as $l){
					for($i=0;$i<sizeof($json_data['rows']);$i++){
						$json_data['rows'][$i].="<".$l.">".$json_data['rows_'.$l][$i]."</".$l.">";
					}
					unset($json_data['rows_'.$l]);
				}
			}

			if(isset($json_data['columns'])){
				for($i=0;$i<sizeof($json_data['columns']);$i++){
					if(strlen($json_data['columns'][$i])>50){
						$json_data['columns'][$i]=$this->str_break($json_data['columns'][$i],50);
					}
					$json_data['columns'][$i]="<English>".$json_data['columns'][$i]."</English>";
				}
				foreach($languages as $l){
					for($i=0;$i<sizeof($json_data['columns']);$i++){
						if(mb_strlen($json_data['columns_'.$l][$i])>50){
							$json_data['columns_'.$l][$i]=$this->mb_wordwrap($json_data['columns_'.$l][$i],50);
							//$json_data['columns_'.$l][$i]=$this->chunk_split_unicode($json_data['columns_'.$l][$i],50,'-<br>');		//inserting br tag in text after 50 characters											
						}
						$json_data['columns'][$i].="<".$l.">".$json_data['columns_'.$l][$i]."</".$l.">";
					}
					unset($json_data['columns_'.$l]);
				}
			}
			
			if(isset($json_data['dropdown_choices'])){
				for($i=0;$i<sizeof($json_data['dropdown_choices']);$i++){
					if(strstr($json_data['dropdown_choices'][$i],'|')){
						if(strstr($json_data['dropdown_choices'][$i],PHP_EOL)){
							$json_data['dropdown_choices'][$i]=str_replace(PHP_EOL.PHP_EOL,PHP_EOL,$json_data['dropdown_choices'][$i]);
							$new_choice=explode(PHP_EOL,$json_data['dropdown_choices'][$i]);
							for($k=0;$k<sizeof($new_choice);$k++){
								if($new_choice[$k]!=="" && $new_choice[$k]!=="|"){
									$new_choice[$k]=explode('|',$new_choice[$k]);
									$new_choice[$k]=$new_choice[$k][0]."|"."<English>".$new_choice[$k][1]."</English>";
								}
							}
							$json_data['dropdown_choices'][$i]=$new_choice;
						}else{
							$new_choice=explode('|',$json_data['dropdown_choices'][$i]);
							$new_choice=$new_choice[0]."|"."<English>".$new_choice[1]."</English>";
							$json_data['dropdown_choices'][$i]=$new_choice;
						}
						foreach($languages as $l){
							if(isset($json_data['dropdown_choices_'.$l])){
								if(strstr($json_data['dropdown_choices_'.$l][$i],PHP_EOL)){
									$json_data['dropdown_choices_'.$l][$i]=str_replace(PHP_EOL.PHP_EOL,PHP_EOL,$json_data['dropdown_choices_'.$l][$i]);
									$new_choice_l=explode(PHP_EOL,$json_data['dropdown_choices_'.$l][$i]);
								}else{
									$new_choice_l=$json_data['dropdown_choices_'.$l][$i];
								}
							}
							$new_choice_l_temp=array();
							if(isset($new_choice_l)){
								if(is_array($new_choice_l)){
									for($j=0;$j<sizeof($new_choice_l);$j++){
										if($new_choice_l[$j]!=="" && $new_choice_l[$j]!=="|"){
											if(strstr($new_choice_l[$j],'|')){
												$jda_l=explode('|',$new_choice_l[$j]);
												array_push($new_choice_l_temp,"<".$l.">".$jda_l[1]."</".$l.">");
											}else{
												array_push($new_choice_l_temp,"<".$l.">".$new_choice_l[$j]."</".$l.">");
											}
										}
									}
								}else{
									if(strstr($new_choice_l,'|')){
										$jda_l=explode('|',$new_choice_l);
										array_push($new_choice_l_temp,"<".$l.">".$jda_l[1]."</".$l.">");
									}else{
										array_push($new_choice_l_temp,"<".$l.">".$new_choice_l."</".$l.">");
									}									
								}
								$json_data['dropdown_choices_'.$l][$i]=$new_choice_l_temp;
							}
						}
					}
				}
			}
			$big_a=array();
			//print_r($json_data);
			if(isset($json_data['dropdown_choices'])){
				if(is_array($json_data['dropdown_choices'])){
					for($x=0;$x<sizeof($json_data['dropdown_choices']);$x++){
						$small_a=array();
						if(is_array($json_data['dropdown_choices'][$x])){
							for($y=0;$y<sizeof($json_data['dropdown_choices'][$x]);$y++){
								$temp=$json_data['dropdown_choices'][$x][$y];
								$temp2='';
								foreach($languages as $l){
									if(isset($json_data['dropdown_choices_'.$l][$x][$y])){
										$temp2.=$json_data['dropdown_choices_'.$l][$x][$y];
									}
								}
								array_push($small_a,$temp.$temp2);
							}
						}else{
								$temp=$json_data['dropdown_choices'][$x];
								$temp2='';
								foreach($languages as $l){
									if(is_array($json_data['dropdown_choices_'.$l][$x])){
										for($y=0;$y<sizeof($json_data['dropdown_choices_'.$l][$x]);$y++){
											$temp2.=$json_data['dropdown_choices_'.$l][$x][$y];
										}
									}
								}
								array_push($small_a,$temp.$temp2);
							
						}
						array_push($big_a,$small_a);
					}
				}
				$json_data['dropdown_choices']=$big_a;
			}
			foreach($languages as $l){
				unset($json_data['dropdown_choices_'.$l]);
			}
			
			//print_r($json_data);die;
			
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'jpg|jpeg|gif|png';
			$config['max_size']    = '99999';
			$config['encrypt_name'] = TRUE;
			$this->upload->initialize($config);
			$this->load->library('upload', $config);
			if($this->upload->do_upload('answer_file')==1){
				$image=$this->upload->file_name;
				$json_data['answer_file']=base_url()."uploads/".$image;	
			}

			$question_data=$this->Survey_model->get_survey_data_by_id($id);
			/* recording events*/
			$data_sync = array(
				'tablename' => 'survey_data',
				'columnname' => 'json_data',
				'meta_primary_key' => $question_data[0]['data_id'],
				'donetime' => time(),
				'work' => 'edit'
			);
			$this->Synclog_model->store_synclog($data_sync);
			/* recording events*/
			
			$data_to_store = array(
				'json_data' => json_encode($json_data),
				'complete' => "0"
			);
			
			$this->Survey_model->update_survey_data_by_id($id,$data_to_store);
		}
		redirect($_SERVER[‘HTTP_REFERER’]);
	}
	public function question_duplicate($question_id){
		$question=$this->Survey_model->get_survey_data_by_id($question_id);
		$section=$this->Survey_model->get_survey_section_by_title_url($question[0]['survey_id']);
		//print_r($question);
		$data=array(
			'data_id' => $this->randomString(20,''),
			'survey_id' => $section[0]['title_url'],
			'qtype'=> $question[0]['qtype'],
			'json_data'=> $question[0]['json_data'],
			'code'=> $question[0]['code'],
			'elements'=> $question[0]['elements'],
			'lengths'=> $question[0]['lengths'],
			'code_name'=> $question[0]['code_name'],
			'style'=> $question[0]['style'],
			'add_date' => time()
		);
		$insert_id=$this->Survey_model->store_survey_data($data);

		/* recording events*/
		$data_sync = array(
			'tablename' => 'survey_data',
			'columnname' => 'data_id',
			'meta_primary_key' => $data['data_id'],
			'donetime' => time(),
			'work' => 'add'
		);
		$this->Synclog_model->store_synclog($data_sync);
		$data_sync = array(
			'tablename' => 'survey_data',
			'columnname' => 'survey_id',
			'meta_primary_key' => $data['data_id'],
			'donetime' => time(),
			'work' => 'add'
		);
		$this->Synclog_model->store_synclog($data_sync);
		$data_sync = array(
			'tablename' => 'survey_data',
			'columnname' => 'json_data',
			'meta_primary_key' => $data['data_id'],
			'donetime' => time(),
			'work' => 'add'
		);
		$this->Synclog_model->store_synclog($data_sync);
		$data_sync = array(
			'tablename' => 'survey_data',
			'columnname' => 'qtype',
			'meta_primary_key' => $data['data_id'],
			'donetime' => time(),
			'work' => 'add'
		);
		$this->Synclog_model->store_synclog($data_sync);
		$data_sync = array(
			'tablename' => 'survey_data',
			'columnname' => 'code',
			'meta_primary_key' => $data['data_id'],
			'donetime' => time(),
			'work' => 'add'
		);
		$this->Synclog_model->store_synclog($data_sync);
		$data_sync = array(
			'tablename' => 'survey_data',
			'columnname' => 'elements',
			'meta_primary_key' => $data['data_id'],
			'donetime' => time(),
			'work' => 'add'
		);
		$this->Synclog_model->store_synclog($data_sync);
		$data_sync = array(
			'tablename' => 'survey_data',
			'columnname' => 'lengths',
			'meta_primary_key' => $data['data_id'],
			'donetime' => time(),
			'work' => 'add'
		);
		$this->Synclog_model->store_synclog($data_sync);
		$data_sync = array(
			'tablename' => 'survey_data',
			'columnname' => 'code_name',
			'meta_primary_key' => $data['data_id'],
			'donetime' => time(),
			'work' => 'add'
		);
		$this->Synclog_model->store_synclog($data_sync);
		$data_sync = array(
			'tablename' => 'survey_data',
			'columnname' => 'style',
			'meta_primary_key' => $data['data_id'],
			'donetime' => time(),
			'work' => 'add'
		);
		$this->Synclog_model->store_synclog($data_sync);
		/* recording events*/
		
		$section=$this->Survey_model->get_survey_section_by_title_url($section[0]['title_url']);
		$question_sort_id=$section[0]['question_sort_id'];
		$new_question_sort_id=array();
		if($question_sort_id!=''){
			foreach(explode(',',$question_sort_id) as $qsi){
				array_push($new_question_sort_id,$qsi);
			}
			array_push($new_question_sort_id,$insert_id);
		}else{
			$questions=$this->Survey_model->get_survey_data_by_title_url($qestion[0]['title_url']);
			foreach($questions as $q){
				array_push($new_question_sort_id,$q['id']);
			}
		}
		$data1=array(
			'question_sort_id' => implode(',',$new_question_sort_id)
		);
		$this->Survey_model->update_section_by_title_url($section[0]['title_url'],$data1);
		
	}		
	public function question_save($title_url){
        if($this->session->userdata('user_logged_id')){		
			$languages=$this->db->query("select languages from survey where title_url in (select survey_id from survey_section where title_url='".$title_url."' ) ");
			$languages=$languages->result_array();
			if(sizeof($languages)>0){
				$languages=$languages[0]['languages'];
				$languages=(array) json_decode($languages);
				//print_r($languages);
			}
			$json_data=$this->input->post();
			$json_data['question']="<English>".$json_data['question']."</English>";
			foreach($languages as $l){
				$json_data['question'].="<".$l.">".$json_data['question_'.$l]."</".$l.">";
				unset($json_data['question_'.$l]);
			}
			if(isset($json_data['answer'])){
				for($i=0;$i<sizeof($json_data['answer']);$i++){
					if(strstr($json_data['answer'][$i],'|')){
						$json_data['answer'][$i]=explode('|',$json_data['answer'][$i]);
						$json_data['answer'][$i]=$json_data['answer'][$i][0]."|"."<English>".$json_data['answer'][$i][1]."</English>";
						foreach($languages as $l){
							if(strstr($json_data['answer_'.$l][$i],'|')){
								$jda_l=explode('|',$json_data['answer_'.$l][$i]);
								$json_data['answer'][$i].="<".$l.">".$jda_l[1]."</".$l.">";
							}else{
								$json_data['answer'][$i].="<".$l.">".$json_data['answer_'.$l][$i]."</".$l.">";
							}
						}
					}
				}
				foreach($languages as $l){
					unset($json_data['answer_'.$l]);
				}
			}
			if(isset($json_data['instructions_for_respondent'])){
				$json_data['instructions_for_respondent']="<English>".$json_data['instructions_for_respondent']."</English>";
				foreach($languages as $l){
					$json_data['instructions_for_respondent'].="<".$l.">".$json_data['instructions_for_respondent_'.$l]."</".$l.">";
					unset($json_data['instructions_for_respondent_'.$l]);
				}
			}
			if(isset($json_data['rows'])){
				for($i=0;$i<sizeof($json_data['rows']);$i++){
					$json_data['rows'][$i]="<English>".$json_data['rows'][$i]."</English>";
				}
				foreach($languages as $l){
					for($i=0;$i<sizeof($json_data['rows']);$i++){
						$json_data['rows'][$i].="<".$l.">".$json_data['rows_'.$l][$i]."</".$l.">";
					}
					unset($json_data['rows_'.$l]);
				}
			}
			if(isset($json_data['columns'])){
				for($i=0;$i<sizeof($json_data['columns']);$i++){
					if(strlen($json_data['columns'][$i])>50){
						$json_data['columns'][$i]=$this->str_break($json_data['columns'][$i],50);
					}					
					$json_data['columns'][$i]="<English>".$json_data['columns'][$i]."</English>";
				}
				foreach($languages as $l){
					for($i=0;$i<sizeof($json_data['columns']);$i++){
						if(mb_strlen($json_data['columns_'.$l][$i])>50){
							$json_data['columns_'.$l][$i]=$this->mb_wordwrap($json_data['columns_'.$l][$i],50);
							//$json_data['columns_'.$l][$i]=$this->chunk_split_unicode($json_data['columns_'.$l][$i],50,'-<br>');		//inserting br tag in text after 50 characters											
						}						
						$json_data['columns'][$i].="<".$l.">".$json_data['columns_'.$l][$i]."</".$l.">";
					}
					unset($json_data['columns_'.$l]);
				}
			}
			//print_r($json_data);
			if(isset($json_data['dropdown_choices'])){
				for($i=0;$i<sizeof($json_data['dropdown_choices']);$i++){
					if(strstr($json_data['dropdown_choices'][$i],'|')){
						if(strstr($json_data['dropdown_choices'][$i],PHP_EOL)){
							$json_data['dropdown_choices'][$i]=str_replace(PHP_EOL.PHP_EOL,PHP_EOL,$json_data['dropdown_choices'][$i]);
							$new_choice=explode(PHP_EOL,$json_data['dropdown_choices'][$i]);
							for($k=0;$k<sizeof($new_choice);$k++){
								if($new_choice[$k]!=="" && $new_choice[$k]!=="|"){
									$new_choice[$k]=explode('|',$new_choice[$k]);
									$new_choice[$k]=$new_choice[$k][0]."|"."<English>".$new_choice[$k][1]."</English>";
								}
							}
							$json_data['dropdown_choices'][$i]=$new_choice;
						}else{
							$new_choice=explode('|',$json_data['dropdown_choices'][$i]);
							$new_choice=$new_choice[0]."|"."<English>".$new_choice[1]."</English>";
							$json_data['dropdown_choices'][$i]=$new_choice;
						}
						foreach($languages as $l){
							if(isset($json_data['dropdown_choices_'.$l])){
								if(strstr($json_data['dropdown_choices_'.$l][$i],PHP_EOL)){
									$json_data['dropdown_choices_'.$l][$i]=str_replace(PHP_EOL.PHP_EOL,PHP_EOL,$json_data['dropdown_choices_'.$l][$i]);
									$new_choice_l=explode(PHP_EOL,$json_data['dropdown_choices_'.$l][$i]);
								}else{

									$new_choice_l=$json_data['dropdown_choices_'.$l][$i];
								}
							}
							$new_choice_l_temp=array();
							if(isset($new_choice_l)){
								if(is_array($new_choice_l)){
									for($j=0;$j<sizeof($new_choice_l);$j++){
										if($new_choice_l[$j]!=="" && $new_choice_l[$j]!=="|"){
											if(strstr($new_choice_l[$j],'|')){
												$jda_l=explode('|',$new_choice_l[$j]);
												array_push($new_choice_l_temp,"<".$l.">".$jda_l[1]."</".$l.">");
											}else{
												array_push($new_choice_l_temp,"<".$l.">".$new_choice_l[$j]."</".$l.">");
											}
										}
									}
								}else{
									if(strstr($new_choice_l,'|')){
										$jda_l=explode('|',$new_choice_l);
										array_push($new_choice_l_temp,"<".$l.">".$jda_l[1]."</".$l.">");
									}else{
										array_push($new_choice_l_temp,"<".$l.">".$new_choice_l."</".$l.">");
									}									
								}
								$json_data['dropdown_choices_'.$l][$i]=$new_choice_l_temp;
							}
						}
					}
				}
			}
			$big_a=array();
			//print_r($json_data);
			if(isset($json_data['dropdown_choices'])){
				if(is_array($json_data['dropdown_choices'])){
					for($x=0;$x<sizeof($json_data['dropdown_choices']);$x++){
						$small_a=array();
						if(is_array($json_data['dropdown_choices'][$x])){
							for($y=0;$y<sizeof($json_data['dropdown_choices'][$x]);$y++){
								$temp=$json_data['dropdown_choices'][$x][$y];
								$temp2='';
								foreach($languages as $l){
									if(isset($json_data['dropdown_choices_'.$l][$x][$y])){
										$temp2.=$json_data['dropdown_choices_'.$l][$x][$y];
									}
								}
								array_push($small_a,$temp.$temp2);
							}
						}else{
								$temp=$json_data['dropdown_choices'][$x];
								$temp2='';
								foreach($languages as $l){
									for($y=0;$y<sizeof($json_data['dropdown_choices_'.$l][$x]);$y++){
										$temp2.=$json_data['dropdown_choices_'.$l][$x][$y];
									}
								}
								array_push($small_a,$temp.$temp2);
							
						}
						array_push($big_a,$small_a);
					}
				}
				$json_data['dropdown_choices']=$big_a;
			}
			foreach($languages as $l){
				unset($json_data['dropdown_choices_'.$l]);
			}
			//print_r($json_data);
			//die;
			
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'jpg|jpeg|gif|png';
			$config['max_size']    = '99999';
			$config['encrypt_name'] = TRUE;
			$this->upload->initialize($config);
			$this->load->library('upload', $config);
			if($this->upload->do_upload('answer_file')==1){
				$image=$this->upload->file_name;
				$json_data['answer_file']=base_url()."uploads/".$image;	
			}

			$data=array(
				'data_id' => $this->randomString(20,''),
				'survey_id' => $title_url,
				'qtype'=> $this->input->post('qtype'),
				'json_data'=> json_encode($json_data),
				'add_date' => time()
			);
			$insert_id=$this->Survey_model->store_survey_data($data);
			/* recording events*/
			$data_sync = array(
				'tablename' => 'survey_data',
				'columnname' => 'data_id',
				'meta_primary_key' => $data['data_id'],
				'donetime' => time(),
				'work' => 'add'
			);
			$this->Synclog_model->store_synclog($data_sync);
			$data_sync = array(
				'tablename' => 'survey_data',
				'columnname' => 'survey_id',
				'meta_primary_key' => $data['data_id'],
				'donetime' => time(),
				'work' => 'edit'
			);
			$this->Synclog_model->store_synclog($data_sync);
			$data_sync = array(
				'tablename' => 'survey_data',
				'columnname' => 'qtype',
				'meta_primary_key' => $data['data_id'],
				'donetime' => time(),
				'work' => 'edit'
			);
			$this->Synclog_model->store_synclog($data_sync);
			$data_sync = array(
				'tablename' => 'survey_data',
				'columnname' => 'json_data',
				'meta_primary_key' => $data['data_id'],
				'donetime' => time(),
				'work' => 'edit'
			);
			$this->Synclog_model->store_synclog($data_sync);
			/* recording events*/
			
			$section=$this->Survey_model->get_survey_section_by_title_url($title_url);
			$question_sort_id=$section[0]['question_sort_id'];
			$new_question_sort_id=array();
			if($question_sort_id!=''){
				foreach(explode(',',$question_sort_id) as $qsi){
					array_push($new_question_sort_id,$qsi);
				}
				array_push($new_question_sort_id,$insert_id);
			}else{
				$questions=$this->Survey_model->get_survey_data_by_title_url($title_url);
				foreach($questions as $q){
					array_push($new_question_sort_id,$q['id']);
				}
			}
			$data1=array(
				'question_sort_id' => implode(',',$new_question_sort_id)
			);
			$this->Survey_model->update_section_by_title_url($title_url,$data1);
		}
		redirect($_SERVER[‘HTTP_REFERER’]);
	}
	public function question_collectcode($id){
		$constants=get_defined_constants();
		$codeArrAvailable=unserialize($constants['codeArrAvailable']);
		$codeArr=unserialize($constants['codeArr']);
        if($this->session->userdata('user_logged_id')){
			$question=$this->Survey_model->get_survey_data_by_id($id);
			$codename_arr=(array) json_decode($question[0]['code_name']);
			//print_r($question);
			//print_r($codename_arr);
			
			$survey_question_text_arr=array();
			$multiple_answer='';
			$sqt=(array) json_decode($question[0]['json_data']);
			//print_r($sqt);
			if(isset($sqt['multiple_answer'])){
				$multiple_answer=$sqt['multiple_answer'];
			}
			if(isset($sqt['rows']) && isset($sqt['rows'])){
				$sqt_combine='';
				$sqt_rows=$sqt['rows'];
				
				if(!isset($sqt['columns'])){
					for($i=0;$i<count($sqt_rows);$i++){
						$survey_question_text_arr["answer_".strtolower($sqt['question_no'])."_".$i]=$sqt_rows[$i];
					}
				}else{
					$sqt_columns=$sqt['columns'];
					$new_sqt_columns=$sqt['columns'];				
					//print_r($sqt_rows);					print_r($sqt_columns);
					for($i=0;$i<count($sqt_rows);$i++){
						for($j=0;$j<count($sqt_columns);$j++){
							$sqt_combine=$sqt_rows[$i]." - ".$sqt_columns[$j];
							$survey_question_text_arr["answer_".strtolower($sqt['question_no'])."_".$i.$j]=$sqt_combine;

							if(isset($sqt['type'][$j]) && $sqt['type'][$j]=="Checkbox"){
								//print_r($sqt['dropdown_choices'][$j]);
								$sqt_dropdown_j=$sqt['dropdown_choices'][$j];
								foreach($sqt_dropdown_j as  $sqt_a){
									if(end($sqt_dropdown_j)!=$sqt_a){
										$sqt_a=explode("|",$sqt_a);
										$survey_question_text_arr["answer_".strtolower($sqt['question_no'])."_".$i.$j."_".$sqt_a[0]]=$sqt_a[1];

										$matches='';
										preg_match("#<English>(.*?)</English>#", trim($sqt_a[1]), $matches);
										$sqt_a[1]=$matches[1];
										$survey_question_text_arr2["answer_".strtolower($sqt['question_no'])."_".$i.$j."_".$sqt_a[0]]=$new_sqt_columns[$j]."_".$sqt_a[0];		
									}else{
										$sqt_a=explode("|",$sqt_a);
										$survey_question_text_arr["answer_".strtolower($sqt['question_no'])."_".$i.$j."_".$sqt_a[0]]=$sqt_a[1];
										//$survey_question_text_arr["answer_".strtolower($sqt['question_no'])."_".$i.$j"_oth"]=$sqt_a[1];

										$matches='';
										preg_match("#<English>(.*?)</English>#", trim($sqt_a[1]), $matches);
										$sqt_a[1]=$matches[1];
										$survey_question_text_arr2["answer_".strtolower($sqt['question_no'])."_".$i.$j."_".$sqt_a[0]]=$new_sqt_columns[$j]."_".$sqt_a[0];		
									}
								}							
							}					

						}
					}
				}
				
			}else{
				if(is_array($sqt) && isset($sqt['multiple_answer']) && $sqt['multiple_answer']=='1'){
					$survey_question_text_arr["answer_".strtolower($sqt['question_no'])]=$sqt['question'];
					foreach($sqt['answer'] as  $sqt_a){
						$sqt_a=explode("|",$sqt_a);
						$survey_question_text_arr["answer_".strtolower($sqt['question_no'])."_".$sqt_a[0]]=$sqt_a[1];
					}
				}else{
					$survey_question_text_arr["answer_".strtolower($sqt['question_no'])]=$sqt['question'];
				}
			}
			//print_r($survey_question_text_arr);
			echo "<form><input type='hidden' name='question_id' value='".$question[0]['id']."' />";
			echo "<table width='100%'>";
				echo "<tr></tr>";
				echo "<th align='center' style='width:60% !important'><label>Variables</label></th>";
				foreach($codeArrAvailable as $ca){
					if($ca=="isRequired"){
						echo '<th><label>&nbsp;Required&nbsp;<input type="checkbox" onclick="checkAll(this,0,this.checked)" /></label></th>';
					}else if($ca=="skip"){
						echo '<th><label>&nbsp;Skip Check&nbsp;<input type="checkbox" onclick="checkAll(this,1,this.checked)" /></label></th>';
					}else if($ca=="isRange"){
						echo '<th><label>&nbsp;Range Check&nbsp;<input type="checkbox" onclick="checkAll(this,2,this.checked)" /></label></th>';
					}else{
						echo "<th><label>&nbsp;".$ca."&nbsp;</label></th>";
					}
				}
				echo "<tr></tr>";
			foreach(json_decode($question[0]['elements']) as $qe){
				echo "<tr></tr>";
				$qe_temp=$qe;
				if(strstr($qe_temp,'_dd_')){
					$qe_temp=str_replace('dd_','',$qe_temp);
				}
				if(strstr($qe_temp,'_mm_')){
					$qe_temp=str_replace('mm_','',$qe_temp);
				}
				if(strstr($qe_temp,'_yyyy_')){
					$qe_temp=str_replace('yyyy_','',$qe_temp);
				}
				if(strstr($qe_temp,'_h_')){
					$qe_temp=str_replace('h_','',$qe_temp);
				}
				if(strstr($qe_temp,'_m_')){
					$qe_temp=str_replace('m_','',$qe_temp);
				}
				if(strstr($qe_temp,'_oth')){
					$qe_temp=str_replace('_oth','',$qe_temp);
				}
				if(isset($survey_question_text_arr[$qe_temp])){	
					$matches='';
					preg_match("#<English>(.*?)</English>#", trim($survey_question_text_arr[$qe_temp]), $matches);
					$survey_question_text_arr[$qe_temp]=$matches[0];					
				}				
				if(isset($codename_arr[$qe]) && $codename_arr[$qe]!=""){
					echo "<td><label>[".$codename_arr[$qe]."] ".$survey_question_text_arr[$qe_temp]."</label></td>";
				}else{
					echo "<td><label>[".$qe."] ".$survey_question_text_arr[$qe_temp]."</label></td>";
				}
				$i=-1;
				foreach($codeArrAvailable as $ca){
					$i++;
					if(isset($codename_arr[$qe]) && $codename_arr[$qe]!=""){
						echo "<td align='center'><label><input class='".$i."' name='".$codename_arr[$qe]."[]' type='checkbox' value='".$ca."' /></label></td>";
					}else{
						echo "<td align='center'><label><input class='".$i."' name='".$qe."[]' type='checkbox' value='".$ca."' /></label></td>";
					}
				}
				echo "<tr></tr>";
			}
			echo "</table><input onClick='generateCode(this)' type='button' value='Generate' /></form>";
		}
	}
	public function question_collectname($id){
        if($this->session->userdata('user_logged_id')){
			$question_codename_arr=array();
			$question=$this->Survey_model->get_survey_data_by_id($id);
			if(isset($question[0]['code_name'])){
				$question_codename_arr=(array) json_decode($question[0]['code_name']);
			}
			//print_r($question_codename_arr);
			
			$survey_question_text_arr=array();
			$survey_question_text_arr2=array();
			$multiple_answer='';
			$sqt=(array) json_decode($question[0]['json_data']);
			//print_r($sqt);
			if(isset($sqt['multiple_answer'])){
				$multiple_answer=$sqt['multiple_answer'];
			}
			if(isset($sqt['rows'])){
				//print_r($sqt);
				$row_default=0;
				$sqt_rows=$sqt['rows'];
				$sqt_rows_count=sizeof($sqt_rows);

				if(!isset($sqt['columns'])){
					for($i=0;$i<count($sqt_rows);$i++){
						if(strstr($sqt_rows[$i],"English")){
							$matches='';
							preg_match("#<English>(.*?)</English>#", trim($sqt_rows[$i]), $matches);
							$sqt_rows[$i]=$matches[1];
							if(strstr($sqt_rows[$i]," ")){
								$sqt_rows[$i]=explode(" ",$sqt_rows[$i]);
								$sqt_rows[$i]=$sqt_rows[$i][0];
							}								
						}	
						$survey_question_text_arr["answer_".strtolower($sqt['question_no'])."_".$i]=$sqt['question_no']."_".$sqt_rows[$i];
					}
				}else{
					$sqt_columns=$sqt['columns'];
					$sqt_columns_count=sizeof($sqt_columns);
					$new_sqt_columns=$sqt['columns'];
					//print_r($sqt_rows);print_r($sqt_columns);
					
					for($i=0;$i<count($sqt_rows);$i++){
						for($j=0;$j<count($sqt_columns);$j++){
							if(strstr($sqt_rows[$i],"English")){
								$matches='';
								preg_match("#<English>(.*?)</English>#", trim($sqt_rows[$i]), $matches);
								$sqt_rows[$i]=$matches[1];
								if(strstr($sqt_rows[$i]," ")){
									$sqt_rows[$i]=explode(" ",$sqt_rows[$i]);
									$sqt_rows[$i]=$sqt_rows[$i][0];
								}								
							}
							if(strstr($new_sqt_columns[$j],"English")){
								$matches='';
								preg_match("#<English>(.*?)</English>#", trim($new_sqt_columns[$j]), $matches);
								$new_sqt_columns[$j]=$matches[1];
							}

							$sqt_combine='';
							$sqt_combine=$sqt_rows[$i]." - ".$sqt_columns[$j];
							$survey_question_text_arr["answer_".strtolower($sqt['question_no'])."_".$i.$j]=$sqt_combine;

							$sqt_combine2='';
							$new_sqt_columns[$j]=explode(' ',$new_sqt_columns[$j]);
							$new_sqt_columns[$j]=$new_sqt_columns[$j][0];
							if($sqt_rows[$i]==''){
								$sqt_combine2=$new_sqt_columns[$j]."_".($i+1);		//if now rows given auto number according to it
							}else{
								$sqt_combine2=$new_sqt_columns[$j]."_".$sqt_rows[$i];
							}
							$survey_question_text_arr2["answer_".strtolower($sqt['question_no'])."_".$i.$j]=$sqt_combine2;

							if(isset($sqt['type_other'][$j]) && $sqt['type_other'][$j]==1){
								$survey_question_text_arr["answer_".strtolower($sqt['question_no'])."_".$i.$j."_oth"]=$sqt_combine;
							}
							if(isset($sqt['type'][$j]) && $sqt['type'][$j]=="Checkbox"){
								//print_r($sqt['dropdown_choices'][$j]);
								$sqt_dropdown_j=$sqt['dropdown_choices'][$j];
								foreach($sqt_dropdown_j as  $sqt_a){
									if(end($sqt_dropdown_j)!=$sqt_a){
										$sqt_a=explode("|",$sqt_a);
										$survey_question_text_arr["answer_".strtolower($sqt['question_no'])."_".$i.$j."_".$sqt_a[0]]=$sqt_a[1];

										$matches='';
										preg_match("#<English>(.*?)</English>#", trim($sqt_a[1]), $matches);
										$sqt_a[1]=$matches[1];
										$survey_question_text_arr2["answer_".strtolower($sqt['question_no'])."_".$i.$j."_".$sqt_a[0]]=$sqt_combine2."_".$sqt_a[0];		
									}else{
										$sqt_a=explode("|",$sqt_a);
										$survey_question_text_arr["answer_".strtolower($sqt['question_no'])."_".$i.$j."_".$sqt_a[0]]=$sqt_a[1];
										//$survey_question_text_arr["answer_".strtolower($sqt['question_no'])."_".$i.$j"_oth"]=$sqt_a[1];

										$matches='';
										preg_match("#<English>(.*?)</English>#", trim($sqt_a[1]), $matches);
										$sqt_a[1]=$matches[1];
										$survey_question_text_arr2["answer_".strtolower($sqt['question_no'])."_".$i.$j."_".$sqt_a[0]]=$sqt_combine2."_".$sqt_a[0];
									}
								}							
							}
							if(isset($sqt['type'][$j]) && $sqt['type'][$j]=="Date"){
								if(isset($sqt['answer_dd'][$j]) && $sqt['answer_dd'][$j]=="dd"){
									$survey_question_text_arr["answer_dd_".strtolower($sqt['question_no'])."_".$i.$j]=$sqt_combine;	
								}
								if(isset($sqt['answer_mm'][$j]) && $sqt['answer_mm'][$j]=="mm"){
									$survey_question_text_arr["answer_mm_".strtolower($sqt['question_no'])."_".$i.$j]=$sqt_combine;	
								}
								if(isset($sqt['answer_yyyy'][$j]) && $sqt['answer_yyyy'][$j]=="yyyy"){
									$survey_question_text_arr["answer_yyyy_".strtolower($sqt['question_no'])."_".$i.$j]=$sqt_combine;	
								}
								if(isset($sqt['answer_h'][$j]) && $sqt['answer_h'][$j]=="h"){
									$survey_question_text_arr["answer_h_".strtolower($sqt['question_no'])."_".$i.$j]=$sqt_combine;	
								}
								if(isset($sqt['answer_m'][$j]) && $sqt['answer_m'][$j]=="m"){
									$survey_question_text_arr["answer_m_".strtolower($sqt['question_no'])."_".$i.$j]=$sqt_combine;	
								}								
							}							
						}
					}
				}
			}else{
				//print_r($sqt);
				if(isset($sqt['multiple_answer']) && $sqt['multiple_answer']=='1'){
				//print_r($sqt);
					$survey_question_text_arr["answer_".strtolower($sqt['question_no'])]=$sqt['question'];
					$survey_question_text_arr2["answer_".strtolower($sqt['question_no'])]=$sqt['question_no'];
					foreach($sqt['answer'] as  $sqt_a){
						if(end($sqt['answer'])!=$sqt_a){
							$sqt_a=explode("|",$sqt_a);
							$survey_question_text_arr["answer_".strtolower($sqt['question_no'])."_".$sqt_a[0]]=$sqt_a[1];
							
							$matches='';
							preg_match("#<English>(.*?)</English>#", trim($sqt_a[1]), $matches);
							$sqt_a[1]=$matches[1];
							$survey_question_text_arr2["answer_".strtolower($sqt['question_no'])."_".$sqt_a[0]]=strtolower($sqt['question_no'])."_".$sqt_a[0];		
						}else{
							$sqt_a=explode("|",$sqt_a);
							$survey_question_text_arr["answer_".strtolower($sqt['question_no'])."_".$sqt_a[0]]=$sqt_a[1];
							$survey_question_text_arr["answer_".strtolower($sqt['question_no'])."_oth"]=$sqt_a[1];
							
							$matches='';
							preg_match("#<English>(.*?)</English>#", trim($sqt_a[1]), $matches);
							$sqt_a[1]=$matches[1];
							$survey_question_text_arr2["answer_".strtolower($sqt['question_no'])."_".$sqt_a[0]]=strtolower($sqt['question_no'])."_".$sqt_a[0];		
						}
					}
				}else if(isset($sqt['answer']) && sizeof($sqt['answer'])>0){
					if( in_array('dd',$sqt['answer']) || in_array('mm',$sqt['answer']) || in_array('yyyy',$sqt['answer']) || in_array('h',$sqt['answer']) || in_array('m',$sqt['answer']) ){
						if( in_array('dd',$sqt['answer'])){
							$survey_question_text_arr["answer_dd_".strtolower($sqt['question_no'])]=$sqt['question'];
						}
						if( in_array('mm',$sqt['answer'])){
							$survey_question_text_arr["answer_mm_".strtolower($sqt['question_no'])]=$sqt['question'];
						}
						if( in_array('yyyy',$sqt['answer'])){
							$survey_question_text_arr["answer_yyyy_".strtolower($sqt['question_no'])]=$sqt['question'];
						}
						if( in_array('h',$sqt['answer'])){
							$survey_question_text_arr["answer_h_".strtolower($sqt['question_no'])]=$sqt['question'];
						}
						if( in_array('m',$sqt['answer'])){
							$survey_question_text_arr["answer_m_".strtolower($sqt['question_no'])]=$sqt['question'];
						}	
						$survey_question_text_arr2["answer_".strtolower($sqt['question_no'])]=$sqt['question_no'];	
					}else{
						$survey_question_text_arr["answer_".strtolower($sqt['question_no'])]=$sqt['question'];
						$survey_question_text_arr2["answer_".strtolower($sqt['question_no'])]=$sqt['question_no'];
						foreach($sqt['answer'] as  $sqt_a){
							$sqt_a=explode("|",$sqt_a);
							$survey_question_text_arr["answer_".strtolower($sqt['question_no'])."_oth"]=$sqt_a[1];

							$matches='';
							preg_match("#<English>(.*?)</English>#", trim($sqt_a[1]), $matches);
							$sqt_a[1]=$matches[1];						
						}
						$survey_question_text_arr2["answer_".strtolower($sqt['question_no'])."_oth"]=$sqt_a[1];	
					}
				}else{
					$survey_question_text_arr["answer_".strtolower($sqt['question_no'])]=$sqt['question'];
					$survey_question_text_arr2["answer_".strtolower($sqt['question_no'])]=$sqt['question_no'];
				}
			}

//removing hindi tags from text of question
$survey_question_text_arr_new=array();
foreach($survey_question_text_arr as $sqta_k=>$qta_v){
	$matches='';
	preg_match("#<English>(.*?)</English>#", trim($qta_v), $matches);
	$qta_v=$matches[0];	
	$survey_question_text_arr_new[$sqta_k]=$qta_v;
}			
$survey_question_text_arr=$survey_question_text_arr_new;
//print_r($survey_question_text_arr);			
//print_r($survey_question_text_arr2);	
//print_r($question[0]);			
			echo "<input type='hidden' id='question_id' name='question_id' value='".$question[0]['id']."' /><form id='formCodeName'>";
			echo "<table width='100%'>";
				echo "<tr>";
				echo "<th align='center'><label>Variables</label></th>";
				echo "<th align='center'><label>Code Name</label></th>";
				echo "</tr>";
			$i=0;
			if(sizeof(json_decode($question[0]['elements']))>0){
				foreach(json_decode($question[0]['elements']) as $qe){
				$i++;
				if($i%2==0){
					echo "<tr class='cover'>";
				}else{
					echo "<tr>";
				}
				$qe_temp=$qe;
				if(strstr($qe_temp,'_dd_')){
					$qe_temp=str_replace('dd_','',$qe_temp);
				}
				if(strstr($qe_temp,'_mm_')){
					$qe_temp=str_replace('mm_','',$qe_temp);
				}
				if(strstr($qe_temp,'_yyyy_')){
					$qe_temp=str_replace('yyyy_','',$qe_temp);
				}
				if(strstr($qe_temp,'_h_')){
					$qe_temp=str_replace('h_','',$qe_temp);
				}
				if(strstr($qe_temp,'_m_')){
					$qe_temp=str_replace('m_','',$qe_temp);
				}
				if(strstr($qe_temp,'_oth')){
					$qe_temp=str_replace('_oth','',$qe_temp);
				}
				if(isset($survey_question_text_arr[$qe])){				
					echo "<td valign='top'><label><span>[".$qe."] ".$survey_question_text_arr[$qe].":</span></label></td>";
				}
				if(array_key_exists($qe,$question_codename_arr)){
					echo "<td align='center' valign='top'><label><input name='".$qe."' type='text' value='".$question_codename_arr[$qe]."' /></label></td>";
				}else{
					if(strstr($qe,'_dd_')){
						if(sizeof($survey_question_text_arr2)>0){
							echo "<td align='center' valign='top'><label><input name='".$qe."' type='text' value='".strtolower($survey_question_text_arr2[$qe_temp])."_dd' /></label></td>";
						}else{
							echo "<td align='center' valign='top'><label><input name='".$qe."' type='text' value='".strtolower($survey_question_text_arr[$qe_temp])."_dd' /></label></td>";
						}
					}else if(strstr($qe,'_mm_')){
						if(sizeof($survey_question_text_arr2)>0){
							echo "<td align='center' valign='top'><label><input name='".$qe."' type='text' value='".strtolower($survey_question_text_arr2[$qe_temp])."_mm' /></label></td>";
						}else{
							echo "<td align='center' valign='top'><label><input name='".$qe."' type='text' value='".strtolower($survey_question_text_arr[$qe_temp])."_mm' /></label></td>";
						}
					}else if(strstr($qe,'_yyyy_')){
						if(sizeof($survey_question_text_arr2)>0){
							echo "<td align='center' valign='top'><label><input name='".$qe."' type='text' value='".strtolower($survey_question_text_arr2[$qe_temp])."_yyyy' /></label></td>";
						}else{
							echo "<td align='center' valign='top'><label><input name='".$qe."' type='text' value='".strtolower($survey_question_text_arr[$qe_temp])."_yyyy' /></label></td>";
						}
					}else if(strstr($qe,'_h_')){
						if(sizeof($survey_question_text_arr2)>0){
							echo "<td align='center' valign='top'><label><input name='".$qe."' type='text' value='".strtolower($survey_question_text_arr2[$qe_temp])."_h' /></label></td>";
						}else{
							echo "<td align='center' valign='top'><label><input name='".$qe."' type='text' value='".strtolower($survey_question_text_arr[$qe_temp])."_h' /></label></td>";
						}
					}else if(strstr($qe,'_m_')){
						if(sizeof($survey_question_text_arr2)>0){
							echo "<td align='center' valign='top'><label><input name='".$qe."' type='text' value='".strtolower($survey_question_text_arr2[$qe_temp])."_m' /></label></td>";
						}else{
							echo "<td align='center' valign='top'><label><input name='".$qe."' type='text' value='".strtolower($survey_question_text_arr[$qe_temp])."_m' /></label></td>";
						}
					}else if(strstr($qe,'_oth')){
						if(sizeof($survey_question_text_arr2)>0){
							echo "<td align='center' valign='top'><label><input name='".$qe."' type='text' value='".strtolower($survey_question_text_arr2[$qe_temp])."_oth' /></label></td>";
						}else{
							echo "<td align='center' valign='top'><label><input name='".$qe."' type='text' value='".strtolower($survey_question_text_arr[$qe_temp])."_oth' /></label></td>";
						}
					}else{
						if(isset($survey_question_text_arr[$qe])){
							if(sizeof($survey_question_text_arr2)>0){
								echo "<td align='center' valign='top'><label><input name='".$qe."' type='text' value='".strtolower($survey_question_text_arr2[$qe_temp])."' /></label></td>";
							}else{
								echo "<td align='center' valign='top'><label><input name='".$qe."' type='text' value='".strtolower($survey_question_text_arr[$qe_temp])."' /></label></td>";
							}
						}
					}
				}
				echo "</tr>";
			}
			}
			echo "</table><input onClick='saveCodename(this)' type='button' value='Save' /></form>";
		}
	}
	public function question_lengths($id){
        if($this->session->userdata('user_logged_id')){
			$question=$this->Survey_model->get_survey_data_by_id($id);
			$question_lengths_arr=(array) json_decode($question[0]['lengths']);
			//print_r($question_lengths_arr);
			$survey_question_text_arr=array();
			$survey_question_text_arr2=array();
			$multiple_answer='';
			$sqt=(array) json_decode($question[0]['json_data']);
			//print_r($sqt);
			if(isset($sqt['multiple_answer'])){
				$multiple_answer=$sqt['multiple_answer'];
			}
			if(isset($sqt['rows']) && isset($sqt['columns'])){
				$sqt_rows=$sqt['rows'];
				$sqt_columns=$sqt['columns'];
				$new_sqt_columns=$sqt['columns'];
				//print_r($sqt_rows);print_r($sqt_columns);

				for($i=0;$i<count($sqt_rows);$i++){
					for($j=0;$j<count($sqt_columns);$j++){
						$sqt_combine='';
						
						$matches='';
						preg_match("#<English>(.*?)</English>#", trim($sqt_rows[$i]), $matches);
						$sqt_rows[$i]=$matches[0];
						$matches='';
						preg_match("#<English>(.*?)</English>#", trim($sqt_columns[$j]), $matches);
						$sqt_columns[$j]=$matches[0];

						$sqt_combine=$sqt_rows[$i]." - ".$sqt_columns[$j];
						$survey_question_text_arr["answer_".strtolower($sqt['question_no'])."_".$i.$j]=$sqt_combine;
						
						$sqt_combine2='';
						$new_sqt_columns[$j]=explode(' ',$new_sqt_columns[$j]);
						$new_sqt_columns[$j]=$new_sqt_columns[$j][0];
						$sqt_combine2=$new_sqt_columns[$j]."_".$sqt_rows[$i];
						$survey_question_text_arr2["answer_".strtolower($sqt['question_no'])."_".$i.$j]=$sqt_combine2;
						
						if(isset($sqt['dropdown_choices'])){
							foreach($sqt['dropdown_choices'] as $new_drop_choice){
								for($k=0;$k<sizeof($new_drop_choice);$k++){

									$temp_drop_choice=$new_drop_choice[$k];
									if($temp_drop_choice!=''){
										$temp_drop_choice=explode("|",$temp_drop_choice);
										if(sizeof($temp_drop_choice)>0){
											//echo $temp_drop_choice[0]." ".$temp_drop_choice[1];
											$survey_question_text_arr["answer_".strtolower($sqt['question_no'])."_".$i.$j."_".$temp_drop_choice[0]]=$temp_drop_choice[1];
											//$survey_question_text_arr["answer_".strtolower($sqt['question_no'])."_".$i.$j"_oth"]=$sqt_a[1];
										}

										$matches='';
										preg_match("#<English>(.*?)</English>#", trim($temp_drop_choice[1]), $matches);
										$temp_drop_choice[1]=$matches[1];
										$survey_question_text_arr2["answer_".strtolower($sqt['question_no'])."_".$i.$j."_".$temp_drop_choice[0]]=$sqt_combine2."_".$temp_drop_choice[0];
									}
								}
								
							}
						}						
					}
				}
			}else if(isset($sqt['rows'])){
				$sqt_rows=$sqt['rows'];
				//print_r($sqt_rows);

				for($i=0;$i<count($sqt_rows);$i++){
					$matches='';
					preg_match("#<English>(.*?)</English>#", trim($sqt_rows[$i]), $matches);
					$sqt_rows[$i]=$matches[0];
					
					$sqt_combine='';
					$sqt_combine=$sqt_rows[$i];
					$survey_question_text_arr["answer_".strtolower($sqt['question_no'])."_".$i]=$sqt_combine;

					$sqt_combine2='';
					$sqt_combine2=$sqt_rows[$i];
					$survey_question_text_arr2["answer_".strtolower($sqt['question_no'])."_".$i]=$sqt_combine2;
				}		
			}else{
				$matches='';
				preg_match("#<English>(.*?)</English>#", trim($sqt['question']), $matches);
				$sqt['question']=$matches[0];
				
				if(is_array($sqt) && isset($sqt['multiple_answer']) && $sqt['multiple_answer']=='1'){
					$survey_question_text_arr["answer_".strtolower($sqt['question_no'])]=$sqt['question'];
					$survey_question_text_arr2["answer_".strtolower($sqt['question_no'])]=$sqt['question'];
					foreach($sqt['answer'] as  $sqt_a){
						$sqt_a=explode("|",$sqt_a);
						$survey_question_text_arr["answer_".strtolower($sqt['question_no'])."_".$sqt_a[0]]=$sqt_a[1];
						$survey_question_text_arr2["answer_".strtolower($sqt['question_no'])."_".$sqt_a[0]]=$sqt_a[1];
					}
				}else{
					$survey_question_text_arr["answer_".strtolower($sqt['question_no'])]=$sqt['question'];
					$survey_question_text_arr2["answer_".strtolower($sqt['question_no'])]=$sqt['question_no'];
				}
			}
//print_r($survey_question_text_arr);			
//print_r($survey_question_text_arr2);			
			//die;
			echo "<input type='hidden' id='question_id' name='question_id' value='".$question[0]['id']."' /><form id='formLengths'>";
			echo "<table width='100%'>";
				echo "<tr>";
				echo "<th width='60%' align='center'><label>Variables</label></th>";
				echo "<th width='20%' align='center'><label>Format</label></th>";
				echo "<th width='20%' align='center'><label>Length</label></th>";
				echo "</tr>";
			$i=0;
			foreach(json_decode($question[0]['elements']) as $qe){
				$i++;
				if($i%2==0){
					echo "<tr class='cover'>";
				}else{
					echo "<tr>";
				}
				$qe_temp=$qe;
				if(strstr($qe_temp,"_dd_")){
				$qe_temp=str_replace('dd_','',$qe_temp);
				}
				if(strstr($qe_temp,"_mm_")){
					$qe_temp=str_replace('mm_','',$qe_temp);
				}
				if(strstr($qe_temp,"_yyyy_")){
					$qe_temp=str_replace('yyyy_','',$qe_temp);
				}
				if(strstr($qe_temp,"_h_")){
					$qe_temp=str_replace('h_','',$qe_temp);
				}
				if(strstr($qe_temp,"_m_")){
					$qe_temp=str_replace('m_','',$qe_temp);
				}
				if(strstr($qe_temp,"_oth")){
					$qe_temp=str_replace('_oth','',$qe_temp);
				}

				echo "<td valign='top'><label><span>[".$qe."] ".$survey_question_text_arr[$qe_temp]."</span></label></td>";
				if(array_key_exists("format_".$qe,$question_lengths_arr) || array_key_exists("length_".$qe,$question_lengths_arr)){
					if(array_key_exists("format_".$qe,$question_lengths_arr)){
						$ql=$question_lengths_arr["format_".$qe];
						$ql_a_checked='';
						$ql_f_checked='';
						if($ql=='A'){$ql_a_checked='checked';}
						else if($ql=='F'){$ql_f_checked='checked';}
						else{}
						echo "<td align='center' valign='top'>";
						echo "<label><input name='format_".$qe."' type='radio' $ql_a_checked value='A' />&nbsp;Alpha&nbsp;</label>";
						echo "<label><input name='format_".$qe."' type='radio' $ql_f_checked value='F' />&nbsp;Numeric&nbsp;</label>";
						echo "</td>";
					}
					if(array_key_exists("length_".$qe,$question_lengths_arr)){
						echo "<td align='center' valign='top'><label><input name='length_".$qe."' type='text' value='".$question_lengths_arr["length_".$qe]."' /></label></td>";
					}
				}else{
					echo "<td align='center' valign='top'>
					<label><input name='format_".$qe."' type='radio' value='A' />&nbsp;Alpha&nbsp;</label>
					<label><input name='format_".$qe."' type='radio' value='F' checked />&nbsp;Numeric&nbsp;</label>
					</td>";
					echo "<td align='center' valign='top'><label><input name='length_".$qe."' type='text' value='8' /></label></td>";
				}
				echo "</tr>";
			}
			echo "</table><input onClick='saveLengths(this)' type='button' value='Save' /></form>";
		}
	}
	public function question_generatecode(){
		$constants=get_defined_constants();
		$codeArrAvailable=unserialize($constants['codeArrAvailable']);
		$codeArr=unserialize($constants['codeArr']);

		$formData=$this->input->post('formData');
		$survey_data=$this->Survey_model->get_survey_data_by_id($formData[0]['value']);
		//print_r($formData);
		echo "<form name='form_data_code' id='form_data_code'>";
		echo "<input id='comm_question_id' type='hidden' name='comm_question_id' value='".$formData[0]['value']."' />";
		echo "<textarea id='comm_panel' name='comm_panel' wrap='off'>";
		//echo "<textarea id='comm_panel' name='comm_panel' wrap='off' readonly>";
		if($survey_data[0]['code']!=''){
			print_r($survey_data[0]['code']);
		}else{
			$default_question_no=json_decode($survey_data[0]['elements']);
			$default_question_no=$default_question_no[0];	
			echo "//".$default_question_no."//\r";
			echo "/*preproc*/\r";
			echo "/*preproc*/\r";
		}
		unset($formData[0]);
		$formDataArray=array();
			//print_r($codeArr);
			//print_r($fd);die;
		foreach($formData as $fd){
			if(array_key_exists($fd['value'],$codeArr)){
				$code=$codeArr[$fd['value']];
				$fd['name']=str_replace('[]','',$fd['name']);
				$code=str_replace('{id}',$fd['name'],$code);
				echo $code;
			}
		}
		echo "</textarea>";
		echo "<label id='comm_error' class='comm_error'></label>";
		echo "<input onClick='saveCode(this)' type='button' value='Save' /><img class='loader' src='".base_url()."theme/images/ajax-loader.gif' /></form>";
	}
	public function indicators($title_url){
		$data = array(
			'survey_id' => $title_url,
			'survey' => $this->Survey_model->get_survey_by_title_url($title_url)[0],
			'sections' => $this->Survey_model->get_survey_sections_by_title_url($title_url)
		);
		//print_r($data);
		$this->load->view('survey-indicators',$data);
	}
	public function indicators_save(){
        if($this->session->userdata('user_logged_id')){		
			$survey_id=$this->input->post('survey_id');
			
			/* recording events*/
			$data_sync = array(
				'tablename' => 'survey',
				'columnname' => 'indicator',
				'meta_primary_key' => $survey_id,
				'donetime' => time(),
				'work' => 'edit'
			);
			$this->Synclog_model->store_synclog($data_sync);
			/* recording events*/
			
			$indicators=json_encode($this->input->post());
			$indicators=str_replace('\r','',$indicators);
			$indicators=str_replace('\n','',$indicators);
			$data=array(
				'indicator'=> $indicators,
			);
			$survey=$this->Survey_model->get_survey_by_title_url($survey_id);
			$this->Survey_model->update_survey_by_title_url($survey_id,$data);
		}
	}
	public function question_savecodename($question_id){
        if($this->session->userdata('user_logged_id')){		
			$question_data=$this->Survey_model->get_survey_data_by_id($question_id);
			//print_r($question_data);
			/* recording events*/
			$data_sync = array(
				'tablename' => 'survey_data',
				'columnname' => 'code_name',
				'meta_primary_key' => $question_data[0]['data_id'],
				'donetime' => time(),
				'work' => 'edit'
			);
			$this->Synclog_model->store_synclog($data_sync);
			/* recording events*/
			
			$data=array(
				'code_name'=> json_encode($this->input->post()),
			);
			$this->Survey_model->update_survey_data_by_id($question_id,$data);
		}
	}
	public function question_savelengths($question_id){
        if($this->session->userdata('user_logged_id')){		

			$question_data=$this->Survey_model->get_survey_data_by_id($question_id);
			/* recording events*/
			$data_sync = array(
				'tablename' => 'survey_data',
				'columnname' => 'lengths',
				'meta_primary_key' => $question_data[0]['data_id'],
				'donetime' => time(),
				'work' => 'edit'
			);
			$this->Synclog_model->store_synclog($data_sync);
			/* recording events*/
			
			$data=array(
				'lengths'=> json_encode($this->input->post()),
			);
			$this->Survey_model->update_survey_data_by_id($question_id,$data);
		}
	}
	public function question_complete($question_id){
        if($this->session->userdata('user_logged_id')){		

			$question_data=$this->Survey_model->get_survey_data_by_id($question_id);
			/* recording events*/
			$data_sync = array(
				'tablename' => 'survey_data',
				'columnname' => 'complete',
				'meta_primary_key' => $question_data[0]['data_id'],
				'donetime' => time(),
				'work' => 'edit'
			);
			$this->Synclog_model->store_synclog($data_sync);
			/* recording events*/
			
			$data=array(
				'complete'=> "1"
			);
			$this->Survey_model->update_survey_data_by_id($question_id,$data);
		}
	}	
	public function analytics($title_url){
        if($this->session->userdata('user_logged_id')){		
			$data = array(
				'survey_id' => $title_url,
				'survey' => $this->Survey_model->get_survey_by_title_url($title_url)[0]
			);
			//print_r($data);
			$this->load->view('header');
			$this->load->view('survey-analytics',$data);
			$this->load->view('footer');
		}else{
			redirect('login');
		}
	}
	public function analytics_graph($title_url,$type,$key){
			$data = array(
				'survey_id' => $title_url,
				'survey' => $this->Survey_model->get_survey_by_title_url($title_url)[0],
				'sections' => $this->Survey_model->get_survey_sections_by_title_url($title_url),
				'type'=>$type,
				'key'=>$key
			);
			//print_r($data);
			$this->load->view('survey-analytics-graph',$data);
	}
	public function publish($title_url){
		$data = array(
			'survey_id' => $title_url,
			'survey' => $this->Survey_model->get_survey_by_title_url($title_url)[0],
			'sections' => $this->Survey_model->get_survey_sections_by_title_url($title_url)
		);
		//print_r($data);
		//$this->load->view('header');
		$this->load->view('survey-publish',$data);
		//$this->load->view('footer');
	}
	public function publish_save($title_url){
        if($this->session->userdata('user_logged_id')){		
			$data=array(
				'username' => $this->session->userdata('user_logged_username'),
				'survey_id' => $title_url,
				'json_data'=> json_encode($this->input->post()),
				'add_date' => time()
			);
			if($this->Survey_model->store_survey_values($data)){
				$data['flash_message'] = TRUE; 
			}else{
				$data['flash_message'] = FALSE; 
			}
			redirect('survey/publish/'.$title_url);
		}else{
			redirect('login');
		}
	}
	public function validate($title_url){
        if(!$this->session->userdata('user_logged_id')){
            redirect('login');
        }
		$section_data=$this->Survey_model->get_survey_section_by_title_url($title_url)[0];
		//print_r($section_data);	
		if($section_data['question_sort_id']!=''){
			$survey_data=array();
			$sort=explode(',',$section_data['question_sort_id']);
			foreach($sort as $s){
				$q_data=$this->Survey_model->get_survey_data_by_id($s);
				if(sizeof($q_data)>0){
					array_push($survey_data,$q_data[0]);
				}
			}
		}else{
			$survey_data=$this->Survey_model->get_survey_data_by_title_url($title_url);
		}
		$data = array(
			'survey_id' => $title_url,
			'section_data' => $section_data,
			'survey' => $this->Survey_model->get_survey_by_title_url($section_data['survey_id'])[0],
			'survey_data' => $survey_data
		);
		$this->load->view('header');
		$this->load->view('survey-validate',$data);
		$this->load->view('footer');
	}
	public function validate_save($title_url){
        if($this->session->userdata('user_logged_id')){		
			print_r($this->input->post());
		}else{
			redirect('login');
		}
	}
	public function question_ajxsave($title_url){
        if($this->session->userdata('user_logged_id')){		
			$json_data=$this->input->post();
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'jpg|jpeg|gif|png';
			$config['max_size']    = '99999';
			$config['encrypt_name'] = TRUE;
			$this->upload->initialize($config);
			$this->load->library('upload', $config);
			if($this->upload->do_upload('answer_file')==1){
				$image=$this->upload->file_name;
				$json_data['answer_file']=base_url()."uploads/".$image;	
			}
			$query=$this->Survey_model->list_questions();
			$count_questions=$query->num_rows();
			if($count_questions>0){
				$question_data=$query->result_array();
				$sort_id=($question_data[0]['id']+1);
			}else{
				$sort_id=1;
			}
			$data=array(
				'sort_id' => $sort_id,
				'survey_id' => $title_url,
				'qtype'=> $this->input->post('qtype'),
				'json_data'=> json_encode($json_data),
				'add_date' => time()
			);
			$id=$this->Survey_model->store_survey_data_ajx($data);
			
			$section_d=$this->Survey_model->get_survey_section_by_title_url($title_url);
			//print_r($section_d);
			$data_sec=array(
				'question_sort_id' => $section_d[0]['question_sort_id'].",".$id
			);
			if($section_d[0]['question_sort_id']!=''){
				$this->Survey_model->update_section_by_title_url($title_url,$data_sec);
			}
			
			$lastques=$this->Survey_model->get_survey_data_by_id($id);
			$lastques=$lastques[0];
			$data1=array(
				'sd' => $lastques,
				'survey_id' =>$title_url
			);
			//print_r($lastques);
			$this->load->view('survey-ajxsave',$data1);
		}else{
			redirect('login');
		}
	}
	public function question_delete($question_id,$title_url){
        if($this->session->userdata('user_logged_id')){

			$section=$this->Survey_model->get_survey_section_by_title_url($title_url);
			$question_sort_id=$section[0]['question_sort_id'];
			$new_question_sort_id=array();
			foreach(explode(',',$question_sort_id) as $qsi){
				if($qsi!=$question_id){
					array_push($new_question_sort_id,$qsi);
				}
			}
			$data1=array(
				'question_sort_id' => implode(',',$new_question_sort_id)
			);
			
			$question_data=$this->Survey_model->get_survey_data_by_id($question_id);
			/* recording events*/
			/*$data_sync = array(
				'tablename' => 'survey_section',
				'columnname' => 'question_sort_id',

				'meta_primary_key' => $title_url,
				'donetime' => time()
			);
			$this->Synclog_model->store_synclog($data_sync);*/
			$data_sync = array(
				'tablename' => 'survey_data',
				'columnname' => 'data_id',
				'meta_primary_key' => $question_data[0]['data_id'],
				'donetime' => time(),
				'work' => 'delete'
			);
			$this->Synclog_model->store_synclog($data_sync);
			//print_r($question_data);die;
			
			$this->Survey_model->update_section_by_title_url($title_url,$data1);
			$this->Survey_model->delete_survey_data_by_id($question_id);
        }
		//redirect($_SERVER[‘HTTP_REFERER’]);
	}
	public function ajxsort($operator,$val1,$val2){
        if($this->session->userdata('user_logged_id')){		
			//echo $operator." ";//echo $val1." ";//echo $val2." ";
			if($operator=="plus"){
				$q_data=$this->Survey_model->get_survey_data_by_ids($val1,$val2);
				$q_data=array_reverse($q_data);
				echo '<pre>';
				print_r($q_data);
				foreach($q_data as $qd){
					$data=array(
						'sort_id'=> ($qd['sort_id']+1)
					);
					$this->Survey_model->update_survey_data_by_sort_id($data,$qd['sort_id']);
				}
			}
			if($operator=="minus"){
				$q_data=$this->Survey_model->get_survey_data_by_ids($val1,$val2);
				echo '<pre>';
				print_r($q_data);
				foreach($q_data as $qd){
					$data=array(
						'sort_id'=> ($qd['sort_id']-1)
					);
					$this->Survey_model->update_survey_data_by_sort_id($data,$qd['sort_id']);
				}
			}
			if($operator=="equal"){
				$data=array(
					'sort_id'=> $val2
				);
				$this->Survey_model->update_survey_data_by_sort_id($data,$val1);
			}
		}else{
			redirect('login');
		}
	}
	public function ajxsort1($section_id,$section_value){
        if(!$this->session->userdata('user_logged_id')){
            redirect('login');
        }
		//$section_value=str_replace(",","','",$section_value);

		/* recording events*/
		$data_sync = array(
			'tablename' => 'survey_section',
			'columnname' => 'question_sort_id',
			'meta_primary_key' => $section_id,
			'donetime' => time(),
			'work' => 'edit'
		);
		$this->Synclog_model->store_synclog($data_sync);
		/* recording events*/
		
		$data=array(
			'question_sort_id'=> $section_value
		);
		$this->Survey_model->update_section_by_title_url($section_id,$data);
	}
	public function ajxsort2($survey_id,$section_sort_id){
        if($this->session->userdata('user_logged_id')){
			/* recording events*/
			$data_sync = array(
				'tablename' => 'survey',
				'columnname' => 'section_sort_id',
				'meta_primary_key' => $survey_id,
				'donetime' => time(),
				'work' => 'edit'
			);
			$this->Synclog_model->store_synclog($data_sync);
			/* recording events*/
			
			$data=array(
				'section_sort_id'=> $section_sort_id
			);
			$this->Survey_model->update_survey_by_title_url($survey_id,$data);
        }
	}
	public function data_code($question_id){
        if(!$this->session->userdata('user_logged_id')){
            redirect('login');
        }
		$question_id=str_replace('qpanelcode','',$question_id);
		$data_code=$this->Survey_model->get_survey_data_by_id($question_id);
		print_r(json_encode($data_code[0]));
	}
	public function survey_indicators($title_url){
        if($this->session->userdata('user_logged_id')){
			$survey_indicators=$this->Survey_model->get_survey_by_title_url($title_url);
			$survey_indicators=(array) json_decode($survey_indicators[0]['indicator']);
			$indi=array();
			foreach($survey_indicators as $k=>$v){
				if($v!='' && strstr($k,"indicator_")!=false){
					$indi[$k]=$v;
				}
			}
			//print_r($indi);
			foreach($indi as $i_k=>$i_v){
				$onclick="onClick=setIndicator('analytics-indicator','".$i_k."','".$i_v."');$('#analyticsMoreIndicatorsSurveyModal').modal('hide')";
				echo "<a class='indi' href=javascript:void(0) ".$onclick.">".$i_v."</a>";
			}
        }
	}
	public function question_codesave($question_id){
        if($this->session->userdata('user_logged_id')){

			$question_data=$this->Survey_model->get_survey_data_by_id($question_id);
			/* recording events*/
			$data_sync = array(
				'tablename' => 'survey_data',
				'columnname' => 'code',
				'meta_primary_key' => $question_data[0]['data_id'],
				'donetime' => time(),
				'work' => 'edit'
			);
			$this->Synclog_model->store_synclog($data_sync);
			/* recording events*/
			
			$data=array(
				'code'=> $this->input->post('comm_panel')
			);
			$this->Survey_model->update_survey_data_by_id($question_id,$data);
        }
	}
	public function uploaddata($title_url){
		$uploaddir = realpath('./') . '/';
		$uploadfile = $uploaddir . basename($_FILES['file_contents']['name']);
		if (move_uploaded_file($_FILES['file_contents']['tmp_name'], $uploadfile)) {
			echo "File is valid, and was successfully uploaded.\n";
		} else {
			echo "Possible file upload attack!\n";
		}
		echo '<pre>';
		echo 'Here is some more debugging info:';
		print_r($_FILES);
		echo "\n<hr />\n";
		print_r($_POST);
		echo "</pre>";		
		
		$data = array(
			'survey_id' => $title_url,
			'survey' => $this->Survey_model->get_survey_by_title_url($title_url)[0],
			'sections' => $this->Survey_model->get_survey_sections_by_title_url($title_url)
		);
		//$this->load->view('header');
		$this->load->view('survey-publish',$data);
		//$this->load->view('footer');
	}
	public function survey_export($survey_id,$type){
        if($this->session->userdata('user_logged_id')){
			$main_survey=$this->Survey_model->get_survey_by_title_url($survey_id);
			//print_r($main_survey);die;
			$survey_values=$this->Survey_model->get_survey_values_by_title_url($survey_id);
			//print_r($survey_values);die;
			
			$survey_columns=array();
			$survey_codenames=array();
			//$sfd=array();
			//$sfd['survey']=array();
			//$sfd['survey_section']=array();
			//$sfd['survey_data']=array();
			
			$this->db->where('title_url', $survey_id);
			$this->db->where('status', '1');
			$this->db->order_by('id','asc');
			$query2 = $this->db->get('survey');
			//echo "query: ".$this->db->last_query();die;
			//echo "query: ".$this->db->last_query()." num rows: ".$query2->num_rows();die;


			if($query2->num_rows()>0){
				$survey=$query2->result_array();
				//$sfd['survey']=$survey;
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
													array_push($survey_columns,$sd);
													array_push($survey_codenames,json_decode($sd['code_name']));
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
												array_push($survey_columns,$sd);
												array_push($survey_codenames,json_decode($sd['code_name']));
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
												array_push($survey_columns,$sd);
												array_push($survey_codenames,json_decode($sd['code_name']));
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
											array_push($survey_columns,$sd);
											array_push($survey_codenames,json_decode($sd['code_name']));
										}
									}										
								}
							}
						}
					}
				}
			}
			//print_r($survey_columns);die;
			//print_r($main_survey);
			//echo json_encode($sfd);			

			/*$survey_columns=$this->db->query("select * from survey_data where survey_id in (select title_url from survey_section where survey_id='".$survey_id."')");
			$survey_columns=$survey_columns->result_array();
			print_r($survey_columns);*/
			
			if($type=="Excel" || $type=="CSV" || $type=="TXT"){
				if($type==="Excel"){
					//$excel_name="Data_".$survey_id."_".date('d-m-Y')."_".$this->session->userdata('user_logged_username').".xls";
					$excel_name="Data_".$survey_id."_".date('d-m-Y')."_".$this->session->userdata('user_logged_username').".xlsx";
				}
				if($type==="CSV"){
					$excel_name="Data_".$survey_id."_".date('d-m-Y')."_".$this->session->userdata('user_logged_username').".csv";
				}
				if($type==="TXT"){
					$excel_name="Data_".$survey_id."_".date('d-m-Y')."_".$this->session->userdata('user_logged_username').".txt";
				}
				//echo $excel_name;die;
				$this->load->library('excel');

				if($type==="Excel"){
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //mime type
					header('Content-Disposition: attachment;filename="'.$excel_name.'"'); //tell browser what's the file name
					header('Cache-Control: max-age=0'); //no cache
				}else if($type==="CSV"){
					header('Content-Type: application/vnd.ms-excel'); //mime type
					header('Content-Disposition: attachment;filename="'.$excel_name.'"'); //tell browser what's the file name
					header('Cache-Control: max-age=0'); //no cache
				}else{
					header('Content-Type: application/text/plain'); //mime type
					header('Content-Disposition: attachment;filename="'.$excel_name.'"'); //tell browser what's the file name
					header('Cache-Control: max-age=0'); //no cache
				}

				$this->excel->setActiveSheetIndex(0);
				$this->excel->getActiveSheet()->setTitle($main_survey[0]['title']);

				$excel_row='0';
				$excel_col='0';$actual_excel_col='';

				/* writing column names in first row*/
				$excel_row++;
				$actual_excel_col=PHPExcel_Cell::stringFromColumnIndex($excel_col);
				$this->excel->getActiveSheet()->getColumnDimension($actual_excel_col)->setAutoSize(TRUE);
				$this->excel->getActiveSheet()->setCellValue($actual_excel_col.$excel_row, "id");

				$excel_col++;
				$actual_excel_col=PHPExcel_Cell::stringFromColumnIndex($excel_col);
				$this->excel->getActiveSheet()->getColumnDimension($actual_excel_col)->setAutoSize(TRUE);
				$this->excel->getActiveSheet()->setCellValue($actual_excel_col.$excel_row, "survey_case_id");

				$excel_columns_array=array();
				//print_r($survey_columns);die;
				foreach($survey_columns as $sv1){
					$json_data=(array) json_decode($sv1['elements']);
					//print_r($json_data);
					foreach($json_data as $val1){
						if(!in_array($val1,$excel_columns_array)){
							array_push($excel_columns_array,$val1);
						}
					}
				}
				//print_r($excel_columns_array);die;
				$excel_columns_array=array_unique($excel_columns_array);
				
				//changing codenames with excel columns if exists
				$new_survey_codenames=array();
				foreach($survey_codenames as $sc){
					$sc=(array) $sc;
					foreach($sc as $sc_k=>$sc_v){
						$new_survey_codenames[$sc_k]=$sc_v;
					}
				}
				//print_r($new_survey_codenames);die;
				
				foreach($excel_columns_array as $eca){
					if(array_key_exists($eca,$new_survey_codenames)){
						$eca=$new_survey_codenames[$eca];
					}
					$eca=str_replace('answer_','',$eca);	//remove answer_ from all column names
					$excel_col++;
					$actual_excel_col=PHPExcel_Cell::stringFromColumnIndex($excel_col);
					$this->excel->getActiveSheet()->getColumnDimension($actual_excel_col)->setAutoSize(TRUE);
					$this->excel->getActiveSheet()->setCellValue($actual_excel_col.$excel_row, strtoupper($eca));
				}

				$excel_col++;
				$actual_excel_col=PHPExcel_Cell::stringFromColumnIndex($excel_col);
				$this->excel->getActiveSheet()->getColumnDimension($actual_excel_col)->setAutoSize(TRUE);
				$this->excel->getActiveSheet()->setCellValue($actual_excel_col.$excel_row, "username");

				$excel_col++;
				$actual_excel_col=PHPExcel_Cell::stringFromColumnIndex($excel_col);
				$this->excel->getActiveSheet()->getColumnDimension($actual_excel_col)->setAutoSize(TRUE);
				$this->excel->getActiveSheet()->setCellValue($actual_excel_col.$excel_row, "add_date");
				
				/* writing column names in first row*/

				//print_r($survey_values);
				foreach($survey_values as $sv){
					$excel_row++;
					$excel_col=0;
					$json_data=(array) json_decode($sv['json_data']);
					//print_r($json_data);die;

					$actual_excel_col=PHPExcel_Cell::stringFromColumnIndex($excel_col);
					$this->excel->getActiveSheet()->setCellValue($actual_excel_col.$excel_row, $sv['id']);

					$excel_col++;
					$actual_excel_col=PHPExcel_Cell::stringFromColumnIndex($excel_col);
					$this->excel->getActiveSheet()->setCellValue($actual_excel_col.$excel_row, $sv['survey_case_id']);

					//print_r($excel_columns_array);
					foreach($excel_columns_array as $eca){
						$excel_col++;
						$actual_excel_col=PHPExcel_Cell::stringFromColumnIndex($excel_col);
						if(array_key_exists($eca,$json_data)){
							if(!is_array($json_data[$eca])){
								$this->excel->getActiveSheet()->setCellValue($actual_excel_col.$excel_row, $json_data[$eca]);
							}else{
								$this->excel->getActiveSheet()->setCellValue($actual_excel_col.$excel_row, implode(',',$json_data[$eca]));
							}
						}else{
							$this->excel->getActiveSheet()->setCellValue($actual_excel_col.$excel_row, "");
						}
					}

					$excel_col++;
					$actual_excel_col=PHPExcel_Cell::stringFromColumnIndex($excel_col);
					$this->excel->getActiveSheet()->setCellValue($actual_excel_col.$excel_row, $sv['username']);

					$excel_col++;
					$actual_excel_col=PHPExcel_Cell::stringFromColumnIndex($excel_col);
					$this->excel->getActiveSheet()->setCellValue($actual_excel_col.$excel_row, $sv['add_date']);
					
				}
				if($type==="Excel"){
					//$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
					$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');  
					ob_end_clean();					
				}
				if($type==="CSV"){
					$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'CSV');  
					ob_end_clean();					
					$objWriter->setEnclosure('');				//	Set enclosure to "
					$objWriter->setDelimiter(",");			    //	Set delimiter to a semi-colon
					$objWriter->setLineEnding("\r\n");
				}
				if($type==="TXT"){
					$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'CSV');  
					ob_end_clean();					
					$objWriter->setEnclosure('');				//	Set enclosure to "
					$objWriter->setDelimiter(",");			    //	Set delimiter to a semi-colon
					$objWriter->setLineEnding("\r\n");
				}
				$objWriter->save('php://output');
			}else if($type=="Sps"){
				$sps_file_name=$main_survey[0]['title'].".sps";
				$survey_elements_style=$this->db->query("select elements,style,lengths from survey_data where survey_id in (select title_url from survey_section where survey_id='".$survey_id."') ");
				$survey_elements_style=$survey_elements_style->result_array();
				$elements_style=array();
				$elements_style_type=array();
				foreach($survey_elements_style as $se){
					$ss=(array) json_decode($se['style']);
					$se=json_decode($se['elements']);
					if(is_array($se)){
						foreach($se as $s){
							if(!array_key_exists($s,$elements_style)){
								$es=str_replace('answer_','length_',$s);
								$est=str_replace('answer_','answertype_',$s);
								if(array_key_exists($es,$ss)){
									$s=str_replace('answer_','',$s);
									$s=strtoupper($s);
									$elements_style[$s]=$ss[$es];
								}
								if(array_key_exists($est,$ss)){
									$elements_style_type[$s]=$ss[$est];
								}
							}
						}
					}
				}
				$elements_lengths=array();
				foreach($survey_elements_style as $ses){
					$ses=(array) json_decode($ses['lengths']);
					$elements_lengths=array_merge($elements_lengths,$ses);
				}
				//print_r($elements_lengths);

				$elements=array();
				$survey_elements=array();
				$this->db->where('title_url', $survey_id);
				$this->db->where('status', '1');
				$this->db->order_by('id','asc');
				$query2 = $this->db->get('survey');

				if($query2->num_rows()>0){
					$survey=$query2->result_array();
					foreach($survey as $s){
						$section_sort_ids=$s['section_sort_id'];
						$section_sort_ids=explode(',',$section_sort_ids);
						if(is_array($section_sort_ids)){
							foreach($section_sort_ids as $sec_arr){
								$this->db->where('id',$sec_arr);
								$query3 = $this->db->get('survey_section');
								if($query3->num_rows()>0){
									$survey_section=$query3->result_array();
									foreach($survey_section as $ss){

										$question_sort_ids=$ss['question_sort_id'];
										$question_sort_ids=explode(',',$question_sort_ids);
										if(is_array($question_sort_ids)){
											foreach($question_sort_ids as $ques_arr){
												$this->db->where('id',$ques_arr);
												$query4 = $this->db->get('survey_data');
												if($query4->num_rows()>0){
													$survey_data=$query4->result_array();
													foreach($survey_data as $sd){
														$sde=json_decode($sd['elements']);
														if(is_array($sde)){
															foreach($sde as $sde_s){
																if(!in_array($sde_s,$elements)){
																	array_push($elements,$sde_s);
																}
															}
														}														
														array_push($survey_elements,array('elements'=>$sd['elements']));
													}
												}								
											}
										}else{
											$this->db->where('id',$question_sort_ids);
											$query4 = $this->db->get('survey_data');
											if($query4->num_rows()>0){
												$survey_data=$query4->result_array();
												foreach($survey_data as $sd){
													$sde=json_decode($sd['elements']);
													if(is_array($sde)){
														foreach($sde as $sde_s){
															if(!in_array($sde_s,$elements)){
																array_push($elements,$sde_s);
															}
														}
													}														
													array_push($survey_elements,array('elements'=>$sd['elements']));
												}
											}											
										}
									}
								}
							}
						}else{
							$this->db->where('id',$section_sort_ids);
							$query3 = $this->db->get('survey_section');
							if($query3->num_rows()>0){
								$survey_section=$query3->result_array();
								foreach($survey_section as $ss){

									$question_sort_ids=$ss['question_sort_id'];
									$question_sort_ids=explode(',',$question_sort_ids);
									if(is_array($question_sort_ids)){
										foreach($question_sort_ids as $ques_arr){
											$this->db->where('id',$ques_arr);
											$query4 = $this->db->get('survey_data');
											if($query4->num_rows()>0){
												$survey_data=$query4->result_array();
												foreach($survey_data as $sd){
													$sde=json_decode($sd['elements']);
													if(is_array($sde)){
														foreach($sde as $sde_s){
															if(!in_array($sde_s,$elements)){
																array_push($elements,$sde_s);
															}
														}
													}														
													array_push($survey_elements,array('elements'=>$sd['elements']));
												}
											}								
										}
									}else{
										$this->db->where('id',$question_sort_ids);
										$query4 = $this->db->get('survey_data');
										if($query4->num_rows()>0){
											$survey_data=$query4->result_array();
											foreach($survey_data as $sd){
												$sde=json_decode($sd['elements']);
												if(is_array($sde)){
													foreach($sde as $sde_s){
														if(!in_array($sde_s,$elements)){
															array_push($elements,$sde_s);
														}
													}
												}														
												array_push($survey_elements,array('elements'=>$sd['elements']));
											}
										}										
									}
								}
							}
						}
					}
				}	
				
				/*$survey_elements=$this->db->query("select elements from survey_data where survey_id in (select title_url from survey_section where survey_id='".$survey_id."') ");
				if($survey_elements->num_rows()>0){
					$survey_elements=$survey_elements->result_array();
					$elements=array();
					foreach($survey_elements as $se){
						$se=json_decode($se['elements']);
						if(is_array($se)){
							foreach($se as $s){
								if(!in_array($s,$elements)){
									array_push($elements,$s);
								}
							}
						}
					}
				}*/
				//print_r($elements);
				//print_r($survey_elements);
				
				$survey_code_name=$this->db->query("select code_name from survey_data where survey_id in (select title_url from survey_section where survey_id='".$survey_id."') ");
				$survey_code_name=$survey_code_name->result_array();
				$code_name=array();
				foreach($survey_code_name as $scn){
					$scn=(array) json_decode($scn['code_name']);
					//print_r($scn);
					foreach($scn as $k=>$v){
						$code_name[$k]=$v;
						//array_push($code_name,$s);
					}
				}
				//print_r($code_name);
				$survey_question_text=$this->db->query("select json_data from survey_data where survey_id in (select title_url from survey_section where survey_id='".$survey_id."') ");
				$survey_question_text=$survey_question_text->result_array();
				$survey_question_text_arr=array();
				foreach($survey_question_text as $sqt){
					$sqt=(array) json_decode($sqt['json_data']);
					//print_r($sqt);
					
					$matches='';
					preg_match("#<English>(.*?)</English>#", trim($sqt['question']), $matches);
					$sqt['question']=$matches[1];
					
					if(isset($sqt['rows']) && isset($sqt['columns'])){
						$sqt_combine='';
						$sqt_rows=$sqt['rows'];
						$sqt_columns=$sqt['columns'];
						//print_r($sqt_rows);print_r($sqt_columns);
						for($i=0;$i<count($sqt_rows);$i++){
							if(isset($sqt_rows[$i])){
								$matches='';
								preg_match("#<English>(.*?)</English>#", trim($sqt_rows[$i]), $matches);
								if(sizeof($matches)>0){
									$sqt_rows[$i]=$matches[1];							
								}
							}
							for($j=0;$j<count($sqt_columns);$j++){
								if(isset($sqt_columns[$j])){
									$matches='';
									preg_match("#<English>(.*?)</English>#", trim($sqt_columns[$j]), $matches);
									if(sizeof($matches)>0){
										$sqt_columns[$j]=$matches[1];							
									}
								}								
								if($sqt_rows[$i]!=""){
									$sqt_combine=$sqt_rows[$i]." - ".$sqt_columns[$j];
								}else{
									$sqt_combine=" ".$sqt_columns[$j];
								}
								$survey_question_text_arr[strtolower($sqt['question_no']."_".$i.$j)]=$sqt_combine;
							}
						}
						$temp_qno=strtolower($sqt['question_no']);
						$survey_question_text_arr[$temp_qno]=$sqt['question'];
					}else if(isset($sqt['multiple_answer']) && $sqt['multiple_answer']=="1"){
						$survey_question_text_arr[strtolower($sqt['question_no'])]=$sqt['question'];
						foreach($sqt['answer'] as  $sqt_a){
							$sqt_a=explode("|",$sqt_a);
							$survey_question_text_arr[strtolower($sqt['question_no'])."_".$sqt_a[0]]=strtoupper($sqt['question_no'])." ".$sqt['question'];
						}				
					}else{
						$temp_qno=strtolower($sqt['question_no']);
						$survey_question_text_arr[$temp_qno]=strtoupper($sqt['question_no'])." ".$sqt['question'];
					}
				}
				//print_r($survey_question_text_arr);die;
				
				$survey_question_value_text=$this->db->query("select json_data from survey_data where survey_id in (select title_url from survey_section where survey_id='".$survey_id."') ");
				$survey_question_value_text=$survey_question_value_text->result_array();
				$survey_question_value_text_arr=array();
				foreach($survey_question_value_text as $sqvt){
					$sqvt=(array) json_decode($sqvt['json_data']);
					//print_r($sqvt);
					if(array_key_exists("answer",$sqvt)){
						if(array_key_exists("multiple_answer",$sqvt)){
							//print_r($sqvt);	
							for($i=0;$i<count($sqvt['answer']);$i++){
								$sqvt_a=explode("|",$sqvt['answer'][$i]);								
								$q="answer_".strtolower($sqvt['question_no'])."_".$sqvt_a[0];
								if(array_key_exists($q,$code_name)){
									$q=strtoupper($code_name[$q]);
								}									
								$survey_question_value_text_arr[$q]=$sqvt['answer'];
							}
						}else{
							if(strpos($sqvt['answer'][0],"|")!=FALSE){
								$q="answer_".strtolower($sqvt['question_no']);
								if(array_key_exists($q,$code_name)){
									$q=strtoupper($code_name[$q]);
								}									
								$survey_question_value_text_arr[$q]=$sqvt['answer'];
							}
						}
					}else{
						if(array_key_exists("rows",$sqvt) && array_key_exists("columns",$sqvt)){
							$sqvt_combine='';
							$sqvt_rows=$sqvt['rows'];
							$sqvt_columns=$sqvt['columns'];							
							for($i=0;$i<count($sqvt_rows);$i++){
								for($j=0;$j<count($sqvt_columns);$j++){
									if(isset($sqvt['type'][$j])){
										if($sqvt['type'][$j]=="Select" || $sqvt['type'][$j]=="Checkbox" || $sqvt['type'][$j]=="Radio" ){
											for($k=0;$k<count($sqvt['dropdown_choices'][$j]);$k++){
												$q="answer_".strtolower($sqvt['question_no']."_".$i.$j);
												if(array_key_exists($q,$code_name)){
													$q=strtoupper($code_name[$q]);
												}												
												$survey_question_value_text_arr[$q]=$sqvt['dropdown_choices'][$j];
											}											
										}
									}
								}
							}
						}
					}
				}
				//print_r($survey_question_value_text_arr);
				//print_r($elements_lengths);
				//print_r($survey_question_text_arr);
				//print_r($code_name);
				//print_r($elements);
				
				header('Content-Disposition: attachment;filename="'.trim($sps_file_name).'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
				header("Content-Type: text/plain");
				

				echo "GET DATA  /TYPE = TXT"."\r\n";
				echo "/FILE = 'C:\Users\\Downloads\dfilename.txt'"."\r\n";
				echo "/DELCASE = LINE"."\r\n";
				echo '/DELIMITERS = ","'."\r\n";
				echo "/ARRANGEMENT = DELIMITED"."\r\n";
				echo "/FIRSTCASE = 2"."\r\n";
				echo "/IMPORTCASE = ALL"."\r\n";
				echo "/VARIABLES ="."\r\n";
				echo "ID F5"."\r\n";
				echo "USERNAME A30"."\r\n";
				foreach($elements as $e){
					$e_new=$e;
					//change autonames to givennames
					if(array_key_exists($e,$code_name) && $code_name[$e]!=''){
						$e=strtoupper($code_name[$e]);
					}else{											//for no answer_ in spss
						$e=str_replace('answer_','',$e);
						$e=strtoupper($e);
					}			
					
					if(array_key_exists("format_".$e_new,$elements_lengths) || array_key_exists("length_".$e_new,$elements_lengths)){
						echo trim($e)." ".$elements_lengths["format_".$e_new].$elements_lengths["length_".$e_new]."\r\n";
					}else{
						echo trim($e)."\r\n";
					}
				}
				echo "DATE A30"."\r\n";
				echo ".\r\n";
				echo "CACHE.\r\n";
				echo "EXECUTE.\r\n";
				echo "\r\n";
			
				
				//print_r($survey_question_value_text_arr);
				//print_r($elements_lengths);
				//print_r($survey_question_text_arr);
				//print_r($code_name);
				//print_r($elements);
				foreach($elements as $e){
					$sqtt='';
					$e_new2='';					
					if(array_key_exists($e,$code_name)){
						$e_new2=strtoupper($code_name[$e]);
					}else{
						$e_new2=strtoupper(str_replace('answer_','',$e));
					}		
					
					$e_1=str_replace('answer_','',$e);
					if(strstr($e,"_")){
						$count=substr_count($e_1, "_");
						if($count<1){
							if(array_key_exists($e_1,$survey_question_text_arr)){
								$sqtt=strip_tags($survey_question_text_arr[$e_1]);
							}							
						}else if($count<2){
							if(strstr($e_1,"_oth")){		
								$e_1=str_replace('_oth','',$e_1);
								if(array_key_exists($e_1,$survey_question_text_arr)){
									$sqtt=strip_tags($survey_question_text_arr[$e_1]);
								}								
								//echo $e_1."\r\n";
							}else if(strstr($e_1,"dd_")){
								$e_1=str_replace('dd_','',$e_1);
								if(array_key_exists($e_1,$survey_question_text_arr)){
									$sqtt=strip_tags($survey_question_text_arr[$e_1]);
								}
							}else if(strstr($e_1,"mm_")){
								$e_1=str_replace('mm_','',$e_1);
								if(array_key_exists($e_1,$survey_question_text_arr)){
									$sqtt=strip_tags($survey_question_text_arr[$e_1]);
								}
							}else if(strstr($e_1,"yyyy_")){
								$e_1=str_replace('yyyy_','',$e_1);
								if(array_key_exists($e_1,$survey_question_text_arr)){
									$sqtt=strip_tags($survey_question_text_arr[$e_1]);
								}
							}else if(strstr($e_1,"h_")){
								$e_1=str_replace('h_','',$e_1);
								if(array_key_exists($e_1,$survey_question_text_arr)){
									$sqtt=strip_tags($survey_question_text_arr[$e_1]);
								}
							}else if(strstr($e_1,"m_")){
								$e_1=str_replace('m_','',$e_1);
								if(array_key_exists($e_1,$survey_question_text_arr)){
									$sqtt=strip_tags($survey_question_text_arr[$e_1]);
								}
							}else{
								if(array_key_exists($e_1,$survey_question_text_arr)){
									$sqtt=strip_tags($survey_question_text_arr[$e_1]);
								}else{
									$e_1=substr($e_1,0,strpos($e_1,"_"));	//underscore with 1 digit
									if(array_key_exists($e_1,$survey_question_text_arr)){
										$sqtt=strip_tags($survey_question_text_arr[$e_1]);
									}									
								}								
							}
						}else if($count<3){
							if(strstr($e_1,"_oth")){		//2 underscore with oth
								$e_1=str_replace('_oth','',$e_1);
								if(array_key_exists($e_1,$survey_question_text_arr)){
									$sqtt=strip_tags($survey_question_text_arr[$e_1]);
								}								
							}else{
								$e_1=substr($e_1,0,strrpos($e_1,"_"));	//underscore with 1 digit
								if(array_key_exists($e_1,$survey_question_text_arr)){
									$sqtt=strip_tags($survey_question_text_arr[$e_1]);
								}
							}
						}else{}
					}
					echo 'VARIABLE LABEL '.trim($e_new2).' "'.trim($sqtt).'".'."\r\n";
				}
				
				echo "EXECUTE.\r\n";
				echo "\r\n";
				
				foreach($survey_question_value_text_arr as $sqvta_key=>$sqvta_value){
					if(strstr($sqvta_key,"answer_")){
						$sqvta_key=str_replace('answer_','',$sqvta_key);
						$sqvta_key=strtoupper($sqvta_key);							
					}
					echo "VAL LAB ".$sqvta_key."\r\n";
					$i=0;
					foreach($sqvta_value as $sv){
						$i++;
						$sv=explode('|',$sv);
						
						$matches='';
						preg_match("#<English>(.*?)</English>#", trim($sv[1]), $matches);
						$sv[1]=$matches[1];						
						$sv[1]=strip_tags($sv[1]);
						
						if($i!=sizeof($sqvta_value)){
							echo trim($sv[0])." ".'"'.trim($sv[1]).'"'."\r\n";
						}else{
							echo trim($sv[0])." ".'"'.trim($sv[1]).'".'."\r\n";
						}
					}
					echo "EXECUTE.\r\n";
					echo "\r\n";
				}
				
			}else{
				$indicators=array();
				$sidc=$this->Survey_model->survey_indicators_dataid_codenames($survey_id);
				$indicators=$sidc['indicators'];
				$new_survey_values=array();
				$json_file_name="Data_".$survey_id."_".date('d-m-Y')."_".$this->session->userdata('user_logged_username').".json";
				
				$database=$this->db->database;
				$tablename="analytics_".$survey_id;
				$table_count=0;
				$table_query=$this->db->query("SELECT count(*) as table_count FROM information_schema.TABLES WHERE (TABLE_SCHEMA = '".$database."') AND (TABLE_NAME = 'analytics_".$survey_id."')");
				if($table_query->num_rows()>0){
					$table_query=$table_query->result_array();
					$table_count=$table_query[0]['table_count'];
					
					$q=$this->db->query("select * from analytics_".$survey_id);
					if($q->num_rows()>0){
						$new_survey_values=$q->result_array();
					}
				}
				header('Content-Disposition: attachment;filename="'.$json_file_name.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
				header("Content-Type: text/plain");				
				echo json_encode(array("data"=>$new_survey_values,"dataLabels"=>$indicators));
			}
        }
	}	
	public function survey_dataupload(){
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = '*';
		//$config['encrypt_name'] = TRUE;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if(!$this->upload->do_upload('survey_values')){
			print_r($this->upload->display_errors());
		}
		$data_upload_files = $this->upload->data();
		$survey_values=$data_upload_files['file_name'];
		
		$survey_id=$this->input->post('survey_id');
		if(strstr($survey_values,$survey_id)===false){
			redirect("survey/create");
		}else{
			$data = array(
				'survey_id' => $survey_id,
				'data_file' => base_url()."uploads/".$survey_values,
				'add_date' => time()
			);
			$this->Survey_model->store_survey_import_datafile($data);
			redirect("survey/create");
		}
	}
	public function survey_data_files(){
		$data_files=$this->Survey_model->get_survey_data_files_by_title_url($this->input->post('survey_id'));
		foreach($data_files as $df){
			$df['data_file']=basename($df['data_file']);
			echo '<div><a href="javascript:void(0);" class="link-import" data-file-id="'.$df['data_file'].'">'.$df['data_file'].'</a></div>';
		}
	}
	public function survey_data_file_import($file_name){
		$file_data = file_get_contents(base_url()."uploads/".$file_name);
		$file_data=json_decode($file_data);
		foreach($file_data as $fd){
			$data = array(
				'username' => $fd->username,
				'survey_id' => $fd->survey_id,
				'json_data' => json_encode($fd->json_data),
				'add_date' => $fd->add_date
			);
			$new=$this->Survey_model->store_survey_values($data);
		}
		if($new){
			$data1 = array(
				'status' => '0'
			);
			$this->Survey_model->update_data_file_import($data1,$file_name);
			echo '1';
		}else{
			echo '0';
		}
	}
/*	public function survey_style($question_id){
		$question_id=str_replace('qpanelstyle','',$question_id);
			$data = array(
				'question_id' => $question_id,
				'question_data' =>$this->Survey_model->get_survey_data_by_id($question_id)
			);
		$this->load->view('survey-style',$data);
	}
*/	
	public function survey_style($survey_id){
		$data = array(
			'survey' =>$this->Survey_model->get_survey_by_title_url($survey_id)
		);
		$this->load->view('survey-style',$data);
	}
/*	public function survey_style_save($question_id){
		$style=$this->input->post();
		$data = array(
			'style' => json_encode($style)
		);
		$this->Survey_model->update_survey_data_by_id($data,$question_id);
		redirect($_SERVER['HTTP_REFERER']);
	}
*/
	public function survey_elements($question_id){
		$elements=$this->input->post('elements');
		$elements=implode(',',$elements);
		if($elements!=''){
			
			$question_data=$this->Survey_model->get_survey_data_by_id($question_id);
			/* recording events*/
			$data_sync = array(
				'tablename' => 'survey_data',
				'columnname' => 'elements',
				'meta_primary_key' => $question_data[0]['data_id'],
				'donetime' => time(),
				'work' => 'edit'
			);
			$this->Synclog_model->store_synclog($data_sync);
			/* recording events*/
			
			$elements=explode(',',$elements);
			$elements=array_unique($elements);
			$elements=implode(',',$elements);
			$elements=explode(',',$elements);
			$data = array(
				'elements' => json_encode($elements)
			);
			$this->Survey_model->update_survey_data_by_id($question_id,$data);
			//echo $this->db->last_query();
		}
	}
	public function survey_question_style($question_id){
			$data = array(
				'question' =>$this->Survey_model->get_survey_data_by_id($question_id)
			);
		$this->load->view('survey-question-style',$data);
	}
	public function survey_question_style_save($question_id){
		$all_setting=$this->input->post();
		$survey_title_url='';
		if(isset($all_setting['apply_all']) && $all_setting['apply_all']=='1'){
			$apply_all=$all_setting['apply_all'];
			unset($all_setting['apply_all']);
			$style=$all_setting;

			$q=$this->db->query("select title_url from survey where title_url in ( select survey_id from survey_section where title_url in (select survey_id from survey_data where id='".$question_id."' ) ) ");
			if($q->num_rows()>0){
				$q=$q->result_array();
				$survey_title_url=$q[0]['title_url'];
			}
			$qq=$this->db->query("select * from survey_data where survey_id in (select title_url from survey_section where survey_id='".$survey_title_url."' )");
			if($qq->num_rows()>0){
				$qq=$qq->result_array();
				foreach($qq as $qqinner){
					
					/* recording events*/
					$data_sync = array(
						'tablename' => 'survey_data',
						'columnname' => 'style',
						'meta_primary_key' => $qqinner['data_id'],
						'donetime' => time(),
						'work' => 'edit'
					);
					$this->Synclog_model->store_synclog($data_sync);
					/* recording events*/	
					
					$data = array(
						'style' => json_encode($style)
					);
					$this->Survey_model->update_survey_data_by_id($qqinner['id'],$data);	
					//echo $this->db->last_query()."\r\n";
				}
			}
		}else{
			$style=$all_setting;	
			
			$question_data=$this->Survey_model->get_survey_data_by_id($question_id);
			/* recording events*/
			$data_sync = array(
				'tablename' => 'survey_data',
				'columnname' => 'style',
				'meta_primary_key' => $question_data[0]['data_id'],
				'donetime' => time(),
				'work' => 'edit'
			);

			$this->Synclog_model->store_synclog($data_sync);
			/* recording events*/			
			
			$data = array(
				'style' => json_encode($style)
			);			
			$this->Survey_model->update_survey_data_by_id($question_id,$data);	
			//echo $this->db->last_query()."\r\n";			
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function survey_section_style($section_id){
			$data = array(
				'section' =>$this->Survey_model->get_survey_section_by_title_url($section_id)
			);
		$this->load->view('survey-section-style',$data);
	}
	public function survey_section_style_save($section_id){
		/* recording events*/
		$data_sync = array(
			'tablename' => 'survey_section',
			'columnname' => 'style',
			'meta_primary_key' => $section_id,
			'donetime' => time(),
			'work' => 'edit'
		);
		$this->Synclog_model->store_synclog($data_sync);
		/* recording events*/
		
		$style=$this->input->post();
		$data = array(
			'style' => json_encode($style)
		);
		$this->Survey_model->update_section_by_title_url($section_id,$data);
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function survey_survey_style($survey_id){
			$data = array(
				'survey_id' => $survey_id,
				'survey_data' =>$this->Survey_model->get_survey_by_id($survey_id)
			);
		$this->load->view('survey-survey-style',$data);
	}
	public function survey_style_save($title_url){
		/* recording events*/
		$data_sync = array(
			'tablename' => 'survey',
			'columnname' => 'style',
			'meta_primary_key' => $title_url,
			'donetime' => time(),
			'work' => 'edit'
		);
		$this->Synclog_model->store_synclog($data_sync);
		/* recording events*/

		$style=$this->input->post();
		$data = array(
			'style' => json_encode($style)
		);
		$this->Survey_model->update_survey_by_title_url($title_url,$data);
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function partial_save($survey_case_id){
        if($this->session->userdata('user_logged_id')){	
			$post=$this->input->post('formData');
			$survey_id=$post[0]['value'];
			$section_id=$post[1]['value'];
			unset($post[0]);
	 		unset($post[1]);

			$new_post=array();
			foreach($post as $p){
				$new_post[$p['name']]=$p['value'];
			}
			$data=array(
				'username' => $this->session->userdata('user_logged_username'),
				'survey_case_id' => $survey_case_id,
				'survey_id' => $survey_id,
				'section_id' => $section_id,
				'json_data'=> json_encode($new_post),
				'add_date' => time()
			);
			if(sizeof($new_post)>0){
				$current_partial=$this->Survey_model->get_partial_by_ids($survey_case_id,$survey_id,$section_id);
				if(sizeof($current_partial)>0){
					$this->Survey_model->delete_partial_by_ids($survey_case_id,$survey_id,$section_id);
					$this->Survey_model->store_survey_partial_values($data);
				}else{
					$this->Survey_model->store_survey_partial_values($data);
				}
			}
		}
		$this->logFill();
	}
	public function partial_load($survey_case_id){
		$q=$this->db->query("select * from survey_partial_values where survey_case_id='".$survey_case_id."' order by id asc ");
		$all_values=array();
		$till_section=$q->num_rows();
		if($q->num_rows()>0){
			$q=$q->result_array();
			foreach($q as $qq){
				$temp_all_values=json_decode($qq['json_data']);
				foreach($temp_all_values as $temp_all_values_k=>$temp_all_values_v){
					$all_values[$temp_all_values_k]=$temp_all_values_v;
				}
			}
		}	
		$all_values_with_section=array();
		if(sizeof($all_values)>0){
			$all_values_with_section['all_values']=$all_values;
			$all_values_with_section['till_section']=$till_section;
			echo json_encode($all_values_with_section);
		}else{
			$all_values_with_section['all_values']=array();
			$all_values_with_section['till_section']=0;			
			echo json_encode($all_values_with_section);
		}
		$this->logFill();
	}
	public function final_save($survey_case_id){
		$this->logFill();
        if($this->session->userdata('user_logged_id')){		
			$this->db->select('*');
			$this->db->from('survey_values');
			$this->db->where('survey_case_id', $survey_case_id);
			$query = $this->db->get();
			//echo $this->db->last_query();
			$extra_id='';
			if($query->num_rows()>0){
				$extra_id="_".$this->randomString(5,'');
			}
			
			$post=$this->input->post('formData');
			$survey_id=$post[0]['value'];
			$full_partial=$this->Survey_model->get_partial_by_id($survey_case_id,$survey_id);
			$new_values=array();
			foreach($full_partial as $fp){

				$json_data=(array) json_decode($fp['json_data']);
				$new_values=array_merge($new_values,$json_data);
			}
			//removing title_urls keys from complete cases
			if(array_key_exists("survey_title_url",$new_values)){
				unset($new_values['survey_title_url']);
			}
			if(array_key_exists("section_title_url",$new_values)){
				unset($new_values['section_title_url']);
			}
			
			if(sizeof($new_values)>0){
				/* recording events*/
				$data_sync = array(
					'tablename' => 'survey_values',
					'columnname' => 'survey_case_id',
					'meta_primary_key' => $survey_case_id,
					'donetime' => time(),
					'work' => 'add'
				);
				$this->Synclog_model->store_synclog($data_sync);
				$data_sync = array(
					'tablename' => 'survey_values',
					'columnname' => 'username',
					'meta_primary_key' => $survey_case_id,
					'donetime' => time(),
					'work' => 'add'
				);
				$this->Synclog_model->store_synclog($data_sync);
				$data_sync = array(
					'tablename' => 'survey_values',
					'columnname' => 'survey_id',
					'meta_primary_key' => $survey_case_id,
					'donetime' => time(),
					'work' => 'add'
				);
				$this->Synclog_model->store_synclog($data_sync);			
				$data_sync = array(
					'tablename' => 'survey_values',
					'columnname' => 'json_data',
					'meta_primary_key' => $survey_case_id,
					'donetime' => time()
				);
				$this->Synclog_model->store_synclog($data_sync);
				/* recording events*/

				$data=array(
					'survey_case_id' => $survey_case_id.$extra_id,
					'username' => $this->session->userdata('user_logged_username'),
					'survey_id' => $survey_id,
					'json_data'=> json_encode($new_values),
					'add_date' => time()
				);
				$this->Survey_model->store_survey_values($data);
				$this->Survey_model->delete_partial_by_id($survey_case_id,$survey_id);
				return 0;
			}else{
				return 1;
			}
			
		}
		
	}
	public function question_search(){
		$question_arr=array();
		$questions=$this->Survey_model->list_questions_all($this->input->get('query'));
		$questions=$questions->result_array();
		$exist_question=array();
		foreach($questions as $qs){
			$id=$qs['id'];
			$qs['json_data']=utf8_encode($qs['json_data']);
			$qs['json_data'] = preg_replace("/[\n\r\t]/","",$qs['json_data']); 
			/*if($id==613){
				print_r($qs['json_data']);
				print_r(json_decode($qs['json_data']));
				die;
			}*/
			
			$q_text=json_decode($qs['json_data']);
			if (is_object($q_text)) {
				$q_text=$q_text->question;
				
				$matches='';
				preg_match("#<English>(.*?)</English>#", $q_text, $matches);
				if(sizeof($matches)>0){
					$q_text=$matches[1];
				}

				$results = preg_match_all('~<([^/][^>]*?)>~',json_decode($qs['json_data'])->question,$qs_arr);
			}
			
			//print_r($qs_arr);
			$tag_size=sizeof($qs_arr[0]);
			$tag_string=implode(",",$qs_arr[1]);
			$tag_string="{".$tag_string."}";
			//echo $tag_string;
			
			if(!in_array($q_text,$exist_question)){
				array_push($exist_question,$q_text);
				array_push($question_arr,array('value'=>$q_text." ".$tag_string,'data'=>$id));
			}
		}
		$question_arr=json_encode($question_arr);
		print_r($question_arr);
	}
	public function question_copy($title_url,$question_id){
		$question=$this->Survey_model->get_survey_data_by_id($question_id);
		//print_r($question);
		$data=array(
			'data_id' => $this->randomString(20,''),
			'survey_id' => $title_url,
			'qtype'=> $question[0]['qtype'],
			'json_data'=> $question[0]['json_data'],
			'code'=> $question[0]['code'],
			'elements'=> $question[0]['elements'],
			'lengths'=> $question[0]['lengths'],
			'code_name'=> $question[0]['code_name'],
			'style'=> $question[0]['style'],
			'add_date' => time()
		);
		$insert_id=$this->Survey_model->store_survey_data($data);

		/* recording events*/
		$data_sync = array(
			'tablename' => 'survey_data',
			'columnname' => 'data_id',
			'meta_primary_key' => $data['data_id'],
			'donetime' => time(),
			'work' => 'add'
		);
		$this->Synclog_model->store_synclog($data_sync);
		$data_sync = array(
			'tablename' => 'survey_data',
			'columnname' => 'survey_id',
			'meta_primary_key' => $data['data_id'],
			'donetime' => time(),
			'work' => 'add'
		);
		$this->Synclog_model->store_synclog($data_sync);
		$data_sync = array(
			'tablename' => 'survey_data',
			'columnname' => 'json_data',
			'meta_primary_key' => $data['data_id'],
			'donetime' => time(),
			'work' => 'add'
		);
		$this->Synclog_model->store_synclog($data_sync);
		$data_sync = array(
			'tablename' => 'survey_data',
			'columnname' => 'qtype',
			'meta_primary_key' => $data['data_id'],
			'donetime' => time(),
			'work' => 'add'
		);
		$this->Synclog_model->store_synclog($data_sync);
		$data_sync = array(
			'tablename' => 'survey_data',
			'columnname' => 'code',
			'meta_primary_key' => $data['data_id'],
			'donetime' => time()
		);
		$this->Synclog_model->store_synclog($data_sync);
		$data_sync = array(
			'tablename' => 'survey_data',
			'columnname' => 'elements',
			'meta_primary_key' => $data['data_id'],
			'donetime' => time(),
			'work' => 'add'
		);
		$this->Synclog_model->store_synclog($data_sync);
		$data_sync = array(
			'tablename' => 'survey_data',
			'columnname' => 'lengths',
			'meta_primary_key' => $data['data_id'],
			'donetime' => time(),
			'work' => 'add'
		);
		$this->Synclog_model->store_synclog($data_sync);
		$data_sync = array(
			'tablename' => 'survey_data',
			'columnname' => 'code_name',
			'meta_primary_key' => $data['data_id'],
			'donetime' => time(),
			'work' => 'add'
		);
		$this->Synclog_model->store_synclog($data_sync);
		$data_sync = array(
			'tablename' => 'survey_data',
			'columnname' => 'style',
			'meta_primary_key' => $data['data_id'],
			'donetime' => time(),
			'work' => 'add'
		);
		$this->Synclog_model->store_synclog($data_sync);
		/* recording events*/
		
		$section=$this->Survey_model->get_survey_section_by_title_url($title_url);
		$question_sort_id=$section[0]['question_sort_id'];
		$new_question_sort_id=array();
		if($question_sort_id!=''){
			foreach(explode(',',$question_sort_id) as $qsi){
				array_push($new_question_sort_id,$qsi);
			}
			array_push($new_question_sort_id,$insert_id);
		}else{
			$questions=$this->Survey_model->get_survey_data_by_title_url($title_url);
			foreach($questions as $q){
				array_push($new_question_sort_id,$q['id']);
			}
		}
		$data1=array(
			'question_sort_id' => implode(',',$new_question_sort_id)
		);
		$this->Survey_model->update_section_by_title_url($title_url,$data1);
		
	}
	public function survey_search($u=''){
		
		$this->db->where('username',$u);
		$query1 = $this->db->get('users');
		if($query1->num_rows()>0){
			$user=$query1->result_array();
			
			$this->db->select('title,title_url');
			$this->db->like('title', $this->input->get('query'));
			$this->db->where('user_id',$user[0]['id']);
			$query = $this->db->get('survey');
			//echo $this->db->last_query();
			$survey_arr=array();
			if($query->num_rows()>0){
				$query=$query->result_array();
				foreach($query as $q){
					array_push($survey_arr,array('value'=>$q['title'],'data'=>$q['title_url']));
				}
			}
			print_r(json_encode($survey_arr));			
		}
		

		
		/*$survey_arr=array();
		$surveys=$this->Survey_model->list_surveys_all();
		//$users=$users->result_array();
		//print_r($surveys);die;
		foreach($surveys as $ss){
			$title=$ss['title'];
			$title_url=$ss['title_url'];
			$title=preg_replace("/[^a-zA-Z0-9 ]/", "",$title);
			//$question_arr[$id]=$q_text;
			array_push($survey_arr,array('value'=>$title,'data'=>$title_url));
		}
		//$question_arr=array_flip($question_arr);
		$survey_arr=json_encode($survey_arr);
		print_r($survey_arr);*/
	}
	public function permission_save(){
		$username=$this->input->post('username');
		$survey_id=$this->input->post('survey_id');
		$design_permission=$this->input->post('design_permission');
		$fill_permission=$this->input->post('fill_permission');
		$analytics_permission=$this->input->post('analytics_permission');
		$survey_data=$this->Survey_model->get_survey_by_title_url($survey_id);
		$temp_new_design_permission=array();
		$temp_new_fill_permission=array();
		$temp_new_analytics_permission=array();
		
		/* recording events*/
		if($this->input->post('design_permission')){
			$data_sync = array(
				'tablename' => 'survey',
				'columnname' => 'permission_design',
				'meta_primary_key' => $survey_id,
				'donetime' => time(),

				'work' => 'edit'
			);
			$this->Synclog_model->store_synclog($data_sync);
		}
		if($this->input->post('fill_permission')){
			$data_sync = array(
				'tablename' => 'survey',
				'columnname' => 'permission_fill',
				'meta_primary_key' => $survey_id,
				'donetime' => time(),
				'work' => 'edit'
			);
			$this->Synclog_model->store_synclog($data_sync);
		}
		if($this->input->post('analytics_permission')){
			$data_sync = array(
				'tablename' => 'survey',
				'columnname' => 'permission_analytics',
				'meta_primary_key' => $survey_id,
				'donetime' => time(),
				'work' => 'edit'
			);
			$this->Synclog_model->store_synclog($data_sync);
		}		
		/* recording events*/
		
		if($design_permission=='1'){
			$temp_design_permission=(array) json_decode($survey_data[0]['permission_design']);
			if(sizeof($temp_design_permission)>0){
				foreach($temp_design_permission as $tdp){
					if($tdp!=$username){
						array_push($temp_new_design_permission,$tdp);
					}
				}
				array_push($temp_new_design_permission,$username);
			}else{
				array_push($temp_new_design_permission,$username);
			}
		}else{
			$temp_design_permission=(array) json_decode($survey_data[0]['permission_design']);
			if(sizeof($temp_design_permission)>0){
				foreach($temp_design_permission as $tdp){
					if($tdp!=$username){
						array_push($temp_new_design_permission,$tdp);
					}
				}
			}			
		}
		if($fill_permission=='1'){
			$temp_fill_permission=(array) json_decode($survey_data[0]['permission_fill']);
			if(sizeof($temp_fill_permission)>0){
				foreach($temp_fill_permission as $tfp){
					if($tfp!=$username){
						array_push($temp_new_fill_permission,$tfp);
					}
				}
				array_push($temp_new_fill_permission,$username);
			}else{
				array_push($temp_new_fill_permission,$username);
			}
		}else{
			$temp_fill_permission=(array) json_decode($survey_data[0]['permission_fill']);
			if(sizeof($temp_fill_permission)>0){
				foreach($temp_fill_permission as $tfp){
					if($tfp!=$username){
						array_push($temp_new_fill_permission,$tfp);
					}
				}
			}
		}
		if($analytics_permission=='1'){
			$temp_analytics_permission=(array) json_decode($survey_data[0]['permission_analytics']);
			if(sizeof($temp_analytics_permission)>0){
				foreach($temp_analytics_permission as $tfp){
					if($tfp!=$username){
						array_push($temp_new_analytics_permission,$tfp);
					}
				}
				array_push($temp_new_analytics_permission,$username);
			}else{
				array_push($temp_new_analytics_permission,$username);
			}
		}else{
			$temp_analytics_permission=(array) json_decode($survey_data[0]['permission_analytics']);
			if(sizeof($temp_analytics_permission)>0){
				foreach($temp_analytics_permission as $tfp){
					if($tfp!=$username){
						array_push($temp_new_analytics_permission,$tfp);
					}
				}
			}
		}
		$data=array(
			'permission_design' => json_encode($temp_new_design_permission),
			'permission_fill' => json_encode($temp_new_fill_permission),
			'permission_analytics' => json_encode($temp_new_analytics_permission)
			
		);
		//print_r($data);
		//die;
		$this->Survey_model->update_survey_by_title_url($survey_data[0]['title_url'],$data);
	}
	public function permission_update($survey_id,$column,$username){
		//echo $survey_id;
		//echo $column;
		//echo $username;
		$survey_data=$this->Survey_model->get_survey_by_title_url($survey_id);
		//print_r($survey_data[0]);
		$temp_new_permission=array();
		if($column=="permission_design"){
			/* recording events*/
			$data_sync = array(
				'tablename' => 'survey',
				'columnname' => 'permission_design',
				'meta_primary_key' => $survey_id,
				'donetime' => time(),
				'work' => 'edit'
			);
			$this->Synclog_model->store_synclog($data_sync);
			/* recording events*/			
			
			$temp_permission=(array) json_decode($survey_data[0]['permission_design']);
			if(sizeof($temp_permission)>0){
				foreach($temp_permission as $tp){
					if($tp!=$username){
						array_push($temp_new_permission,$tp);
					}
				}
			}
			$data=array(
				'permission_design' => json_encode($temp_new_permission)
			);
		}
		if($column=="permission_fill"){
			$data_sync = array(
				'tablename' => 'survey',
				'columnname' => 'permission_fill',
				'meta_primary_key' => $survey_id,
				'donetime' => time()
			);
			$this->Synclog_model->store_synclog($data_sync);
			
			$temp_permission=(array) json_decode($survey_data[0]['permission_fill']);
			if(sizeof($temp_permission)>0){
				foreach($temp_permission as $tp){
					if($tp!=$username){
						array_push($temp_new_permission,$tp);
					}
				}
			}
			$data=array(
				'permission_fill' => json_encode($temp_new_permission)
			);
		}
		if($column=="permission_analytics"){
			$data_sync = array(
				'tablename' => 'survey',
				'columnname' => 'permission_analytics',
				'meta_primary_key' => $survey_id,
				'donetime' => time()
			);
			$this->Synclog_model->store_synclog($data_sync);
			
			$temp_permission=(array) json_decode($survey_data[0]['permission_analytics']);
			if(sizeof($temp_permission)>0){
				foreach($temp_permission as $tp){
					if($tp!=$username){
						array_push($temp_new_permission,$tp);
					}
				}
			}
			$data=array(
				'permission_analytics' => json_encode($temp_new_permission)
			);
		}		
		//print_r($data);
		$this->Survey_model->update_survey_by_title_url($survey_data[0]['title_url'],$data);
	}
	public function cases($survey_title_url){
		//echo $survey_title_url;
		//echo $this->randomString(20,'');
		$cases=$this->Survey_model->get_case_ids_by_survey_title_url($survey_title_url);
		//print_r($cases);
		echo '<input type="button" value="New Survey" onclick="javascript:setSurveyCase2(\''.$this->randomString(20,'').'\',\'New\')">';
		echo '<br><br><table width="100%" border="1">';
		echo '<tr>';
		echo '<td style="font-weight:600" align="center">Sno.</td>';
		echo '<td style="font-weight:600" align="center">Username</td>';
		echo '<td style="font-weight:600" align="center">Time</td>';
		echo '<td style="font-weight:600" align="center">First Answer</td>';
		echo '</tr>';
		$i=0;
		foreach($cases as $c){$i++;
			if($c['username']==$this->session->userdata('user_logged_username')){
				$c['json_data']=(array) json_decode($c['json_data']);
				//print_r($c['json_data']);
				echo '<tr>';
				echo '<td align="center">'.$i.'</td>';
				echo '<td align="center">'.$c['username'].'</td>';
				echo '<td align="center"><a href="javascript:setSurveyCase2(\''.$c['survey_case_id'].'\',\'Old\')">'.date('M d Y h:i:s',$c['ad']).'</a></td>';
				echo '<td align="center">'.reset($c['json_data']).'</td>';
				echo '</tr>';
			}
		}
		echo '</table><br>';
		echo '<table width="100%" border="1">';
		echo '<tr>';
		echo '<td style="font-weight:600" align="center">Username</td>';
		echo '<td style="font-weight:600" align="center">Complete Cases</td>';
		echo '</tr>';		
		$synced=array();
		$synced_cases=$this->db->query("select meta_primary_key from synclog where tablename='survey_values' and columnname='survey_case_id' and status='1' ");
		if($synced_cases->num_rows()>0){
			$synced_cases=$synced_cases->result_array();
			foreach($synced_cases as $sc){
				array_push($synced,$sc['meta_primary_key']);
			}
		}
		if(sizeof($synced)>0){
			$complete_cases=$this->db->query("SELECT username, count(*) as total FROM `survey_values` where survey_id='".$survey_title_url."' and username='".$this->session->userdata('user_logged_username')."' and survey_case_id not in ('".implode("','",$synced)."') group by username");
		}else{
			$complete_cases=$this->db->query("SELECT username, count(*) as total FROM `survey_values` where survey_id='".$survey_title_url."' and username='".$this->session->userdata('user_logged_username')."' group by username");
		}
		if($complete_cases->num_rows()>0){
			$complete_cases=$complete_cases->result_array();
			foreach($complete_cases as $cc){
				echo '<tr>';
				echo '<td align="center">'.$cc['username'].'</td>';
				echo '<td align="center">'.$cc['total'].'</td>';
				echo '</tr>';			
			}
		}
		echo '</table>';
	}
	public function survey_compile($title_url){
		$funcs=array();
        if($this->session->userdata('user_logged_id')){		
			$query = $this->db->query("select * from survey_data where code!='' && survey_id in (select title_url from survey_section where survey_id='".$title_url."') ");
			if($query->num_rows()>0){
				$funcs=array();
				$questions=$query->result_array();
				$code_name_array=array();
				foreach($questions as $q){
					//print_r($q['code']);
					if($q['code_name']!=''){
						$q['code_name']=(array) json_decode($q['code_name']);
						//print_r($q['code_name']);
						foreach($q['code_name'] as $keyy=>$valuee){
							$code_name_array[$keyy]=$valuee;
						}
					}	
				}
				//print_r($code_name_array);
				foreach($questions as $q){
					$big_code='';	//post functions
					$small_code='';	//pre functions

					if($q['code']!=''){
						$q['code']=preg_split('/\/\//',$q['code']);
						unset($q['code'][0]);
						//print_r($q['code']);
						$code=array();
						$key_code='';
						$value_code='';
						//print_r($q['code']);
						$i=0;
						foreach($q['code'] as $c){
							$i++;
							if($i%2==1){
								$key_code=$c;		
							}else{
								$value_code=$c;
							}
							$code[$key_code]=$value_code;
						}
						foreach($code as $k=>$v){
							$big_code_temp='';
							$small_code_temp='';
							if(strstr($v,"/*preproc*/")){
								/*extracting preprec code from postproc code start*/
								$v_temp=explode("/*preproc*/",$v);
								/*extracting preprec code from postproc code end*/
								if(sizeof($v_temp)>0){
									if(!empty($v_temp[2])){
									$big_code_temp.='function '.$k.'(){'.$v_temp[2].'}';
									}
									if(!empty($v_temp[1])){
										$small_code_temp.='function _'.$k.'(){'.$v_temp[1].'}';
									}
								}else{
									$big_code_temp.='function '.$k.'(){'.$v.'}';
								}
							}else{
									$big_code_temp.='function '.$k.'(){'.$v.'}';
							}
							$big_code.=$big_code_temp;
							$small_code.=$small_code_temp;
						}
					}
					if(sizeof($code_name_array)>0){
						foreach($code_name_array as $sqcn_k=>$sqcn_v){
							$big_code=str_replace($sqcn_v,$sqcn_k,$big_code);
							//$big_code=str_replace("function ".$sqcn_v."(","function ".$sqcn_k."(",$big_code);
							$small_code=str_replace($sqcn_v,$sqcn_k,$small_code);
							//$small_code=str_replace("function ".$sqcn_v."(","function ".$sqcn_k."(",$small_code);
						}
					}	
					$small_code=str_replace("\r\n",'',$small_code);
					$big_code=str_replace("\r\n",'',$big_code);
					array_push($funcs,$small_code);
					array_push($funcs,$big_code);
				}
			}
			//ob_clean();
			echo json_encode($funcs);
			//print_r($funcs);
			//echo $funcs=implode('',$funcs);
		}
	}	
	public function survey_duplicate_save(){
		setcookie('design_survey', '', time() - 3600, '/');
		setcookie('fill_survey', '', time() - 3600, '/');
		setcookie('analytics_survey', '', time() - 3600, '/');
		$survey_id=$this->input->post('id');
		$title=$this->input->post('title');
		$survey=$this->Survey_model->get_survey_by_title_url($survey_id);
		foreach($survey as $s){
			//print_r($s);
			$s['id']='';
			$s['title_url']=$this->randomString(20,'');
			$s['title']=$title;
			$s['user_id']="".$this->session->userdata('user_logged_id')."";
			$s['access']='0';
			
			$section_sort_id=$s['section_sort_id'];
			$section_sort_id=explode(',',$section_sort_id);
			$new_section_sort_id=array();
			foreach($section_sort_id as $ssi){
				$section=$this->Survey_model->get_survey_section_by_id($ssi);
				//print_r($section);
				foreach($section as $sec){
					$sec['id']='';
					$sec['title_url']=$this->randomString(20,'');
					$sec['survey_id']=$s['title_url'];
					$question_sort_id=$sec['question_sort_id'];
					$question_sort_id=explode(',',$question_sort_id);	
					$new_question_sort_id=array();
					foreach($question_sort_id as $qsi){
						$question=$this->Survey_model->get_survey_data_by_id($qsi);
						//print_r($question);
						foreach($question as $ques){
							$ques['id']='';
							$ques['data_id']=$this->randomString(20,'');	
							$ques['survey_id']=$sec['title_url'];
							$insert_id=$this->Survey_model->store_survey_data($ques);
							array_push($new_question_sort_id,$insert_id);
							//echo "question_id ".$insert_id."\r\n";
						}
					}
					$sec['question_sort_id']=implode(',',$new_question_sort_id);
					$insert_id=$this->Survey_model->store_survey_section($sec);						
					array_push($new_section_sort_id,$insert_id);
					//echo "section_id ".$insert_id."\r\n";
				}
			}
			$s['section_sort_id']=implode(',',$new_section_sort_id);
			$insert_id=$this->Survey_model->store_survey($s);	
			//echo "survey_id ".$insert_id."\r\n";
		}
		redirect(base_url());
	}
	public function question_default_name($question_id){
		$survey_data_query=$this->Survey_model->get_survey_data_by_id($question_id);
		$survey_data_query=$survey_data_query[0];
		$default_question_no=json_decode($survey_data_query['elements']);
		$default_question_no=$default_question_no[0];
		//print_r($default_question_no);
		//ob_clean();
		echo $default_question_no;
	}
	public function lengths($survey_title_url){
		if($this->session->userdata('user_logged_id')){
			$questions_arr=array();
			$this->db->where('title_url', $survey_title_url);
			$this->db->where('status', '1');
			$this->db->order_by('id','asc');
			$query2 = $this->db->get('survey');
			if($query2->num_rows()>0){
				$survey=$query2->result_array();
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
									//array_push($sfd['survey_section'],$ss);

									$question_sort_ids=$ss['question_sort_id'];
									$question_sort_ids=explode(',',$question_sort_ids);
									if(is_array($question_sort_ids)){
										foreach($question_sort_ids as $ques_arr){
											$this->db->select('id,qtype,lengths,elements,json_data');
											$this->db->where('id',$ques_arr);
											$query4 = $this->db->get('survey_data');
											//echo "query: ".$this->db->last_query()." num rows: ".$query3->num_rows();
											if($query4->num_rows()>0){
												$survey_data=$query4->result_array();
												foreach($survey_data as $sd){
													array_push($questions_arr,$sd);
												}
											}								
										}
									}else{
										$this->db->select('id,qtype,lengths,elements,json_data');
										$this->db->where('id',$question_sort_ids);
										$query4 = $this->db->get('survey_data');
										//echo "query: ".$this->db->last_query()." num rows: ".$query3->num_rows();
										if($query4->num_rows()>0){
											$survey_data=$query4->result_array();
											foreach($survey_data as $sd){
												array_push($questions_arr,$sd);
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
								//array_push($sfd['survey_section'],$ss);

								$question_sort_ids=$ss['question_sort_id'];
								$question_sort_ids=explode(',',$question_sort_ids);
								if(is_array($question_sort_ids)){
									foreach($question_sort_ids as $ques_arr){
										$this->db->select('id,qtype,lengths,elements,json_data');
										$this->db->where('id',$ques_arr);
										$query4 = $this->db->get('survey_data');
										//echo "query: ".$this->db->last_query()." num rows: ".$query3->num_rows();
										if($query4->num_rows()>0){
											$survey_data=$query4->result_array();
											foreach($survey_data as $sd){
												array_push($questions_arr,$sd);
											}
										}								
									}
								}else{
									$this->db->select('id,qtype,lengths,elements,json_data');
									$this->db->where('id',$question_sort_ids);
									$query4 = $this->db->get('survey_data');
									//echo "query: ".$this->db->last_query()." num rows: ".$query3->num_rows();
									if($query4->num_rows()>0){
										$survey_data=$query4->result_array();
										foreach($survey_data as $sd){
											array_push($questions_arr,$sd);
										}
									}										
								}
							}
						}
					}
				}
				echo '<table id="VFL" width="100%">
						<tr>
						<th width="60%" align="center"><label>Variables</label></th>
						<th width="20%" align="center"><label>Format</label></th>
						<th width="20%" align="center"><label>Length</label></th>
						</tr></table>
				';				
				foreach($questions_arr as $qa){
					if($qa['qtype']!="Static Image"){
						$question_lengths_arr=(array) json_decode($qa['lengths']);
						//print_r($question_lengths_arr);
						$survey_question_text_arr=array();
						$survey_question_text_arr2=array();
						$multiple_answer='';
						$sqt=(array) json_decode($qa['json_data']);
						//print_r($sqt);
						if(isset($sqt['multiple_answer'])){
							$multiple_answer=$sqt['multiple_answer'];
						}
						if(isset($sqt['rows']) && isset($sqt['columns'])){
							$sqt_rows=$sqt['rows'];
							$sqt_columns=$sqt['columns'];
							$new_sqt_columns=$sqt['columns'];
							//print_r($sqt_rows);print_r($sqt_columns);

							for($i=0;$i<count($sqt_rows);$i++){
								for($j=0;$j<count($sqt_columns);$j++){
									$sqt_combine='';
									$sqt_combine=$sqt_rows[$i]." - ".$sqt_columns[$j];
									$survey_question_text_arr["answer_".strtolower($sqt['question_no'])."_".$i.$j]=$sqt_combine;

									$sqt_combine2='';
									$new_sqt_columns[$j]=explode(' ',$new_sqt_columns[$j]);
									$new_sqt_columns[$j]=$new_sqt_columns[$j][0];
									$sqt_combine2=$new_sqt_columns[$j]."_".$sqt_rows[$i];
									$survey_question_text_arr2["answer_".strtolower($sqt['question_no'])."_".$i.$j]=$sqt_combine2;

									if(isset($sqt['dropdown_choices'])){
										foreach($sqt['dropdown_choices'] as $new_drop_choice){
											for($k=0;$k<sizeof($new_drop_choice);$k++){

												$temp_drop_choice=$new_drop_choice[$k];
												if($temp_drop_choice!=''){
													$temp_drop_choice=explode("|",$temp_drop_choice);
													if(sizeof($temp_drop_choice)>0){
														//echo $temp_drop_choice[0]." ".$temp_drop_choice[1];
														$survey_question_text_arr["answer_".strtolower($sqt['question_no'])."_".$i.$j."_".$temp_drop_choice[0]]=$temp_drop_choice[1];
														//$survey_question_text_arr["answer_".strtolower($sqt['question_no'])."_".$i.$j"_oth"]=$sqt_a[1];
													}

													$matches='';
													preg_match("#<English>(.*?)</English>#", trim($temp_drop_choice[1]), $matches);
													$temp_drop_choice[1]=$matches[1];
													$survey_question_text_arr2["answer_".strtolower($sqt['question_no'])."_".$i.$j."_".$temp_drop_choice[0]]=$sqt_combine2."_".$temp_drop_choice[0];
												}
											}

										}
									}						
								}
							}
						}else if(isset($sqt['rows'])){
							$sqt_rows=$sqt['rows'];
							//print_r($sqt_rows);

							for($i=0;$i<count($sqt_rows);$i++){
								$sqt_combine='';
								$sqt_combine=$sqt_rows[$i];
								$survey_question_text_arr["answer_".strtolower($sqt['question_no'])."_".$i]=$sqt_combine;

								$sqt_combine2='';
								$sqt_combine2=$sqt_rows[$i];
								$survey_question_text_arr2["answer_".strtolower($sqt['question_no'])."_".$i]=$sqt_combine2;
							}		
						}else{
							if(is_array($sqt) && isset($sqt['multiple_answer']) && $sqt['multiple_answer']=='1'){
								$survey_question_text_arr["answer_".strtolower($sqt['question_no'])]=$sqt['question'];
								$survey_question_text_arr2["answer_".strtolower($sqt['question_no'])]=$sqt['question'];
								foreach($sqt['answer'] as  $sqt_a){
									$sqt_a=explode("|",$sqt_a);
									$survey_question_text_arr["answer_".strtolower($sqt['question_no'])."_".$sqt_a[0]]=$sqt_a[1];
									$survey_question_text_arr2["answer_".strtolower($sqt['question_no'])."_".$sqt_a[0]]=$sqt_a[1];
								}
							}else{
								$survey_question_text_arr["answer_".strtolower($sqt['question_no'])]=$sqt['question'];
								$survey_question_text_arr2["answer_".strtolower($sqt['question_no'])]=$sqt['question_no'];
							}
						}
							//print_r($survey_question_text_arr);			die;
							//print_r($survey_question_text_arr2);die;			
							
						
						echo "<form name='formLengths' style='margin:0'>
						<input type='hidden' id='question_id' name='question_id' value='".$qa['id']."' />";
						echo "<table width='100%' style='margin:0;'>";
						foreach(json_decode($qa['elements']) as $qe){
							echo "<tr>";
							$qe_temp=$qe;
							if(strstr($qe_temp,"_dd_")){
							$qe_temp=str_replace('dd_','',$qe_temp);
							}
							if(strstr($qe_temp,"_mm_")){
								$qe_temp=str_replace('mm_','',$qe_temp);
							}
							if(strstr($qe_temp,"_yyyy_")){
								$qe_temp=str_replace('yyyy_','',$qe_temp);
							}
							if(strstr($qe_temp,"_h_")){
								$qe_temp=str_replace('h_','',$qe_temp);
							}
							if(strstr($qe_temp,"_m_")){
								$qe_temp=str_replace('m_','',$qe_temp);
							}
							if(strstr($qe_temp,"_oth")){
								$qe_temp=str_replace('_oth','',$qe_temp);
							}
							
							$survey_question_text_arr_without_english=$survey_question_text_arr[$qe_temp];
							$matches='';
							preg_match("#<English>(.*?)</English>#", trim($survey_question_text_arr_without_english), $matches);
							$survey_question_text_arr_without_english=$matches[0];
							
							echo "<td width='60%' valign='top'><label><span>[".$qe."] ".$survey_question_text_arr_without_english."</span></label></td>";
							if(array_key_exists("format_".$qe,$question_lengths_arr) || array_key_exists("length_".$qe,$question_lengths_arr)){
								if(array_key_exists("format_".$qe,$question_lengths_arr)){
									$ql=$question_lengths_arr["format_".$qe];
									$ql_a_checked='';
									$ql_f_checked='';
									if($ql=='A'){$ql_a_checked='checked';}
									else if($ql=='F'){$ql_f_checked='checked';}
									else{}
									echo "<td width='20%' align='center' valign='top'>";
									echo "<label><input name='format_".$qe."' type='radio' $ql_a_checked value='A' />&nbsp;Alpha&nbsp;</label>";
									echo "<label><input name='format_".$qe."' type='radio' $ql_f_checked value='F' />&nbsp;Numeric&nbsp;</label>";
									echo "</td>";
								}
								if(array_key_exists("length_".$qe,$question_lengths_arr)){
									echo "<td width='20%' align='center' valign='top'><label><input name='length_".$qe."' type='text' value='".$question_lengths_arr["length_".$qe]."' /></label></td>";
								}
							}else{
								echo "<td width='20%' align='center' valign='top'>
								<label><input name='format_".$qe."' type='radio' value='A' />&nbsp;Alpha&nbsp;</label>
								<label><input name='format_".$qe."' type='radio' value='F' checked />&nbsp;Numeric&nbsp;</label>
								</td>";
								echo "<td width='20%' align='center' valign='top'><label><input name='length_".$qe."' type='text' value='8' /></label></td>";
							}
							echo "</tr>";
						}
						echo "</table></form>";	
						
				
					}
				}
				echo '<table width="100%">
					  <tr><td><input onClick=saveLengthsAll("'.$survey_title_url.'") type="button" value="Save" /></td></tr></table>';
			}			
		}
		
		
	}
	public function savelengths($survey_title_url){
		$post=$this->input->post();
		//print_r($survey_title_url);
		$post=json_decode($post['i']);
		foreach($post as $p){
			$p=(array) $p;
			$question_id=$p['question_id'];
			//print_r($p);
			parse_str($p['formData'],$p['formData']);
			unset($p['formData']['question_id']);
			//print_r($p['formData']);
			
			$question_data=$this->Survey_model->get_survey_data_by_id($question_id);
			/* recording events*/
			$data_sync = array(
				'tablename' => 'survey_data',
				'columnname' => 'lengths',
				'meta_primary_key' => $question_data[0]['data_id'],
				'donetime' => time(),
				'work' => 'edit'
			);
			$this->Synclog_model->store_synclog($data_sync);
			/* recording events*/			
			$data=array(
				'lengths'=> json_encode($p['formData']),
			);
			//print_r($data);
			$this->Survey_model->update_survey_data_by_id($question_id,$data);			
		}
		
	}
	public function control($survey_title_url){
		if($this->session->userdata('user_logged_id')){
			$this->db->where('title_url', $survey_title_url);
			$this->db->where('status', '1');
			$this->db->order_by('id','asc');
			$s = $this->db->get('survey');
			if($s->num_rows()>0){
				$contorl0='';
				$contorl1='';
				$s=$s->result_array();	
				$s=$s[0];
				if($s['control']=='0'){
					$contorl0='checked';
				}else{
					$contorl1='checked';
				}
				echo '
			<form name="control-form" id="control-form" method="post" action="'.base_url().'survey/savecontrol/'.$survey_title_url.'">
			<label><input '.$contorl0.' type="radio" name="control" value="0" /> Operator Control</label>
			<label><input '.$contorl1.' type="radio" name="control" value="1" /> System Control</label>
			<input value="Save" type="submit">
			</form>  				
				';
			}
		}
	}
	public function savecontrol($survey_title_url){
		if($this->session->userdata('user_logged_id')){
			$post=$this->input->post();
			//print_r($post);
			$data=array(
				'control'=> $post['control'],
			);
			//print_r($data);
			$this->Survey_model->update_survey_by_title_url($survey_title_url,$data);
			//echo $this->db->last_query();
			redirect($_SERVER[‘HTTP_REFERER’]);
		}
	}
	public function permission_check($username,$survey_title){
		$this->db->select('permission_design,permission_fill,permission_analytics');
		$this->db->from('survey');
		$this->db->where('title_url', $survey_title);
		$query = $this->db->get();
		if($query->num_rows()>0){
			$query=$query->result_array(); 
			$query=$query[0];
			$return_arr=array();
			$permission_design=json_decode($query['permission_design']);
			$permission_fill=json_decode($query['permission_fill']);
			$permission_analytics=json_decode($query['permission_analytics']);
			if(in_array($username,$permission_design) && sizeof($permission_design)>0){
				$return_arr['permission_design']='1';
			}else{
				$return_arr['permission_design']='0';
			}
			if(in_array($username,$permission_fill) && sizeof($permission_fill)>0){
				$return_arr['permission_fill']='1';
			}else{
				$return_arr['permission_fill']='0';
			}
			if(in_array($username,$permission_analytics) && sizeof($permission_analytics)>0){
				$return_arr['permission_analytics']='1';
			}else{
				$return_arr['permission_analytics']='0';
			}
			echo json_encode($return_arr);
		}else{
			echo json_encode(array('permission_design'=>'0','permission_fill'=>'0','permission_analytics'=>'0'));
		}
	}
	public function savejson($survey_title_url,$filename){
		//echo $survey_title_url." ".$filename;
		$json_file=array();
		$json_columns=array();
		$json_rows=array();
		$fields = $this->db->list_fields('analytics_'.$survey_title_url);
		foreach ($fields as $field){		
			array_push($json_columns,$field);
		}
		$query_data = $this->db->query('SELECT * FROM analytics_'.$survey_title_url);
		if($query_data->num_rows()>0){
			$query_data=$query_data->result_array();
			foreach($query_data as $qd){
				$json_row=array();
				foreach($fields as $field){
					$json_row[$field]=$qd[$field];
					//array_push($json_row,$qd[$field]);
				}
				array_push($json_rows,$json_row);
			}
		}	
		$user_data=$this->User_model->get_user_by_id($this->session->userdata('user_logged_id'));
		$json_file['username']=$user_data[0]['username'];
		$json_file['table']='analytics_'.$survey_title_url;
		$json_file['json_columns']=$json_columns;
		$json_file['json_rows']=$json_rows;
		$json_file=json_encode($json_file);
		$date=date('d-m-Y h i s');
		//echo $json_file;

		$local_version_path='./uploads/';
		$local_version_file=urldecode($filename)."_".$survey_title_url."_".$user_data[0]['username']."_".$date.".json";
		if(!file_exists($local_version_path.$local_version_file)) {
			@file_put_contents($local_version_path.$local_version_file, $json_file); 
		}	
		$data=array(
			'username'=>$user_data[0]['username'],
			'survey_id'=>$survey_title_url,
			'filename'=>$local_version_file,
			'add_date'=>time()
		);
		$this->db->insert('survey_values_backups',$data);
		redirect($_SERVER[‘HTTP_REFERER’]."dataeditor");
	}
	public function loadjson($survey_title_url,$filename){
		//echo $survey_title_url.$filename;
		$this->load->dbforge();
		$this->dbforge->drop_table('analytics_'.$survey_title_url);
		
		$json_url = "./uploads/".urldecode($filename);
		$json = file_get_contents($json_url);
		$data = json_decode($json, TRUE);
		//echo "<pre>";
		//print_r($data);
		//echo "</pre>";		
		
		$create_analytics_table_query="
		CREATE TABLE `".'analytics_'.$survey_title_url."` (";
		for($i=0;$i<sizeof($data['json_columns']);$i++){
			if($i== (sizeof($data['json_columns'])-1) ){
				$create_analytics_table_query.="`".$data['json_columns'][$i]."` varchar(255) NOT NULL";
			}else{
				$create_analytics_table_query.="`".$data['json_columns'][$i]."` varchar(255) NOT NULL,";
			}
		}
		$create_analytics_table_query.="
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		";
		//echo $create_analytics_table_query;
		$this->db->query($create_analytics_table_query);
		
		$alter_query1='ALTER TABLE `'.'analytics_'.$survey_title_url.'` ADD PRIMARY KEY(`id`);';
		$alter_query2='ALTER TABLE `'.'analytics_'.$survey_title_url.'` CHANGE `id` `id` INT NOT NULL AUTO_INCREMENT;';
		$this->db->query($alter_query1);
		$this->db->query($alter_query2);
		
		for($j=0;$j<sizeof($data['json_rows']);$j++){
			$insert_analytics_row_query="INSERT INTO `".'analytics_'.$survey_title_url."` (";
			for($i=0;$i<sizeof($data['json_columns']);$i++){
				if($i== (sizeof($data['json_columns'])-1) ){
					$insert_analytics_row_query.="`".$data['json_columns'][$i]."`";
				}else{
					$insert_analytics_row_query.="`".$data['json_columns'][$i]."`, ";
				}
			}		
			$insert_analytics_row_query.=") VALUES (";
			for($k=0;$k<sizeof($data['json_columns']);$k++){	
				if($k== (sizeof($data['json_columns'])-1) ){
					$insert_analytics_row_query.="'".$data['json_rows'][$j][$data['json_columns'][$k]]."' ";
				}else{
					$insert_analytics_row_query.="'".$data['json_rows'][$j][$data['json_columns'][$k]]."', ";
				}
			}
			$insert_analytics_row_query.=");";
			//echo $insert_analytics_row_query."\r\n";
			$this->db->query($insert_analytics_row_query);
		}
		$f=$this->db->query("update survey_values_backups set status='0' ");
		$f=$this->db->query("update survey_values_backups set status='1' where survey_id='".$survey_title_url."' && filename='".urldecode($filename)."'  ");
		redirect($_SERVER[‘HTTP_REFERER’]."dataeditor");
	}
	public function removejson($survey_title_url,$filename){
		$f=$this->db->query("delete from survey_values_backups where survey_id='".$survey_title_url."' && filename='".urldecode($filename)."'  ");
		$filename=urldecode($filename);
		if(file_exists("uploads/".$filename)){
			unlink("uploads/".$filename);
		}
		redirect($_SERVER[‘HTTP_REFERER’]."dataeditor");
	}	
	public function updateentry($survey_id,$row,$column,$val){
		$val=urldecode($val);
		$q="update analytics_".$survey_id." set ".$column."='".$val."' where survey_case_id='".$row."' ";
		$this->db->query($q);
	}
	public function frequency($survey_id){
		$g=json_decode($this->input->post('rows'));
		$indicators=(array) json_decode($this->input->post('indicators'));
		$indicators_dataid=(array) json_decode($this->input->post('indicators_dataid'));
		foreach($g as $gg){
			$data=array(
				'rows' => $gg,
				'survey_id' => $survey_id,
				'indicators' => $indicators,
				'indicators_dataid' => $indicators_dataid
			);
			$this->load->view('analytics_frequency',$data);
			//break;
		}
	}
	public function table($survey_id){
		$rows=json_decode($this->input->post('rows'));
		$columns=json_decode($this->input->post('columns'));
		$indicators=(array) json_decode($this->input->post('indicators'));
		$indicators_dataid=(array) json_decode($this->input->post('indicators_dataid'));
		$row_percent=json_decode($this->input->post('row_percent'));
		$col_percent=json_decode($this->input->post('col_percent'));
			$data=array(
				'rows' => $rows[0],
				'columns' => $columns[0],
				'survey_id' => $survey_id,
				'indicators' => $indicators,
				'indicators_dataid' => $indicators_dataid,
				'row_percent' => $row_percent,
				'col_percent' => $col_percent
			);
			$this->load->view('analytics_table',$data);
	}
	public function table2x2($survey_id){
		$rows=json_decode($this->input->post('rows'));
		$columns=json_decode($this->input->post('columns'));
		$indicators=(array) json_decode($this->input->post('indicators'));
		$indicators_dataid=(array) json_decode($this->input->post('indicators_dataid'));
		$row_percent=json_decode($this->input->post('row_percent'));
		$col_percent=json_decode($this->input->post('col_percent'));
			$data=array(
				'rows' => $rows,
				'columns' => $columns,
				'survey_id' => $survey_id,
				'indicators' => $indicators,
				'indicators_dataid' => $indicators_dataid,
				'row_percent' => $row_percent,
				'col_percent' => $col_percent
			);
			$this->load->view('analytics_table2x2',$data);
	}
	public function table_layer($survey_id){
		$rows=json_decode($this->input->post('rows'));
		$columns=json_decode($this->input->post('columns'));
		$layer=json_decode($this->input->post('layer'));
		$indicators=(array) json_decode($this->input->post('indicators'));
		$indicators_dataid=(array) json_decode($this->input->post('indicators_dataid'));
		$row_percent=json_decode($this->input->post('row_percent'));
		$col_percent=json_decode($this->input->post('col_percent'));
			$data=array(
				'rows' => $rows[0],
				'columns' => $columns[0],
				'layer' => $layer[0],
				'survey_id' => $survey_id,
				'indicators' => $indicators,
				'indicators_dataid' => $indicators_dataid,
				'row_percent' => $row_percent,
				'col_percent' => $col_percent
			);
			$this->load->view('analytics_table_layer',$data);
	}	
	public function chart($survey_id){
		$chartType=$this->input->post('chartType');
		$rows=json_decode($this->input->post('rows'));
		$columns=json_decode($this->input->post('columns'));
		$layer=json_decode($this->input->post('layer'));
		$indicators=(array) json_decode($this->input->post('indicators'));
		$indicators_dataid=(array) json_decode($this->input->post('indicators_dataid'));
		$row_percent=json_decode($this->input->post('row_percent'));
		$col_percent=json_decode($this->input->post('col_percent'));
		$chartDrawType=$this->input->post('chartDrawType');
			$inner_data=array(
				'chartType' => $chartType,
				'chartDrawType' => $chartDrawType,
				'rows' => $rows,
				'columns' => $columns,
				'layer' => $layer,
				'survey_id' => $survey_id,
				'indicators' => $indicators,
				'indicators_dataid' => $indicators_dataid
			);
			$data=array(
				'data' => $inner_data
			);
			if($chartDrawType==''){
				$this->load->view('analytics_chart_'.$chartType.'_count',$data);
			}else{
				$this->load->view('analytics_chart_'.$chartType.'_'.$chartDrawType,$data);
			}
	}	
	public function map($survey_id){
		$mapType=$this->input->post('mapType');
		$rows=json_decode($this->input->post('rows'));
		$columns=json_decode($this->input->post('columns'));
		$indicators=(array) json_decode($this->input->post('indicators'));
		$indicators_dataid=(array) json_decode($this->input->post('indicators_dataid'));
			$inner_data=array(
				'mapType' => $mapType,
				'rows' => $rows,
				'columns' => $columns,
				'survey_id' => $survey_id,
				'indicators' => $indicators,
				'indicators_dataid' => $indicators_dataid
			);
			$data=array(
				'data' => $inner_data
			);
			$this->load->view('analytics_map',$data);
	}	
	public function analytics_save($survey_id){
		if($this->session->userdata('user_logged_id')){		
			$analytic_or_track=$this->input->post('analytic_or_track');
			$analytics_graph_url=$this->input->post('analytics_graph_url');
			$analytics_post_data=$this->input->post('analytics_post_data');
			$data=array(
				'analytic_or_track' => $analytic_or_track,
				'analytics_graph_url' => $analytics_graph_url,
				'analytics_post_data' => $analytics_post_data,
				'survey_id'=>$survey_id,
				'username' => $this->session->userdata('user_logged_username'),
				'add_date'=>time()
			);
			$this->db->insert('dashboard_analytics',$data);
		}
	}
	public function newcase(){
		echo json_encode(array("key"=>$this->randomString(20,'')));
		$this->logFill();		
	}
	public function analytics_png(){
		$filename="chart_".$this->input->post('chart_id').".png";
		$data = $this->input->post('data_url');
		list($type, $data) = explode(';', $data);
		list(, $data)      = explode(',', $data);
		$data = base64_decode($data);
		file_put_contents('uploads/'.$filename, $data);	
		echo json_encode(array("success"=>1));
	}
	public function analytics_png2($name){
		$data = $this->input->post('data_url');
		list($type, $data) = explode(';', $data);
		list(, $data)      = explode(',', $data);
		$data = base64_decode($data);
		$filename="chart_".$name.".png";	
		unlink('uploads/'.$filename);
		file_put_contents('uploads/'.$filename, $data);	
		echo json_encode(array("filename"=>$filename));	
	}
	public function survey_email(){
		//$email_url=$this->input->post('email_url');
		$email_to=$this->input->post('email_to');
		$email_subject=$this->input->post('email_subject');
		$email_message=$this->input->post('email_message');
		/*$html_mail='
			<p>Dear '.$this->input->post('name').',</p>
			<p>Username '.$this->input->post('username').',</p>
			<p>Password SaMbOdHi</p>
			<!--<p><a href="'.base_url()."login/setpassword/".md5($this->input->post('email')).'">Plz Click Here To Set Your Password For Login on Sambodhi Survey </a></p>-->
			';*/
		$this->email->from("jagjeet.singh@sambodhi.co.in", 'Thesurveypoint.com');
		$this->email->to($email_to);
		$this->email->subject($email_subject);
		$this->email->message($email_message);
		$this->email->set_mailtype("html");
		$this->email->send();
		redirect($_SERVER["HTTP_REFERER"]);		
	}
	public function fill_entry($survey_title_url){
		//echo $survey_title_url;
		$data=array(
			'randomstring'=>$this->randomString(20,''),
			'big_code'=>''
		);		
		$data['survey']=$this->Survey_model->get_survey_by_title_url($survey_title_url);
		$temp_sections=$this->Survey_model->get_survey_sections_by_title_url($survey_title_url);
		$data['section_count']=sizeof($temp_sections);
		$this->load->view("fill_entry",$data);
		
	}
	public function question_bank(){
		$this->load->view("question_bank");
	}
	public function templates(){
		$this->load->view("templates");
	}
	public function fill_status($survey_id){
		//pcsu
		$p=0;$c=0;$s=0;$u=0;
		$q=$this->db->query("select count(*),survey_case_id from survey_partial_values where survey_id='".$survey_id."' group by survey_case_id ");
		$p=$q->num_rows();
		$q=$this->db->query("select * from survey_values where survey_id='".$survey_id."'");
		$c=$q->num_rows();
		$q=$this->db->query("select * from synclog where tablename='survey_values' && columnname='survey_case_id' && status='1' && meta_primary_key in (select survey_case_id from survey_values where survey_id='".$survey_id."')");
		$s=$q->num_rows();
		$q=$this->db->query("select * from synclog where tablename='survey_values' && columnname='survey_case_id' && status='0' && meta_primary_key in (select survey_case_id from survey_values where survey_id='".$survey_id."')");
		$u=$q->num_rows();
		//echo $p."\r\n";
		//echo $c."\r\n";
		//echo $s."\r\n";
		//echo $u."\r\n";
		//echo "P:".$p." C:".$c." S:".$s." U:".$u;
		//P:".$p.", C:".$c.", S:".$s.", U:".$u."
		echo "<span>Partial:".$p.", Complete:".$c.", Synced:".$s.", Unsynced:".$u."<span>";
	}
	public function fill_vals_save(){
		$formData=$this->input->post('formData');
		print_r($formData);
		if($formData!=''){
			$formData=str_replace('"','',$formData);
			$formData=explode(',',$formData);
			//print_r($formData);
			$local_version_file='logEntry.txt';
			if(!file_exists($local_version_file)) {
				@file_put_contents($local_version_file, 'Entry Logs'); 
			}
			$date=date('d-m-Y ');
			$time=date('h:i:sa');
			@file_put_contents($local_version_file, PHP_EOL." ".PHP_EOL.$date." ".$time,FILE_APPEND); 
			foreach($formData as $fD){
				if($fD!=''){
					@file_put_contents($local_version_file, PHP_EOL.$fD,FILE_APPEND); 
				}
			}
		}else{
			echo json_encode(array('success'=>'0'));
		}
	}
	public function compute($survey_id){
		$ne=$this->input->post('numerical_expression');
		$tv=$this->input->post('target_variable');
		$tl=$this->input->post('target_label');
		//$q1=$this->Survey_model->survey_indicators_dataid_codenames($this->input->post('survey_title_url'));
		$q2=$this->db->list_fields('analytics_'.$survey_id);
		
		//create column if not exist
		if(in_array($tv,$q2)){
		}else{
			$this->db->query("ALTER TABLE `analytics_".$survey_id."` ADD `".$tv."` text NULL COMMENT '".$tl."' After `".$q2[sizeof($q2)-3]."` ");
		}		
		$q2=$this->db->list_fields('analytics_'.$survey_id);
		//print_r($q2);
		//unset($q2[sizeof($q2)-1]);
		//unset($q2[sizeof($q2)-1]);
		//unset($q2[0]);
		//unset($q2[1]);
		//print_r($q2[sizeof($q2)-3]);
		if(strstr($ne,$tv)){
			$ne=str_replace($tv,"$".$tv,$ne);
		}
		foreach($q2 as $qq2){
			if(strstr($ne,$qq2)){
				$ne=str_replace($qq2,"$".$qq2,$ne);
			}
		}
		$ne=str_replace("$$","$",$ne);

		$q3=$this->db->query("select ".implode(',',$q2)." from analytics_".$survey_id);
		$total=$q3->num_rows();
		if($total>0){
			$q3=$q3->result_array();
			foreach($q3 as $qq3){
				foreach($qq3 as $qqq3_k=>$qqq3_v){
					//variables created with names of columns
					${$qqq3_k} = $qqq3_v;
					if(strstr($ne,$qqq3_k)){
						eval($ne);
					}
				}
				//echo "UPDATE `analytics_".$survey_id."` SET `".$tv."` = '".${$tv}."' WHERE `analytics_".$survey_id."`.`id` = ".$qq3['id']."";
				$this->db->query("UPDATE `analytics_".$survey_id."` SET `".$tv."` = '".${$tv}."' WHERE `analytics_".$survey_id."`.`id` = ".$qq3['id']."");
				unset(${$tv});
			}
			//print_r(get_defined_vars());
		}
		echo json_encode(array("success"=>"1","msg"=>"Variable created sucessfully!"));
	}
	public function table_columns($survey_id){
		$q=$this->db->list_fields('analytics_'.$survey_id);
		unset($q[sizeof($q)-1]);
		unset($q[sizeof($q)-1]);
		unset($q[0]);
		unset($q[1]);
		$q1=$this->Survey_model->survey_indicators_dataid_codenames($survey_id);
		//print_r($q1);
		foreach($q as $qq){
			$func="insertAtCursor($('#numerical_expression'),'".$qq."')";
			if(isset($q1['indicators'][$qq])){
				echo '<option onDblClick="'.$func.'" value="'.$qq.'">'.$qq.' '.$q1['indicators'][$qq].'</option>';
			}else{
				echo '<option onDblClick="'.$func.'" value="'.$qq.'">'.$qq.'</option>';
			}
		}
	}
	public function excel_upload(){

		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'xlsx|xls';
		$config['max_size']    = '99999';
		$config['encrypt_name'] = TRUE;
		$this->upload->initialize($config);
		$this->load->library('upload', $config);
		if($this->upload->do_upload('excel_file')==1){
			$filename=$this->upload->file_name;
			$this->load->library('excel');
			$objPHPExcel = PHPExcel_IOFactory::load($config['upload_path'].$filename);
			$sheet=$objPHPExcel->getSheet(0); 
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();
			$headings = $sheet->rangeToArray('A1:' . $highestColumn . 1,NULL,TRUE,FALSE);	//got all columns in excel
			//print_r($headings);					
			
			//check table existence
			$survey_id=$this->input->post('survey_id');
			$database=$this->db->database;
			$tablename="analytics_".$survey_id;
			$table_count=0;
			$table_query=$this->db->query("SELECT count(*) as table_count FROM information_schema.TABLES WHERE (TABLE_SCHEMA = '".$database."') AND (TABLE_NAME = 'analytics_".$survey_id."')");
			if($table_query->num_rows()>0){
				$table_query=$table_query->result_array();
				$table_count=$table_query[0]['table_count'];
				//print_r($table_count);
				if($table_count>0){		//update table
					//print_r($headings[0]);
					
					$comment_arr=array();
					$query = $this->db->query("SELECT COLUMN_NAME,COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '{$database}' AND TABLE_NAME = '{$tablename}'");
					if($query->num_rows()>0){
						$query=$query->result_array();
						foreach($query as $q){
							if($q['COLUMN_COMMENT']!=''){
								$comment_arr[$q['COLUMN_NAME']]=$q['COLUMN_COMMENT'];
							}
						}
					}					
					
					foreach($headings[0] as $h){
						$columns=array();
						$fields_data = $this->db->query("SHOW FULL COLUMNS FROM `".$tablename."` ");
						if($fields_data->num_rows()>0){
							$fields_data=$fields_data->result_array();
							foreach($fields_data as $fd){
								array_push($columns,$fd['Field']);
							}
						}
						//print_r($columns);
						$new_columns = array_diff($columns, array('id', 'survey_case_id', 'username', 'add_date'));

						if($h=="id"){
						}else if($h=="survey_case_id"){
						}else if($h=="username"){
						}else if($h=="add_date"){
						}else{
							if(!in_array($h,$new_columns)){ 	//checking excel columns in db for addition
								$alter_query="ALTER TABLE `".$tablename."` ADD `".$h."` text NULL COMMENT 'New' AFTER `".end($new_columns)."` ";
								$this->db->query($alter_query);
							}else{
								$alter_query="ALTER TABLE `".$tablename."` CHANGE  `".$h."` `".$h."` text NULL COMMENT '' ";
								//$this->db->query($alter_query);
							}
						}
					}
					foreach($new_columns as $c){
						if($c=="id"){
						}else if($c=="survey_case_id"){
						}else if($c=="username"){
						}else if($c=="add_date"){
						}else{
							if(!in_array($c,$headings[0])){ 	//checking db columns in excel for deletion
								if($comment_arr[$c]!=""){
									if($comment_arr[$c]=="New" || $comment_arr[$c]=="Removed"){
										$alter_query="ALTER TABLE `".$tablename."` CHANGE  `".$c."` `".$c."` text NULL COMMENT 'Removed' ";
										$this->db->query($alter_query);
									}
								}else{
										$alter_query="ALTER TABLE `".$tablename."` CHANGE  `".$c."` `".$c."` text NULL COMMENT 'Removed' ";
										$this->db->query($alter_query);
								}
							}
						}
					}	
					//die;
				}else{					//create table
					$create_analytics_table_query="CREATE TABLE `".$tablename."` (";
					foreach($headings[0] as $h){
						if($h=="id"){
							$create_analytics_table_query.="`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, ";
						}else if($h=="survey_case_id"){
							$create_analytics_table_query.="`survey_case_id` varchar(255) NOT NULL, ";
						}else if($h=="username"){
							$create_analytics_table_query.="`username` varchar(255) NOT NULL, ";
						}else if($h=="add_date"){
							$create_analytics_table_query.="`add_date` varchar(255) NOT NULL ";
						}else{
							$create_analytics_table_query.="`".$h."` text NULL, ";
						}					
					}
					$create_analytics_table_query.=") ENGINE=InnoDB DEFAULT CHARSET=utf8;";
					//echo $create_analytics_table_query;
					$this->db->query($create_analytics_table_query);					
				}
			}			
			for ($row = 2; $row <= $highestRow; $row++){ 
				//  Read a row of data into an array
				$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);
				$rowData[0] = array_combine($headings[0], $rowData[0]);
				
				$this->db->where('survey_case_id', $rowData[0]['survey_case_id']);
				$rowExistQuery = $this->db->get($tablename);
				if($rowExistQuery->num_rows()>0){		//updating excel rows
					$update_analytics_row_query="UPDATE `".$tablename."` SET ";
					$i=0;
					foreach($headings[0] as $h){
						if($h=="id"){
						}else if($h=="survey_case_id"){
						}else if($h=="username"){
						}else if($h=="add_date"){
						}else{
							$i++;
							if(sizeof($headings[0])-4==$i){
								$update_analytics_row_query.="`".$h."` = '".$rowData[0][$h]."' ";
							}else{
								$update_analytics_row_query.="`".$h."` = '".$rowData[0][$h]."', ";
							}
						}
					}
					$update_analytics_row_query.="WHERE `".$tablename."`.`survey_case_id`= '".$rowData[0]['survey_case_id']."' ";
					$this->db->query($update_analytics_row_query);
				}else{									//inserting excel rows
					$insert_analytics_row_query="INSERT INTO `".$tablename."` (";			
					foreach($headings[0] as $h){
						if($h=="add_date"){
							$insert_analytics_row_query.="`".$h."` ";
						}else{
							$insert_analytics_row_query.="`".$h."`, ";
						}
					}				
					$insert_analytics_row_query.=") VALUES (";
					foreach($headings[0] as $h){
						if(!isset($rowData[0][$h])){
							$rowData[0][$h]="";
						}
						if($h=="id"){
							$insert_analytics_row_query.="NULL, ";
						}else if($h=="add_date"){
							$insert_analytics_row_query.="'".$rowData[0][$h]."' ";
						}else{
							$insert_analytics_row_query.="'".$rowData[0][$h]."', ";
						}
					}
					$insert_analytics_row_query.=");";
					$this->db->query($insert_analytics_row_query);
				}
			}
		}
		$filename='uploads/'.$filename;
		if(file_exists($filename)){
			unlink($filename);
		}
		redirect($_SERVER[‘HTTP_REFERER’]."dataeditor");
	}
	function survey_attach($survey_id1,$survey_id2){
		$columns_a=array();
		$columns_b=array();
		$columns_common=array();
		$fields_data = $this->db->query("SHOW FULL COLUMNS FROM `"."analytics_".$survey_id1."` ");
		if($fields_data->num_rows()>0){
			$fields_data=$fields_data->result_array();
			foreach($fields_data as $fd){
				array_push($columns_a,$fd['Field']);
			}
		}		
		$fields_data = $this->db->query("SHOW FULL COLUMNS FROM `"."analytics_".$survey_id2."` ");
		if($fields_data->num_rows()>0){
			$fields_data=$fields_data->result_array();
			foreach($fields_data as $fd){
				array_push($columns_b,$fd['Field']);
			}
		}		
		$columns_common=array_intersect($columns_a,$columns_b);
		$columns_tochange = array_diff($columns_common, array('id', 'survey_case_id', 'username', 'add_date'));
		//print_r($columns_a);
		//print_r($columns_b);
		//print_r($columns_tochange);
		echo '<form method="post" action="'.base_url().'survey/attach_save">';
		echo '<input type="hidden" name="survey_id1" value="'.$survey_id1.'" />';
		echo '<input type="hidden" name="survey_id2" value="'.$survey_id2.'" />';
		echo '<select name="unique_key">';
			echo '<option value="">Select Unique Key</option>';
		foreach($columns_common as $cc){
			echo '<option value="'.$cc.'">'.$cc.'</option>';
		}
		echo '</select>';
		//print_r($columns_tochange);
		echo '<table class="attach-table table" width="100%">';
		echo '<tr><th align="center">Common Keys</th><th align="center">New Key</th></tr>';
		foreach($columns_tochange as $ctc){
			echo '<tr><th align="center" valign="middle">'.$ctc.'</th><th><input type="text" name="'.$ctc.'" /></th></tr>';
		}
		echo '</table>';
		echo '<input type="submit" value="Attach" />';
		echo '</form>';
	}
	function attach_save(){
		$survey_id1=$this->input->post('survey_id1');
		$survey_id2=$this->input->post('survey_id2');
		$unique_key=$this->input->post('unique_key');
		
		$renamed_columns=$this->input->post();
		unset($renamed_columns['survey_id1']);
		unset($renamed_columns['survey_id2']);
		unset($renamed_columns['unique_key']);
		
		$columns_a=array();
		$columns_b=array();
		$columns_common=array();
		$fields_data = $this->db->query("SHOW FULL COLUMNS FROM `"."analytics_".$survey_id1."` ");
		if($fields_data->num_rows()>0){
			$fields_data=$fields_data->result_array();
			foreach($fields_data as $fd){
				array_push($columns_a,$fd['Field']);
			}
		}		
		$fields_data = $this->db->query("SHOW FULL COLUMNS FROM `"."analytics_".$survey_id2."` ");
		if($fields_data->num_rows()>0){
			$fields_data=$fields_data->result_array();
			foreach($fields_data as $fd){
				array_push($columns_b,$fd['Field']);
			}
		}		
		$columns_common=array_intersect($columns_a,$columns_b);
		$columns_tochange = array_diff($columns_common, array('id', 'survey_case_id', 'username', 'add_date'));
		$columns_b_new=$columns_a;
		foreach($columns_b as $cb){
			if(!in_array($cb,$columns_b_new)){
				array_push($columns_b_new,$cb);
			}else{
				if(isset($renamed_columns[$cb])){
					array_push($columns_b_new,$renamed_columns[$cb]);
				}
			}
		}

		$columns_b_new = array_diff($columns_b_new, array('id', 'survey_case_id', 'username', 'add_date'));
		$columns_b_new='id,survey_case_id,'.implode(',',$columns_b_new).',username,add_date';
		$columns_b_new=explode(',',$columns_b_new);
		$columns_b_new=array_unique($columns_b_new);
		
		$columns_common=array_intersect($columns_a,$columns_b);
		$columns_tochange = array_diff($columns_common, array('id', 'survey_case_id', 'username', 'add_date'));
		$columns_b_rest = array_diff($columns_b, $columns_common);
		
		//print_r($columns_a);
		//print_r($columns_b);
		//print_r($columns_b_new);
		//print_r($columns_common);
		//print_r($columns_tochange);
		//print_r($renamed_columns);
		//print_r($columns_b_rest);
		
		$last_column_to_add=end($columns_tochange);
		//if got new name for common fields
		foreach($columns_tochange as $ctc){				
			if(isset($renamed_columns[$ctc]) && $renamed_columns[$ctc]!=''){
				$last_column_to_add=$renamed_columns[$ctc];
				$alter_query="ALTER TABLE `"."analytics_".$survey_id1."` ADD `".$renamed_columns[$ctc]."` text NULL COMMENT 'New' AFTER `".end($columns_tochange)."` ";
				//echo $alter_query."\r\n";
				$this->db->query($alter_query);
			}
		}
		
		//adding rest columns of b table
		foreach($columns_b_rest as $cbr){
				$alter_query="ALTER TABLE `"."analytics_".$survey_id1."` ADD `".$cbr."` text NULL COMMENT 'New' AFTER `".$last_column_to_add."` ";
				//echo $alter_query."\r\n";
				$this->db->query($alter_query);
				$last_column_to_add=$cbr;
		}
		
		//transferring data from table2 to table1
		$tablename="analytics_".$survey_id1;
		$rowDataQuery=$this->db->get("analytics_".$survey_id2);
		if($rowDataQuery->num_rows()>0){
			$rowDatas=$rowDataQuery->result_array();
			//print_r($rowDatas);die;
			$reversed_renamed_columns=array_flip($renamed_columns);
			foreach($rowDatas as $rowData){
				$this->db->where($unique_key, $rowData[$unique_key]);			//checking select unique key for data comparision

				$rowExistQuery = $this->db->get($tablename);
				if($rowExistQuery->num_rows()>0){		//updating excel rows
					$update_analytics_row_query="UPDATE `".$tablename."` SET ";
					foreach($columns_tochange as $ctc){
						if(array_key_exists($ctc,$renamed_columns)){
							$update_analytics_row_query.="`".$renamed_columns[$ctc]."` = '".$rowData[$ctc]."', ";
						}else{
							$update_analytics_row_query.="`".$ctc."` = '".$rowData[$ctc]."', ";
						}
					}
					foreach($columns_b_rest as $cbr){
						if($cbr==end($columns_b_rest)){
							$update_analytics_row_query.="`".$cbr."` = '".$rowData[$cbr]."' ";
						}else{
							$update_analytics_row_query.="`".$cbr."` = '".$rowData[$cbr]."', ";
						}
					}
					$update_analytics_row_query.="WHERE `".$tablename."`.`survey_case_id`= '".$rowData['survey_case_id']."' ";
					//echo $update_analytics_row_query."\r\n";
					$this->db->query($update_analytics_row_query);
				}else{									//inserting excel rows
					$insert_analytics_row_query="INSERT INTO `".$tablename."` (";			
					foreach($columns_b_new as $cbn){
						if($cbn=="add_date"){
							$insert_analytics_row_query.="`".$cbn."` ";
						}else{
							$insert_analytics_row_query.="`".$cbn."`, ";
						}
					}				
					$insert_analytics_row_query.=") VALUES (";
					foreach($columns_b_new as $cbn){
						if(!isset($rowData[$cbn])){
							$rowData[$cbn]="";
						}
						if($cbn=="id"){
							$insert_analytics_row_query.="NULL, ";
						}else if(array_key_exists($cbn,$reversed_renamed_columns)){
							$insert_analytics_row_query.="'".$rowData[$reversed_renamed_columns[$cbn]]."', ";
						}else if(array_key_exists($cbn,$renamed_columns)){
							$insert_analytics_row_query.="'', ";
						}else if($cbn=="add_date"){
							$insert_analytics_row_query.="'".$rowData[$cbn]."' ";
						}else{
							$insert_analytics_row_query.="'".$rowData[$cbn]."', ";
						}
					}
					$insert_analytics_row_query.=");";
					//echo $insert_analytics_row_query."\r\n";
					$this->db->query($insert_analytics_row_query);
				}		
			}
		}
		redirect($_SERVER[‘HTTP_REFERER’]."dataeditor");
	}
	public function recordchart($survey_id){
		$data=array(
			'survey_id' => $survey_id
		);
		$this->load->view('analytics_chart_recordchart',$data);
	}	
	public function calculateregression($survey_id){
		$dependentVars=json_decode($this->input->post('rows'));
		$independentVars=json_decode($this->input->post('columns'));
		$indicators=(array) json_decode($this->input->post('indicators'));
		$dataLabels=array();
		$data=array();
		$all_vars=array_merge($dependentVars,$independentVars);
		foreach($all_vars as $av){
			if(array_key_exists($av,$indicators)){
				$dataLabels[$av]=$indicators[$av];
			}
		}
		
		//getting data values in data array
		$database=$this->db->database;
		$tablename="analytics_".$survey_id;
		$table_count=0;
		$q1=$this->db->query("SELECT count(*) as table_count FROM information_schema.TABLES WHERE (TABLE_SCHEMA = '".$database."') AND (TABLE_NAME = '".$tablename."')");
		if($q1->num_rows()>0){	
			$q2=$this->db->query("select ".implode(",",$all_vars)." from ".$tablename."");
			if($q2->num_rows()>0){	
				$q2=$q2->result_array();
				$data=$q2;
			}
		}
		
		//passing all data to json array
		$json=array();
		$json['data']=$data;
		$json['independentVars']=$independentVars;
		$json['dependentVars']=$dependentVars;
		$json['dataLabels']=$dataLabels;
		$json['regressionType']=$this->input->post('regression_type');
		//print_r($json);
		echo json_encode($json,JSON_NUMERIC_CHECK);
	}	
	public function r_software(){
		//escaping receiving data and outputing static json for generating chart
		$r_software_input=(array) json_decode('{"title":"Linear Regression Model having P Value: 1.49078657993012e-15 and r squared value: 30.0697068247315 on dependent variable  Q309A1  against independent variable in the graph below","regression_data":[{"variable":"p_value","variable_description":"P Value","coefficient_values":"1.49078657993012e-15"},{"variable":"r_value","variable_description":"R Squared Value","coefficient_values":"30.0697068247315"}],"data":[{"variable":"intercept","variable_description":"Model Intercept","coefficient_values":"-0.184144496412591"},{"variable":"Q309B1","variable_description":"B.Other specialist (MD/MS in filed other than obstetrics and gynaecologist) (12 days CAC training) - Total number posted at present","coefficient_values":"0.0481722445800298"},{"variable":"Q309C1","variable_description":"C.Medical Officers/ lady medical officer i.e. LMO (non-specialist, MBBS)/ ( 12 days CAC training) - Total number posted at present","coefficient_values":"0.0670869294389704"},{"variable":"Q309D1","variable_description":"D.AYUSH  - Total number posted at present","coefficient_values":"-0.158435624130615"},{"variable":"Q309E1","variable_description":"E.Staff nurses (4 days CAC training) - Total number posted at present","coefficient_values":"0.069512513252151"},{"variable":"Q309F1","variable_description":"F.ANMs/LHVs   - Total number posted at present","coefficient_values":"-0.0578182293940985"},{"variable":"Q309G1","variable_description":"G.Pharmacist - Total number posted at present","coefficient_values":"0.151415148949154"},{"variable":"Q309H1","variable_description":"H.Laboratory technician - Total number posted at present","coefficient_values":"0.0251265152614402"}]}');
		$r_software_input=json_encode($r_software_input);
		echo $r_software_input;
	}
	public function regressionchart($survey_id){
		$this->load->view('analytics_chart_regressionchart');
	}	
	public function get_survey_elements_list($question_id){
		$question_query=$this->db->query("select elements from survey_data where id='".$question_id."'");
		if($question_query->num_rows()>0){
			$question_query=$question_query->result_array();
			$question_query=$question_query[0];
			$question_query['elements']=json_decode($question_query['elements']);
			//print_r($question_query);
			echo json_encode($question_query['elements']);
		}
	}	
	public function word_cloud($survey_id){
		$g=json_decode($this->input->post('rows'));
		$indicators=(array) json_decode($this->input->post('indicators'));
		$indicators_dataid=(array) json_decode($this->input->post('indicators_dataid'));
		$data=array(
			'rows' => $g,
			'survey_id' => $survey_id,
			'indicators' => $indicators,
			'indicators_dataid' => $indicators_dataid
		);
		$this->load->view('analytics_wordcloud',$data);
		//break;
	}	
	public function get_survey_elements_list_all($survey_id){
		$elements=array();
		$question_query=$this->db->query("
		select elements from survey_data where survey_id in
		(select title_url from survey_section where survey_id='".$survey_id."'
		)
		");
		//echo $this->db->last_query();
		if($question_query->num_rows()>0){
			$question_query=$question_query->result_array();
			foreach($question_query as $qq){
				if($qq['elements']!=""){
					$qq['elements']=json_decode($qq['elements']);
					foreach($qq['elements'] as $qqe){
						//print_r($qqe);
						array_push($elements,$qqe);
					}
				}
			}
			echo json_encode($elements);
		}
	}	
	public function get_survey_code2($question_id){
		$question_query=$this->db->query("select code2 from survey_data where id='".$question_id."' ");
		//echo $this->db->last_query();
		if($question_query->num_rows()>0){
			$question_query=$question_query->result_array();
			$question_query=$question_query[0]['code2'];
			echo $question_query;
		}else{
			echo "";
		}
	}
	public function save_wizard_code(){
		//print_r($this->input->post());
		$question_id=$this->input->post('question_id');
		$html=$this->input->post('html');	
		$html=trim($html);
		$data=array(
			'code2'=>$html
		);
		$this->db->where('id',$question_id);
		$this->db->update('survey_data',$data);
	}
	public function get_survey_code($question_id){
		$constants=get_defined_constants();
		$codeArrAvailable=unserialize($constants['codeArrAvailable']);
		$codeArr=unserialize($constants['codeArr']);
		
		echo "<form name='form_data_code' id='form_data_code'>";
		echo "<textarea id='comm_panel' name='comm_panel' wrap='off' readonly>";
		
		$question_query=$this->db->query("select code from survey_data where id='".$question_id."' ");
		//echo $this->db->last_query();
		if($question_query->num_rows()>0){
			$question_query=$question_query->result_array();
			$question_query=$question_query[0]['code'];
			echo $question_query;
		}else{
			echo "";
		}
		echo "</textarea>";
		echo "<label id='comm_error' class='comm_error'></label>";		
	}	
	public function save_wizard_updated_code(){
		//print_r($this->input->post());
		$question_id=$this->input->post('question_id');
		$code=$this->input->post('code');	
		//$code=trim($code);
		$data=array(
			'code'=>$code
		);
		$this->db->where('id',$question_id);
		$this->db->update('survey_data',$data);
	}	
}
?>



