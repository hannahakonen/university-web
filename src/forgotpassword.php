<?php

/*tuleeko:
if (is_user_logged_in()) { 
    redirect_to('index.php');
}*/

//mallia login ja register
$errors = [];
$inputs = [];

if (is_post_request()) {
    [$inputs, $errors] = filter($_POST, [
        //'email' => 'email | required | email | unique: users, email'
        'email' => 'email | required | email'  //tästä yksi email pois
    ]);

    echo $inputs['email'];  //testi POISTA!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

    if ($errors) {
        redirect_with('forgotpassword.php', [
            'errors' => $errors, 
            'inputs' => $inputs
        ]);
    }

    //tokenin luonti jne
    $password_reset_code = generate_password_reset_code();   

    // Check if the email exists in your database 
    // If it does, generate a unique reset token and store it in the database
    if (create_password_reset_code($inputs['email'], $password_reset_code)) {

        // Send a reset link to the user's email with a link like resetpassword.php?token=YOUR_TOKEN
        send_password_reset_email($inputs['email'], $password_reset_code); 

        redirect_with_message(
            'forgotpassword.php',
            'If the email exists in our system, you will receive a reset link shortly.'
        );
    }

} else if (is_get_request()) {
    [$errors, $inputs] = session_flash('errors', 'inputs');
}

// chatgpt
/*if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the form submission for sending a reset link
    $email = $_POST['email']; // Assuming you have a form field with the name "email"

    // Validate the email (you may add more validation)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } else {
        // Check if the email exists in your database
        // If it does, generate a unique reset token and store it in the database
        // Send a reset link to the user's email with a link like resetpassword.php?token=YOUR_TOKEN
        // You may use a library like PHPMailer to send emails
        // ...

        // Display a message to the user
        $message = "If the email exists in our system, you will receive a reset link shortly.";
    }
}*/
?>