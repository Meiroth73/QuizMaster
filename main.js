
document.querySelectorAll('.topic-box i').forEach(box => {
    box.style.color = "rgb(" + Math.floor(Math.random() * 255) + ", "+ Math.floor(Math.random() * 255) + ", "+ Math.floor(Math.random() * 255) + ")";
});