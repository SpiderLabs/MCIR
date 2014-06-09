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
<title>SQLol - SELECT query</title>
<link rel="stylesheet" type="text/css" href="../includes/mcir.css">
</head>
<body>
<center><h1>SQLol - SELECT query</h1></center><br>
<?php
include('includes/nav.inc.php');
include('../includes/options.inc.php');
?>

<tr><td>Injection Location:</td><td>
	<select name="location">
		<option value="where_string">String in WHERE clause</option>
		<option value="where_int" <?php if(isset($_REQUEST["location"]) and $_REQUEST["location"]=="where_int") echo "selected"; ?>>Integer in WHERE clause</option>
		<option value="entire_query" <?php if(isset($_REQUEST["location"]) and $_REQUEST["location"]=="entire_query") echo "selected"; ?>>Entire Query</option>
		<option value="column_name" <?php if(isset($_REQUEST["location"]) and $_REQUEST["location"]=="column_name") echo "selected"; ?>>Column Name</option>
		<option value="table_name" <?php if(isset($_REQUEST["location"]) and $_REQUEST["location"]=="table_name") echo "selected"; ?>>Table Name</option>
		<option value="order_by" <?php if(isset($_REQUEST["location"]) and $_REQUEST["location"]=="order_by") echo "selected"; ?>>ORDER BY clause</option>
		<option value="group_by" <?php if(isset($_REQUEST["location"]) and $_REQUEST["location"]=="group_by") echo "selected"; ?>>GROUP BY clause</option>
		<option value="having" <?php if(isset($_REQUEST["location"]) and $_REQUEST["location"]=="having") echo "selected"; ?>>HAVING clause</option>
	</select></td></tr>
	</table>
<input type="submit" id="submit" name="submit" value="Inject!">
</form>
<div id="results">

<?php
if(isset($_REQUEST['submit'])){ //Injection time!	
	include('../includes/environ.inc.php');
	include('../includes/sanitize.inc.php');

	if($_REQUEST['location'] == 'entire_query'){//If we're injecting an entire query (SQLi as a feature, seems unrealistic but I've seen it more than once) then let's not waste cycles building the query.
		
		$query = $_REQUEST['inject_string'];
		if(isset($_REQUEST['show_query']) and $_REQUEST['show_query']=='on') $displayquery = '<u>' . $_REQUEST['inject_string'] . '</u>';
		
	} else { //Otherwise, define all the parts of the query and replace only the portion we're injecting into.
		
		$display_column_name = $column_name = 'username';
		$display_table_name = $table_name = 'users';
		$display_where_clause = $where_clause = 'WHERE isadmin = 0';
		$display_group_by_clause = $group_by_clause = 'GROUP BY username';
		$display_order_by_clause = $order_by_clause = 'ORDER BY username ASC';
		$display_having_clause = $having_clause = 'HAVING 1 = 1';
	
		switch ($_REQUEST['location']){
			case 'column_name':
				$column_name = $_REQUEST['inject_string'];
				$display_column_name = '<u>' . $_REQUEST['inject_string'] . '</u>';
				break;
			case 'table_name':
				$table_name = $_REQUEST['inject_string'];
				$display_table_name = '<u>' . $_REQUEST['inject_string'] . '</u>';
				break;
			case 'where_string':
				$where_clause = "WHERE username = '" . $_REQUEST['inject_string'] . "'";
				$display_where_clause = "WHERE username = '" . '<u>' . $_REQUEST['inject_string'] . '</u>' . "'";
				break;
			case 'where_int':
				$where_clause = 'WHERE isadmin = ' . $_REQUEST['inject_string'];
				$display_where_clause = 'WHERE isadmin = ' . '<u>' . $_REQUEST['inject_string'] . '</u>';
				break;
			case 'group_by':
				$group_by_clause = 'GROUP BY ' . $_REQUEST['inject_string'];
				$display_group_by_clause = 'GROUP BY ' . '<u>' . $_REQUEST['inject_string'] . '</u>';
				break;
			case 'order_by':
				$order_by_clause = 'ORDER BY ' . $_REQUEST['inject_string'] . ' ASC';
				$display_order_by_clause = 'ORDER BY ' . '<u>' . $_REQUEST['inject_string'] . '</u>' . ' ASC';
				break;
			case 'having':
				$having_clause = 'HAVING isadmin = ' . $_REQUEST['inject_string'];
				$display_having_clause = 'HAVING isadmin = ' . '<u>' . $_REQUEST['inject_string'] . '</u>';
				break;
		}
		
		$query = "SELECT $column_name FROM $table_name $where_clause $group_by_clause $order_by_clause ";
		/*Probably a better way to create $displayquery...
		This allows me to underline the injection string
		in the resulting query that's displayed with the
		"Show Query" option without munging the query
		which hits the database.*/
		$displayquery = "SELECT $display_column_name FROM $display_table_name $display_where_clause $display_group_by_clause $display_order_by_clause ";
		
	}
	
	include('includes/database.inc.php');
	
}
?>
</div>
<?php include('../includes/mcir.nav.inc.php'); ?>
</body>
</html>
