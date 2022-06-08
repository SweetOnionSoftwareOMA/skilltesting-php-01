<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Auth_Controller {

	protected $_viewRoot  = 'app/dashboard/';
	protected $_modelRoot = 'app/';
	protected $_routeRoot = 'app/dashboard/';
	protected $_homeRoute = 'index';

	public function __construct()
	{
		parent::__construct();
		$this->load->model($this->_modelRoot . 'Model_forms', 'm_forms');
		$this->load->model($this->_modelRoot . 'Model_location_form_data', 'm_location_form_data');
		$this->data['subNavBar']      = 'app/nav_primary';
		$this->data['templateStyle']  = 'sidebar';
	}

	public function index()
	{
		$data = &$this->data;
		$data['pageFunction']        = '';
		$data['pageClass']           = 'hold-transition sidebar-mini';
		$data['primaryView']         = $this->_viewRoot . $this->_homeRoute;
		$data['pageTitle']           = 'Dashboard :: MTM Reporting';
		$data['name']                = $this->session->userdata('name');
		$data['heading']             = 'Welcome, '.$data['name'].'.';
		$data['subHeading']          = 'Great to see you!';
		$data['pageDescription']     = '';
		$data['breadcrumb']          = array('#' => 'Dashboard');
		$data['offices'] 			 = $this->session->userdata('user_offices');
		$data['office_stats']		 = $this->m_location_form_data->getAllOfficesStats()->result();
		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}
}

/* End of file Dashboard.php */
