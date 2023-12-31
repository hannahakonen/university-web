<?php
//jukalla alussa
//if (!session_id())
//    session_start();
//ini_set('default_charset', 'utf-8');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!--<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
-->

    <!--phptutorial.net-->
    <!--<link rel="stylesheet" href="css/phptutorial.css">-->
    <!--<link rel="stylesheet" href="https://www.phptutorial.net/app/css/style.css">-->

    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=IM+Fell+DW+Pica&display=swap">
    
    <link rel="stylesheet" href="css/style.css">
    <?php if (isset($css)) echo "<link rel='stylesheet' href='$css'>"; ?>
    <style>
        
    </style>
    <title>
        <?= $title ?? 'Home' ?>
    </title>
    <!-- Include jQuery for ajax query-->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>

<body>
    <?php $logged_in = isset($_SESSION['username']); ?>

    <nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
        <a class="navbar-brand custom-font" href="#">Primea</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">OPI</a>
                    <!--<a class="nav-link" href="index.php">OPI <span class="sr-only">(current)</span></a>-->
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="">Search</a>
                </li>
                <?php if ($logged_in) {
                    echo "<li class='nav-item'>
                        <a class='nav-link' href='enrolments.php'>Registration</a>
                    </li>";
                    echo "<li class='nav-item'>
                        <a class='nav-link' href='frontpage.php'>Front page</a>
                    </li>";
                } ?>

            </ul>
            <!-- Push "Contact" link to the right -->
            <ul class="navbar-nav ms-auto">
                <?php if (!$logged_in) {
                    
                    echo "<li class='nav-item'>
                        <a class='nav-link' href='login.php'>Login</a>
                </li>";
                } else {
                    $username = $_SESSION['username'];
                    echo "<li class='nav-item dropdown'>
                    <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button'
                        data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        $username
                    </a>
                    <div class='dropdown-menu dropdown-menu-end' aria-labelledby='navbarDropdown'>
                        <a class='dropdown-item' href='contact.php'>Give feedback</a>
                        <div class='dropdown-divider'></div>
                        <a class='dropdown-item' href='logout.php'>Log out</a>
                    </div>
                </li>";
                } ?>
            </ul>
        </div>
    </nav>

    <!-- Bootstrap JS (and Popper.js) -->
    <!--<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
            -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <main>
        <?php flash() ?>