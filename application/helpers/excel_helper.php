<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @param $model
 * @return string
 * get success url to redirect for specific model's import
 */
function get_success_url($model): string
{
	$url = "";
	switch ($model) {
		case "Model_glasses":
			$url = 'appmgr/glasses/glasses_list';
			break;
	}
	return $url;
}

/**
 * @param $model
 * @return string
 * get error url to redirect for specific model's import
 */
function get_error_url($model): string
{
	$url = "";
	switch ($model) {
		case "Model_glasses":
			$url = 'appmgr/glasses/import_excel';
			break;
	}
	return $url;
}

/**
 * @param $model
 * @return string|string[][]
 * get columns with related types for a specific model
 */
function get_columns($model)
{
	$columns = "";
	switch ($model) {
		case "Model_glasses":
			$columns =  array(array("name" => "glasses_id", "type" => "integer"), array("name" => "lens_style", "type" => "string"), array("name" => "lens_design", "type" => "string"), array("name" => "design_msrp", "type" => "numeric"), array("name" => "lens_material", "type" => "string"), array("name" => "material_msrp", "type" => "numeric"), array("name" => "lens_type", "type" => "string"), array("name" => "type_msrp", "type" => "numeric"), array("name" => "lens_color", "type" => "string"), array("name" => "color_msrp", "type" => "numeric"));
    break;
	}
	return $columns;
}

/**
 * @param $type
 * @param $value
 * @return bool
 * check whether the type and value of a certain column matches or not
 */
function match_type($type, $value)
{
	$matched = false;
	switch ($type) {
		case "integer":
			$matched = is_null($value) || is_int($value);
			break;
		case "string":
			$matched = is_null($value) || is_string($value);
			break;
		case "numeric":
			$matched = is_null($value) || is_numeric($value);
			break;
	}
	return $matched;
}

/**
 * @param $model
 * @return array
 * get table details against model
 */
function get_table_details($model)
{
	$details = array();
	switch ($model) {
		case "Model_glasses":
			$details['name'] = "glasses";
			$details['key'] = "glasses_id";
			$details['verify_ids'] = array(array("verify" => "glasses_id", "from" => "glasses", "with" => "glasses_id"));
			$details['verify_names'] = array(array("verify" => "lens_style", "from" => "lens_styles", "with" => "lens_style", "get" => "lensstyle_id"));
			$details['update_date'] = 'updated_at';
			break;
	}
	return $details;
}

/**
 * @param $model
 * @param $error
 * @return mixed
 * get excel import results
 */
function get_excel_imports($model, $error)
{
	$ci =& get_instance();
	$ci->load->database();
	return $ci->db->select('excel_imports.*')->where('excel_imports.user_id', $_SESSION['user_id'])->where('excel_imports.model', $model)->where('excel_imports.error', $error)->limit($_SESSION['lastImportExceptions'])->order_by('imported_at', 'DESC')->get('excel_imports');
}

