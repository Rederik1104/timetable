<?php
    session_start();
    include("database.php");
    $name = $_POST['name'];
    $color = $_POST['color'];

    $sql = $pdo->prepare("INSERT INTO subject(subject_name, color, editable, createdBy) VALUES(:subject_name, :color, 1, :createdBy)");
    $sql->bindParam(":subject_name", $name);
    $sql->bindParam(":color", $color);
    $sql->bindParam(":createdBy", $_SESSION['userID']);
    
    if($sql->execute()){
        header("Location: infos.php");
    }
    


?>