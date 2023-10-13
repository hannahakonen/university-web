<?php

require __DIR__ . '/../src/bootstrap.php';
logout();

/*Jos ongelmaa azuren kanssa: vaihtoehto:
<?php

session_unset();

session_destroy();

//header("Location: index.php?pages=login");
echo '<script>window.location.href = "index.php?pages=login";</script>
exit();
?>
*/