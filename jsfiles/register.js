document.getElementById('registerForm').addEventListener('submit', function(event) {
    const email = document.getElementById('email').value;
    const confirmEmail = document.getElementById('confirmEmail').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const phoneNumber = document.getElementById('phoneNumber').value;

    if (email !== confirmEmail) {
        alert('Email addresses do not match.');
        event.preventDefault();
    }

    if (password !== confirmPassword) {
        alert('Passwords do not match.');
        event.preventDefault();
    }

    const phoneRegex = /^[0-9]{10}$/;
    if (!phoneRegex.test(phoneNumber)) {
        alert('Please enter a valid 10-digit phone number.');
        event.preventDefault();
    }
});
