<?php
$dbconfig['host'] = 'Content.goatserver.de';
$dbconfig['user'] = 'erik';
$dbconfig['base'] = 'erik';
$dbconfig['pass'] = 'erik.Goatserver';
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