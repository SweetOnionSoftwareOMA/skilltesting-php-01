<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/


/*
|--------------------------------------------------------------------------
| BUGSNAG INTEGRATION
|--------------------------------------------------------------------------
|
*/

$hook['pre_system'] = function(){
    require_once 'vendor/autoload.php';

    // Automatically send unhandled errors to your Bugsnag dashboard:
	if (ENVIRONMENT != 'development') {
		$GLOBALS['bugsnag'] = Bugsnag\Client::make("57f6b8cdf54c06b07517a0f44ebfd1ef");
		$GLOBALS['bugsnag']->setReleaseStage(ENVIRONMENT);
		$GLOBALS['bugsnag']->setAppType('MTM');
		Bugsnag\Handler::register($GLOBALS['bugsnag']);
	};
	// Manually send an error (you can use this to test your integration)
    // $GLOBALS['bugsnag']->notifyError('ErrorType', 'Testing Integration');
  }


?>
