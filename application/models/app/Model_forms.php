<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Model_forms extends MY_Model
{

	protected $_table = null;

	protected $accessibleFields = ['form_id', 'user_id', 'form_data'];

	function getAllForms($visibility = true, $showDeleted = false)
	{
		$this->db->where('visibility', $visibility);
		$this->db->group_start();
		$this->db->where('deleted', $showDeleted)->or_where('deleted', false);
		$this->db->group_end();
		$this->db->order_by('display_order', 'ASC');
		return $this->db->get('forms');
	}

	function getForms($form_id)
	{
		$this->db->where('visibility', true);
		$this->db->group_start();
		$this->db->where('deleted', false)->or_where('deleted', false);
		$this->db->group_end();
		return $this->db->where('form_id', $form_id)->get('forms');
	}

	function insertFormData($data)
	{
		$data = $this->permittedFields($data, $this->accessibleFields);
		$data = $this->updateTimestamps($data, 'insert');
		$this->writeDB->insert('form_submissions', $data);
		return ($this->writeDB->affected_rows() == 1);
	}

	function getAllFormsData($form_id, $fields)
	{
		return $this->db->select($fields)
						->join('users u', 'u.user_id=fs.user_id')
						->where('fs.form_id', $form_id)
						->get('form_submissions fs');
	}

	function updateFormData($form_response_id, $data)
	{
		$data = $this->permittedFields($data, $this->accessibleFields, 'update');
		$data = $this->updateTimestamps($data, 'update');

		$this->writeDB->where('form_id', $form_id)
					  ->set($data)
					  ->update('form_submissions');

		if ($this->writeDB->affected_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteFormData($form_response_id)
	{
		$data = ['deleted' => true];
		$data = $this->updateTimestamps($data, 'delete');

		$this->writeDB->where('form_response_id', $form_response_id)
			->set($data)
			->update('form_submissions');

		if ($this->writeDB->affected_rows() >= 1) {
			return true;
		} else {
			return false;
		}
	}

	public function restoreFormData($form_response_id)
	{
		$data = ['deleted' => false, 'deleted_at' => null];
		$data = $this->updateTimestamps($data, 'delete');

		$this->writeDB->where('form_response_id', $form_response_id)
			->set($data)
			->update('form_submissions');

		if ($this->writeDB->affected_rows() >= 1) {
			return true;
		} else {
			return false;
		}
	}
}

/* End of file Model_forms.php */
