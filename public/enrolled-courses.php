<?php
//require __DIR__ . '/../src/bootstrap.php';

//Tämä kurssi-ilmo apufileen

//courses registered by user
$username = $_SESSION['username'];
$sql = 'SELECT courses.name
            FROM courses
            JOIN courses_selected_by ON courses.id = courses_selected_by.course_id
            JOIN users ON users.id = courses_selected_by.user_id
            WHERE users.username=:username AND courses_selected_by.registered=1';
            
    $statement = db()->prepare($sql);
    $statement->bindValue(':username', $username); // "hannahakonen"
    $statement->execute();

    //// Fetch all rows as an associative array
    $enrolled_courses=$statement->fetchAll(PDO::FETCH_ASSOC);