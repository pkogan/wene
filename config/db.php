<?php

$HOST = $_ENV['MYSQL_HOST'];
$DB_NAME = $_ENV['MYSQL_DATABASE'];
$DB_USER = $_ENV['MYSQL_USER'];
$DB_PASS = $_ENV['MYSQL_PASSWORD'];

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=' . $HOST . ';dbname=' . $DB_NAME,
    'username' => $DB_USER,
    'password' => $DB_PASS,
    'charset' => 'utf8',
];
