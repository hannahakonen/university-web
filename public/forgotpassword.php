<?php

require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/../src/forgotpassword.php';
//require_login();
?>

<?php view('header', ['title' => 'Forgot Password']) ?>

<!--mallia login ja register-->
<form action="forgotpassword.php" method="post">
    <h1>Password forgotten?</h1>

    <div>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= $inputs['email'] ?? '' ?>"
            class="<?= error_class($errors, 'email') ?>">
        <small>
            <?= $errors['email'] ?? '' ?>
        </small>
    </div>

    <section>
        <button type="submit">Send link</button>
    </section>

</form>

<!--chatgpt
<?php if (isset($error)): ?>
    <p>
        <?php echo $error; ?>
    </p>
<?php endif; ?>

<?php if (isset($message)): ?>
    <p>
        <?php echo $message; ?>
    </p>
<?php endif; ?>

<form method="post" action="">
    <label for="email">Email:</label>
    <input type="email" name="email" required>
    <button type="submit">Send Reset Link</button>
</form>
-->
<?php view('footer') ?>