<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager extends Auth_Controller {

	protected $_viewRoot  = 'office/';
	protected $_modelRoot = 'office/';
	protected $_routeRoot = 'office/manager';
	protected $_homeRoute = 'user_list';

	public function __construct()
	{
		parent::__construct();
		$this->data['subNavBar']      = 'app/nav_office';
		$this->data['templateStyle']  = 'sidebar';
		$this->load->model($this->_modelRoot . 'Model_office_manager', 'm_office_manager');
		$this->data['user_offices']   = $this->session->userdata('user_offices');
		//Exclude this part for Super Admin

		if ($this->session->userdata('user_isSA')){
			$this->setFlashMessage('Access Denied', 'error', 'The section you are trying to access is not allowed.');
			redirect('/');
		}
	}

	public function index()
	{
		// Alias $data
		$data = &$this->data;

		$data['pageFunction']	= 'view';
		$data['pageClass']		= 'hold-transition sidebar-mini';
		$data['primaryView']	= $this->_viewRoot . 'index';
		$data['pageTitle']		= 'Office Manager :: MTM Reporting';
		$data['name']			= $this->session->userdata('name');
		$data['heading']		= 'Office Manager';
		$data['breadcrumb']		= array('#' => 'Office Manager');
		$select_fields			= $array = $dataTable = array();
		$array					= array('Title',
									 	'First Name',
									 	'Last Name',
									 	'Username',
									 	'Email',
									 	'Created At',
									 	'Actions');
		$dataTable['headings']	= $array;
		$data['dataTable']   	= $dataTable;

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}

	public function list()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			// Alias $data
			$data 				= &$this->data;

			$post 				= $this->input->post();
			$draw 				= intval($this->input->post("draw"));
			$start 				= ((intval($this->input->post("start"))) ? $this->input->post("start") : 0 );
			$length 			= ((intval($this->input->post("length"))) ? $this->input->post("length") : 5 );

			$columns_array 		= array('title', 'first_name', 'last_name', 'username', 'email', 'created_at');
			$column_index 		= $post['order'][0]['column'];
			$column_name 		= $columns_array[$column_index];
			$column_sort_order 	= $post['order'][0]['dir'];
			$keyword 			= $post['search']['value'];
			$user_offices 		= array_keys($data['user_offices']);

			$count 				= $this->m_office_manager->getOfficeUsersCount(false, $user_offices, $keyword);

			$query 				= $this->m_office_manager->getAllOfficeUsers(false, $user_offices, $start, $length, $column_name, $column_sort_order, $keyword);

			$data 				= [];

			foreach($query->result() as $r) {
				$data[] 		= array('title' => $r->title,
										'first_name' => $r->first_name,
										'last_name' => $r->last_name,
										'username' => $r->username,
										'email' => $r->email,
										'created_at' => date('m-d-Y h:i:s', strtotime($r->created_at)),
										'action' => '<a href="'.base_url().'office/manager/edit/'.$r->user_id.'" class="btn btn-primary"><i class="fas fa-user-edit"></i> Edit</a> <a href="'.base_url().'office/manager/remove/'.$r->user_id.'" onclick="return confirm(\'Are you sure you want to delete this user?\');" id="#delete-link" data-link="" class="btn btn-danger"><i class="fas fa-user-times"></i> Delete</a>');
			}

			$result 			= array("draw" 				=> $draw,
										"recordsTotal" 		=> $count,
			    	     				"recordsFiltered" 	=> $count,
				         				"data" 				=> $data);

	      	echo json_encode($result);
	    }
    	exit();
	}

	public function add()
	{
		// Alias $data
		$data 						= &$this->data;
		$data['pageFunction']		= 'view';
		$data['pageClass']			= 'hold-transition sidebar-mini';
		$data['primaryView']		= $this->_viewRoot . 'add';
		$data['pageTitle']			= 'Add Office User :: MTM Reporting';
		$data['name']				= $this->session->userdata('name');
		$data['heading']			= 'Add Office User';
		$data['breadcrumb']			= array(base_url().'office/manager' => 'Office Manager', '#' => 'Add Office User');
		$data['formSubmitHandler']	= $this->_routeRoot.'/save';
		$data['user_roles']   		= $this->m_office_manager->getAssignableRoles(false);
		$data['user_organizations'] = $this->session->userdata('user_organizations');

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}

	public function edit($user_id)
	{
		// Alias $data
		$data 								= &$this->data;
		$data['user']   					= $this->m_office_manager->getOfficeUser(false, $user_id, array_keys($data['user_offices']))->row();

		if (@sizeof($data['user'])) {
			$this->load->model('app/Model_users', 'm_users');

			$data['pageFunction']			= 'view';
			$data['pageClass']				= 'hold-transition sidebar-mini';
			$data['primaryView']			= $this->_viewRoot . 'edit';
			$data['pageTitle']				= 'Edit Office User :: MTM Reporting';
			$data['name']					= $this->session->userdata('name');
			$data['heading']				= 'Edit Office User';
			$data['breadcrumb']				= array(base_url().'office/manager' => 'Office Manager', '#' => 'Edit Office User');
			$data['formSubmitHandler']		= $this->_routeRoot.'/save';
			$data['user_organizations'] 	= $this->session->userdata('user_organizations');
			$data['user_roles']   			= $this->m_office_manager->getAssignableRoles(false);
			$data['user_assigned_roles']   	= $this->m_users->getUserRoles($user_id)->result_array();
			$data['user_selected_offices']  = $this->m_users->getUserOffices(false, $user_id, array_keys($data['user_organizations']))->result_array();
			$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
		} else {
			$this->setFlashMessage('Failure', 'error', 'There was an error finding the office user, please try again.');
			redirect($this->_routeRoot);
		}
	}

	public function save()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {

			$post 							= $_POST;
			$action                			= 'added';
			if (isset($post['user_id'])) {
				$user_id					= $post['user_id'];
			}

			if (isset($user_id)) {
				$response 					= $this->m_office_manager->updateOfficeUser($user_id, $post);
				$action                 	= 'updated';
			} else {
				$response 					= $this->m_office_manager->createOfficeUser($post);
			}

			if ($response) {
				$this->setFlashMessage('Successful!', 'success', 'Office user has been '.$action.'.');
			} else {
				$this->setFlashMessage('Failure', 'error', 'There was a problem '.(($action == 'added') ? 'adding' : 'updating' ).' office user, please try again.');
			}
		}
		redirect($this->_routeRoot);
	}

	public function remove($user_id)
	{
		// Alias $data
		$data 								= &$this->data;
		$data['user']   					= $this->m_office_manager->getOfficeUser(false, $user_id, array_keys($data['user_offices']))->row();

		if (sizeof($data['user'])) {
			$deleted 						= $this->m_office_manager->deleteOfficeUser($user_id);
			if ($deleted) {
				$this->setFlashMessage('Successful!', 'success', 'User was deleted.');
			} else {
				$this->setFlashMessage('Failure', 'error', 'We are unable to delete this office user, please try again.');
			}
		} else {
			$this->setFlashMessage('Failure', 'error', 'There was an error finding the office user, please try again.');
		}
		redirect($this->_routeRoot);
	}

	public function is_available()
	{
		$status = true;
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$username = $this->input->get('username');
			$user = $this->m_office_manager->getUserFromUsername($username);
			 if (count($user) == 1) :
			 	$status = false;
			 else :
			 	$status = true;
			 endif;
		}
		echo json_encode($status);
	}
}
