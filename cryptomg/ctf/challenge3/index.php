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

$key = "PreDE9eTRuEdraZ8";
$key_hash = "57f3450d18e982b8f3d4e9beb8ca290d";

$p_key = @$_POST['password'];
$e_message = "";

$plaintext = "It was the best of times it was the worst of times it was 
the age of wisdom it was the age of foolishness it was the epoch of belief 
it was the epoch of incredulity it was the season of Light it was the season 
of Darkness it was the spring of hope it was the winter of despair.";

$cipherText = encode(encrypt($plaintext, $cipher, $mode, $key_hash, $iv), 1);

function checkKey($key, $p_key){
	$key_hash = "";
	for($i=0; $i<strlen($p_key); $i++){
			if($key[$i] == $p_key[$i]){
				$hash = md5($key[$i]);
				for($k=0; $k<100000; $k++){
					$hash= md5($k.$hash);
				}
				$key_hash .= $hash;
			}else{ 
				return false;
			}
	}
	if(strlen($p_key) != strlen($key))
		return false;
	else
		return md5($key_hash);
}
if($p_key!=null){
	$hash = checkKey($key, $p_key);
	if(!$hash)
		$e_message = "Invalid Password";
	else{
		$decode =  decode(urldecode($cipherText),1);
		$decrypt = decrypt($decode, $cipher, $mode, $hash, $iv);
	}
}
?>
<html>
	<head>
		<title>CryptOMG - Challenge 3</title>
	</head>
	<body>
		<b>Message:</b>
		<pre>
<?php  
		print chunk_split(urldecode($cipherText));
?>	</pre>
	<?php print $e_message;
		if(isset($decrypt))
			print($decrypt); ?>
	<form action="<?php print $_SERVER['PHP_SELF'] ?>" method="POST">
		<input type="text" name="password" value="<?php print htmlentities($p_key) ?>" />
		<input type="submit" value="Decrypt" />
	</body>
</html>
