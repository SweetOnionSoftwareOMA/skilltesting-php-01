<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Weeklyemails extends CI_Controller {

	protected $_modelRoot = 'app/';

	public function __construct()
	{
		parent::__construct();

		//Disallow the direct access except CLI
		if (!$this->input->is_cli_request()){
			show_error('Direct access is not allowed');
		}

		// Load Library
		$this->load->library('emails/weekly');
		$this->load->helper('file');
		$this->reporting_week = new DateTime('Monday ago');
		$this->log_message = array(date('Y-m-d h:i:s', strtotime('now')));
	}

    public function od_report($send_to)
	{
		$this->load->model($this->_modelRoot . 'Model_od_form_data', 'm_od_form_data');
		if ($this->weekly->od_report($send_to, $this->reporting_week)) {
			$this->log_message[] = 'OD Weekly email sent to '.$send_to.'.';
		} else {
			$this->log_message[] = 'Unable to send OD Weekly email to '.$send_to.'.';
		}
		$this->_write_email_log_message();
	}

    public function location_report($send_to)
	{
		$this->load->model($this->_modelRoot . 'Model_location_form_data', 'm_location_form_data');
		if ($this->weekly->location_report($send_to, $this->reporting_week)) {
			$this->log_message[] = 'Location Weekly email sent to '.$send_to.'.';
		} else {
			$this->log_message[] = 'Unable to send Location Weekly email to '.$send_to.'.';
		}
		$this->_write_email_log_message();
	}

    public function vc_report($send_to)
	{
		$this->load->model($this->_modelRoot . 'Model_vc_form_data', 'm_vc_form_data');
		if ($this->weekly->vc_report($send_to, $this->reporting_week)) {
			$this->log_message[] = 'VC Weekly email sent to '.$send_to.'.';
		} else {
			$this->log_message[] = 'Unable to send VC Weekly email to '.$send_to.'.';
		}
		$this->_write_email_log_message();
	}

	private function _write_email_log_message()
	{
		$file = APPPATH .'logs/weekly-log-'.$this->reporting_week->format('m-d-Y').'.txt';
		$log_content = read_file($file);

		$log_content .= (($log_content) ? "\n" : "" ).implode("\t", $this->log_message);

		if (write_file($file, $log_content)) {
			echo 'Job log has been written.';
		} else {
			echo 'Unable to write log.';
		}
	}
}
/* End of file Weeklyemails.php */
