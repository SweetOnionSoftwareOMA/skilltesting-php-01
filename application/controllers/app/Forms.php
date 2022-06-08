<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forms extends Auth_Controller {

	protected $_viewRoot  = 'app/forms/';
	protected $_modelRoot = 'app/';
	protected $_routeRoot = 'app/forms/';
	protected $_homeRoute = 'list';

	public function __construct()
	{
		parent::__construct();
		$this->load->model($this->_modelRoot . 'Model_forms', 'm_forms');
		$this->data['subNavBar']      = 'app/nav_primary';
		$this->data['templateStyle']  = 'sidebar';
	}

	public function list()
	{
		// Alias $data
		$data = &$this->data;
		$data['pageClass']           = 'hold-transition sidebar-mini';
		$data['primaryView']         = $this->_viewRoot . $this->_homeRoute;
		$data['pageTitle']           = 'Forms :: MTM Reporting';
		$data['name']                = $this->session->userdata('name');
		$data['heading']             = 'Forms Listing';

		//Execute the following part for reporters only.
		$data['forms']               = $this->m_forms->getAllForms(true, false);
		$data['formSubmitHandler']   = $this->_routeRoot . 'save';
		$data['activeTab']           = '';
		$data['breadcrumb']          = array('#' => 'Forms');

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}
}
/* End of file Forms.php */


