<?php
session_start();
include "../connection.php";

if (isset($_GET["exam_category"])) {
    $exam_category = mysqli_real_escape_string($link, $_GET["exam_category"]);
    $_SESSION["exam_category"] = $exam_category;

    $res = mysqli_query($link, "SELECT * from exam_category where category='$exam_category'");
    if ($row = mysqli_fetch_array($res)) {
        $_SESSION["exam_time"] = $row["exam_time_in_minutes"];

        $date = date("Y-m-d H:i:s");
        $_SESSION["end_time"] = date("Y-m-d H:i:s", strtotime($date . "+$_SESSION[exam_time] minutes"));
        $_SESSION["exam_start"] = "yes";

        echo "success"; // Send response back to JavaScript
    } else {
        echo "exam category not found";
    }
} else {
    echo "no category specified";
}
?>