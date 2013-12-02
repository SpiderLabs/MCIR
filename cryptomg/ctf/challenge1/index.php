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

require "../../includes/init.php";

$mode = MCRYPT_MODE_CBC;
$directory = "./files";


function pkcs5_pad ($text, $blocksize){
    $pad = $blocksize - (strlen($text) % $blocksize);
    return $text . str_repeat(chr($pad), $pad);
}

function pkcs5_unpad($text) 
{ 
    $pad = ord($text{strlen($text)-1}); 
    if ($pad > strlen($text)) return false; 
    if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) return false; 
    return substr($text, 0, -1 * $pad); 
} 

if(isset($_GET['c'])){
	$cipherText = @$_GET['c'];
}else{
	$cipherText = encode(encrypt(pkcs5_pad(genNonce(16)."|".$directory."/home", $blocksize), $cipher, $mode, $key, $iv), $p_encoding);
}
if(!is_null(@$cipherText)){
	$plainText = pkcs5_unpad(decrypt(decode($cipherText, $p_encoding), $cipher, $mode, $key, $iv), $blocksize);
	//$plainText2 = substr($plainText2, 16, strlen($plainText2));
	$file = explode("|", $plainText);
	$plainText2 = $file[sizeof($file)-1];
	if($plainText2){
		if(file_exists($plainText2) && !is_dir($plainText2)){
			//$output = str_replace("\n", "<br />", file_get_contents($plainText2));
			$theData = str_replace("\n", "<br />", file_get_contents($plainText2));
			$fileName = explode("/", $plainText2);
			$title = ucwords($fileName[sizeof($fileName)-1]);
			$heading = $title;
		}
		else{
			header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); 
			$title = "File not found";
			$header = $title;
		}
	}
	else{
		header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
		 $title = "Server 500: Padding Error";
		 $header = "Padding Error";
	}
}
?>
<html>
	<head>
		<title>CryptOMG - Challenge 1 :: <?php print $title ?></title>
		 <link rel="stylesheet" type="text/css" href="../../style.css" />
	</head>
	<body>
		<div id="settings">
			<form action="<?php print $_SERVER['PHP_SELF']?>" method="GET">
				<label>Cipher:</label>
				<select name="cipher">
			<?php foreach($cipherList as $lkey => $value){ ?>
			<option value="<?php print ($lkey + 1) ?>"<?php print ($lkey+1 == $p_cipher) ? "selected": "";?>><?php print $value ?></option>
			<?php } ?>
		</select>
				<label>Encoding:</label>
				<select name="encoding">
			<?php foreach($encoding_list as $lkey => $value){ ?>
			<option value="<?php print $lkey+1?>"<?php print ($lkey+1 == $p_encoding) ? "selected": "";?>><?php print $value ?></option>
			<?php } ?>
		</select>
				<input type="submit" value="save" />
			</form>
		</div>
		<div id="nav">
			<ul>
			<?php $files = glob("./files/*");
			foreach($files as $file){
				$time = time();
				$fileName = explode("/", $file);
				$filePlace = sizeof($fileName)-1;
				$url = "";
				if(isset($_GET['cipher']))
					$url .= "cipher=".$p_cipher;
				if(isset($_GET['encoding']))
					$url .="&encoding=".$p_encoding;
				print "<li><a href=\"?$url&c=".encode(encrypt(pkcs5_pad(genNonce(16)."|".$directory."/".$fileName[$filePlace], $blocksize), $cipher, $mode, $key, $iv), $p_encoding)."\">".ucwords($fileName[$filePlace])."</a></li>";
			}
			?>
			</ul>
		</div>
		<div id="content">
			<h1><?php print $title ?></h1>
	<?php print @$theData ?>
		</div>
</body>
</html>
