document.addEventListener("DOMContentLoaded", () => {
    console.log("JavaScript Loaded Successfully!");

    const registerForm = document.getElementById("register-form");
    const loginForm = document.getElementById("login-form");
    const showRegisterBtn = document.getElementById("show-register");
    const showLoginBtn = document.getElementById("show-login");
    const registerSubmit = document.getElementById("registerForm");

    // Function to validate the form
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

    // Handle Registration Form Submission
    if (registerSubmit) {
        registerSubmit.addEventListener("submit", (e) => {
            e.preventDefault();
            if (!validateForm(registerSubmit)) return;
            
            alert("Registration successful! Please log in.");
            
            // Hide registration form and show login form
            registerForm.style.display = "none";
            loginForm.style.display = "block";
        });
    }

    // Show Register Form and Hide Login Form
    if (showRegisterBtn) {
        showRegisterBtn.addEventListener("click", (e) => {
            e.preventDefault();
            console.log("Switching to Register Form");
            loginForm.style.display = "none";
            registerForm.style.display = "block";
        });
    }

    // Show Login Form and Hide Register Form
    if (showLoginBtn) {
        showLoginBtn.addEventListener("click", (e) => {
            e.preventDefault();
            console.log("Switching to Login Form");
            registerForm.style.display = "none";
            loginForm.style.display = "block";
        });
    }
});
