<?php
    $dsn = "mysql:dbname=erik;host=Content.goatserver.de";
    $username = "erik";
    $password = getenv('DB_PASSWORD');
    $con = new PDO($dsn, $username, $password);

    if(isset($_POST["submit"])){
        var_dump($_POST);
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
    <form action="register_failure.php" method="POST">
        <h1>Account Erstellen</h1>
        <div class="inputs_container">
            <input type="text" placeholder="username not available" name="username" autocomplete="off">
            <input type="text" placeholder="Email" name="email" autocomplete="off">
            <input type="password" placeholder="Passwort" name="password" autocomplete="off">
        </div>
        <button name="submit">Erstellen</button>
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
        ">zum Login</a>
        
    </form>
    
</body>
</html>