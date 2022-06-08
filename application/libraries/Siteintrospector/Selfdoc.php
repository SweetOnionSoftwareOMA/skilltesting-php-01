<?php defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 *  This library contains all the site/application wide functions requried to record
 * 		self-discovery Controller/Methdods and turn them into permissions.
 *
 * 	In addition, this library will house "HELP" functionality.
 *
 */
final class Selfdoc {

	/**
	 * @var CIMODEL Loads the Siteintrospector libray's custom model
	 */
	protected $model = null;
	protected $CI = null;

	public function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->load->model('../libraries/Siteintrospector/Model_site', 'site');
	}

	/**
	 * Validate if a permissions record exists for the supplied path.
	 * If it does not it creates the record. This allows for immediate permissions
	 * by developers (with SuperAdmin).
	 *
	 * The permission will still require assignment to a role for other users to access
	 *
	 * @return void
	 */
	public function documentPage($thisPage, $app)
	{
		$fullPage = $app .'-' .$thisPage;
		$this->CI->cache_redis->del('allAppPages');
		$allAppPages = $this->CI->cache_redis->get('allAppPages');
		// Verify if all the site's pages have been loaded from the permissions table
		if ( ! $allAppPages )
		{
			$p = $this->CI->site->getAppPages($app);
			$saved = $this->CI->cache_redis->set('allAppPages', implode(",", $p));
			$allAppPages = $this->CI->cache_redis->get('allAppPages');
		}

		// Check if the current page is already created as a permission
		if ( !$allAppPages || ! in_array($fullPage, explode(',', $allAppPages)) )
		{
			// Write to Database
			$this->CI->site->createPage($thisPage, $app);
			$this->CI->cache_redis->set('allAppPages', ',' . $fullPage);
		}
	}
}
