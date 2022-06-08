<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_od_form_data extends MY_Model
{
	protected $_table = 'od_form_data';

	protected $accessibleFields = ['user_id', 'office_id', 'reporting_week', 'routine_encounters', 'followup_encounters', 'neurolens_eligble_patients', 'neurolens_accepted', 'has_ose_data', 'occular_surface_scheduled', 'occular_surface_performed', 'lipiflow_treatments_performed', 'myopia_eligble_patients', 'myopia_accepted'];

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
			$this->db->or_like($this->_table.'.routine_encounters::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.followup_encounters::text', $keyword, 'both', false);
			// $this->db->or_like('followup_routing_rate', $keyword);
			$this->db->or_like($this->_table.'.neurolens_eligble_patients::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.neurolens_accepted::text', $keyword, 'both', false);
			// $this->db->or_like('neurolens_conversion_rate', $keyword);
			$this->db->or_like($this->_table.'.occular_surface_scheduled::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.occular_surface_performed::text', $keyword, 'both', false);
			// $this->db->or_like('occular_surface_exam_rate', $keyword);
			$this->db->or_like($this->_table.'.lipiflow_treatments_performed::text', $keyword, 'both', false);
			// $this->db->or_like('lipiflow_conversion_rate', $keyword);
			$this->db->or_like($this->_table.'.myopia_eligble_patients::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.myopia_accepted::text', $keyword, 'both', false);
			// $this->db->or_like('myopia_conversion_rate', $keyword);
			$this->db->or_like($this->_table.'.created_at::text', $keyword, 'both', false);
			$this->db->group_end();
		}

		return $this->db->count_all_results($this->_table);
	}

	function getFormData($showDeleted = false, $start, $length, $order_by, $order, $keyword)
	{
		$this->db->select($this->_table.'.od_form_data_id,
						   CONCAT_WS(\' \', u.title, u.first_name, u.last_name) AS submitted_by,
						   o.office_name AS location,
						   '.$this->_table.'.reporting_week,
						   '.$this->_table.'.routine_encounters,
						   '.$this->_table.'.followup_encounters,

CASE
	WHEN '.$this->_table.'.followup_encounters=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.routine_encounters=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.followup_encounters/'.$this->_table.'.routine_encounters)*100)
END

						    AS followup_routing_rate,


						   '.$this->_table.'.neurolens_eligble_patients,
						   '.$this->_table.'.neurolens_accepted,

CASE
	WHEN '.$this->_table.'.neurolens_accepted=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.neurolens_eligble_patients=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.neurolens_accepted/'.$this->_table.'.neurolens_eligble_patients)*100)
END
 							AS neurolens_conversion_rate,
						   '.$this->_table.'.has_ose_data,
						   '.$this->_table.'.occular_surface_scheduled,
						   '.$this->_table.'.occular_surface_performed,

CASE
	WHEN '.$this->_table.'.occular_surface_performed=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.occular_surface_scheduled=\'0\'
		THEN \'0\'
	ELSE
		((('.$this->_table.'.occular_surface_scheduled-'.$this->_table.'.occular_surface_performed)/'.$this->_table.'.occular_surface_scheduled)*100)
END

						    AS occular_surface_exam_rate,

						   '.$this->_table.'.lipiflow_treatments_performed,

CASE
	WHEN '.$this->_table.'.lipiflow_treatments_performed=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.occular_surface_performed=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.lipiflow_treatments_performed/'.$this->_table.'.occular_surface_performed)*100)
END

						   AS lipiflow_conversion_rate,

						   '.$this->_table.'.myopia_eligble_patients,
						   '.$this->_table.'.myopia_accepted,

CASE
	WHEN '.$this->_table.'.myopia_accepted=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.myopia_eligble_patients=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.myopia_accepted/'.$this->_table.'.myopia_eligble_patients)*100)
END
							AS myopia_conversion_rate,

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
			$this->db->or_like($this->_table.'.routine_encounters::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.followup_encounters::text', $keyword, 'both', false);
			// $this->db->or_like('followup_routing_rate', $keyword);
			$this->db->or_like($this->_table.'.neurolens_eligble_patients::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.neurolens_accepted::text', $keyword, 'both', false);
			// $this->db->or_like('neurolens_conversion_rate', $keyword);
			$this->db->or_like($this->_table.'.occular_surface_scheduled::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.occular_surface_performed::text', $keyword, 'both', false);
			// $this->db->or_like('occular_surface_exam_rate', $keyword);
			$this->db->or_like($this->_table.'.lipiflow_treatments_performed::text', $keyword, 'both', false);
			// $this->db->or_like('lipiflow_conversion_rate', $keyword);
			$this->db->or_like($this->_table.'.myopia_eligble_patients::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.myopia_accepted::text', $keyword, 'both', false);
			// $this->db->or_like('myopia_conversion_rate', $keyword);
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

	function getFormDataById($showDeleted = false, $od_form_data_id)
	{
		$this->db->select($this->_table.'.od_form_data_id,
						'.$this->_table.'.user_id,
						'.$this->_table.'.office_id,
						o.office_name,
					    '.$this->_table.'.reporting_week,
					    '.$this->_table.'.routine_encounters,
					    '.$this->_table.'.followup_encounters,

CASE
	WHEN '.$this->_table.'.followup_encounters=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.routine_encounters=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.followup_encounters/'.$this->_table.'.routine_encounters)*100)
END

						    AS followup_routing_rate,


						   '.$this->_table.'.neurolens_eligble_patients,
						   '.$this->_table.'.neurolens_accepted,

CASE
	WHEN '.$this->_table.'.neurolens_accepted=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.neurolens_eligble_patients=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.neurolens_accepted/'.$this->_table.'.neurolens_eligble_patients)*100)
END
 							AS neurolens_conversion_rate,
						   '.$this->_table.'.has_ose_data,
						   '.$this->_table.'.occular_surface_scheduled,
						   '.$this->_table.'.occular_surface_performed,

CASE
	WHEN '.$this->_table.'.occular_surface_performed=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.occular_surface_scheduled=\'0\'
		THEN \'0\'
	ELSE
		((('.$this->_table.'.occular_surface_scheduled-'.$this->_table.'.occular_surface_performed)/'.$this->_table.'.occular_surface_scheduled)*100)
END

						    AS occular_surface_exam_rate,

						   '.$this->_table.'.lipiflow_treatments_performed,

CASE
	WHEN '.$this->_table.'.lipiflow_treatments_performed=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.occular_surface_performed=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.lipiflow_treatments_performed/'.$this->_table.'.occular_surface_performed)*100)
END

						   AS lipiflow_conversion_rate,

						   '.$this->_table.'.myopia_eligble_patients,
						   '.$this->_table.'.myopia_accepted,

CASE
	WHEN '.$this->_table.'.myopia_accepted=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.myopia_eligble_patients=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.myopia_accepted/'.$this->_table.'.myopia_eligble_patients)*100)
END
							AS myopia_conversion_rate,

						   '.$this->_table.'.created_at');
		$this->db->join('users u', 'u.user_id = '.$this->_table.'.user_id');
		$this->db->join('offices o', 'o.office_id = '.$this->_table.'.office_id');

		$this->db->where($this->_table.'.od_form_data_id', $od_form_data_id);

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
						->join('users u', 'u.user_id=ofd.user_id')
						->where($where)
						->get($this->_table.' ofd');
	}

	function updateFormData($od_form_data_id, $data)
	{
		$data = $this->permittedFields($data, $this->accessibleFields, 'update');
		$data = $this->updateTimestamps($data, 'update');

		$this->writeDB->where('od_form_data_id', $od_form_data_id)
					  ->set($data)
					  ->update($this->_table);

		if ($this->writeDB->affected_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteFormData($od_form_data_id)
	{
		$data = ['deleted' => true];
		$data = $this->updateTimestamps($data, 'delete');

		$this->writeDB->where('od_form_data_id', $od_form_data_id)
			->set($data)
			->update($this->_table);

		if ($this->writeDB->affected_rows() >= 1) {
			return true;
		} else {
			return false;
		}
	}

	public function restoreFormData($od_form_data_id)
	{
		$data = ['deleted' => false, 'deleted_at' => null];
		$data = $this->updateTimestamps($data, 'delete');

		$this->writeDB->where('od_form_data_id', $od_form_data_id)
			->set($data)
			->update($this->_table);

		if ($this->writeDB->affected_rows() >= 1) {
			return true;
		} else {
			return false;
		}
	}

	public function neurolensConversionRate($showDeleted)
	{
		$this->db->select($this->_table.'.office_id,
						'.$this->_table.'.reporting_week,
CASE
	WHEN '.$this->_table.'.neurolens_accepted=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.neurolens_eligble_patients=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.neurolens_accepted/'.$this->_table.'.neurolens_eligble_patients)*100)
END
 							AS neurolens_conversion_rate');

		$this->db->where($this->_table.'.reporting_week>=', $this->input->post('start_date'));
		$this->db->where($this->_table.'.reporting_week<=', $this->input->post('end_date'));

		if (sizeof($this->input->post('offices')))
			$this->db->where_in($this->_table.'.office_id', $this->input->post('offices'));

		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();

		return $this->db->get($this->_table);
	}

	public function lipiflowConversionRateChart($showDeleted)
	{
		$this->db->select($this->_table.'.office_id,
						'.$this->_table.'.reporting_week,
CASE
	WHEN '.$this->_table.'.lipiflow_treatments_performed=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.occular_surface_performed=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.lipiflow_treatments_performed/'.$this->_table.'.occular_surface_performed)*100)
END
						   AS lipiflow_conversion_rate');

		$this->db->where($this->_table.'.reporting_week>=', $this->input->post('start_date'));
		$this->db->where($this->_table.'.reporting_week<=', $this->input->post('end_date'));

		if (sizeof($this->input->post('offices')))
			$this->db->where_in($this->_table.'.office_id', $this->input->post('offices'));

		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();

		return $this->db->get($this->_table);
	}

	public function myopiaConversionRateChart($showDeleted)
	{
		$this->db->select($this->_table.'.office_id,
						'.$this->_table.'.reporting_week,
CASE
	WHEN '.$this->_table.'.myopia_accepted=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.myopia_eligble_patients=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.myopia_accepted/'.$this->_table.'.myopia_eligble_patients)*100)
END
							AS myopia_conversion_rate');

		$this->db->where($this->_table.'.reporting_week>=', $this->input->post('start_date'));
		$this->db->where($this->_table.'.reporting_week<=', $this->input->post('end_date'));

		if (sizeof($this->input->post('offices')))
			$this->db->where_in($this->_table.'.office_id', $this->input->post('offices'));

		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();

		return $this->db->get($this->_table);
	}
}

/* End of file Model_od_form_data.php */
