<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Doctor extends CI_Controller
{
	private $base_path;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('auth_model', 'auth_m');
		$this->load->model('patient_model', 'patient_m');
		$this->base_path = base_url() . 'index.php/doctor/';
	}
	
	protected function display($page, $data=array())
	{
		$this->session->set_userdata('current_page', $page);
		
		$data['success'] = $this->session->userdata('success');
		$data['error'] = $this->session->userdata('error');
		
		$this->load->view('template/header', $data);
		$this->load->view('template/top_menu', $data);
		$this->load->view($page, $data);
		$this->load->view('template/footer', $data);
		
		switch($page)
		{
			case 'add_appointment':
				$this->load->view('scripts/script_add_appointment', $data);
				break;
			case 'calendar':
				$this->load->view('scripts/script_calendar', $data);
				break;
			case 'dashboard':
				$this->load->view('scripts/script_dashboard', $data);
				break;
			case 'after_treatment':
				$this->load->view('scripts/script_after_treatment', $data);
				break;
			case 'patient_list':
				$this->load->view('scripts/script_patient_list', $data);
				break;
			case 'add_immediate_appointment':
				$this->load->view('scripts/script_add_immediate_appointment', $data);
				break;
			case 'recall_list':
				$this->load->view('scripts/script_recall_list', $data);				
				break;
			default:
				break;
		}
	}
	
	private function isUserLogin()
	{
		if($this->session->userdata('id_doctor') != null)
		{
			return true;
		}
		else
		{
			redirect(base_url() . 'index.php/doctor/login');
		}
	}
	
	public function index()
	{
		if($this->isUserLogin())
		{
			redirect(base_url() . 'index.php/doctor/dashboard');
		}
	}
	
	public function login()
	{
		if($_POST)
		{
			$result = $this->auth_m->loginDoctor($_POST);
			
			if($result != null)
			{
				$this->session->set_userdata('id_doctor', $result);
				$this->session->set_userdata('username', $_POST['username']);
				redirect(base_url() . 'index.php/doctor');
			}
			else
			{
				$data['alert'] = 'Wrong username or password';
				$this->display('login', $data);
			}
		}
		else
		{
			$this->display('login');
		}
	}
	
	public function patientList()
	{
		if($this->isUserLogin())
		{
			$id_doctor = $this->session->userdata('id_doctor');
			$data['success'] = $this->session->userdata('success');
			$data['error'] = $this->session->userdata('error');
			$data['list_patient'] = $this->patient_m->getAllPatientByDoctor($id_doctor);
			$this->display('patient_list', $data);
		}
	}
	
	public function addPatient($mode = 0)
	{
		if($this->isUserLogin())
		{
			if($_POST)
			{
				$patient_data = $_POST;
				unset($patient_data['schedule_date']);
				unset($patient_data['start_time']);
				unset($patient_data['end_time']);
				
				$return_id = $this->patient_m->addPatient($patient_data);
				if($return_id)
				{
					$this->session->set_userdata('success', 'succesfully add patient ' . $_POST['name']);
				}
				else
				{
					$this->session->set_userdata('error', 'patient already exist');
				}
				
				switch($mode)
				{
					case 1:
						$_POST['patient_name'] = $_POST['name'];
						unset($_POST['name']);
						unset($_POST['telephone_number']);
						$this->registerSchedule($_POST);
						redirect(base_url() . 'index.php/doctor/addAppointment');
						break;
					default:
						redirect(base_url() . 'index.php/doctor/patientList');
						break;
				}	
				
			}
			else
			{
				// tampilkan error
			}
		}
	}
	
	public function editPatient()
	{
		if($this->isUserLogin())
		{
			if($_POST)
			{
				$id_patient = $this->input->post('id_patient', true);
				
				$data = array
				(
					'name' => $this->input->post('name', true),
					'telephone_number' => $this->input->post('telephone_number', true)
				);
				
				$this->patient_m->updatePatient($id_patient, $data);
				$this->session->set_userdata('success', 'patient data has been saved');
				redirect(base_url() . 'index.php/doctor/patientList');
			}
		}
	}
	
	public function removePatient()
	{
		if($this->isUserLogin())
		{
			if($_POST)
			{
				$id_patient = $this->input->post('id_patient', true);
				$this->patient_m->deletePatient($id_patient);
				$this->session->set_userdata('success', 'patient has been deleted');
				redirect(base_url() . 'index.php/doctor/patientList');
			}
		}
	}
	
	public function searchPatient()
	{
		if($this->isUserLogin())
		{
			if($_POST)
			{
				$data['success'] = null;
				$data['error'] = null;
				$id_doctor = $this->session->userdata('id_doctor');
				$data['keyword'] = $this->input->post('keyword', true);
				$data['list_patient'] = $this->patient_m->searchPatient($id_doctor, $data['keyword']);
				
				$this->display('patient_list', $data);
			}
			else
			{
				redirect(base_url() . 'index.php/doctor/patientList');
			}
		}
	}
	
	public function logout()
	{
		$this->session->unset_userdata('id_doctor');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('current_page');
		redirect(base_url() . 'index.php/doctor');
	}
	
	private function retrieveDataFromSession($label)
	{
		$ret = $this->session->userdata($label);
		$this->session->unset_userdata($label);
		return $ret;
	}
	
	private function getDataForAppointmentView($base_date = '', $exception_edit = null)
	{
		$data;
		
		$this->load->model('schedule_model', 'sch_m');
		$id_doctor = $this->session->userdata('id_doctor');
		
		if($base_date == '')
		{
			$base_date = date('Y-m-d', strtotime('monday this week'));
		}
		
		$columnTitles = array();
		
		$last_week = new DateTime(date('Y-m-d', strtotime($base_date)));
		date_modify($last_week, '-1 week');
		$last_week = date_format($last_week, 'Y-m-d');
		
		$next_week = new DateTime(date('Y-m-d', strtotime($base_date)));
		date_modify($next_week, '+1 week');
		$next_week = date_format($next_week, 'Y-m-d');
		
		// isi columnTitles
		for($i = 0; $i < 6; $i++)
		{
			$date = new DateTime($base_date); 
			date_modify($date, '+' . $i . ' day');
			array_push($columnTitles, date_format($date, 'D, d-M-y'));
		}
		
		// get freetime dokter
		$freetime_week = array();
		
		foreach($columnTitles as $tanggal)
		{
			if($exception_edit)
			{
				array_push($freetime_week, $this->sch_m->getDoctorFreeTimes($id_doctor, date('Y-m-d', strtotime($tanggal)), $exception_edit));
			}
			else
			{
				array_push($freetime_week, $this->sch_m->getDoctorFreeTimes($id_doctor, date('Y-m-d', strtotime($tanggal))));
			}
		}
		
		$data['success'] = $this->session->userdata('success');
		$data['error'] = $this->session->userdata('error');
		$data['patient_not_exist'] = $this->session->userdata('patient_not_exist');
		
		$data['columnTitles'] = $columnTitles;
		$data['prevMonday'] = $last_week;
		$data['nextMonday'] = $next_week;
		$data['freetime_week'] = $freetime_week;
		$data['freetime_day_max_count'] = $this->sch_m->getMaxFreetimeArraySize($freetime_week);
		$data['list_patient'] = $this->patient_m->getAllPatientByDoctor($id_doctor);
		
		return $data;
	}
	
	public function addAppointment($base_date = '')
	{
		if($this->isUserLogin())
		{	
			$data = $this->getDataForAppointmentView($base_date);
			
			// data custom utk add appointment
			$data['patient_not_exist'] = $this->retrieveDataFromSession('patient_not_exist');
			$data['telephone_number'] = null;
			$data['patient_name'] = $this->retrieveDataFromSession('patient_name');
			$data['schedule_date'] = $this->retrieveDataFromSession('schedule_date');
			$data['start_time'] = $this->retrieveDataFromSession('start_time');
			$data['end_time'] = $this->retrieveDataFromSession('end_time');	

			$data['type'] = 'add';
			
			$this->display('add_appointment', $data);
		}
	}
	
	public function editAppointment($id_appointment, $base_date = '')
	{
		if($this->isUserLogin())
		{
			
			$this->load->model('schedule_model', 'sch_m');
			$sch_data = $this->sch_m->getSchedule($id_appointment);

			$exception_edit['date'] = $sch_data->schedule_date;
			$exception_edit['start_time'] = $sch_data->start_time;
			$exception_edit['end_time'] = $sch_data->end_time;
			
			$data = $this->getDataForAppointmentView($base_date, $exception_edit);
			
			// data custom utk edit appointment
			$data['patient_not_exist'] = null;
			$data['patient_name'] = $sch_data->patient_name;
			$data['telephone_number'] = $this->patient_m->getPatientNumber($data['patient_name']);
			$data['schedule_date'] = date('D, d-M-y', strtotime($sch_data->schedule_date));
			$data['start_time'] = $sch_data->start_time;
			$data['end_time'] = $sch_data->end_time;

			$data['type'] = 'edit';
			
			$data['id_appointment'] = $id_appointment;
			$data['base_date'] = $base_date;
			
			$this->display('add_appointment', $data);
		}
	}
	
	private function registerSchedule($data, $type = 'add', $id_appointment = '')
	{
		// register schedule-nya
		$this->load->model('schedule_model', 'sch_m');
		
		// verify dulu timenya
		$start_time = $this->sch_m->convertTimeToIdTime($data['start_time']);
		$end_time = $this->sch_m->convertTimeToIdTime($data['end_time']);
		$id_doctor = $this->session->userdata('id_doctor');
		
		if($start_time > $end_time)
		{
			$this->session->set_userdata('error', 'End Time less than Start Time');
		}
		else
		{	
			if($type == 'add')
			{
				if($this->sch_m->validateSchedule($id_doctor, $data))
				{
					$return_id = $this->sch_m->addSchedule($data);
					if($return_id != null)
					{
						$this->session->set_userdata
						(
							'success', 
							'appointment with <b>' . $data['patient_name'] . '</b> at <b>' . $data['start_time'] . '-' . $data['end_time'] . '</b> is created'
						);
					}
					else
					{
						$this->session->set_userdata('error', 'failed to add appointment');
					}
				}
				else
				{
					$this->session->set_userdata('error', 'new schedule is intersect with existing schedule');
				}
			}
			else
			{
				if($this->sch_m->validateSchedule($id_doctor, $data))
				{
					$this->sch_m->editSchedule($id_appointment, $data);
					$this->session->set_userdata
					(
						'success', 
						'appointment with <b>' . $data['patient_name'] . '</b> at <b>' . $data['start_time'] . '-' . $data['end_time'] . '</b> is edited'
					);
				}
				else
				{
					$this->session->set_userdata('error', 'new schedule is intersect with existing schedule');
				}
			}
		}	
	}
	
	public function addAppointment_P($type = 'add', $id_appointment = '', $base_date = '')
	{
		if($this->isUserLogin())
		{
			if($_POST)
			{
				// cek dulu patient exist atau nggak
				$id_doctor = $this->session->userdata('id_doctor');
				if($this->patient_m->isPatientExistByName($id_doctor, $_POST['patient_name']))
				// kalo iya
				{
					if($type == 'add')
					{
						// pasang validasi appointment time disini
						$this->load->model('schedule_model', 's_m');
						if($this->s_m->checkAppointmentTimeValid($_POST))
						{
							$this->registerSchedule($_POST);
						}
						else
						{
							// return error
							$this->session->set_userdata('error', 'Cannot add appointment, schedule time already reserved');
						}
					}
					else
					{
						$this->registerSchedule($_POST, 'edit', $id_appointment);
					}
				}
				else // kalo ternyata patient-nya belum ada
				{
					// kasih notifikasi ke user dan tampilin button ke user
					// kirim juga post-nya
					$this->session->set_userdata('patient_not_exist', true);
					$this->session->set_userdata('patient_name', $_POST['patient_name']);
					$this->session->set_userdata('schedule_date', $_POST['schedule_date']);
					$this->session->set_userdata('start_time', $_POST['start_time']);
					$this->session->set_userdata('end_time', $_POST['end_time']);
				}
				
				if($type == 'add')
				{
					redirect($this->base_path . 'addAppointment');
				}
				else
				{
					redirect($this->base_path . 'editAppointment/' . $id_appointment . '/' . $base_date);
				}
			}
		}
	}
	
	public function deleteAppointment($id, $dashboard = null)
	{
		if($this->isUserLogin())
		{
			$this->load->model('schedule_model', 'sch_m');
			$this->sch_m->removeSchedule($id);
			
			if($dashboard)
			{
				redirect($this->base_path . 'dashboard/' . $dashboard);
			}
			else
			{
				redirect($this->base_path . 'calendar');
			}
		}
	}
	
	public function calendar()
	{
		if($this->isUserLogin())
		{
			$this->load->model('schedule_model', 'sch_m');
			$id_doctor = $this->session->userdata('id_doctor');
			$data['list_appointment'] = $this->sch_m->getAllAppointmentbyDoctor($id_doctor);
			$data['all_available_time'] = $this->sch_m->getAllAvailableTime();
			$data['doctor_available_time'] = $this->sch_m->getDoctorAvailableTime($id_doctor);
			$this->display('calendar', $data);
		}
	}
	
	public function set_doctor_available_time()
	{
		if($this->isUserLogin())
		{
			if($_POST)
			{
				$id_doctor = $this->session->userdata('id_doctor');
				$this->load->model('schedule_model', 'sch_m');
				$this->sch_m->setDoctorAvailableTime($id_doctor, $_POST);
				$this->session->set_userdata('success', 'Doctor available time has been set');
			}
			
			redirect($this->base_path . 'calendar');
		}
	}

	public function dashboard($date = null)
	{
		if($this->isUserLogin())
		{

			$this->load->model('doctor_model', 'd_m');
			if(!$date)
			{
				$date = date('Y-m-d', strtotime('now'));
			}
			
			$id = $this->session->userdata('id_doctor');
			$data['appointments'] = $this->d_m->getDashboardAppointmentsData($id, $date);
			$data['date'] = $date;
			
			$nextDate = new DateTime(date('Y-m-d', strtotime($date)));
			date_modify($nextDate, '+1 day');
			$nextDate = date_format($nextDate, 'Y-m-d');
			
			$prevDate = new DateTime(date('Y-m-d', strtotime($date)));
			date_modify($prevDate, '-1 day');
			$prevDate = date_format($prevDate, 'Y-m-d');
			
			$data['success'] = $this->session->userdata('success');
			$data['error'] = $this->session->userdata('error');
			
			$data['nextDate'] = $nextDate;
			$data['prevDate'] = $prevDate;
			
			$this->display('dashboard', $data);
		}
	}
	
	public function after_treatment($id_patient = 0)
	{
		if($this->isUserLogin())
		{
			$this->load->model('doctor_model', 'd_m');
			if($this->d_m->checkIsDoctorPatient($id_patient))
			{
				$data['patient'] = $this->patient_m->getPatient($id_patient);
				$data['treatments'] = $this->d_m->getDataTreatments($id_patient);
				$this->display('after_treatment', $data);
			}
			else
			{
				redirect($this->base_path . 'dashboard');
			}
		}
	}
	
	public function addTreatment_P($data = null)
	{
		$ret;
		if($this->isUserLogin())
		{
			
			$this->load->model('doctor_model', 'd_m');
			$id = $this->session->userdata('id_doctor');
			
			if($data)
			{
				unset($data['week']);
				unset($data['month']);
				unset($data['year']);
					
				// ini kali di-supply pake parameter
				$ret = $this->d_m->savePatientTreatment($data);
			}
			else
			{
				if($_POST)
				{
					unset($_POST['week']);
					unset($_POST['month']);
					unset($_POST['year']);
					
					$ret = $this->d_m->savePatientTreatment($_POST);
					redirect($this->base_path . 'dashboard');
				}
			}
		}
		
		return $ret;
	}
	
	public function changeAppointmentStatus_P()
	{
		if($this->isUserLogin())
		{
			if($_POST)
			{
				$this->load->model('doctor_model', 'd_m');
				$this->d_m->saveAppointmentStatus($_POST);
			}
		}
	}
	
	public function editTreatment_P()
	{
		if($this->isUserLogin())
		{
			$this->load->model('schedule_model', 's_m');
			$this->s_m->editTreatment($_POST);
		}
		
		redirect($this->base_path . 'after_treatment/' . $_POST['id_patient']);
	}
	
	public function removeTreatment_P($id)
	{
		if($this->isUserLogin())
		{
			$this->load->model('schedule_model', 's_m');
			$id_patient = $this->s_m->removeTreatment($id);
			redirect($this->base_path . 'after_treatment/' . $id_patient);
		}
	}
	
	public function changePassword_P()
	{
		if($this->isUserLogin())
		{
			$this->load->model('doctor_model', 'd_m');
			$this->d_m->changePassword($_POST);
			$this->session->set_userdata('success', 'Successfully change password');
		}
		
		redirect($this->base_path . 'dashboard');
	}
	
	/*
		Fungsi untuk immediate appointment
	*/
	
	public function addImmediateAppointment($prev_data = null)
	{
		if($this->isUserLogin())
		{
			if($_POST)
			{
				$data['prev_data'] = $prev_data;
			}
			
			$id_doctor = $this->session->userdata('id_doctor');
			$data['list_patient'] = $this->patient_m->getAllPatientByDoctor($id_doctor);
			$this->display('add_immediate_appointment', $data);
		}
	}
	
	public function addImmediateAppointment_P()
	{
		$this->load->model('doctor_model', 'd_m');
		
		$id_doctor = $this->session->userdata('id_doctor');
		$name = $_POST['patient_name'];
		
		if($this->patient_m->isPatientExistByName($id_doctor, $name)) {
			$this->d_m->addImmediateSchedule($_POST);
			$this->session->set_userdata('success', 'Successfully add patient');
			redirect($this->base_path . 'dashboard');
		} else {
			$this->session->set_userdata('error', 'Patient is not registered, please register patient first');
			$this->addImmediateAppointment($_POST);
		}
		
	}
	
	public function addImmediateAppointmentNewPatient_P()
	{	
		/*
			prepare data utk add patient
		*/
		$patient = $_POST;
		unset($patient['patient_name']);
		unset($patient['date']);
		unset($patient['diagnosis']);
		unset($patient['treatment']);
		
		$this->patient_m->addPatient($patient);
		
		/*
			prepare data utk add immediate schedule
		*/
		$schedule = $_POST;
		unset($schedule['id_doctor']);
		unset($schedule['name']);
		unset($schedule['telephone_number']);
		
		$this->load->model('doctor_model', 'd_m');
		$this->d_m->addImmediateSchedule($schedule);
		
		$this->session->set_userdata('success', 'Successfully add patient');
		redirect($this->base_path . 'dashboard');
	}
	
	public function recallList()
	{
		$id_doctor = $this->session->userdata('id_doctor');
		$data['success'] = $this->session->userdata('success');
		$data['error'] = $this->session->userdata('error');
		$data['list_recall'] = $this->patient_m->getRecallListByDoctor($id_doctor);
		//$this->debug($data['list_recall']);
		$this->display('recall_list', $data);
	}
	
	public function addTreatmentWithRecall_P($mode = 0)
	{
		switch($mode)
		{
			case 0:
				$id_treatment = $this->addTreatment_P($_POST);
				$_POST['id'] = $id_treatment;
				$this->addRecall_P($_POST);
				redirect($this->base_path . 'dashboard');
				break;
			case 1:
				break;
		}
	}
	
	private function debug($data)
	{
		echo "<pre>";
		var_dump($data);
		echo "</pre>";	
	}
	
	private function addRecall_P($param)
	{
		$data['id'] = $param['id'];
		$data['id_doctor'] = $id_doctor = $this->session->userdata('id_doctor');
		$data['id_patient'] = $param['id_patient'];
		$data['week'] = $param['week'];
		$data['month'] = $param['month'];
		$data['year'] = $param['year'];
		
		$this->load->model('doctor_model', 'd_m');
		return $this->d_m->savePatientRecall($data);
	}

	public function changeRecallStatus_P()
	{
		if($_POST)
		{
			
			$this->load->model('doctor_model', 'd_m');
			$this->d_m->updateRecallStatus($_POST);
		}
	}
	
	public function deleteRecallEntry_P($id)
	{
		$this->load->model('doctor_model', 'd_m');
		$this->d_m->deleteRecallEntry($id);
		redirect($this->base_path . 'recallList');
	}
	
	public function updateRecallTime_P()
	{
		$this->load->model('doctor_model', 'd_m');
		$this->d_m->updateRecallEntry($_POST);
		redirect($this->base_path . 'recallList');
	}
}

?>