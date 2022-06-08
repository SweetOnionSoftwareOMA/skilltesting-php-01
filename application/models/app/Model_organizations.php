<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Model_organizations extends MY_Model
{

	protected $_table = 'organizations';
	protected $accessibleFields = ['organization_name', ];

	public function __construct()
	{
		parent::__construct();
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

	public function getOrganization($org_id)
	{
		$sql = "
				select *,
						(select count(user_id) from organizations_users where organization_id = org.organization_id) as org_users,
						(select count(office_id) from offices_organizations where organization_id = org.organization_id) as org_offices
				from
					organizations as org
				where
					organization_id = ?;
			";
		return $this->db->query($sql, $org_id)->row();
	}

	public function getOrganizationOffices($org_id)
	{
		return $this->db->where('office_id IN (select office_id from offices_organizations where organization_id IN (' . $org_id . '))')->get('offices');

	}

	public function getOrganizationUsers($org_id)
	{
		return $this->db->where('user_id IN (select user_id from organizations_users where organization_id = ' .$org_id .')')->get('users');
	}


	public function getAllOffices()
	{
		return $this->db->where('deleted', false)->get('v_offices_organizations');
	}

	public function getAllUsers()
	{
		return $this->db->where('deleted', false)->get('v_users_organizations');
	}

	public function updateOrganization($org_id, $data)
	{
		$data = $this->permittedFields($data, $this->accessibleFields, 'update');
		$data = $this->updateTimestamps($data, 'update');
		$this->writeDB->where('organization_id', $org_id)
			->set($data)
			->update('organizations');

		if ($this->writeDB->affected_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}
	public function insertOrganization($data)
	{
		$data = $this->permittedFields($data, $this->accessibleFields, 'insert');
		$data = $this->updateTimestamps($data, 'insert');
		$this->writeDB->insert('organizations', $data);

		if ($this->writeDB->affected_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	public function restoreOrganization($org_id)
	{

		$data = ['deleted' => false, 'deleted_at' => null];
		$data = $this->updateTimestamps($data, 'update');


		$this->writeDB->where('organization_id', $org_id)
			->set($data)
			->update('organizations');

		if ($this->writeDB->affected_rows() >= 1) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteOrganization($org_id)
	{
		//TODO: What to do with associated offices when deleted

		$data = ['deleted' => true];
		$data = $this->updateTimestamps($data, 'delete');


		$this->writeDB->where('organization_id', $org_id)
			->set($data)
			->update('organizations');

		if ($this->writeDB->affected_rows() >= 1) {
			return true;
		} else {
			return false;
		}
	}

	public function saveOfficeAssociations($org_id, $offices)
	{
		// Always clear associations, than rebuild if they exist
		$this->writeDB->where('organization_id', $org_id)->delete('offices_organizations');

		if (isset($offices) && count($offices) > 0)
		{
			foreach ($offices as $office_id) {
				$data[] = ['office_id' => $office_id, 'organization_id' => $org_id];
			}

			$this->writeDB->insert_batch('offices_organizations', $data);

			if ($this->writeDB->affected_rows() >= 1) {
				return true;
			} else {
				return false;
			}

		}
		return true;
	}

	public function saveUserAssociations($org_id, $users)
	{
		// Always clear associations, than rebuild if they exist
		$this->writeDB->where('organization_id', $org_id)->delete('organizations_users');

		if (isset($users) && count($users) > 0) {
			foreach ($users as $user_id) {
				$data[] = ['user_id' => $user_id, 'organization_id' => $org_id];
			}

			$this->writeDB->insert_batch('organizations_users', $data);

			if ($this->writeDB->affected_rows() >= 1) {
				return true;
			} else {
				return false;
			}
		}
		return true;
	}
}

/* End of file Model_organizations.php */
