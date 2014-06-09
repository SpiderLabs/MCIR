<?php
/*
Magical Code Injection Rainbow - A set of configurable injection testbeds 
Daniel "unicornFurnace" Crowley
Copyright (C) 2014 Trustwave Holdings, Inc.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

include_once('../includes/branding.php');
//TODO: Update page name
$mcir['page_name'] = 'Challenge 0 - The first challenge';
?>

<html>
<head>
	<title><?php echo $mcir['name'].' - '.$mcir['page_name']?></title>
<link rel="stylesheet" type="text/css" href="../../includes/mcir.css">
</head>
<body>
	<center><h1><?php echo $mcir['name'].' - '.$mcir['page_name']?></h1></center><br>

	<hr width="40%">
	<hr width="60%">
	<hr width="40%">
<div id="challenge">
	
<!--TODO: Describe challenge setup and objective -->
Lorem ipsum lolcats foobar<br>
<br>
Your objective is to gain psychic control of a common housecat using only a tin can, a piece of cheese and weapons-grade bromium.

<pre>
PARAMETERS:
Injection Location - Command argument
Method - GET
Sanitization - None
Output - output shown, error status disclosed, command shown
</pre>

</div>
<!--TODO: point form at target page, set options appropriately for challenge -->
<form action="../friend.php" method="get" name="challenge_form">
        <input type="hidden" name="query_results" value="all_rows"/>
        <input type="hidden" name="error_level" value="verbose"/>
        <input type="hidden" name="show_query" value="on"/>
	<input type="hidden" name="location" value="argument"/>
	Injection String: <input type="text" name="inject_string"/><br>
	<input type="submit" name="submit" value="Inject!"/>
</form>
<br>
</body>
</html>
