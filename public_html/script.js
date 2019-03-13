
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