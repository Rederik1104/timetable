const buttons = document.querySelector(".button-container");
const table = document.querySelector(".table");
const tds = document.querySelectorAll(".td"); // all td-elements selected
const draggables = document.querySelectorAll(".draggable"); // all draggable-elements selected
const draggableDiv = document.querySelector(".draggable-items");

// function to create the timetable
function createTimetable() {
  localStorage.setItem("createMode", "true");

  table.style.boxShadow = "0 0 10px rgba(0, 0, 0, 0.2)";

  buttons.innerHTML =
    '<button class="btn-create-timetable" id="cancelTimetable" onclick="cancelTimetable()">Cancel</button>';

  // EventListener for Drag-and-Drop added
  tds.forEach((td) => {
    td.addEventListener("dragover", handleDragOver);
    td.addEventListener("drop", handleDrop);
    td.addEventListener("dragleave", handleDragLeave);
  });

  draggables.forEach((item) => {
    item.addEventListener("dragstart", handleDragStart);
  });

  draggableDiv.style.display = "flex";
}

// function to cancel the create mode
function cancelTimetable() {
  localStorage.setItem("createMode", "false");

  table.style.boxShadow = "0 0 0px rgba(0, 0, 0, 0.2)";

  buttons.innerHTML =
    '<button class="btn-create-timetable" id="createTimetable" onclick="createTimetable()">Create Timetable</button>';

  // EventListener for Drag-and-Drop removed
  tds.forEach((td) => {
    td.removeEventListener("dragover", handleDragOver);
    td.removeEventListener("drop", handleDrop);
    td.removeEventListener("dragleave", handleDragLeave);
  });

  draggables.forEach((item) => {
    item.removeEventListener("dragstart", handleDragStart);
  });
  draggableDiv.style.display = "none";
}

// Event-Handler for Drag-Start
function handleDragStart(event) {
  event.dataTransfer.setData("text", event.target.id);
}

// Event-Handler für Drag-Übertragung
function handleDragOver(event) {
  event.preventDefault(); // Ermöglicht das Ablegen
  event.target.classList.add("dragover"); // Optional: Visuelles Feedback
}

// Event-Handler für Drop
function handleDrop(event) {
  event.preventDefault();
  event.target.classList.remove("dragover"); // Entferne visuelles Feedback
  const data = event.dataTransfer.getData("text");
  const draggedElement = document.getElementById(data);

  if (draggedElement) {
    // Füge das gezogene Element in das <td> ein
    event.target.appendChild(draggedElement);
  }
}

// Event-Handler für Drag verlassen
function handleDragLeave(event) {
  event.target.classList.remove("dragover");
}

// Funktion zum Überprüfen des Modus beim Laden der Seite
function checkCreateMode() {
  if (localStorage.getItem("createMode") === "true") {
    createTimetable();
  } else {
    cancelTimetable();
  }
}

// Beim Laden der Seite den Modus überprüfen
document.addEventListener("DOMContentLoaded", function () {
  checkCreateMode();
});
