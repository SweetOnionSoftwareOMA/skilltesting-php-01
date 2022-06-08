<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Model_office_manager extends MY_Model
{
	protected $_table = 'users';

	protected $accessibleFields = ['title', 'first_name', 'last_name', 'username', 'email', 'password', 'question1', 'question1_answer', 'question2', 'question2_answer', 'created_at'];

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * returns count of the users in associated offices
	 *
	 * @param bool $showDeleted

	 * @param array $offices
	 *
	 * @return CIRESULT COUNT
	 */
	public function getOfficeUsersCount($showDeleted = false, $offices, $keyword)
	{
		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();

		$this->db->select($this->_table.'.user_id');
		$this->db->join('offices_users', 'offices_users.user_id=users.user_id');
		$this->db->where($this->_table.'.user_id !=', $this->session->userdata('user_id'));
		$this->db->where_in('offices_users.office_id', $offices);
		$this->db->group_by($this->_table.'.user_id');

		if ($keyword)
		{
			$this->db->group_start();
			$this->db->like($this->_table.'.title', $keyword);
			$this->db->or_like($this->_table.'.first_name', $keyword);
			$this->db->or_like($this->_table.'.last_name', $keyword);
			$this->db->or_like($this->_table.'.username', $keyword);
			$this->db->or_like($this->_table.'.email', $keyword);
			$this->db->group_end();
		}

		return $this->db->count_all_results($this->_table);
	}

	/**
	 * returns all users in associated offices
	 *
	 * @param bool $showDeleted
     *
	 * @param array $offices
	 *
	 * @return CIRESULT
	 */
	public function getAllOfficeUsers($showDeleted = false, $offices, $start, $length, $order_by, $order, $keyword)
	{
		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();

		$this->db->select($this->_table.'.*');
		$this->db->join('offices_users', 'offices_users.user_id=users.user_id');
		$this->db->where($this->_table.'.user_id !=', $this->session->userdata('user_id'));
		$this->db->where_in('offices_users.office_id', $offices);
		$this->db->group_by($this->_table.'.user_id');

		if ($keyword)
		{
			$this->db->group_start();
			$this->db->like($this->_table.'.title', $keyword);
			$this->db->or_like($this->_table.'.first_name', $keyword);
			$this->db->or_like($this->_table.'.last_name', $keyword);
			$this->db->or_like($this->_table.'.username', $keyword);
			$this->db->or_like($this->_table.'.email', $keyword);
			$this->db->group_end();
		}

		if ($length > 0)
     		$this->db->limit($length, $start);

	    $this->db->order_by($order_by, $order);

		return $this->db->get($this->_table);
	}

	/**
	 * returns all users in associated offices
	 *
	 * @param bool $showDeleted
	 *
	 * @param bool $user_id
     *
	 * @param array $offices
	 *
	 * @return CIRESULT
	 */
	public function getOfficeUser($showDeleted = false, $user_id, $offices)
	{
		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();

		$this->db->select($this->_table.'.*');
		$this->db->join('offices_users', 'offices_users.user_id=users.user_id');
		$this->db->where_in('offices_users.office_id', $offices);
		$this->db->where($this->_table.'.user_id', $user_id);
		return $this->db->get($this->_table);
	}

	/**
	 * returns all assignable roles
	 *
	 * @param bool $showDeleted
     *
	 * @return CIRESULT
	 */
	public function getAssignableRoles($showDeleted = false)
	{
		$this->db->group_start();
		$this->db->where('roles.deleted', $showDeleted)->or_where('roles.deleted', false);
		$this->db->group_end();

		return $this->db->select('roles.role_id, roles.role_name')
						->where('office_manager_can_assign', true)
						->get('roles');
	}

	/**
	 * @param $email
	 * @return mixed
	 * get user from email
	 */
	public function getUserFromEmail($email)
	{
		return $this->db->where('email', $email)->get('users')->row();
	}

	/**
	 * @param $username
	 * @return mixed
	 * get user from username
	 */
	public function getUserFromUsername($username)
	{
		return $this->db->where('username', strtolower($username))->get('users')->row();
	}

	/**
	 * @param $data
	 * @return array
	 * create new user and assign organizations, offices and roles
	 */
	public function createOfficeUser($data)
	{
		$data['password'] 			= password_hash($data['password'], PASSWORD_DEFAULT);
		$data['username'] 			= strtolower($data['username']);

		$data['question1'] 			= '0';
		$data['question1_answer'] 	= '';
		$data['question2'] 			= '0';
		$data['question2_answer'] 	= '';

		$user 						= $this->permittedFields($data, $this->accessibleFields, 'insert');
		$user 						= $this->updateTimestamps($user, 'insert');
		if(!is_null($this->getUserFromEmail($data['email']))) {
			$response['success'] 	= false;
			$response['dbError'] 	= true;
			$response['message'] 	= "Email has already been taken.";
			return $response;
		}

		$flag						= $this->writeDB->trans_start();

		if ($flag) {
			$flag  					= $this->writeDB->insert($this->_table, $user);
		}

		$response 					= array();
		$flag 						= $this->writeDB->affected_rows() === 1;
		$response["success"] 		= $flag;

		if($flag) {
			$user_id 				= $this->db->insert_id();
			$user_organizations 	= explode(',', $data["user_organizations"]);
			$organization_user 		= array();

			foreach ($user_organizations as $user_organization) {
				$organization_user[]= array('user_id' => $user_id, 'organization_id' => $user_organization);
			}

			if (sizeof($organization_user)){
				$flag 				= $this->writeDB->insert_batch('organizations_users', $organization_user);
			}
		}

		if($flag) {
			$office_user 			= array();
			foreach ($data['cbOffices'] as $office_id) {
				$office_user[] 		= array('user_id' => $user_id, 'office_id' => $office_id);
			}

			if (sizeof($office_user)){
				$this->writeDB->insert_batch('offices_users', $office_user);
			}
		}

		if($flag) {
			$role_user 				= array();
			$data['cbRoles'][]    	= 2;
			foreach ($data['cbRoles'] as $role_id) {
				$role_user[]		= ['user_id' => $user_id, 'role_id' => $role_id];
			}

			if (sizeof($office_user)) {
				$flag 				= $this->writeDB->insert_batch('roles_users', $role_user);
			}
		}

		if ($flag) {
			$this->writeDB->trans_commit();
			$response['user_id'] 	= $user_id;
		} else {
			$this->writeDB->trans_rollback();
		}
		return $response;
	}

	/**
	 * @param $data
	 * @return array
	 * create new user and assign organizations, offices and roles
	 */
	public function updateOfficeUser($user_id, $data)
	{
		$user 						= $this->permittedFields($data, $this->accessibleFields, 'update');
		$user 						= $this->updateTimestamps($user, 'update');

		if (!is_blank($user['password'])) {
			$user['password'] 		= password_hash($user['password'], PASSWORD_DEFAULT);
		}

		$flag						= $this->writeDB->trans_start();
		$user						= $this->updateTimestamps($user, 'update');

		if ($flag) {
			$this->writeDB->where('user_id', $user_id)
						  ->set($user)
						  ->update('users');
			$flag					= $this->writeDB->affected_rows();
		}

		if ($flag) {
			$this->writeDB->where('user_id', $user_id)->delete('offices_users');

			$office_user 			= array();
			foreach ($data['cbOffices'] as $office_id) {
				$office_user[] 		= array('user_id' => $user_id, 'office_id' => $office_id);
			}

			if (sizeof($office_user)) {
				$flag  				= $this->writeDB->insert_batch('offices_users', $office_user);
			}
		}

		if ($flag) {
			$flag  					= $this->writeDB->where('user_id', $user_id)->delete('roles_users');

			$role_user 				= array();
			$data['cbRoles'][]    	= 2;
			foreach ($data['cbRoles'] as $role_id) {
				$role_user[]		= ['user_id' => $user_id, 'role_id' => $role_id];
			}

			if (sizeof($office_user)) {
				$flag  				= $this->writeDB->insert_batch('roles_users', $role_user);
			}
		}

		if ($flag) {
			$this->writeDB->trans_commit();
			return true;
		} else {
			$this->writeDB->trans_rollback();
			return false;
		}
	}

	public function deleteOfficeUser($user_id)
	{
		$data = ['deleted' => true];
		$data = $this->updateTimestamps($data, 'delete');
		$this->writeDB->where('user_id', $user_id)
						->set($data)
						->update('users');

		if ($this->writeDB->affected_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}
}
