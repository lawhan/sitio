<?php
function sitio_init( $atts ){
?>
	<script type="text/javascript">
	// Begin Javascript
		function showModels(){
			var appliance=document.getElementById("appliance").value;
			document.getElementById('ovenDropdown').style.display = 'none'; 
			document.getElementById('dishwasherDropdown').style.display = 'none'; 
			
			if (appliance == "dishwasher")
			{
				document.getElementById('dishwasherDropdown').style.display = 'inline';
			}
			else if (appliance == "oven")
			{
				document.getElementById('ovenDropdown').style.display = 'inline';
			}
		}
	</script>
	
	<form method="post" action="/results" >
	
	Appliance: <select id="appliance" name="appliance" onchange="showModels()">
		<option value=""></option>
		<option value="dishwasher">Dishwasher</option>
		<option value="oven">Oven</option>
		<option value="dryer">Dryer</option>
		<option value="washer">Clothes Washer</option>
	</select><br />
	
	<div id="dishwasherDropdown"  style="display:none;"> 
	Dishwasher: <select id="dishwasherModel" name="dishwasherModel">
		<option value="1">EnergyStar</option>
		<option value="2">Standard</option>
	</select><br />
	</div>

	<div id="ovenDropdown"  style="display:none;"> 
	Oven: <select id="ovenModel" name="ovenModel">
		<option value="1">EnergyStar</option>
		<option value="2">Standard</option>
	</select><br />
	</div>
	
	Zip Code: <input type="text" name="zipcode" /><br />
	<br />
	
	<input type="submit" value="submit" name="submit">
	</form>

	
<?php
}
?>