<?php
    if($_POST["email1"] == $_POST["email2"]){

        session_start();
        $userID = $_SESSION["userID"];
        $newEmail = $_POST["email1"];

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

        $emailChange = "UPDATE users SET email = :newEmail WHERE id = :id";
        $stmt = $pdo->prepare($emailChange);
        $stmt->bindParam(":newEmail", $newEmail);
        $stmt->bindParam(":id", $userID);
        if($stmt->execute()){
            header("Location: user.php"); 
        }
    }
    else
    {
        header("Location: user.php");
    }
    
?>