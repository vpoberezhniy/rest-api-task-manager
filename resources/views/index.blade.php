<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #e0f7ff, #ffffff);
        }
        .login-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #00aaff;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-shadow: inset 0px 1px 3px rgba(0, 0, 0, 0.1);
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #00aaff;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0088cc;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    <form id="loginForm">
        <input type="email" id="email" placeholder="Email" required>
        <input type="password" id="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</div>

<script>
    // Handle form submission
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the page from reloading

        const LOGIN_URL = "{{ env('APP_URL') }}";
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        // Send POST request to the API route
        fetch(`${LOGIN_URL}/api/login`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                email: email,
                password: password
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.token) {
                    // Store the token in local storage
                    localStorage.setItem('auth_token', data.token);
                    // alert('Login successful!');

                    // Redirect to the dashboard if the token is received
                    window.location.href = data.redirect; // Use the redirect URL from the response
                } else {
                    // alert('Login failed');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // alert('Request failed');
            });
    });
</script>

</body>
</html>
