<?php

    $roomID = $_GET["roomID"];
    include("database.php");
    $delete = $pdo->query("DELETE FROM room WHERE roomID = $roomID");

    if($delete){
        header("Location: infos.php");
    }
