// Check for matching passwords
var password1 = document.getElementById("password1");
var password2 = document.getElementById("password2");
var passwordtip = document.getElementById("passwordtip");

function validatePassword(){
  if(password1.value != password2.value) {
    password2.setCustomValidity("Passwords do not match");
  } else {
	  password2.setCustomValidity('');
  }

  if (password1.value.length < 8) {
    password1.setCustomValidity("Invalid password");
    passwordtip.classList.add("text-danger");
  } else if (password1.value.search(/[a-z]/) < 0) {
    password1.setCustomValidity("Invalid password");
    passwordtip.classList.add("text-danger");
  } else if(password1.value.search(/[A-Z]/) < 0) {
    password1.setCustomValidity("Invalid password");
    passwordtip.classList.add("text-danger");
  } else  if (password1.value.search(/[0-9]/) < 0) {
    password1.setCustomValidity("Invalid password");
    passwordtip.classList.add("text-danger");
  } else {
    password1.setCustomValidity('');
    passwordtip.classList.remove("text-danger");
    passwordtip.classList.add("text-success");
  }
}

password1.onkeyup = validatePassword;
password2.onkeyup = validatePassword;
