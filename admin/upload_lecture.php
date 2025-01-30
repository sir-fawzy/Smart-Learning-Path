<?php
session_start();
include "../connection.php";
include "header.php";
?>

<head>
    <style>
        .back-btn {
            color: #333;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            color: #666;
            text-decoration: none;
        }
    </style>
</head>

<!-- Add Back Button -->
<div class="container mt-3">
    <a href="lectures.php" class="back-btn">
        <i class='bx bxs-left-arrow-square'></i> Back to Lectures Menu
    </a>
</div>
<div class="container mt-5">
    <div class="card shadow-sm" style="border-radius: 10px;">
        <div class="card-body p-4">
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
                <button type="submit" class="btn btn-success" name="upload">Upload</button>
            </form>
        </div>
    </div>
</div>

<?php
if (isset($_POST['upload'])) {
    // Create uploads directory if it doesn't exist
    $upload_dir = "../uploads/";
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    chmod($upload_dir, 0777);

    $lecture_title = mysqli_real_escape_string($link, $_POST['lecture_title']);
    $lecture_notes = mysqli_real_escape_string($link, $_POST['lecture_notes']);

    $pdf_path = "";
    $video_path = "";

    // Handle PDF upload
    if (!empty($_FILES['lecture_pdf']['name'])) {
        $pdf_file = $_FILES['lecture_pdf'];
        $pdf_name = time() . '_' . basename($pdf_file['name']);
        $pdf_path = $upload_dir . $pdf_name;

        if ($pdf_file['error'] === 0) {
            if (move_uploaded_file($pdf_file['tmp_name'], $pdf_path)) {
                $pdf_path = "uploads/" . $pdf_name; // Store relative path in database
            } else {
                echo "<div class='alert alert-danger'>Error uploading PDF: " . error_get_last()['message'] . "</div>";
            }
        }
    }

    // Handle Video upload
    if (!empty($_FILES['lecture_video']['name'])) {
        $video_file = $_FILES['lecture_video'];
        $video_name = time() . '_' . basename($video_file['name']);
        $video_path = $upload_dir . $video_name;

        if ($video_file['error'] === 0) {
            if (move_uploaded_file($video_file['tmp_name'], $video_path)) {
                $video_path = "uploads/" . $video_name; // Store relative path in database
            } else {
                echo "<div class='alert alert-danger'>Error uploading video: " . error_get_last()['message'] . "</div>";
            }
        }
    }

    // Only insert into database if at least one file was uploaded successfully
    if ($pdf_path !== "" || $video_path !== "" || ($lecture_notes !== "" && $lecture_title !== "")) {
        $query = "INSERT INTO lectures (title, notes, pdf_path, video_path) VALUES ('$lecture_title', '$lecture_notes', '$pdf_path', '$video_path')";
        if (mysqli_query($link, $query)) {
            echo "<div class='alert alert-success'>Lecture materials uploaded successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Database Error: " . mysqli_error($link) . "</div>";
        }
    }
}
?>

<?php
include "footer.php";
?>