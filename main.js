
// generate random colors in the 7 topic section
document.querySelectorAll('.topic-box i').forEach(box => {
    box.style.color = "rgb(" + Math.floor(Math.random() * 255) + ", "+ Math.floor(Math.random() * 255) + ", "+ Math.floor(Math.random() * 255) + ")";
});

// show comment form in comments section
document.querySelector('#comments-write-own-opinion-btn').addEventListener('click', () => {
    document.getElementById('comments-write-own-opinion-btn').style.top = '-100%';
    document.querySelector('.section-comments').style.height = '870px';
    setTimeout(() => {
        document.getElementById('comments-div-btn').style.display = 'none';
        document.getElementById('comments-form').style.display = 'flex';
    }, 350);

    setTimeout(() => {
        document.querySelector('#comments-form button').style.left = '50%';
        document.querySelector('#comments-form textarea').style.left = '50%';
        document.querySelectorAll('.comments-label').forEach((label) => {
            label.style.fontSize = '30px';
        });
    }, 400);
});


document.querySelectorAll('.reviews-div-profile-info > span').forEach((span) => {
    // console.log(span.getAttribute('rate'));
    let starCount = span.getAttribute('rate');
    let counter = 0;
    // let starTab;
    span.querySelectorAll('p').forEach((p) => {
        if(counter < starCount) {
            p.classList.add('comments-star-active');
            p.classList.remove('comments-star-inactive');
            counter++;
        }
    });
});



let reviewsDivPosition = 25;
let reviewsCount = document.querySelectorAll('#comments-div .reviews').length;
let reviewsPosition = 0;
document.getElementById('reviews-button-get-move-to-left').addEventListener('click', () => {
    if(reviewsPosition == 0) {
        document.getElementById('reviews-button-get-move-to-left').classList.add('comments-inactive-button');
        document.getElementById('reviews-button-get-move-to-left').classList.remove('comments-active-button');
    } else {
        reviewsPosition--;
        reviewsDivPosition += 450;
        document.getElementById('review-id-1').style.marginLeft = reviewsDivPosition + "px";
        document.getElementById('reviews-button-get-move-to-right').classList.add('comments-active-button');
        document.getElementById('reviews-button-get-move-to-right').classList.remove('comments-inactive-button');
    }
});

document.getElementById('reviews-button-get-move-to-right').addEventListener('click', () => {
    if(reviewsPosition >= (reviewsCount - 3)) {
        document.getElementById('reviews-button-get-move-to-right').classList.add('comments-inactive-button');
        document.getElementById('reviews-button-get-move-to-right').classList.remove('comments-active-button');
    } else {
        reviewsPosition++;
        reviewsDivPosition -= 450;
        document.getElementById('review-id-1').style.marginLeft = reviewsDivPosition + "px";
        document.getElementById('reviews-button-get-move-to-left').classList.add('comments-active-button');
        document.getElementById('reviews-button-get-move-to-left').classList.remove('comments-inactive-button');
    }
});


// add service for stars in comments section
let commentsInputsNumber = 1;
document.querySelectorAll('#comments-form input').forEach(input => {
    input.setAttribute('value', commentsInputsNumber)
    input.addEventListener('change', () => {
        document.querySelectorAll('#comments-form label').forEach(label => {
            label.classList.remove('comments-star-inactive');
            label.classList.remove('comments-star-active');
            label.classList.remove('comments-star-active-click');
        });
        for(let i = 1; i <= input.getAttribute('value'); i++) {
            document.getElementById('comment-label-' + i).classList.add('comments-star-active-click');
        }
    });
    commentsInputsNumber++;
});

let commentsLabelsNumber = 1;
document.querySelectorAll('#comments-form label').forEach(label => {
    label.setAttribute('value', commentsLabelsNumber);
    label.addEventListener('mouseover', () => {
        let x = label.getAttribute('value');
        for(let i = 1; i <= x; i++) {
            document.getElementById('comment-label-' + i).classList.add('comments-star-active');
            document.getElementById('comment-label-' + i).classList.remove('comments-star-inactive');
        }
    });
    label.addEventListener('mouseout', () => {
            document.querySelectorAll('#comments-form label').forEach(label => {
                if(label.classList.contains('comments-star-active-click')) {
                } else {
                    label.classList.add('comments-star-inactive');
                    label.classList.remove('comments-star-active');
                }
            });
    });
    commentsLabelsNumber++;
});
