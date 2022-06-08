<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// TODO: Add filtering to prevent automated attempts
class Model_auth extends My_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function getUserByEmail($email)
	{
		return $this->db->where('email', $email)->get('users')->row();
	}

	public function getUserByUsername($username)
	{
		return $this->db->where('username', strtolower($username))->get('users')->row();
	}

	public function verifyValidUser($username)
	{
		$q = $this->db->where('username', strtolower($username))->where('deleted', false)->get('users');
		$q = $q;
		return  ($q->num_rows() == 1);
	}

	public function requestResetToken($username)
	{
		$token = password_hash(substr(sha1(time() .strtolower($username)), 0, 24), PASSWORD_DEFAULT);
		$this->writeDB->set(['reset_token' => $token, 'reset_requested_at' => UTC_Now()])->where('username', strtolower($username))->update('users');

		$user = $this->getUserByUsername($username);

		// Log the Event to the user's auth log.
		$this->_recordPasswordChange($user->user_id, 'Reset Requested');

		return $user;
	}

	public function validateUserPasswordReset($resetToken, $hashedUserID)
	{
		$user = $this->db->where('reset_token', $resetToken)->get('users');
		if ($user->num_rows() == 1)
		{
			$user = $user->row();
			$hashKey = $user->user_id . $user->username;
			return [password_verify($hashKey, $hashedUserID), $user];
		}
		else
		{
			return [false, false];
		}
	}

	public function getUser($id)
	{
		return $this->db->where('user_id', $id)->get('users')->row();
	}

	public function searchUser($fields)
	{
		$r = $this->db->where($fields)->get('users');
		return $r;
	}

	public function validatePassword($username = null, $pass = null)
	{
		$user = $this->db->where('username', strtolower($username))
						 ->where('deleted', false)
						 ->get('users');

		if (count($user->result_array()) != 1) {
			return false;
		}

		$validPassword = password_verify($pass, $user->row()->password);

		if ($validPassword) {
			$this->recordLoginAttempt($user->row()->user_id, 'failed');
		}

		return $validPassword;
	}


	public function validateChallengeQuestions($answer1, $answer2, $user_id)
	{
		$q = $this->db->where('question1_answer', $answer1)
						->where('question2_answer', $answer2)
						->where('user_id', $user_id)
						->get('users');
		$user = $q->row();

		return [($q->num_rows() == 1), $user];
	}

	public function savePassword($user_id, $data)
	{
		$row = ['password' => password_hash($data['password1'], PASSWORD_DEFAULT)];
		$this->updateTimestamps($row, 'update');
		$this->writeDB->set($row)->where('user_id', $user_id)->update('users');
		$affected = $this->writeDB->affected_rows();

		// Log the Event to the user's auth log.
		$this->_recordPasswordChange($user_id, 'Password Reset');

		return ( $affected == 1);
	}

	public function recordLoginAttempt($user_id, $status = 'success', $impersonated = null)
	{
		$data = [
			'user_id'              => $user_id,
			'impersonate_user'     => $impersonated,
			'ipaddress'            => $_SERVER['REMOTE_ADDR'],
			'activity_time'        => UTC_Now(),
			'status'               => $status,
		];
		$this->writeDB->insert('log_auth', $data );
	}

	private function _recordPasswordChange($user_id, $status)
	{
		$data =
		[
			'user_id'              => $user_id,
			'impersonate_user'     => null,
			'ipaddress'            => $_SERVER['REMOTE_ADDR'],
			'activity_time'        => UTC_Now(),
			'status'               => $status,
		];
		$this->writeDB->insert('log_auth', $data);
	}
}
