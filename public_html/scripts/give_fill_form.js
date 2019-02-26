// script for coloring and autofilling input data on give forms (give badge and give rank) 

// Get badge-form
let form = document.getElementById('badge-form');

// Get user form and user items
let users = document.getElementsByClassName('user-item');

let form_user = document.getElementById('username');

let is_rank_page;

if (document.getElementsByClassName('rank-item').length == 0) {
    is_rank_page = false;
} else {
    is_rank_page = true;
}

// sets items to ranks or badges and forms depending on which page is used
let items;
let form_item;
if (is_rank_page) {
    items = document.getElementsByClassName('rank-item');
    form_item = document.getElementById('rank');
} else {
    items = document.getElementsByClassName('badge-item');
    form_item = document.getElementById('badge');
}

// Adds event listeners for users
for (let index = 0; index < users.length; index++) {

    // If username input is already set to valid data, select that item
    if (users[index].getAttribute('data-user') == form_user.value) {
        users[index].classList.remove('selected');
        users[index].classList.add('selected');
    }

    users[index].addEventListener('click', function () {
        form_user.value = users[index].getAttribute('data-user');

        if (!is_rank_page)
            form.submit();

        // Only need these because of give rank
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

    // If username input is already set to valid data, select that item
    if (items[index].getAttribute('data-rank') == form_item.value) {
        items[index].classList.remove('selected');
        items[index].classList.add('selected');
    }

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
