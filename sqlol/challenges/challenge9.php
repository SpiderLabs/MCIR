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
	<title>SQLol - Challenge 9 - Administrative Tasks</title>
<link rel="stylesheet" type="text/css" href="../../includes/mcir.css">
</head>
<body>
	<center><h1>SQLol - Challenge 9 - Administrative Tasks</h1></center><br>

	<hr width="40%">
	<hr width="60%">
	<hr width="40%">
<div id="challenge">
	
In this challenge, you are working with an UPDATE query. The query updates the field "username" in the "users" table for a given user.<br>
<br>
Your objective is to inject into the query and cause it to update the "isadmin" field to 1 for the user with id 3.

<pre>
PARAMETERS:
Query Type - UPDATE query
Injection Type - Value to be written
Method - POST
Sanitization - None
Output - Generic error messages, query shown
</pre>

</div>
<form action="../update.php" method="post" name="challenge_form">
	<input type="hidden" name="query_results" value="none"/>
	<input type="hidden" name="error_level" value="errors"/>
	<input type="hidden" name="show_query" value="on"/>
	<input type="hidden" name="location" value="value"/>
	Injection String: <input type="text" name="inject_string"/><br>
	<input type="submit" name="submit" value="Inject!"/>
</form>
<br>
</body>
</html>
