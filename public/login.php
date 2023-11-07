<?php

require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/../src/login.php';
?>

<?php view('header', ['title' => 'Login']) ?>

<?php if (isset($errors['login'])): ?>
    <div class="alert alert-error">
        <?= $errors['login'] ?>
    </div>
<?php endif ?>
<div class="container">
<form action="login.php" method="post">
    <h1>Login</h1>
    <div>
        <label for="username">Username:</label>
        <input type="text" class="form-control" name="username" id="username" value="<?= $inputs['username'] ?? '' ?>">
        <small>
            <?= $errors['username'] ?? '' ?>
        </small>
    </div>

    <div>
        <label for="password">Password:</label>
        <input type="password" class="form-control" name="password" id="password">
        <small>
            <?= $errors['password'] ?? '' ?>
        </small>
    </div>

    <div>
        <label for="remember_me">
            <input type="checkbox" name="remember_me" id="remember_me" value="checked" <?= $inputs['remember_me'] ?? '' ?> />
            Remember Me
        </label>
        <small>
            <?= $errors['agree'] ?? '' ?>
        </small>
    </div>

    <section>
        <button type="submit" class="btn btn-primary">Login</button>
        <a href="register.php">Register</a>
        <!-- omaa -->
        <a href="forgotpassword.php">Password forgotten?</a> 
    </section>

</form>
<div>
<?php view('footer') ?>