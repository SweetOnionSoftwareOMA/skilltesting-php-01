<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends Auth_Controller
{
	public function __construct()
	{
		parent::__construct();
		$stuff = 'stuff';
	}

	public function index()
	{
		redirect('app/dashboard');
	}

	public function not_permitted()
	{
		// development & Testing override option.
		if (isset($_GET['override']) && $_GET['override'] == 'admin' && isset($_GET['reset'])) {
			$this->session->sess_destroy();
		}
		echo 'Your Action is not Permitted.';
	}
}
