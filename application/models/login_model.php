<?php

class Login_model extends CI_Model
{

	function login($table, $data)
	{
		$login_id = null;
		
		$this->db->where('username', $data['username']);
		$this->db->where('password', $data['password']);
		//$this->db->where('password', md5($data['password']));
		$this->db->select()->from($table);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if($query->num_rows() == 1)
		{
			$login_id = $query->first_row()->id;
		}
		
		return $login_id;
	}
}

?>