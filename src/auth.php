<?php
//www.phptutorial.net + function send_activation_email modified with PHPMAILER
//+ Jukan message-muotoilu
/**
* Register a user
*
* @param string $email
* @param string $username
* @param string $password
* @param bool $is_admin
* @return bool
*/
function register_user(string $email, string $username, string $password, string $activation_code, int $expiry = 1 * 24  * 60 * 60, bool $is_admin = false): bool
{
    $sql = 'INSERT INTO users(username, email, password, is_admin, activation_code, activation_expiry)
            VALUES(:username, :email, :password, :is_admin, :activation_code,:activation_expiry)';

    $statement = db()->prepare($sql);

    $statement->bindValue(':username', $username);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', password_hash($password, PASSWORD_BCRYPT));
    $statement->bindValue(':is_admin', (int)$is_admin, PDO::PARAM_INT);
    $statement->bindValue(':activation_code', password_hash($activation_code, PASSWORD_DEFAULT));
    $statement->bindValue(':activation_expiry', date('Y-m-d H:i:s',  time() + $expiry));

    return $statement->execute();
}

function find_user_by_username(string $username) //PUUTTUU id:n haku!!!!!!!!!!!!!!!!!!!!!! Lisätty
{
    $sql = 'SELECT id, username, password, active, email
            FROM users
            WHERE username=:username';

    $statement = db()->prepare($sql);
    $statement->bindValue(':username', $username);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}

function login(string $username, string $password, bool $remember = false): bool
{

    $user = find_user_by_username($username);

    // if user found, check the password
    if ($user && is_user_active($user) && password_verify($password, $user['password'])) {

        log_user_in($user);

        if ($remember) {  //remember me checked
            remember_me($user['id']);   //Miksi NULL, korjattu
        }

        return true;
    }

    return false;
}

/**
 * log a user in
 * @param array $user
 * @return bool
 */
function log_user_in(array $user): bool
{
    // prevent session fixation attack
    if (session_regenerate_id()) {
        // set username & id in the session
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id'] = $user['id'];
        return true;
    }

    return false;
}

function remember_me(int $user_id, int $day = 30)
{
    [$selector, $validator, $token] = generate_tokens();

    // remove all existing token associated with the user id
    delete_user_token($user_id);

    // set expiration date
    $expired_seconds = time() + 60 * 60 * 24 * $day;

    // insert a token to the database
    $hash_validator = password_hash($validator, PASSWORD_DEFAULT);
    $expiry = date('Y-m-d H:i:s', $expired_seconds);

    if (insert_user_token($user_id, $selector, $hash_validator, $expiry)) {
        setcookie('remember_me', $token, $expired_seconds);
    }
}

function require_login(): void
{
    if (!is_user_logged_in()) {
        redirect_to('login.php');
    }
}

function logout(): void
{
    if (is_user_logged_in()) { //true koska herjaa vasta seuraavasta:

        // delete the user token
        delete_user_token($_SESSION['user_id']); 
        // delete session
        unset($_SESSION['username'], $_SESSION['user_id`']);

        // remove the remember_me cookie
        if (isset($_COOKIE['remember_me'])) {
            unset($_COOKIE['remember_me']);
            //setcookie('remember_user', null, -1);  // cookie eriniminen?
            setcookie('remember_me', null, -1);
            //setcookie('rememberme', null, -1, "", "", false, true); //jukka
        }

        // remove all session data
        session_destroy();

        // redirect to the login page
        redirect_to('login.php');
    }
}

function is_user_logged_in(): bool
{
    // check the session
    if (isset($_SESSION['username'])) {
        return true;
    }

    // check the remember_me in cookie
    $token = filter_input(INPUT_COOKIE, 'remember_me', FILTER_SANITIZE_STRING);

    if ($token && token_is_valid($token)) {

        $user = find_user_by_token($token);

        if ($user) {
            return log_user_in($user);
        }
    }
    return false;
}

function current_user()
{
    if (is_user_logged_in()) {
        return $_SESSION['username'];
    }
    return null;
}

function is_user_active($user)
{
    return (int)$user['active'] === 1;
}

function generate_activation_code(): string
{
    return bin2hex(random_bytes(16));
}

function send_activation_email(string $email, string $activation_code): void
{
    // create the activation link
    $activation_link = APP_URL . "/activate.php?email=$email&activation_code=$activation_code";
    //$activation_link = APP_URL . "/activate.php";  YHA NOT FOUND 

    // set email subject & body
    $subject = 'Please activate your account';
    
    $message = "Hi,<br><br>";
    $message.= "Please click the following link to activate your account:<br><br>";
    $message.= "<a href='$activation_link'>Activation link</a>";
    //$message.= "<br><br>t. t. $PALVELUOSOITE";

    // email header
    $header = "From:" . SENDER_EMAIL_ADDRESS;

    // send the email
    //mail($email, $subject, nl2br($message), $header); 
    //OMA MODAUS PHPMAILER: libs/mail.php:
    send_email($email, $message, $subject);

}

function delete_user_by_id(int $id, int $active = 0)
{
    $sql = 'DELETE FROM users
            WHERE id =:id and active=:active';

    $statement = db()->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->bindValue(':active', $active, PDO::PARAM_INT);

    return $statement->execute();
}

function find_unverified_user(string $activation_code, string $email)
{

    $sql = 'SELECT id, activation_code, activation_expiry < now() as expired
            FROM users
            WHERE active = 0 AND email=:email';

    $statement = db()->prepare($sql);

    $statement->bindValue(':email', $email);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);  //sis. hashed activation_code

    if ($user) {
        // already expired, delete the in active user with expired activation code
        if ((int)$user['expired'] === 1) {
            delete_user_by_id($user['id']);
            return null;
        }
        // verify the password
        if (password_verify($activation_code, $user['activation_code'])) {
            return $user;
        }
    }

    return null;
}

function activate_user(int $user_id): bool
{
    $sql = 'UPDATE users
            SET active = 1,
                activated_at = CURRENT_TIMESTAMP
            WHERE id=:id';

    $statement = db()->prepare($sql);
    $statement->bindValue(':id', $user_id, PDO::PARAM_INT);

    return $statement->execute();
}

function generate_password_reset_code(): string //OMA
{
    return bin2hex(random_bytes(50));
}

function find_user_email_exists_and_is_active($email) //OMA
{
    $sql = 'SELECT id FROM users WHERE email=:email AND active=1';  //toimii phpmyadmin

    $statement = db()->prepare($sql);
    $statement->bindValue(':email', $email);  //, PDO::PARAM_INT pois

    $statement->execute(); //boolean
    $id = $statement->fetch(PDO::FETCH_ASSOC); //array

    return $id['id'];
}

function create_password_reset_code($email, $password_reset_code, int $expiry = 1 * 24  * 60 * 60){

    $user_id = find_user_email_exists_and_is_active($email);

    if (isset($user_id)){
        $sql = 'INSERT INTO resetpassword_tokens(users_id, token, expiry)
                VALUES(:users_id, :token, :expiry)';
        $statement = db()->prepare($sql);

        $statement->bindValue(':users_id', $user_id);
        $statement->bindValue(':token', password_hash($password_reset_code, PASSWORD_DEFAULT));
        $statement->bindValue(':expiry', date('Y-m-d H:i:s',  time() + $expiry));
    
        return $statement->execute();
    }

    return false;
};

function send_password_reset_email(string $email, string $password_reset_code): void //OMA muokkaa
{
    // create the reset link
    $reset_link = APP_URL . "/resetpassword.php?password_reset_code=$password_reset_code";
    //$activation_link = APP_URL . "/activate.php";  YHA NOT FOUND 

    // set email subject & body
    $subject = 'Change your password';
    
    $message = "Hi,<br><br>";
    $message.= "Please click the following link to change the password:<br><br>";
    $message.= "<a href='$reset_link'>Password reset link</a>";
    //$message.= "<br><br>t. t. $PALVELUOSOITE";

    // email header
    $header = "From:" . SENDER_EMAIL_ADDRESS;

    // send the email
    //mail($email, $subject, nl2br($message), $header); 
    //OMA MODAUS PHPMAILER: libs/mail.php:
    send_email($email, $message, $subject);
}

function find_user_by_password_reset_code($password_reset_code) { //oma 
    $sql = 'SELECT users_id, expiry > now() as valid
            FROM resetpassword_tokens 
            WHERE token=:password_reset_code'; 

    $statement = db()->prepare($sql);
    $statement->bindValue(':password_reset_code', $password_reset_code);  
    $statement->execute(); //boolean
    $user = $statement->fetch(PDO::FETCH_ASSOC); //array

    if ($user && (int)$user['valid'] === 1) {
        return $user['users_id'];
    } 
    return null;
}

function delete_password_reset_code($user_id) { //oma muuta pdo
    $sql = 'DELETE FROM resetpassword_tokens 
            WHERE users_id=:user_id';
    
    $statement = db()->prepare($sql);
    $statement->bindValue(':id', $user_id, PDO::PARAM_INT);

    return $statement->execute();
}

function change_password($user_id, $password) { //oma muuta pdo
    $password = password_hash($password, PASSWORD_DEFAULT);
    $query = "UPDATE users SET password = '$password' WHERE id = $user_id";
}

//malliksi
function delete_user_by_id(int $id, int $active = 0)
{
    $sql = 'DELETE FROM users
            WHERE id =:id and active=:active';

    $statement = db()->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->bindValue(':active', $active, PDO::PARAM_INT);

    return $statement->execute();
}