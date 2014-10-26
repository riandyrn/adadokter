<?php

class General_model extends CI_Model
{
	
	function getAllData($table, $field_selected='*', $where_field = null, $where_condition = null)
	{
		$this->db->select($field_selected)->from($table);
		if(($where_field != null) && ($where_condition != null))
		{
			$this->db->where($where_field, $where_condition);
		}
		$query = $this->db->get();
		return $query->result();
	}
	
	function getJoinTable($table_1, $table_2, $identifier_1, $identifier_2, $select_param = '*')
	{
		$this->db->select($select_param)->from($table_1);
		$this->db->join($table_2, $identifier_1 . '=' . $identifier_2);
		$query = $this->db->get();
		
		return $query->result();
	}
	
	function getFirstRowOfJoinTable($table_1, $table_2, $identifier_1, $identifier_2, $select_param = '*', $where_field = null, $where_condition = null)
	{
		$this->db->limit(1);
		$this->db->select($select_param)->from($table_1);
		$this->db->join($table_2, $identifier_1 . '=' . $identifier_2);
		if(($where_field != null) && ($where_condition !=null))
		{
			$this->db->where($where_field, $where_condition);
		}
		$query = $this->db->get();
		
		return $query->first_row();
	}
	
	function getData($table, $id)
	{
		$this->db->where('id', $id);
		$this->db->select()->from($table);
		$query = $this->db->get();
		
		return $query->first_row();
	}
	
	function deleteData($table, $id)
	{
		$this->db->where('id', $id);
		$this->db->delete($table);
	}
	
	function insertData($table, $data)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}
	
	function updateData($table, $id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update($table, $data);
	}
	
	function getMultipleData($table, $id_field_name, $id)
	{
		/*  
			ini fungsi untuk return yg id-nya
			nggak unik/ada dua/> primary key, 
			biasanya utk table relationship
		*/
		
		$this->db->where($id_field_name, $id);
		$this->db->select()->from($table);
		$query = $this->db->get();
		
		return $query->result();
	}
	
	/* 
		fungsi-fungsi ini dipake utk id yg
		field name-nya nggak id atau dia
		terkait sm data di table lain, misal 
		di table setoran
	*/
	
	function getDataCustomId($table, $id_field_name, $id)
	{
		$this->db->where($id_field_name, $id);
		$this->db->select()->from($table);
		$query = $this->db->get();
		
		return $query->first_row();
	}
	
	function deleteDataCustomId($table, $id_field_name, $id)
	{
		$this->db->where($id_field_name, $id);
		$this->db->delete($table);
	}
	
	function updateDataCustomId($table, $id_field_name, $id, $data)
	{
		$this->db->where($id_field_name, $id);
		$this->db->update($table, $data);
	}
	
}

?>