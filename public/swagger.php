<?php
chdir(dirname(__DIR__));
require 'vendor/autoload.php';
$swagger = \Swagger\scan('src/');
header('Content-Type: application/json');
echo $swagger;