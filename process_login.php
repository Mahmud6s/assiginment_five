<?php

// Start a session
session_start();

// Initialize the $users array
$users = [];

// Read user data from the file "user_data.txt"
$lines = file('user_data.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
    // Split the line into its components
    $data = explode(', ', $line);
    $username = trim(str_replace('Username: ', '', $data[0]));
    $email = trim(str_replace('Email: ', '', $data[1]));
    $password = trim(str_replace('Password: ', '', $data[2]));
    $role = trim(str_replace('Role: ', '', $data[3]));

    // Add user data to the $users array
    $users[] = ['email' => $email, 'password' => $password, 'role' => $role];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the provided email and password match a user
    foreach ($users as $user) {
        if ($user['email'] == $email && password_verify($password, $user['password'])) {
            // Authentication successful, set a session variable
            $_SESSION['user'] = $user;

            // Check if the user is an administrator
            if ($user['role'] === 'admin') {
                header('Location: admin_dashboard.php'); // Redirect to the admin dashboard
                exit;
            } else {
                header('Location: user_dashboard.php'); // Redirect to the user dashboard
                exit;
            }
        }
    }

    // If no match is found, display an error message
    echo "Invalid email or password. Please try again.";
}
