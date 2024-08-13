function validatePassword(password) {
    const minLength = 8;
    const hasUpperCase = /[A-Z]/.test(password);
    const hasLowerCase = /[a-z]/.test(password);
    const hasNumbers = /[0-9]/.test(password);
    const hasSpecialChars = /[!@#$%^&*(),.?":{}|<>]/.test(password);

    alert(password)
    if (password.length < minLength) {
        return `Password must be at least ${minLength} characters long.`;
    }
    if (!hasUpperCase) {
        return 'Password must include at least one uppercase letter.';
    }
    if (!hasLowerCase) {
        return 'Password must include at least one lowercase letter.';
    }
    if (!hasNumbers) {
        return 'Password must include at least one number.';
    }
    if (!hasSpecialChars) {
        return 'Password must include at least one special character.';
    }
    return ''; // Return an empty string if the password is valid
}

async function registerUser(username, email, password) {
    try {
        const response = await fetch('http://localhost:8000/api/user/register.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                username: username,
                email: email,
                password: password
            })
        });

        const data = await response.json();

            alert('Registration successful!');
 
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while registering. Please try again.');
    }
}


document.getElementById('signup-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;

    if (password !== confirmPassword) {
        alert('Passwords do not match.');
    } else {
        const validationMessage = validatePassword(password);
        if (validationMessage) {
            alert(validationMessage);
        } else {
            console.log(username, email, confirmPassword);
            registerUser(username, email, password);

        }
    }

 
});
