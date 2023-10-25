<?php
// Start a session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php'); // Redirect to the login page if not logged in
    exit;
}

// Initialize variables for new username and email
$newUsername = '';
$newEmail = '';

if (isset($_SESSION['user']['username'])) {
    $newUsername = $_SESSION['user']['username'];
}

if (isset($_SESSION['user']['email'])) {
    $newEmail = $_SESSION['user']['email'];
}

// Function to update user data in the "user_data.txt" file
function updateUser($email, $newUsername, $newEmail) {
    // Read user data from the file "user_data.txt"
    $user_data = file_get_contents('user_data.txt');
    $users = explode("\n", $user_data);

    foreach ($users as &$userData) {
        $fields = explode(', ', $userData);
        if (count($fields) === 4) {
            $userEmail = str_replace('Email: ', '', $fields[1]);
            if ($userEmail === $email) {
                $userData = "Username: $newUsername, Email: $newEmail, Password: " . $_SESSION['user']['password'] . ", Role: " . $_SESSION['user']['role'];
                $_SESSION['user']['username'] = $newUsername;
                $_SESSION['user']['email'] = $newEmail;
            }
        }
    }

    // Save the updated data to the file
    file_put_contents('user_data.txt', implode("\n", $users));

    // Redirect back to the admin dashboard
    header('Location: user_dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_user'])) {
    $email = $_POST['email'];
    $newUsername = $_POST['new_username'];
    $newEmail = $_POST['new_email'];

    // Perform validation on the new data (you can add more robust validation)
    if (empty($newUsername) || empty($newEmail)) {
        echo "Username and email are required.";
    } else {
        updateUser($email, $newUsername, $newEmail);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>
    
    <form method="post">
        <label for="new_username">New Username:</label>
        <input type="text" id="new_username" name="new_username" value="<?php echo $newUsername; ?>">
        <br>

        <label for="new_email">New Email:</label>
        <input type="email" id="new_email" name="new_email" value="<?php echo $newEmail; ?>">
        <br>

        <input type="hidden" name="email" value="<?php echo $_SESSION['user']['email']; ?>">
        <input type="submit" name="edit_user" value="Save">
    </form>
</body>
</html>
