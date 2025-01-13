<?php
// Starte die Session (wenn noch nicht gestartet)
session_start();

// Generiere einen zufälligen Verschlüsselungsschlüssel (256 Bit)
$key = bin2hex(random_bytes(32)); // 32 Bytes = 256 Bit

// Speichere den Schlüssel in der Session
$_SESSION['encryption_key'] = $key;

// Gebe den Schlüssel als JSON-Antwort zurück
echo json_encode(['encryption_key' => $key]);
?>
