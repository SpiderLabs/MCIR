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
	<title>XMLmao - XML Injection Challenge 5 - XInclude</title>
<link rel="stylesheet" type="text/css" href="../../includes/mcir.css">
</head>
<body>
	<center><h1>XMLmao - XML Injection Challenge 5 - XInclude</h1></center><br>

	<hr width="40%">
	<hr width="60%">
	<hr width="40%">
<div id="challenge">
	
XInclude is a way of merging XML documents or creating dynamic XML content by including external content.
<br>
Your objective is to read /etc/passwd or c:\boot.ini using XInclude.

<pre>
PARAMETERS:
Injection Type - CDATA-wrapped value
Sanitization - None
Output - Full results, verbose errors
</pre>

</div>
<form action="../xmlinjection.php" method="get" name="challenge_form">
      <input type="hidden" name="location" value="cdatavalue" />
      <input type="hidden" name="query&#95;results" value="all_rows" />
      <input type="hidden" name="error&#95;level" value="verbose" />
      <input type="hidden" name="xinclude" value="on" />
	Injection String: <input type="text" name="inject_string"/><br>
	<input type="submit" name="submit" value="Inject!"/>
</form>
<br>
</body>
</html>
