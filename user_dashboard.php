<?php
// Start a session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php'); // Redirect to the login page if not logged in
    exit;
}

// ... Your existing code ...

// Read user data from the file "user_data.txt"
$user_data = file_get_contents('user_data.txt');
$users = explode("\n", $user_data);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['user']['email']; ?></h1>
    
    <h2>User List</h2>
    <form method="post">
        <table>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            <?php
            foreach ($users as $userData) {
                $userFields = explode(', ', $userData);
                if (count($userFields) === 4) {
                    $username = str_replace('Username: ', '', $userFields[0]);
                    $email = str_replace('Email: ', '', $userFields[1]);
                    $role = str_replace('Role: ', '', $userFields[3]);
                    
                    echo "<tr>
                            <td>$username</td>
                            <td>$email</td>
                            <td>$role</td>
                            <td>
                            <a href='edit_user.php?email=$email'>Edit</a>
                            </td>
                          </tr>";
                }
            }
            ?>
        </table>
    </form>
    
    <!-- Add a logout button -->
    <form method="post" action="logout.php">
        <input type="submit" name="logout" value="Logout">
    </form>
</body>
</html>

