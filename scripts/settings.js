
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