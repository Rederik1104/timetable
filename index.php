<?php
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

require_once __DIR__.'/../bootstrap.php';
    
if(empty($_GET['state']) || (isset($_SESSION['oauth2state'])) && $_GET['state'] !== $_SESSION['oauth2state']){
    if(isset($_SESSION['oauth2state'])){
        unset($_SESSION['oauth2state']);
    }
    die();
}
try{
    $accessToken = $provider->getAccessToken(
        'authorization_code',
        [
            'code' => $_GET['code']
        ]
        );
        $values = $accessToken->getValues();
        $jwt = $values['id_token'];
        $userData = file_get_contents("https://oauth2.googleapis.com/tokeninfo?id_token=".$jwt);
        $userData = json_decode($userData, true);
        $_SESSION['userData'] = $userData;
        echo "$userData";

}catch(Exception $e){
        
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
        <h1>Account Erstellen</h1>
        <div class="inputs_container">
            <input type="text" placeholder="Benutzername" name="username" autocomplete="off">
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
    <a href="google/redirect.php">Login mit google</a>
    
</body>
</html>