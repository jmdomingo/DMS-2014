<?php
	class Query{
		function searchIfExist($table, $code, $columnName){
			include("include/dbcon.php");
			$query = "
				SELECT *
				FROM " . $table . "
				WHERE " . $columnName . " = ?
			";
			$exist = sqlsrv_query( $Conn, $query, array($code));
			$exist = sqlsrv_has_rows($exist);
			return $exist;
		}
	}
?>