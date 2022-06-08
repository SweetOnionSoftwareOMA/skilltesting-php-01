<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Model_logger_accounting extends MY_Model
{

    protected $_table = 'logs_audits';

    protected $accessibleFields = [
		'user_id','user_impersonating','controller','method','action',
		'object_class','object_id','user_ip','impersonating','extra_message',
    ];

    public function __construct()
    {
        parent::__construct();
	}

	public function saveLogMessage($props)
	{
		$row = $this->permittedFields($props, $this->accessibleFields, 'insert');
		$row = $this->updateTimestamps($row, 'insert');
		$this->writeDB->insert($this->_table, $row);

		return ($this->writeDB->affected_rows() > 0);
	}
}

/* End of file Model_logger_accounting.php */
