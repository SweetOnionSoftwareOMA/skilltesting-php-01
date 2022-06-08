<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vc_form extends Auth_Controller {

	protected $_viewRoot  = 'app/forms/';
	protected $_modelRoot = 'app/';
	protected $_routeRoot = 'app/vc_form/';
	protected $_routeDataset = 'app/vc_dataset/';
	protected $_homeRoute = 'list';
	protected $_formID    = 3;

	public function __construct()
	{
		parent::__construct();
		$this->load->model($this->_modelRoot . 'Model_forms', 'm_forms');
		$this->load->model($this->_modelRoot . 'Model_users', 'm_users');
		$this->load->model($this->_modelRoot . 'Model_vc_form_data', 'm_vc_form_data');
		$this->data['subNavBar']      = 'app/nav_primary';
		$this->data['templateStyle']  = 'sidebar';
	}

	public function index()
	{
		$data 					         = &$this->data;
		$data['pageClass']               = 'hold-transition sidebar-mini';
		$form 	 					 	 = $this->m_forms->getForms($this->_formID)->row_array();

		if(sizeof($form)) {
			$data['primaryView']         = $this->_viewRoot . $form['template_url'];
			$data['pageTitle']           = $form['name'].' :: MTM Reporting';
			$data['form']             	 = $form;
			$data['name']                = $this->session->userdata('name');
			$data['heading']             = $form['name'];
			$data['pageDescription']     = $form['description'];
			$data['breadcrumb']          = array(base_url().'app/forms/list' => 'Forms', '#' => $form['name']);
			$data['formSubmitHandler']   = $this->_routeRoot . 'save';

			$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
		} else {
			$this->setFlashMessage('Failure', 'error', 'There is an issue accessing the form, please try again.');
			redirect('forms/list');
		}
	}

	public function edit($vc_form_data_id)
	{
		if ($vc_form_data_id != '' && $this->authuser->isSuperAdmin()) {
			$data 					        = &$this->data;
			$data['pageClass']              = 'hold-transition sidebar-mini';
			$form 	 					 	= $this->m_forms->getForms($this->_formID)->row_array();

			$data['primaryView']         	= $this->_viewRoot . $form['template_url'];
			$data['pageTitle']           	= $form['name'].' :: MTM Reporting';
			$data['form']             	 	= $form;
			$data['name']                	= $this->session->userdata('name');
			$data['heading']             	= $form['name'];
			$data['pageDescription']     	= $form['description'];
			$data['breadcrumb']          	= array(base_url().'app/forms/list' => 'Forms', base_url().'app/vc_form' => $form['name'], '#' => 'Update Data');
			$data['formSubmitHandler']   	= $this->_routeRoot . 'save';
			$data['form_data']   			= $this->m_vc_form_data->getFormDataById(false, $vc_form_data_id)->row_array();

			$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
		} else {
			$this->setFlashMessage('Failure', 'error', 'There is an issue accessing the form, please try again.');
			redirect($this->_routeDataset);
		}
	}

	public function save()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			if ($this->input->post('reporting_week')) {
				$reporting_week 					= explode('-', $this->input->post('reporting_week'));
				$week_start 						= new DateTime();
				$week_start->setISODate($reporting_week[0], $reporting_week[1]);
				$_POST['reporting_week']			= $week_start->format('Y-m-d');
			}

			$post 									= $_POST;

			//Check duplicate in table
			$select = array('vc.vc_form_data_id');
			$where 	= array('vc.user_id' 		=> $post['user_id'],
						   'vc.office_id' 		=> $post['office_id'],
						   'vc.reporting_week'  => $post['reporting_week']);

			if (isset($post['vc_form_data_id'])) {
				$vc_form_data_id					= $post['vc_form_data_id'];
				$where['vc.vc_form_data_id !='] 	= $post['vc_form_data_id'];//Skip the same record in case of edit
			}

			if ($this->m_vc_form_data->getAllFormsData($select, $where)->num_rows()) {
				$this->setFlashMessage('Duplicate Entry', 'error', 'This location has the entry on the same date.');
			} else {
				if (isset($vc_form_data_id)) {
					$response 						= $this->m_vc_form_data->updateFormData($vc_form_data_id, $post);
				} else {
					$response 						= $this->m_vc_form_data->insertFormData($post);

					if ($response && $this->config->item('send_new_data_eamil')) {
						$user_offices = $this->session->userdata('user_offices');
						$office = $user_offices[$post['office_id']];
						$form_data = $this->m_vc_form_data->getFormDataById(false, $response)->row_array();

						//Current date
						$date = new DateTime();
						$week = $date->format("W");
						$year = $date->format("Y");

						$post['reporting_week'] = $reporting_week[0].'-'.$reporting_week[1];

						// Email Flag
						// Check if the entry is for current week.
						// Selected office is set to recieve new notification.
						// Selected office has an email address.
						if ($post['reporting_week'] == $year.'-'.$week && to_boolean($office['notify_new_data']) && $office['notify_email_address'] && sizeof($form_data)) {
							send_new_form_data_email($office['notify_email_address'], 'VC', $week_start->format('M d Y'), $form_data);
						}
					}
				}

				if ($response) {
					$this->setFlashMessage('Successful!', 'success', 'Forms data has been was saved.');
				} else {
					$this->setFlashMessage('Failure', 'error', 'There was a problem saving your data, please try again.');
				}
			}
		}

		if (isset($vc_form_data_id)) {
			redirect($this->_routeDataset);
		} else{
			redirect($this->_routeRoot);
		}
	}
}
/* End of file Vc_forms.php */
