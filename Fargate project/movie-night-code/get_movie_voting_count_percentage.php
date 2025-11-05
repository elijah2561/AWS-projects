<?php

include('db_config.php');

$query = "SELECT 
    COUNT(*) as movie_voting_total_count,
    SUM(CASE WHEN movie = 'Superhero Epic' THEN 1 ELSE 0 END) as superhero_epic_count,
    SUM(CASE WHEN movie = 'Comedy Classic' THEN 1 ELSE 0 END) as comedy_classic_count,
    SUM(CASE WHEN movie = 'Horror Night' THEN 1 ELSE 0 END) as horror_night_count
FROM movie_voting";

$query_run = mysqli_query($connection, $query);
$result_array = [];

if (mysqli_num_rows($query_run) > 0) {
    foreach ($query_run as $row) {
        array_push($result_array, $row);
    }
    header('Content-type: application/json');
    echo json_encode($result_array);
} else {
    echo json_encode($result_array);
}