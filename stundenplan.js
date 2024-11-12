const buttons = document.querySelector(".button-container");
const table = document.querySelector(".table");
const tds = document.querySelectorAll(".td"); // all td-elements selected
const draggables = document.querySelectorAll(".card_add"); // all draggable-elements selected
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
    item.addEventListener("touchstart", handleTouchStart); // Add touch support
    item.addEventListener("touchmove", handleTouchMove); // Add touch support
    item.addEventListener("touchend", handleTouchEnd); // Add touch support
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
    item.removeEventListener("touchstart", handleTouchStart);
    item.removeEventListener("touchmove", handleTouchMove);
    item.removeEventListener("touchend", handleTouchEnd);
  });
  draggableDiv.style.display = "none";
}

// Event-Handler for Drag-Start
function handleDragStart(event) {
  event.dataTransfer.setData("text", event.target.id);
  console.log(event.target.id);
}

// Event-Handler for Touch Start (to simulate drag start)
function handleTouchStart(event) {
  const touch = event.touches[0];
  event.dataTransfer = {
    setData: function () {},
    getData: function () {
      return event.target.id;
    },
  };
  handleDragStart(event); // Reuse drag start logic
}

// Event-Handler for Touch Move
function handleTouchMove(event) {
  event.preventDefault(); // Prevent scrolling
  const touchLocation = event.targetTouches[0];

  // Move the card to follow the touch
  event.target.style.position = "absolute";
  event.target.style.left = `${touchLocation.pageX}px`;
  event.target.style.top = `${touchLocation.pageY}px`;
}

// Event-Handler for Drop
function handleDrop(event) {
  event.preventDefault();
  event.target.classList.remove("dragover");
  const data = event.dataTransfer.getData("text");
  const draggedElement = document.getElementById(data);

  if (draggedElement) {
    // Append the dragged element to the target cell
    event.target.appendChild(draggedElement);
    onItemDropped(event, draggedElement.querySelector(".card-title").innerText);
  }
}

// Event-Handler for Touch End (to simulate drop)
function handleTouchEnd(event) {
  const touch = event.changedTouches[0];
  const dropTarget = document.elementFromPoint(touch.clientX, touch.clientY);

  if (dropTarget && dropTarget.classList.contains("td")) {
    const cardId = event.target.id;
    const draggedCard = document.getElementById(cardId);

    if (draggedCard) {
      dropTarget.appendChild(draggedCard);
      onItemDropped(
        { target: dropTarget },
        draggedCard.querySelector(".card-title").innerText
      );
    }
  }
  // Reset card position after touch ends
  event.target.style.position = "";
  event.target.style.left = "";
  event.target.style.top = "";
}

// Function to call on item drop with additional logic
function onItemDropped(Dragevent, subject) {
  let day = Dragevent.target.id.split("-");
  window.location.href = `addLesson.php?day=${day[1]}&lesson=${
    day[3]
  }&subject_name=${encodeURIComponent(subject)}`;
}

// Event-Handler for Drag Leave
function handleDragLeave(event) {
  event.target.classList.remove("dragover");
}

// Event-Handler for Drag Over
function handleDragOver(event) {
  event.preventDefault();
  event.target.classList.add("dragover");
}

// Check mode on page load
function checkCreateMode() {
  if (localStorage.getItem("createMode") === "true") {
    createTimetable();
  } else {
    cancelTimetable();
  }
}

document.addEventListener("DOMContentLoaded", function () {
  checkCreateMode();
});
