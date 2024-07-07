async function changeHour() {
  let hour = document.getElementById("schoolHour").value;

  const response = await fetch("updateHour.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `hour=${hour}`,
  });

  if (!response.ok) {
    throw new Error("Network response was not ok");
  }

  const data = await response.json();
  console.log(data);
}
