// Check for matching passwords
var password1 = document.getElementById("password1");
var password2 = document.getElementById("password2");

function validatePassword(){
  if(password1.value != password2.value) {
    password2.setCustomValidity("Passwords do not match");
  } else {
	  password2.setCustomValidity('');
  }
}

password1.onkeyup = validatePassword;
password2.onkeyup = validatePassword;
