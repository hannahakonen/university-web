<?php
require __DIR__ . '/../src/bootstrap.php';
function find_courses_selected_by_username(string $username)
{
    $sql = 'SELECT courses.name
            FROM courses
            JOIN courses_selected_by ON courses.id = courses_selected_by.course_id
            JOIN users ON users.id = courses_selected_by.user_id
            WHERE users.username=:username'; //muuta tähän $username!!!!!!!!!!!!!!!!!!!!!!
            
    $statement = db()->prepare($sql);
    $statement->bindValue(':username', $username); // "hannahakonen"
    $statement->execute();

    //// Fetch all rows as an associative array
    $data=$statement->fetchAll(PDO::FETCH_ASSOC);

    // Convert the result to JSON
    return json_encode($data);
}

// Handle the AJAX request 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //session_start();//tarviiko??????????????????????????????
    // Get the username from the AJAX request
    $username = $_SESSION['username'];//tai $_SESSION['username'];

    // Call your function and echo the result
    echo find_courses_selected_by_username($username);
}