<?php
require __DIR__ . '/../src/bootstrap.php';
// Include your database connection file or configure the database connection here
//include_once 'db_connection.php';

function course_id_by_name($courseName)
{
    $sql = 'SELECT id
    FROM courses
    WHERE name=:name';

    $statement = db()->prepare($sql);
    $statement->bindValue(':name', $courseName);
    $statement->execute();

    $id = $statement->fetch(PDO::FETCH_ASSOC);  //ONKO OIKEA MUOTO????
    return $id['id'];
}

//Tämä kurssi-ilmo apufileen
function enroll_user($courseName) //, $username
{
    // Perform the database update logic here
    // ...
    $registered = 1;
    $username = $_SESSION['username'];//?????????????
    $user = find_user_by_username($username);
    $user_id = $user['id'];
    $course_id = course_id_by_name($courseName);

    $sql = 'UPDATE courses_selected_by 
            SET registered=:registered 
            WHERE user_id=:user_id AND course_id=:course_id';
    // Example: Update the users enrolled courses in the database
    // You need to adapt this part based on your database structure
    $statement = db()->prepare($sql);
    $statement->bindValue(':registered', $registered, PDO::PARAM_INT);
    $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $statement->bindValue(':course_id', $course_id, PDO::PARAM_INT);
    $statement->execute();
}

function cancel_enrollment($courseName) //, $username
{
    // Perform the database update logic here
    // ...
    $registered = 0;
    $username = $_SESSION['username'];
    $user = find_user_by_username($username);
    $user_id = $user['id'];
    $course_id = course_id_by_name($courseName);

    $sql = 'UPDATE courses_selected_by 
            SET registered=:registered 
            WHERE user_id=:user_id AND course_id=:course_id';
    
    $statement = db()->prepare($sql);
    $statement->bindValue(':registered', $registered, PDO::PARAM_INT);
    $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $statement->bindValue(':course_id', $course_id, PDO::PARAM_INT);
    $statement->execute();
}

// Handle the AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courseName = $_POST['courseName'];
    //$username = $_POST['username'];  //tämä voisi tulla myös session
    $buttonText = $_POST['buttonText'];
    if ($buttonText == 'Register') {
        enroll_user($courseName); //, $username
    } elseif ($buttonText == 'Cancel registration') {
        cancel_enrollment($courseName);
    }
}
?>