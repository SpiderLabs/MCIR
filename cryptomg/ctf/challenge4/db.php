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

include "../../includes/db.inc.php";

$sql_create_table =  "CREATE TABLE IF NOT EXISTS challenge4_users (
					id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					username VARCHAR(32),
					password VARCHAR(32),
					email VARCHAR(64))";
$query_create_table = mysql_query($sql_create_table) or die(mysql_error());

$sql_insert_data = "INSERT INTO challenge4_users (id, username, password, email)
										VALUES(1, 'admin', '".
										md5("@4rfhaOsd(#d4l;hp)")."', 
										'admin@example.org')";
@$query_insert_data = mysql_query($sql_insert_data);							

?>
