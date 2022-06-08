<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_location_form_data extends MY_Model
{
	protected $_table = 'location_form_data';

	protected $accessibleFields = ['user_id', 'office_id', 'reporting_week', 'cash_not_collected', 'cash_collected', 'dailylog_cash', 'scheduled_encounters', 'ecounters_confirmed', 'encounters_patients', 'encounters_newpatients', 'insurance_authorizations', 'total_retinal_images_accepted', 'encounters_routine', 'encounters_medical', 'medical_insurance_card_collected', 'glasses_eligible_encounters', 'glasses_purchase_encounters', 'contacts_eligible_encounters', 'contacts_purchase', 'payment_plans_accepted', 'social_reviews_google', 'social_reviews_facebook'];

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
			$this->db->or_like($this->_table.'.cash_not_collected::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.cash_collected::text', $keyword, 'both', false);
			// $this->db->or_like('cash_collection_rate::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.dailylog_cash::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.scheduled_encounters::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.encounters_patients::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.encounters_newpatients::text', $keyword, 'both', false);
			// $this->db->or_like('enconters_newpatient_rate::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.insurance_authorizations::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.total_retinal_images_accepted::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.encounters_routine::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.encounters_medical::text', $keyword, 'both', false);
			// $this->db->or_like('medical_conversion_rate', $keyword);
			$this->db->or_like($this->_table.'.medical_insurance_card_collected::text', $keyword, 'both', false);
			// $this->db->or_like('insurance_conversion_rate', $keyword);
			$this->db->or_like($this->_table.'.glasses_eligible_encounters::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.glasses_purchase_encounters::text', $keyword, 'both', false);
			// $this->db->or_like('glasses_capture_rate::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.contacts_eligible_encounters::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.contacts_purchase::text', $keyword, 'both', false);
			// $this->db->or_like('contact_capture_rate', $keyword);
			$this->db->or_like($this->_table.'.payment_plans_accepted::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.social_reviews_google::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.social_reviews_facebook::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.created_at::text', $keyword, 'both', false);
			$this->db->group_end();
		}

		return $this->db->count_all_results($this->_table);
	}

	function getFormDataById($showDeleted = false, $location_form_data_id)
	{
		$this->db->select($this->_table.'.location_form_data_id,
						'.$this->_table.'.user_id,
						'.$this->_table.'.office_id,
						o.office_name,
						'.$this->_table.'.reporting_week,
						'.$this->_table.'.cash_not_collected,
						'.$this->_table.'.cash_collected,

CASE
	WHEN '.$this->_table.'.cash_collected=\'0\'
		THEN \'0\'
	ELSE
		((('.$this->_table.'.cash_collected/('.$this->_table.'.cash_collected+'.$this->_table.'.cash_not_collected)))*100)
END
						    AS cash_collection_rate,

							'.$this->_table.'.dailylog_cash,
							'.$this->_table.'.scheduled_encounters,
							'.$this->_table.'.ecounters_confirmed,

CASE
	WHEN '.$this->_table.'.scheduled_encounters=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.ecounters_confirmed=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.ecounters_confirmed/'.$this->_table.'.scheduled_encounters)*100)
END
						    AS ecounters_confirmed_rate,

							'.$this->_table.'.encounters_patients,

CASE
	WHEN '.$this->_table.'.scheduled_encounters=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.encounters_patients=\'0\'
		THEN \'0\'
	ELSE
		((1-('.$this->_table.'.encounters_patients/'.$this->_table.'.scheduled_encounters))*100)
END
						    AS encounters_no_show_rate,

							'.$this->_table.'.encounters_newpatients,

CASE
	WHEN '.$this->_table.'.encounters_patients=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.encounters_newpatients=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.encounters_newpatients/'.$this->_table.'.encounters_patients)*100)
END
						    AS enconters_newpatient_rate,

							'.$this->_table.'.insurance_authorizations,

CASE
	WHEN '.$this->_table.'.encounters_patients=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.insurance_authorizations=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.insurance_authorizations/'.$this->_table.'.encounters_patients)*100)
END
						    AS insurance_compliance_rate,


							'.$this->_table.'.total_retinal_images_accepted,

CASE
	WHEN '.$this->_table.'.encounters_routine
=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.total_retinal_images_accepted=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.total_retinal_images_accepted/'.$this->_table.'.encounters_routine)*100)
END
						    AS retinal_images_accepted_rate,

							'.$this->_table.'.encounters_routine,
							'.$this->_table.'.encounters_medical,

CASE
	WHEN '.$this->_table.'.encounters_patients=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.encounters_medical=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.encounters_medical/'.$this->_table.'.encounters_patients)*100)
END
						    AS medical_conversion_rate,

							'.$this->_table.'.medical_insurance_card_collected,

CASE
	WHEN '.$this->_table.'.encounters_medical=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.medical_insurance_card_collected=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.medical_insurance_card_collected/'.$this->_table.'.encounters_medical)*100)
END
						    AS insurance_conversion_rate,

							'.$this->_table.'.glasses_eligible_encounters,
							'.$this->_table.'.glasses_purchase_encounters,

CASE
	WHEN '.$this->_table.'.glasses_eligible_encounters=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.glasses_purchase_encounters=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.glasses_purchase_encounters/'.$this->_table.'.glasses_eligible_encounters)*100)
END
						    AS glasses_capture_rate,

							'.$this->_table.'.contacts_eligible_encounters,
							'.$this->_table.'.contacts_purchase,

CASE
	WHEN '.$this->_table.'.contacts_purchase=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.contacts_eligible_encounters=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.contacts_purchase/'.$this->_table.'.contacts_eligible_encounters)*100)
END
						    AS contact_capture_rate,

							'.$this->_table.'.payment_plans_accepted,
							'.$this->_table.'.social_reviews_google,
							'.$this->_table.'.social_reviews_facebook,
							'.$this->_table.'.created_at');

		$this->db->join('users u', 'u.user_id = '.$this->_table.'.user_id');
		$this->db->join('offices o', 'o.office_id = '.$this->_table.'.office_id');

		$this->db->where($this->_table.'.location_form_data_id', $location_form_data_id);

		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();

		return $this->db->get($this->_table);
	}

	function getFormData($showDeleted = false, $start, $length, $order_by, $order, $keyword)
	{
		$this->db->select($this->_table.'.location_form_data_id,
						   CONCAT_WS(\' \', u.title, u.first_name, u.last_name) AS submitted_by,
						   o.office_name AS location,
						   '.$this->_table.'.reporting_week,
						   '.$this->_table.'.cash_not_collected,
						   '.$this->_table.'.cash_collected,

CASE
	WHEN '.$this->_table.'.cash_collected=\'0\'
		THEN \'0\'
	ELSE
		((('.$this->_table.'.cash_collected/('.$this->_table.'.cash_collected+'.$this->_table.'.cash_not_collected)))*100)
END
						    AS cash_collection_rate,

							'.$this->_table.'.dailylog_cash,
							'.$this->_table.'.scheduled_encounters,
							'.$this->_table.'.ecounters_confirmed,

CASE
	WHEN '.$this->_table.'.scheduled_encounters=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.ecounters_confirmed=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.ecounters_confirmed/'.$this->_table.'.scheduled_encounters)*100)
END
						    AS ecounters_confirmed_rate,

							'.$this->_table.'.encounters_patients,

CASE
	WHEN '.$this->_table.'.scheduled_encounters=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.encounters_patients=\'0\'
		THEN \'0\'
	ELSE
		((1-('.$this->_table.'.encounters_patients/'.$this->_table.'.scheduled_encounters))*100)
END
						    AS encounters_no_show_rate,

							'.$this->_table.'.encounters_newpatients,

CASE
	WHEN '.$this->_table.'.encounters_patients=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.encounters_newpatients=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.encounters_newpatients/'.$this->_table.'.encounters_patients)*100)
END
						    AS enconters_newpatient_rate,

							'.$this->_table.'.insurance_authorizations,

CASE
	WHEN '.$this->_table.'.encounters_patients=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.insurance_authorizations=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.insurance_authorizations/'.$this->_table.'.encounters_patients)*100)
END
						    AS insurance_compliance_rate,

							'.$this->_table.'.total_retinal_images_accepted,

CASE
	WHEN '.$this->_table.'.encounters_routine
=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.total_retinal_images_accepted=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.total_retinal_images_accepted/'.$this->_table.'.encounters_routine)*100)
END
						    AS retinal_images_accepted_rate,

							'.$this->_table.'.encounters_routine,
							'.$this->_table.'.encounters_medical,

CASE
	WHEN '.$this->_table.'.encounters_patients=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.encounters_medical=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.encounters_medical/'.$this->_table.'.encounters_patients)*100)
END
						    AS medical_conversion_rate,

							'.$this->_table.'.medical_insurance_card_collected,

CASE
	WHEN '.$this->_table.'.encounters_medical=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.medical_insurance_card_collected=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.medical_insurance_card_collected/'.$this->_table.'.encounters_medical)*100)
END
						    AS insurance_conversion_rate,

							'.$this->_table.'.glasses_eligible_encounters,
							'.$this->_table.'.glasses_purchase_encounters,

CASE
	WHEN '.$this->_table.'.glasses_eligible_encounters=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.glasses_purchase_encounters=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.glasses_purchase_encounters/'.$this->_table.'.glasses_eligible_encounters)*100)
END
						    AS glasses_capture_rate,

							'.$this->_table.'.contacts_eligible_encounters,
							'.$this->_table.'.contacts_purchase,

CASE
	WHEN '.$this->_table.'.contacts_purchase=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.contacts_eligible_encounters=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.contacts_purchase/'.$this->_table.'.contacts_eligible_encounters)*100)
END
						    AS contact_capture_rate,

							'.$this->_table.'.payment_plans_accepted,
							'.$this->_table.'.social_reviews_google,
							'.$this->_table.'.social_reviews_facebook,
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
			$this->db->or_like($this->_table.'.cash_not_collected::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.cash_collected::text', $keyword, 'both', false);
			// $this->db->or_like('cash_collection_rate::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.dailylog_cash::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.scheduled_encounters::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.encounters_patients::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.encounters_newpatients::text', $keyword, 'both', false);
			// $this->db->or_like('enconters_newpatient_rate::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.insurance_authorizations::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.total_retinal_images_accepted::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.encounters_routine::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.encounters_medical::text', $keyword, 'both', false);
			// $this->db->or_like('medical_conversion_rate', $keyword);
			$this->db->or_like($this->_table.'.medical_insurance_card_collected::text', $keyword, 'both', false);
			// $this->db->or_like('insurance_conversion_rate', $keyword);
			$this->db->or_like($this->_table.'.glasses_eligible_encounters::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.glasses_purchase_encounters::text', $keyword, 'both', false);
			// $this->db->or_like('glasses_capture_rate::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.contacts_eligible_encounters::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.contacts_purchase::text', $keyword, 'both', false);
			// $this->db->or_like('contact_capture_rate', $keyword);
			$this->db->or_like($this->_table.'.payment_plans_accepted::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.social_reviews_google::text', $keyword, 'both', false);
			$this->db->or_like($this->_table.'.social_reviews_facebook::text', $keyword, 'both', false);
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
						// ->join('users u', 'u.user_id=lfd.user_id')
						->where($where)
						->get($this->_table);
	}

	function updateFormData($location_form_data_id, $data)
	{
		$data = $this->permittedFields($data, $this->accessibleFields, 'update');
		$data = $this->updateTimestamps($data, 'update');

		$this->writeDB->where('location_form_data_id', $location_form_data_id)
					  ->set($data)
					  ->update($this->_table);

		if ($this->writeDB->affected_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteFormData($location_form_data_id)
	{
		$data = ['deleted' => true];
		$data = $this->updateTimestamps($data, 'delete');

		$this->writeDB->where('location_form_data_id', $location_form_data_id)
			->set($data)
			->update($this->_table);

		if ($this->writeDB->affected_rows() >= 1) {
			return true;
		} else {
			return false;
		}
	}

	public function getAllOfficesStats($showDeleted = false)
	{
		$this->db->select('office_id, SUM(encounters_patients) as patient_encounters, SUM(cash_not_collected)+SUM(cash_collected) as total_sales');
		$this->db->group_by('office_id');
		return $this->db->get($this->_table);
	}

	public function restoreFormData($form_response_id)
	{
		$data = ['deleted' => false, 'deleted_at' => null];
		$data = $this->updateTimestamps($data, 'delete');

		$this->writeDB->where('form_response_id', $form_response_id)
					  ->set($data)
					  ->update($this->_table);

		if ($this->writeDB->affected_rows() >= 1) {
			return true;
		} else {
			return false;
		}
	}

	public function patientEncountersChart($showDeleted)
	{
		$this->db->select($this->_table.'.office_id,
						'.$this->_table.'.reporting_week,
						'.$this->_table.'.encounters_patients');

		$this->db->where($this->_table.'.reporting_week>=', $this->input->post('start_date'));
		$this->db->where($this->_table.'.reporting_week<=', $this->input->post('end_date'));

		if (sizeof($this->input->post('offices')))
			$this->db->where_in($this->_table.'.office_id', $this->input->post('offices'));

		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();

		$this->db->order_by($this->_table.'.reporting_week', 'ASC');

		return $this->db->get($this->_table);
	}

	public function newPatientRateChart($showDeleted)
	{
		$this->db->select($this->_table.'.office_id,
						'.$this->_table.'.reporting_week,
CASE
	WHEN '.$this->_table.'.encounters_patients=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.encounters_newpatients=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.encounters_newpatients/'.$this->_table.'.encounters_patients)*100)
END
						    AS enconters_newpatient_rate');

		$this->db->where($this->_table.'.reporting_week>=', $this->input->post('start_date'));
		$this->db->where($this->_table.'.reporting_week<=', $this->input->post('end_date'));

		if (sizeof($this->input->post('offices')))
			$this->db->where_in($this->_table.'.office_id', $this->input->post('offices'));

		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();

		return $this->db->get($this->_table);
	}

	public function retinalImageAcceptanceRatesChart($showDeleted)
	{
		$this->db->select($this->_table.'.office_id,
						'.$this->_table.'.reporting_week,
CASE
	WHEN '.$this->_table.'.encounters_routine=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.total_retinal_images_accepted=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.total_retinal_images_accepted/'.$this->_table.'.encounters_routine)*100)
END
						    AS retinal_images_accepted_rate');

		$this->db->where($this->_table.'.reporting_week>=', $this->input->post('start_date'));
		$this->db->where($this->_table.'.reporting_week<=', $this->input->post('end_date'));

		if (sizeof($this->input->post('offices')))
			$this->db->where_in($this->_table.'.office_id', $this->input->post('offices'));

		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();

		return $this->db->get($this->_table);
	}

	public function patientEncounterConversionRateChart($showDeleted)
	{
		$this->db->select($this->_table.'.office_id,
						'.$this->_table.'.reporting_week,

CASE
	WHEN '.$this->_table.'.insurance_authorizations=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.scheduled_encounters=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.insurance_authorizations/'.$this->_table.'.scheduled_encounters)*100)
END

						    AS insurance_compliance_rate');

		$this->db->where($this->_table.'.reporting_week>=', $this->input->post('start_date'));
		$this->db->where($this->_table.'.reporting_week<=', $this->input->post('end_date'));

		if (sizeof($this->input->post('offices')))
			$this->db->where_in($this->_table.'.office_id', $this->input->post('offices'));

		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();

		return $this->db->get($this->_table);
	}

	public function totalPracticeCashChart($showDeleted)
	{
		$this->db->select($this->_table.'.office_id,
				    SUM('.$this->_table.'.dailylog_cash) AS total_cash_collected');

		$this->db->where($this->_table.'.reporting_week>=', $this->input->post('start_date'));
		$this->db->where($this->_table.'.reporting_week<=', $this->input->post('end_date'));

		if (sizeof($this->input->post('offices')))
			$this->db->where_in($this->_table.'.office_id', $this->input->post('offices'));

		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();

		$this->db->group_by($this->_table.'.office_id');

		return $this->db->get($this->_table);
	}

	public function cashCollectionRateChart($showDeleted)
	{
		$this->db->select($this->_table.'.office_id,
						'.$this->_table.'.reporting_week,
CASE
	WHEN '.$this->_table.'.cash_collected=\'0\'
		THEN \'0\'
	ELSE
		((('.$this->_table.'.cash_collected/('.$this->_table.'.cash_collected+'.$this->_table.'.cash_not_collected)))*100)
END
						    AS cash_collection_rate');

		$this->db->where($this->_table.'.reporting_week>=', $this->input->post('start_date'));
		$this->db->where($this->_table.'.reporting_week<=', $this->input->post('end_date'));

		if (sizeof($this->input->post('offices')))
			$this->db->where_in($this->_table.'.office_id', $this->input->post('offices'));

		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();

		return $this->db->get($this->_table);
	}

	public function contactLensConversionRateChart($showDeleted)
	{
		$this->db->select($this->_table.'.office_id,
						'.$this->_table.'.reporting_week,

CASE
	WHEN '.$this->_table.'.contacts_purchase=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.contacts_eligible_encounters=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.contacts_purchase/'.$this->_table.'.contacts_eligible_encounters)*100)
END

						    AS contact_capture_rate');

		$this->db->where($this->_table.'.reporting_week>=', $this->input->post('start_date'));
		$this->db->where($this->_table.'.reporting_week<=', $this->input->post('end_date'));

		if (sizeof($this->input->post('offices')))
			$this->db->where_in($this->_table.'.office_id', $this->input->post('offices'));

		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();

		return $this->db->get($this->_table);
	}

	public function glassesConversionRatesChart($showDeleted)
	{
		$this->db->select($this->_table.'.office_id,
						'.$this->_table.'.reporting_week,
CASE
	WHEN '.$this->_table.'.glasses_eligible_encounters=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.glasses_purchase_encounters=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.glasses_purchase_encounters/'.$this->_table.'.glasses_eligible_encounters)*100)
END
						    AS glasses_capture_rate');

		$this->db->where($this->_table.'.reporting_week>=', $this->input->post('start_date'));
		$this->db->where($this->_table.'.reporting_week<=', $this->input->post('end_date'));

		if (sizeof($this->input->post('offices')))
			$this->db->where_in($this->_table.'.office_id', $this->input->post('offices'));

		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();

		return $this->db->get($this->_table);
	}

	public function confirmationRateChart($showDeleted)
	{
		$this->db->select($this->_table.'.office_id,
						'.$this->_table.'.reporting_week,

CASE
	WHEN '.$this->_table.'.scheduled_encounters=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.ecounters_confirmed=\'0\'
		THEN \'0\'
	ELSE
		(('.$this->_table.'.ecounters_confirmed/'.$this->_table.'.scheduled_encounters)*100)
END

						    AS ecounters_confirmed_rate');

		$this->db->where($this->_table.'.reporting_week>=', $this->input->post('start_date'));
		$this->db->where($this->_table.'.reporting_week<=', $this->input->post('end_date'));

		if (sizeof($this->input->post('offices')))
			$this->db->where_in($this->_table.'.office_id', $this->input->post('offices'));

		$this->db->group_start();
		$this->db->where($this->_table.'.deleted', $showDeleted)->or_where($this->_table.'.deleted', false);
		$this->db->group_end();

		return $this->db->get($this->_table);
	}

	public function noShowRateChart($showDeleted)
	{
		$this->db->select($this->_table.'.office_id,
						'.$this->_table.'.reporting_week,
CASE
	WHEN '.$this->_table.'.scheduled_encounters=\'0\'
		THEN \'0\'
	WHEN '.$this->_table.'.encounters_patients=\'0\'
		THEN \'0\'
	ELSE
		((1-('.$this->_table.'.encounters_patients/'.$this->_table.'.scheduled_encounters))*100)
END

						    AS encounters_no_show_rate');

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

/* End of file Model_location_form_data.php */
