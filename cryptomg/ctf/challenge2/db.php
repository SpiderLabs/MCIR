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

include("../../includes/db.inc.php");
$db_name = "cryptomg";

$admin_password = encode(encrypt("Cru@UJUbet69YePejEwr", $cipher, $mode, $key, $iv), 4);
$guest_password = encode(encrypt("guest", $cipher, $mode, $key, $iv), 4);

$create_table_users = "CREATE TABLE IF NOT EXISTS challenge2_users (
			id INT NOT NULL PRIMARY KEY,
			username VARCHAR(32),
			password VARCHAR(64));";
$query_create_table = mysql_query($create_table_users);

$create_table_articles = "CREATE TABLE IF NOT EXISTS challenge2_articles (
						id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
						title VARCHAR(32),
						content VARCHAR(728))";
						
$query_create_table_articles = mysql_query($create_table_articles);


$insert_test_users = "INSERT INTO challenge2_users (id, username, password)
			VALUES(1, 'admin', '$admin_password'),
			      (2, 'guest', '$guest_password')";
$query_insert_data = mysql_query($insert_test_users);

$content = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis 
mollis egestas mattis. Vestibulum mattis ullamcorper ligula, eu hendrer
it velit hendrerit nec. Nulla facilisi. Donec pellentesque interdum sem 
sit amet vulputate. Suspendisse aliquam faucibus ipsum, non consequat 
ipsum semper eget. Nam laoreet odio vitae tortor pellentesque non 
facilisis eros ultricies. Class aptent taciti sociosqu ad litora torquent 
per conubia nostra, per inceptos himenaeos. Vivamus metus neque, ornare 
eu tristique quis, malesuada nec ipsum. Duis sed metus libero, a molestie 
velit. Fusce id mi ligula, ut molestie eros. Quisque vulputate tellus commodo 
justo luctus sodales. Donec massa enim, hendrerit non adipiscing quis, 
gravida ac mauris.";

$insert_test_articles = "INSERT INTO challenge2_articles (id, title, content)
							VALUES";
for($i=1; $i<11; $i++)
	$insert_test_articles .= " ($i, 'Article $i', '$content'), ";
$insert_test_articles = substr($insert_test_articles, 0, strlen($insert_test_articles)-2);
mysql_query($insert_test_articles);

?>
