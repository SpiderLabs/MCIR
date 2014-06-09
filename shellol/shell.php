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
<title>ShellOL - Shell Command Injection</title>
<link rel="stylesheet" type="text/css" href="../includes/mcir.css">
</head>
<body>
<center><h1>ShellOL - Shell Command Injection</h1></center><br>
<?php
include('includes/nav.inc.php');
include('../includes/options.inc.php');
?>
	<tr><td>Injection Location:</td><td>
		<select name="location">
			<option value="argument">Argument</option>
			<option value="argument_quotes" <?php if(isset($_REQUEST["location"]) and $_REQUEST["location"]=="argument_quotes") echo "selected"; ?>>Argument (wrapped in quotes)</option>
			<option value="command" <?php if(isset($_REQUEST["location"]) and $_REQUEST["location"]=="command") echo "selected"; ?>>Command</option>
			<option value="filename" <?php if(isset($_REQUEST["location"]) and $_REQUEST["location"]=="filename") echo "selected"; ?>>File name for output redirection</option>
		</select></td></tr>
		<tr><td>Custom command (*INJECT* specifies injection point):</td><td><textarea name="custom_inject"><?php echo (isset($_REQUEST['custom_inject']) ? htmlentities($_REQUEST['custom_inject']) : '' ); ?></textarea></td></tr>
	</table>
	<input type="submit" id="submit" name="submit" value="Inject!">
</form>
<div id="results">

<?php
if(isset($_REQUEST['submit'])){
	if(stristr(PHP_OS, 'WIN') && PHP_OS != 'Darwin'){
		$base_utility = 'dir';
		$base_filename = 'C:\\derp';
	} else {
		$base_utility = 'ls';
		$base_filename = '/tmp/derp';
	}
	$base_command = $base_utility . ' ' . $base_filename;
	
	//add environmental factors
	include('../includes/environ.inc.php');
	//sanitization section
	include('../includes/sanitize.inc.php');
	
	if (isset($_REQUEST['custom_inject']) and $_REQUEST['custom_inject']!=''){
		$command = str_replace('*INJECT*', $_REQUEST['inject_string'], $_REQUEST['custom_inject']);
		$display_command = str_replace('*INJECT*', '<u>' . $_REQUEST['inject_string'] . '</u>', $_REQUEST['custom_inject']);
	}else{
		switch ($_REQUEST['location']){
			case 'argument':
				$command = str_replace($base_filename, $_REQUEST['inject_string'], $base_command);
				$display_command = str_replace($base_filename, '<u>' . $_REQUEST['inject_string'] . '</u>', $base_command);
				break;
			case 'argument_quotes':
				$command = str_replace($base_filename, '"'.$_REQUEST['inject_string'].'"', $base_command);
				$display_command = str_replace($base_filename, '"<u>' . $_REQUEST['inject_string'] . '</u>"', $base_command);
				break;
			case 'command':
				$command = str_replace($base_utility, $_REQUEST['inject_string'], $base_command);
				$display_command = str_replace($base_utility, '<u>' . $_REQUEST['inject_string'] . '</u>', $base_command);
				break;
			case 'filename':
				$command = $base_command . ' > ' . $_REQUEST['inject_string'];
				$display_command = $base_command . ' &gt; <u>' . $_REQUEST['inject_string'] . '</u>';
				break;
		}
	}
	
	
	$descriptor_spec = array(
		0 => array('pipe','r'),
		1 => array('pipe','w'),
		2 => array('pipe','w')
	);

	$process = proc_open($command, $descriptor_spec, $pipes);

	if(is_resource($process)){
		fclose($pipes[0]);
		$output = stream_get_contents($pipes[1]);
		fclose($pipes[1]);
		$errors = stream_get_contents($pipes[2]);
		fclose($pipes[2]);
		proc_close($process);
	}else{
		die('Could not launch child process.');
	}
	
	if(isset($_REQUEST['show_query'])){
		echo '<b>Command executed (payload is <u>underlined</u>)</b>:<br> ' . $display_command . '<br><br>';
	}

	if(isset($_REQUEST['query_results']) and $output) {
		switch($_REQUEST['query_results']){
			case 'all_rows':
				echo '<b>Output:</b><br>';
				echo '<pre>'.$output.'</pre>';
				break;
			case 'one_row':
				$output_array = explode("\n", $output);
				echo '<b>Output:</b><br>';
				echo $output[0];
				break;
			case 'bool':
				echo '<b>Output</b>:<br>';
				echo 'Command returned output.';
				break;
		}
	}

	if(isset($_REQUEST['error_level']) && isset($errors)){
		switch ($_REQUEST['error_level']){
			case 'generic':
				echo '<b>Errors:</b><br>';
				echo 'Command returned errors.';
				break;
			case 'verbose':
				echo '<b>Errors:</b><br>';
				echo $errors.'<br>';
				break;
		}

	}
	
}

?>

</div>
<?php include('../includes/mcir.nav.inc.php'); ?>
</body>
</html>
