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
	<title>SQLol - Challenge 2 - The Failure of Quote Filters</title>
<link rel="stylesheet" type="text/css" href="../../includes/mcir.css">
</head>
<body>
	<center><h1>SQLol - Challenge 2 - The Failure of Quote Filters</h1></center><br>

	<hr width="40%">
	<hr width="60%">
	<hr width="40%">
<div id="challenge">
	
Many people sanitize or remove single quotes in their Web applications to prevent SQL injection attacks. While this can be effective against injection into string parameters, it is ineffective at preventing injection into parameters which are not quote delimited, like integers or datetime values. This places restrictions on how your injection string can be written, but does not present much of an obstacle to an attacker.<br>
<br>
Your objective is to find the table of social security numbers present in the database and extract its information.

<pre>
PARAMETERS:
Query Type - SELECT query
Injection Type - Integer value in WHERE clause
Method - GET
Sanitization - Single quotes removed
Output - All results, verbose error messages, query shown
</pre>

</div>
<form action="../select.php" method="get" name="challenge_form">
	<input type="hidden" name="sanitization_level" value="high"/>
	<input type="hidden" name="sanitization_params" value="'">
	<input type="hidden" name="sanitization_type" value="keyword">
	<input type="hidden" name="query_results" value="all_rows"/>
	<input type="hidden" name="error_level" value="verbose"/>
	<input type="hidden" name="show_query" value="on"/>
	<input type="hidden" name="location" value="where_int"/>
	Injection String: <input type="text" name="inject_string"/><br>
	<input type="submit" name="submit" value="Inject!"/>
</form>
<br>
</body>
</html>
