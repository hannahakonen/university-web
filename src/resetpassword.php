<?php

//if (is_user_logged_in()) { 
//    redirect_to('index.php');
//}

//mallia login ja register
$errors = [];
$inputs = [];

$password_reset_code = $_GET['password_reset_code'] ?? '';  //parametrina osoitteessa
$user_id = '';  //onko ok???

if (is_get_request() && isset($password_reset_code)) {
    
    // Check if the token exists in your database and is not expired
    $user_id = find_user_by_password_reset_code($password_reset_code);  //id
} 

if (is_post_request()) {
    $fields = [
        'password' => 'string | required | secure',
        'password2' => 'string | required | same: password',
    ];

    // custom messages
    $messages = [
        'password2' => [
            'required' => 'Please enter the password again',
            'same' => 'The password does not match'
        ],
    ];

    [$inputs, $errors] = filter($_POST, $fields, $messages);

    if ($errors) {
        redirect_with('resetpassword.php', [
            'inputs' => $inputs,
            'errors' => $errors
        ]);
    }
    // Handle the form submission for changing the password
    $password = $_POST['password'];

    // Validate and update the password in your database
    // ...
    change_password(???)
    // Display a message to the user
    $message = "Password reset successful. You can now log in with your new password.";

    //jukan modaa
    if (empty($errors['password2']) and empty($errors['password'])) {
        if ($_POST['password'] != $_POST['password2']) {
            $errors['password2'] = $virheilmoitukset['password2']['customError'];
            }
        }
        
    debuggeri($errors);    
    if (empty($errors)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET password = '$password' WHERE id = $users_id";
        $result = $yhteys->query($query);
        $muutettu = $yhteys->affected_rows;
        }
    
    if ($muutettu) {
        $query = "DELETE FROM resetpassword_tokens WHERE users_id = $users_id";
        debuggeri($query);
        $result = $yhteys->query($query);
        $poistettu_token = $yhteys->affected_rows;
        debuggeri("Poistettiin $poistettu_token token.");
        /* Huom. tässä siirrytään suoraan kirjautumissivulle. */
        header("location: login.php");
        exit;
        }

} else if (is_get_request()) {
    [$errors, $inputs] = session_flash('errors', 'inputs');
}
;

// chatgpt

// Assuming you have a database to store reset tokens and their expiration times
/*
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
}*/
?>