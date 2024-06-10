<?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        header('Content-Type: application/json');
    
        try {
            if (!isset($_SESSION["V-code"]) || !isset($_POST['user']) || !isset($_POST["email"]) || !isset($_POST['password'])) {
                throw new Exception("Session data or email parameter missing.");         
            }
    
            $Vcode = $_SESSION['V-code'];
            $usern = $_POST['user'];
            $email = $_POST['email'];
            $password = $_POST['password'];
    
            // Benutzer-Eingabe aus POST-Daten
            $userCode = $_POST['code'];
    
            // Überprüfung des Codes
            if ($userCode == $Vcode) {
                include("database.php");
    
                $register = "INSERT INTO users (username, email, password) VALUES (:user, :email, :password)";
                $register = $pdo->prepare($emailChange);
                $register->bindParam(":email", $email);
                $register->bindParam(":user", $usern);
                $register->bindParam(":password", $password);
    
                if ($register->execute()) {
                    echo json_encode(['success' => true]);
                    exit();
                } else {
                    throw new Exception("Failed to update email.");
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid verification code.']);
                exit();
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            exit();
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Verifizierungscode Eingeben</title>
        <link rel="stylesheet" href="Vcode.css">
    </head>
    <body>
    
    <div class="container">
        <h2>Verification Code</h2>
        <label for="digit-1">You received a verification code on your new email address. Please type it in the boxes below.</label>
        <div class="code-inputs">
            <input type="text" id="digit-1" maxlength="1" oninput="moveToNext(this, 'digit-2')" autofocus>
            <input type="text" id="digit-2" maxlength="1" oninput="moveToNext(this, 'digit-3')">
            <input type="text" id="digit-3" maxlength="1" oninput="moveToNext(this, 'digit-4')">
            <input type="text" id="digit-4" maxlength="1" oninput="moveToNext(this, 'digit-5')">
            <input type="text" id="digit-5" maxlength="1" oninput="moveToNext(this, 'digit-6')">
            <input type="text" id="digit-6" maxlength="1" oninput="submitCode()">
        </div>
        <div id="message" class="message"></div>
    </div>
    
    <script>
    function moveToNext(current, nextFieldID) {
        if (current.value.length >= 1) {
            const nextField = document.getElementById(nextFieldID);
            if (nextField) {
                nextField.focus();
            }
        }
    }
    
    function submitCode() {
        // Zusammensetzen des Codes aus den Eingabefeldern
        let userCode = '';
        for (let i = 1; i <= 6; i++) {
            userCode += document.getElementById(`digit-${i}`).value;
        }
    
        // AJAX Anfrage an PHP Script senden
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    const messageElement = document.getElementById("message");
                    if (response.success) {
                        messageElement.textContent = "Verification successful!";
                        messageElement.style.color = "green";
                        // Redirect after successful verification
                        window.location.href = "login.php";
                    } else {
                        messageElement.textContent = response.message || "Verification failed. Please try again.";
                        messageElement.style.color = "red";
                    }
                } catch (e) {
                    console.error("Error parsing JSON:", e);
                    document.getElementById("message").textContent = "An unexpected error occurred.";
                    document.getElementById("message").style.color = "red";
                }
            }
        };
        xhr.send("code=" + userCode);
    }
    </script>
    
    </body>
    </html>
    