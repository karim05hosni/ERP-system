<!-- login.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form id="loginForm">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            fetch('http://enterprisesoftware.root/TenantLayer/public/api/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(Object.fromEntries(new FormData(this)))
            }).then(response => response.json()).then(data => {
                if (data.token) {
                    localStorage.setItem('token', data.token);
                    alert('Login successful');
                } else {
                    alert('Login failed');
                }
            });
        });
    </script>
</body>
</html>