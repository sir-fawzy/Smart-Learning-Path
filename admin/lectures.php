<?php
session_start();
include "../connection.php";
include "header.php";
?>

<div class="container mt-5" style="height: 100% ;background-color: white; padding: 20px; border-radius: 8px;">
    <h2>Lecture Management</h2>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="d-grid gap-3" style="display: flex; flex-direction: row;">
                <a href="upload_lecture.php" class="btn btn-secondary btn-lg" style="margin-right: 10%; padding: 25%; ">
                    <i class='bx bxs-cloud-upload'></i> Upload New Lecture
                </a>
                <a href="view_lectures.php" class="btn btn-secondary btn-lg" style="margin-left: 5%; padding: 25%;">
                    <i class='bx bxs-book-content'></i> View Previous Lectures
                </a>
            </div>
        </div>
    </div>
</div>

<?php
include "footer.php";
?>