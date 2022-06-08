<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Auth_Controller {

	protected $_viewRoot  = 'admin/users/';
	protected $_modelRoot = 'admin/';
	protected $_routeRoot = 'admin/users/';
	protected $_homeRoute = 'index';

	public function __construct()
	{
		parent::__construct();
		$this->load->model($this->_modelRoot . 'Model_users', 'm_users');
		$this->load->model($this->_modelRoot . 'Model_offices', 'm_offices');
		$this->load->model($this->_modelRoot . 'Model_roles', 'm_roles');
		$this->data['subNavBar']      = 'admin/nav_admin';
		$this->data['templateStyle']  = 'sidebar';
	}

	public function index()
	{
		$data 					    = &$this->data;
		$data['pageFunction']       = '';
		$data['pageClass']          = 'hold-transition sidebar-mini dark-mode';
		$data['primaryView']        = $this->_viewRoot . $this->_homeRoute;
		$data['pageTitle']          = 'Users Management :: MTM Reporting';
		$data['name']               = $this->session->userdata('name');
		$data['heading']            = 'View Users <small class="float-right">Show Deleted <input type="checkbox" id="ShowDeleted" name="ShowDeleted" data-on-text="Yes" data-off-text="No" data-bootstrap-switch data-off-color="danger" data-on-color="success" data-size="mini"></small>';
		$data['breadcrumb']         = array('#' => 'Users');
		$array 						= $dataTable = array();

		$array						= array('Title',
											'First Name',
											'Last Name',
											'Username',
											'Email',
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
			$showDeleted 		= $post['showDeleted'];

			$count 				= $this->m_users->getUsersCount($showDeleted, $keyword);

			$query 				= $this->m_users->getAllUsers($showDeleted, $start, $length, $column_name, $column_sort_order, $keyword);

			$data 				= [];

			foreach($query->result() as $r) {
				$data[] 		= array('user_id' => $r->user_id,
										'title' => $r->title,
										'first_name' => $r->first_name,
										'last_name' => $r->last_name,
										'username' => $r->username,
										'email' => $r->email,
										'deleted' => to_boolean($r->deleted),
										'created_at' => date('m-d-Y h:i:s', strtotime($r->created_at)));
			}

			$result 			= array("draw" 				=> $draw,
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
		$data 						= &$this->data;
		$data['pageClass']          = 'hold-transition sidebar-mini dark-mode';
		$data['pageFunction']		= 'add';
		$data['primaryView']		= $this->_viewRoot . 'add';
		$data['pageTitle']			= 'Add User :: MTM Reporting';
		$data['name']				= $this->session->userdata('name');
		$data['heading']			= 'Add User';
		$data['breadcrumb']			= array(base_url().'admin/users' => 'Users', '#' => 'Add User');
		$data['formSubmitHandler']	= $this->_routeRoot.'save';
		$data['offices'] 			= $this->m_offices->getAllOffices(false, '', '', '', '', '')->result();
		$data['roles']   			= $this->m_roles->getAllRoles(false, '', '', '', '', '')->result();

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}

	public function edit($user_id)
	{
		// Alias $data
		$data 								= &$this->data;
		$data['user']   					= $this->m_users->getUser(true, $user_id)->row();

		if (@sizeof($data['user'])) {
			$data['pageClass']				= 'hold-transition sidebar-mini dark-mode';
			$data['pageFunction']			= 'edit';
			$data['primaryView']			= $this->_viewRoot . 'edit';
			$data['pageTitle']				= 'Edit User :: MTM Reporting';
			$data['name']					= $this->session->userdata('name');
			$data['heading']				= 'Edit User';
			$data['breadcrumb']				= array(base_url().'admin/users' => 'User', '#' => 'Edit User');
			$data['formSubmitHandler']		= $this->_routeRoot.'save';

			$data['offices'] 				= $this->m_offices->getAllOffices(false, '', '', '', '', '')->result();
			$data['users_offices']  		= $this->m_users->getUserOffices(false, $user_id)->result_array();

			$data['roles']   				= $this->m_roles->getAllRoles(false, '', '', '', '', '')->result();
			$data['users_roles']  			= $this->m_users->getUserRoles(false, $user_id)->result_array();

			$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
		} else {
			$this->setFlashMessage('Failure', 'error', 'There was an error finding the user, please try again.');
			redirect($this->_routeRoot);
		}
	}

	public function save()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {

			$post 							= $this->input->post();
			$action                			= 'added';
			if (isset($post['user_id'])) {
				$user_id					= $post['user_id'];
			}

			if (isset($user_id)) {
				$response 					= $this->m_users->updateUser($user_id, $post);
				$action                 	= 'updated';
			} else {
				$response 					= $this->m_users->createUser($post);
			}

			if ($response) {
				$this->setFlashMessage('Successful!', 'success', 'User has been '.$action.'.');
			} else {
				$this->setFlashMessage('Failure', 'error', 'There was a problem '.(($action == 'added') ? 'adding' : 'updating' ).' user, please try again.');
			}
		}
		redirect($this->_routeRoot);
	}

	public function view($user_id)
	{
		if ($user_id){
			$user 							= $this->m_users->getUser(false, $user_id)->row_array();
			if (sizeof($user)) {
				$user['offices'] 			= $this->m_users->getUserOffices(false, $user_id)->result_array();
				$user['roles'] 				= $this->m_users->getUserRoles(false, $user_id)->result_array();
				echo json_encode($user);
				exit;
			} else {
				echo json_encode(array('status' => false, 'message' => 'No user found.'));
				exit;
			}
		} else {
			echo json_encode(array('status' => false, 'message' => 'User ID required.'));
			exit;
		}
	}

	public function is_available()
	{
		$status 							= true;
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$username 						= $this->input->get('username');
			$user 							= $this->m_users->getUserFromUsername($username);
			 if (count($user) == 1) :
			 	$status 					= false;
			 else :
			 	$status 					= true;
			 endif;
		}
		echo json_encode($status);
	}

	public function recover($user_id)
	{
		$recovered 						= $this->m_users->recoverUser($user_id);
		if ($recovered) {
			$this->setFlashMessage('Successful!', 'success', 'User was recovered.');
		} else {
			$this->setFlashMessage('Failure', 'error', 'We are unable to recovered this user, please try again.');
		}
		redirect($this->_routeRoot);

	}

	public function delete($user_id)
	{
		$deleted 						= $this->m_users->deleteUser($user_id);
		if ($deleted) {
			$this->setFlashMessage('Successful!', 'success', 'User was deleted.');
		} else {
			$this->setFlashMessage('Failure', 'error', 'We are unable to delete this user, please try again.');
		}
		redirect($this->_routeRoot);
	}
}

/* End of file Users.php */
