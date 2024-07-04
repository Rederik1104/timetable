<?php
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// Create a new Dotenv instance
$dotenv = Dotenv::createUnsafeImmutable(__DIR__);

// Load the environment variables
$dotenv->load();
$dbconfig['host'] = 'Content.goatserver.de';
$dbconfig['user'] = 'erik';
$dbconfig['base'] = 'erik';
$dbconfig['pass'] = getenv('DB_PASSWORD');
$dbconfig['char'] = 'utf8';
              
try {
  $pdo = new
  PDO('mysql:host='.$dbconfig['host'].';dbname='.$dbconfig['base'].';charset='.$dbconfig['char'].';',
  $dbconfig['user'], $dbconfig['pass']);
}
catch(PDOException $e) {
  exit('Unable to connect Database.');
}


?>