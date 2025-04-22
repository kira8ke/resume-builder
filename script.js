document.addEventListener("DOMContentLoaded", () => {
    console.log("JavaScript Loaded Successfully!");

    const registerFormContainer = document.getElementById("register-form");
    const loginFormContainer = document.getElementById("login-form");
    const showRegisterBtn = document.getElementById("show-register");
    const showLoginBtn = document.getElementById("show-login");
    const registerForm = document.getElementById("registerForm");

    // Validate form inputs
    function validateForm(form) {
        const inputs = form.querySelectorAll("input[required]");
        for (let input of inputs) {
            if (input.value.trim() === "") {
                alert(`${input.placeholder} is required!`);
                return false;
            }

            if (input.type === "email" && !/\S+@\S+\.\S+/.test(input.value)) {
                alert("Please enter a valid email address.");
                return false;
            }

            if (input.type === "password" && input.value.length < 6) {
                alert("Password must be at least 6 characters long.");
                return false;
            }
        }
        return true;
    }

    // Show registration form
    showRegisterBtn?.addEventListener("click", () => {
        loginFormContainer.classList.add("hidden");
        registerFormContainer.classList.remove("hidden");
    });

    // Show login form
    showLoginBtn?.addEventListener("click", () => {
        registerFormContainer.classList.add("hidden");
        loginFormContainer.classList.remove("hidden");
    });

    // Handle registration form submit
    registerForm?.addEventListener("submit", (e) => {
        e.preventDefault();

        if (!validateForm(registerForm)) return;

        alert("Registration successful! Please log in.");

        // Switch back to login
        registerFormContainer.classList.add("hidden");
        loginFormContainer.classList.remove("hidden");
    });
});
