<?php
session_start();
include "../connection.php";
include "header.php";
?>

<div class="container">
    <h2>Lecture Materials</h2>
    <div class="row">
        ghgh
        <?php

        $query = "SELECT * FROM lectures ORDER BY created_at DESC";
        $result = mysqli_query($link, $query);


        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='col-md-4'>";
            echo "<h3>" . $row['title'] . "</h3>";
            if ($row['notes']) {
                echo "<p>" . nl2br($row['notes']) . "</p>";
            }
            if ($row['pdf_path']) {
                echo "<p><a href='" . $row['pdf_path'] . "' target='_blank'>Download PDF</a></p>";
            }
            if ($row['video_path']) {
                echo "<p><a href='" . $row['video_path'] . "' target='_blank'>Watch Video</a></p>";
            }
            echo "</div>";
        }
        ?>
    </div>
</div>

<?php
include "footer.php";
?>