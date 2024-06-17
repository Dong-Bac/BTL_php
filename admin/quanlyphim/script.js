// Get the modal
var modal = document.getElementById("addFilmModal");

// Get the button that opens the modal
var btn = document.querySelector(".add-film");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

// Handle form submission
document.getElementById("addFilmForm").onsubmit = function(event) {
  event.preventDefault();
  // Get form data
  var title = document.getElementById("title").value;
  var image = document.getElementById("image").value;
  var year = document.getElementById("year").value;
  var description = document.getElementById("description").value;
  var link = document.getElementById("link").value;
  var duration = document.getElementById("duration").value;
  var rating = document.getElementById("rating").value;

  // Add new film to the table
  var table = document.querySelector("table tbody");
  var newRow = table.insertRow();
  newRow.innerHTML = `
    <td>${table.rows.length}</td>
    <td>${title}</td>
    <td><img src="${image}" width="100px" height="100px"/></td>
    <td>${year}</td>
    <td>${description}</td>
    <td>${link}</td>
    <td>${duration}</td>
    <td>${rating}</td>
    <td class="flex"><button>Sửa</button> <button class="del-film">Xóa</button></td>
  `;

  // Close the modal
  modal.style.display = "none";
}

// Get the delete modal
var modaldel = document.getElementById("delFilmModal");

// Handle opening the delete modal
document.querySelectorAll(".del-film").forEach(function(button) {
  button.onclick = function() {
    modaldel.style.display = "block";
  }
});

// Get the <span> element that closes the modal
var closeButtons = document.getElementsByClassName("close");
for (var i = 0; i < closeButtons.length; i++) {
  closeButtons[i].onclick = function() {
    modaldel.style.display = "none";
    modal.style.display = "none";
  }
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal || event.target == modaldel) {
    modal.style.display = "none";
    modaldel.style.display = "none";
  }
}
