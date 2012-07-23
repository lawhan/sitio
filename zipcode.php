<?php
	//Connect To Database
	$hostname='sitiodata.db.8678816.hostedresource.com';
	$username='sitiodata';
	$password='EVstati0n';
	$dbname='sitiodata';
	$usertable='zipcode';

	mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
	mysql_select_db($dbname);
	
	function processZipcode( $zipcode )
	{
		$query = 'SELECT * FROM zipcode WHERE ID_ZIPCODE = ' . $zipcode;
		$result = mysql_query($query);
		if($result) {
		while( $row = mysql_fetch_array($result) ){
			$name = $row[ 'ID_ZONE' ];
		}
		}
		return $name;
	}
?>