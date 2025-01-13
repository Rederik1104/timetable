<?php

// Prüfen, ob der Server auf Port 8081 läuft
$serverRunning = @fsockopen("localhost", 8081);

if (!$serverRunning) {
    // Prüfen, ob Node.js installiert ist, indem die Version abgefragt wird
    exec("node -v", $output, $nodeCheck);

    // Überprüfen, ob der Befehl erfolgreich ausgeführt wurde (Node.js vorhanden)
    if ($nodeCheck !== 0) {
        die("Fehler: Node.js ist nicht installiert oder nicht im PATH verfügbar. Bitte installieren Sie Node.js.");
    }

    // Versuch, den Server zu starten
    $startCommand = "node " . escapeshellarg(__DIR__ . "/server.js") . " > /dev/null 2>&1 &";
    exec($startCommand, $output, $returnCode);

    // Überprüfen, ob der Server erfolgreich gestartet wurde
    if ($returnCode === 0) {
        //echo "Server wurde erfolgreich gestartet.";
    } else {
        // Fehlerbehandlung, wenn der Server nicht gestartet werden konnte
        //echo "Fehler beim Starten des Servers. Überprüfen Sie die Logs.";
        // Logge die Fehlermeldungen in einer Log-Datei, um Fehler leichter nachzuvollziehen
        file_put_contents('server_start_error.log', "Fehler beim Starten von server.js: " . implode("\n", $output), FILE_APPEND);
    }
} else {
    //echo "Der Server läuft bereits auf Port 8081.";
    fclose($serverRunning); // Schließe die Verbindung zum offenen Port
}

?>


<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with Untis</title>
    <link rel="stylesheet" href="login.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
</head>
<body>
    <form id="loginForm">
        <h1 id="title">Login with Untis</h1>
        <div class="inputs_container">
            <input type="text" placeholder="Benutzername" name="username" autocomplete="off" id="username">
            <input type="password" placeholder="Passwort" name="password" autocomplete="off" id="password">
            <input type="text" placeholder="school" name="school" autocomplete="off" id="school">
            <input type="text" placeholder="server" name="server" autocomplete="off" id="server">
        </div>
        <button name="submit">Login</button>
        <a href="index.php" style="
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
        ">back to registration</a>
    </form>

    <script src="untis.js"></script>
    
</body>
</html>