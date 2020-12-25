<?php
class ModelModuleForm extends Model {
	public function saveForm($title,$body) {
	
		$this->db->query("INSERT INTO `" . DB_PREFIX . "form` SET title = '" . $this->db->escape($title) . "', body = '" . $this->db->escape($body) . "', date_added = NOW()");
		return true;
	}
	 public function getLastId()
    {
       $query =$this->db->query("SELECT id_form FROM ".DB_PREFIX."form ORDER BY id_form DESC  LIMIT 1");
       return ($query->num_rows < 1) ? false : $query->row['id_form'];
    }	
	
}