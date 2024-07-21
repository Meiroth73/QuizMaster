
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
    let error = document.getElementById('register-error-1');
    
    let userNameregEx = /^[a-zA-Z0-9._-]{3,15}$/;
    if(!userNameregEx.test(document.getElementById('user-name').value)) {
        error.innerHTML = "Nazwa użytkowika może zawierac tylko małe i duże litery, cyfry oraz '.', '-', '_'";
        return false;
    }

    let emailRegEx = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,63}$/;
    if(!emailRegEx.test(document.getElementById('e-mail').value)) {
        error.innerHTML = "E-mail jest nie poprawny";
        return false;
    }

    let passwordRegEx = /^(?=.*[a-ząćęłńóśźż])(?=.*[A-ZĄĆĘŁŃÓŚŹŻ])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-ząćęłńóśźżĄĆĘŁŃÓŚŹŻ\d!@#$%^&*]{8,}$/;
    if(!passwordRegEx.test(document.getElementById('register-password').value)) {
        error.innerHTML = "Hasło powinno mieć minimum 8 znaków, w tym małe i duże litery, cyfry i znaki specjalne";
        return false;
    }

    if(!document.getElementById('register-password-confirm').value) {
        error.innerHTML = "Nalerzy potwierdzić hasło";
        return false;
    }

    if(document.getElementById('register-password').value !== document.getElementById('register-password-confirm').value) {
        error.innerHTML = "Hasła nie są takie same";
        return false;
    }

    divRegisterContinue.style.left = "0%";
    divRegister.style.left = '-50%';

    error.innerHTML = '';

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
        document.getElementById('register-password-confirm').setAttribute('type', 'text');
    } else {
        document.getElementById('btn-show-register-confirm-password').innerHTML = "<i class=\"fa-regular fa-eye-slash\"></i>";
        document.getElementById('register-password-confirm').setAttribute('type', 'password');
    }
    isRegisterPasswordConfirmHidden = !isRegisterPasswordConfirmHidden;
});

let isWarningDisplayed = false;
document.getElementById('register-button').addEventListener('click', (event) => {
    event.preventDefault();
    let error = document.getElementById('register-error-2');

    let name = /^[A-Za-zĄĆĘŁŃÓŚŹŻąćęłńóśźż\s-]{1,50}$/;
    if(!name.test(document.getElementById('name').value)) {
        error.innerHTML = "Niepoprawne imie";
        return false;
    }

    if(!name.test(document.getElementById('lastname').value)) {
        error.innerHTML = "Niepoprawne nazwisko";
        return false;
    }

    let phone = /^\+?[0-9\s-]{7,15}$/;
    if(!phone.test(document.getElementById('phone').value)) {
        error.innerHTML = "Niepoprawny numer telefonu";
        return false;
    }

    if((document.getElementById('description').value.length) == 0) {
        if(!isWarningDisplayed) {
            isWarningDisplayed = !isWarningDisplayed;
            error.innerHTML = "Zaleca się aby opis nie był pusty";
            return false;
        }
    }

    document.getElementById('register-form').submit();
});