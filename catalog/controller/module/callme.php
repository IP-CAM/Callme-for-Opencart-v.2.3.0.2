<?php
class ControllerModuleCallme extends Controller {		
	public function index() {
		$this->load->language('module/callme');
		$json = array();	
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && isset($this->request->post['session_id']) && $this->request->post['session_id'] == $this->session->session_id ) {
			if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 150)) {
				$json['error']['name'] = $this->language->get('error_name_empty');
			}		
			if (!preg_match('/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/', $this->request->post['phone'])){
				$json['error']['phone'] = $this->language->get('error_phone');
			}
			if (!isset($json['error'])) {
				$subject = $this->config->get('config_name').". ".$this->request->post['subject'];
				$message="<h3>".$this->request->post['head']."</h3>";
			foreach($this->request->post as $key=>$value){
				if($key!='subject'){
					if($key=='name'){
						$message .="<p><i>".$this->language->get('text_name')."</i>: ".htmlspecialchars(strip_tags($value))."</p>";
					}
					if($key=='phone'){
						$message .="<p><i>".$this->language->get('text_phone')."</i>: ".htmlspecialchars(strip_tags($value))."</p>";
					}
					if($key=='geturl'){
						$message .="<p><hr/><i>".$this->language->get('text_page')."</i> ".htmlspecialchars(strip_tags($value))."</p>";
					}
				}			
			}			
			$this->sendEmail($message, $subject);			
			$json['success'] = $this->language->get('text_success');
			if(isset($this->request->post['phone'])){
				$json['success_call'] = $this->language->get('text_success_call');
				$json['call'] = $this->request->post['phone'];
			}
			$this->load->model('module/form');	
			$this->model_module_form->saveForm($subject,$message);			
			}			
		}		
		$this->response->addHeader('Content-Type: application/json');
		echo(json_encode($json));
}
	public function write() {
		$this->load->language('module/callme');
		$this->load->model('setting/customvalidator');
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && isset($this->request->post['session_id']) && $this->request->post['session_id'] == $this->session->session_id ) {
			if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 150)) {
				$json['error']['name'] = $this->language->get('error_name_empty');				
			}
			if (!preg_match('/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/', $this->request->post['phone'])){
				$json['error']['phone'] = $this->language->get('error_phone');
            } 		
			if(isset($this->request->post['message']) && $this->request->post['message']!=''){
				if($this->model_setting_customvalidator->getBadWords($this->request->post['message'])==false)
				{
					$json['error']['message'] = $this->language->get('error_badwords');
				}
				if ((utf8_strlen($this->request->post['message']) > 1000)) {
					$json['error']['message'] = $this->language->get('error_message');
				}
			}		
			if(!filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL))
            {
               $json['error']['email'] = $this->language->get('error_email');
            }
			if (!isset($json['error'])) {                
                $subject = $this->config->get('config_name').". ".$this->request->post['subject'];
				$message="<h3>".$this->request->post['head']."</h3>";
                foreach($this->request->post as $key=>$value){
					if($key!='subject'){
						if($key=='name'){
							$message .="<p><i>".$this->language->get('text_name')."</i>: ".htmlspecialchars(strip_tags($value))."</p>";
						}
						if($key=='phone'){
							$message .="<p><i>".$this->language->get('text_phone')."</i>: ".htmlspecialchars(strip_tags($value))."</p>";
						}
						if($key=='email'){
							$message .="<p><i>".$this->language->get('text_email')."</i>: ".htmlspecialchars(strip_tags($value))."</p>";
						}
						if($key=='message'){
							$message .="<p><i>".$this->language->get('text_message')."</i>: ".htmlspecialchars(strip_tags($value))."</p>";
						}
						if($key=='product' && $value!=''){
							$message .="<p><i>".$this->language->get('text_product')."</i>: ".htmlspecialchars(strip_tags($value))."</p>";
						}	
						if($key=='geturl'){
							$message .="<p><hr/><i>".$this->language->get('text_page')."</i> ".htmlspecialchars(strip_tags($value))."</p>";
						}
					}
				}			
				$this->sendEmail($message, $subject);
				$json['success'] = $this->language->get('text_success');
				if(isset($this->request->post['phone'])){
					$json['success_call'] = $this->language->get('text_success_call');
					$json['call'] = $this->request->post['phone'];
					}				
				$this->load->model('module/form');	
				$this->model_module_form->saveForm($subject,$message);
			}	
		}		
		$this->response->addHeader('Content-Type: application/json');	
		echo(json_encode($json));
	}	
	
	
	private function sendEmail($message, $subject){
		$message .="<p>".$_SERVER['REMOTE_ADDR']."</p>";
		$entry_from = $this->config->get('config_email');
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";
		$headers .= "From: ".$this->config->get('config_name')." <".$entry_from.">\r\n"; 
		$headers .= "Reply-To: ".$entry_from."\r\n"; 
		$headers .= "X-Mailer: PHP/" . phpversion();
		$emails = explode(',', $this->config->get('config_alert_email'));
		foreach ($emails as $email) {
			if ($email && preg_match($this->config->get('config_mail_regexp'), $email)) {
				@mail($email, $subject, $message, $headers);
			}
		}
		return true;	
	}
	
	public function ajax(){
		$json['success'] = 'ok';
		$this->response->addHeader('Content-Type: application/json');	
		echo(json_encode($json));
	}
}
?>