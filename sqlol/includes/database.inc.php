<?php
/*
Magical Code Injection Rainbow - A set of configurable injection testbeds 
Daniel "unicornFurnace" Crowley
Copyright (C) 2014 Trustwave Holdings, Inc.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

include('database.config.php');
include_once('adodb/adodb.inc.php');

$dsn = $dbtype.'://'.$hostspec.'/'.$database.$persist;
$db_conn = NewADOConnection($dsn);

$_REQUEST = array_merge($_GET, $_POST, $_COOKIE);

if(isset($_REQUEST['show_query']) and $_REQUEST['show_query']=='on') echo "<b>Query (injection string is <u>underlined</u>):</b> <br>" . $displayquery . "\n<br><br>";

$db_conn->SetFetchMode(ADODB_FETCH_ASSOC);
$results = $db_conn->Execute($query);

if (!$results){
	$error = $db_conn->ErrorMsg();
	if(isset($_REQUEST['error_level']) and isset($error)){
		switch ($_REQUEST['error_level']){
			case 'generic':
				echo "<b>An error occurred.</b>" . "\n<br>";
				break;
			case 'verbose':
				echo "<b>Error:</b><br> " . $error . "\n<br>";
				break;
		}
	}	
} else {
	if(isset($_REQUEST['query_results'])) switch($_REQUEST['query_results']){
		case 'one_row':
			print('<b>Results:</b><br>');
			print_r($results->fields);
			print("\n<br>");
			break;
		case 'all_rows':
			print('<b>Results:</b><br>');
			while(!$results->EOF){
				print_r($results->fields);
				print("\n<br>");
				$results->MoveNext();
			}
			break;
		case 'bool':
			print('<b>Results:</b><br>');
			if(!$results->EOF) print "Got results!\n";
			break;
	}
}

if ($results) $results->Close();
if ($db_conn) $db_conn->Close();

?>
