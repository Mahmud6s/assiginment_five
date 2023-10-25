<?php
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password
    
    // Set a default role
    $role = "user";
    
    // Simple validation (you can add more robust validation)
    if (!empty($username) && !empty($email) && !empty($password)) {
        // Save the user's details to a file
        $data = "Username: $username, Email: $email, Password: $password, Role: $role\n";
        file_put_contents('user_data.txt', $data, FILE_APPEND);
        
        // Redirect to a success page or perform other actions as needed
        header('Location: registration_success.php');
        exit;
    } else {
        // Handle validation errors or missing data
        echo "Please fill in all fields.";
    }
}
?>
