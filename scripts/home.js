

let menuButtons = document.getElementsByClassName('menu-button');
let filesList = ['../home/elements/main.php', '../home/elements/info.php', '../home/elements/settings.php', ''];

let i = 0;
Array.from(menuButtons).forEach((button, index) => {
    i++;
    button.addEventListener('click', () => {
        Array.from(document.getElementsByClassName('selected')).forEach(element => {
            element.classList.remove('selected');
        });
        button.classList.add('selected');
        loadElementFromFile(filesList[index], 'document-body');
    });
});

function loadElementFromFile(file, element) {
    fetch(file).then(response => {
        if(!response.ok) {
            throw new Error('Load file Error');
        }
            return response.text();
        }) .then(data => {
            document.getElementById(element).innerHTML = data;
        }) .catch(error => {
            console.error('Problem with fetch operation: ' + error);
        });
}