<?php 
include 'config.php';
// Display errors in development mode
error_reporting(E_ALL);
ini_set('display_errors', 1);
$config['install_route'] = '/pruebas/framework';

$config['db_type'] = 'sqlite';
$config['db'] = 'sqlite:'.BASE.'db/database.sqlite';


$config['cache_active'] = false;
