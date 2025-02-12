<?php
session_start();
include "../connection.php";

if (isset($_POST['delete']) && isset($_POST['lecture_id'])) {
    $lecture_id = mysqli_real_escape_string($link, $_POST['lecture_id']);

    // Get file paths before deletion
    $query = "SELECT pdf_path, video_path FROM lectures WHERE id = '$lecture_id'";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_assoc($result);

    // Delete files if they exist
    if ($row['pdf_path'] && file_exists("../" . $row['pdf_path'])) {
        unlink("../" . $row['pdf_path']);
    }
    if ($row['video_path'] && file_exists("../" . $row['video_path'])) {
        unlink("../" . $row['video_path']);
    }

    // Delete database record
    $delete_query = "DELETE FROM lectures WHERE id = '$lecture_id'";
    mysqli_query($link, $delete_query);

    if (mysqli_query($link, $delete_query)) {
        $_SESSION['message'] = "Lecture deleted successfully";
    } else {
        $_SESSION['message'] = "Error deleting lecture: " . mysqli_error($link);
    }
}

header("Location: view_lectures.php");
exit();