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
				<input type="checkbox" value="1" name="null_iv" <?php if(@$_GET['null_iv'] == 1) print "checked" ?>/><label>Null IV</label>
				<input type="submit" value="save" />
			</form>
		</div>
