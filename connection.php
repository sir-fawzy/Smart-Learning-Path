<?php
$link = mysqli_connect("localhost", "root", "", "online_quiz");

//mpkq88@2022
// Check if the connection is successful
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}
?>