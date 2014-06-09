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
<title>CryptOMG - Pseudo-Random Number Generator</title>
<link rel="stylesheet" type="text/css" href="../includes/mcir.css">
</head>
<body>
<center><h1>CryptOMG - Pseudo-Random Number Generator</h1></center><br>
<?php
include('includes/nav.inc.php');
?>

<form method="get">
<table>
<tr><td><b>Environmental Settings:</b></td></tr>
<tr><td><small><i>Simulate transient application issues</i></small></td></tr>
        <tr><td>Random Failure?</td><td><input type="checkbox" name="random_failure"<?php echo isset($_REQUEST['random_failure']) ? ' checked' : '' ?>>
        <tr><td>Random Time Delay?</td><td><input type="checkbox" name="random_delay"<?php echo isset($_REQUEST['random_delay']) ? ' checked' : '' ?>>
<tr><td><br/></td><td></td></tr>
<tr><td><b>Randomness Options:</b></td></tr>
<tr><td><small><i>Choose the source of pseudo-random numbers</i></small></td></tr>
	<tr><td>Seed Source:</td><td><select name="seed">
		<option value="noseed"<?php echo (isset($_REQUEST['seed']) and $_REQUEST['seed'] == "noseed") ? "selected": "";?>>Do not seed</option>
		<option value="dev_random"<?php echo (isset($_REQUEST['seed']) and $_REQUEST['seed'] == "dev_random") ? "selected": "";?>>/dev/random</option>
		<option value="dev_urandom" <?php echo (isset($_REQUEST['seed']) and $_REQUEST['seed'] == "dev_urandom") ? "selected": "";?>>/dev/urandom</option>
		<option value="microtime" <?php echo (isset($_REQUEST['seed']) and $_REQUEST['seed'] == "microtime") ? "selected": "";?>>PHP microtime()</option>
		<option value="time" <?php echo (isset($_REQUEST['seed']) and $_REQUEST['seed'] == "time") ? "selected": "";?>>PHP time()</option>
		<option value="eight" <?php echo (isset($_REQUEST['seed']) and $_REQUEST['seed'] == "eight") ? "selected": "";?>>The number eight</option>
		<?php //I <3 The Stanley Parable. ?>
		</select></td></tr>
	<tr><td>Pseudo-random Number Generator:</td><td><select name="prng">
		<option value="rand"<?php echo (isset($_REQUEST['prng']) and $_REQUEST['prng'] == "rand") ? "selected": "";?>>libc rand()</option>
		<option value="mt" <?php echo (isset($_REQUEST['prng']) and $_REQUEST['prng'] == "mt") ? "selected": "";?>>Mersenne Twister</option>
		</select></td></tr>
<tr><td><br/></td><td></td></tr>
<tr><td><b>Output Options:</b></td></tr>
<tr><td><small><i>Configure the amount of output</i></small></td></tr>
	<tr><td>Number of values to output:</td><td><input type="text" name="num_values" value="<?php echo isset($_REQUEST['num_values']) ? $_REQUEST['num_values'] : '1' ?>"></td></tr>
	<tr><td>Max number size:</td><td><input type="text" name="max_num" value="<?php echo isset($_REQUEST['max_num']) ? $_REQUEST['max_num'] : '' ?>"></td></tr>
<tr><td><br/></td><td></td></tr>
<tr><td><b>Guess:</b></td></tr>
<tr><td><small><i>Attempt to predict one of the outputted numbers</i></small></td></tr>
<tr><td>Suspected number:</td><td><input type="text" name="guess" value="<?php echo isset($_REQUEST['guess']) ? $_REQUEST['guess'] : '' ?>"></td></tr>
<tr><td><br/></td><td></td></tr>
	</table>
<input type="submit" id="submit" name="submit" value="Go!">
</form>
<div id="results">

<?php
if(isset($_REQUEST['submit'])){ //What time is it? PRNG TIME!	
	include('../includes/environ.inc.php');

	//Set the seed
	switch ($_REQUEST['seed']){
		case 'dev_random':
			$seed_fd = fopen('/dev/random','r');
			$seed = fread($seed_fd,20);
			fclose($seed_fd);
			break;
		case 'dev_urandom':
			$seed_fd = fopen('/dev/urandom','r');
			$seed = fread($seed_fd,20);
			fclose($seed_fd);
			break;
		case 'microtime':
			$microtime = explode(' ', microtime());
			$seed = str_replace('.', '', $microtime[0]);
			break;
		case 'time':
			$seed = time();
			break;
		default:
			$seed = '8'; //eight
			break;
	}

	//Set the PRNG
	switch ($_REQUEST['prng']){
		case 'mt':
			if(!(isset($_REQUEST['seed']) and $_REQUEST['seed'] == 'noseed')) mt_srand($seed);
			function do_prng(){
				$max_num = (isset($_REQUEST['max_num']) and $_REQUEST['max_num'] != '') ? $_REQUEST['max_num'] : mt_getrandmax();
				return mt_rand(0,$max_num);
			}
			break;
		default:
			if(!(isset($_REQUEST['seed']) and $_REQUEST['seed'] == 'noseed')) srand($seed);
			function do_prng(){
				$max_num = (isset($_REQUEST['max_num']) and $_REQUEST['max_num'] != '') ? $_REQUEST['max_num'] : getrandmax();
				return rand(0,$max_num);
			}
			break;
	}

	$num_values = isset($_REQUEST['num_values']) ? $_REQUEST['num_values'] : 1;

	for ($i = $num_values;$i--;$i>0){
		$num_out = do_prng();
		if ($_REQUEST['guess'] == $num_out) echo "Correctly guessed number: ";
		echo $num_out . "<br>\n";
	}

}
?>
</div>
<?php include('../includes/mcir.nav.inc.php'); ?>
</body>
</html>
