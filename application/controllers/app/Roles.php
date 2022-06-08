<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends Auth_Controller {

	protected $_viewRoot  = 'app/roles/';
	protected $_modelRoot = 'app/';
	protected $_routeRoot = 'app/roles/';
	protected $_homeRoute = 'app/roles/roles_list';

    public function roles_list()
	{
		// Alias $data
		$data = &$this->data;

		$data['primaryView'] = $this->_viewRoot .'role_list';
		$data['pageTitle']   = 'APPMGR Roles Listing :: MTM Reporting';
		$data['templateStyle']  = 'sidebar';
		$data['subNavBar']     = 'app/nav_users';

		$this->load->model( $this->_modelRoot .'model_randp', 'randp');

		$showDeleted = (isset($_GET['deleted'])) ? to_boolean($_GET['deleted']) : false;
		$data['roles']	= $this->randp->getAllRoles($showDeleted);

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}

    public function edit_role($role_id)
	{
		// Alias $data
		$data = &$this->data;

		$data['primaryView'] = $this->_viewRoot .'role_edit';
		$data['pageTitle']   = 'Edit Role :: MTM Reporting';
		$data['templateStyle']  = 'sidebar';
		$data['subNavBar']     = 'app/nav_users';

		$this->load->model($this->_modelRoot .'model_randp', 'randp');
		$data['role']	= $this->randp->getRole($role_id);
		$data['role_permissions'] = $this->randp->getRolePermissions($role_id);
		$data['permissions']	= $this->randp->getAllPermissions();

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}

	public function update_role()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model($this->_modelRoot . 'model_randp', 'randp');
			$saved = $this->randp->updateRole($_POST);

			if ($saved) {
				$this->setFlashMessage('Successful!', 'success', 'Role was updated.');
			} else {
				$this->setFlashMessage('Failure', 'error', 'There was a problem saving your changes, please try again.');
			}
		}
		redirect($this->_homeRoute);
	}

	public function save_role()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model($this->_modelRoot . 'model_randp', 'randp');

			if ($_POST['role_id'] == '0') {
				$saved = $this->randp->insertRole($_POST);
			} else {
				$saved = $this->randp->updateRole($_POST);
			}

			if ($saved) {
				$this->setFlashMessage('Successful!', 'success', 'Role was saved.');
			} else {
				$this->setFlashMessage('Failure', 'error', 'There was a problem saving your changes, please try again.');
			}
		}
		redirect($this->_homeRoute);
	}

	public function add_role()
	{
		// Alias $data
		$data = &$this->data;

		$data['primaryView'] = $this->_viewRoot .'role_add';
		$data['pageTitle']   = 'New Role :: MTM Reporting';
		$data['templateStyle']  = 'sidebar';
		$data['subNavBar']     = 'app/nav_users';

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}

	public function delete_role()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model($this->_modelRoot . 'model_randp', 'randp');
			$deleted = $this->randp->deleteRole($_POST['role_id']);
			if ($deleted)
			{
				$this->setFlashMessage('Successful!', 'success', 'Role was deleted.');
			} else {
				$this->setFlashMessage('Failure', 'error', 'There was a problem saving your changes, please try again.');
			}
		}
		redirect($this->_homeRoute);
	}


	public function restore_role()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model($this->_modelRoot . 'model_randp', 'randp');
			$restored = $this->randp->restoreRole($_POST['role_id']);
			if ($restored) {
				$this->setFlashMessage('Successful!', 'success', 'Role was restored.');
			} else {
				$this->setFlashMessage('Failure', 'error', 'There was a problem saving your changes, please try again.');
			}
		}
		redirect($this->_homeRoute);
	}

	public function associate_permissions($role_id)
	{
		// Alias $data
		$data = &$this->data;

		$data['primaryView'] = $this->_viewRoot .'role_to_permissions';
		$data['pageTitle']   = 'Role Permission Association :: MTM Reporting';
		$data['templateStyle']  = 'sidebar';
		$data['subNavBar']     = 'app/nav_users';

		$this->load->model($this->_modelRoot . 'model_randp', 'randp');
		$data['role']	= $this->randp->getRole($role_id);
		$data['permissions'] = $this->randp->getPermissionRole($role_id);

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}

	public function associate_to_permission()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model($this->_modelRoot . 'model_randp', 'randp');
			$_POST['permissions'] = (isset($_POST['permissions'])) ? $_POST['permissions'] : [];
			$updated = $this->randp->associateRoles($_POST['role_id'], $_POST['permissions']);
			if ($updated) {
				$this->setFlashMessage('Successful!', 'success', 'Roles were associated.');
			} else {
				$this->setFlashMessage('Failure', 'error', 'There was a problem saving your changes, please try again.');
			}
		}
		if (isset($_POST['rdr']))
		{
			redirect($_POST['rdr']);
		}
		else
		{
			redirect($this->_routeRoot . 'associate_permissions/' . $_POST['role_id']);
		}
	}
}
/* End of file Roles.php */
