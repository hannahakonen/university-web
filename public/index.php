<?php
require __DIR__ . '/../src/bootstrap.php';
//require_login();
?>

<?php view('header', ['title' => 'Dashboard']) ?>
<p>Welcome
    <?= current_user() ?> <a href="logout.php">Logout</a>
</p>
<?php

//echo "<h3> PHP List All Session Variables</h3>";
//foreach ($_SESSION as $key => $val)
//    echo $key . " " . $val . "<br/>";
?>
<?php view('footer') ?>