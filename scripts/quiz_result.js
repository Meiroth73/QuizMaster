let isHashShowed = false;
const arrow = document.getElementById('arrow');
const divHash = document.getElementById('div-hash');

document.getElementById('hash-info').addEventListener('click', () => {
    if (isHashShowed) {
        arrow.style.transform = 'rotate(0deg)';
        divHash.style.top = '-100%';
    } else {
        arrow.style.transform = 'rotate(90deg)';
        divHash.style.top = '0';
    }
    isHashShowed = !isHashShowed;
});