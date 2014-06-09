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
	<title>XSSmh - Challenge 0 - alert("Hello, world!");</title>
<link rel="stylesheet" type="text/css" href="../../includes/mcir.css">
</head>
<body>
	<center><h1>XSSmh - Challenge 0 - alert("Hello, world!");</h1></center><br>

	<hr width="40%">
	<hr width="60%">
	<hr width="40%">
<div id="challenge">
	
You must perform the simplest of XSS attacks.<br>
<br>
Your objective is to cause an alert box to pop up on the resulting page.<br>
(Note: Some browsers have anti-XSS protections which prevent this from working. Try using Firefox, Safari, or old versions of Internet Explorer.)

<pre>
PARAMETERS:
Injection Type - Injection into HTML body
Sanitization - None
</pre>

</div>
<form action="../xss.php" method="get" name="challenge_form">
	<input type="hidden" name="location" value="body"/>
	Injection String: <input type="text" name="inject_string"/><br>
	<input type="submit" name="submit" value="Inject!"/>
</form>
<br>
</body>
</html>
