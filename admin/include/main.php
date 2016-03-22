<?php
require_once('config.php');
require_once('classes/MysqliDb.php');
require_once('functions.php');
error_reporting(E_ALL);

$db = new Mysqlidb(DB_HOST, DB_USER, DB_PASS, DB_NAME);
require_once('auth.php');

?>