<?php defined('BASEPATH') or exit('No direct script access allowed');

$config['redis'] = [];

$config['redis'] = [
	'default_server' => 'primary',
	'servers' => [
		'primary' => [
			'scheme' => 'tcp',
			'host' => getenv('CACHE_REDIS_HOST'),
			'port' =>  getenv('CACHE_REDIS_PORT'),
			'password' => getenv('CACHE_REDIS_PASSWORD'),
			'database' => 3,
			'timeout'	=> getenv('CACHE_REDIS_TIMEOUT')
			]
		]
	];

// Set a constant to be the default for the entire Application,
//	can be overridden per function call
//
// EXAMPLE:
//  	$this->cache->save('key, 'Some Value',CACHE_REDIS_KEY_TIMEOUT);
defined('REDIS_KEY_TIMEOUT')  or define('REDIS_KEY_TIMEOUT', getenv('CACHE_REDIS_KEY_TIMEOUT'));
