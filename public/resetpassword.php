<?php
//if (is_user_logged_in()) { 
//    redirect_to('index.php');
//}
require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/../src/resetpassword.php';
//require_login();
?>

<?php view('header', ['title' => 'Reset Password']) ?>

<!--mallia login ja register-->
<form action="resetpassword.php" method="post">
    <h1>New Password</h1>

    <div>
        <label for="password">New Password:</label>
        <input type="password" name="password" id="password" value="<?= $inputs['password'] ?? '' ?>"
               class="<?= error_class($errors, 'password') ?>">
        <small><?= $errors['password'] ?? '' ?></small>
    </div>

    <div>
        <label for="password2">Password Again:</label>
        <input type="password" name="password2" id="password2" value="<?= $inputs['password2'] ?? '' ?>"
               class="<?= error_class($errors, 'password2') ?>">
        <small><?= $errors['password2'] ?? '' ?></small>
    </div>
    

    <section>
        <button type="submit">Send link</button>
    </section>

</form>

<!--chatgpt
<?php if (isset($message)): ?>
    <p>
        <?php echo $message; ?>
    </p>
<?php else: ?>
    <form method="post" action="">
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required>
        <button type="submit">Reset Password</button>
    </form>
<?php endif; ?>
-->

<?php view('footer') ?>