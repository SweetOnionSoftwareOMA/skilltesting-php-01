<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Weekly {

	function __construct()
    {
		$this->_CI = &get_instance();
	}

	/**
	 * send Location weekly email
	 *
	 * @param string $send_to
	 *
	 * @param object $date
	 *
	 **/
	function od_report($send_to, $date)
	{
		if ($date) {
			$_POST['start_date'] 	= $date->format('Y-m-d');
			$_POST['end_date'] 		= $date->format('Y-m-d');
		}

		//Get Weekly Data
		$form_data = $this->_CI->m_od_form_data->getFormData(false, '0', '-1', 'location', 'ASC', '');
		if ($form_data->num_rows()) {
			return $this->_send_email($send_to, 'OD', $date->format('M d Y'), $form_data->result_array());
		} else {
			show_error('No result found for this week ['.$keyword.'].');
		}
	}

	/**
	 * send Location weekly email
	 *
	 * @param string $send_to
	 *
	 * @param object $date
	 *
	 **/
    function location_report($send_to, $date)
	{
		if ($date) {
			$_POST['start_date'] 	= $date->format('Y-m-d');
			$_POST['end_date'] 		= $date->format('Y-m-d');
		}

		//Get Weekly Data
		$form_data = $this->_CI->m_location_form_data->getFormData(false, '0', '-1', 'location', 'ASC', '');

		if ($form_data->num_rows()) {
			return $this->_send_email($send_to, 'Location', $date->format('M d Y'), $form_data->result_array());
		} else {
			show_error('No result found for this week ['.$keyword.'].');
		}
	}

	/**
	 * send VC weekly email
	 *
	 * @param string $send_to
	 *
	 * @param object $date
	 *
	 **/
    function vc_report($send_to, $date)
	{
		if ($date) {
			$_POST['start_date'] 	= $date->format('Y-m-d');
			$_POST['end_date'] 		= $date->format('Y-m-d');
		}

		//Get Weekly Data
		$form_data = $this->_CI->m_vc_form_data->getFormData(false, '0', '-1', 'location', 'ASC', '');

		if ($form_data->num_rows()) {
			return $this->_send_email($send_to, 'VC', $date->format('M d Y'), $form_data->result_array());
		} else {
			show_error('No result found for this week ['.$keyword.'].');
		}
	}

	private function _send_email($send_to, $form_name, $reporting_week, $form_data) {

		$this->_CI->load->library('email');

		$this->_CI->email->initialize(array('protocol' => 'smtp',
											'smtp_host' => 'smtp.sendgrid.net',
											'smtp_user' => 'apikey',
											'smtp_pass' => $this->_CI->config->item('sendgrid_key'),
											'smtp_port' => 587,
											'crlf' => "\r\n",
											'newline' => "\r\n"));

		$this->_CI->email->from('no-reply@visionplanpro.com', 'Vision Pro');

		$this->_CI->email->to($send_to);

		$this->_CI->email->subject($form_name.' Form - Monday, '.$reporting_week);

		$msg = $this->_CI->load->view('app/emails/weekly_'.strtolower($form_name).'_template', array('form_data' => $form_data), true);

		$this->_CI->email->message($msg);

		return $this->_CI->email->send();
	}
}
