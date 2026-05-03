<?php
$password = "001";

$hash = password_hash($password, PASSWORD_DEFAULT);

echo $hash . PHP_EOL;