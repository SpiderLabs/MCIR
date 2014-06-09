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
<title>XMLmao - XML Injection</title>
<link rel="stylesheet" type="text/css" href="../includes/mcir.css">
</head>
<body>
<center><h1>XMLmao - XML Injection</h1></center><br>

<?php
include('includes/nav.inc.php');
include('../includes/options.inc.php');
?>
	<tr><td>Injection Location:</td><td>
		<select name="location">
			<option value="attribute">Attribute</option>
			<option value="value" <?php echo (isset($_REQUEST['location']) and $_REQUEST['location']=='value') ? 'selected' : ''; ?>>Node Value</option>
			<option value="cdatavalue" <?php echo (isset($_REQUEST['location']) and $_REQUEST['location']=='cdatavalue') ? 'selected' : ''; ?>>CDATA-wrapped Value</option>
			<option value="header_value" <?php echo (isset($_REQUEST['location']) and $_REQUEST['location']=='header_value') ? 'selected' : ''; ?>>Header Value</option>
		</select></td></tr>
		<tr><td>Custom XML (*INJECT* specifies injection point):</td><td><textarea name="custom_inject"><?php echo (isset($_REQUEST['custom_inject']) ? htmlentities($_REQUEST['custom_inject']) : '' ); ?></textarea></td></tr>
		<tr><td><b>Parser options:</b></td></tr>
                <tr><td>Load external DTD?</td><td><input type='checkbox' name='ext_dtd' <?php echo (isset($_REQUEST['ext_dtd']) ?'checked' : ''); ?>></td></tr>
                <tr><td>Validate with the DTD?</td><td><input type='checkbox' name='valid_dtd' <?php echo (isset($_REQUEST['valid_dtd']) ?'checked' : ''); ?>></td></tr>
                <tr><td>Substitute entities?</td><td><input type='checkbox' name='subs_ent' <?php echo (isset($_REQUEST['subs_ent']) ?'checked' : ''); ?>></td></tr>
                <tr><td>Enable XInclude?</td><td><input type='checkbox' name='xinclude' <?php echo (isset($_REQUEST['xinclude']) ? 'checked' : ''); ?>></td></tr>
	</table>
	<input type="submit" id="submit" name="submit" value="Inject!">
</form>
<div id="results">

<?php
$xmldata = '<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE xmlfile [  
<!ENTITY author "Inject4" > ]>
<xmlfile>
 <hooray attrib="Inject2">
  <ilovepie>Inject1</ilovepie>
 </hooray>
 <data>
	<![CDATA[Inject3]]>
 </data>
</xmlfile>
';

if(isset($_REQUEST['submit'])){

	include_once('../includes/sanitize.inc.php');
	include_once('../includes/environ.inc.php');

	if (isset($_REQUEST['custom_inject']) and $_REQUEST['custom_inject']!=''){
		$displayxml = nl2br(str_replace('*INJECT*', '<u>' . htmlentities($_REQUEST['inject_string']) . '</u>', htmlentities($_REQUEST['custom_inject'])));
		$xmldata = str_replace('*INJECT*', $_REQUEST['inject_string'], $_REQUEST['custom_inject']);
	}else{
		switch($_REQUEST['location']){
			case 'attribute':
				$displayxml = str_replace('Inject2', '<u>'.htmlentities($_REQUEST['inject_string']).'</u>', htmlentities($xmldata));
				$xmldata = str_replace('Inject2', $_REQUEST['inject_string'], $xmldata);
				break;
			case 'value':
				$displayxml = str_replace('Inject1', '<u>'.htmlentities($_REQUEST['inject_string']).'</u>', htmlentities($xmldata));
				$xmldata = str_replace('Inject1', $_REQUEST['inject_string'], $xmldata);
				break;
			case 'cdatavalue':
				$displayxml = str_replace('Inject3', '<u>'.htmlentities($_REQUEST['inject_string']).'</u>', htmlentities($xmldata));
				$xmldata = str_replace('Inject3', $_REQUEST['inject_string'], $xmldata);
				break;
			case 'header_value':
				$displayxml = str_replace('Inject4', '<u>'.htmlentities($_REQUEST['inject_string']).'</u>', htmlentities($xmldata));
				$xmldata = str_replace('Inject4', $_REQUEST['inject_string'], $xmldata);
				break;
			default:
				$displayxml = str_replace('Inject2', '<u>'.htmlentities($_REQUEST['inject_string']).'</u>', htmlentities($xmldata));
				$xmldata = str_replace('Inject2', $_REQUEST['inject_string'], $xmldata);
				break;
		}
		$displayxml = nl2br($displayxml, false);
	}
	
	if(isset($_REQUEST['show_query']) and $_REQUEST['show_query'] == 'on') echo "<b>Resulting XML:</b><br>" . $displayxml . '<br><br>';
	
	$xmloptions = 0;
	
	//Enable external DTD loading if the option is on
	if(isset($_REQUEST['ext_dtd']) and $_REQUEST['ext_dtd'] == 'on') $xmloptions = $xmloptions | LIBXML_DTDLOAD;

        //Validate with the DTD if the option is on
        if(isset($_REQUEST['valid_dtd']) and $_REQUEST['valid_dtd'] == 'on') $xmloptions = $xmloptions | LIBXML_DTDVALID;
 
        //Substitute entities if the option is on
        if(isset($_REQUEST['subs_ent']) and $_REQUEST['subs_ent'] == 'on') $xmloptions = $xmloptions | LIBXML_NOENT;

	$xml = '';

	if(isset($_REQUEST['error_level'])){
		switch ($_REQUEST['error_level']){
			case 'generic':
				ini_set('display_errors', 0);
				$xml = simplexml_load_string($xmldata,'SimpleXMLElement',$xmloptions);
				if($results == FALSE) echo "<b>Errors:</b><br>An error occurred.<br>";
				break;
			case 'verbose':
				ini_set('display_errors', 1);
				$xml = simplexml_load_string($xmldata,'SimpleXMLElement',$xmloptions);
				break;
			case 'none':
				ini_set('display_errors', 0);
				$xml = simplexml_load_string($xmldata,'SimpleXMLElement',$xmloptions);
				break;
		}
	}
	
	//Hack to get XInclude working since SimpleXML doesn't REALLY do xinclude
	//Despite an option which would suggest it does
	if(isset($_REQUEST['xinclude']) and $_REQUEST['xinclude']=='on'){
		$dom = dom_import_simplexml($xml);
		$dom->ownerDocument->xinclude();
		
		$xml = simplexml_import_dom($dom);
	}

	switch ($_REQUEST['query_results']){
		case 'all_rows':
			echo '<b>Results:</b>';
			foreach ($xml->data as $data){
				echo '<br>'.$data;
			}
			break;
		case 'one_row':
			echo '<b>Results:</b><br>';
			echo $xml->data[0];
			break;
		case 'bool':
			if ($xml->data[0] != FALSE) echo 'Got results!';
			break;
	}
}
?>
</div>
<?php include('../includes/mcir.nav.inc.php'); ?>
</body>
</html>
