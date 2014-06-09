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
<title>XMLmao - XPath Injection</title>
<link rel="stylesheet" type="text/css" href="../includes/mcir.css">
</head>
<body>
<center><h1>XMLmao - XPath Injection</h1></center><br>

<?php
include('includes/nav.inc.php');
include('../includes/options.inc.php');
?>
	<tr><td><b>Injection Location:</b></td><td>
		<select name="location">
			<option value="condition_string">String Value in Condition</option>
			<option value="condition_num" <?php echo (isset($_REQUEST['location']) and $_REQUEST['location']=='condition_num') ? 'selected' : ''; ?>>Numeric Value in Condition</option>
			<option value="node_path" <?php echo (isset($_REQUEST['location']) and $_REQUEST['location']=='node_path') ? 'selected' : ''; ?>>Node Path</option>
			<option value="node_name" <?php echo (isset($_REQUEST['location']) and $_REQUEST['location']=='node_name') ? 'selected' : ''; ?>>Node Name</option>
			<option value="condition_var" <?php echo (isset($_REQUEST['location']) and $_REQUEST['location']=='condition_var') ? 'selected' : ''; ?>>Condition Variable</option>
			<option value="sub_node" <?php echo (isset($_REQUEST['location']) and $_REQUEST['location']=='sub_node') ? 'selected' : ''; ?>>Child Node</option>
		</select></td></tr>
		<tr><td>Custom XPath query (*INJECT* specifies injection point):</td><td><textarea name="custom_inject"><?php echo isset($_REQUEST['custom_inject']) ? htmlentities($_REQUEST['custom_inject']) : ''; ?></textarea></td></tr>
	<tr><td><br/></td><td></td></tr>
	</table>
	<input type="submit" id="submit" name="submit" value="Inject!">
</form>
<div id="results">

<?php
if(isset($_REQUEST['submit'])){
	$node_path = $display_node_path = '/xmlfile/users';
	$node_name = $display_node_name = '/user';
	$condition = $display_condition = "username='jsmiley'";
	$sub_node = $display_sub_node = '/username';
	
	include_once('../includes/sanitize.inc.php');
	include_once('../includes/environ.inc.php');
	
	if (isset($_REQUEST['custom_inject']) and $_REQUEST['custom_inject']!=''){
		
		$display_query = str_replace('*INJECT*', '<u>' . $_REQUEST['inject_string'] . '</u>', $_REQUEST['custom_inject']);
		$query = str_replace('*INJECT*', $_REQUEST['inject_string'], $_REQUEST['custom_inject']);
		
	}else{
		
		switch ($_REQUEST['location']){
			case 'node_path':
				$node_path = $_REQUEST['inject_string'];
				$display_node_path = '<u>' . $_REQUEST['inject_string'] . '</u>';
				break;
			case 'node_name':
				$node_name = '/' . $_REQUEST['inject_string'];
				$display_node_name = '/<u>' . $_REQUEST['inject_string'] . '</u>';
				break;
			case 'condition_var':
				$condition = $_REQUEST['inject_string'] . "='jsmiley'";
				$display_condition = '<u>' . $_REQUEST['inject_string'] . "</u>='jsmiley'";
				break;
			case 'condition_string':
				$condition = "username='" . $_REQUEST['inject_string'] . "'";
				$display_condition = "username='<u>" . $_REQUEST['inject_string'] . "</u>'";
				break;
			case 'condition_num':
				$condition = 'id=' . $_REQUEST['inject_string'];
				$display_condition = 'id=<u>' . $_REQUEST['inject_string'] . '</u>';
				break;
			case 'sub_node':
				$sub_node = '/' . $_REQUEST['inject_string'];
				$display_sub_node = '/<u>' . $_REQUEST['inject_string'] . '</u>';
				break;
		}
		$display_query = $display_node_path . $display_node_name . "[". $display_condition . "]" . $display_sub_node;
		$query = $node_path . $node_name . "[". $condition . "]" . $sub_node;
		
	}

	$xml = simplexml_load_file('data.xml');
	
	$results = '';
	
	if(isset($_REQUEST['show_query']) and $_REQUEST['show_query'] == 'on') echo '<b>Executed query:</b><br> ' . $display_query . '<br><br>';

	if(isset($_REQUEST['error_level'])){
		switch ($_REQUEST['error_level']){
			case 'generic':
				ini_set('display_errors', 0);
				$results = $xml->xpath($query);
				if($results == FALSE) echo "<b>An error occurred.</b>" . "\n<br>";
				break;
			case 'verbose':
				ini_set('display_errors', 1);
				$results = $xml->xpath($query);
				break;
			case 'none':
				ini_set('display_errors', 0);
				$results = $xml->xpath($query);
				break;
		}
	}
	

	if($results){
		switch($_REQUEST['query_results']){
			case 'all_rows':
				print('<b>Results:</b><br><pre>');
				print_r($results);
				print('</pre>');
				break;
			case 'one_row':
				print('<b>Results:</b><br>');
				print($results[0]);
				break;
			case 'bool':
				if($results[0]) echo "<b>Results:</b><br>Got results!";
				break;
		}
	}
	
}

?>
</div>
<?php include('../includes/mcir.nav.inc.php'); ?>
</body>
</html>
