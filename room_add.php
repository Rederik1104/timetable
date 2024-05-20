<?php
    session_start();
    $building = htmlentities($_POST["building"]);
    $room = htmlentities($_POST["number"]);
    $description = htmlentities($_POST["discription"]);
    $userID = $_SESSION["userID"];

    include "database.php";

    $sql = "INSERT INTO room (building, room, description, createdBY) VALUES (:building, :room, :discription, :userID)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':building', $building);
    $stmt->bindParam(':room', $room);
    $stmt->bindParam(':discription', $description);
    $stmt->bindParam(':userID', $userID);
    if($stmt->execute()){
        header("Location: infos.php");
    }



?>