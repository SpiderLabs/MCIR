<?php
/*
Magical Code Injection Rainbow - A set of configurable injection testbeds 
Daniel "unicornFurnace" Crowley
Copyright (C) 2014 Trustwave Holdings, Inc.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.
*/
?>
<html>
<head>
<title>SQLol - INSERT query</title>
<link rel="stylesheet" type="text/css" href="../includes/mcir.css">
</head>
<body>
<center><h1>SQLol - INSERT query</h1></center><br>
<?php
include('includes/nav.inc.php');
include('../includes/options.inc.php');
?>

<tr><td>Injection Location:</td><td>
	<select name="location">
		<option value="string_value">Value (string)</option>
		<option value="int_value" <?php if(isset($_REQUEST["location"]) and $_REQUEST["location"]=="int_value") echo "selected"; ?>>Value (int)</option>
		<option value="column_name" <?php if(isset($_REQUEST["location"]) and $_REQUEST["location"]=="column_name") echo "selected"; ?>>Column Name</option>
		<option value="table_name" <?php if(isset($_REQUEST["location"]) and $_REQUEST["location"]=="table_name") echo "selected"; ?>>Table Name</option>
	</select></td></tr></table>
	
<input type="submit" id="submit" name="submit" value="Inject!">
</form>
<div id="results">

<?php
if(isset($_REQUEST['submit'])){ //Injection time!
		
	include('../includes/environ.inc.php');		
	include('../includes/sanitize.inc.php');	
		
	$display_column_name = $column_name = 'username, isadmin';
	$display_table_name = $table_name = 'users';
	$display_string_value = $string_value = 'haxotron9000';
	$display_int_value = $int_value = '0';

	switch ($_REQUEST['location']){ //Rewrite the appropriate variable for the injection location
		case 'column_name':
			$column_name = $_REQUEST['inject_string'] . ', isadmin';
			$display_column_name = '<u>' . $_REQUEST['inject_string'] . '</u>' . ', isadmin';
			break;
		case 'table_name':
			$table_name = $_REQUEST['inject_string'];
			$display_table_name = '<u>' . $_REQUEST['inject_string'] . '</u>';
			break;
		case 'string_value':
			$string_value = $_REQUEST['inject_string'];
			$display_string_value = '<u>' . $_REQUEST['inject_string'] . '</u>';
			break;
		case 'int_value':
			$int_value = $_REQUEST['inject_string'];
			$display_int_value = '<u>' . $_REQUEST['inject_string'] . '</u>';
			break;
	}
	
	$query = "INSERT INTO $table_name ($column_name) VALUES ('$string_value', $int_value)";
	$displayquery = "INSERT INTO $display_table_name ($display_column_name) VALUES ('$display_string_value', $display_int_value)";
	
	include('includes/database.inc.php');

}
?>

</div>
<?php include('../includes/mcir.nav.inc.php'); ?>
</body>
</html>
