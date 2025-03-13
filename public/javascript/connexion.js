const REGISTER_BTN = document.getElementById('register-btn');
const LOGIN_BTN = document.getElementById('login-btn');
const REGISTER_FORM = document.querySelector('.register-form');
const LOGIN_FORM = document.querySelector('.login-form');


REGISTER_BTN.addEventListener('click', showRegisterForm);
LOGIN_BTN.addEventListener('click', showLoginForm);

function showRegisterForm(){
  if(LOGIN_FORM.style.display === "block"){
    REGISTER_FORM.style.display = "block";
    LOGIN_FORM.style.display = "none";
  } else {
    REGISTER_FORM.style.display = "block";
  }
}

function showLoginForm(){
  if(REGISTER_FORM.style.display === "block"){
    LOGIN_FORM.style.display = "block";
    REGISTER_FORM.style.display = "none";
  } else {
    LOGIN_FORM.style.display = "block";
  }
}

console.log(LOGIN_BTN);


