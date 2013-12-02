<?php
/*
CryptOMG - A configurable CTF style test bed.
CryptOMG by Andrew Jordan
This challenge contributed by Daniel Crowley
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

$directory = "./files";
$algo = 'md5';
$title = '';
$secret = 'ThisisMYl0ng4ndh5rd2gues%sSekrett!';

if(isset($_GET['algo'])){
	$algo = $_GET['algo'];
}

if(isset($_GET['file']) and isset($_GET['hash'])){
	if(hash($algo,$secret.$_GET['file'])==$_GET['hash']){
		$fileToGet = $directory."/".$_GET['file'];
		//Ugly hack to get this to work in PHP when it shouldn't due to null bytes. I feel dirty. (DC)
		$fileToGet = str_replace("\0",'',$fileToGet);
		$theData = nl2br(file_get_contents($fileToGet));
		$title = $_GET['file'];
	}
	else{
		header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); 
		$title = "File not found";
		$header = $title;
	}
}else{
	$theData = "Please select an option from the left.";
}

?>
<html>
	<head>
		<title>CryptOMG - Challenge 5 :: <?php print $title ?></title>
		 <link rel="stylesheet" type="text/css" href="../../style.css" />
	</head>
	<body>
		<div id="settings">
			<form action="<?php print $_SERVER['PHP_SELF']?>" method="GET">
				<label>Algorithm:</label>
				<select name="algo">
			<option value="md4">md4</option>
			<option value="md5">md5</option>
			<option value="ripemd160">ripemd160</option>
			<option value="sha1">sha1</option>
			<option value="sha256">sha256</option>
			<option value="sha512">sha512</option>
			<option value="whirlpool">whirlpool</option>
		</select>
				<input type="submit" value="save" />
			</form>
		</div>
		<div id="nav">
			<ul>
			<?php $files = glob("./files/*");
			foreach($files as $file){
				$url = "";
				$fileName = basename($file);
				if(isset($_GET['algo']))
					$url .= "algo=".$_GET['algo'];
				print "<li><a href=\"?$url&file=".$fileName."&hash=".hash($algo,$secret.$fileName)."\">".$fileName."</a></li>";
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
