<?php
    session_start();
    $dsn = "mysql:dbname=erik;host=Content.goatserver.de";
    $username = "erik";
    $password = "erik.Goatserver";
    $con = new PDO($dsn, $username, $password);

    if(isset($_POST["submit"])){
        $usern = $_POST["username"];
        $usern = strval($usern);
        $email = $_POST["email"];
        $password = PASSWORD_HASH($_POST["password"], PASSWORD_DEFAULT);

        $sql = $con->prepare("SELECT id FROM users WHERE username=:username;");
        $sql->bindParam(":username", $usern);
        $sql->execute();
        $userAlreadyExists = $sql->fetch();
        if(!$userAlreadyExists){
            //Registrieren
            registerUser(strtolower($usern), $email, $password);
        }
        else{
            //Users existiert bereits
            header("Location: register_failure.php");
            exit();
        }
    
    }

    function registerUser($usern, $email, $password){
        global $con;
        $stmt = $con->prepare("INSERT INTO users(username, email, password) VALUES(:username, :email, :password)");
        $stmt->bindParam(":username", $usern);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam("password", $password);
        $stmt->execute();
        header("Location: login.php");
        exit();
    }

    if(isset($_SESSION['userData'])){
        include("database.php");
        $nEmail = $_SESSION['userData']['email'];
        $name = $_SESSION['userData']['given_name'];
        $pass = $_SESSION['userData']['kid'];
        $stmt = $pdo->query("SELECT * FROM users");
        while($row = $stmt->fetch()){
            if($row['username'] == $name && $row['email'] == $nEmail && $row['password'] == $pass){
                $_SESSION["userID"] = $row['id'];
                header("Location: infos.php");
                exit();
            }
        }
        $sql = $pdo->prepare("INSERT INTO users(username, email, password) VALUES(:username, :email, :password)");
        $sql->bindParam(":username", $name);
        $sql->bindParam(":email", $nEmail);
        $sql->bindParam("password", $pass);
        if($sql->execute()){
            $stmt = $pdo->query("SELECT * FROM users");
            while($row = $stmt->fetch()){
                if($name == $row['username'] && $pass == $row['password']){
                    $userID = $row['id'];
                    break;
                }
            }
            $_SESSION["userID"] = $userID;
            header("Location: infos.php");
            exit();
        }
    }

?>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrieren</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <form action="index.php" method="POST">
        <h1>Create Account</h1>
        <div class="inputs_container">
            <input type="text" placeholder="Benutzername" name="username" autocomplete="off">
            <input type="text" placeholder="Email" name="email" autocomplete="off">
            <input type="password" placeholder="Passwort" name="password" autocomplete="off">
        </div>
        <button name="submit">Create</button>
        <a href="login.php" style="
            color:white;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 19px;
            background-image: linear-gradient(to right, rgb(162,0,255), rgb(74,15,236));
            background-size: 100% 4px;
            background-position: bottom;
            background-repeat: no-repeat;
            line-height: 30px;
            text-decoration: none;
        ">Login</a>
        <a href="google/redirect.php"  style="
            color:white;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 19px;
            background-image: linear-gradient(to right, rgb(162,0,255), rgb(74,15,236));
            background-size: 100% 4px;
            background-position: bottom;
            background-repeat: no-repeat;
            line-height: 30px;
            text-decoration: none;
            text-align:center;
            align-items:center;
        ">Login with Google</a> 
    </form>
    
</body>
</html>