<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 *  Converts a query result from a dimensional array to a single value array
 *
 * @param \CODEIGNITER\MODEL::Result $results
 * @param string $col Column Name to flatten
 *
 * @return array
 *
 */

function query_column_to_array($results, $col)
{
	// Check for no query results
	if (count($results) <= 0) {
		return [];
	}

    $arr = array();
    foreach ($results as $r) {
        array_push($arr,  $r->$col);
    }
    return $arr;
}


function asIDArray($query, $idField)
{

	$result_set = Array();

	foreach ($query->result_array() as $row)
	{
		$result_set[$row[$idField]] = $row;

	}

	return $result_set;
}
