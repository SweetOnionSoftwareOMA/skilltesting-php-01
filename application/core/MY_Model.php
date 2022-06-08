<?php

use phpDocumentor\Reflection\Types\Boolean;

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

	// These get reset with each Model Load.
	protected $hasTimestamps = FALSE;
	protected $useCallbacks = TRUE;
	protected $_table = NULL;
	protected $accessibleFields = [];

	public function __construct()
	{
		parent::__construct();
		$this->writeDB = $this->load->database('writer', TRUE, TRUE);

		 // Pass reference of database to the CI-instance
		 //  Assists with intellisense and profiler
		$CI =& get_instance();
		$CI->writeDB =& $this->writeDB;
	}


	/**
	 * Function removes any fields from multidimensional array based on
	 * the submitted fieldlist. Based on rails permittedvalues
	 *
	 * @param array $postVar multidimensional array
	 * @param array $fieldList
	 *
	 * @return array multidimensional
	 */
	final protected function permittedFields($postVar, $fieldList, $action = null)
	{
		$fields = $postVar;
		foreach ($postVar as $key => $value) {
			if (!in_array($key, $fieldList)){
				unset($fields[$key]);
			}
			else {
				//  This keeps string from just spaces, but also permits NULL values.
				$fields[$key] = ($value === null) ? null : ((gettype($value) == 'boolean') ? $value : trim($value));
			}
		}
		return $fields;
	}


	/**
	 * Custom Function that updates the timestamps on all records
	 */
	final protected function updateTimestamps($fields, $action)
	{
		$now = UTC_Now();
		if ($action == 'update') {
			$fields = array_merge($fields, ['updated_at' => $now]);
		}
		if ($action == 'insert') {
			$fields = array_merge($fields, ['created_at' => $now]);
		}
		if ($action == 'delete') {
			$fields = array_merge($fields, ['updated_at' => $now]);
			$fields = array_merge($fields, ['deleted_at' => $now]);
		}
		return $fields;
	}

	/**
	 * Takes a CI Query Result Object and two columns and turns into a
	 * key -> value pair array for use in HTML select boxes and such.
	 *
	 * @param string $key
	 * @param string $value
	 * @param CIQUERYRESULT $query
	 *
	 * @return array
	 */
	final protected function toSelect($key, $value, $query)
	{
		$result = array();
		foreach ($query->result() as $row)
		{
			$result[$row->$key] = $row->$value;
		}
		return $result;
	}

}

/* End of file MY_Model.php */
