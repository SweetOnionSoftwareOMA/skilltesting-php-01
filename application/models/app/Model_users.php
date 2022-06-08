<?php

defined('BASEPATH') or exit('No direct script access allowed');


class Model_users extends MY_Model
{

	protected $_table = 'users';

	protected $accessibleFields = [
		'first_name', 'last_name', 'company_name', 'email', 'address',
		'city', 'state', 'zip', 'title', 'password',
		'question1', 'question2', 'question1_answer', 'question2_answer'
	];

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * returns all the users in the MTM application
	 *
	 * @param bool $showDeleted
	 *
	 * @param bool $includeSuperAdmin
	 *
	 * @return CIRESULT
	 */
	public function getAllUsers($showDeleted = false, $includeSuperAdmin = true)
	{
		$this->db->select($this->_table.'.*');
		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();

		$this->db->join('roles_users ru', 'ru.user_id = '.$this->_table.'.user_id');
		$this->db->join('roles r', 'r.role_id = ru.role_id');

		if ($includeSuperAdmin === false):
			$this->db->where('r.super_admin', $includeSuperAdmin);
		endif;

		$this->db->group_by($this->_table.'.user_id');

		$query = $this->db->get('users');
		return $query;
	}

	public function getUser($user_id)
	{
		return $this->db->where('user_id', $user_id)->get('users');
	}

	public function updateUser($data)
	{
		$data = $this->permittedFields($data, $this->accessibleFields, 'update');
		$data = $this->updateTimestamps($data, 'update');
		$this->writeDB->where('user_id', $this->input->post('user_id'))
					  ->set($data)
					  ->update('users');

		if ($this->writeDB->affected_rows() >= 0) {
			return true;
		} else {
			return false;
		}
	}

	public function insertUser($data)
	{
		$data['question1'] = $data['question2'] = '0';
		$data['question1_answer'] = $data['question2_answer'] = $data['password'];
		$data = $this->permittedFields($data, $this->accessibleFields, 'insert');
		$data = $this->updateTimestamps($data, 'insert');
		$this->writeDB->insert('users', $data);

		if ($this->writeDB->affected_rows() >= 0) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteUser($user_id)
	{
		$data = ['deleted' => true];
		$data = $this->updateTimestamps($data, 'delete');
		$this->writeDB->where('user_id', $user_id)
						->set($data)
						->update('users');

		if ($this->writeDB->affected_rows() == 1)
		{
			return true;
		} else {
			return false;
		}
	}

	public function reinstateUser($user_id)
	{
		$data = ['deleted' => false, 'deleted_at' => null];
		$data = $this->updateTimestamps($data, 'update');
		$this->writeDB->where('user_id', $user_id)
						->set($data)
						->update('users');

		if ($this->writeDB->affected_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	public function getValidRoles($user_id, $auth_user_id, $isSa = false)
	{
		if ($isSa){
			//  If Site Super Admin, allow all role assignment.
			$sql = "select *,
							(select id from roles_users where user_id= ? and role_id = roles.role_id) as hasrole
					from roles;";
			$data = $this->db->query($sql, $user_id);
		}
		else
		{
			//  Only allow a user to assign roles, for which they are already memebers.
			$sql = "select *,
							(select id from roles_users where user_id= ? and role_id = roles.role_id) as hasrole
					from roles
					where role_id in (select role_id from roles_users where user_id = ?;";
			$data = $this->db->query($sql, $user_id, $auth_user_id);
		}

		return $data;
	}

	public function updateRoles($data)
	{
		$affectedRows = 0;
		// Clear the user's existing permissions
		$this->writeDB->where('user_id', $data['user_id'])->delete('roles_users');

		//  There are no roles to add, abort here.
		if (!isset($data['roles']))
		{
			return true;
		}

		// Insert the new permissions
		foreach ($data['roles'] as $role) {
			$row = ['user_id' => $data['user_id'],  'role_id' => $role];
			$this->writeDB->insert('roles_users', $row);
			$r= $this->writeDB->affected_rows();
			$affectedRows = $affectedRows + $this->writeDB->affected_rows();
		}

		return ($affectedRows == count($data['roles']));

		//TODO:  Add mechanism to force rebuild of affected user's session if they have one
	}

	/**
	 * @return mixed
	 * get roles
	 */
	public function getRoles()
	{
		return $this->db->where('deleted', false)->get('roles');
	}

	/**
	 * @param $user_id
	 * @return mixed
	 * get user's roles
	 */
	public function getUserRoles($user_id)
	{
		return $this->db->select('roles.*')->join('roles', 'roles.role_id = roles_users.role_id')->where('user_id', $user_id)->get('roles_users');
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
	 * @param $data
	 * @return array
	 * create new user and assign organization, offices and roles
	 */
	public function createUser($data)
	{
		$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
		$data['question1'] = $data['question2'] = '0';
		$data['question1_answer'] = $data['question2_answer'] = $data['password'];
		$user = $this->permittedFields($data, $this->accessibleFields, 'insert');
		$user['username'] = $user['first_name']." ".$user["last_name"];
		$user = $this->updateTimestamps($user, 'insert');
		if(!is_null($this->getUserFromEmail($data['email']))) {
			$response['success'] = false;
			$response['dbError'] = true;
			$response['message'] = "Email has already been taken.";
			return $response;
		}
		$this->writeDB->insert($this->_table, $user);
		$response = array();
		$response["success"] = $this->writeDB->affected_rows() === 1;
		if($response["success"]) {
			$user_id = $this->db->insert_id();
			$organization_user = ['user_id' => $user_id, 'organization_id' => $data["organization_id"]];
			$this->writeDB->insert("organizations_users", $organization_user);
			foreach ($data["offices"] as $office_id) {
				$office_user = ['user_id' => $user_id, 'office_id' => $office_id];
				$this->writeDB->insert("offices_users", $office_user);
			}
			foreach ($data["roles"] as $role_id) {
				$role_user = ['role_id' => $role_id, 'user_id' => $user_id];
				$this->writeDB->insert("roles_users", $role_user);
			}
			$response['user_id'] = $user_id;
		}
		return $response;
	}

	/**
	 * returns all the organizations users is associated with
	 *
	 * @param bool $showDeleted
	 *
	 * @param int $user_id
	 *
	 * @return CIRESULT
	 */
	public function getUserOrganizations($showDeleted = false, $user_id)
	{
		$this->db->group_start();
		$this->db->where('organizations.deleted', $showDeleted)->or_where('organizations.deleted', false);
		$this->db->group_end();

		return $this->db->select('organizations.organization_id, organizations.organization_name')
						->join('organizations_users', 'organizations_users.organization_id=organizations.organization_id')
						->where('organizations_users.user_id', $user_id)
						->get('organizations');
	}

	/**
	 * returns all the offices users has access
	 *
	 * @param bool $showDeleted
	 *
	 * @param int $user_id
	 *
	 * @param array $user_organizations
	 *
	 * @return CIRESULT
	 */
	public function getUserOffices($showDeleted = false, $user_id, $user_organizations)
	{
		$this->db->group_start();
		$this->db->where('offices.deleted', $showDeleted)->or_where('offices.deleted', false);
		$this->db->group_end();

		return $this->db->select('offices.office_id, offices.office_name, offices.office_color, offices.notify_email_address, offices.notify_new_data')
					    ->join('offices_users', 'offices_users.office_id=offices.office_id')
					    ->join('offices_organizations', 'offices_organizations.office_id=offices.office_id')
					    ->where_in('offices_organizations.organization_id', $user_organizations)
					    ->where('offices_users.user_id', $user_id)
					    ->get('offices');
	}
}

/* End of file Model_users.php */
