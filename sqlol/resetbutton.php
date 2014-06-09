<?php
/*
Magical Code Injection Rainbow - A set of configurable injection testbeds 
Daniel "unicornFurnace" Crowley
Copyright (C) 2014 Trustwave Holdings, Inc.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

include_once('includes/adodb/adodb.inc.php');
include('includes/database.config.php');

$dsn = $dbtype.'://'.$hostspec;
$db_conn = NewADOConnection($dsn);

if(!$db_conn) die ('Could not connect to database. Did you edit includes/database.config.php?');

$db_conn->Execute('drop database ' . $database);
$db_conn->Execute('create database ' . $database);

$db_conn->Close();

$dsn = $dbtype.'://'.$hostspec.'/'.$database;
$db_conn = NewADOConnection($dsn);
$datadict = NewDataDictionary($db_conn, $dbtype);

if(!$db_conn) die ('Could not connect to database.');

$table_def1 = "
 username C(50),
 isadmin I DEFAULT 0,
 id I AUTOINCREMENT PRIMARY
";
$table_def2 = "
 name C(50),
 ssn C(11) PRIMARY
";

if($dbtype == 'sqlite'){
	$sqlarray = $datadict->DropTableSQL('users');
	$datadict->ExecuteSQLArray($sqlarray);
	$sqlarray = $datadict->DropTableSQL('ssn');
	$datadict->ExecuteSQLArray($sqlarray);	
}

$sqlarray = $datadict->CreateTableSQL('users', $table_def1);
$execute_status = $datadict->ExecuteSQLArray($sqlarray);
if( $execute_status == 0) {
	print_r($sqlarray);
	die('Could not create table "users", execute failed.<br>');
} elseif ($execute_status == 1) {
	print_r($sqlarray);
	die('Could not create table "users", execute succeeded with errors.<br>'.$db_conn->ErrorMsg());
}

$sqlarray = $datadict->CreateTableSQL('ssn', $table_def2);
$execute_status = $datadict->ExecuteSQLArray($sqlarray);
if( $execute_status == 0) {
	print_r($sqlarray);
	die('Could not create table "ssn", execute failed.<br>');
} elseif ($execute_status == 1) {
	print_r($sqlarray);
	die('Could not create table "ssn", execute succeeded with errors.<br>'.$db_conn->ErrorMsg());
}

$db_conn->Execute("insert into users (username, isadmin) values ('Herp Derper', 1)");
$db_conn->Execute("insert into users (username, isadmin) values ('SlapdeBack LovedeFace', 1)");
$db_conn->Execute("insert into users (username, isadmin) values ('Wengdack Slobdegoob', 0)");
$db_conn->Execute("insert into users (username, isadmin) values ('Chunk MacRunfast', 0)");
$db_conn->Execute("insert into users (username, isadmin) values ('Peter Weiner', 0)");

$db_conn->Execute("insert into ssn (name, ssn) values ('Herp Derper', '012-34-5678')");
$db_conn->Execute("insert into ssn (name, ssn) values ('SlapdeBack LovedeFace', '999-99-9999')");
$db_conn->Execute("insert into ssn (name, ssn) values ('Wengdack Slobdegoob', '000-00-1112')");
$db_conn->Execute("insert into ssn (name, ssn) values ('Chunk MacRunfast', '666-67-6776')");
$db_conn->Execute("insert into ssn (name, ssn) values ('Peter Weiner', '111-22-3333')");

$db_conn->Close();

echo "Done!\n";

?>
