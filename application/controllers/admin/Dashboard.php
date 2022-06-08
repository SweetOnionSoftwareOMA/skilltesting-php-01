<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Auth_Controller {

	protected $_viewRoot  = 'admin/dashboard/';
	protected $_modelRoot = 'admin/';
	protected $_routeRoot = 'admin/dashboard/';
	protected $_homeRoute = 'index';

	public function __construct()
	{
		parent::__construct();
		$this->load->model($this->_modelRoot . 'Model_offices', 'm_offices');
		$this->load->model($this->_modelRoot . 'Model_roles', 'm_roles');
		$this->load->model($this->_modelRoot . 'Model_users', 'm_users');
		$this->data['subNavBar']      = 'admin/nav_admin';
		$this->data['templateStyle']  = 'sidebar';
	}

	public function index()
	{
		$data = &$this->data;
		$data['pageFunction']        = '';
		$data['pageClass']           = 'hold-transition sidebar-mini dark-mode';
		$data['primaryView']         = $this->_viewRoot . $this->_homeRoute;
		$data['pageTitle']           = 'Admin Dashboard :: MTM Reporting';
		$data['name']                = $this->session->userdata('name');
		$data['heading']             = 'Welcome, '.$data['name'].'.';
		$data['subHeading']          = 'Great to see you!';
		$data['pageDescription']     = 'Here what\'s happening in your account today.';
		$data['breadcrumb']          = array('#' => 'Dashboard');
		$data['total_offices']		 = $this->m_offices->getOfficesCount(false, '');
		$data['total_users']		 = $this->m_users->getUsersCount(false, '');
		$data['total_roles']		 = $this->m_roles->getRolesCount(false, '');
		$data['total_forms']		 = 3;
		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}
}

/* End of file Dashboard.php */
