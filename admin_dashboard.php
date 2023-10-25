<?php
// Start a session
session_start();

// Check if the user is an admin, if not, redirect to the login page
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php'); // Redirect to your login page
    exit;
}

// Read user data from the file "user_data.txt"
$user_data = file('user_data.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $emailToDelete = $_POST['emailToDelete'];

    // Find and remove the user's information
    foreach ($user_data as $key => $line) {
        $data = explode(', ', $line);
        $email = str_replace('Email: ', '', $data[1]);

        if ($email === $emailToDelete) {
            unset($user_data[$key]);
        }
    }

    // Save the updated user data back to the file
    file_put_contents('user_data.txt', implode("\n", $user_data));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome, Admin!</h1>
    <a href="logout.php">Logout</a>

    <h2>User List</h2>
    <table>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        <?php
        foreach ($user_data as $line) {
            $data = explode(', ', $line);
            $username = str_replace('Username: ', '', $data[0]);
            $email = str_replace('Email: ', '', $data[1]);
            $role = str_replace('Role: ', '', $data[3]);

            echo "<tr>
                    <td>$username</td>
                    <td>$email</td>
                    <td>$role</td>
                    <td>
                        <a href='edit_admin.php?email=$email'>Edit</a>
                        <form method='post' style='display: inline;'>
                            <input type='hidden' name='emailToDelete' value='$email'>
                            <input type='submit' name='delete' value='Delete' onclick='return confirm(\"Are you sure you want to delete this user?\");'>
                        </form>
                    </td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>
