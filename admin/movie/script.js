const addForm = document.getElementById("wrap_addform")
const updateForm = document.getElementById("wrap_updateform")
const deleteForm = document.getElementById("wrap_deleteform")

const divAddForm = document.getElementById("div_addform")
const divUpdateForm = document.getElementById("div_updateform")
const divDeleteForm = document.getElementById("div_deleteform")

var catchDimissAll = true


function Update(id, image, tittle, release_date, description, director_id, link, duration, actorIds, genreIds) {
  addForm.style.display = "none"
  updateForm.style.display = "flex"
  updateForm.style.alignItems = 'center'
  updateForm.style.justifyContent = 'center'
  deleteForm.style.display = "none"
  document.getElementById("id_update").value = id
  document.getElementById("title_update").value = tittle
  document.getElementById("image_update").value = image
  document.getElementById("releaseDate_update").value = release_date
  document.getElementById("description_update").value = description
  document.getElementById("director"+director_id).selected = true
  document.getElementById("link_update").value = link
  document.getElementById("duration_update").value = duration

  var actors = actorIds.split(",")
  actors.forEach(function(id) {
    document.getElementById("actor"+id).checked = true
    document.getElementById("actor"+id).selected = true
    console.log(document.getElementById("actor"+id))
  });
  var genres = genreIds.split(",")
  genres.forEach(function(id) {
    document.getElementById("genre"+id).checked = true
  });
  catchDimissAll = false
}

function Delete(id) {
  addForm.style.display = "none"
  updateForm.style.display = "none"
  deleteForm.style.display = "flex"
  deleteForm.style.alignItems = 'center'
  deleteForm.style.justifyContent = 'center'
  document.getElementById("id_delete").value = id
  catchDimissAll = false
}

function Add() {
  addForm.style.display = 'flex'
  addForm.style.alignItems = 'center'
  addForm.style.justifyContent = 'center'
  updateForm.style.display = "none"
  deleteForm.style.display = "none"
  catchDimissAll = false
}
function dimissDelete() {
  deleteForm.style.display = "none"
}

function dimissAll() {
  addForm.style.display = 'none'
  updateForm.style.display = "none"
  deleteForm.style.display = "none"
}
document.addEventListener('click', (e) => {
  if(catchDimissAll){
    if (!divAddForm.contains(e.target) && !divDeleteForm.contains(e.target) && !divUpdateForm.contains(e.target)) {
      dimissAll()
    }
  } else {
    catchDimissAll = true
  }
})

