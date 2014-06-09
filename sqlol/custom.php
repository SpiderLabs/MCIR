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
<title>SQLol - Custom query</title>
<link rel="stylesheet" type="text/css" href="../includes/mcir.css">
</head>
<body>
<center><h1>SQLol - Custom query</h1></center><br>
<?php
include('includes/nav.inc.php');
include('../includes/options.inc.php');
?>

<tr><td>Original Query (*INJECT* specifies injection point):</td><td><textarea name="location"><?php if(isset($_REQUEST["location"])) echo htmlentities($_REQUEST["location"]); ?></textarea></td></tr>
	</table>
<input type="submit" id="submit" name="submit" value="Inject!">
</form>
<div id="results">

<?php
if(isset($_REQUEST['submit'])){ //Injection time!	
	
	include('../includes/environ.inc.php'); //Simulate app failure and/or net latency if requested
	include('../includes/sanitize.inc.php'); //Sanitize input as requested
	
	//Build the query
	$query = str_replace('*INJECT*', $_REQUEST['inject_string'], $_REQUEST['location']);
	$displayquery = str_replace('*INJECT*', '<u>' . $_REQUEST['inject_string'] . '</u>', $_REQUEST['location']);
	
	include('includes/database.inc.php');
	
}
?>
</div>
<?php include('../includes/mcir.nav.inc.php'); ?>
</body>
</html>
