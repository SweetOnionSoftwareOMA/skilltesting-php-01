<?php defined('BASEPATH') or exit('No direct script access allowed');


class Model_site extends MY_Model
{


	public function __construct()
	{
		parent::__construct();
	}

	public function getAppPages($app)
	{
		$r = $this->db->select("CONCAT(app, '-', controller,'-',page_method) as page")
					->where('app', $app)
					->get('permissions');

		return query_column_to_array($r->result(), 'page');
	}

	public function createPage($page, $app)
	{
		list($controller, $method) = explode( '-', $page);
		$record = [
			'permission_name' 	=> $page,
			'controller' 		=> $controller,
			'page_method'		=> $method,
			'app'				=> $app,
		];
		$record = $this->updateTimestamps($record, 'insert');
		$r = $this->writeDB->insert('permissions', $record);

	}
}

/* End of file Model_site.php */
