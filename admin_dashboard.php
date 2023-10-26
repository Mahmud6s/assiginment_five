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
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 p-8">
    <div class="max-w-screen-lg mx-auto bg-white p-4 rounded shadow-lg">
        <h1 class="text-3xl font-semibold mb-4">Welcome, Admin!</h1>
        <a href="logout.php" class="text-blue-500">Logout</a>

        <h2 class="text-2xl mt-8 mb-4">User List</h2>
        <table class="w-full border-collapse border border-gray-300">
            <tr class="bg-gray-200">
                <th class="p-2">Username</th>
                <th class="p-2">Email</th>
                <th class="p-2">Role</th>
                <th class="p-2">Actions</th>
            </tr>
            <?php
            foreach ($user_data as $line) {
                $data = explode(', ', $line);
                $username = str_replace('Username: ', '', $data[0]);
                $email = str_replace('Email: ', '', $data[1]);
                $role = str_replace('Role: ', '', $data[3]);

                echo "<tr>
                          <td class='p-2 text-center'>$username</td>
                          <td class='p-2 text-center'>$email</td>
                          <td class='p-2 text-center'>$role</td>
                          <td class='p-2 text-center'>
                          <a href='edit_admin.php?email=$email' class='text-blue-500'>Edit</a>
                          <form method='post' style='display: inline;'>
                       <input type='hidden' name='emailToDelete' value='$email'>
                       <button type='submit' name='delete' class='text-red-500 ml-2'
                                       onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</button>
                        </form>
                           </td>
                     </tr>";
            }
                ?>
        </table>
    </div>
</body>

</html>