<?php 

$host       = '???';
$username   = '???';
$password   = '???';
$dbname     = 'subscriptiondb';
$dsn        = "mysql:host=$host;dbname=$dbname";
$options    = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
