<?php

function connection() {
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "students_transcripts";

    $con = new mysqli($host, $username, $password, $database);

    if ($con->connect_errno) {
        throw new Exception("Failed to connect to MySQL: " . $con->connect_error);
    }

    return $con;
}

?>
