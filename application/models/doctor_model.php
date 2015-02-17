<?php

class Doctor_model extends CI_Model
{
	function getCountPatient($id_doctor)
	{
		$this->db->select()->from('patient');
		$this->db->where('id_doctor', $id_doctor);
		$query = $this->db->get();
		
		return $query->num_rows();
	}
	
	function getArrayDoctorWithCountPatient($arr_docs)
	{
		$ret_arr = $arr_docs;
		foreach($ret_arr as $doc)
		{
			$doc->count_patient = $this->getCountPatient($doc->id);
		}
		
		return $ret_arr;
	}
	
	function getDashboardAppointmentsData($id_doctor, $date)
	{
		$this->db->where('schedule.schedule_date', $date);
		$this->db->where('schedule.id_doctor', $id_doctor);
		$this->db->select()->from('schedule');
		$this->db->join('appointment_status', 'appointment_status.id=schedule.id');
		$this->db->join('patient', 'patient.name=schedule.patient_name');
		$this->db->order_by('start_time', 'ASC');
		$query = $this->db->get();
		
		return $this->addAdditionalDataFields($query->result());
	}
	
	function addAdditionalDataFields($arr)
	{
		$this->load->model('schedule_model', 's_m');
		$ret_arr = $arr;
		
		foreach($ret_arr as $row)
		{
			$row->converted_time = 
				$this->s_m->convertIdTimeToTime($row->start_time) 
				. '-' .
				$this->s_m->convertIdTimeToTime($row->end_time);
			$row->treatment_status = 
				$this->getTreatmentStatus
				(
					$this->getIdPatient($row->patient_name), 
					$row->schedule_date
				);
			$row->id_patient = $this->getIdPatient($row->patient_name);
		}
		
		return $ret_arr;
	}
	
	function getIdPatient($name)
	{
		$this->db->where('name', $name);
		$query = $this->db->get('patient');
		
		return $query->first_row()->id;
	}
	
	function getTreatmentStatus($id_patient, $date)
	{
		$ret = false;
		$this->db->where('id_patient', $id_patient);
		$this->db->where('date', $date);
		$query = $this->db->get('treatment');
		
		if($query->num_rows() > 0)
		{
			$ret = true;
		}
		
		return $ret;
	}
	
	function getDataTreatments($id_patient)
	{
		$this->db->where('id_patient', $id_patient);
		$query = $this->db->get('treatment');
		
		return $query->result();
	}
	
	function checkIsDoctorPatient($id_patient)
	{
		$ret = false;
		$id_doctor = $this->session->userdata('id_doctor');
		
		$this->db->where('id', $id_patient);
		$this->db->where('id_doctor', $id_doctor);
		$this->db->limit(1);
		$query = $this->db->get('patient');
		
		if($query->num_rows() > 0)
		{
			$ret = true;
		}
		
		return $ret;
	}
	
	function savePatientTreatment($data)
	{
		$this->db->insert('treatment', $data);
		return $this->db->insert_id();
	}
	
	function savePatientRecall($data)
	{
		$this->db->insert('recall_time', $data);
		return $this->db->insert_id();
	}
	
	function updateRecallEntry($data)
	{
		$this->db->where('id', $data['id']);
		$this->db->update('recall_time', $data);
	}
	
	function updateRecallStatus($data)
	{
		$this->db->where('id', $data['id']);
		$this->db->update('recall_time', $data);
	}
	
	function saveAppointmentStatus($data)
	{
		$this->db->where('id', $data['id']);
		$this->db->update('appointment_status', $data);
	}
	
	function changePassword($data)
	{
		$id = $this->session->userdata('id_doctor');
		$this->db->where('id', $id);
		$this->db->update('doctor', $data);
	}
	
	function addImmediateSchedule($data)
	{
		//prepare data utk treatment
		$data_treatment = $data;
		$data_treatment['id_patient'] = $this->getIdPatient($data_treatment['patient_name']);
		$data_treatment['date'] = date('Y-m-d', strtotime($data_treatment['date']));
		unset($data_treatment['patient_name']);
		
		//prepare data utk schedule
		$data_schedule = $data;
		$id = $this->session->userdata('id_doctor');
		$data_schedule['id_doctor'] = $id;
		$data_schedule['schedule_date'] = date('Y-m-d', strtotime($data_schedule['date']));
		$data_schedule['start_time'] = null;
		$data_schedule['end_time'] = null;
		unset($data_schedule['date']);
		unset($data_schedule['treatment']);
		unset($data_schedule['diagnosis']);
		
		//proses data treatment
		$this->db->insert('treatment', $data_treatment);
		
		//proses data schedule
		$this->load->model('schedule_model', 's_m');
		$this->s_m->addSchedule($data_schedule, 1);
	}	
	
	function deleteRecallEntry($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('recall_time');
	}
}

?>