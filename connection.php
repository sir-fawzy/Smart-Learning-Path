<?php
$link = mysqli_connect("localhost", "root", "mpkq88@2022", "online_quiz");

// Check if the connection is successful
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}
?>