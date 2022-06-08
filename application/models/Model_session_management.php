<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Model_session_management extends MY_Model
{

    protected $_table = 'ci_sessions';
    protected $accessibleFields = ['data', 'id', 'ip_address', 'username'];


	public function endSession($session_id)
	{
		$this->sessionDB->set(['ended_at' => UTC_Now()])
						->where('id', $session_id)
						->update($this->_table);
	}

	public function addUsernameToSession($session_id)
	{
		$message = "Adding username - " . $_SESSION['username'] . " - to session";
		log_message('info', $message);
		$this->sessionDB->set(['username' => $_SESSION['username']])
							->where('id', $session_id)
							->update($this->_table);

	}
}

/* End of file Model_session_management.php */
