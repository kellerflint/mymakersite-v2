// script for coloring and autofilling input data on give forms (give badge and give rank) 

let users = document.getElementsByClassName('user-item');

// sets items to ranks or badges depending on which page is used
let items;
if (document.getElementsByClassName('rank-item').length == 0) {
    items = document.getElementsByClassName('badge-item');
} else {
    items = document.getElementsByClassName('rank-item');
}

let form_user = document.getElementById('username');

// sets form to rank or badge depending on which page is used
let form_item;
if (!document.getElementById('rank')) {
    form_item = document.getElementById('badge');
} else {
    form_item = document.getElementById('rank');
}

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

// Adds event listeners for items
for (let index = 0; index < items.length; index++) {
    items[index].addEventListener('click', function () {
        form_item.value = items[index].getAttribute('data-rank');

        items[index].classList.remove('selected');
        items[index].classList.add('selected');

        for (let i = 0; i < items.length; i++) {
            if (index != i) {
                items[i].classList.remove('selected');
            }
        }
    });
}
