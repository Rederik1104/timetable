<?php
    $building = htmlentities($_POST["building"]);
    $room = htmlentities($_POST["number"]);
    $description = htmlentities($_POST["discription"]);

    $dbconfig['host'] = 'localhost';
    $dbconfig['user'] = 'root';
    $dbconfig['base'] = 'login';
    $dbconfig['pass'] = '';
    $dbconfig['char'] = 'utf8';
                            
    try {
        $pdo = new
        PDO('mysql:host='.$dbconfig['host'].';dbname='.$dbconfig['base'].';charset='.$dbconfig['char'].';',
        $dbconfig['user'], $dbconfig['pass']);
    }
    catch(PDOException $e) {
        exit('Unable to connect Database.');
    }

    $sql = "INSERT INTO room (building, room, description) VALUES (:building, :room, :discription)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':building', $building);
    $stmt->bindParam(':room', $room);
    $stmt->bindParam(':discription', $description);
    if($stmt->execute()){
        header("Location: infos.php");
    }



?>