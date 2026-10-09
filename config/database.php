<?php
$host = 'localhost';
$port = '5432';
$dbname = 'php_login';
$username = 'dev_user';
$password = 'M0nG10b3INV';

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

$pdo = new PDO($dsn, $username, $password);

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);