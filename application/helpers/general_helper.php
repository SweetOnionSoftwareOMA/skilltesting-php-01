<?php

/**
 *
 *  helper function that returns the current date/time
 *
 * @var OPTIONAL:string $rt Return type either: string|object
 *
 * @return mixed
 */
function UTC_Now($rt = 'string')
{
	$dtz = new DateTimeZone("UTC");
	$now = new DateTime(date("c"), $dtz);
	if ($rt == 'object') {
		return $now;
	}
	return $now->format("Y-m-d H:i:s");
}

/**
 *
 * returns the date/time X number of days from NOW or the datetime you supplied
 * Can return as a string or DateTime Object based on 2nd parameter
 *
 * @param int $days
 *
 * @param string $rt
 *
 * @param DateTime $startDate
 *
 * @return mixed
 */

function addDays( int $days, $rt = 'string', DateTime $startDate = null)
{
	if (empty($startDate))
	{
		$startDate = UTC_Now('object');
	}
	$startDate->modify('+' .$days .'days');

	if ($rt == 'object')
	{
		return $startDate;
	}
	return $startDate->format("Y-m-d H:i:s");
}

/**
 *
 * returns the date/time going backward the number of days from NOW or the datetime you supplied
 * Can return as a string or DateTime Object based on 2nd parameter
 *
 * @param int $days
 *
 * @param string $rt
 *
 * @param DateTime $startDate
 *
 * @return mixed
 */

function subtractDays(int $days, $rt = 'string', DateTime $startDate = null)
{
	if (empty($startDate)) {
		$startDate = UTC_Now('object');
	}
	$startDate->modify('-' . $days . 'days');

	if ($rt == 'object') {
		return $startDate;
	}
	return $startDate->format("Y-m-d H:i:s");
}


/**
 *  validates if the supplied string is truthy. through optional 2nd param
 *  the function permits checks against an additional value(s).
 *   Supply as a string
 *
 * @param string  $string
 *
 * @param string $addValue OPTIONAL
 *
 * @return boolean DEFAULTS FALSE
 */
function to_boolean($string, string $addValue = null) {
	// convert to lowercase string
	$string = strtolower(strval($string));
	if ($addValue === null) {
		$truthy = ['true', 'on', 't', 'yes', 'y', '1'];
	} else {
		$truthy = ['true', 'on', 't', 'yes', 'y', '1', $addValue];
	}

	return (in_array($string, $truthy));
}

/**
 * Determines is supplied item is null, empty, or empty string.
 * A string with a space is NOT considered blank, if want to ignore
 * spaces, trim before sending to function.
 *
 * @param $thing
 *
 * @return boolean
 */
function is_blank($thing)
{
// This function should be be expanded on as needed.
//   will throw error if supplied a type that is not handled

	if ($thing === null || !isset($thing)) {
		return true;
	}

	switch (gettype($thing)) {
		case 'string':
			if (strlen($thing) == 0) return true;
			break;

		case 'array':
			if (count($thing) == 0) return true;
			break;


		default:
			throw new Exception('Unknown Type Provided');

	return false;
	}
}

/**
 * generate a random password
 * contains: 2 capital, 2 numbers, 2 symbols and 6 small letters
 */
function random_password() {
	$capital = 'ABCDEFGHJKMNPQRSTUVWXYZ';
	$small = 'abcdefghjkmnpqrstuvwxyz';
	$number = '23456789';
	$symbol = '.!#=';
	$pass = array();
	$capitalLength = strlen($capital) - 1;
	$smallLength = strlen($small) - 1;
	$numberLength = strlen($number) - 1;
	$symbolLength = strlen($symbol) - 1;
	for ($i = 0; $i < 12; $i++) {
		$length = ($i == 4 || $i == 11 ? $numberLength : ($i == 2 || $i == 10 ? $symbolLength : ($i == 6 || $i == 9 ? $capitalLength : $smallLength)));
		$array = ($i == 4 || $i == 11 ? $number : ($i == 2 || $i == 10 ? $symbol : ($i == 6 || $i == 9 ? $capital : $small)));
		$n = rand(0, $length);
		$pass[] = $array[$n];
	}
	return implode($pass);
}

/**
 * send new form data email
 *
 * @param string $send_to
 *
 * @param string $form_name
 *
 * @param string $reporting_week
 *
 * @param array $form_data
 *
 */
function send_new_form_data_email($send_to, $form_name, $reporting_week, $form_data) {
	$CI =& get_instance();

	$CI->load->library('email');

	$CI->email->initialize(array('protocol' => 'smtp',
								 'smtp_host' => 'smtp.sendgrid.net',
								 'smtp_user' => 'apikey',
								 'smtp_pass' => $CI->config->item('sendgrid_key'),
								 'smtp_port' => 587,
								 'crlf' => "\r\n",
								 'newline' => "\r\n"));

	$CI->email->from('no-reply@visionplanpro.com', 'Vision Pro');

	$CI->email->to($send_to);

	$CI->email->subject($form_name.' Form - Monday, '.$reporting_week.' - '.$form_data['office_name']);

	$msg = $CI->load->view('app/emails/'.strtolower($form_name).'_template', array('form_data' => $form_data), true);

	$CI->email->message($msg);

	return $CI->email->send();
}
