<?php
	function getRegionName($RegionCode) {
		include("dbcon.php");

		$Query = sqlsrv_query($Conn, "SELECT region_name FROM lib_regions WHERE region_code=?",
								array(&$RegionCode) );
								
		sqlsrv_fetch( $Query );
		
		$RegionName = sqlsrv_get_field( $Query, 0 );
		
		sqlsrv_close( $Conn );
		
		return $RegionName;
	}
?>