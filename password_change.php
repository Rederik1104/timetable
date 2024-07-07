<?php
session_start();
$oPass = $_POST['oPass'];
$nPass = $_POST['nPass'];
$userID = $_SESSION['userID'];

include("database.php");
$sql = $pdo->prepare("SELECT password FROM users WHERE id = :id");
$sql->bindParam(":id", $userID);
$sql->execute();
$row = $sql->fetch();

if(password_verify($oPass, $row['password'])){
    $passHash = password_hash($nPass, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
    $stmt->bindParam(":password", $passHash);
    $stmt->bindParam(":id", $userID);

    if($stmt->execute()){
        header("Location: user.php");
    }
    
}else{
    echo "password is false!";
    header("Location: user.php");
    exit();
}
