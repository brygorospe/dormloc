<?php 

class Group_model extends MY_Model {

	function get_group_id($user_id){
		$query = $this->db->get_where('admin_users_groups', array('user_id' => $user_id), 1);

		foreach ($query->result() as $row)
		{
			$user_group = $row->group_id;
		}

		return $user_group;
	}
}