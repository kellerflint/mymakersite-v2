
// Selecting sessions and displaying or hiding options
let sessions = document.getElementsByClassName('session-wrapper');

for (let i = 0; i < sessions.length; i++) {
    sessions[i].addEventListener("click", function () {
        // Removes selected from all others
        for (let c = 0; c < sessions.length; c++) {
            sessions[c].classList.remove("selected");
        }

        // Adds hidden/removes visible from options div
        sessions[i].classList.add("selected");
        for (let c = 0; c < sessions.length; c++) {
            // childNodes[3] is the location of the options div
            sessions[c].childNodes[3].classList.add("hidden");
            sessions[c].childNodes[3].classList.remove("visible");
        }

        sessions[i].childNodes[3].classList.add("visible");
    });
}