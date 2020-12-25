<?php
class ModelSettingCustomValidator extends Model {
	public function getBadWords($string) {
		$badwords=array();
		$error=false;
		
		$config_badwords=$this->language->get('badwords');
		if($config_badwords!=''){
		
			$badwords=explode(",",$config_badwords);
			
			foreach($badwords as $value_array)
			 {
				
				if(stripos($string, $value_array)===false){
					//$error=true;
					
				}
				else{
					return false;
					exit();
					
				}
			 } 
			
			if (preg_match('/[a-zA-Z]/', $string)) { 
				return false;
					exit();
                //запрещенные символы
                //если присутствует хоть что-то кроме цифры или латинской буквы
			}				   
			else{
				return true;
			}	
			
			
		}
		return true;
		//print_r($error);exit();
		//return $error;
		
	}
	
	public function getNoLink($string) {	
		$error=true;
		$success = preg_match("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", $string);
		if ($success) {
		  // Обратите внимание, как мы можем здесь добавить ошибку в поле.
		  return false;
			exit();
		}
		$success = preg_match("/(^|[\n ])([\w]*?)((www|ftp)\.[^ \,\"\t\n\r<]*)/is", $string);
		if ($success) { 
		  return false;
			exit();
		}
		$success = preg_match("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", $string);
		if ($success) {  
		  return false;
			exit();
		}
		return true;
	
	}
	
	
}