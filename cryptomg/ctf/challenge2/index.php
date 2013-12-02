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

require("../../includes/init.php");
require("db.php");

session_start();

function checkAuth($username, $password){
	$sql_check_auth = "SELECT * FROM challenge2_users WHERE username='$username' AND password='$password'";
	$query_check_auth = mysql_query($sql_check_auth);
	if(mysql_num_rows($query_check_auth) == 1){
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;
		return true;
	} else return false;
}

$page = @$_GET['page'];
$return_url = @$_REQUEST['ReturnUrl'];
$auth = false;

if($page == "logout"){
	session_destroy();
	header("Location: index.php?cipher=$p_cipher&encoding=$p_encoding&mode=$p_mode");
}

if(!is_null(@$_POST['username']) && !is_null(@$_POST['password'])){
	$username = htmlentities(@$_POST['username']);
	$password = encode(encrypt(htmlentities(@$_POST['password']), $cipher, $mode, $key, $iv), 4);
	$auth =checkAuth($username, $password);
}elseif(!is_null(@$_SESSION['username']) && !is_null(@$_SESSION['password']))
	$auth = checkAuth($_SESSION['username'], $_SESSION['password']);

if(is_null($page))
	$page = "articles";
elseif(!is_null(@$_GET['id']) && $auth == false)
	$page .= "&id=".$_GET['id'];
if(is_null($return_url)){
	$return_url = encode(encrypt($page, $cipher, $mode, $key, $iv), $p_encoding);
}
if($auth==false && is_null(@$_GET['ReturnUrl']))
	header("Location: ./index.php?cipher=$p_cipher&encoding=$p_encoding&mode=$p_mode&ReturnUrl=$return_url");
elseif($auth == true && is_null(@$_GET['page'])){
	header("Location: ./index.php?cipher=$p_cipher&encoding=$p_encoding&mode=$p_mode&page=".trim(decrypt(decode($return_url, $p_encoding), $cipher, $mode, $key, $iv)));
}

?>
<html>
	<head>
		<title>CryptOMG - Challenge 2</title>
		<link rel="stylesheet" type="text/css" href="../../style.css" />
	</head>
	<body>
		
<div id="settings">
			<form action="<?php print $_SERVER['PHP_SELF']?>" method="GET">
				<label>Cipher:</label>
				<select name="cipher">
			<?php foreach($cipherList as $lkey => $value){ ?>
			<option value="<?php print ($lkey + 1) ?>"<?php print ($lkey+1 == $p_cipher) ? " selected": "";?>><?php print $value ?></option>
			<?php } ?>
		</select>
				<label>Mode:</label>
				<select name="mode">
			<?php foreach($modeList as $mkey => $value){ ?>
			<option value="<?php print $mkey+1?>"<?php print ($mkey+1 == $p_mode) ? " selected": "";?>><?php print $value ?></option>
			<?php } ?>
		</select>
				<label>Encoding:</label>
				<select name="encoding">
			<?php foreach($encoding_list as $lkey => $value){ ?>
			<option value="<?php print $lkey+1?>"<?php print ($lkey+1 == $p_encoding) ? " selected": "";?>><?php print $value ?></option>
			<?php } ?>
		</select>
				<input type="submit" value="save" />
			</form>
		</div>
		<br />
		<br />
<?php if($auth==false){ ?>
	You may login as a guest using guest/guest as the username/password;
	<form action="<?php print $_SERVER['PHP_SELF']."?cipher=$p_cipher&encoding=$p_encoding&ReturnUrl=".$return_url ?>" method="POST" autocomplete="off">
		  <fieldset style="width:250px;">
			<legend><small>Enter your details:</small></legend>
			<br />
			Username:<br />
			<input type="text" name="username" value="" style="width:100%;">
			<br /><br />
			Password:<br />
			<input type="password" name="password" style="width:100%;">
			<br /><br />
			<input type="submit" value="Login">
		  </fieldset>
		</form>
<? } else{ ?>
	<div id="nav">
		<ul>
			<li><a href="./index.php?cipher=<?php print $p_cipher ?>&encoding=<?php print $p_encoding ?>&mode=<?php print $p_mode ?>&page=articles">Articles</a></li>
				<ul>
				<?php if($page == "articles"){
						$sql_get_articles = "SELECT * FROM challenge2_articles";
						$query_get_articles = mysql_query($sql_get_articles);
						while($row = mysql_fetch_array($query_get_articles)){
							print "<li><a href=\"./index.php?cipher=$p_cipher&encoding=$p_encoding&mode=$p_mode&page=".htmlentities($page)."&id=".encode(encrypt($row['id'], $cipher, $mode, $key, $iv), $p_encoding)."\">".$row['title']."</a></li>";
						}
					} ?>
			</ul>
			<li><a href="./index.php?page=logout">Logout</a></li>
		</ul>
	</div>
	<div id="content" style="margin-left: 200px; margin-top: -200px;">
		<?php
				if(!is_null(@$_GET['id']) && $page == "articles"){
								$article_id = decrypt(decode(@$_GET['id'], $p_encoding), $cipher, $mode, $key, $iv);
								$sql_get_article = "SELECT * FROM challenge2_articles WHERE id='$article_id'";
								$query_get_article = mysql_query($sql_get_article) or die(mysql_error());
								if(mysql_num_rows($query_get_article)){
									while($result = mysql_fetch_array($query_get_article)){
										$title = $result['title'];
										$body = $result['content'];
										print "<h1>$title</h1>";
										print $body;
									}
								}else print "Article not found";
						}else print "Please select an article";
		?>
	</div>
<?}?>
	</body>
</html>
