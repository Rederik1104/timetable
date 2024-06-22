<?php
session_start();

// Zerstöre die Sitzung.
session_destroy();

// Weiterleitung zur Startseite nach dem Logout
header("Location: index.php");
exit;

