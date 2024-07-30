
document.getElementById('load-file-button').addEventListener('click', (event) => {
    event.preventDefault();
    document.getElementById('file-input').click();
});

document.getElementById('file-input').addEventListener('change', () => {
    let fileInput = document.getElementById('file-input');
    let image = document.getElementById('profile-image');
    let error = document.getElementById('file-error');
    let file = fileInput.files[0];

    if(file) {
        let validImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/webp'];

        if(validImageTypes.includes(file.type)) {
            let fileReader = new FileReader();

            fileReader.onload = function(e) {
                image.src = e.target.result;
                error.innerHTML = '';
            }

            fileReader.readAsDataURL(file);
        } else {
            error.innerHTML = 'Niepoprawny format pliku';
        }
    } else {
        error.innerHTML = '';
    }
});

let isWarningDisplayed = false;
document.getElementById('save-settings').addEventListener('click', (event) => {
    event.preventDefault();
    let error = document.getElementById('settings-error');
    
    let name = /^[A-Za-zĄĆĘŁŃÓŚŹŻąćęłńóśźż\s-]{1,50}$/;
    if(!name.test(document.getElementById('name').value)) {
        error.innerHTML = "Niepoprawne imie";
        return false;
    }

    if(!name.test(document.getElementById('lastname').value)) {
        error.innerHTML = "Niepoprawne nazwisko";
        return false;
    }

    let userNameRegEx = /^[a-zA-Z0-9._-]{3,15}$/;
    if(!userNameRegEx.test(document.getElementById('username').value)) {
        error.innerHTML = "Nazwa użytkowika może zawierac tylko małe i duże litery, cyfry oraz '.', '-', '_'";
        return false;
    }

    let emailRegEx = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,63}$/;
    if(!emailRegEx.test(document.getElementById('email').value)) {
        error.innerHTML = "E-mail jest nie poprawny";
        return false;
    }

    if((document.getElementById('description').value.length) == 0) {
        if(!isWarningDisplayed) {
            isWarningDisplayed = !isWarningDisplayed;
            error.innerHTML = "Zaleca się aby opis nie był pusty";
            return false;
        }
    }

    document.getElementById('settings-form').submit();
});