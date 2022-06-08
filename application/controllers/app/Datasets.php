<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datasets extends CI_Controller {

	protected $_viewRoot  = 'app/datasets/';
	protected $_modelRoot = 'app/';
	protected $_routeRoot = 'app/datasets/';
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
		$data['pageFunction'] 		 = 'datasets';
		$data['pageClass']           = 'hold-transition sidebar-mini';
		$data['primaryView']         = $this->_viewRoot . $this->_homeRoute;
		$data['pageTitle']           = 'Datasets :: MTM Reporting';
		$data['name']                = $this->session->userdata('name');
		$data['heading']             = 'Datasets ';

		$data['forms']               = $this->m_forms->getAllForms(true, false);
		$data['formSubmitHandler']   = $this->_routeRoot . 'save';
		$data['activeTab']           = '';
		$data['breadcrumb']          = array('#' => 'Datasets');

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}
}
/* End of file Datasets.php */
