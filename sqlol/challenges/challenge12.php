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
	<title>SQLol - Challenge 12 - XSSQLi</title>
<link rel="stylesheet" type="text/css" href="../../includes/mcir.css">
</head>
<body>
	<center><h1>SQLol - Challenge 12 - XSSQLi</h1></center><br>

	<hr width="40%">
	<hr width="60%">
	<hr width="40%">
<div id="challenge">
	
The contents of the database are usually considered to be trusted. Some mass attackers have taken advantage of this fact and launched mass SQL injection attacks which not only steal the contents of the database but which also place &lt;script&gt; tags pointing to malicious Javascript in all rows of the database in the hopes that they will be presented to users of the site.<br>
<br>
Your objective is to use an SQL injection flaw to execute a reflected cross-site scripting attack.

<pre>
PARAMETERS:
Query Type - SELECT query
Injection Type - String value in WHERE clause
Method - POST
Sanitization - None
Output - One row, verbose error messages, query not shown
</pre>

</div>
<form action="../select.php" method="post" name="challenge_form">
	<input type="hidden" name="query_results" value="one_row"/>
	<input type="hidden" name="error_level" value="verbose"/>
	<input type="hidden" name="show_query" value="off"/>
	<input type="hidden" name="location" value="where_string"/>
	Injection String: <input type="text" name="inject_string"/><br>
	<input type="submit" name="submit" value="Inject!"/>
</form>
<br>
</body>
</html>
