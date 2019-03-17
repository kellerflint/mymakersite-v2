// SESSION PAGE SCRIPTS

// Selecting sessions and displaying or hiding options
let sessions = document.getElementsByClassName('session-wrapper');
let options = document.getElementsByClassName('options');
let descript = document.getElementsByClassName('descript');

for (let i = 0; i < sessions.length; i++) {
    sessions[i].addEventListener("click", function () {
        remove_visible_sections();
        options[i].classList.add("visible");
        descript[i].classList.add("visible");
    });
}

// Adds hidden and removes visible from options and descript divs
function remove_visible_sections() {
    for (let c = 0; c < options.length; c++) {
        options[c].classList.add("hidden");
        options[c].classList.remove("visible");
        descript[c].classList.add("hidden");
        descript[c].classList.remove("visible");
    }
}

// GIVE BADGE SCRIPTS

// script for coloring and autofilling input data on give forms (give badge and give rank) 

// Get badge-form
let form = document.getElementById('badge-form');

// Get user form and user items
let users = document.getElementsByClassName('user-item');

let form_user = document.getElementById('user_id');

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
    form_item = document.getElementById('badge_id');
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