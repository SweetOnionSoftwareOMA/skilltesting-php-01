<?php
defined('BASEPATH') or exit('No direct script access allowed');

//* The HACKY way of providing multiple customer controller classes is to just define multiple classes in this file.

/**
 * MY_CONTROLLER
 *
 * This class overloads the CI_CONTROLLER Class permitting us to use it as the
 * BASE controller class.
 *
 */
class MY_Controller extends CI_Controller
{
	/**
	 * @var array $data
	 *
	 * Provides the base array for all information passed to the templated view.
	 *
	 *      pageTitle
	 *      templateStyle
	 *      primaryView
	 *      pageFunction
	 *      pageClass
	 *
	 *  reference object &$data that can be passed to sub views
	 *
	 *      embededData
	 */
	public $data = [];
	public $cache_redis;
	public $logger = [];

	function __construct()
	{
		parent::__construct();

		// Load Caching Driver so all application has access
		require_once APPPATH . 'libraries/codeigniter-predis/src/Redis.php';
		$this->cache_redis = new \CI_Predis\Redis();
		$this->load->driver('cache', array('adapter' => 'redis','backup' => 'file'));

		// TODO: Change this to a check of a .ENV var
		if (ENVIRONMENT == 'development')
		{
			// $this->output->enable_profiler(TRUE);
		}

		// DEFINE SOME DEFAULT VARIABLES WITH DEFAULTS FOR THE ENTIRE SITE

		$this->data['pageTitle'] = 'Metrics That Matters';

		//  These settings drive the view(s)
		$this->data['templateStyle'] = 'default';
		$this->data['primaryView'] = null;

		// These settings assist with the CSS and stylings
		$this->data['pageFunction'] = null;
		$this->data['pageClass'] = null;

		$this->data['csrf'] = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		// Initialize user accounting logger
		$this->logger_accounting->initLogger();

		// Site Self Discovery and Documentation
		$currentPage =  $this->router->fetch_class() . '-' . $this->router->fetch_method();
		$this->selfdoc->documentPage($currentPage, $this->config->item('app_name'));
	}

	/**
	 * Provides Inherited level access to the user_accounting logger
	 * These are the minimum fields required, review the logger class for additional properties.
	 *
	 * @example [
	 *    'user_id'         => $_SESSION['user_id'],
	 *    'object_class'  => 'user',
	 *    'object_id'   => $_SESSION['user_id'],
	 *    'action'          => 'update',
	 *  ]
	 *
	 * @param [array] $properties
	 *
	 * @return void
	 *   Function returns void intentionally, we don't want logging to stop execution, EVER.
	 */
	protected function writeToLog(array $properties)
	{
		if ($this->logger_accounting->setLogMessage($properties))
		{
			$this->logger_accounting->writeMessage();
		}
	}
}


/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 */
class Base_Controller extends MY_Controller
{

	// TODO: Sessions to Database

	public function __construct()
	{
		parent::__construct();

		// Do not load session library in home screen to prevent erroneous sessions from AWS WAF
		$this->load->library('session');

		//  Ban Repeated Attempts to login.
		if (isset($_SESSION['attemptCount']) && $_SESSION['attemptCount'] > 5)
		{
			redirect('/not_permitted');
		}
	}

	/**
	 * Creates a uniformed flash messaged throughout the site.
	 *
	 * @param string $title
	 * @param string $severity
	 * @param array|string $message
	 *
	 * @return void
	 */
	public function setFlashMessage($title, $severity, $message)
	{
		// Ensure that the messages are being properly typed
		if (gettype($message) == 'string')
		{
			$message = [$message];
		}

		$this->session->set_flashdata('userMessageTitle', $title);
		$this->session->set_flashdata('userMessages', $message);

		// This variable is used in a JS widget SweetAlert, it should be lowercased.
		// Acceptable values are: error, success, question, info, warning
		// Ensure correct value set, or override
		$severity = (in_array(strtolower($severity), ['error', 'success', 'question', 'info', 'warning'])) ? $severity : 'info';
		$this->session->set_flashdata('userMessageType', strtolower($severity));
	}
}

/**
 * Extend this controller class when you want to ensure the user is logged before
 * they access the resource
 *
 * NOTE:   If you find yourself in infinite redirections, check to see if PHP errors are being
 * thrown.  The CI Error template seems to clear the session array.
 *
 */
class Auth_Controller extends Base_Controller
{
	public function __construct()
	{
		parent::__construct();

    	// Validate permissions for the URI
		$permission = $this->router->fetch_class() .'-'. $this->router->fetch_method();
		if ( !$this->authuser->hasPermission($permission)) {
			// || hasRole()
			if (!isset($_SERVER['HTTP_REFERER'])) {
				redirect('my-profile');
			} else {
				$this->setFlashMessage('Not Authorized', 'info', 'Your account does not have access to that function.');
				redirect ($_SERVER['HTTP_REFERER']);
			}
		}
	}

	public function __destruct()
	{
		// Validate user is logged in, if not reroute. This is in the destruct method to permit changes
		// being saved before the user is booted.
		if (!$this->input->is_ajax_request()) {
			if (($this->authuser->isLoggedIn() === false) || ($this->authuser->hasActiveSession() === false)) {
				redirect('/session_expired');
			}
		}
	}
}
