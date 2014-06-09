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
<title>XSSmh - Cross-Site Scripting</title>
<link rel="stylesheet" type="text/css" href="../includes/mcir.css">
</head>
<body>
<center><h1>XSSmh - Cross-Site Scripting</h1></center><br>
<?php
include('includes/nav.inc.php');
include('../includes/options.inc.php');
?>
	<tr><td>Injection Location:</td><td>
		<select name="location">
			<option value="body">Body</option>
			<option value="attribute_single" <?php if(isset($_REQUEST["location"]) and $_REQUEST["location"]=="attribute_single") echo "selected"; ?>>Attribute value (wrapped in single quotes)</option>
			<option value="attribute_double" <?php if(isset($_REQUEST["location"]) and $_REQUEST["location"]=="attribute_double") echo "selected"; ?>>Attribute value (wrapped in double quotes)</option>
			<option value="attribute_noquotes" <?php if(isset($_REQUEST["location"]) and $_REQUEST["location"]=="attribute_noquotes") echo "selected"; ?>>Attribute value (not wrapped in quotes)</option>
			<option value="image_src" <?php if(isset($_REQUEST["location"]) and $_REQUEST["location"]=="image_src") echo "selected"; ?>>Image URL</option>
			<option value="javascript" <?php if(isset($_REQUEST["location"]) and $_REQUEST["location"]=="javascript") echo "selected"; ?>>JavaScript</option>
		</select></td></tr>
		<tr><td>Custom HTML (*INJECT* specifies injection point):</td><td><textarea name="custom_inject"><?php echo (isset($_REQUEST['custom_inject']) ? htmlentities($_REQUEST['custom_inject']) : '' ); ?></textarea></td></tr>
	<tr><td>Persistent?</td><td><input type='checkbox' name='persistent' <?php echo (isset($_REQUEST['persistent']) ? 'checked' : ''); ?>>
	</table>
	<input type="submit" id="submit" name="submit" value="Inject!">
</form>
<div id="results">

<?php
if(isset($_REQUEST['submit'])){
	$base_output = 'Foo! <img src="baz.jpg"><input type="text" value="bar!"><script>a="javascript";</script>';
	
	//environmental factors
	include('../includes/environ.inc.php');
	//sanitization section
	include('../includes/sanitize.inc.php');
	
	if (isset($_REQUEST['custom_inject']) and $_REQUEST['custom_inject']!=''){
		$output = str_replace('*INJECT*', $_REQUEST['inject_string'], $_REQUEST['custom_inject']);
		$display_output = str_replace('*INJECT*', 'UNDERLINEME'.$_REQUEST['inject_string'].'UNDERLINEMEEND', $_REQUEST['custom_inject']);
	}else{
		switch ($_REQUEST['location']){
			case 'body':
				$output = str_replace('Foo!', $_REQUEST['inject_string'], $base_output);
				$display_output = str_replace('Foo!', 'UNDERLINEME'.$_REQUEST['inject_string'].'UNDERLINEMEEND', $base_output);
				break;
			case 'attribute_single':
				$output = str_replace('"bar!"', '\''.$_REQUEST['inject_string'].'\'', $base_output);
				$display_output = str_replace('"bar!"', '\''.'UNDERLINEME'.$_REQUEST['inject_string'].'UNDERLINEMEEND'.'\'', $base_output);
				break;
			case 'attribute_double':
				$output = str_replace('bar!', $_REQUEST['inject_string'], $base_output);
				$display_output = str_replace('bar!', 'UNDERLINEME'.$_REQUEST['inject_string'].'UNDERLINEMEEND', $base_output);
				break;
			case 'attribute_noquotes':
				$output = str_replace('"bar!"', $_REQUEST['inject_string'], $base_output);
				$display_output = str_replace('"bar!"', 'UNDERLINEME'.$_REQUEST['inject_string'].'UNDERLINEMEEND', $base_output);
				break;
			case 'image_src':
				$output = str_replace('baz.jpg', $_REQUEST['inject_string'], $base_output);
				$display_output = str_replace('baz.jpg', 'UNDERLINEME'.$_REQUEST['inject_string'].'UNDERLINEMEEND', $base_output);
				break;
			case 'javascript':
				$output = str_replace('javascript', $_REQUEST['inject_string'], $base_output);
				$display_output = str_replace('javascript', 'UNDERLINEME'.$_REQUEST['inject_string'].'UNDERLINEMEEND', $base_output);
				break;
		}
	}
	
	if (isset($_REQUEST['show_query']) and $_REQUEST['show_query']!=''){
		$tokens = array('UNDERLINEMEEND','UNDERLINEME');
		$replacements = array('</u>','<u>');
		$display_output = str_replace($tokens, $replacements, htmlentities($display_output));
		echo '<b>Payload in context (payload is <u>underlined</u>):<br>'.$display_output.'<br><br>';
	}

	if(isset($_REQUEST['persistent'])){
	
		$fhandle = fopen('pxss.html','w') or die('Whoops! Can\'t write to our PXSS file. Did you run setup.sh?');
		fwrite($fhandle, $output);
		fclose($fhandle);
	
		echo "<a href='pxss.html'>See the output</a>";
		
	}else{
		
		echo '<b>Output:</b><br>' . $output;
	
	}
	
}

?>
</div>
<?php include('../includes/mcir.nav.inc.php'); ?>
</body>
</html>
