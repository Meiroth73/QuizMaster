
let isKeyShowed = false;
document.getElementById('key-info').addEventListener('click', () => {
    if (isKeyShowed) {
        document.getElementById('arrow').style.transform = 'rotate(0deg)';
        document.getElementById('div-key').style.top = '-100%';
    } else {
        document.getElementById('arrow').style.transform = 'rotate(90deg)';
        document.getElementById('div-key').style.top = '0';
    }
    isKeyShowed = !isKeyShowed;
});