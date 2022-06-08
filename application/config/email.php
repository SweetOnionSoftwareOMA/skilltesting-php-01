<?php

$config['useragent']			= 'VisionSpecialistsMailer';
$config['protocol']				= 'smtp';
$config['mailpath']				= false;			// We do not use sendmail servers.
$config['smtp_host']			= getenv('DB_SMTP_HOSTNAME');
$config['smtp_user']			= getenv('DB_SMTP_USER');
$config['smtp_pass']			= getenv('DB_SMTP_PASSWORD');
$config['smtp_port']			= getenv('DB_SMTP_PORT');
$config['smtp_timeout']			= getenv('DB_SMTP_TIMEOUT');
$config['smtp_keepalive']		= getenv('DB_SMTP_KEEPALIVE');
$config['smtp_crypto']			= '';
$config['wordwrap']				= true;
$config['wrapchars']			= 80;
$config['mailtype']				= 'html';
$config['charset']				= 'utf-8';
$config['validate']				= false;
$config['priority']				= 3;
$config['crlf']					= '\r\n';
$config['newline']				= '\r\n';
$config['bcc_batch_mode']		= true;
$config['bcc_batch_size']		= 30;
$config['dsn']					= false;

defined('AUTHMAILER_FROM_EMAIL')      or define('AUTHMAILER_FROM_EMAIL', 'auth_noreply@visionspecialists.com');
defined('AUTHMAILER_FROM_NAME')      or define('AUTHMAILER_FROM_NAME', 'VPP SECURITY');
defined('EMAIL_SUBJECT_START')		or define('EMAIL_SUBJECT_START', 'Vision Specialists | ');

