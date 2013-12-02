<?php
/*
CryptOMG - A configurable CTF style test bed.
Andrew Jordan
Copyright (C) 2012 Trustwave Holdings, Inc.

This program is free software: you can redistribute it and/or modify it 
under the terms of the GNU General Public License as published by the 
Free Software Foundation, either version 3 of the License, or (at your 
option) any later version.

This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of 
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General 
Public License for more details.

You should have received a copy of the GNU General Public License along 
with this program. If not, see <http://www.gnu.org/licenses/>.
*/

include "db.php";
if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])){
	$username = htmlentities($_POST['username']);
	$password = md5($_POST['password']);
	$email = htmlentities($_POST['email']);
	
	$sql_check_user = "SELECT * FROM challenge4_users WHERE username='$username'";
	$query_check_user = mysql_query($sql_check_user) or die(mysql_error());
	if(mysql_num_rows($query_check_user) > 0)
		$message = "Username already exisits";
	else{
		$sql_insert_user = "INSERT INTO challenge4_users (username, password, email)
									VALUES('$username', '$password', '$email')";
		$query_insert_user = mysql_query($sql_insert_user) or die(mysql_error());
		if($query_insert_user)
			$message = "Registration successful, you may now <a href=\"./index.php\">login</a>.";
	}
}
?>
<html>
	<head>
		<title>Challenge 4 - Register</title>
	</head>
	<body>
		<h1>Register</h1>
		<?php print @$message; ?>
		<br />
		<br />
		<form action="<?php print $_SERVER['PHP_SELF']; ?>" method="POST">
			<fieldset style="width:250px">
				<legend>Enter your details</legend>
				<label>Username:</label><br />
				<input type="text" name="username" value="<?php print htmlentities(@$_POST['username']); ?>"/><br />
				<label>Email Address:</label><br />
				<input type="text" name="email" value="<?php print htmlentities(@$_POST['email']); ?>" /><br />
				<label>Password</label><br />
				<input type="password" name="password" /><br />
				<input type="submit" value="Register" />
			</fieldset>
	</body>
</html>
