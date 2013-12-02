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
?>

<html>
	<head>
		<title>CryptOMG Training <?php print $title ?></title>
		<script type="text/javascript">
			function changeState(e, s){
				
				x = document.getElementById(e+"_txt");
				y = document.getElementById(e+"_span");
				if(s == 1){
					x.disabled = false;
					y.style.display='block';
				}
				else {
					x.disabled = true;
					y.style.display='none';
				}
			}
		</script>
	</head>
	<body>
		<div style="text-align:center">
			<h1>CryptOMG</h1>
			<h2>Training</h2>
			<hr />
			| <a href="./encrpyt.php">Encrypt</a> || 
			<a href="./decrypt.php">Decrypt</a> ||
			<a href="./Encoder.php">Encoder</a> || 
			<a href="./challenges">Challenges</a> |
			<br />
			<br />
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
				<label>Key:</label>
				<select name="key">
				<?php foreach($key_iv_list as $kkey => $value){ ?>
				<option value="<?php print $kkey+1?>"<?php print ($kkey+1 == $p_key_settings) ? " selected ": ""; if($kkey==2) print "onclick=\"changeState('key', 1)\""; else  print "onclick=\"changeState('key', 0)\""; ?>><?php print $value ?></option>
				<?php } ?>
				</select>
				<label>IV:</label>
				<select name="iv">
				<?php foreach($key_iv_list as $ikey => $value){ ?>
				<option value="<?php print $ikey+1?>"<?php print ($ikey+1 == $p_iv_settings) ? " selected ": ""; if($ikey==2) print "onclick=\"changeState('iv', 1)\""; else  print "onclick=\"changeState('iv', 0)\"";?>><?php print $value ?></option>
				<?php } ?>
				</select>
				<input type="submit" value="save" />
				<br />
				<br />
				<span>
				<span id="key_span" style="position:absolute; display:none;  margin-left: 40%; margin-top: -10px;">
					<label>Key (Encoded)</label>
					<input type="text" id="key_txt" name="key_value" value="<?php print htmlentities(@$p_key)?>" disabled="true"/>
					&nbsp;&nbsp;&nbsp;
				</span>
				</span>
				<span id="iv_span" style="position: absolute;display:none;  margin-left: 60%;; margin-top: -10px;">
					<label>IV (Encoded)</label>
					<input type="text" id="iv_txt" name="iv_value" value="<?php print htmlentities(@$p_iv) ?>" disabled="true"/>
				</span>
			</form>
		</div>
	</div>
	<hr />
