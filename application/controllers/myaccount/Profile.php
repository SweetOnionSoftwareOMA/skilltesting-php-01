<?php defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends Auth_Controller
{

	private $_homeRoute = 'my-profile';

	public function __construct()
	{
		parent::__construct();
		$this->data['subNavBar']      = 'app/nav_primary';
		$this->data['templateStyle']  = 'sidebar';
	}

    public function index()
    {
        // Alias $data
        $data = &$this->data;

		$data['primaryView']    = 'myaccount/edit';
		$data['pageTitle']		= 'Profile :: MTM Reporting';
		$data['heading']        = 'My Profile';
		$data['breadcrumb']     = array('#' => 'My Profile');

		$this->load->model('myaccount/Model_myaccount', 'user_model');
		$this->load->model('Model_lookups', 'lookups');

		$data['user'] = $this->user_model->getUser($_SESSION['user_id']);
		$data['states'] = $this->lookups->statesAbbrKey(TRUE);
		$this->load->view('layouts/'.$data['templateStyle'].'_template', $data);
    }

    public function update()
    {
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$this->load->model('myaccount/Model_myaccount', 'user_model');
			$saved = $this->user_model->updateUser($_POST);
			if ($saved) {
				$this->setFlashMessage('Successful!','success','Profile was updated.');
				// $this->writeToLog([
				// 				'user_id'  	 	=> $_SESSION['user_id'],
				// 				'object_class'  => 'user',
				// 				'object_id'  	=> $_SESSION['user_id'],
				// 				'action'  		=> 'update',
				// 			]);
			} else {
				$this->setFlashMessage('Failure', 'error', 'There was a problem saving your changes, please try again.');
			}
		}
		redirect($this->_homeRoute);
    }

	public function changepassword()
	{
		if (($this->input->server('REQUEST_METHOD') == 'POST') && ($_POST['pass1'] == $_POST['pass2']))
		{
			$_POST['password'] = password_hash($_POST['pass1'], PASSWORD_DEFAULT);
			$this->load->model('myaccount/Model_myaccount', 'user_model');
			$saved = $this->user_model->updateUser($_POST);
			if ($saved) {
				// $this->_successfulResetEmail($this->user_model->getUser($_POST['user_id']));
				$this->setFlashMessage('Successful!', 'success', 'Password has been changed successfully.');
			} else {
				$this->setFlashMessage('Failure', 'error', 'Unable to change your password, please try again.');
			}
		}
		redirect($this->_homeRoute);
	}

	public function loginHistory()
	{
		// Alias $data
		$data = &$this->data;

		$this->load->model('myaccount/Model_myaccount', 'user_model');

		$data['primaryView']    = 'myaccount/loginhistory';
		$data['pageTitle']	= 'Profile  :: MTM Reporting';
		$data['templateStyle'] = 'sidebar';
		$data['logins'] = $this->user_model->getLoginActivity($_SESSION['user_id']);

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}

	private function _successfulResetEmail($user)
	{
		$data['user'] = $user;
		$email_body = $this->load->view('email_templates/auth/password_changed', $data, TRUE);
		$this->load->library('email');

		$this->email->from(AUTHMAILER_FROM_EMAIL, AUTHMAILER_FROM_NAME);
		$this->email->to($user->email);
		$this->email->subject(EMAIL_SUBJECT_START . 'Password Changed');
		$this->email->message($email_body);
		$this->email->send();
	}
}
/* End of file Profiles.php */
