<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Model_roles extends MY_Model
{
	protected $_table = 'roles';

	protected $accessibleFields = ['role_name', 'description', 'super_admin', 'office_manager_can_assign', 'created_at'];

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * returns count of the roles
	 *
	 * @param bool $showDeleted
	 *
	 * @param str $keyword
	 *
	 * @return CIRESULT COUNT
	 */
	public function getRolesCount($showDeleted = false, $keyword)
	{
		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();

		$this->db->select($this->_table.'.role_id');

		if ($keyword)
		{
			$this->db->group_start();
			$this->db->like($this->_table.'.role_name', $keyword);
			$this->db->or_like($this->_table.'.description', $keyword);
			$this->db->group_end();
		}

		return $this->db->count_all_results($this->_table);
	}

	/**
	 * returns all users in associated roles
	 *
	 * @param bool $showDeleted
	 *
	 * @param int $start
	 *
	 * @param int $length
	 *
	 * @param str $order_by
	 *
	 * @param str $order
	 *
	 * @param str $keyword
     *
	 * @return CIRESULT
	 */
	public function getAllRoles($showDeleted = false, $start, $length, $order_by, $order, $keyword)
	{
		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();

		$this->db->select($this->_table.'.*');

		if ($keyword)
		{
			$this->db->group_start();
			$this->db->like($this->_table.'.role_name', $keyword);
			$this->db->or_like($this->_table.'.description', $keyword);
			$this->db->group_end();
		}

		if ($length > 0)
     		$this->db->limit($length, $start);

		if ($order_by)
	    	$this->db->order_by($order_by, $order);

		return $this->db->get($this->_table);
	}

	/**
	 * returns all roles in associated roles
	 *
	 * @param bool $showDeleted
	 *
	 * @param bool $role_id
	 *
	 * @return CIRESULT
	 */
	public function getRole($showDeleted = false, $role_id)
	{
		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();
		$this->db->select($this->_table.'.*');
		$this->db->where($this->_table.'.role_id', $role_id);
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
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();

		return $this->db->select($this->_table.'.role_id, '.$this->_table.'.role_name')
						->where('role_manager_can_assign', true)
						->get($this->_table);
	}

	/**
	 * Get Role from Name
	 *
	 * @param str $role_name
	 *
	 * @return CIRESULT
	 */
	public function getRoleFromName($role_name)
	{
		return $this->db->where('role_name', $role_name)->get($this->_table)->row();
	}

	/**
	 * Get all Permissions
	 *
	 * @param bool $showDeleted
	 *
	 * @return CIRESULT
	 */
	public function getAllPermissions($showDeleted = false)
	{
		$this->db->group_start();
		$this->db->where('permissions.deleted', $showDeleted)->or_where('permissions.deleted', false);
		$this->db->group_end();

		return $this->db->get('permissions');
	}

	/**
	 * Create new Role, assign Permissions and Users
	 *
	 * @param array $data
	 *
	 * @return array
	 */
	public function createRole($data)
	{
		$role								= $this->permittedFields($data, $this->accessibleFields, 'insert');
		$role 								= $this->updateTimestamps($role, 'insert');

		if(!is_null($this->getRoleFromName($data['role_name']))) {
			$response['success'] 			= false;
			$response['dbError'] 			= true;
			$response['message'] 			= "Role already exists.";
			return $response;
		}

		$flag								= $this->writeDB->trans_start();

		if ($flag) {
			$flag 							= $this->writeDB->insert($this->_table, $role);
			$response 						= array();
			$response["success"] 			= $this->writeDB->affected_rows() === 1;
		}

		if ($flag) {
			$role_id 						= $this->db->insert_id();
			$permissions_roles 				= array();

			foreach ($data['cbPermissions'] as $permission_id) {
				$permissions_roles[]		= array('permission_id' => $permission_id, 'role_id' => $role_id);
			}

			if (sizeof($permissions_roles)) {
				$flag						= $this->writeDB->insert_batch('permissions_roles', $permissions_roles);
			}
		}

		if ($flag) {
			$roles_users 					= array();
			foreach ($data['cbUsers'] as $user_id) {
				$roles_users[] 				= array('role_id' => $role_id, 'user_id' => $user_id);
			}

			if (sizeof($roles_users)) {
				$flag 						= $this->writeDB->insert_batch('roles_users', $roles_users);
			}

			$response['role_id'] 			= $role_id;
		}

		if ($flag) {
			$this->writeDB->trans_commit();
			return $response;
		} else {
			$this->writeDB->trans_rollback();
			return false;
		}
	}

	/**
	 * Update Role and assign Permissions and Users
	 *
	 * @param int $role_id
	 *
	 * @param array $data
	 *
	 * @return array
	 */
	public function updateRole($role_id, $data)
	{
		$role 								= $this->permittedFields($data, $this->accessibleFields, 'update');
		$role 								= $this->updateTimestamps($role, 'update');

		$flag								= $this->writeDB->trans_start();
		$this->writeDB->where('role_id', $role_id)
					  ->set($role)
					  ->update($this->_table);

		$flag								= $this->writeDB->affected_rows();

		if ($flag) {
			$permissions_roles 				= $permissions_users = array();

			foreach ($data['cbPermissions'] as $permission_id) {
				$permissions_roles[]		= array('role_id' => $role_id, 'permission_id' => $permission_id);
				foreach ($data['cbUsers'] as $user_id) {
					$permissions_users[] 	= array('permission_id' => $permission_id, 'user_id' => $user_id);
				}
			}

			$flag 							= $this->writeDB->where('role_id', $role_id)->delete('permissions_roles');
			if (sizeof($permissions_roles) && $flag) {
				$flag 						= $this->writeDB->insert_batch('permissions_roles', $permissions_roles);
			}
		}

		if ($flag) {
			$roles_users 					= array();
			foreach ($data['cbUsers'] as $user_id) {
				$roles_users[] 				= array('role_id' => $role_id, 'user_id' => $user_id);
			}

			$flag 							= $this->writeDB->where('role_id', $role_id)->delete('roles_users');
			if (sizeof($roles_users)){
				$flag 						= $this->writeDB->insert_batch('roles_users', $roles_users);
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
	 * Recover Role
	 *
	 * @param int $role_id
	 *
	 */
	public function recoverRole($role_id)
	{
		$data 		= ['deleted' => false, 'deleted_at' => null];
		$data 		= $this->updateTimestamps($data, 'update');
		$this->writeDB->where('role_id', $role_id)
					  ->set($data)
					  ->update($this->_table);

		if ($this->writeDB->affected_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Delete Role
	 *
	 * @param int $role_id
	 *
	 * @return bool
	 */
	public function deleteRole($role_id)
	{
		$data = ['deleted' => true];
		$data = $this->updateTimestamps($data, 'delete');
		$this->writeDB->where('role_id', $role_id)
					  ->set($data)
					  ->update($this->_table);

		if ($this->writeDB->affected_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Get Role Permissions
	 *
	 * @param int $role_id
	 *
	 * @return CIRESULT
	 */
	public function getRolesPermissions($role_id)
	{
		return $this->db->where('role_id', $role_id)->get('permissions_roles');
	}

	/**
	 * Get Role Users
	 *
	 * @param int $role_id
	 *
	 * @return CIRESULT
	 */
	public function getRolesUsers($role_id)
	{
		return $this->db->where('role_id', $role_id)->get('roles_users');
	}
}
