<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usermgt extends Auth_Controller {

	protected $_homeRoute = 'app/usermgt/user_list';

    public function index()
	{
		// Alias $data
		$data = &$this->data;

		$data['primaryView'] = 'app/usermgt/index';
		$data['pageTitle']   = 'User Manager :: MTM Reporting';
		$data['templateStyle']	= 'sidebar';
		$data['subNavBar']	= 'app/nav_users';

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}

	public function user_list()
	{
		// Alias $data
		$data = &$this->data;

		$data['primaryView']    = 'app/usermgt/user_list';
		$data['pageTitle']	= 'User List :: MTM Reporting';
		$data['templateStyle']	= 'sidebar';
		$data['subNavBar']	= 'app/nav_users';

		$this->load->model('app/model_users', 'users');
		$showDeletedUsers = false;
		if ($this->input->get('deleted') == 'true') { $showDeletedUsers = true;}
		$data['users'] = $this->users->getAllUsers($showDeletedUsers);

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}

	public function user_add()
	{
		// Alias $data
		$data = &$this->data;

		$data['primaryView']    = 'app/usermgt/user_add';
		$data['pageTitle']	= 'User List :: MTM Reporting';
		$data['templateStyle']	= 'sidebar';
		$data['subNavBar']	= 'app/nav_users';

		$this->load->model('Model_lookups', 'lookups');
		$data['states'] = $this->lookups->statesAbbrKey(TRUE);

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}

	public function edit_user($user_id)
	{
		// Alias $data
		$data = &$this->data;

		$data['primaryView']    = 'app/usermgt/user_edit';
		$data['pageTitle']	= 'User List :: MTM Reporting';
		$data['templateStyle']	= 'sidebar';
		$data['subNavBar']	= 'app/nav_users';

		$this->load->model('app/model_users', 'users');
		$this->load->model('Model_lookups', 'lookups');

		$data['states'] = $this->lookups->statesAbbrKey(TRUE);
		$data['user'] = $this->users->getUser($user_id)->row();

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}

	public function update()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('app/model_users', 'user_model');
			if ($_POST['user_id'] == '0'){
				// Generates a random password
				// $_POST['password'] = password_hash( substr(md5(time()), 0, 16), PASSWORD_DEFAULT);
				$_POST['password'] = password_hash( 'vpp!Password123', PASSWORD_DEFAULT);
				$saved = $this->user_model->insertUser($_POST);
			}
			else
			{
				$saved = $this->user_model->updateUser($_POST);
			}

			if ($saved) {
				$this->setFlashMessage('Successful!', 'success', 'User was updated.');
			} else {
				$this->setFlashMessage('Failure', 'error', 'There was a problem saving your changes, please try again.');
			}
		}
		redirect($this->_homeRoute);
	}

	public function remove_user()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('app/model_users', 'user_model');
			$deleted = $this->user_model->deleteUser($_POST['user_id']);
			if ($deleted) {
				$this->setFlashMessage('Successful!', 'success', 'User was updated.');
			} else {
				$this->setFlashMessage('Failure', 'error', 'There was a problem saving your changes, please try again.');
			}
		}
		redirect($this->_homeRoute);
	}

	public function	user_role_manager($user_id)
	{
		// Alias $data
		$data = &$this->data;

		$data['primaryView']    = 'app/usermgt/users_to_roles';
		$data['pageTitle']	= 'Role Mapper :: MTM Reporting';
		$data['templateStyle']	= 'sidebar';
		$data['subNavBar']	= 'app/nav_users';

		$this->load->model('app/model_users', 'user_model');

		$data['roles'] = $this->user_model->getValidRoles($user_id, $_SESSION['user_id'], $_SESSION['user_isSA']);
		$data['user'] = $this->user_model->getUser($user_id)->row();


		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);

	}

	public function activate_user()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('app/model_users', 'user_model');
			$updated = $this->user_model->reinstateUser($_POST['user_id']);
			if ($updated) {
				$this->setFlashMessage('Successful!', 'success', "User was reactivated.");
			} else {
				$this->setFlashMessage('Failure', 'error', 'There was a problem saving your changes, please try again.');
			}
		}
		redirect($this->_homeRoute);
	}

	public function update_roles()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('app/model_users', 'user_model');
			$updated = $this->user_model->updateRoles($_POST);
			if ($updated) {
				$this->setFlashMessage('Successful!', 'success', "Roles were updated.");
			} else {
				$this->setFlashMessage('Failure', 'error', 'There was a problem saving your changes, please try again.');
			}
		}
		redirect('app/usermgt/user_role_manager/'.$_POST['user_id']);
	}
}

/* End of file UsermgtController.php */
