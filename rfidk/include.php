<?php
/*
Magical Code Injection Rainbow - A set of configurable injection testbeds 
Daniel "unicornFurnace" Crowley
Copyright (C) 2014 Trustwave Holdings, Inc.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

include_once('includes/branding.php');
$mcir['page_name'] = 'File Inclusion'; //Description of this page
?>

<html>
<head>
<title><?php echo $mcir['name'].' - '.$mcir['page_name']?></title>
<link rel="stylesheet" type="text/css" href="../includes/mcir.css">
</head>
<body>
<center><h1><?php echo $mcir['name'].' - '.$mcir['page_name']?></h1></center><br>
<?php
include('includes/nav.inc.php');
include('../includes/options.inc.php');
?>
	<tr><td><b>File Inclusion Options:</b></td><td>
		<tr><td><small><i>File inclusion specific options</i></small></td></tr>
		<tr><td>Display file only:</td><td><input type="checkbox" name="no_parse" <?php if(isset($_REQUEST["no_parse"])) echo "checked"; ?> ></td></tr>
		<tr></tr>
	<tr><td>Injection Location:</td><td>
		<select name="location">
			<option value="filename">Full filename</option>
			<option value="basename" <?php if(isset($_REQUEST["location"]) and $_REQUEST["location"]=="basename") echo "selected"; ?>>File basename (&lt;your_input&gt;.ext)</option>
			<option value="domain" <?php if(isset($_REQUEST["location"]) and $_REQUEST["location"]=="domain") echo "selected"; ?>>Domain name</option>

		</select></td></tr>
		<tr><td>Custom include path (*INJECT* specifies injection point):</td><td><textarea name="custom_inject"><?php echo (isset($_REQUEST['custom_inject']) ? htmlentities($_REQUEST['custom_inject']) : '' ); ?></textarea></td></tr>
	</table>
	<input type="submit" id="submit" name="submit" value="Inject!">
</form>
<div id="results">

<?php
if(isset($_REQUEST['submit'])){
	
	//add environmental factors
	include('../includes/environ.inc.php');
	//sanitize injection string
	include('../includes/sanitize.inc.php');
	
	if (isset($_REQUEST['custom_inject']) and $_REQUEST['custom_inject']!=''){
		$uri = str_replace('*INJECT*', $_REQUEST['inject_string'], $_REQUEST['custom_inject']);
		$display_uri = str_replace('*INJECT*', '<u>' . $_REQUEST['inject_string'] . '</u>', $_REQUEST['custom_inject']);
	}else{
		switch ($_REQUEST['location']){
			case 'filename':
				$uri = str_replace('date.php', $_REQUEST['inject_string'], 'pages/date.php');
				$display_uri = str_replace('date.php', '<u>' . $_REQUEST['inject_string'] . '</u>', 'pages/date.php');
				break;
			case 'basename':
				$uri = str_replace('date', $_REQUEST['inject_string'], 'pages/date.php');
				$display_uri = str_replace('date', '<u>' . $_REQUEST['inject_string'] . '</u>', 'pages/date.php');
				break;
			case 'domain':
				$uri = str_replace('example.com', $_REQUEST['inject_string'], 'http://example.com/date.php');
				$display_uri = str_replace('example.com', '<u>' . $_REQUEST['inject_string'] . '</u>', 'http://example.com/date.php');
				break;
		}
	}
	
	
	try {
		if(isset($_REQUEST['no_parse'])){
			$output = file_get_contents($uri);
		}else{
			$tempfilename = tempnam('tempfiles','temp');
			$tempfile = fopen($tempfilename,'w');
			fwrite($tempfile,file_get_contents($uri));
			fclose($tempfile);
			$output = include($tempfilename);
			unlink($tempfilename);	
		}
	} catch (Exception $e) {
		if(isset($_REQUEST['error_level']) and $_REQUEST['error_level'] == 'generic'){
			echo 'An error occurred.';
		} else if (isset($_REQUEST['error_level']) and $_REQUEST['error_level'] == 'verbose'){
			echo 'Error: ' . $e->getMessage();
		}
	}

	if(isset($_REQUEST['show_query'])){
		echo '<b>URI opened (payload is <u>underlined</u>)</b>:<br> ' . $display_uri . '<br><br>';
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
				if($output){
					echo 'Include operation successful.';
				}
				break;
		}
	}
	
}

?>

</div>
<?php include('../includes/mcir.nav.inc.php'); ?>
</body>
</html>
