<?php
declare(strict_types=1);

ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/phpErrors.txt');
error_reporting(E_ALL);

header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);

require './components/db.php';

