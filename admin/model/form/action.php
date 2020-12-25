<?php
class ModelFormAction extends Model {
	
	public function getFomrs($data = array()) {
		
		$sql = "SELECT * FROM " . DB_PREFIX . "form ";	

		$sql .= " ORDER BY 	date_added";

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}


	public function getTotalForms($data = array()) {
    $sql = "SELECT COUNT(DISTINCT id_form) AS total FROM " . DB_PREFIX . "form ";	

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	
	public function deleteForm($form_id) {	

		$this->db->query("DELETE FROM " . DB_PREFIX . "form WHERE id_form = '" . (int)$form_id . "'");	

		
	}

	
}
