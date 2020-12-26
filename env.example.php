<?php
$variables = [
    'DB_CONNECTION' => 'mysql',
    'DB_HOST' => 'localhost',
    'DB_PORT' => '3306',
    'DB_DATABASE' => 'ni1099597_2sql4',
    'DB_USERNAME' => 'developer',
    'DB_PASSWORD' => '',
];

foreach ($variables as $key => $value) {
    putenv("$key=$value");
}
