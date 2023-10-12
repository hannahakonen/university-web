<?php

if (is_user_logged_in()) { 
    redirect_to('index.php');
}
// chatgpt

// Assuming you have a database to store reset tokens and their expiration times

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['token'])) {
    $token = $_GET['token']; // The token sent in the reset link

    // Check if the token exists in your database and is not expired
    // If it does, allow the user to reset the password
    // ...

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the form submission for changing the password
    $newPassword = $_POST['new_password']; // Assuming you have a form field with the name "new_password"
    
    // Validate and update the password in your database
    // ...

    // Display a message to the user
    $message = "Password reset successful. You can now log in with your new password.";
}
?>