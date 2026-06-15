
<?php

$usuarios = [
    'lmr', // Laura Medina Ruiz
    'arg', // Antonio Romero Gil
    'msl', // Marta Sánchez León
    'dtv', // Daniel Torres Vega
    'com', // Carmen Ortega Martín
    'jnd', // Javier Navarro Díaz
    'ecp', // Elena Cruz Pérez
    'smc', // Sergio Molina Castro
    'nhs', // Nuria Herrera Soto
    'pjr'  // Pablo Jiménez Ríos
];

foreach ($usuarios as $password) {
    echo $password . ' => ' . password_hash($password, PASSWORD_DEFAULT) . PHP_EOL;
}

