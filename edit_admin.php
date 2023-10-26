<?php
// Start a session
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php'); // Redirect to the login page if not logged in or not an admin
    exit;
}

// Function to update user data in the "user_data.txt" file
function updateUser($email, $newUsername, $newEmail, $newRole) {
    // Read user data from the file "user_data.txt"
    $user_data = file_get_contents('user_data.txt');
    $users = explode("\n", $user_data);

    foreach ($users as &$userData) {
        $fields = explode(', ', $userData);
        if (count($fields) === 4) {
            $userEmail = str_replace('Email: ', '', $fields[1]);
            if ($userEmail === $email) {
                $userData = "Username: $newUsername, Email: $newEmail, Password: " . $_SESSION['user']['password'] . ", Role: $newRole";
            }
        }
    }

    // Save the updated data to the file
    file_put_contents('user_data.txt', implode("\n", $users));

    // Redirect back to the admin dashboard
    header('Location: admin_dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_user'])) {
    $email = $_POST['email'];
    $newUsername = $_POST['new_username'];
    $newEmail = $_POST['new_email'];
    $newRole = $_POST['new_role'];

    // Perform validation on the new data (you can add more robust validation)
    if (empty($newUsername) || empty($newEmail) || empty($newRole)) {
         echo "Username, email, and role are required.";
    } else {
        updateUser($email, $newUsername, $newEmail, $newRole);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8 flex justify-center items-center h-screen">
    <div class="bg-white p-4 rounded shadow-lg w-96">
        <h1 class="text-2xl font-semibold mb-4">Edit User</h1>
        <form method="post">
            <div class="mb-4">
                <label for="new_username" class="block font-medium text-gray-700">New Username:</label>
                <input type="text" id="new_username" name="new_username" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label for="new_email" class="block font-medium text-gray-700">New Email:</label>
                <input type="email" id="new_email" name="new_email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label for="new_role" class="block font-medium text-gray-700">New Role:</label>
                <input type="text" id="new_role" name="new_role" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>

            <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">

            <button type="submit" name="edit_user" class="w-full bg-blue-500 text-white font-semibold p-2 rounded-lg hover:bg-blue-600">Save</button>
        </form>
    </div>
</body>
</html>
