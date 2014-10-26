<?php

class Patient_model extends CI_Model
{
	function getAllPatientByDoctor($id_doctor)
	{
		$this->db->select()->from('patient');
		$this->db->where('id_doctor', $id_doctor);
		$query = $this->db->get();
		
		return $query->result();
	}
	
	function searchPatient($id_doctor, $keyword)
	{
		$this->db->select()->from('patient');
		$this->db->where('id_doctor', $id_doctor);
		$this->db->like('name', $keyword);
		$query = $this->db->get();
		
		return $query->result();
	}
	
	function getPatient($id_patient)
	{
		$this->db->select()->from('patient');
		$this->db->where('id', $id_patient);
		$query = $this->db->get();
		
		return $query->first_row();
	}
	
	function isPatientExistByName($id_doctor, $patient_name)
	{
		$ret = false;
		$this->db->select()->from('patient');
		$this->db->where('id_doctor', $id_doctor);
		$this->db->where('name', $patient_name);
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			$ret = true;
		}
		
		return $ret;
	}
	
	function deletePatient($id_patient)
	{
		/*
			hapus seluruh schedule
		*/
		$this->deleteAllScheduleOfPatient($id_patient);
		
		/*
			hapus seluruh treatment
		*/
		$this->db->where('id_patient', $id_patient);
		$this->db->delete('treatment');
		
		/* 
			baru hapus user
		*/
		$this->db->where('id', $id_patient);
		$this->db->delete('patient');
	}
	
	function deleteAllScheduleOfPatient($id_patient)
	{
		/*
			get seluruh schedule patient
			dulu
		*/
		$name = $this->getPatientName($id_patient);
		$this->db->where('patient_name', $name);
		$result = $this->db->get('schedule')->result();
		
		/* 
			lakukan iterasi terhadap seluruh
			schedule patient lalu delete appointment_status
		*/
		foreach($result as $row)
		{
			$this->db->where('id', $row->id);
			$this->db->delete('appointment_status');
		}
		
		/*
			delete seluruh schedule patient
		*/
		$this->db->where('patient_name', $name);
		$this->db->delete('schedule');
	}
	
	function getPatientName($id_patient)
	{
		$this->db->where('id', $id_patient);
		$query = $this->db->get('patient');
		
		return $query->first_row()->name;
	}
	
	function getPatientNumber($name)
	{
		$id_doctor = $this->session->userdata('id_doctor');
		$this->db->where('id_doctor', $id_doctor);
		$this->db->where('name', $name);
		$query = $this->db->get('patient');
		
		return $query->first_row()->telephone_number;
	}
	
	function addPatient($data)
	{
		$ret = null;
		$id_doctor = $this->session->userdata('id_doctor');
		$patient_name = $data['name'];
		
		if(!($this->isPatientExistByName($id_doctor, $patient_name))) {
			$this->db->insert('patient', $data);
			$ret = $this->db->insert_id();
		}
		
		return $ret;
	}
	
	function updatePatient($id_patient, $data)
	{
		$this->db->where('id', $id_patient);
		$this->db->update('patient', $data);
	}
}

?>