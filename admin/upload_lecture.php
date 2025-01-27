<?php
session_start();
include "../connection.php";
include "header.php";
?>

<div class="container">
    <h2>Upload Lecture Materials</h2>
    <form action="upload_lecture.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="lecture_title">Lecture Title:</label>
            <input type="text" class="form-control" id="lecture_title" name="lecture_title" required>
        </div>
        <div class="form-group">
            <label for="lecture_notes">Lecture Notes (Typed):</label>
            <textarea class="form-control" id="lecture_notes" name="lecture_notes" rows="5"></textarea>
        </div>
        <div class="form-group">
            <label for="lecture_pdf">Lecture PDF/Document:</label>
            <input type="file" class="form-control" id="lecture_pdf" name="lecture_pdf">
        </div>
        <div class="form-group">
            <label for="lecture_video">Lecture Video:</label>
            <input type="file" class="form-control" id="lecture_video" name="lecture_video">
        </div>
        <button type="submit" class="btn btn-primary" name="upload">Upload</button>
    </form>
</div>

<?php
if (isset($_POST['upload'])) {
    $lecture_title = mysqli_real_escape_string($link, $_POST['lecture_title']);
    $lecture_notes = mysqli_real_escape_string($link, $_POST['lecture_notes']);

    $pdf_path = "";
    $video_path = "";

    if ($_FILES['lecture_pdf']['name'] != "") {
        $pdf_path = "uploads/" . basename($_FILES['lecture_pdf']['name']);
        move_uploaded_file($_FILES['lecture_pdf']['tmp_name'], $pdf_path);
    }

    if ($_FILES['lecture_video']['name'] != "") {
        $video_path = "uploads/" . basename($_FILES['lecture_video']['name']);
        move_uploaded_file($_FILES['lecture_video']['tmp_name'], $video_path);
    }

    $query = "INSERT INTO lectures (title, notes, pdf_path, video_path) VALUES ('$lecture_title', '$lecture_notes', '$pdf_path', '$video_path')";
    if (mysqli_query($link, $query)) {
        echo "<div class='alert alert-success'>Lecture materials uploaded successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($link) . "</div>";
    }
}
?>

<?php
include "footer.php";
?>