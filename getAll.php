<?php
include("database.php");
session_start();
$createdBy = $_SESSION['userID'];

try {
    $sql = $pdo->prepare("SELECT name FROM teacher WHERE createdBy = :createdBy UNION SELECT subject_name FROM subject UNION SELECT concat(building, room)  FROM room WHERE createdBY = :createdBy");
    $sql->bindParam(":createdBy", $createdBy);
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}