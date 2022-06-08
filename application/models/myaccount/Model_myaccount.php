<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Model_myaccount extends MY_Model
{

    protected $_table = 'user';

	protected $accessibleFields = [
		'first_name', 'last_name', 'company_name', 'email', 'address',
		'city', 'state', 'zip', 'title', 'password', 'question1', 'question2',
		'question1_answer', 'question2_answer'
		];

	public function __construct()
    {
		parent::__construct();
    }

    public function getUser($id = false)
    {
        return  $this->db->where('user_id', $id)->get('users')->row();
    }

	public function updateUser($data)
	{
		$data = $this->permittedFields($data, $this->accessibleFields, 'update');
		$this->writeDB->where('user_id', $this->input->post('user_id'))
				->set($data)
				->update('users');

		if ($this->writeDB->affected_rows() >= 0) {
			return true;
		} else {
			return false;
		}

	}

	public function getLoginActivity($id)
	{
		return $this->db->where('user_id', $id)
						->where('activity_time > ', subtractDays(90))
						->order_by('activity_time', 'desc')
						->get('log_auth');
	}
}
