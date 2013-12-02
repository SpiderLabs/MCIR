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

include "../../includes/init.php";
include "db.php";
if(@$_GET['a'] == "logout"){
	setcookie("authtoken", "", 1);
	header("Location: index.php");
	die();
}

Global $username2;
$mode = MCRYPT_MODE_ECB;
function checkAuth($username, $password){
	if(isset($_COOKIE['authtoken'])){
		$authtoken = decode($_COOKIE['authtoken'], 2);
		$info = explode("|", decrypt($authtoken, $GLOBALS['cipher'], $GLOBALS['mode'], $GLOBALS['key'], $GLOBALS['iv']));
		$GLOBALS['username2'] = $info[2];
		return true;
	}else{
		$sql_check_auth = "SELECT * FROM challenge4_users WHERE username='$username'";
		$query_check_auth = mysql_query($sql_check_auth) or die(mysql_error());
		if(mysql_num_rows($query_check_auth)){
			$result = mysql_fetch_array($query_check_auth);
			if($result['password'] == $password){
				$authtoken = $result['id']."|".$result['email']."|".$result['username'];
				$GLOBALS['username2'] = $result['username'];
				setcookie("authtoken", encode(encrypt($authtoken, $GLOBALS['cipher'], $GLOBALS['mode'], $GLOBALS['key'], $GLOBALS['iv']), 2));
				return true;
			}else return false;
		}
	}
}
$auth = checkAuth(htmlentities(@$_POST['username']), md5(@$_POST['password']));
if($auth){
		$message = "Welcome, $username2";
}
elseif(isset($_POST['username'])){
	$message = "Wrong username or password";
}
?>
<html>
	<head>
		<title>Challenge 4 - Login</title>
	</head>
	<body>
		<br />
		<br />
		<br />
		<br />
		<?php print @$message;
		if(!$auth){ ?>
		<form action="<?php print $_SERVER['PHP_SELF'];?>" method="POST">
			<fieldset style="width:250px">
				<legend>Login</legend>
				<label>Username:</label><br />
				<input type="text" name="username" value="<?php print(htmlentities(@$username));?>" /><br />
				<label>Password:</label><br />
				<input type="password" name="password" /><br />
				<input type="submit" value="login" />
			</fieldset>
		</form><br />
		<a href="./register.php">Register</a>
		<?php } else print "<br /><a href=\"index.php?a=logout\">Logout</a>" ?>
	</body>
</html>
