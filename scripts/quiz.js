document.querySelectorAll('.topic-box').forEach(box => {
    let colorRed = Math.floor(Math.random() * 265) + 45;
    let colorGreen = Math.floor(Math.random() * 265) + 45;
    let colorBlue = Math.floor(Math.random() * 265) + 45;
    box.style.backgroundColor = "rgb(" + colorRed + ", "+ colorGreen + ", "+ colorBlue + ")";
});