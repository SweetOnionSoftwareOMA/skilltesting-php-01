<?php defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| REDIS settings
| -------------------------------------------------------------------------
| Your REDIS servers can be specified below.
|
|	See: https://sujanbyanjankar.com.np/redis-codeigniter/
|
*/


//`tcp` or `unix`
$config['socket_type'] 	= getenv('CACHE_REDIS_SOCKET_TYPE');
// in case of `unix` socket type
$config['socket'] 		= getenv('CACHE_REDIS_SOCKET');
//change this to match your amazon redis cluster node endpoint
$config['host'] 		= getenv('CACHE_REDIS_HOST');
// If supported this is recommeded for max security, especially with PII/HIPPA Data
$config['password'] 	= getenv('CACHE_REDIS_PASSWORD');
$config['port'] 		= getenv('CACHE_REDIS_PORT');
$config['timeout'] 		= getenv('CACHE_REDIS_TIMEOUT');

// Set a constant to be the default for the entire Application,
//	can be overridden per function call
//
// EXAMPLE:
//  	$this->cache->save('key, 'Some Value',CACHE_REDIS_KEY_TIMEOUT);
defined('REDIS_KEY_TIMEOUT')  or define('REDIS_KEY_TIMEOUT', getenv('CACHE_REDIS_KEY_TIMEOUT'));
