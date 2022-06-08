<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class MY_Security extends CI_Security {

	/**
	 * CSRF Set Cookie
	 *
	 * @codeCoverageIgnore
	 * @return	CI_Security
	 */
	public function csrf_set_cookie()
	{
		$expire = time() + $this->_csrf_expire;
		// $secure_cookie = (bool) config_item('cookie_secure');
	// BUGFIX
	//	ADDED this code to fix a know issue when not using https, in production this is forced
		if (ENVIRONMENT == 'development')
		{
			$secure_cookie = FALSE;
		}
		else
		{
			$secure_cookie = (bool) config_item('cookie_secure');
		}
	// END BUGFIX

		if ($secure_cookie && !is_https()) {
			return FALSE;
		}

		setcookie(
			$this->_csrf_cookie_name,
			$this->_csrf_hash,
			$expire,
			config_item('cookie_path'),
			config_item('cookie_domain'),
			$secure_cookie,
			config_item('cookie_httponly')
		);
		log_message('info', 'CSRF cookie sent');

		return $this;
	}

}
