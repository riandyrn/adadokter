<?php

class Common_Controller extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	private function setUserLoginData($id, $username, $account_type)
	{
		$this->session->set_userdata('id_' . $account_type, $id);
		$this->session->set_userdata('username_' .$account_type, $username);
	}
	
	private function unsetUserLoginData($account_type)
	{
		$this->session->unset_userdata('id_' . $account_type);
		$this->session->unset_userdata('username_' .$account_type);
	}
	
	private function isUserLogin($account_type)
	{
		return ($this->session->userdata('id_' . $account_type) != null);
	}
	
	protected function checkUserHasLogin($false_path, $account_type = 'user')
	{
		if(!$this->isUserLogin($account_type))
		{
			redirect($false_path);
		}
	}
	
	protected function getIdCurrentUser($account_type = 'user')
	{
		return $this->session->userdata('id_' . $account_type);
	}
	
	protected function getUsernameCurrentUser($account_type = 'user')
	{
		return $this->session->userdata('username_' . $account_type);
	}
	
	protected function login($table_name, $data, $account_type = 'user')
	{
		$this->load->model('login_model');
		
		$return_id = $this->login_model->login($table_name, $data);
		if($return_id != null)
		{
			$this->setUserLoginData($return_id, $data['username'], $account_type);
		}
		
		return $return_id;
	}
	
	protected function logout($account_type = 'user')
	{
		$this->unsetUserLoginData($account_type);
		$this->unsetCurrentPage();
	}
	
	protected function display($path, $page, $data=array())
	{
		$this->setCurrentPage($page);
		$this->load->view($path . '/' . 'template/header');
		$this->load->view($path . '/' .'template/menu');
		$this->load->view($path . '/' .$page, $data);
		$this->load->view($path . '/' .'template/footer');
	}
	
	protected function displayLogin($path, $data=array())
	{
		$this->load->view($path . '/' . 'login', $data);
	}
	
	private function setCurrentPage($page)
	{
		$this->session->set_userdata('current_page', $page);
	}
	
	private function unsetCurrentPage()
	{
		$this->session->unset_userdata('current_page');
	}
	
	protected function setMessageToSession($label, $message)
	{
		/*
			hati2 menggunakan ini, ingat session di CI
			ada batasan ukurannya.
		*/
		$this->session->set_userdata($label, $message);
	}
	
	protected function getMessageFromSession($label)
	{
		return $this->session->userdata($label);
	}
	
	protected function unsetMessageFromSession($label)
	{
		$this->session->unset_userdata($label);
	}
}

?>