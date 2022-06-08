<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vc_dataset extends Auth_Controller {

	protected $_viewRoot  = 'app/datasets/';
	protected $_modelRoot = 'app/';
	protected $_routeRoot = 'app/vc_dataset/';
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
		$data 					         	= &$this->data;
		$data['pageClass']               	= 'hold-transition sidebar-mini';
		$form 	 					 	 	= $this->m_forms->getForms($this->_formID)->row_array();

		if(sizeof($form)) {
			$data['primaryView']         	= $this->_viewRoot . $form['template_url'].'_dataset';
			$data['pageTitle']           	= $form['name'].' Dataset :: MTM Reporting';
			$data['form']             		= $form;
			$data['name']                	= $this->session->userdata('name');
			$data['heading']            	= $form['name'].' Dataset ';
			$data['pageDescription']     	= $form['description'];
			$data['breadcrumb']          	= array(base_url().'app/datasets/list' => 'Datasets', '#' => $form['name'].' Dataset ');
			$data['formSubmitHandler']   	= $this->_routeRoot . 'save';
			$select_fields 					= $array = $dataTable = array();

			$array 						 	= array('Action',
													'Submitted By',
											 		'Location',
													'Start of Reporting Week',
											 		'Total Weekly Sales',
											 		'Second Pair Offerings',
											 		'Second Pairs Sold',
											 		'Second Pair Conversion (%)',
											 		'Created At');

			if (!$this->authuser->isSuperAdmin()) {
				unset($array[0]);
				$array = array_values($array);
			}

			$dataTable['headings'] 			= $array;
			$data['dataTable']           	= $dataTable;

			$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
		} else {
			$this->setFlashMessage('Failure', 'error', 'There is an issue accessing the form, please try again.');
			redirect('forms/list');
		}
	}

	public function list()
	{
		$post 				= $this->input->post();

		$draw 				= intval($this->input->post("draw"));
		$start 				= ((intval($this->input->post("start"))) ? $this->input->post("start") : 0 );
		$length 			= ((intval($this->input->post("length"))) ? $this->input->post("length") : 5 );

		$columns_array 		= array('dataset_action', 'submitted_by', 'location', 'reporting_week', 'location_gross_sales', 'secondpair_eligible', 'secondpair_accepted', 'secondpair_conversion_rate', 'created_at');

		if (!$this->authuser->isSuperAdmin()){
			unset($columns_array[0]);
			$columns_array = array_values($columns_array);
		}

		$column_index 		= $post['order'][0]['column'];
		$column_name 		= $columns_array[$column_index];
		$column_sort_order 	= $post['order'][0]['dir'];
		$keyword 			= $post['search']['value'];

		$count 				= $this->m_vc_form_data->getFormDataCount(false, $keyword);

		$query 				= $this->m_vc_form_data->getFormData(false, $start, $length, $column_name, $column_sort_order, $keyword);

		$data 				= [];

		foreach($query->result() as $r) {
			$data[] 		= array('dataset_action' => '<a href="'.base_url().'app/vc_form/edit/'.$r->vc_form_data_id.'" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>',
									'submitted_by' => $r->submitted_by,
									'location' => $r->location,
									'reporting_week' => date('m-d-Y', strtotime($r->reporting_week)),
									'location_gross_sales' => $r->location_gross_sales,
									'secondpair_eligible' => $r->secondpair_eligible,
									'secondpair_accepted' => $r->secondpair_accepted,
									'secondpair_conversion_rate' => number_format($r->secondpair_conversion_rate, 1).'%',
									'created_at' => date('m-d-Y h:i:s', strtotime($r->created_at)));

			if (!$this->authuser->isSuperAdmin())
				unset($data['dataset_action']);
		}

		$result 			= array("draw" 				=> $draw,
									"recordsTotal" 		=> $count,
		    	     				"recordsFiltered" 	=> $count,
			         				"data" 				=> $data);

      	echo json_encode($result);
    	exit();
	}
}
/* End of file Od_Dataset.php */
