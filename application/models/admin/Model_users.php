<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Model_users extends MY_Model
{
	protected $_table = 'users';

	protected $accessibleFields = ['first_name', 'last_name', 'title', 'company_name', 'address', 'city', 'state', 'zip', 'email', 'username', 'password', 'question1', 'question1_answer', 'question2', 'question2_answer', 'created_at'];

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * returns count of the users
	 *
	 * @param bool $showDeleted
	 *
	 * @return CIRESULT COUNT
	 */
	public function getUsersCount($showDeleted = false, $keyword)
	{
		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();

		//Exclude current logged in
		$this->db->where($this->_table.'.user_id !=', $this->session->userdata('user_id'));

		$this->db->select($this->_table.'.user_id');

		if ($keyword)
		{
			$this->db->group_start();
			$this->db->like($this->_table.'.first_name', $keyword);
			$this->db->or_like($this->_table.'.last_name', $keyword);
			$this->db->or_like($this->_table.'.title', $keyword);
			$this->db->or_like($this->_table.'.email', $keyword);
			$this->db->or_like($this->_table.'.username', $keyword);
			$this->db->group_end();
		}

		return $this->db->count_all_results($this->_table);
	}

	/**
	 * returns all users in associated users
	 *
	 * @param bool $showDeleted
     *
	 * @return CIRESULT
	 */
	public function getAllUsers($showDeleted = false, $start, $length, $order_by, $order, $keyword)
	{
		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();

		//Exclude current logged in
		$this->db->where($this->_table.'.user_id !=', $this->session->userdata('user_id'));

		$this->db->select($this->_table.'.*');

		if ($keyword)
		{
			$this->db->group_start();
			$this->db->like($this->_table.'.first_name', $keyword);
			$this->db->or_like($this->_table.'.last_name', $keyword);
			$this->db->or_like($this->_table.'.title', $keyword);
			$this->db->or_like($this->_table.'.email', $keyword);
			$this->db->or_like($this->_table.'.username', $keyword);
			$this->db->group_end();
		}

		if ($length > 0)
     		$this->db->limit($length, $start);

	    $this->db->order_by($order_by, $order);
;
		return $this->db->get($this->_table);
	}

	/**
	 * returns all users in associated users
	 *
	 * @param bool $showDeleted
	 *
	 * @param bool $user_id
	 *
	 * @return CIRESULT
	 */
	public function getUser($showDeleted = false, $user_id)
	{
		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();
		$this->db->select($this->_table.'.user_id, '.$this->_table.'.title, '.$this->_table.'.first_name, '.$this->_table.'.last_name, '.$this->_table.'.email, '.$this->_table.'.username, '.$this->_table.'.created_at');
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
						->where('user_manager_can_assign', true)
						->get('roles');
	}

	/**
	 * @param $username
	 * @return mixed
	 * get user from username
	 */
	public function getUserFromUsername($username)
	{
		return $this->db->where('username', strtolower($username))->get($this->_table)->row();
	}

	/**
	 * @param $data
	 * @return array
	 * create new user and assign organizations, users and roles
	 */
	public function createUser($data)
	{
		$data['question1'] 						= 0;
		$data['question1_answer'] 				= '';
		$data['question2'] 						= 0;
		$data['question2_answer'] 				= '';
		$data['username'] 						= strtolower($data['username']);

		$data['password'] 						= password_hash($data['password'], PASSWORD_DEFAULT);

		$user									= $this->permittedFields($data, $this->accessibleFields, 'insert');
		$user 									= $this->updateTimestamps($user, 'insert');

		if(!is_null($this->getUserFromUsername($data['username']))) {
			$response['success'] 				= false;
			$response['dbError'] 				= true;
			$response['message'] 				= "Username already exists.";
			return $response;
		}

		$flag									= $this->writeDB->trans_start();

		if ($flag) {
			$flag 								= $this->writeDB->insert($this->_table, $user);
			$response 							= array();
			$response["success"] 				= $this->writeDB->affected_rows() === 1;
		}

		if ($flag) {
			$user_id 							= $this->db->insert_id();
			$offices_users 						= $organizations_users = array();

			// Fetch organizations of offices
			if (sizeof($data['cbOffices'])) {
				$organizations 					= $this->db->select('organization_id')
														   ->where_in('office_id', $data['cbOffices'])
														   ->get('offices_organizations')
														   ->result();
			}

			foreach ($organizations as $row) {
				$organizations_users[] 			= array('user_id' => $user_id, 'organization_id' => $row->organization_id);
			}

			if (sizeof($organizations_users)) {
				$flag 							= $this->writeDB->insert_batch('organizations_users', $organizations_users);
			}
		}

		if ($flag) {
			foreach ($data['cbOffices'] as $office_id) {
				$offices_users[]				= array('user_id' => $user_id, 'office_id' => $office_id);
			}

			if (sizeof($offices_users)){
				$flag 							= $this->writeDB->insert_batch('offices_users', $offices_users);
			}
		}

		if ($flag) {
			$roles_users 						= array();
			foreach ($data['cbRoles'] as $role_id) {
				$roles_users[] 					= array('role_id' => $role_id, 'user_id' => $user_id);
			}

			if (sizeof($roles_users)) {
				$flag 							= $this->writeDB->insert_batch('roles_users', $roles_users);
			}
		}

		if ($flag) {
			$this->writeDB->trans_commit();
			$response['user_id'] 				= $user_id;
			return $response;
		} else {
			$this->writeDB->trans_rollback();
			return false;
		}
	}

	/**
	 * @param int $user_id
	 *
	 * @param array $data
	 *
	 * @return array
	 *
	 * update user and assign organizations and users
	 */
	public function updateUser($user_id, $data)
	{
		$user 									= $this->permittedFields($data, $this->accessibleFields, 'update');
		$user 									= $this->updateTimestamps($user, 'update');

		if (!is_blank($user['password'])) {
			$user['password'] 					= password_hash($user['password'], PASSWORD_DEFAULT);
		} else {
			unset($user['password']);
		}

		$flag									= $this->writeDB->trans_start();

		if ($flag) {
			$flag 								= $this->writeDB->where('user_id', $user_id)
					  									    	->set($user)
					  									    	->update($this->_table);
			$flag								= $this->writeDB->affected_rows();
		}

		if ($flag) {
			$offices_users 						= $organizations_users = array();

			// Fetch organizations of offices
			if (sizeof($data['cbOffices'])) {
				$organizations 					= $this->db->select('organization_id')
														   ->where_in('office_id', $data['cbOffices'])
														   ->get('offices_organizations')
														   ->result();
			}

			foreach ($organizations as $row) {
				$organizations_users[] 			= array('user_id' => $user_id, 'organization_id' => $row->organization_id);
			}

			$flag 								= $this->writeDB->where('user_id', $user_id)->delete('organizations_users');

			if (sizeof($organizations_users) && $flag) {
				$flag 							= $this->writeDB->insert_batch('organizations_users', $organizations_users);
			}
		}

		if ($flag) {
			foreach ($data['cbOffices'] as $office_id) {
				$offices_users[]				= array('user_id' => $user_id, 'office_id' => $office_id);
			}

			$flag 								= $this->writeDB->where('user_id', $user_id)->delete('offices_users');

			if (sizeof($offices_users) && $flag){
				$flag 							= $this->writeDB->insert_batch('offices_users', $offices_users);
			}
		}

		if ($flag) {
			$roles_users 						= array();
			foreach ($data['cbRoles'] as $role_id) {
				$roles_users[] 					= array('role_id' => $role_id, 'user_id' => $user_id);
			}

			$flag 								= $this->writeDB->where('user_id', $user_id)->delete('roles_users');

			if (sizeof($roles_users) && $flag) {
				$flag 							= $this->writeDB->insert_batch('roles_users', $roles_users);
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

	/**
	 * recover user
	 *
	 * @param int $user_id
	 *
	 */
	public function recoverUser($user_id)
	{
		$data 		= ['deleted' => false, 'deleted_at' => null];
		$data 		= $this->updateTimestamps($data, 'update');
		$this->writeDB->where('user_id', $user_id)
					  ->set($data)
					  ->update('users');

		if ($this->writeDB->affected_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * delete user
	 *
	 * @param int $user_id
	 *
	 */
	public function deleteUser($user_id)
	{
		$data = ['deleted' => true];
		$data = $this->updateTimestamps($data, 'delete');
		$this->writeDB->where('user_id', $user_id)
						->set($data)
						->update($this->_table);

		if ($this->writeDB->affected_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * get user's roles
	 *
	 * @param int $user_id
	 *
	 * @return CIRESULT
	 */
	public function getUserRoles($showDeleted = false, $user_id)
	{
		$this->db->group_start();
		$this->db->where('roles.deleted', $showDeleted)->or_where('roles.deleted', false);
		$this->db->group_end();

		return $this->db->select('roles.*')
					    ->join('roles', 'roles.role_id = roles_users.role_id')
					    ->where('user_id', $user_id)
					    ->get('roles_users');
	}

	/**
	 * returns all the user's offices
	 *
	 * @param bool $showDeleted
	 *
	 * @param int $user_id
	 *
	 * @return CIRESULT
	 */
	public function getUserOffices($showDeleted = false, $user_id)
	{
		$this->db->group_start();
		$this->db->where('offices.deleted', $showDeleted)->or_where('offices.deleted', false);
		$this->db->group_end();

		return $this->db->select('offices.office_id, offices.office_name')
					    ->join('offices_users', 'offices_users.office_id=offices.office_id')
					    ->where('offices_users.user_id', $user_id)
					    ->get('offices');
	}
}
