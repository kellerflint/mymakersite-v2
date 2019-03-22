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

// GIVE SCRIPTS

// script for coloring and autofilling input data on give forms (give badge and give rank and permissions) 

// Get user form and user items
let users = document.getElementsByClassName('user-item');

let form_user = document.getElementById('user_id');

let form_item = document.getElementById('item_id');

let is_rank_page = false;
let is_badge_page = false;
let is_permission_page = false;
let is_user_page = false;

if (document.getElementsByClassName('rank-item').length == 0) {
    is_rank_page = false;
}

if (document.getElementById('badge-form')) {
    is_badge_page = true;
}

if (document.getElementById('permission-form')) {
    is_permission_page = true;
}

if (document.getElementById('global-user-box')) {
    is_user_page = true;
}

// sets items to ranks or badges and forms depending on which page is used
let items;
let form;

// Get form (for badge or  permission)
if (is_badge_page) {
    form = document.getElementById('badge-form');
} else {
    form = document.getElementById('permission-form');
}

if (is_rank_page) {
    items = document.getElementsByClassName('rank-item');
} else {
    items = document.getElementsByClassName('badge-item');
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

        if (is_badge_page || is_permission_page)
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

// Create permissions string for permissions.php

let checkboxs;
if (document.getElementsByTagName("title")[0].innerText.includes("Permissions"))
    checkboxs = document.getElementsByClassName("permission-checkbox");


let permissions = ["false", "false", "false", "false", "false", "false"];
if (document.getElementsByTagName("title")[0].innerText.includes("Permissions")) {
    set_permissions_array();
    document.getElementById("permissions_string").value = set_permission_string();
}

if (checkboxs) {
    for (let i = 0; i < checkboxs.length; i++) {
        checkboxs[i].addEventListener("click", function () {
            set_permissions_array();
            document.getElementById("permissions_string").value = '';
            document.getElementById("permissions_string").value = set_permission_string();
        });
    }
}

function set_permissions_array() {
    for (let i = 0; i < checkboxs.length; i++) {
        if (checkboxs[i].checked == true) {
            permissions[i] = "true";
        } else {
            permissions[i] = "false";
        }
    }
}

function set_permission_string() {
    return permissions.join(",");
}