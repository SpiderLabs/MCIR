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
	<title>XMLmao - XSL Injection Challenge 0 - Hello, world!</title>
<link rel="stylesheet" type="text/css" href="../../includes/mcir.css">
</head>
<body>
	<center><h1>XMLmao - XSL Injection Challenge 0 - Hello, world!</h1></center><br>

	<hr width="40%">
	<hr width="60%">
	<hr width="40%">
<div id="challenge">
	
You must perform the simplest of XSL injection attacks.<br>
<br>
Your objective is to retrieve passwords from the XML document.

<pre>
PARAMETERS:
Injection Type - Static content in output
Sanitization - None
Output - All results, verbose errors, xml shown
</pre>

</div>
<form action="../xslt.php" method="get" name="challenge_form">
      <input type="hidden" name="query&#95;results" value="all&#95;rows" />
      <input type="hidden" name="error&#95;level" value="verbose" />
      <input type="hidden" name="show&#95;query" value="on" />
      Injection String: <input type="text" name="inject&#95;string" value="" /><br>
      <input type="hidden" name="location" value="content" />
      <input type="submit" name="submit" value="Inject!"/>
</form>
<br>
</body>
</html>
