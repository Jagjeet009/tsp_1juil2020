<?php
class Mail_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }
    public function mail($to='',$subject='',$message='',$file=''){
        //echo "To: ".$to."\r\n";
        //echo "Subject: ".$subject."\r\n";
        //echo "Message: ".$message."\r\n";
        //echo "File: ".$file."\r\n";

        $config['smtp_crypto'] = 'tls';
        $config['protocol'] = 'smtp'; 
        $config['smtp_host'] = 'smtp.office365.com';
        $config['smtp_user'] = 'noreply@tsnplay.com'; 
        $config['smtp_pass'] = 'Boy80436'; 
        $config['smtp_port'] = '587'; 
        $config['charset']='utf-8'; // Default should be utf-8 (this should be a text field) 
        $config['newline']="\r\n"; //"\r\n" or "\n" or "\r". DEFAULT should be "\r\n" 
        $config['crlf'] = "\r\n"; //"\r\n" or "\n" or "\r" DEFAULT should be "\r\n" 
        $config['smtp_timeout'] = '60';    

        $this->load->library('email');                    
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->from($config['smtp_user']);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        if($file!=""){
            $this->email->attach($file);
        }
        $sent=$this->email->send();
        $status=array(
            'sent'=> $sent,
            'error'=>$this->email->print_debugger()
        );
        //print_r($status);
        return $status;        
    }
}
?>  