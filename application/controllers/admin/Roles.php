<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends Auth_Controller {

	protected $_viewRoot  = 'admin/roles/';
	protected $_modelRoot = 'admin/';
	protected $_routeRoot = 'admin/roles/';
	protected $_homeRoute = 'index';

	public function __construct()
	{
		parent::__construct();
		$this->load->model($this->_modelRoot . 'Model_roles', 'm_roles');
		$this->load->model($this->_modelRoot . 'Model_users', 'm_users');
		$this->data['subNavBar']      		= 'admin/nav_admin';
		$this->data['templateStyle']  		= 'sidebar';
	}

	public function index()
	{
		$data 					    		= &$this->data;
		$data['pageFunction']       		= '';
		$data['pageClass']         			= 'hold-transition sidebar-mini dark-mode';
		$data['primaryView']        		= $this->_viewRoot . $this->_homeRoute;
		$data['pageTitle']          		= 'Roles Management :: MTM Reporting';
		$data['name']               		= $this->session->userdata('name');
		$data['heading']           			= 'View Roles <small class="float-right">Show Deleted <input type="checkbox" id="ShowDeleted" name="ShowDeleted" data-on-text="Yes" data-off-text="No" data-bootstrap-switch data-off-color="danger" data-on-color="success" data-size="mini"></small>';
		$data['breadcrumb']         		= array('#' => 'Roles');
		$array 								= $dataTable = array();

		$array								= array('Role  Name',
													'Description',
													'Super Admin',
													'Manager Can Assign',
													'Created At',
													'Actions');

		$dataTable['headings'] 				= $array;
		$data['dataTable']          		= $dataTable;

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

			$columns_array 					= array('role_name', 'description', 'super_admin', 'office_manager_can_assign', 'created_at');
			$column_index 					= $post['order'][0]['column'];
			$column_name 					= $columns_array[$column_index];
			$column_sort_order 				= $post['order'][0]['dir'];
			$keyword 						= $post['search']['value'];
			$showDeleted 					= $post['showDeleted'];

			$count 							= $this->m_roles->getRolesCount($showDeleted, $keyword);

			$query 							= $this->m_roles->getAllRoles($showDeleted, $start, $length, $column_name, $column_sort_order, $keyword);

			$data 							= [];

			foreach($query->result() as $r) {
				$data[] 					= array('role_id' => $r->role_id,
													'role_name' => $r->role_name,
													'description' => ((strlen($r->description) > 50) ? substr($r->description, 0, 50).'&hellip;' : $r->description ),
													'super_admin' => to_boolean($r->super_admin) ? 'Yes' : 'No' ,
													'office_manager_can_assign' => to_boolean($r->office_manager_can_assign) ? 'Yes' : 'No' ,
													'deleted' => to_boolean($r->deleted),
													'created_at' => date('m-d-Y h:i:s', strtotime($r->created_at)));
			}

			$result 						= array('draw' 				=> $draw,
													'recordsTotal' 		=> $count,
					    	     					'recordsFiltered' 	=> $count,
				         							'data' 				=> $data);

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
		$data['pageTitle']					= 'Add Role :: MTM Reporting';
		$data['name']						= $this->session->userdata('name');
		$data['heading']					= 'Add Role';
		$data['breadcrumb']					= array(base_url().'admin/roles' => 'Roles', '#' => 'Add Role');
		$data['formSubmitHandler']			= $this->_routeRoot.'save';
		$data['permissions'] 				= $this->m_roles->getAllPermissions(false)->result();
		$data['users']   					= $this->m_users->getAllUsers(false, '', '', '', '', '')->result();

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}

	public function edit($role_id)
	{
		// Alias $data
		$data 								= &$this->data;
		$data['role']   					= $this->m_roles->getRole(false, $role_id)->row();

		if (@sizeof($data['role'])) {
			$data['pageClass']				= 'hold-transition sidebar-mini dark-mode';
			$data['pageFunction']			= 'edit';
			$data['primaryView']			= $this->_viewRoot . 'edit';
			$data['pageTitle']				= 'Edit Role :: MTM Reporting';
			$data['name']					= $this->session->userdata('name');
			$data['heading']				= 'Edit Role';
			$data['breadcrumb']				= array(base_url().'admin/roles' => 'Role', '#' => 'Edit Role');
			$data['formSubmitHandler']		= $this->_routeRoot.'save';

			$data['permissions'] 			= $this->m_roles->getAllPermissions(false)->result();
			$data['permissions_roles']  	= $this->m_roles->getRolesPermissions($role_id)->result_array();

			$data['users']   				= $this->m_users->getAllUsers(false, '', '', '', '', '')->result();
			$data['roles_users']  			= $this->m_roles->getRolesUsers($role_id)->result_array();

			$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
		} else {
			$this->setFlashMessage('Failure', 'error', 'There was an error finding the role, please try again.');
			redirect($this->_routeRoot);
		}
	}

	public function save()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {

			$post 							= $this->input->post();
			$action                			= 'added';
			if (isset($post['role_id'])) {
				$role_id					= $post['role_id'];
			}

			if (!isset($post['super_admin'])) {
				$post['super_admin'] 		= false;
			}

			if (!isset($post['office_manager_can_assign'])) {
				$post['office_manager_can_assign'] = false;
			}

			if (isset($role_id)) {
				$response 					= $this->m_roles->updateRole($role_id, $post);
				$action                 	= 'updated';
			} else {
				$response 					= $this->m_roles->createRole($post);
			}

			if ($response) {
				$this->setFlashMessage('Successful!', 'success', 'Role has been '.$action.'.');
			} else {
				$this->setFlashMessage('Failure', 'error', 'There was a problem '.(($action == 'added') ? 'adding' : 'updating' ).' role, please try again.');
			}
		}
		redirect($this->_routeRoot);
	}

	public function is_available()
	{
		$status 							= true;
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$role_name 						= $this->input->get('role_name');
			$role 							= $this->m_roles->getRoleFromRolename($role_name);
			 if (count($role) == 1) :
			 	$status 					= false;
			 else :
			 	$status 					= true;
			 endif;
		}
		echo json_encode($status);
	}

	public function recover($role_id)
	{
		$recovered 						= $this->m_roles->recoverRole($role_id);
		if ($recovered) {
			$this->setFlashMessage('Successful!', 'success', 'Role was recovered.');
		} else {
			$this->setFlashMessage('Failure', 'error', 'We are unable to recovered this role, please try again.');
		}
		redirect($this->_routeRoot);
	}

	public function delete($role_id)
	{
		$deleted 							= $this->m_roles->deleteRole($role_id);
		if ($deleted) {
			$this->setFlashMessage('Successful!', 'success', 'Role was deleted.');
		} else {
			$this->setFlashMessage('Failure', 'error', 'We are unable to delete this role, please try again.');
		}
		redirect($this->_routeRoot);
	}
}

/* End of file Roles.php */
