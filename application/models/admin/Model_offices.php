<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Model_offices extends MY_Model
{
	protected $_table = 'offices';

	protected $accessibleFields = ['office_name', 'office_color', 'notify_email_address', 'notify_new_data', 'address1', 'address2', 'city', 'state', 'zip', 'phone', 'app_url', 'taxrate', 'location_url', 'created_at'];

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * returns count of the offices
	 *
	 * @param bool $showDeleted
	 *
	 * @return CIRESULT COUNT
	 */
	public function getOfficesCount($showDeleted = false, $keyword)
	{
		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();

		$this->db->select($this->_table.'.user_id');

		if ($keyword)
		{
			$this->db->group_start();
			$this->db->like($this->_table.'.office_name', $keyword);
			$this->db->or_like($this->_table.'.address1', $keyword);
			$this->db->or_like($this->_table.'.address2', $keyword);
			$this->db->or_like($this->_table.'.city', $keyword);
			$this->db->or_like($this->_table.'.state', $keyword);
			$this->db->or_like($this->_table.'.zip', $keyword);
			$this->db->or_like($this->_table.'.phone', $keyword);
			$this->db->or_like($this->_table.'.app_url', $keyword);
			$this->db->or_like($this->_table.'.location_url', $keyword);
			$this->db->group_end();
		}

		return $this->db->count_all_results($this->_table);
	}

	/**
	 * returns all users in associated offices
	 *
	 * @param bool $showDeleted
     *
	 * @return CIRESULT
	 */
	public function getAllOffices($showDeleted = false, $start, $length, $order_by, $order, $keyword)
	{
		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();

		$this->db->select($this->_table.'.*');

		if ($keyword)
		{
			$this->db->group_start();
			$this->db->like($this->_table.'.office_name', $keyword);
			$this->db->or_like($this->_table.'.address1', $keyword);
			$this->db->or_like($this->_table.'.address2', $keyword);
			$this->db->or_like($this->_table.'.city', $keyword);
			$this->db->or_like($this->_table.'.state', $keyword);
			$this->db->or_like($this->_table.'.zip', $keyword);
			$this->db->or_like($this->_table.'.phone', $keyword);
			$this->db->or_like($this->_table.'.app_url', $keyword);
			$this->db->or_like($this->_table.'.location_url', $keyword);
			$this->db->group_end();
		}

		if ($length > 0)
     		$this->db->limit($length, $start);

		if ($order_by)
	    	$this->db->order_by($order_by, $order);

		return $this->db->get($this->_table);
	}

	/**
	 * returns all offices in associated offices
	 *
	 * @param bool $showDeleted
	 *
	 * @param bool $office_id
	 *
	 * @return CIRESULT
	 */
	public function getOffice($showDeleted = false, $office_id)
	{
		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();
		$this->db->select($this->_table.'.*');
		$this->db->where($this->_table.'.office_id', $office_id);
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
	 * @param $office_name
	 * @return mixed
	 * get office from name
	 */
	public function getOfficeFromName($office_name)
	{
		return $this->db->where('office_name', $office_name)->get($this->_table)->row();
	}

	/**
	 * @param $data
	 * @return array
	 * create new user and assign organizations, offices and roles
	 */
	public function createOffice($data)
	{
		$office									= $this->permittedFields($data, $this->accessibleFields, 'insert');
		$office 								= $this->updateTimestamps($office, 'insert');

		if(!is_null($this->getOfficeFromName($data['office_name']))) {
			$response['success'] 				= false;
			$response['dbError'] 				= true;
			$response['message'] 				= "Office already exists.";
			return $response;
		}

		$flag									= $this->writeDB->trans_start();

		if ($flag) {
			$flag 								= $this->writeDB->insert($this->_table, $office);
			$response 							= array();
			$response["success"] 				= $this->writeDB->affected_rows() === 1;
		}

		if ($flag) {
			$office_id 							= $this->db->insert_id();
			$offices_organizations 				= $organizations_users = array();

			foreach ($data['cbOrganizations'] as $organization_id) {
				$offices_organizations[]		= array('office_id' => $office_id, 'organization_id' => $organization_id);
				foreach ($data['cbUsers'] as $user_id) {
					$organizations_users[] 		= array('organization_id' => $organization_id, 'user_id' => $user_id);
				}
			}

			if (sizeof($offices_organizations) && $flag) {
				 $flag 							= $this->writeDB->insert_batch('offices_organizations', $offices_organizations);
			}
		}

		if ($flag) {
			$offices_users 						= array();
			foreach ($data['cbUsers'] as $user_id) {
				$offices_users[] 				= array('office_id' => $office_id, 'user_id' => $user_id);
			}

			if (sizeof($offices_users) && $flag) {
				$flag 							= $this->writeDB->insert_batch('offices_users', $offices_users);
			}
		}

		if ($flag) {
			if (sizeof($organizations_users) && $flag) {
				$flag 							= $this->writeDB->insert_batch('organizations_users', $organizations_users);
			}
		}

		if ($flag) {
			$this->writeDB->trans_commit();
			$response['office_id'] 				= $office_id;
			return $response;
		} else {
			$this->writeDB->trans_rollback();
			return false;
		}
	}

	/**
	 * @param $office_id
	 *
	 * @param $data
	 *
	 * @return array
	 *
	 * update office and assign organizations and users
	 */
	public function updateOffice($office_id, $data)
	{
		$office 							= $this->permittedFields($data, $this->accessibleFields, 'update');
		$office 							= $this->updateTimestamps($office, 'update');

		$flag								= $this->writeDB->trans_start();
		$office								= $this->updateTimestamps($office, 'update');

		if ($flag) {
			$flag 							= $this->writeDB->where('office_id', $office_id)
															->set($office)
															->update($this->_table);
			$flag							= $this->writeDB->affected_rows();
		}

		if ($flag) {
			$offices_organizations 			= $organizations_users = array();

			foreach ($data['cbOrganizations'] as $organization_id) {
				$offices_organizations[]	= array('office_id' => $office_id, 'organization_id' => $organization_id);
				foreach ($data['cbUsers'] as $user_id) {
					$organizations_users[] 	= array('organization_id' => $organization_id, 'user_id' => $user_id);
				}
			}

			$flag 							= $this->writeDB->where('office_id', $office_id)->delete('offices_organizations');
			if (sizeof($offices_organizations) && $flag){
				$flag 						= $this->writeDB->insert_batch('offices_organizations', $offices_organizations);
			}
		}

		if ($flag) {
			$offices_users 					= array();
			foreach ($data['cbUsers'] as $user_id) {
				$offices_users[] 			= array('office_id' => $office_id, 'user_id' => $user_id);
			}

			$flag 							= $this->writeDB->where('office_id', $office_id)->delete('offices_users');
			if (sizeof($offices_users)){
				$flag 						= $this->writeDB->insert_batch('offices_users', $offices_users);
			}
		}

		if ($flag) {
			if (sizeof($organizations_users)){
				$this->writeDB->insert_batch('organizations_users', $organizations_users);
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
	 * Recover Office
	 *
	 * @param int $office_id
	 *
	 */
	public function recoverOffice($office_id)
	{
		$data 		= ['deleted' => false, 'deleted_at' => null];
		$data 		= $this->updateTimestamps($data, 'update');
		$this->writeDB->where('office_id', $office_id)
					  ->set($data)
					  ->update($this->_table);

		if ($this->writeDB->affected_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Delete Office
	 *
	 * @param int $role_id
	 *
	 * @return bool
	 */
	public function deleteOffice($office_id)
	{
		$data = ['deleted' => true];
		$data = $this->updateTimestamps($data, 'delete');
		$this->writeDB->where('office_id', $office_id)
					  ->set($data)
					  ->update($this->_table);

		if ($this->writeDB->affected_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @param $office_id
	 * @return mixed
	 * get office organizations
	 */
	public function getOfficesOrganizations($office_id)
	{
		return $this->db->where('office_id', $office_id)->get('offices_organizations');
	}

	/**
	 * @param $office_id
	 * @return mixed
	 * get office users
	 */
	public function getOfficesUsers($office_id)
	{
		return $this->db->where('office_id', $office_id)->get('offices_users');
	}

	public function getAllOrganizations($showDeleted = false)
	{
		$r = $this->db->select('*')
					->select('(select count(user_id) from organizations_users where organization_id = organizations.organization_id) as org_users')
					->select('(select count(office_id) from offices_organizations where organization_id = organizations.organization_id) as org_offices')
					->where('deleted', $showDeleted)
					->or_where('deleted', false)
					->get('organizations');
		return $r ;
	}
}
