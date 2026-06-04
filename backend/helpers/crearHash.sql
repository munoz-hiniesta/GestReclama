<?php
$password = "002";

$hash = password_hash($password, PASSWORD_DEFAULT);

echo $hash . PHP_EOL;