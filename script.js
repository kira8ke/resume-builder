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

            // Email validation
            if (input.type === "email" && !/\S+@\S+\.\S+/.test(input.value)) {
                alert("Please enter a valid email address.");
                return false;
            }

            // Password validation (min 6 characters)
            if (input.type === "password" && input.value.length < 6) {
                alert("Password must be at least 6 characters long.");
                return false;
            }
        }
        return true;
    }

    if (registerForm) {
        registerForm.addEventListener("submit", (e) => {
            if (!validateForm(registerForm)) e.preventDefault();
        });
    }

    if (loginForm) {
        loginForm.addEventListener("submit", (e) => {
            if (!validateForm(loginForm)) e.preventDefault();
        });
    }
});
