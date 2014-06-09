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
$mcir['page_name'] = 'PHP Code Injection';
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
	<tr><td>Injection Location:</td><td>
		<select name="location">
			<option value="value">Variable Value</option>
			<option value="variable" <?php if(isset($_REQUEST["location"]) and $_REQUEST["location"]=="variable") echo "selected"; ?>>Variable Name</option>
		</select></td></tr>
		<tr><td>Custom command (*INJECT* specifies injection point):</td><td><textarea name="custom_inject"><?php echo (isset($_REQUEST['custom_inject']) ? htmlentities($_REQUEST['custom_inject']) : '' ); ?></textarea></td></tr>
	</table>
	<input type="submit" id="submit" name="submit" value="Inject!">
</form>
<div id="results">

<?php
if(isset($_REQUEST['submit'])){
	
	$variable = '$var2';
	$value = "foobar";
	$eval_string = $variable . " = '" . $value . "';";
	include('../includes/environ.inc.php');
	include('../includes/sanitize.inc.php');
	
	if (isset($_REQUEST['custom_inject']) and $_REQUEST['custom_inject']!=''){
		$eval_string = str_replace('*INJECT*', $_REQUEST['inject_string'], $_REQUEST['custom_inject']);
		$display_eval_string = str_replace('*INJECT*', '<u>' . $_REQUEST['inject_string'] . '</u>', $_REQUEST['custom_inject']);
	}else{
		switch ($_REQUEST['location']){
			case 'variable':
				$eval_string = str_replace($variable, '$' . $_REQUEST['inject_string'], $eval_string);
				$display_eval_string = str_replace($variable, '<u>$' . $_REQUEST['inject_string'] . '</u>', $eval_string);
				break;
			case 'value':
				$eval_string = str_replace($value, $_REQUEST['inject_string'], $eval_string);
				$display_eval_string = str_replace($value, '<u>' . $_REQUEST['inject_string'] . '</u>', $eval_string);
				break;
		}
	}

	if(isset($_REQUEST['error_level'])){
		switch ($_REQUEST['error_level']){
			case 'generic':
				ini_set("display_errors", '0');
				$output = eval($eval_string);
				if($output == FALSE){
					echo '<b>Errors:</b><br>';
					echo 'Command returned errors.<br>';
				}
				break;
			case 'verbose':
				ini_set("display_errors", '1');
				$output = eval($eval_string);
				break;
			case 'none':
				ini_set("display_errors", '0');
				$output = eval($eval_string);
				break;
		}

	}
	//else{
		//ini_set("display_errors", '0');
		//$output = eval($eval_string);
	//}
	
	if(isset($_REQUEST['show_query'])){
		echo '<b>Command executed (payload is <u>underlined</u>)</b>:<br> ' . $display_eval_string . '<br><br>';
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
	
	
}

?>

</div>
<?php include('../includes/mcir.nav.inc.php'); ?>
</body>
</html>
