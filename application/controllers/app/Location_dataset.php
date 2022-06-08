<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location_dataset extends Auth_Controller {

	protected $_viewRoot  = 'app/datasets/';
	protected $_modelRoot = 'app/';
	protected $_routeRoot = 'app/location_dataset/';
	protected $_homeRoute = 'list';
	protected $_formID    = 2;

	public function __construct()
	{
		parent::__construct();
		$this->load->model($this->_modelRoot . 'Model_forms', 'm_forms');
		$this->load->model($this->_modelRoot . 'Model_users', 'm_users');
		$this->load->model($this->_modelRoot . 'Model_location_form_data', 'm_location_form_data');
		$this->data['subNavBar']      = 'app/nav_primary';
		$this->data['templateStyle']  = 'sidebar';
	}

	public function index()
	{
		$data 					         = &$this->data;
		$data['pageClass']               = 'hold-transition sidebar-mini';
		$form 	 					 	 = $this->m_forms->getForms($this->_formID)->row_array();

		if(sizeof($form)) {
			$data['primaryView']         = $this->_viewRoot . $form['template_url'].'_dataset';
			$data['pageTitle']           = $form['name'].' Dataset :: MTM Reporting';
			$data['form']             	 = $form;
			$data['name']                = $this->session->userdata('name');
			$data['heading']             = $form['name'].' Dataset ';
			$data['pageDescription']     = $form['description'];
			$data['breadcrumb']          = array(base_url().'app/datasets/list' => 'Datasets', '#' => $form['name'].' Dataset ');
			$data['formSubmitHandler']   = $this->_routeRoot . 'save';
			$select_fields 				 = $array = $dataTable = array();

			$data['forms']               = $this->m_forms->getAllForms(true, false);

			$array 						= array('Action',
												'Submitted By',
												'Location',
												'Start of Reporting Week',
												'Cash Not Collected',
												'Cash Collected',
												'Cash Collection Rate (%)',
												'Sum Daily Log $$ for Reporting Week',
												'Scheduled Encounters',
												'Confirmed Appointments',
												'Confirmation Rate (%)',
												'Patient Encounters',
												'No Show Rate (%)',
												'New Patient Encounters',
												'New Patients Rate (%)',
												'Completed Insurance Authorizations',
												'Total Retinal Images Accepted',
												'Retinal Images Accepted Rate',
												'Authorization Compliance Rate (%)',
												'Routine Encounters',
												'Medical Encounters',
												'Medical Conversion Rate (%)',
												'Insurance Card Entries (Medical Only)',
												'Insurance Conversion Rate (%)',
												'Glasses Eligible Patients',
												'Patients Purchasing Glasses',
												'Glasses Capture Rate (%)',
												'Contact Eligible Patients',
												'Patients Purchasing Contacts',
												'Contacts Capture Rate (%)',
												'# of Payment Plans Accepted',
												'Google Reviews',
												'Facebook Reviews',
												'Created At');
			if (!$this->authuser->isSuperAdmin()){
				unset($array[0]);
				$array = array_values($array);
			}

			$dataTable['headings'] 			= $array;
			$data['dataTable']           	= $dataTable;

			$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
		} else {
			$this->setFlashMessage('Failure', 'error', 'There is an issue accessing the form, please try again.');
			redirect('app/forms/list');
		}
	}

	public function list()
	{
		$post 				= $this->input->post();

		$draw 				= intval($this->input->post('draw'));
		$start 				= ((intval($this->input->post('start'))) ? $this->input->post('start') : 0 );
		$length 			= ((intval($this->input->post('length'))) ? $this->input->post('length') : 5 );

		$columns_array 		= array('dataset_action', 'submitted_by', 'location', 'reporting_week', 'cash_not_collected', 'cash_collected', 'cash_collection_rate', 'dailylog_cash', 'scheduled_encounters', 'ecounters_confirmed', 'ecounters_confirmed_rate', 'encounters_patients', 'encounters_no_show_rate', 'encounters_newpatients', 'enconters_newpatient_rate', 'insurance_authorizations', 'insurance_compliance_rate', 'total_retinal_images_accepted', 'retinal_images_accepted_rate', 'encounters_routine', 'encounters_medical', 'medical_conversion_rate', 'medical_insurance_card_collected', 'insurance_conversion_rate', 'glasses_eligible_encounters', 'glasses_purchase_encounters', 'glasses_capture_rate', 'contacts_eligible_encounters', 'contacts_purchase', 'contact_capture_rate', 'payment_plans_accepted', 'social_reviews_google', 'social_reviews_facebook', 'created_at');

		if (!$this->authuser->isSuperAdmin()){
			unset($columns_array[0]);
			$columns_array = array_values($columns_array);
		}

		$column_index 		= $post['order'][0]['column'];
		$column_name 		= $columns_array[$column_index];
		$column_sort_order 	= $post['order'][0]['dir'];
		$keyword 			= $post['search']['value'];

		$count 				= $this->m_location_form_data->getFormDataCount(false, $keyword);

		$query 				= $this->m_location_form_data->getFormData(false, $start, $length, $column_name, $column_sort_order, $keyword);

		$data 				= [];

		foreach($query->result() as $r) {
			$data[] 		= array('dataset_action' => '<a href="'.base_url().'app/location_form/edit/'.$r->location_form_data_id.'" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>',
									'submitted_by' => $r->submitted_by,
									'location' => $r->location,
									'reporting_week' => date('m-d-Y', strtotime($r->reporting_week)),
									'cash_not_collected' => $r->cash_not_collected,
									'cash_collected' => $r->cash_collected,
									'cash_collection_rate' => number_format($r->cash_collection_rate, 1).'%',
									'dailylog_cash' => $r->dailylog_cash,
									'scheduled_encounters' => $r->scheduled_encounters,
									'ecounters_confirmed' => $r->ecounters_confirmed,
									'ecounters_confirmed_rate' => number_format($r->ecounters_confirmed_rate, 1).'%',
									'encounters_patients' => $r->encounters_patients,
									'encounters_no_show_rate' => number_format($r->encounters_no_show_rate, 1).'%',
									'encounters_newpatients' => $r->encounters_newpatients,
									'enconters_newpatient_rate' => number_format($r->enconters_newpatient_rate, 1).'%',
									'insurance_authorizations' => $r->insurance_authorizations,
									'insurance_compliance_rate' => number_format($r->insurance_compliance_rate, 1).'%',
									'total_retinal_images_accepted' => $r->total_retinal_images_accepted,
									'retinal_images_accepted_rate' => number_format($r->retinal_images_accepted_rate, 1).'%',
									'encounters_routine' => $r->encounters_routine,
									'encounters_medical' => $r->encounters_medical,
									'medical_conversion_rate' => number_format($r->medical_conversion_rate, 1).'%',
									'medical_insurance_card_collected' => $r->medical_insurance_card_collected,
									'insurance_conversion_rate' => number_format($r->insurance_conversion_rate, 1).'%',
									'glasses_eligible_encounters' => $r->glasses_eligible_encounters,
									'glasses_purchase_encounters' => $r->glasses_purchase_encounters,
									'glasses_capture_rate' => number_format($r->glasses_capture_rate, 1).'%',
									'contacts_eligible_encounters' => $r->contacts_eligible_encounters,
									'contacts_purchase' => $r->contacts_purchase,
									'contact_capture_rate' => number_format($r->contact_capture_rate, 1).'%',
									'payment_plans_accepted' => $r->payment_plans_accepted,
									'social_reviews_google' => $r->social_reviews_google,
									'social_reviews_facebook' => $r->social_reviews_facebook,
									'created_at' => date('m-d-Y h:i:s', strtotime($r->created_at)));

			if (!$this->authuser->isSuperAdmin())
				unset($data['dataset_action']);
		}

		$result 			= array('draw' 				=> $draw,
									'recordsTotal' 		=> $count,
		    	     				'recordsFiltered' 	=> $count,
			         				'data' 				=> $data);

      	echo json_encode($result);
    	exit();
	}
}
/* End of file Location_dataset.php */
