<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offices extends Auth_Controller {

	protected $_viewRoot  = 'admin/offices/';
	protected $_modelRoot = 'admin/';
	protected $_routeRoot = 'admin/offices/';
	protected $_homeRoute = 'index';

	public function __construct()
	{
		parent::__construct();
		$this->load->model($this->_modelRoot . 'Model_offices', 'm_offices');
		$this->load->model($this->_modelRoot . 'Model_users', 'm_users');
		$this->data['subNavBar']      = 'admin/nav_admin';
		$this->data['templateStyle']  = 'sidebar';
	}

	public function index()
	{
		$data 					    = &$this->data;
		$data['pageFunction']       = '';
		$data['pageClass']          = 'hold-transition sidebar-mini dark-mode';
		$data['primaryView']        = $this->_viewRoot . $this->_homeRoute;
		$data['pageTitle']          = 'Offices Management :: MTM Reporting';
		$data['name']               = $this->session->userdata('name');
		$data['heading']            = 'View Offices <small class="float-right">Show Deleted <input type="checkbox" id="ShowDeleted" name="ShowDeleted" data-on-text="Yes" data-off-text="No" data-bootstrap-switch data-off-color="danger" data-on-color="success" data-size="mini"></small>';
		$data['breadcrumb']         = array('#' => 'Offices');
		$array 						= $dataTable = array();

		$array						= array('Office Name',
											'Office Color',
											'Notification Email',
											'Notify for New Data',
											'Address 1',
											'Address 2',
											'City',
											'State',
											'Zip Code',
											'Phone',
											'App URL',
											'Tax Rate',
											'Location URL',
											'Created At',
											'Actions');

		$dataTable['headings'] 		= $array;
		$data['dataTable']          = $dataTable;

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}

	public function list()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			// Alias $data
			$data 							= &$this->data;

			$post 							= $this->input->post();
			$draw 							= intval($this->input->post("draw"));
			$start 							= ((intval($this->input->post("start"))) ? $this->input->post("start") : 0 );
			$length 						= ((intval($this->input->post("length"))) ? $this->input->post("length") : 5 );

			$columns_array 					= array('office_name', 'address1', 'address2', 'city', 'state', 'zip', 'phone', 'app_url', 'taxrate', 'location_url', 'created_at');
			$column_index 					= $post['order'][0]['column'];
			$column_name 					= $columns_array[$column_index];
			$column_sort_order 				= $post['order'][0]['dir'];
			$keyword 						= $post['search']['value'];
			$showDeleted 					= $post['showDeleted'];

			$count 							= $this->m_offices->getOfficesCount($showDeleted, $keyword);

			$query 							= $this->m_offices->getAllOffices($showDeleted, $start, $length, $column_name, $column_sort_order, $keyword);

			$data 							= [];

			foreach($query->result() as $r) {
				$data[] 					= array('office_id' => $r->office_id,
													'office_name' => $r->office_name,
													'office_color' => (($r->office_color) ? '<span class="badge btn-block" style="background-color:'.$r->office_color.'">'.$r->office_color.'</span>' : '' ),
													'notify_email_address' => $r->notify_email_address,
													'notify_new_data' => '<span class="badge btn-block badge-'.((to_boolean($r->notify_new_data)) ? 'success">Yes' : 'danger">No' ).'</span>',
													'address1' => $r->address1,
													'address2' => $r->address2,
													'city' => $r->city,
													'state' => $r->state,
													'zip' => $r->zip,
													'phone' => $r->phone,
													'app_url' => $r->app_url,
													'taxrate' => $r->taxrate,
													'location_url' => $r->location_url,
													'deleted' => to_boolean($r->deleted),
													'created_at' => date('m-d-Y h:i:s', strtotime($r->created_at)));
			}

			$result 						= array("draw" 				=> $draw,
													"recordsTotal" 		=> $count,
			    	     							"recordsFiltered" 	=> $count,
				         							"data" 				=> $data);

	      	echo json_encode($result);
	    	exit();
	    }
	}

	public function add()
	{
		// Alias $data
		$data 								= &$this->data;
		$data['pageClass']          		= 'hold-transition sidebar-mini dark-mode';
		$data['pageFunction']				= 'add';
		$data['primaryView']				= $this->_viewRoot . 'add';
		$data['pageTitle']					= 'Add Office :: MTM Reporting';
		$data['name']						= $this->session->userdata('name');
		$data['heading']					= 'Add Office';
		$data['breadcrumb']					= array(base_url().'admin/offices' => 'Offices', '#' => 'Add Office');
		$data['formSubmitHandler']			= $this->_routeRoot.'save';
		$data['organizations'] 				= $this->m_offices->getAllOrganizations(false)->result();
		$data['users']   					= $this->m_users->getAllUsers(false, '', '', '', '', '')->result();

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}

	public function edit($office_id)
	{
		// Alias $data
		$data 								= &$this->data;
		$data['office']   					= $this->m_offices->getOffice(false, $office_id)->row();

		if (@sizeof($data['office'])) {
			$data['pageClass']				= 'hold-transition sidebar-mini dark-mode';
			$data['pageFunction']			= 'edit';
			$data['primaryView']			= $this->_viewRoot . 'edit';
			$data['pageTitle']				= 'Edit Office :: MTM Reporting';
			$data['name']					= $this->session->userdata('name');
			$data['heading']				= 'Edit Office';
			$data['breadcrumb']				= array(base_url().'admin/offices' => 'Office', '#' => 'Edit Office');
			$data['formSubmitHandler']		= $this->_routeRoot.'save';
			$data['organizations'] 			= $this->m_offices->getAllOrganizations(false)->result();
			$data['offices_organizations']  = $this->m_offices->getOfficesOrganizations($office_id)->result_array();
			$data['users']   				= $this->m_users->getAllUsers(false, '', '', '', '', '')->result();
			$data['offices_users']  		= $this->m_offices->getOfficesUsers($office_id)->result_array();
			$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
		} else {
			$this->setFlashMessage('Failure', 'error', 'There was an error finding the office, please try again.');
			redirect($this->_routeRoot);
		}
	}

	public function save()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {

			$post 							= $this->input->post();
			$action                			= 'added';
			if (isset($post['office_id'])) {
				$office_id					= $post['office_id'];
			}

			$post['notify_new_data'] 		= to_boolean($post['notify_new_data']);

			if (isset($office_id)) {
				$response 					= $this->m_offices->updateOffice($office_id, $post);
				$action                 	= 'updated';
			} else {
				$response 					= $this->m_offices->createOffice($post);
			}

			if ($response) {
				$this->setFlashMessage('Successful!', 'success', 'Office has been '.$action.'.');
			} else {
				$this->setFlashMessage('Failure', 'error', 'There was a problem '.(($action == 'added') ? 'adding' : 'updating' ).' office, please try again.');
			}
		}
		redirect($this->_routeRoot);
	}

	public function recover($office_id)
	{
		$recovered 							= $this->m_offices->recoverOffice($office_id);
		if ($recovered) {
			$this->setFlashMessage('Successful!', 'success', 'Office was recovered.');
		} else {
			$this->setFlashMessage('Failure', 'error', 'We are unable to recovered this office, please try again.');
		}
		redirect($this->_routeRoot);
	}

	public function delete($office_id)
	{
		$deleted 							= $this->m_offices->deleteOffice($office_id);
		if ($deleted) {
			$this->setFlashMessage('Successful!', 'success', 'Office was deleted.');
		} else {
			$this->setFlashMessage('Failure', 'error', 'We are unable to delete this office, please try again.');
		}
		redirect($this->_routeRoot);
	}
}

/* End of file Offices.php */
