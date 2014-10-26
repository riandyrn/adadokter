<?php

class Auth_model extends CI_Model
{
	function loginDoctor($data)
	{
		$ret = null;
		
		$this->db->select()->from('doctor');
		$this->db->where('username', $data['username']);
		$this->db->where('password', $data['password']);
		$this->db->limit(1);
		
		$query = $this->db->get();
		if($query->num_rows()==1)
		{
			$ret = $query->first_row()->id;
		}
		
		return $ret;
	}
}

?>