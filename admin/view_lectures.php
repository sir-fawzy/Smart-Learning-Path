<?php
session_start();
include "../connection.php";
include "header.php";

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}
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

<div class="container"
    style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); ">
    <h2 class="mb-4" style="color: #333; border-bottom: 2px solid grey; padding-bottom: 10px;">Lecture Materials</h2>
    <div class="row">
        <?php
        $query = "SELECT * FROM lectures ORDER BY created_at DESC";
        $result = mysqli_query($link, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='col-md-4'>";
            echo "<div class='card mb-4 hover-shadow' style='transition: all 0.3s ease; border: none; box-shadow: 0 2px 5px rgba(0,0,0,0.1);'>";

            // Title container
            echo "<div class='title-container'>";
            echo "<h3 class='card-title' style='background-color:#4C0013; padding: 15px; margin: 0; color: white; font-size: 1.2rem; border-radius: 4px 4px 0 0;'>" . htmlspecialchars($row['title']) . "</h3>";
            echo "</div>";

            // Content container
            echo "<div class='content-container' style='padding: 20px;'>";
            if ($row['notes']) {
                echo "<p class='card-text' style='color: #555; margin-bottom: 15px;'>" . nl2br(htmlspecialchars($row['notes'])) . "</p>";
            }

            echo "<div class='button-group' style='display: flex; flex-direction: column; gap: 10px;'>";
            if ($row['pdf_path']) {
                echo "<a href='../" . htmlspecialchars($row['pdf_path']) . "' class='btn btn-success btn-block' style='border: none;' target='_blank'>View Lecture</a>";
            }
            if ($row['video_path']) {
                echo "<a href='../" . htmlspecialchars($row['video_path']) . "' class='btn btn-success btn-block' style=' border: none;' target='_blank'>Watch Video</a>";
            }
            echo "<form action='delete_lecture.php' method='POST' onsubmit='return confirm(\"Are you sure you want to delete this lecture?\")'>";
            echo "<input type='hidden' name='lecture_id' value='" . $row['id'] . "'>";
            echo "<button type='submit' name= 'delete' class='btn btn-danger btn-block' style='background-color: #dc3545; border: none;'>Delete Lecture</button>";
            echo "</form>";
            echo "</div>";
            echo "</div>";

            echo "</div></div>";
        }
        ?>
    </div>
</div>
<style>
    .hover-shadow:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15) !important;
    }

    .btn-block {
        width: 100%;
        margin-bottom: 5px;
        border-radius: 4px;
        padding: 8px;
    }
</style>

<?php
include "footer.php";
?>