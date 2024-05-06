
let getRegisterFormButton = document.getElementById("btn-get-register-form");
let getLoginFormButton = document.getElementById("btn-get-login-form");

let divTextLogin = document.getElementById("div-text-login");
let divTextRegister = document.getElementById("div-text-register");
let divLogin = document.getElementById("div-login");
let divRegister = document.getElementById("div-register");
let divRegisterContinue = document.getElementById('div-register-continue');

getRegisterFormButton.addEventListener('click', () => {
    divRegister.style.left = '0';
    divTextRegister.style.left = '50%';
    divLogin.style.left = '0';
    divTextLogin.style.left = '75%';
    divLogin.style.zIndex = '0';
});

getLoginFormButton.addEventListener('click', () => {
    divRegister.style.left = '-50%';
    divTextRegister.style.left = '100%';
    divLogin.style.left = '50%';
    divTextLogin.style.left = '0%';
    divLogin.style.zIndex = '3';
    divRegisterContinue.style.left = "50%";
});


document.getElementById('btn-continue-register').addEventListener('click', () => {
    divRegisterContinue.style.left = "0%";
    divRegister.style.left = '-50%';

    document.getElementById('user-name-in-form').setAttribute('value', document.getElementById('user-name').value);
    document.getElementById('e-mail-in-form').setAttribute('value', document.getElementById('e-mail').value);
    document.getElementById('password-in-form').setAttribute('value', document.getElementById('register-password').value);
});

document.getElementById('btn-undo').addEventListener('click', () => {
    divRegisterContinue.style.left = "50%";
    divRegister.style.left = '0%';
});

isLoginPasswordHidden = true;
document.getElementById('btn-show-login-password').addEventListener('click', () => {
    if(isLoginPasswordHidden) {
        document.getElementById('btn-show-login-password').innerHTML = "<i class=\"fa-regular fa-eye\"></i>";
        document.getElementById('password').setAttribute('type', 'text');
    } else {
        document.getElementById('btn-show-login-password').innerHTML = "<i class=\"fa-regular fa-eye-slash\"></i>";
        document.getElementById('password').setAttribute('type', 'password');
    }
    isLoginPasswordHidden = !isLoginPasswordHidden;
});

isRegisterPasswordHidden = true;
document.getElementById('btn-show-register-password').addEventListener('click', () => {
    if(isRegisterPasswordHidden) {
        document.getElementById('btn-show-register-password').innerHTML = "<i class=\"fa-regular fa-eye\"></i>";
        document.getElementById('register-password').setAttribute('type', 'text');
    } else {
        document.getElementById('btn-show-register-password').innerHTML = "<i class=\"fa-regular fa-eye-slash\"></i>";
        document.getElementById('register-password').setAttribute('type', 'password');
    }
    isRegisterPasswordHidden = !isRegisterPasswordHidden;
});

isRegisterPasswordConfirmHidden = true;
document.getElementById('btn-show-register-confirm-password').addEventListener('click', () => {
    if(isRegisterPasswordConfirmHidden) {
        document.getElementById('btn-show-register-confirm-password').innerHTML = "<i class=\"fa-regular fa-eye\"></i>";
        document.getElementById('password-confirm').setAttribute('type', 'text');
    } else {
        document.getElementById('btn-show-register-confirm-password').innerHTML = "<i class=\"fa-regular fa-eye-slash\"></i>";
        document.getElementById('password-confirm').setAttribute('type', 'password');
    }
    isRegisterPasswordConfirmHidden = !isRegisterPasswordConfirmHidden;
});