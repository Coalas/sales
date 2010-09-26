<?php
  /* MySQL connection */
	/* Database connection information */
	$gaSql['user']       = "root";
	$gaSql['password']   = "Laguna";
	$gaSql['db']         = "mailing";
	$gaSql['server']     = "localhost";
	
	$gaSql['link'] =  mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or
		die( 'Could not open connection to server' );
	
	mysql_select_db( $gaSql['db'], $gaSql['link'] ) or 
		die( 'Could not select database '. $gaSql['db'] );
	
	/* Paging */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
			mysql_real_escape_string( $_GET['iDisplayLength'] );
	}
	
	/* Ordering */
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<mysql_real_escape_string( $_GET['iSortingCols'] ) ; $i++ )
		{
			$sOrder .= fnColumnToField(mysql_real_escape_string( $_GET['iSortCol_'.$i] ))."
			 	".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
		}
		$sOrder = substr_replace( $sOrder, "", -2 );
	}
	
	/* Filtering - NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
	$sWhere = "";
	if ( $_GET['sSearch'] != "" )
	{
		$sWhere = "WHERE name LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ".
		                "city LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ".
		                "tel LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ".
		                "email LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ".
		                "www LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%'";
	}
	
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS idhouses, name, city, tel, email, www
		FROM   houses
		$sWhere
		$sOrder
		$sLimit
	";
	$rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	$sQuery = "
		SELECT COUNT(idhouses)
		FROM   houses
	";
	$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	$aResultTotal = mysql_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];
	
	$sOutput = '{';
	$sOutput .= '"sEcho": '.intval($_GET['sEcho']).', ';
	$sOutput .= '"iTotalRecords": '.$iTotal.', ';
	$sOutput .= '"iTotalDisplayRecords": '.$iFilteredTotal.', ';
	$sOutput .= '"aaData": [ ';
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		$sOutput .= "[";
		$sOutput .= '"'.str_replace('"', '\"', $aRow['idhouses']).'",';
		$sOutput .= '"'.str_replace('"', '\"', $aRow['name']).'",';
		$sOutput .= '"'.str_replace('"', '\"', $aRow['city']).'",';
		$sOutput .= '"'.str_replace('"', '\"', $aRow['tel']).'",';
		if ( $aRow['email'] == "0" )
			$sOutput .= '"-",';
		else
			$sOutput .= '"'.str_replace('"', '\"', $aRow['email']).'",';
		$sOutput .= '"'.str_replace('"', '\"', $aRow['www']).'"';
		$sOutput .= "],";
	}
	$sOutput = substr_replace( $sOutput, "", -1 );
	$sOutput .= '] }';
	
	echo $sOutput;
	
	
	function fnColumnToField( $i )
	{
		if ( $i == 0 )
			return "name";
		else if ( $i == 1 )
			return "city";
		else if ( $i == 2 )
			return "tel";
		else if ( $i == 3 )
			return "email";
		else if ( $i == 4 )
			return "www";
	}
?>