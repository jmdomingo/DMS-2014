<?php

function getPage($stmt, $pageNum, $rowsPerPage) {
	$offset = ($pageNum - 1) * $rowsPerPage;
	$rows = array();
	$i = 0;
	while(($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC, SQLSRV_SCROLL_ABSOLUTE, $offset + $i)) && $i < $rowsPerPage) {
		array_push($rows, $row);
		$i++;
	}
	return $rows;
}
?>