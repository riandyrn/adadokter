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
	
	function getRecallListByDoctor($id_doctor)
	{
		$this->db->select()->from('patient');
		$this->db->where('patient.id_doctor', $id_doctor);
		$this->db->join('recall_time', 'patient.id = recall_time.id_patient');
		
		/*** Add +/- 2 week(s) to recallList ***/
		$num = 2;
		
		$date_two_weeks_ago = date('Y-m-d', strtotime('-' . $num . ' week'));
		$date_two_weeks_later = date('Y-m-d', strtotime('+' . $num . ' week'));
		
		$year_two_weeks_ago = date('Y', strtotime($date_two_weeks_ago));
		$year_two_weeks_later = date('Y', strtotime($date_two_weeks_later));
		
		$month_two_weeks_ago = date('m', strtotime($date_two_weeks_ago));
		$month_two_weeks_later = date('m', strtotime($date_two_weeks_later));
		
		$week_two_weeks_ago = getWeeks($date_two_weeks_ago, "sunday");
		$week_two_weeks_later = getWeeks($date_two_weeks_later, "sunday");
		
		$baseline_two_weeks_ago = strtotime($year_two_weeks_ago . '-' . $month_two_weeks_ago . '-' . $week_two_weeks_ago);
		$baseline_two_weeks_later = strtotime($year_two_weeks_later . '-' . $month_two_weeks_later . '-' . $week_two_weeks_later);
		
		/*** select +/- 2 week(s) from db ***/
		$this->db->where('recall_time.baseline >=', $baseline_two_weeks_ago);
		$this->db->where('recall_time.baseline <=', $baseline_two_weeks_later);
		
		/*** order ascending ***/
		$this->db->order_by('recall_time.baseline', 'asc');
		
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