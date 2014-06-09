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
	<title>SQLol - Challenge 13 - LIKE OMG</title>
<link rel="stylesheet" type="text/css" href="../../includes/mcir.css">
</head>
<body>
	<center><h1>SQLol - Challenge 13 - LIKE OMG</h1></center><br>

	<hr width="40%">
	<hr width="60%">
	<hr width="40%">
<div id="challenge">
	
The LIKE keyword operates similarly to the equality operator "=" in SQL databases. The difference is that wildcards are allowed. In this challenge, a developer has used the "LIKE" keyword instead of the equality operator.<br>
<br>
Your objective is to retrieve all usernames from the database.

<pre>
PARAMETERS:
Query Type - SELECT query
Injection Type - String value in WHERE clause
Method - POST
Sanitization - Single quotes removed
Output - Boolean, query not shown
</pre>

</div>
<form action="../custom.php" method="post" name="challenge_form">
	<input type="hidden" name="query_results" value="bool"/>
	<input type="hidden" name="sanitization_params" value="'"/>
	<input type="hidden" name="sanitization_type" value="keyword"/>
	<input type="hidden" name="sanitization_level" value="reject_high"/>
	<input type="hidden" name="error_level" value="none"/>
	<input type="hidden" name="show_query" value="off"/>
	<input type="hidden" name="location" value="select username from users where username LIKE '*INJECT*'"/>
	Injection String: <input type="text" name="inject_string"/><br>
	<input type="submit" name="submit" value="Inject!"/>
</form>
<br>
</body>
</html>
