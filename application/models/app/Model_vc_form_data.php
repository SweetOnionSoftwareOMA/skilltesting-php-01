<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_vc_form_data extends MY_Model
{
	protected $_table = 'vc_form_data';

	protected $accessibleFields = ['user_id', 'office_id', 'reporting_week', 'location_gross_sales', 'secondpair_eligible', 'secondpair_accepted', 'created_at'];

	function getAllFormData($showDeleted = false)
	{
		$this->db->group_start();
		$this->db->where('deleted', $showDeleted)->or_where('deleted', false);
		$this->db->group_end();
		$this->db->order_by('created_at', 'DESC');
		return $this->db->get($this->_table);
	}

	function getFormDataCount($showDeleted, $keyword)
	{
		$this->db->join('users u', 'u.user_id = '.$this->_table.'.user_id');
		$this->db->join('offices o', 'o.office_id = '.$this->_table.'.office_id');

		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();

		if ($keyword)
		{
			$this->db->group_start();
			$this->db->like('u.title', $keyword);
			$this->db->or_like('u.first_name', $keyword);
			$this->db->or_like('u.last_name', $keyword);
			$this->db->or_like('o.office_name', $keyword);
			$this->db->or_like($this->_table.'.reporting_week::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.location_gross_sales::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.secondpair_eligible::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.secondpair_accepted::text', $keyword, 'both', false);
			// $this->db->or_like('secondpair_conversion_rate', $keyword);
			$this->db->or_like($this->_table.'.created_at::text', $keyword, 'both', false);
			$this->db->group_end();
		}

		return $this->db->count_all_results($this->_table);
	}

	function getFormData($showDeleted = false, $start, $length, $order_by, $order, $keyword)
	{
		$this->db->select($this->_table.'.vc_form_data_id,
						  CONCAT_WS(\' \', u.title, u.first_name, u.last_name) AS submitted_by,
						  o.office_name AS location,
						  '.$this->_table.'.reporting_week,
						  '.$this->_table.'.location_gross_sales,
						  '.$this->_table.'.secondpair_eligible,
						  '.$this->_table.'.secondpair_accepted,

CASE
	WHEN '.$this->_table.'.secondpair_eligible=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.secondpair_accepted=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.secondpair_accepted/'.$this->_table.'.secondpair_eligible)*100)
END
						    AS secondpair_conversion_rate,

						   '.$this->_table.'.created_at');
		$this->db->join('users u', 'u.user_id = '.$this->_table.'.user_id');
		$this->db->join('offices o', 'o.office_id = '.$this->_table.'.office_id');

		if ($keyword)
		{
			$this->db->group_start();
			$this->db->like('u.title', $keyword);
			$this->db->or_like('u.first_name', $keyword);
			$this->db->or_like('u.last_name', $keyword);
			$this->db->or_like('o.office_name', $keyword);
			$this->db->or_like($this->_table.'.reporting_week::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.location_gross_sales::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.secondpair_eligible::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.secondpair_accepted::text', $keyword, 'both', false);
			// $this->db->or_like('secondpair_conversion_rate', $keyword);
			$this->db->or_like($this->_table.'.created_at::text', $keyword, 'both', false);
			$this->db->group_end();
		}

		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();

		if ($this->input->post('start_date'))
			$this->db->where($this->_table.'.reporting_week>=', $this->input->post('start_date'));

		if ($this->input->post('end_date'))
			$this->db->where($this->_table.'.reporting_week<=', $this->input->post('end_date'));

		if ($length > 0)
     		$this->db->limit($length, $start);

	    $this->db->order_by($order_by, $order);

		return $this->db->get($this->_table);
	}

	function getFormDataById($showDeleted = false, $vc_form_data_id)
	{
		$this->db->select($this->_table.'.vc_form_data_id,
						'.$this->_table.'.user_id,
						'.$this->_table.'.office_id,
						o.office_name,
					    '.$this->_table.'.reporting_week,
					    '.$this->_table.'.location_gross_sales,
					    '.$this->_table.'.secondpair_eligible,
					    '.$this->_table.'.secondpair_accepted,

CASE
	WHEN '.$this->_table.'.secondpair_eligible=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.secondpair_accepted=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.secondpair_accepted/'.$this->_table.'.secondpair_eligible)*100)
END
						    AS secondpair_conversion_rate,

						   '.$this->_table.'.created_at');
		$this->db->join('users u', 'u.user_id = '.$this->_table.'.user_id');
		$this->db->join('offices o', 'o.office_id = '.$this->_table.'.office_id');

		$this->db->where($this->_table.'.vc_form_data_id', $vc_form_data_id);

		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();

		return $this->db->get($this->_table);
	}

	function insertFormData($data)
	{
		$data = $this->permittedFields($data, $this->accessibleFields);
		$data = $this->updateTimestamps($data, 'insert');
		$this->writeDB->insert($this->_table, $data);
		return (($this->writeDB->affected_rows() == 1) ? $this->writeDB->insert_id() : false );
	}

	function getAllFormsData($fields, $where)
	{
		return $this->db->select($fields)
						->join('users u', 'u.user_id=vc.user_id')
						->where($where)
						->get($this->_table.' vc');
	}

	function updateFormData($vc_form_data_id, $data)
	{
		$data = $this->permittedFields($data, $this->accessibleFields, 'update');
		$data = $this->updateTimestamps($data, 'update');

		$this->writeDB->where('vc_form_data_id', $vc_form_data_id)
					  ->set($data)
					  ->update($this->_table);

		if ($this->writeDB->affected_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteFormData($vc_form_data_id)
	{
		$data = ['deleted' => true];
		$data = $this->updateTimestamps($data, 'delete');

		$this->writeDB->where('vc_form_data_id', $vc_form_data_id)
			->set($data)
			->update($this->_table);

		if ($this->writeDB->affected_rows() >= 1) {
			return true;
		} else {
			return false;
		}
	}

	public function restoreFormData($vc_form_data_id)
	{
		$data = ['deleted' => false, 'deleted_at' => null];
		$data = $this->updateTimestamps($data, 'delete');

		$this->writeDB->where('vc_form_data_id', $vc_form_data_id)
					  ->set($data)
					  ->update($this->_table);

		if ($this->writeDB->affected_rows() >= 1) {
			return true;
		} else {
			return false;
		}
	}
}

/* End of file Model_vc_form_data.php */
