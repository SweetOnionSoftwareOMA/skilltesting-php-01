<?php

defined('BASEPATH') or exit('No direct script access allowed');


class Model_lookups extends MY_Model
{

	protected $_table = null;

	protected $accessibleFields = [];

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Returns a list of all states using the Abbreviation as the KEY and the
	 * name as the value.
	 *
	 * @param bool $asSelect True will return the query in an array ready for
	 * 							HTML selects
	 *
	 * @return mixed
	 */
	public function statesAbbrKey($asSelect = false)
	{
		$q = $this->db->order_by('state_name', 'ASC')->get('states');
		return ($asSelect) ? $this->toSelect('state_abbr', 'state_name', $q) : $q ;
	}


	/**
	 * Return all of the active offices in the application.
	 *
	 * @param mixed $asSelect returns it as id=>name array
	 *
	 * @return void
	 */
	public function getOffices($asSelect = false)
	{
		$q = $this->db->where('deleted', false)->order_by('office_name')->get('offices');

		return ($asSelect) ? $this->toSelect('office_id', 'office_name', $q) : $q ;
	}

}

/* End of file Model_lookups.php */
