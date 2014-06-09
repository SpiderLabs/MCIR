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
<title>XMLmao - XSLT Injection</title>
<link rel="stylesheet" type="text/css" href="../includes/mcir.css">
</head>
<body>
<center><h1>XMLmao - XSLT Injection</h1></center><br>

<?php
include('includes/nav.inc.php');
include('../includes/options.inc.php');
?>
	<tr><td><b>XSL processor options:</b></td></tr>
	<tr><td><small><i>XSL processor specific options</i></small></td></tr>
	<tr><td>Enable PHP functions?</td><td><input type="checkbox" name="php_funcs" <?php if(isset($_REQUEST["php_funcs"])) echo "checked"; ?> ></td></tr>
	<tr><td><br/></td><td></td></tr>
	<tr><td><b>Injection Location:</b></td><td>
		<select name="location">
			<option value="content">Static content in output</option>
			<option value="row" <?php echo (isset($_REQUEST['location']) and $_REQUEST['location']=='row') ? 'selected' : ''; ?>>Name of field to retrieve from XML</option>
		</select></td></tr>
		<tr><td>Custom XSL document (*INJECT* specifies injection point):</td><td><textarea name="custom_inject"><?php echo isset($_REQUEST['custom_inject']) ? htmlentities($_REQUEST['custom_inject']) : ''; ?></textarea></td></tr>
	<tr><td><br/></td><td></td></tr>
	</table>
	<input type="submit" id="submit" name="submit" value="Inject!">
</form>
<div id="results">

<?php
if(isset($_REQUEST['submit'])){
	$xml = new DOMDocument;
	$xml->load('data.xml');

	$xsl = new DOMDocument;
	
	$xsl_string =
	'<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:php="http://php.net/xsl">
	<xsl:template match="/">
	<b>Inject1</b>
	<table><tr><td>ID</td><td>USERNAME</td></tr>
	<xsl:for-each select="xmlfile/users/user">
		<tr>
			<td><xsl:value-of select="id"/></td>
			<td><xsl:value-of select="username"/></td>
		</tr>
	</xsl:for-each>
	</table>
	</xsl:template>
	</xsl:stylesheet>';
	
	include_once('../includes/sanitize.inc.php');
	include_once('../includes/environ.inc.php');
	
	if (isset($_REQUEST['custom_inject']) and $_REQUEST['custom_inject']!=''){
		
		$display_xsl_string = str_replace('*INJECT*', 'START_PAYLOAD' . $_REQUEST['inject_string'] . 'END_PAYLOAD', $_REQUEST['custom_inject']);
		$xsl_string = str_replace('*INJECT*', $_REQUEST['inject_string'], $_REQUEST['custom_inject']);
		
	}else{
		
		switch ($_REQUEST['location']){
			case 'content':
				$display_xsl_string = str_replace('Inject1', 'START_PAYLOAD' . $_REQUEST['inject_string'] . 'END_PAYLOAD', $xsl_string);
				$xsl_string = str_replace('Inject1', $_REQUEST['inject_string'], $xsl_string);
				break;
			case 'row':
				$display_xsl_string = str_replace('username', 'START_PAYLOAD' . $_REQUEST['inject_string'] . 'END_PAYLOAD', $xsl_string);
				$xsl_string = str_replace('username', $_REQUEST['inject_string'], $xsl_string);
				break;
		}
		
	}
	
	$processor = new XSLTProcessor;
	if(isset($_REQUEST['php_funcs'])){
		$processor->registerPHPFunctions();
	}



	if(isset($_REQUEST['error_level'])){
		switch ($_REQUEST['error_level']){
			case 'generic':
				ini_set('display_errors', 0);
				$xsl->loadXML($xsl_string);
				$processor->importStyleSheet($xsl);
				$output = $processor->transformToXML($xml);
				if($output == FALSE) echo "<b>An error occurred.</b>" . "\n<br>";
				break;
			case 'verbose':
				ini_set('display_errors', 1);
				$xsl->loadXML($xsl_string);
				$processor->importStyleSheet($xsl);
				$output = $processor->transformToXML($xml);
				break;
			case 'none':
				ini_set('display_errors', 0);
				$xsl->loadXML($xsl_string);
				$processor->importStyleSheet($xsl);
				$output = $processor->transformToXML($xml);
				break;
		}
	}
	
	if(isset($_REQUEST['show_query'])){
		echo "<b>Payload in context</b><br/>";
		$markers = array('START_PAYLOAD','END_PAYLOAD');
		$replacements = array('<u>','</u>');
		echo str_replace(
			$markers,
			$replacements,
			nl2br(
				htmlentities($display_xsl_string)
			)
		    ) . '<br/>';
	}

	if($output){
		switch($_REQUEST['query_results']){
			case 'all_rows':
				echo '<b>Results:</b><br/>';
				echo $output;
				break;
			case 'one_row':
				echo '<b>Results:</b><br/>';
				echo "This level of output verbosity does not make sense in the context of XSLT injection. Providing full output.\n<br>";
				echo $output;
				break;
			case 'bool':
				echo '<b>Results:</b><br/>';
				echo "This level of output verbosity does not make sense in the context of XSLT injection. Providing full output.\n<br>";
				echo $output;
				break;
		}
	}
	
}

?>
</div>
<?php include('../includes/mcir.nav.inc.php'); ?>
</body>
</html>
