<?php
    include("database.php");
    $id = $_GET['subjectID'];

    $sql = $pdo->query("SELECT * FROM subject");
    while($row = $sql->fetch()){
        if($row['ID'] == $id){
            if($row['editable'] == 1){
                $sql = $pdo->prepare("DELETE FROM subject WHERE ID = :id");
                $sql->bindParam(":id", $id);
                if($sql->execute()){
                    header("Location: infos.php");
                    exit();
                }
            }
        }
    }

?>