<?php defined('BASEPATH') or exit('No direct script access allowed');


/**
 * LOGGER_ACCOUNTING
 *
 * This class provides user level logging for accounting for users actions
 *
 * set methods can be used individually, or
 */
final class Logger_accounting
{

	private $_CI = null;
	private $_init = false;

	// Used to prevent extra keys from being specified in the setLogMessage method.
	//  private properties should not listed as valid
	private $validKeys = [ 'user_id','object_class','object_id','action','extra_message',];

	// Certain attributes are not available during login/logout activities
	private $loginActivity = false;

	protected $message_properties = [];
	protected $savedState = false;
	protected $error_message = null;

	// If more actions are required, add them to this array.
	private $validActions = [
						'login', 'logout', 'cred_reset',
						'insert', 'update', 'delete', 'configured',
						'reporting'
						];

    public function __construct()
    {
		$this->_CI = &get_instance();
	}

	public function initLogger()
	{
		$this->message_properties['user_id'] = null;
		$this->message_properties['controller'] = $this->_CI->router->fetch_class();
		$this->message_properties['method']	= $this->_CI->router->fetch_method();
		$this->message_properties['object_class'] = null;
		$this->message_properties['object_id'] = null;
		$this->message_properties['action'] = null;
		$this->message_properties['extra_message'] = null;

		$this->setUserIP();
		$this->_isImpersionating();
		$this->_init = true;
	}

	public function setLogMessage(array $params)
	{
		if (! $this->_init) $this->initLogger();

		//  Validate that a key, value associative array was passed.
		if (count(array_keys($params)) !== count(array_values($params))) return false;

		foreach ($params as $k => $v)
		{
			// Only set property if valid for class
			if (in_array($k, $this->validKeys)) $this->message_properties[$k] = $v;
		}

		return true;
	}

	public function setUser(int $ID = null)
	{
		$this->message_properties['user_id'] = $ID;
	}

	public function setObjectClass(string $class_name)
	{
		$this->message_properties['object_class'] = $class_name;
	}

	public function setObjectId(int $id)
	{
		$this->message_properties['object_id'] = $id;
	}

	public function setAction(string $action)
	{
		if (! $this->_isValidAction) {
			$this->error_message = 'Not a valid Action.';
			return false;
		}

		if (in_array($action, ['login', 'logout', 'cred_reset']))
		{
			$this->loginActivity = true;
		}
		$this->message_properties['action'] = $action;
	}

	public function setUserIP()
	{
		$this->message_properties['user_ip'] = $_SERVER['REMOTE_ADDR'];
	}

	public function setExtraMessage(array $message = null)
	{
		$this->message_properties['extra_message'] = json_encode($message);
	}

	public function writeMessage()
	{
		if ($this->savedState)
		{
			$this->error_message = 'Already Saved';
			return false;
		}
		return $this->_saveLog();
	}

	public function getErrorMessage()
	{
		return $this->error_message;
	}

//  ===============================  PRIVATE METHODS   =============================== //

	public function _isValidAction($action)
	{
		return (in_array($action, $this->validActions));
	}

	private function _isImpersionating()
	{
		$this->message_properties['impersonating'] = ( isset($_SESSION['impersonating']) && is_bool($_SESSION['impersonating']) ) ? $_SESSION['impersonating'] : false ;
		$this->message_properties['user_impersonating'] = ( isset($_SESSION['user_impersonating']) && $_SESSION['user_impersonating'] !== false ) ? $_SESSION['user_impersonating'] : null ;
	}

	private function _saveLog()
	{
		$this->_CI->load->model('../libraries/logger/Model_logger_accounting', 'm_logger_accounting');

		//  BASE minimum keys to create a log message
		$requiredKeys = ['controller','method','action','user_ip',];

		if (! $this->loginActivity)
		{
			//  This might be NULL property, but attempt anyway
			array_merge($requiredKeys, ['user_id']);

			//  Check if an object is being modified, if require additional fields.
			if (in_array($this->message_properties['action'], ['insert', 'update', 'delete']))
			{
				array_merge($requiredKeys, ['object_class','object_id',]);
			}
		}
			// IF the correct values are not set, abort... abort... abort...
		if (! $this->_validateData($requiredKeys))  return false;

		$this->message_properties['impersonating'] = (isset($_SESSION['user_impersonating']) && $_SESSION['user_impersonating'] !== false) ? true : false;
		$this->savedState =  $this->_CI->m_logger_accounting->saveLogMessage($this->message_properties);
		return $this->savedState;
	}

	public function _validateData($requiredKeys)
	{
		$failed_fields = array();
		$passed = true;
		foreach ($requiredKeys as $r)
		{
			$valid = (isset($this->message_properties[$r]) && ! is_blank($this->message_properties[$r]));
			if (! $valid)
			{
				array_push($failed_fields, $r);
				$passed = false;
			}
		}
		if (! $valid) $this->error_message = 'Missing Required Keys: ' .implode(', ', $failed_fields);
		return $passed;
	}


}

/**
 *	 These are the properties of the LOGGER library that can be set

 *   'user_id'  	 => null,
 *   'object_class'  => null,
 *   'object_id'  	 => null,
 *   'action'  		 => null,
 *   'extra_message' => null,
 */

