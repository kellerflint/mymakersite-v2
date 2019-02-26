let firstname = document.getElementById("firstname");
let lastname = document.getElementById("lastname");
let username = document.getElementById("username");

firstname.addEventListener("keyup", function () {
    username.value = firstname.value + lastname.value;
});

lastname.addEventListener("keyup", function () {
    username.value = firstname.value + lastname.value;
});