function initDropDown() {
    const dropdowns = document.querySelectorAll(".js-dropdown");
    if (!dropdowns) return;

    dropdowns.forEach(dropdown => {
        const btn = dropdown.querySelector('.js-dropbtn');
        if (btn) {
            btn.addEventListener('click', (event) => {
                event.stopPropagation();
                //console.log("Chaning some stuff");
                dropDown(dropdown);
            });
        }
    });
}

function dropDown(dropDown) {
    const content = dropDown.querySelector(".js-dropContent");
    const currentState = content.getAttribute("data-state");

    if (currentState === "closed") {
        content.setAttribute("data-state", "open");
    } else {
        content.setAttribute("data-state", "closed");
    }
}

initDropDown();