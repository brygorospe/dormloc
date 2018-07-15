<?php 

class Dorm_model extends MY_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	function form_insert($data){
		$this->db->insert('dorms', $data);
		$insert_id = $this->db->insert_id();
		
		return $insert_id;
	}
}