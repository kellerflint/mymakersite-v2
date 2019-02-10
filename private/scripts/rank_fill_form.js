let users = document.getElementsByClassName('user-item');
let ranks = document.getElementsByClassName('rank-item');
let form_user = document.getElementById('username');
let form_rank = document.getElementById('rank');

// Adds event listeners for users
for (let index = 0; index < users.length; index++) {
    users[index].addEventListener('click', function () {
        form_user.value = users[index].getAttribute('data-user');

        users[index].classList.remove('selected');
        users[index].classList.add('selected');


        for (let i = 0; i < users.length; i++) {
            if (index != i) {
                users[i].classList.remove('selected');
            }
        }
    });
}

// Adds event listeners for ranks
for (let index = 0; index < ranks.length; index++) {
    ranks[index].addEventListener('click', function () {
        form_rank.value = ranks[index].getAttribute('data-rank');

        ranks[index].classList.remove('selected');
        ranks[index].classList.add('selected');


        for (let i = 0; i < ranks.length; i++) {
            if (index != i) {
                ranks[i].classList.remove('selected');
            }
        }
    });
}
