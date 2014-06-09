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
$mcir['page_name'] = 'Challenge 0 - http://hello.com/world.php';
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
	
In this challenge, you must perform a basic remote file inclusion attack and show the phpinfo() page.<br>
<br>


<pre>
PARAMETERS:
Injection Location - Entire URI
Method - GET
Sanitization - None
Output - output shown, error status disclosed, command shown
</pre>

</div>
<form action="../include.php" method="get" name="challenge_form">
        <input type="hidden" name="query_results" value="all_rows"/>
        <input type="hidden" name="error_level" value="verbose"/>
        <input type="hidden" name="show_query" value="on"/>
        <input type="hidden" name="allow_remote" value="on"/>
	<input type="hidden" name="custom_inject" value="*INJECT*"/>
	Injection String: <input type="text" name="inject_string"/><br>
	<input type="submit" name="submit" value="Inject!"/>
</form>
<br>
</body>
</html>
