<!-- <?php 
$link=mysqli_connect("localhost", "root", "");
mysqli_select_db($link,"online_quiz");
?>  -->

<?php 
$link = mysqli_connect("localhost", "root", "", "online_quiz");

// Check if the connection is successful
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}
?>




