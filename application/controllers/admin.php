<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Common_Controller
{
	private $base_path;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('general_model', 'gen_m');
		$this->base_path = base_url() . 'index.php/admin/';
	}
	
	protected function display($page, $data=array())
	{
		parent::display('admin', $page, $data);
	}
	
	protected function checkUserHasLogin()
	{
		parent::checkUserHasLogin($this->base_path, 'admin');
	}
	
	public function index()
	{
		if(parent::getIdCurrentUser('admin') != null)
		{
			$this->load->model('doctor_model', 'd_m');
			$data['error'] = parent::getMessageFromSession('error');
			$data['success'] = parent::getMessageFromSession('success');
			$data['list_doctor'] = $this->d_m->getArrayDoctorWithCountPatient($this->gen_m->getAllData(TABEL_DOKTER)); 
			$this->display('doctor_list', $data);
		}
		else
		{
			if($_POST)
			{
				$ret_id = parent::login(TABEL_ADMIN, $_POST, 'admin');
				if($ret_id)
				{
					redirect($this->base_path);
				}
				else
				{	
					$data['error'] = 'wrong username or password';
					$this->display('login', $data);
				}
			}
			else
			{
				$this->display('login');
			}
		}
	}
	
	public function addDoctor()
	{
		$this->checkUserHasLogin();
		if($_POST)
		{
			$return_id = $this->gen_m->insertData(TABEL_DOKTER, $_POST);
			if($return_id)
			{
				parent::setMessageToSession('success', 'doctor ' . $_POST['username'] . ' sucessfully added');
			}
			else
			{
				parent::setMessageToSession('error', 'failed to add doctor');
			}
			redirect($this->base_path);
		}
	}
	
	public function editDoctor($id_doctor)
	{
		$this->checkUserHasLogin();
		if($_POST)
		{
			$this->gen_m->updateData(TABEL_DOKTER, $id_doctor, $_POST);
			parent::setMessageToSession('success', 'update data has been performed');
			redirect($this->base_path);
		}
	}
	
	public function changePassword_P()
	{
		$this->checkUserHasLogin();
		if($_POST)
		{
			$id_doctor = parent::getIdCurrentUser('admin');
			$this->gen_m->updateData(TABEL_ADMIN, $id_doctor, $_POST);
			parent::setMessageToSession('success', 'account data has been changed');
			redirect($this->base_path);
		}
	}
	
	public function deleteDoctor($id_doctor)
	{
		$this->checkUserHasLogin();
		$this->gen_m->deleteData(TABEL_DOKTER, $id_doctor);
		parent::setMessageToSession('success', 'doctor has been deleted');
		redirect($this->base_path);
	}
	
	public function logout()
	{
		parent::logout('admin');
		redirect($this->base_path);
	}
}

?>