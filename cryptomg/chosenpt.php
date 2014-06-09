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
<title>CryptOMG - Chosen Plaintext Attack</title>
<link rel="stylesheet" type="text/css" href="../includes/mcir.css">
</head>
<body>
<center><h1>CryptOMG - Chosen Plaintext Attack</h1></center><br>
<?php
include('includes/nav.inc.php');
$cipherList = mcrypt_list_algorithms();
$cipherModeList = mcrypt_list_modes();
?>

<form method="get">
<table>
<tr><td><b>Environmental Settings:</b></td></tr>
<tr><td><small><i>Simulate transient application issues</i></small></td></tr>
        <tr><td>Random Failure?</td><td><input type="checkbox" name="random_failure"<?php echo isset($_REQUEST['random_failure']) ? ' checked' : '' ?>>
        <tr><td>Random Time Delay?</td><td><input type="checkbox" name="random_delay"<?php echo isset($_REQUEST['random_delay']) ? ' checked' : '' ?>>
<tr><td><br/></td><td></td></tr>
<tr><td><b>Encryption Options:</b></td></tr>
	<tr><td>Encryption Algorithm:</td><td><select name="algorithm">
		<?php foreach($cipherList as $lkey => $value){ ?>
		<option value="<?php print ($value) ?>"<?php print ($_REQUEST['algorithm'] == $value) ? "selected": "";?>><?php print $value ?></option>
                <?php } ?>
		</select></td></tr>
	<tr><td>Block Cipher Mode:</td><td><select name="cipher_mode">
		<?php foreach($cipherModeList as $lkey => $value){ ?>
		<option value="<?php print ($value) ?>"<?php print ($_REQUEST['cipher_mode'] == $value) ? "selected": "";?>><?php print $value ?></option>
                <?php } ?>
		</select></td></tr>
	<tr><td>Initialization Vector:</td><td><select name="iv">
		<option value="static">Static</option>
		<option value="random">Random</option>
		<option value="null">Null</option>
		<!-- TODO: Implement predictable IV -->
		</select></td></tr>
	<tr><td>Key (ascii hex [base16] encoded):</td><td><input type="text" name="key" value="<?php echo isset($_REQUEST['key']) ? $_REQUEST['key'] : '0000000000000000' ; ?>"></td></tr>
	<tr><td>IV (ascii hex [base16] encoded):</td><td><input type="text" name="static_iv" value="<?php echo isset($_REQUEST['static_iv']) ? $_REQUEST['static_iv'] : '0000000000000000' ; ?>"></td></tr>
<tr><td><br/></td><td></td></tr>
<tr><td><b>Data to be encrypted:</b></td></tr>
	<tr><td>Prefix:</td><td><input type="text" name="prefix" value="<?php echo (isset($_REQUEST['prefix']) ? $_REQUEST['prefix'] : '' );?>"></td></tr>
	<tr><td>Suffix:</td><td><input type="text" name="suffix" value="<?php echo (isset($_REQUEST['suffix']) ? $_REQUEST['suffix'] : '' );?>"></td></tr>
	<tr><td>Plaintext:</td><td><input type="text" name="plaintext" value="<?php echo (isset($_REQUEST['plaintext']) ? $_REQUEST['plaintext'] : '' );?>"></td></tr>
	</table>
<input type="submit" id="submit" name="submit" value="Go!">
</form>
<div id="results">

<?php
if(isset($_REQUEST['submit'])){ //Crypto time!	
	include('../includes/environ.inc.php');

//Add prefix and suffix to plaintext
$data = $_REQUEST['prefix'] . $_REQUEST['plaintext'] . $_REQUEST['suffix'];

//Set cipher mode to stream if algo is a stream cipher
if(mcrypt_module_is_block_algorithm($_REQUEST['algorithm'])){
	$cipher_mode = $_REQUEST['cipher_mode'];
} else {
	$cipher_mode = 'stream';
}

//Decode key from hex
$key = pack('H*', $_REQUEST['key']);

//Create cipher descriptor
$cipher_descriptor = mcrypt_module_open($_REQUEST['algorithm'], '', $cipher_mode, '');

//Get IV size and create IV according to options
$iv_size = mcrypt_enc_get_iv_size($cipher_descriptor);
if($_REQUEST['iv'] == 'null'){
	if($iv_size){
		$iv = '';
		for ($i=$iv_size;$i--;$i>=1){
			$iv .= '00';
		}
		echo "IV: " . $iv . "<br>\n";
		$iv = pack('H*', $iv);
	}

//Unless we're given an IV 
} else if ($_REQUEST['iv'] == 'static'){
	$iv = pack('H*', $_REQUEST['static_iv']);
	echo "IV: " . $_REQUEST['static_iv'] . "<br>\n";

//Or told to create a random one
} else if ($_REQUEST['iv'] == 'random'){
	$iv = mcrypt_create_iv($iv_size);
	$iv_encoded = unpack('H*', $iv);
	echo "IV: " . $iv_encoded[1] . "<br>\n";
}

//Initialize cipher
mcrypt_generic_init($cipher_descriptor, $key, $iv);

//TODO: allow other types of output encodings
//Encrypt data and output it
echo base64_encode(mcrypt_generic($cipher_descriptor, $data));

}
?>
</div>
<?php include('../includes/mcir.nav.inc.php'); ?>
</body>
</html>
