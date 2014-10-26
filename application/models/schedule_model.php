<?php

class Schedule_model extends CI_Model
{
	function getAllAppointmentByDoctor($id_doctor)
	{
		$this->db->where('id_doctor', $id_doctor);
		$this->db->select()->from('schedule');
		$query = $this->db->get();
		
		return $this->getAllAppointmentWithTime($query->result());
	}
	
	function getAllAppointmentWithTime($arr)
	{
		$ret = $arr;
		foreach($ret as $el)
		{
			$el->start_time = $this->convertIdTimeToTime($el->start_time);
			$el->end_time = $this->convertIdTimeToTime($el->end_time);
		}
		
		return $ret;
	}
	
	function getInclusiveInterval($start, $end)
	{
		/*
			ini untuk tampilan yg di free schedule
		*/
		
		$ret_array = array();
		for($i=$start+1; $i<$end; $i++)
		{
			array_push($ret_array, $i);
		}
		
		return $ret_array;
	}
	
	function getAllScheduleByDoctor($id_doctor, $date)
	{
		$date = date('Y-m-d', strtotime($date));
		$this->db->where('id_doctor', $id_doctor);
		$this->db->where('schedule_date', $date);
		$this->db->select()->from('schedule');
		$query = $this->db->get();
		
		return $query->result();
	}
	
	function getDoctorFreeTimes($id_doctor, $date, $exception_edit = null)
	{

		if($data = $this->getDoctorAvailableTime($id_doctor))
		{
			$finish_hour = $this->convertTimeToIdTime($data->finish_hour) + 1;
			$start_hour = $this->convertTimeToIdTime($data->start_hour);
		}
		else
		{
			$finish_hour = 48;
			$start_hour = 0;
		}
		
		// init freetime array
		$freetime_array = array(); //isinya bakalan semisal 1, 2, 3, 4, ....
		$interval = null;
		
		for($i=$start_hour; $i < $finish_hour; $i++)
		{
			array_push($freetime_array, $i);
		}
		
		$doctor_schedule = $this->getAllScheduleByDoctor($id_doctor, $date);
		
		foreach($doctor_schedule as $schedule)
		{
			if($exception_edit)
			{
				// kalo editnya di tanggal itu
				if($exception_edit['date'] == $date)
				{
					//jgn di process
				}
				else
				{
					// dapatkan start_time & end_time
					$start_time = $schedule->start_time;
					$end_time = $schedule->end_time;
					
					// get inclusive interval
					$interval = $this->getInclusiveInterval($start_time, $end_time);
					
					// remove inclusive interval dr free time array
					$freetime_array = array_diff($freetime_array, $interval);				
				}
			}
			else
			{
				// dapatkan start_time & end_time
				$start_time = $schedule->start_time;
				$end_time = $schedule->end_time;
				
				// get inclusive interval
				$interval = $this->getInclusiveInterval($start_time, $end_time);
				
				// remove inclusive interval dr free time array
				$freetime_array = array_diff($freetime_array, $interval);
				
				/*if($freetime_array[0] == $schedule->start_time)
				{
					unset($freetime_array[0]);
				}*/
			}

		}
		
		/*echo '<pre>';
		var_dump($freetime_array);
		echo '</pre>';*/
		
		return $this->convertFreeTimeArrToTimeArr($freetime_array); 
	}
	
	function getMaxFreetimeArraySize($freetime_week)
	{
		$max = 0;
		
		foreach($freetime_week as $freetime_day)
		{
			if($max < count($freetime_day))
			{
				$max = count($freetime_day);
			}
		}
		
		return $max;
	}
	
	function convertFreeTimeArrToTimeArr($freetime_arr)
	{
		$ret_array = array();
		foreach($freetime_arr as $id_time)
		{
			array_push($ret_array, $this->convertIdTimeToTime($id_time));
		}
		
		return $ret_array;
	}
	
	function addSchedule($data, $appointment_status = 0)
	{
		$data['schedule_date'] = date('Y-m-d', strtotime($data['schedule_date']));
		$data['start_time'] = $this->convertTimeToIdTime($data['start_time']);
		$data['end_time'] = $this->convertTimeToIdTime($data['end_time']);
		$this->db->insert('schedule', $data);
		
		$id = $this->db->insert_id();
		$this->addAppointmentStatus($id, $appointment_status);
		return $id;
	}
	
	function addAppointmentStatus($id, $appointment_status = 0)
	{
		$data['id'] = $id;
		$data['status'] = $appointment_status;
		$this->db->insert('appointment_status', $data);
	}
	
	function removeSchedule($id)
	{
		/*
			delete dulu appointment_status
		*/
		$this->db->where('id', $id);
		$this->db->delete('appointment_status');
		
		/* 
			baru delete schedulenya
		*/
		$this->db->where('id', $id);
		$this->db->delete('schedule');
	}
	
	function convertTimeToIdTime($time)
	{
		$this->db->where('time', $time);
		$this->db->select('id')->from('time_convert');
		$query = $this->db->get();
		
		return $query->first_row()->id;
	}
	
	function convertIdTimeToTime($id)
	{
		$this->db->where('id', $id);
		$this->db->select('time')->from('time_convert');
		$query = $this->db->get();
		
		return $query->first_row()->time;
	}

	function getSchedule($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('schedule');
		
		$data = $query->first_row();
		$data->start_time = $this->convertIdTimeToTime($data->start_time);
		$data->end_time = $this->convertIdTimeToTime($data->end_time);
		
		return $data;
	}
	
	function editSchedule($id_appointment, $data)
	{
		$data['schedule_date'] = date('Y-m-d', strtotime($data['schedule_date']));
		$data['start_time'] = $this->convertTimeToIdTime($data['start_time']);
		$data['end_time'] = $this->convertTimeToIdTime($data['end_time']);
		$this->db->where('id', $id_appointment);
		$this->db->update('schedule', $data);
	}
	
	function getAllAvailableTime()
	{
		/* 	
			fungsi ini return seluruh waktu yg
			mungkin dipakai oleh seorang dokter 
		*/
		
		$query = $this->db->get('time_convert');
		return $query->result();
	}
	
	function getDoctorAvailableTime($id_doctor)
	{
		/* 
			fungsi ini return waktu start_time dan
			finish_time dari seorang dokter
		*/
		
		$this->db->where('id', $id_doctor);
		$query = $this->db->get('doctor_available_schedule');
		
		$data = null;
		if($query->num_rows() > 0)
		{
			$data = $query->first_row();
			$data->start_hour = $this->convertIdTimeToTime($data->start_hour);
			$data->finish_hour = $this->convertIdTimeToTime($data->finish_hour);
		}
		
		return $data;
	}
	
	function setDoctorAvailableTime($id_doctor, $data)
	{
		/* 
			Fungsi ini akan set start_time dan finish_time
			dari seorang dokter, kalo datanya belum ada
			fungsi ini akan create. kalo udah ada bakalan update
		*/
		
		$table = 'doctor_available_schedule';
		
		$this->db->where('id', $id_doctor);
		$check_query = $this->db->get($table);
		
		// cek udah ada datanya atau belum
		if($check_query->num_rows() > 0)
		// kalo udah
		{
			// update data
			$this->db->where('id', $id_doctor);
			$this->db->update($table, $data);
		}
		else // kalo belum
		{
			// insert data
			$data['id'] = $id_doctor;
			$this->db->insert($table, $data);
		}
		
	}
	
	function getArrTimeScheduleOfDoctor($date, $id_doctor)
	{
		$date = date('Y-m-d', strtotime($date));
		$this->db->where('id', $id_doctor);
		$this->db->where('schedule_date', $date);
		$this->db->select('start_time, end_time');
		$query = $this->db->get('schedule');
		
		return $query->result();
	}
	
	function validateSchedule($id_doctor, $data)
	{
		/* 
			Fungsi ini akan validate schedule yang
			akan dimasukkan. Apakah tabrakan sama
			jadwal yang udah ada atau enggak
		*/
		
		$ret = true;
				
		$arr_time = $this->getArrTimeScheduleOfDoctor($data['schedule_date'], $id_doctor);
		
		$start_new = $data['start_time'];
		$end_new = $data['end_time'];
		
		foreach($arr_time as $time)
		{
			$start_old = $time->start_time;
			$end_old = $time->end_time;
			
			$con_1 = $start_new < $end_old;
			$con_2 = $start_old < $end_new;
			$con_3 = ($start_new < $start_old) && ($end_old < $new_end);
			$con_4 = ($start_old < $start_new) && ($end_new < $end_old); 
			
			if($con_1 || $con_2 || $con_3 || $con_4)
			{
				$ret = false;
			}
		}
		
		return $ret;
	}
	
	function editTreatment($data)
	{
		$this->db->where('id', $data['id']);
		$this->db->update('treatment', $data);
	}
	
	function removeTreatment($id)
	{	
		$this->db->where('id', $id);
		$query = $this->db->get('treatment');
		
		$id_patient = $query->first_row()->id_patient;
		
		$this->db->where('id', $id);
		$this->db->delete('treatment');
		
		return $id_patient;
	}
	
	function checkAppointmentTimeValid($data)
	{
		/*
			appointment time bakalan valid
			kalo dia nggak tabrakan sama waktu
			yang lain (hrs distinct)
		*/
		
		$ret = true;
		
		$id_doctor = $this->session->userdata('id_doctor');
		$date = date('Y-m-d', strtotime($data['schedule_date']));
		$start_time = $this->convertTimeToIdTime($data['start_time']);
		$end_time = $this->convertTimeToIdTime($data['end_time']);
		
		$this->db->where('id_doctor', $id_doctor);
		$this->db->where('schedule_date', $date);
		$query = $this->db->get('schedule');
		$result = $query->result();
		
		foreach($result as $row)
		{
			if
			(
				(($start_time < $row->start_time) && ($end_time >= $row->end_time)) ||
				(($start_time < $row->end_time) && ($end_time > $row->start_time)) ||
				(($row->start_time < $end_time) && ($start_time < $row->end_time))
			)
			{
				$ret = false;
			}
		}
		
		return $ret;
	}
}

?>