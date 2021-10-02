const lineTokenCreate = {
        link: document.querySelector("#linkline"),
        content: document.querySelector("#token-create")
};

const fingerRegistration = {
        link: document.querySelector("#linkfinger"),
        content: document.querySelector("#finger-register")
};

const activeRegistered = {
        link: document.querySelector("#linktoactive"),
        content: document.querySelector("#active-finger")
};

lineTokenCreate.link.addEventListener('click', (e) => {
        e.preventDefault();
        
        lineTokenCreate.link.classList.add("active");
        lineTokenCreate.content.style.display = "block";

        fingerRegistration.link.classList.remove("active");
        fingerRegistration.content.style.display = "none";

        activeRegistered.link.classList.remove("active");
        activeRegistered.content.style.display = "none";
});

fingerRegistration.link.addEventListener('click', (e) => {
        e.preventDefault();
        
        lineTokenCreate.link.classList.remove("active");
        lineTokenCreate.content.style.display = "none";

        fingerRegistration.link.classList.add("active");
        fingerRegistration.content.style.display = "block";

        activeRegistered.link.classList.remove("active");
        activeRegistered.content.style.display = "none";
});

activeRegistered.link.addEventListener('click', (e) => {
        e.preventDefault();
        
        lineTokenCreate.link.classList.remove("active");
        lineTokenCreate.content.style.display = "none";

        fingerRegistration.link.classList.remove("active");
        fingerRegistration.content.style.display = "none";

        activeRegistered.link.classList.add("active");
        activeRegistered.content.style.display = "block";
});

(() => {
        lineTokenCreate.link.click();
})();
