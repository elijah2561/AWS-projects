<?php

include('db_config.php');

$name = htmlentities($_REQUEST['name']);
$email = htmlentities($_REQUEST['email']);
$movie = htmlentities($_REQUEST['movie']);

if ($name === '' || $email === '' || $movie === '') {
    echo json_encode(array('message' => 'Please fill all fields', 'status' => 'error'));
    die();
} else {
    $query = "INSERT INTO `movie_voting` (name, email, movie) VALUES ('$name', '$email', '$movie');";
    if (!mysqli_query($connection, $query)) {
        echo json_encode(array('message' => 'Error on submit data', 'status' => 'error', 'sql_error' => mysqli_error($connection)));
        die();
    } else {
        echo json_encode(array('message' => 'Thank you for voting!', 'status' => 'success'));
        die();
    }
}