<?php
//NOT FOUND EDES ILMAN PARAM
require __DIR__ . '/../src/bootstrap.php';

if (is_get_request()) {

    echo "plop";

    // sanitize the email & activation code   ACTIVATION_CODE LINKISSA EI-HASHATTYNA, DB:SSA ON
    [$inputs, $errors] = filter($_GET, [
        'email' => 'string | required | email',
        'activation_code' => 'string | required'
    ]);

    if (!$errors) {

        $user = find_unverified_user($inputs['activation_code'], $inputs['email']); //password_verify vertaa hashed/ei activation_coden

        // if user exists and activate the user successfully
        if ($user && activate_user($user['id'])) {
            redirect_with_message(
                'login.php',
                'You account has been activated successfully. Please login here.'
            );
        }
    }
}

// redirect to the register page in other cases
redirect_with_message(
    'register.php',
    'The activation link is not valid, please register again.',
    FLASH_ERROR
);