document.getElementById('login-form').addEventListener('submit', async function(event) {
    event.preventDefault(); // Prevent the form from submitting normally

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    // Simple validation
    if (!username || !password) {
        alert('Please enter both username and password.');
        return;
    }

    // Prepare the data for the POST request
    const loginData = {
        username: username,
        password: password
    };

    try {
        const response = await fetch('http://localhost:8000/api/user/login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(loginData)
        });

        const data = await response.json();
        console.log(data);


        if (data.message == 'Login successful.') {
            // Store the JWT token in the local storage
            localStorage.setItem('jwtToken', data.token);
            localStorage.setItem('username', data.username);
            alert('Login successful!');
            // // Redirect to the home page
            window.location.href = './index.html';
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while logging in. Please try again.');
    }
});
