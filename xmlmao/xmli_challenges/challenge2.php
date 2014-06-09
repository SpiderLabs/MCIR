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
	<title>XMLmao - XML Injection Challenge 2 - Anti-Anti-XSS</title>
<link rel="stylesheet" type="text/css" href="../../includes/mcir.css">
</head>
<body>
	<center><h1>XMLmao - XML Injection Challenge 2 - Anti-Anti-XSS</h1></center><br>

	<hr width="40%">
	<hr width="60%">
	<hr width="40%">
<div id="challenge">
	
Browser-based anti-XSS measures involve comparing input to output. If inputs contain scripting and are used as part of a script in the resulting response, the script is not executed. If you can break the comparison, you can defeat the anti-XSS measures.<br>
<br>
Your objective is to use XML injection to perform cross-site scripting which bypasses browser anti-XSS measures.<br>
(Note: Firefox [without NoScript], Safari, and old versions of IE do not have anti-XSS protections. Try using a browser which has anti-XSS measures, like Chrome.)

<pre>
PARAMETERS:
Injection Type - CDATA-wrapped value
Sanitization - None
Output - All results, verbose errors, xml shown
</pre>

</div>
<form action="../xmlinjection.php" method="get" name="challenge_form">
	<input type="hidden" name="query_results" value="all_rows"/>
	<input type="hidden" name="show_query" value="on"/>
	<input type="hidden" name="location" value="cdatavalue"/>
	<input type="hidden" name="error_level" value="verbose"/>
	Injection String: <input type="text" name="inject_string"/><br>
	<input type="submit" name="submit" value="Inject!"/>
</form>
<br>
</body>
</html>
