document.addEventListener("DOMContentLoaded", () => {
    const registerForm = document.getElementById("register-form");
    const loginForm = document.getElementById("login-form");

    function validateForm(form) {
        const inputs = form.querySelectorAll("input[required]");
        for (let input of inputs) {
            if (input.value.trim() === "") {
                alert(`${input.placeholder} is required!`);
                return false;
            }
        }
        return true;
    }

    registerForm.addEventListener("submit", (e) => {
        if (!validateForm(registerForm)) e.preventDefault();
    });

    loginForm.addEventListener("submit", (e) => {
        if (!validateForm(loginForm)) e.preventDefault();
    });
});
