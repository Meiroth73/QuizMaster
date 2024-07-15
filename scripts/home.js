

let menuButtons = document.getElementsByClassName('menu-button');
let filesList = ['/home/elements/info.php', '/home/elements/info.php', '../home/elements/settings.php', ''];

let i = 0;
Array.from(menuButtons).forEach((button, index) => {
    i++;
    button.addEventListener('click', () => {
        Array.from(document.getElementsByClassName('selected')).forEach(element => {
            element.classList.remove('selected');
        });
        button.classList.add('selected');
    });

});
