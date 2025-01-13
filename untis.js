document.getElementById("loginForm").addEventListener("submit", async (e) => {
  e.preventDefault();

  const username = document.getElementById("username").value;
  const password = document.getElementById("password").value;
  const server = document.getElementById("server").value;
  const school = document.getElementById("school").value;

  // Schritt 1: Verschlüsselungsschlüssel abrufen
  const key = await getEncryptionKey(); // Funktion getEncryptionKey() siehe weiter unten

  if (!key) {
    console.error("Fehler beim Abrufen des Verschlüsselungsschlüssels.");
    return; // Beende die Funktion, falls der Schlüssel nicht abgerufen werden konnte
  }

  // Schritt 2: Anfrage an den Server senden
  const response = await fetch("http://localhost:3000/run-python", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ username, password, server, school }),
  });

  const result = await response.json();

  if (result.success == true && result.data.timetable) {
    // Schritt 3: Daten verschlüsseln, bevor sie gespeichert werden
    const encryptedTimetable = CryptoJS.AES.encrypt(
      JSON.stringify(result.data.timetable), // Die Daten, die verschlüsselt werden sollen
      key // Der Verschlüsselungsschlüssel
    ).toString();

    // Schritt 4: Verschlüsselte Daten im localStorage speichern
    localStorage.setItem("timetable", encryptedTimetable);

    // Weiterleitung zur nächsten Seite
    window.location.href =
      "register_untis.php?username=" +
      username +
      "&password=" +
      password +
      "&server=" +
      server +
      "&school=" +
      school;
  } else {
    document.getElementById("title").innerHTML = "Login failed.";
  }
  console.log(result);
});

// Funktion zum Abrufen des Verschlüsselungsschlüssels
async function getEncryptionKey() {
  try {
    const response = await fetch("generate_encryption_key.php"); // PHP-Datei, die den Schlüssel zurückgibt
    const data = await response.json();

    if (data.encryption_key) {
      console.log("Verschlüsselungsschlüssel erhalten:", data.encryption_key);
      return data.encryption_key; // Rückgabe des Schlüssels
    } else {
      throw new Error("Kein Schlüssel erhalten");
    }
  } catch (error) {
    console.error("Fehler:", error);
    return null; // Falls kein Schlüssel abgerufen werden kann
  }
}
