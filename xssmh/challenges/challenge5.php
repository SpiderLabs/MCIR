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
	<title>XSSmh - Challenge 5 - Detour</title>
<link rel="stylesheet" type="text/css" href="../../includes/mcir.css">
</head>
<body>
	<center><h1>XSSmh - Challenge 5 - Detour</h1></center><br>

	<hr width="40%">
	<hr width="60%">
	<hr width="40%">
<div id="challenge">
	
A page with a password submission form is vulnerable to XSS.<br>
<br>
Your objective is to change the action of the resulting form to point to a different location so that the password is not submitted to the normal place.<br>
(Note: Some browsers have anti-XSS protections which prevent this from working. Try using Firefox, Safari, or old versions of Internet Explorer.)

<pre>
PARAMETERS:
Injection Type - Injection into HTML body
Sanitization - None
</pre>

</div>
<form action="../xss.php" method="get" name="challenge_form">
	<input type="hidden" name="custom_inject" value="<form action=&quot;xss.php&quot; name=&quot;xssform&quot;>Enter password:<input type=&quot;password&quot; name=&quot;password&quot; /><input type=&quot;submit&quot; /></form>*INJECT*" />
	Injection String: <input type="text" name="inject_string"/><br>
	<input type="submit" name="submit" value="Inject!"/>
</form>
<br>
</body>
</html>
