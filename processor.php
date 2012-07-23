<?php 
	require_once SITIO_PLUGIN_DIR . '/dishwasher.php';
	require_once SITIO_PLUGIN_DIR . '/zipcode.php';
	require_once SITIO_PLUGIN_DIR . '/calculator.php';
	require_once SITIO_PLUGIN_DIR . '/constants.php';
	
	function sitio_post( $atts )
	{	
		// Introductory calculations
		$zone = zoneChooser( $_POST["zipcode"] );
		runZoneCalculators( $zone );
		getCurrentRate( $_POST["zipcode"] );

		echo '<br/><br/>';
		
		// Modules for each appliance
		$usage = applianceChooser( $_POST["appliance"], $_POST[ $_POST["appliance"] . "Model"] );
	}

	// Determines which appliance you chose and preps that data
	function applianceChooser( $appliance, $model )
	{
		$usage = 0;
		if( $appliance == "dishwasher" )
		{
			echo '<h3>If you turn on your dishwasher now...</h3>';
			$usage = processDishwasher( $model );
		}
		return $usage;
	}
	
	// Determines which zone you live in and preps that data
	function zoneChooser( $zipcode )
	{
		$zone = processZipcode( $zipcode );
		return $zone;
	}
	
	// Runs your calculators
	function runZoneCalculators( $zone )
	{
		if( $zone = 1 ) // CAISO Zone
		{
			// Set to Pacific time
			date_default_timezone_set('America/Los_Angeles');
			calculateCaisoCarbon( date("H") );
		}
	}

	function getCurrentRate( $zipcode )
	{
		calculateCurrentRate( $zipcode );
	}
?>