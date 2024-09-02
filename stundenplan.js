const { WebUntis } = require("webuntis"); // Hier ist 'webuntis' der Name des Moduls im package.json des geklonten Repos

const untis = new WebUntis(
  "Mannesmann-gym#",
  "erik.senkbeil",
  "Zupomiwo.8",
  "xyz.webuntis.com"
);

async function getTimetable() {
  try {
    await untis.login();
    const timetable = await untis.getOwnTimetableForToday();
    console.log("Stundenplan für heute:", timetable);
  } catch (error) {
    console.error("Fehler beim Abrufen des Stundenplans:", error);
  }
}

getTimetable();
