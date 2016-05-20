<?php
include('adodb.inc.php');

$db = adonewconnection('mysqli');
$db->connect('localhost', 'root', 'C0yote71', 'mantis_13x');

$t = 'mantis_user_table';
$c = array('username' => 'test');
print $db->getinsertsql($t, $c) . PHP_EOL;
