<!-- register.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form id="registerForm">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="text" name="domain" placeholder="Domain" required>
        <input type="text" name="name" placeholder="Name" required>
        <button type="submit">Register</button>
    </form>
    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            fetch('http://enterprisesoftware.root/TenantLayer/public/api/register', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(Object.fromEntries(new FormData(this)))
            }).then(response => response.json()).then(data => alert(JSON.stringify(data)));
        });
    </script>
</body>
</html>