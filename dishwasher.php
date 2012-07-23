<?php
	function processDishwasher( $model )
	{
		$usage = 0;
		if( $model == 1 )
		{
			$usage = 1.34;
		}
		else if ( $model == 2 )
		{
			$usage = 1.79;
		}
		return $usage;
	}
?>