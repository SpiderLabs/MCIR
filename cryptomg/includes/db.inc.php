<?php
/*
CryptOMG - A configurable CTF style test bed.
Andrew Jordan
Copyright (C) 2012 Trustwave Holdings, Inc.

This program is free software: you can redistribute it and/or modify it 
under the terms of the GNU General Public License as published by the 
Free Software Foundation, either version 3 of the License, or (at your 
option) any later version.

This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of 
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General 
Public License for more details.

You should have received a copy of the GNU General Public License along 
with this program. If not, see <http://www.gnu.org/licenses/>.
*/

$db_host = "localhost";
$db_user = "";
$db_pass = "";
$db_name = "cryptomg";

$link = mysql_connect($db_host, $db_user, $db_pass);
if(!$link)
	die("database error");

mysql_query("CREATE DATABASE IF NOT EXISTS $db_name");
$db_select = mysql_select_db($db_name, $link);
if(!$db_select)
	die("can't select database");
?>
