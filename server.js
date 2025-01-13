const express = require("express");
const { spawn } = require("child_process");
const cors = require("cors");
const path = require("path"); // path-Modul hinzufügen
const app = express();

app.use(cors()); // CORS aktivieren
app.use(express.json()); // Body-Parser für JSON-Daten

// POST-Endpunkt, um das Python-Skript auszuführen
app.post("/run-python", (req, res) => {
  // Extrahiere die Daten aus dem Request-Body
  const { username, password, server, school } = req.body;

  // Prüfe, ob alle benötigten Daten vorhanden sind
  if (!username || !password || !server || !school) {
    console.error("Fehlende Eingabedaten: ", req.body);
    return res
      .status(400)
      .json({ success: false, error: "Alle Felder müssen ausgefüllt werden." });
  }

  // Erstelle eine JSON-Datenstruktur, die an das Python-Skript übergeben wird
  const dataF = JSON.stringify({ username, password, server, school });

  console.log("Python-Skript wird mit den folgenden Daten aufgerufen:", dataF);

  // Rufe das Python-Skript auf und übergebe die Daten als Argument
  const pythonProcess = spawn(
    "python3", // Use just "python" instead of the full path
    [path.join(__dirname, "untis.py"), dataF]
  );

  let output = "";
  let errorOutput = ""; // Speichern von Fehlermeldungen des Python-Prozesses

  pythonProcess.stdout.on("data", (data) => {
    output += data.toString();
  });

  pythonProcess.stderr.on("data", (data) => {
    errorOutput += data.toString();
    console.error("Fehler im Python-Skript:", data.toString()); // Logge die Fehlermeldung
  });

  pythonProcess.on("close", (code) => {
    console.log(`Python-Prozess beendet mit Code ${code}`);

    try {
      if (code === 0) {
        // Wenn der Python-Prozess erfolgreich war, parsen wir die Ausgabe
        console.log("Erfolgreiche Antwort vom Python-Skript:", output);

        // Parse die JSON-Antwort vom Python-Skript
        const parsedOutput = JSON.parse(output);

        // Überprüfen, ob die Antwort aus dem Python-Skript den erwarteten Inhalt hat
        if (parsedOutput.error) {
          console.error("Fehler im Python-Skript:", parsedOutput.error);
          return res
            .status(500)
            .json({ success: false, error: parsedOutput.error });
        }

        // Überprüfen, ob der Stundenplan leer ist
        if (
          parsedOutput.status === "success" &&
          Array.isArray(parsedOutput.timetable) &&
          parsedOutput.timetable.length === 0
        ) {
          return res.json({
            success: true,
            message: "Stundenplan ist leer.",
            timetable: [],
          });
        }

        // Rückgabe der Antwort an den Client
        return res.json({ success: true, data: parsedOutput });
      } else {
        // Falls der Python-Prozess einen Fehlercode zurückgibt
        console.error("Python-Skript fehlgeschlagen mit dem Fehlercode:", code);
        console.error("Fehlerausgabe des Python-Skripts:", errorOutput);

        // Versuche, die Fehlerausgabe als JSON zu parsen
        try {
          const parsedError = JSON.parse(errorOutput); // Versuche, die Fehlerausgabe als JSON zu parsen
          return res.status(500).json({
            success: false,
            error: `Python-Skript fehlgeschlagen: ${
              parsedError.error || "Unbekannter Fehler"
            }`,
            details:
              parsedError.exception || "Keine weiteren Details verfügbar.",
          });
        } catch (e) {
          // Falls das Parsen der Fehlerausgabe fehlschlägt, sende die rohe Fehlerausgabe
          return res.status(500).json({
            success: false,
            error:
              "Python-Skript fehlgeschlagen: Fehler beim Parsen der Ausgabe",
            details: errorOutput,
          });
        }
      }
    } catch (error) {
      // Fehlerbehandlung, falls beim Parsen der Ausgabe ein Problem auftritt
      console.error("Fehler beim Parsen der Antwort:", error);
      return res
        .status(500)
        .json({ success: false, error: "Fehler beim Parsen der Antwort" });
    }
  });

  pythonProcess.on("error", (err) => {
    // Enhanced error logging
    console.error("Fehler beim Starten des Python-Prozesses:", err);
    console.error("Fehlerdetails:", err.message); // Log the error message
    return res.status(500).json({
      success: false,
      error: "Fehler beim Starten des Python-Prozesses",
      details: err.message, // Include the error message in the response
    });
  });
});

// Server läuft auf Port 3000
app.listen(3000, () => {
  console.log("Server läuft auf http://localhost:3000");
});
