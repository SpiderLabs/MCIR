<?php
//If you're installing the magical code injection rainbow, MySQL will be set up by default. Enter the username and password for the user you configured during MySQL setup below in the MySQL section.

/*
Magical Code Injection Rainbow - A set of configurable injection testbeds 
Daniel "unicornFurnace" Crowley
Copyright (C) 2014 Trustwave Holdings, Inc.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

//Choose the appropriate type of database here

//Choose me for MySQL
$dbtype = 'mysqli';
$server = '127.0.0.1';
$port = '3306';
$username = 'root';
$password = 'default_mcir_db_password';
$database = 'sqlol';
$persist = '';

$hostspec = $username.':'.$password.'@'.$server.':'.$port;


/*//Choose me for PostgreSQL
$dbtype = 'postgres';
$server = '127.0.0.1';
$port = '5432';
$username = 'postgres';
$password = 'postgres';
$database = 'sqlol';
$persist = '';

$hostspec = $username.':'.$password.'@'.$server.':'.$port;
*/

/*//Choose me for SQLite
$dbtype = 'sqlite';
$hostspec = urlencode('c:\path\to\sqlite.db');
$database = ''; //Keep this value set to null for SQLite
$persist = ''; //Don't persist, SQLite is bad at concurrent connections
*/

?>
