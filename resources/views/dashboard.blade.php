<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .logout-button {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 15px;
            background-color: #00aaff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .logout-button:hover {
            background-color: #0088cc;
        }
    </style>
</head>
<body>

<h1>Welcome to the Dashboard</h1>
<p>This is a simple page with a logout button.</p>

<button class="logout-button" id="logoutButton">Logout</button>

<script>
    document.getElementById('logoutButton').addEventListener('click', function() {

        const LOGIN_URL = "{{ env('APP_URL') }}";
        // Send POST request to the logout route
        fetch(`${LOGIN_URL}api/logout`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('auth_token')
            }
        })
            .then(response => {
                if (response.ok) {
                    // alert('Successfully logged out');
                    localStorage.removeItem('auth_token');
                    window.location.href = '/';
                } else {
                    // alert('Logout failed');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // alert('Logout request failed');
            });
    });
</script>

</body>
</html>
