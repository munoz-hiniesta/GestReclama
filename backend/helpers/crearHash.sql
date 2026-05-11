<?php
$password = "003";

$hash = password_hash($password, PASSWORD_DEFAULT);

echo $hash . PHP_EOL;