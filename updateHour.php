<?php
session_start();
include("database.php");

$id = $_SESSION["userID"];

$sql = $pdo->prepare("SELECT * FROM hourLength WHERE createdBy = :id");
$sql->bindParam(":id", $id);

if($sql->execute() && $sql->rowCount() > 0){
    $sql = $pdo->prepare("UPDATE hourLength SET length = :hourLength WHERE id = :id");
    $sql->bindParam(":hourLength", $_POST["hour"]);
    $sql->bindParam(":id", $id);
} else {
    $sql = $pdo->prepare("INSERT INTO hourLength(length, createdBy) VALUES(:hourLength, :id)");
    $sql->bindParam(":hourLength", $_POST["hour"]);
    $sql->bindParam(":id", $id);
}

if($sql->execute()){
    echo json_encode(array("success" => true));
} else {
    echo json_encode(array("success" => false));
}


