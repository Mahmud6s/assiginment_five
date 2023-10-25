<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
</head>
<body>
    <h1>Registration Form</h1>
    <form method="post" action="process_registration.php">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>
        
        <input type="submit" value="Register">
        <a href="login_form.php">logout</a>
    </form>
</body>
</html>
