<?php

session_start();
include "./connection.php";
include "header.php";
$date = date("Y-m-d H:i:s");
$_SESSION["end_time"] = date("Y-m-d H:i:s", strtotime($date . "+ $_SESSION[exam_time] minutes"));
if (!$link) {
    echo die("Connection failed: " . mysqli_connect_error());
}
?>

<div class="row" style="margin: 0px; padding:0px; margin-bottom: 50px;">
    <!-- content area -->
    <div class="col-lg-6 col-lg-push-3" style="min-height: 500px; background-color: white;">
        <?php

        $correct = 0;
        $wrong = 0;
        $needs_grading = false;

        if (isset($_SESSION["answer"])) {
            foreach ($_SESSION["answer"] as $i => $user_answer) {
                $answer = "";
                $res = mysqli_query($link, "SELECT * from questions where category='$_SESSION[exam_category]' AND question_no=$i");
                while ($row = mysqli_fetch_array($res)) {
                    $answer = $row["answer"];
                    if ($row["question_type"] == "text_answer") {
                        // Text answers need manual grading
                        $needs_grading = true;
                        // Store the student's text answer for later review
                        $student_answer = $user_answer;
                        // Don't increment correct/wrong counters for text answers yet
                    } else {
                        // Multiple choice/true-false can still be auto-graded
                        if ($answer == $user_answer) {
                            $correct++;
                        } else {
                            $wrong++;
                        }
                    }
                }
            }
        }

        $res = mysqli_query($link, "SELECT * from questions where category='$_SESSION[exam_category]'");
        $count = mysqli_num_rows($res);
        $wrong = $count - $correct;
        echo "<br>";
        echo "<br>";
        echo "<center>";
        echo "Total Questions=" . $count;
        echo "<br>";
        echo "Correct Answer=" . $correct;
        echo "<br>";
        echo "Wrong Answer=" . $wrong;
        echo "</center>";
        ?>
    </div>
</div>

<?php
if (isset($_SESSION["exam_start"])) {
    $res = mysqli_query($link, "SELECT * from questions where category='$_SESSION[exam_category]'");
    $count = mysqli_num_rows($res);
    $wrong = $count - $correct;

    if (!isset($_SESSION["username"]) || !isset($_SESSION["exam_category"])) {
        die("Error: Required session variables not set");
    }

    $date = date("Y-m-d H:i:s"); // Change to include time
    $username = mysqli_real_escape_string($link, $_SESSION['username']);
    $exam_type = mysqli_real_escape_string($link, $_SESSION['exam_category']);

    $query = "INSERT INTO exam_results(
        username, 
        exam_type, 
        total_question,
        correct_answer,
        wrong_answer,
        exam_time,
        needs_grading
    ) VALUES (
        '$username',
        '$exam_type',
        $count,
        $correct,
        $wrong,
        '$date',
        " . ($needs_grading ? 'TRUE' : 'FALSE') . "
    )";

    if (!mysqli_query($link, $query)) {
        echo "Error: " . mysqli_error($link);
    }

    unset($_SESSION["exam_start"]);


}
?>

<?php
include "footer.php";
?>