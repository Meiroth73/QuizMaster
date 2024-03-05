
// generate random colors in the 7 topic section
document.querySelectorAll('.topic-box i').forEach(box => {
    box.style.color = "rgb(" + Math.floor(Math.random() * 255) + ", "+ Math.floor(Math.random() * 255) + ", "+ Math.floor(Math.random() * 255) + ")";
});

//show add comment form in comments section
document.querySelector('#comments-write-own-opinion-btn').addEventListener('click', () => {
    document.getElementById('comments-write-own-opinion-btn').style.top = '-100%';
    setTimeout(() => {
        document.querySelectorAll('.section-comments div').forEach(div => {
            div.style.display = 'none';
        });
    }, 500);
    
});