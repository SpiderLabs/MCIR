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
<title>SQLol - UPDATE query</title>
<link rel="stylesheet" type="text/css" href="../includes/mcir.css">
</head>
<body>
<center><h1>SQLol - UPDATE query</h1></center><br>
<?php
include('includes/nav.inc.php');
include('../includes/options.inc.php');
?>

<tr><td>Injection Location:</td><td>
	<select name="location">
		<option value="where_string">String in WHERE clause</option>
		<option value="where_int" <?php if(isset($_REQUEST["location"]) and $_REQUEST["location"]=="where_int") echo "selected"; ?>>Integer in WHERE Clause</option>
		<option value="column_name" <?php if(isset($_REQUEST["location"]) and $_REQUEST["location"]=="column_name") echo "selected"; ?>>Column Name</option>
		<option value="table_name" <?php if(isset($_REQUEST["location"]) and $_REQUEST["location"]=="table_name") echo "selected"; ?>>Table Name</option>
		<option value="value" <?php if(isset($_REQUEST["location"]) and $_REQUEST["location"]=="value") echo "selected"; ?>>Value to write</option>
	</select></td></tr>
	</table>
<input type="submit" id="submit" name="submit" value="Inject!">
</form>
<div id="results">

<?php
if(isset($_REQUEST['submit'])){ //Injection time!
	
	include('../includes/environ.inc.php');
	include('../includes/sanitize.inc.php');
	
	$display_column_name = $column_name = 'username';
	$display_table_name = $table_name = 'users';
	$display_value = $value = 'haxotron9000';
	$display_where_clause = $where_clause = 'WHERE isadmin = 0';

	switch ($_REQUEST['location']){
		case 'column_name':
			$column_name = $_REQUEST['inject_string'];
			$display_column_name = '<u>' . $_REQUEST['inject_string'] . '</u>';
			break;
		case 'table_name':
			$table_name = $_REQUEST['inject_string'];
			$display_table_name = '<u>' . $_REQUEST['inject_string'] . '</u>';
			break;
		case 'value':
			$value = $_REQUEST['inject_string'];
			$display_value = '<u>' . $_REQUEST['inject_string'] . '</u>';
			break;
		case 'where_string':
			$where_clause = "WHERE username = '" . $_REQUEST['inject_string'] . "'";
			$display_where_clause = "WHERE username = '" . '<u>' . $_REQUEST['inject_string'] . '</u>' . "'";
			break;
		case 'where_int':
			$where_clause = 'WHERE isadmin = ' . $_REQUEST['inject_string'];
			$display_where_clause = 'WHERE isadmin = ' . '<u>' . $_REQUEST['inject_string'] . '</u>';
			break;
	}
	
	$query = "UPDATE $table_name SET $column_name = '$value' $where_clause";
	$displayquery = "UPDATE $display_table_name SET $display_column_name = '$display_value' $display_where_clause";

	include('includes/database.inc.php');

}
?>

</div>
<?php include('../includes/mcir.nav.inc.php'); ?>
</body>
</html>
