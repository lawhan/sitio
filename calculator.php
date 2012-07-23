<?php
	//Connect To Database
	$hostname='sitiodata.db.8678816.hostedresource.com';
	$username='sitiodata';
	$password='EVstati0n';
	$dbname='sitiodata';
	$usertable='zipcode';

	mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
	mysql_select_db($dbname);
	
	function calculateCaisoCarbon( $hour )
	{
		$hourPercentCarbon = 0.0;
		$hourPercentSolar = 0.0;
		$hourPercentWind = 0.0;
	
		$query = 'SELECT * FROM supplymix WHERE DATE_OF = CURDATE()-2';
		$result = mysql_query($query);
		if($result) {		
		while( $row = mysql_fetch_array($result) ){
			if( $row[ Constants::HOUR_ARRAYPOS ] == $hour  )
			{
				$hourPercentCarbon = hourPercentCarbon( $row );
				$hourPercentSolar = hourPercentSolar( $row );
				$hourPercentWind = hourPercentWind( $row );
			}
		}
		
		echo 'It is currently: ' . (date("D F d Y h:i:s a", time() )) . '<br/>';
		echo round($hourPercentCarbon, 2) . '% of the electricity is coming from carbon-free sources<br/>';
		echo round($hourPercentSolar, 2) . '% of the electricity is coming from solar<br/>';
		echo round($hourPercentWind, 2) . '% of the electricity is coming from wind<br/>';
		}
		else
		{
		echo "No data";
		}
	}
		
	function hourPercentCarbon( $row )
	{
		$hourNonCarbon =  $row[ 3 ] + $row[ 4 ] + $row[ 5 ] + $row[ 6 ] + $row[ 7 ] + $row[ 8 ] + $row[ 9 ] + $row[ 12 ];
		$total =  $row[ 3 ] + $row[ 4 ] + $row[ 5 ] + $row[ 6 ] + $row[ 7 ] + $row[ 8 ] + $row[ 9 ] 
				  + $row[ 10 ] + $row[ 12 ] + $row[ 12 ];
  	    return $hourNonCarbon/$total*100;
	}
	
	function hourPercentSolar( $row )
	{
		$hourSolar = $row[ Constants::SOLAR_ARRAYPOS ];
		$total =  $row[ 3 ] + $row[ 4 ] + $row[ 5 ] + $row[ 6 ] + $row[ 7 ] + $row[ 8 ] + $row[ 9 ] 
				  + $row[ 10 ] + $row[ 12 ] + $row[ 12 ];
		return $hourSolar/$total*100;
	}

	function hourPercentWind( $row )
	{
		$hourWind = $row[ Constants::WIND_ARRAYPOS ];
		$total =  $row[ 3 ] + $row[ 4 ] + $row[ 5 ] + $row[ 6 ] + $row[ 7 ] + $row[ 8 ] + $row[ 9 ] 
				  + $row[ 10 ] + $row[ 12 ] + $row[ 12 ];
		return $hourWind/$total*100;
	}	
	
	function calculateCurrentRate( $zipcode )
	{
		// Call Genability for the latest price
		$url = "http://api.genability.com/rest/public/tariffs?appId=9a8e8699-e784-4d56-85be-becf6163a560&appKey=2ba657c1-95f1-48a2-9d28-284be8b17dc5&customerClasses=RESIDENTIAL&tariffTypes=DEFAULT&zipCode=" . $zipcode;
		$json = file_get_contents($url);
		$jsonArray = json_decode($json, TRUE);
		
		$masterTariffId = $jsonArray['results'][0]['masterTariffId'];
		// Find master tariff schedule and assume 1000 kWh per month consumption
		$url = "http://api.genability.com/rest/public/prices/" . $masterTariffId . 
			   "?appId=9a8e8699-e784-4d56-85be-becf6163a560&appKey=2ba657c1-95f1-48a2-9d28-284be8b17dc5&consumptionAmount=1000";
		$jsonTariff = file_get_contents($url);
		$jsonTariffArray = json_decode($jsonTariff, TRUE);
		
		// Find which is the highest price for this average level of consumption
		$maxTariff = 0.0;
		foreach ($jsonTariffArray['results'] as &$tariff) {
			if ( $tariff['rateAmount'] > maxTariff )
			{
				$maxTariff = $tariff['rateAmount'];
			}
		}
		echo "You are currently paying " . round( $maxTariff * 100, 2 ) . " cents per kWh.";
	}
?>