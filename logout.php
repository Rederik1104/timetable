<?php
session_start();

// Überprüfe, ob das Zugriffstoken vorhanden ist und widerrufe es
if (isset($_SESSION['userData']['access_token'])) {
    $accessToken = $_SESSION['userData']['access_token'];

    // Sende eine Anfrage zum Widerrufen des Tokens
    $url = 'https://accounts.google.com/o/oauth2/revoke?token=' . $accessToken;

    $opts = array(
        'http' => array(
            'method' => 'GET',
            'ignore_errors' => true // Um alle HTTP-Fehlercodes zu erfassen
        )
    );

    $context = stream_context_create($opts);
    $response = file_get_contents($url, false, $context);

    // Überprüfe die Antwort und handle Fehler
    if ($response === false) {
        // Lies den Fehler aus dem HTTP-Response-Header aus
        $error = error_get_last();
        echo 'Error revoking token: ' . $error['message'];
    } else {
        // Logge den HTTP-Statuscode für Debugging-Zwecke
        $httpCode = explode(' ', $http_response_header[0])[1];
        if ($httpCode != '200') {
            echo 'Failed to revoke token. HTTP Status Code: ' . $httpCode;
        } else {
            echo 'Token successfully revoked.';
        }
    }
}

// Lösche alle Session-Variablen
$_SESSION = array();

// Wenn die Sitzung gelöscht werden soll, lösche auch das Session-Cookie.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Zerstöre die Sitzung.
session_destroy();

// Weiterleitung zur Startseite nach dem Logout
header("Location: index.php");
exit;
?>
