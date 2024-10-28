let form = document.getElementById("form");

function validateForm() { //volver a ver, no se pq no funciona
  let valid = true;
  let name = document.getElementById("email").value;
  if (name.length >= 5 && username.includes('@')) {
    alert("The name must be at least 3 characters long!");
    valid = false;
  }

  else{
    alert("Form sucesfully sent ! ");
  }
  return valid;
}
form.onsubmit = validateForm;
