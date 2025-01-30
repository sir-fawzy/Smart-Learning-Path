<?php
session_start();
include "./connection.php";
include "header.php";
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<style>
    .card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        background: white;
        margin-bottom: 20px;
        padding: 20px;
    }

    .card-title {
        font-size: 2rem;
        margin-bottom: 20px;
    }

    .download-btn {
        background-color: #4285f4;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        text-decoration: none;
        display: inline-block;
        font-size: 1rem;
    }

    .download-btn:hover {
        background-color: #3367d6;
        color: white;
        text-decoration: none;
    }

    .page-title {
        font-size: 2.5rem;
        margin-bottom: 30px;
        font-weight: normal;
    }
</style>

<div class="container">
    <h1 class="page-title">Lecture Materials</h1>
    <div class="row">
        <?php
        $query = "SELECT * FROM lectures ORDER BY created_at DESC";
        $result = mysqli_query($link, $query);
        if (!$result) {
            die("Query failed: " . mysqli_error($link));
        }

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='col-md-4 mb-4'>";
            echo "<div class='card h-100' style='height: 300px; overflow: scroll'>";
            echo "<div class='card-body'>";

            if ($row['pdf_path']) {
                echo "<div style='display: flex; justify-content: space-between; align-items: center;'>";
                echo "<h2 class='card-title' >" . htmlspecialchars($row['title']) . "</h2>";
                echo "<a href='" . htmlspecialchars($row['pdf_path']) . "' class='download-btn' target='_blank'>View PDF</a>";
                echo "</div>";
            } else {
                echo "<h2 class='card-title'>" . htmlspecialchars($row['title']) . "</h2>";
            }

            echo "<hr>";
            // Add notes display
            if ($row['notes']) {
                echo "<p class='card-text mb-3'>" . nl2br(htmlspecialchars($row['notes'])) . "</p>";
            }

            if ($row['pdf_path']) {
                echo "<div class='mt-3 mb-3'>";
                echo "<embed src='" . htmlspecialchars($row['pdf_path']) . "' type='application/pdf' width='100%' height='300px' />";
                echo "</div>";


            }

            if ($row['video_path']) {
                echo "<video width='100%' height='200' controls>
                    <source src='" . htmlspecialchars($row['video_path']) . "' type='video/mp4'>
                    Your browser does not support the video tag.
                </video>";
            }

            echo "</div>"; // close card-body
            echo "</div>"; // close card
            echo "</div>"; // close col
        }
        ?>
    </div>
</div>

<?php include "footer.php"; ?>