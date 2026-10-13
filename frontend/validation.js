document.getElementById("registrationForm").addEventListener("submit", function (event) {
    let valid = true;

    const name = document.getElementById("name").value.trim();
    const roll = document.getElementById("rollNo").value.trim();
    const email = document.getElementById("email").value.trim();
    const course = document.getElementById("course").value;
    const password = document.getElementById("password").value;

    document.querySelectorAll(".error").forEach(e => e.textContent = "");

    if (name === "") {
        document.getElementById("nameError").textContent = "Name is required.";
        valid = false;
    }

    if (roll === "") {
        document.getElementById("rollError").textContent = "Roll number is required.";
        valid = false;
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        document.getElementById("emailError").textContent =
            "Enter a valid email address.";
        valid = false;
    }

    if (course === "") {
        document.getElementById("courseError").textContent =
            "Please select a course.";
        valid = false;
    }

    // Strong password: at least 8 characters, one uppercase,
    // one lowercase, one number and one special character.
    const strongPassword =
        /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/;

    if (!strongPassword.test(password)) {
        document.getElementById("passwordError").textContent =
            "Password must be 8+ characters with upper, lower, number and special character.";
        valid = false;
    }

    if (!valid) {
        event.preventDefault();
    }
});
