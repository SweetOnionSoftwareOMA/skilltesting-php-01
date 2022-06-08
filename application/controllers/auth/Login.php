<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends Base_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Model_session_management', 'm_sessions');
		$this->load->model("auth/Model_auth", 'm_auth');
		$this->load->model("app/Model_users", 'm_users');
		$this->load->helper('captcha');

		$permission = $this->router->fetch_class().'-'.$this->router->fetch_method();
		if (isset($_SESSION['user_id']) && in_array($permission, array('login-index', 'login-session_timedout', 'login-forgot_password'))) {
			$this->setFlashMessage('Not Applicable', 'success', 'You are already logged in.');
			redirect('app/dashboard');
		}
	}

	public function index()
	{
		$data = &$this->data;
		$data['primaryView']      = 'auth/login';
		$data['pageFunction']     = 'login';
		$data['pageClass']        = 'hold-transition login-page';
		$data['pageTitle']        = 'Login :: MTM Reporting';
		$data['templateStyle']    = 'default';
		// Workaround to make passing variables to sub-views easier
		$data['embeddedData']     = $data;
		$this->load->view('layouts/default_template', $data);
	}

	public function authenticate()
	{
		$user = $this->m_auth->validatePassword($_POST['username'], $_POST['password']);
		if ($user) {
			$this->_buildSession($this->m_auth->getUserByUsername($_POST['username']));
			redirect('app/dashboard');
		} else {
			$this->setFlashMessage('Not Authorized', 'error', 'Authentication failed, please try again.');
			$this->_increaseAttempts();
		}
		redirect('login');
	}

	public function logout()
	{
		$this->_destroySession();
		redirect('/login/');
	}

	public function session_timedout()
	{
		$data = &$this->data;

		$data['pageFunction']  = 'login';
		$data['pageClass']     = 'login-page session-timeout';
		$data['pageTitle']     = 'Session Ended :: MTM Reporting';
		$data['templateStyle'] = 'default';
		$data['primaryView']   = 'auth/timed_out';

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}

	public function forgot_password($step = 1)
	{
		$data = &$this->data;

		$data['pageFunction']     = 'login';
		$data['pageClass']        = 'login-page';
		$data['pageTitle']        = 'Forgot Password :: MTM Reporting';
		$data['templateStyle']    = 'default';

		if ($step == 1) {
			$this->_destroySession();
			$data['primaryView']     = 'auth/forgot_password';
			$this->load->view('layouts/default_template', $data);
		} elseif ($step == 2 && $this->input->server('REQUEST_METHOD') == 'POST') {
			$this->_sendResetEmail($_POST);
			$data['primaryView']     = 'auth/reset_email_sent';
			$this->load->view('layouts/default_template', $data);
		} else {
			redirect('forgot_password');
		}
	}

	public function password_reset($resetToken, $hashedUserID)
	{
		$data = &$this->data;

		$data['pageFunction']     = 'login';
		$data['pageClass']        = 'login-page';
		$data['pageTitle']        = 'Reset Password :: MTM Reporting';
		$data['templateStyle']    = 'default';

		list($validKey, $user) = $this->m_auth->validateUserPasswordReset(urldecode($resetToken), urldecode($hashedUserID));
		if ($validKey) {
			$data['primaryView']     = 'auth/proceed_with_reset';
			$data['user'] = $user;
			$this->session->set_userdata(['user_id' => $user->user_id, 'username' => $user->email, 'attemptCount' => null]);
		} else {
			$data['primaryView']     = 'auth/invalid_reset';
		}

		$this->load->view('layouts/default_template', $data);
	}

	public function challenge_questions()
	{
		$data = &$this->data;

		if (session_id() != $_POST['sessionID']) {
			redirect('/login');
		}

		if (isset($_SESSION['user_id'])) {
			// If they fail to answer correctly and are redirected
			$data['user'] = $this->m_auth->getUser($_SESSION['user_id']);
		} else {
			// Did not arrive here using a correct method
			redirect('/login');
		}

		$data['pageFunction']     = 'login';
		$data['pageClass']        = 'login-page';
		$data['pageTitle']        = 'Challenge Question :: MTM Reporting';
		$data['templateStyle']    = 'default';
		$data['primaryView']      = 'auth/challenge_questions';

		$this->load->view('layouts/default_template', $data);
	}

	public function validate_challenge()
	{
		if (session_id() != $_POST['sessionID']) {
			redirect('/login');
		}

		$valid = $this->m_auth->validateChallengeQuestions($_POST['question1_answer'], $_POST['question2_answer'], $_SESSION['user_id']);

		if ($valid) {
			redirect('/auth/login/force_password_reset/' .session_id());
		} else {
			redirect('login');
		}
	}

	public function force_password_reset($sessionID)
	{
		if (session_id() != $sessionID) {
			redirect('/login');
		}

		$data = &$this->data;

		$data['pageFunction']     = 'login';
		$data['pageClass']        = 'login-page';
		$data['pageTitle']        = 'Reset Password :: MTM Reporting';
		$data['templateStyle']    = 'default';
		$data['primaryView']      = 'auth/force_password_reset';

		$this->load->view('layouts/default_template', $data);
	}

	public function savePassword()
	{
		if (session_id() != $_POST['sessionID']) {
			redirect('/login');
		}

		if ($_POST['password1'] != $_POST['password2']) {
			// THis should never happen as there is client side validation, but never hurts to check twice.`
			$this->setFlashMessage('Password Update Failed', 'warning', 'Your passwords did not match, please try again.');
			redirect('/auth/login/force_password_reset/' .session_id());
		}

		$saved = $this->m_auth->savePassword($_SESSION['user_id'], $_POST);
		if ($saved) {
			$user = $this->m_auth->getUser($_SESSION['user_id']);
			$this->_buildSession($user);
			$this->_successfulResetEmail($user);
			$this->setFlashMessage('Success', 'success', 'Your Password has been changed');
			redirect('/my-profile');
		} else {
			$this->setFlashMessage('Update Failed', 'danger', 'There was a problem saving, please try again.');
			redirect('/auth/login/force_password_reset/' . session_id());
		}
	}

	/** PRIVATE FUNCTIONS **/
	private function _buildSession($user)
	{
		// Must set the USER ID so the AUTH library has access to the "SESSION USERID"
		$this->session->set_userdata(['user_id' => $user->user_id, 'username' => $user->username, 'name' => trim($user->title.' '.$user->first_name.' '.$user->last_name), 'attemptCount' => null]);

		// Finish setting up session
		$userRoles 										= $this->authuser->getRoles($user->user_id);
		$userPermissions 								= $this->authuser->getPermissions($user->user_id, $userRoles);

		$userOffices        							= $userOrganizations = array();
		if ($this->authuser->isSuperAdmin()) {//If super admin fetch all organizations
			$this->load->model("app/Model_organizations", 'm_organizations');
			$query 										= $this->m_organizations->getAllOrganizations(false);
		} else {
			$query 										= $this->m_users->getUserOrganizations(false, $user->user_id);
		}

		if ($query->num_rows()>0) {
			foreach($query->result() as $row) {
				$organization_id 						= $row->organization_id;
				$organization_name 						= $row->organization_name;
				$userOrganizationID 					= $organization_id;
				$userOrganizations[$userOrganizationID] = $organization_name;
			}
		}

		if (sizeof($userOrganizations)){

			if ($this->authuser->isSuperAdmin()) {//If super admin fetch all offices in organizations
				$query 									= $this->m_organizations->getOrganizationOffices(implode(',', array_keys($userOrganizations)));
			} else {
				$query 									= $this->m_users->getUserOffices(false, $user->user_id, array_keys($userOrganizations));
			}

			if ($query->num_rows()>0) {
				foreach($query->result() as $row) {
					$userOffices[$row->office_id] 		= array('name' => $row->office_name, 'color' => $row->office_color, 'notify_email_address' => $row->notify_email_address, 'notify_new_data' => $row->notify_new_data);
				}
			}
		}

		$this->session->set_userdata(
			[
				'logged_in' => true,
				'user_roles' => $userRoles,
				'user_permissions' => $userPermissions,
				'user_organizations' => $userOrganizations,
				'user_offices' => $userOffices,
				'user_isSA' => $this->authuser->isSuperAdmin(),
				'impersonating' => false,                // NOT IMPLEMENTED YET
				'admin_user_id' => false,                // NOT IMPLEMENTED YET
			]
		);

		// Write Session, Ensure it is in the DB to update
		session_write_close();

		// Document the user logged in
		$this->m_auth->recordLoginAttempt($_SESSION['user_id']);
		$this->m_sessions->addUsernameToSession(session_id());
	}

	private function _destroySession()
	{
		// Only destroy if user was logged in, otherwise we need to track attempt Counts
		if (isset($_SESSION['user_id'])) {
			$this->load->model('session_management', 'm_sessions');
			$this->m_sessions->endSession(session_id());
			$this->session->sess_destroy();
		}
	}

	private function _increaseAttempts()
	{
		isset($_SESSION['attemptCount']) ? $_SESSION['attemptCount']++ : $_SESSION['attemptCount'] = 1;
	}

	private function _sendResetEmail($data)
	{
		if ($this->m_auth->verifyValidUser($data['username'])) {
			$body['user'] = $this->m_auth->requestResetToken($data['username']);
			$email_body = $this->load->view('email_templates/auth/password_reset_request', $body, true);
			$this->load->library('email');

			$this->email->from(AUTHMAILER_FROM_EMAIL, AUTHMAILER_FROM_NAME);
			$this->email->to($body['user']->email);
			$this->email->subject(EMAIL_SUBJECT_START .'Password Reset Request');
			$this->email->message($email_body);
			$this->email->send();
		}
	}

	private function _successfulResetEmail($user)
	{
		$email_body = $this->load->view('email_templates/auth/password_changed', $user, true);
		$this->load->library('email');

		$this->email->from(AUTHMAILER_FROM_EMAIL, AUTHMAILER_FROM_NAME);
		$this->email->to($user->email);
		$this->email->subject(EMAIL_SUBJECT_START . 'Password Changed');
		$this->email->message($email_body);
		$this->email->send();
	}
}
