<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Model_offices extends MY_Model
{

	protected $_table = 'offices';

	protected $accessibleFields = [
		'office_name', 'address1', 'address2', 'city', 'taxrate',
		'state', 'zip', 'phone', 'app_url', 'location_url'
	];

	public function __construct()
	{
		parent::__construct();
	}
	public function getAllOffices($showDeleted = false)
	{
		return $this->db->where('deleted', $showDeleted)
						->or_where('deleted', false)
						->get('v_offices_organizations');
	}

	public function getOffice($office_id)
	{
		return $this->db->where('office_id', $office_id)->get('v_offices_organizations')->row();
	}

	/**
	 * @param bool $asSelect Set to True if you need K=>V array
	 */
	public function getOrganizationChoices($asSelect = false)
	{
		$q = $this->db->where('deleted', false)->order_by('organization_name', 'ASC')->get('organizations');
		return ($asSelect) ? $this->toSelect('organization_id', 'organization_name', $q) : $q;
	}

	public function getOfficeUsers($office_id)
	{
		return $this->db->where( 'user_id IN (select user_id from offices_users where office_id = ' .$office_id .')' )->get('users');
	}

	public function getOrganizationUsers($office_id)
	{
		$where = "organization_id = (select organization_id from offices_organizations where office_id = $office_id)";
		return $this->db->where($where)->get('v_users_organizations');
	}

	public function getAllUsers()
	{
		return $this->db->where('deleted', false)->get('users');
	}

	public function updateOffice($office_id, $data)
	{
		$data = $this->permittedFields($data, $this->accessibleFields, 'update');
		$data = $this->updateTimestamps($data, 'update');
		$this->writeDB->where('office_id', $office_id)
			->set($data)
			->update($this->_table);

		if ($this->writeDB->affected_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	public function associateToOrganization($office_id, $org_id, $action)
	{
		if ($action == 'insert') {
			$data = ['organization_id' => $org_id, 'office_id' => $office_id];
			$this->writeDB->insert('offices_organizations', $data);
		}

		if ($action == 'update'){
			$data = ['organization_id' => $org_id];
			$this->writeDB->where('office_id', $office_id)
				->set($data)
				->update('offices_organizations');
		}

		if ($this->writeDB->affected_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	public function insertOffice($data)
	{
		// set before we remove permitted fields
		$org_id = $data['organization_id'];

		$data = $this->permittedFields($data, $this->accessibleFields, 'insert');
		$data = $this->updateTimestamps($data, 'insert');
		$this->writeDB->insert($this->_table, $data);

		if ($this->writeDB->affected_rows() == 1) {
			// If saved, update reference
			return $this->associateToOrganization($this->writeDB->insert_id(), $org_id, 'insert');
		} else {
			return false;
		}
	}

	public function deleteOffice($office_id)
	{
		//TODO: Should we disassociate from Organization if deleted?

		$data = ['deleted' => true];
		$data = $this->updateTimestamps($data, 'delete');

		$this->writeDB->where('office_id', $office_id)
			->set($data)
			->update($this->_table);

		if ($this->writeDB->affected_rows() >= 1) {
			return true;
		} else {
			return false;
		}
	}

	public function restoreOffice($office_id)
	{
		$data = ['deleted' => false, 'deleted_at' => null];
		$data = $this->updateTimestamps($data, 'delete');

		$this->writeDB->where('office_id', $office_id)
			->set($data)
			->update($this->_table);

		if ($this->writeDB->affected_rows() >= 1) {
			return true;
		} else {
			return false;
		}
	}

	public function saveUserAssociations($office_id, $users)
	{
		// Always clear associations, than rebuild if they exist
		$this->writeDB->where('office_id', $office_id)->delete('offices_users');

		if (isset($users) && count($users) > 0) {
			foreach ($users as $user_id) {
				$data[] = ['user_id' => $user_id, 'office_id' => $office_id];
			}

			$this->writeDB->insert_batch('offices_users', $data);

			if ($this->writeDB->affected_rows() >= 1) {
				return true;
			} else {
				return false;
			}
		}
		return true;
	}

	public function getPlans()
	{
		return $this->db->where('deleted', false)->get('v_inscompanies_plans');
	}

	public function getOfficePlans($office_id)
	{
		return $this->db->where('office_id', $office_id)->get('offices_plans');
	}

	public function savePlanAssociations($office_id, $plans)
	{
		// Always clear associations, than rebuild if they exist
		$this->writeDB->where('office_id', $office_id)->delete('offices_plans');

		if (isset($plans) && count($plans) > 0) {
			foreach ($plans as $plan_id) {
				$data[] = ['plan_id' => $plan_id, 'office_id' => $office_id];
			}

			$this->writeDB->insert_batch('offices_plans', $data);

			if ($this->writeDB->affected_rows() >= 1) {
				return true;
			} else {
				return false;
			}
		}
		return true;
	}

	public function getServices()
	{
		return $this->db->where('deleted', false)->get('services');
	}

	public function getOfficeServices($office_id)
	{
		return $this->db->join('services', 'services.service_id = offices_services.service_id')
						->where('office_id', $office_id)
						->get('offices_services');
	}

	public function saveServiceAssociations($data)
	{
		// update current office
		$all_services = explode(',', $data['all_services']);
		$previous_services = explode(',', $data['previous_services']);
		foreach ($all_services as $service_id) {

			if (isset($data['service_ids'][$service_id]) && in_array($service_id, $previous_services)) {
				// The user has updated this service, update accordingly.
				$display_as = is_blank($data['display_as'][$service_id]) ? null : $data['display_as'][$service_id];
				$row = [
					'service_id' 	=> $data['service_ids'][$service_id],
					'display_as' 	=> $display_as,
					'sort_order'	=> (int) $data['sort_order'][$service_id],
					'msrp'			=> $data['msrp'][$service_id],
				];
				$row = $this->updateTimestamps($row, 'update');

				$this->writeDB->where('office_service_id', $data['office_service_id'][$service_id])
							->update('offices_services', $row);

			} elseif (in_array($service_id, $previous_services)) {  // Previously existed, but no longer exists

					$this->writeDB->where('office_service_id', $data['office_service_id'][$service_id])->delete('offices_services');

			} elseif (isset($data['service_ids'][$service_id])  && !in_array($service_id, $previous_services)) { // Creating office service as it was newly added or first time office creation

				$row = [
					'office_id'		=> $data['office_id'],
					'service_id' 	=> $data['service_ids'][$service_id],
					'display_as' 	=> $data['display_as'][$service_id],
					'sort_order'	=> (int) $data['sort_order'][$service_id],
					'msrp'			=> $data['msrp'][$service_id],
				];
				$row = $this->updateTimestamps($row, 'insert');
					$this->writeDB->insert('offices_services', $row);

			}
		} // Looping service Types

		return ($this->writeDB->affected_rows() >= 1);
	}

	public function getGlasses()
	{
		return $this->db->select('glasses.*, lens_styles.glasses_style, lens_styles.lensstyle_name')
						->join('lens_styles', 'lens_styles.lensstyle_id = glasses.lensstyle_id')
						->where('glasses.deleted', false)->get('glasses');
	}

	public function getOfficeGlasses($office_id)
	{
		return $this->db->select('glasses.*')
						->select('lens_styles.glasses_style, lens_styles.lensstyle_name')
						->select(
								'offices_glasses.office_glasses_id, offices_glasses.deleted as office_deleted,
								offices_glasses.design_msrp, offices_glasses.material_msrp, offices_glasses.type_msrp'
								)
						->join('glasses', 'glasses.glasses_id = offices_glasses.glasses_id')
						->join('lens_styles', 'lens_styles.lensstyle_id = glasses.lensstyle_id')
						->where('office_id', $office_id)
						->get('offices_glasses');
	}

	public function saveGlassesAssociations($data)
	{
		// update current office
		$all_glasses = explode(',', $data['all_glasses']);
		$previous_glasses = explode(',', $data['previous_glasses']);
		foreach ($all_glasses as $glasses_id) {

			if (isset($data['glasses_ids'][$glasses_id]) && in_array($glasses_id, $previous_glasses))
            {
				// The user has updated this Lens, update accordingly.
				$row = [
					'glasses_id' 	=> $data['glasses_ids'][$glasses_id],
					'design_msrp'	=> (is_blank($data['design_msrp'][$glasses_id])) ? null : $data['design_msrp'][$glasses_id] ,
					'material_msrp'	=> (is_blank($data['material_msrp'][$glasses_id])) ? null : $data['material_msrp'][$glasses_id] ,
					'type_msrp'		=> (is_blank($data['type_msrp'][$glasses_id])) ? null : $data['type_msrp'][$glasses_id] ,
				];
				$row = $this->updateTimestamps($row, 'update');

				$this->writeDB->where('office_glasses_id', $data['office_glasses_id'][$glasses_id])
							->update('offices_glasses', $row);

			}
            elseif (in_array($glasses_id, $previous_glasses))
            {  // Previously existed, but no longer exists

					$this->writeDB->where('office_glasses_id', $data['office_glasses_id'][$glasses_id])->delete('offices_glasses');

			}
            elseif (isset($data['glasses_ids'][$glasses_id])  && !in_array($glasses_id, $previous_glasses))
            { // Creating office Lens as it was newly added or first time office creation

				$row = [
					'office_id'		=> $data['office_id'],
					'glasses_id' 	=> $data['glasses_ids'][$glasses_id],
					'design_msrp'	=> (is_blank($data['design_msrp'][$glasses_id])) ? null : $data['design_msrp'][$glasses_id] ,
					'material_msrp'	=> (is_blank($data['material_msrp'][$glasses_id])) ? null : $data['material_msrp'][$glasses_id] ,
					'type_msrp'		=> (is_blank($data['type_msrp'][$glasses_id])) ? null : $data['type_msrp'][$glasses_id] ,
				];
				$row = $this->updateTimestamps($row, 'insert');
					$this->writeDB->insert('offices_glasses', $row);

			}
		} // Looping Lens Types

		return ($this->writeDB->affected_rows() >= 1);
	}

	public function getLenscoatings()
	{
		return $this->db->where('lens_coatings.deleted', false)
                        ->get('lens_coatings');
	}

	public function getOfficeLenscoatings($office_id)
	{
		return $this->db->select('lens_coatings.*')
						->select(
								'offices_lenscoatings.office_lenscoatings_id, offices_lenscoatings.deleted as office_deleted,
								offices_lenscoatings.msrp_uv, offices_lenscoatings.msrp_ar'
								)
						->join('lens_coatings', 'lens_coatings.lenscoating_id = offices_lenscoatings.lenscoating_id')
						->where('office_id', $office_id)
						->get('offices_lenscoatings');
	}

	public function saveLenscoatingsAssociations($data)
	{
		// update current office
		$all_lenscoatings = explode(',', $data['all_lenscoatings']);
		$previous_lenscoatings = explode(',', $data['previous_lenscoatings']);
		foreach ($all_lenscoatings as $lenscoating_id) {

			if (isset($data['lenscoating_ids'][$lenscoating_id]) && in_array($lenscoating_id, $previous_lenscoatings))
            {
				// The user has updated this Lens, update accordingly.
				$row = [
					'lenscoating_id' 	=> $data['lenscoating_ids'][$lenscoating_id],
					'msrp_ar'	=> (is_blank($data['msrp_ar'][$lenscoating_id])) ? null : $data['msrp_ar'][$lenscoating_id] ,
					'msrp_uv'	=> (is_blank($data['msrp_uv'][$lenscoating_id])) ? null : $data['msrp_uv'][$lenscoating_id] ,
				];
				$row = $this->updateTimestamps($row, 'update');

				$this->writeDB->where('office_lenscoatings_id', $data['office_lenscoatings_id'][$lenscoating_id])
							->update('offices_lenscoatings', $row);

			}
            elseif (in_array($lenscoating_id, $previous_lenscoatings))
            {  // Previously existed, but no longer exists

					$this->writeDB->where('office_lenscoatings_id', $data['office_lenscoatings_id'][$lenscoating_id])->delete('offices_lenscoatings');

			}
            elseif (isset($data['lenscoating_ids'][$lenscoating_id])  && !in_array($lenscoating_id, $previous_lenscoatings))
            { // Creating office Lens as it was newly added or first time office creation

				$row = [
					'office_id'		=> $data['office_id'],
					'lenscoating_id' 	=> $data['lenscoating_ids'][$lenscoating_id],
					'msrp_ar'	=> (is_blank($data['msrp_ar'][$lenscoating_id])) ? null : $data['msrp_ar'][$lenscoating_id] ,
					'msrp_uv'	=> (is_blank($data['msrp_uv'][$lenscoating_id])) ? null : $data['msrp_uv'][$lenscoating_id] ,
				];
				$row = $this->updateTimestamps($row, 'insert');
					$this->writeDB->insert('offices_lenscoatings', $row);

			}
		} // Looping Lens Types

		return ($this->writeDB->affected_rows() >= 1);
	}

	public function getLensfinishes()
	{
		return $this->db->where('lens_finishes.deleted', false)
                        ->get('lens_finishes');
	}

	public function getOfficeLensfinishes($office_id)
	{
		return $this->db->select('lens_finishes.*')
						->select(
								'offices_lensfinishes.office_lensfinish_id, offices_lensfinishes.deleted as office_deleted,
								offices_lensfinishes.msrp'
								)
						->join('lens_finishes', 'lens_finishes.lensfinish_id = offices_lensfinishes.lensfinish_id')
						->where('office_id', $office_id)
						->get('offices_lensfinishes');
	}

	public function saveLensfinishAssociations($data)
	{
		// update current office
		$all_lensfinishes = explode(',', $data['all_lensfinishes']);
		$previous_lensfinishes = explode(',', $data['previous_lensfinishes']);
		foreach ($all_lensfinishes as $lensfinish_id) {

			if (isset($data['lensfinish_ids'][$lensfinish_id]) && in_array($lensfinish_id, $previous_lensfinishes))
            {
				// The user has updated this Lens, update accordingly.
				$row = [
					'lensfinish_id' 	=> $data['lensfinish_ids'][$lensfinish_id],
					'msrp'	=> (is_blank($data['msrp'][$lensfinish_id])) ? null : $data['msrp'][$lensfinish_id] ,
				];
				$row = $this->updateTimestamps($row, 'update');

				$this->writeDB->where('office_lensfinish_id', $data['office_lensfinish_id'][$lensfinish_id])
							->update('offices_lensfinishes', $row);

			}
            elseif (in_array($lensfinish_id, $previous_lensfinishes))
            {  // Previously existed, but no longer exists

					$this->writeDB->where('office_lensfinish_id', $data['office_lensfinish_id'][$lensfinish_id])->delete('offices_lensfinishes');

			}
            elseif (isset($data['lensfinish_ids'][$lensfinish_id])  && !in_array($lensfinish_id, $previous_lensfinishes))
            { // Creating office Lens as it was newly added or first time office creation

				$row = [
					'office_id'		=> $data['office_id'],
					'lensfinish_id' 	=> $data['lensfinish_ids'][$lensfinish_id],
					'msrp'	=> (is_blank($data['msrp'][$lensfinish_id])) ? null : $data['msrp'][$lensfinish_id] ,
				];
				$row = $this->updateTimestamps($row, 'insert');
					$this->writeDB->insert('offices_lensfinishes', $row);

			}
		} // Looping Lens Types

		return ($this->writeDB->affected_rows() >= 1);
	}

	public function getContacts()
	{
		return $this->db->where('contacts.deleted', false)
                        ->get('contacts');
	}

	public function getOfficeContacts($office_id)
	{
		return $this->db->select('contacts.*')
						->select(
								'offices_contacts.office_contact_id, offices_contacts.deleted as office_deleted,
								offices_contacts.year_supply_discount'
								)
						->join('contacts', 'contacts.contact_id = offices_contacts.contact_id')
						->where('office_id', $office_id)
						->get('offices_contacts');
	}

	public function saveContactsAssociations($data)
	{
		// update current office
		$all_contacts = explode(',', $data['all_contacts']);
		$previous_contacts = explode(',', $data['previous_contacts']);
		foreach ($all_contacts as $contact_id) {

			if (isset($data['contact_ids'][$contact_id]) && in_array($contact_id, $previous_contacts))
            {
				$discount = (is_blank($data['year_supply_discount'][$contact_id])) ? null : $data['year_supply_discount'][$contact_id] ;
				$row = [
					'contact_id' 	=> $data['contact_ids'][$contact_id],
					'year_supply_discount' => $discount,

				];
				$row = $this->updateTimestamps($row, 'update');

				$this->writeDB->where('office_contact_id', $data['office_contact_id'][$contact_id])->update('offices_contacts', $row);

			}
            elseif (in_array($contact_id, $previous_contacts))
            {

					$this->writeDB->where('office_contact_id', $data['office_contact_id'][$contact_id])->delete('offices_contacts');

			}
            elseif (isset($data['contact_ids'][$contact_id])  && !in_array($contact_id, $previous_contacts))
            {
				$discount = (is_blank($data['year_supply_discount'][$contact_id])) ? null : $data['year_supply_discount'][$contact_id] ;
				$row = [
					'office_id'		=> $data['office_id'],
					'contact_id' 	=> $data['contact_ids'][$contact_id],
					'year_supply_discount' => $discount,
				];
				$row = $this->updateTimestamps($row, 'insert');
				$this->writeDB->insert('offices_contacts', $row);

			}
		} // Looping Contact Lens

		return ($this->writeDB->affected_rows() >= 1);
	}

	public function getRebates()
	{
		return $this->db->where('rebates.deleted', false)
                        ->get('rebates');
	}

	public function getOfficeRebates($office_id)
	{
		return $this->db->select('rebates.*')
						->select('offices_rebates.office_rebate_id, offices_rebates.deleted as office_deleted')
						->join('rebates', 'rebates.rebate_id = offices_rebates.rebate_id')
						->where('office_id', $office_id)
						->get('offices_rebates');
	}

	public function saveRebatesAssociations($data)
	{
		// update current office
		$all_rebates = explode(',', $data['all_rebates']);
		$previous_rebates = explode(',', $data['previous_rebates']);
		foreach ($all_rebates as $rebate_id) {

			if (isset($data['rebate_ids'][$rebate_id]) && in_array($rebate_id, $previous_rebates))
            {
				$row = [
					'rebate_id' 	=> $data['rebate_ids'][$rebate_id],
					'manufacturer_name'	=> $data['manufacturer_name'][$rebate_id],
				];
				$row = $this->updateTimestamps($row, 'update');

				$this->writeDB->where('office_rebate_id', $data['office_rebate_id'][$rebate_id])->update('offices_rebates', $row);
			}
            elseif (in_array($rebate_id, $previous_rebates))
            {
				$this->writeDB->where('office_rebate_id', $data['office_rebate_id'][$rebate_id])->delete('offices_rebates');
			}
            elseif (isset($data['rebate_ids'][$rebate_id])  && !in_array($rebate_id, $previous_rebates))
            {
				$row = [
					'office_id'		=> $data['office_id'],
					'rebate_id' 	=> $data['rebate_ids'][$rebate_id],
					'manufacturer_name'	=> $data['manufacturer_name'][$rebate_id],
				];
				$row = $this->updateTimestamps($row, 'insert');
				$this->writeDB->insert('offices_rebates', $row);

			}
		} // Looping Contact Lens Rebates
		return ($this->writeDB->affected_rows() >= 1);
	}
}

/* End of file Offices.php */
