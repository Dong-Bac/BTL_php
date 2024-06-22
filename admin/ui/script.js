function Update(id) {
  document.getElementById("wrap_addform").style.display = "none"
  document.getElementById("wrap_updateform").style.display = "block"
  document.getElementById("wrap_deleteform").style.display = "none"
}

function Delete(id) {
  document.getElementById("wrap_addform").style.display = "none"
  document.getElementById("wrap_updateform").style.display = "none"
  document.getElementById("wrap_deleteform").style.display = "block"
}

function Add() {
  document.getElementById("wrap_addform").style.display = "block"
  document.getElementById("wrap_updateform").style.display = "none"
  document.getElementById("wrap_deleteform").style.display = "none"
}