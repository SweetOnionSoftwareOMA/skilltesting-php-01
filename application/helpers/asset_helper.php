<?php
defined('BASEPATH') or exit('No direct script access allowed');


if ( ! function_exists('asset_url()')) {

	/**
	 *  Helper that generates all the html tags for all preload content required across the entire
	 *   application
	 *
	 * @return string  HTML TAGS
	 */
	function asset_preloader($type = 'all'){

		$stuff = config_item('assets_preloadCDN');

		if (count($stuff) <= 0) return false;
		$return_sting = null;

		$allowed_files = array();

		//Page based CSS / JS Implementation
		$CI =& get_instance();
		$controller = $CI->router->fetch_class();

		if ($controller == 'login') {
			$allowed_files = array('googlefont', 'fontawesome', 'bootstrap', 'admin', 'googlefont');
		}

		$method = (($CI->router->fetch_method() == 'index') ? '' : $CI->router->fetch_method() );
		$raw_file = $controller.(($method) ? '-'.$method : '' );
		$custom_file = str_replace(array('_', 'session-timedout'), array('-', 'login'), $raw_file);

		echo '<!--'.$custom_file.'-->';

		if (file_exists(FCPATH.'assets/dist/css/pages/'.$custom_file.'.css'))
			$stuff[$custom_file.':css']= 'assets/dist/css/pages/'.$custom_file.'.css';

		if (file_exists(FCPATH.'assets/dist/js/pages/'.$custom_file.'.js'))
			$stuff[$custom_file.':js'] = 'assets/dist/js/pages/'.$custom_file.'.js';

		foreach ($stuff as $key => $va) {

			list($name, $media_type) = explode(":", $key);
			if (startsWith($va, 'http')) {
				$url = null  ;
			} else {
				$url = media_url($media_type);
			}
			// echo '<!--' . $name . '-->';
			if ($type != 'all' && $type != $media_type) {
				continue;
			}

			switch ($media_type) {
				case 'js':
					$content =  '<script type="text/javascript" src="' .$url .$va .'"></script>'."\n\r\t";
					break;

				case 'css':
					$content =  '<link rel="stylesheet" href="' .$url .$va .'">'."\n\r\t";
					break;

				case 'video':
					$content =  '<script src="' .$url .$va .'"></script>';
					break;

				case 'image':
					$content =  '<script src="' .$url .$va .'"></script>';
					break;

				default:
					$content = '<-- typeNotCorrect: ' .$key .' -->';

			}
			$return_sting .= $content;
		}

		return $return_sting;

	}

	/**
	 *  Provides a uniform function for implementing asset offloading and CDN caching
	 *
	 * @return string
	 */
	function asset_url() {

		if (config_item('assets_cloudfrontURL') != '')
			{return config_item('assets_assetURL');}

		if (config_item('assets_assetURL') != '') {
			return config_item('assets_assetURL');
		}
		$r = base_url();
		return $r;

	}

	function startsWith($string, $startString)
	{
		$len = strlen($startString);
		return (substr($string, 0, $len) === $startString);
	}


	/**
	 * Provides a uniform function to override the asset_url by medium type.
	 *
	 * Asset hosting and caching can vary based on the medium/type, this function
	 * permits the usage of varying urls and folder locations to provide extensible options
	 * for hosting and migration of older projects
	 *
	 * @param string $media_type eg. js, css, video, image
	 *
	 * @return string eg http://xxxxx
	 */
	function media_url($media_type = null) {
		$base = null;

		switch ($media_type) {
			case 'js':
				$base = config_item('assets_jsURL');
				break;

			case 'css':
				$base = config_item('assets_cssURL');
				break;

			case 'video':
				$base = config_item('assets_videoURL');
				break;

			case 'image':
				$base = config_item('assets_imageURL');
				break;

			default:
				return asset_url();
		}
		if ($base == null) {
			return asset_url();
		}
		else {
			return $base;
		}
	}
}

/**
 *  returns a URL for given asset based on the configured asset URL
 *
 * @param string $media_type  (js, css, video, image)
 *
 * @param string $asset_path (relative path and filename)
 *
 * @return string
 */
function site_media(string $media_type, string $asset_path)
{
	// Check if it starts with a /, and remove if needed
	if (substr($asset_path, 0, 1) == '/')
	{
		$asset_path = substr($asset_path, 1);
	}
	return media_url($media_type) .$asset_path;
}
