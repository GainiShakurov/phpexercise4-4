<?php

$dbType = "mysql";
$host = 'localhost';
$user = 'shakurov';
$password = 'neto1748';
$db = 'shakurov';
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$connect = new PDO($dbType.':host='.$host.';dbname='.$db.';charset=utf8', $user, $password, $opt);