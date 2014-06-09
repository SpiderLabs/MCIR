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
	<title>XSSmh - Challenge 7 - Crouching JS, Hidden Field</title>
<link rel="stylesheet" type="text/css" href="../../includes/mcir.css">
</head>
<body>
	<center><h1>XSSmh - Challenge 7 - Crouching JS, Hidden Field</h1></center><br>

	<hr width="40%">
	<hr width="60%">
	<hr width="40%">
<div id="challenge">
	
In this challenge, you are injecting into a hidden input field and cannot break out of the tag.
<br>
Your objective is to cause an alert box to pop up on the resulting page.<br>
(Note: Some browsers have anti-XSS protections which prevent this from working. Try using Firefox, Safari, or old versions of Internet Explorer.)

<pre>
PARAMETERS:
Injection Type - Custom, value attribute of hidden input field
Sanitization - No right angle bracket (&gt;)
</pre>

</div>
<form action="../xss.php" method="get" name="challenge_form">
	Injection String: <input type="text" name="inject_string"/><br>
      <input type="hidden" name="custom&#95;inject" value="&lt;form&gt;&#13;&#10;&lt;input&#32;&#32;value&#61;&quot;&#42;INJECT&#42;&quot;&#32;type&#61;&quot;hidden&quot;&#32;&#47;&gt;&#13;&#10;&lt;&#47;form&gt;" />
      <input type="hidden" name="sanitization&#95;level" value="reject_high" />
      <input type="hidden" name="sanitization&#95;params" value="&gt;" />
      <input type="hidden" name="sanitization&#95;type" value="keyword" />
	<input type="submit" name="submit" value="Inject!"/>
</form>
<br>
</body>
</html>
