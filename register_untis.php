<?php
    session_start();
    //$key = isset($_SESSION['encryption_key']) ? $_SESSION['encryption_key'] : null;

    include("database.php");
    $sql = "SELECT * FROM users";
    $stmt = $pdo->query($sql);
    while($row = $stmt->fetch()){
        if($row['username'] == $_GET['username']){
            $_SESSION['userID'] = $row['id'];
            $_SESSION['untisLogin'] = true;
            header("Location: infos.php");
            exit();
        }
    }

    $username = $_GET['username'];
    $password = $_GET['password'];
    $server = $_GET['server'];
    //$school = $_GET['school'];
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users(username, email, password) VALUES(:username, :email, :password)");
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $password_hash);
    $stmt->bindParam(":email", $server);
    if($stmt->execute()){
        $_SESSION['untisLogin'] = true;

        $sql = "SELECT * FROM users";
        $stmt = $pdo->query($sql);
        while($row = $stmt->fetch()){
            if($row['username'] == $username){
                $_SESSION['userID'] = $row['id'];
            }
        }
        header("Location: infos.php");
        exit();
    }

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
<script>
    //const key = "<?php echo $key; ?>";
    // Verschlüsselte Daten aus dem localStorage abrufen
    //const encryptedTimetable = localStorage.getItem("timetable");

    //if (encryptedTimetable) {
    // Verschlüsselten Wert entschlüsseln
    //const decryptedBytes = CryptoJS.AES.decrypt(encryptedTimetable, key);
    //const decryptedTimetable = JSON.parse(decryptedBytes.toString(CryptoJS.enc.Utf8));

    //console.log("Entschlüsselter Stundenplan:", decryptedTimetable);
    //}
</script>
