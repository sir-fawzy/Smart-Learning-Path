<?php
include "header.php";
include "../connection.php";

$id = $_GET["id"];
$exam_category = '';

$res = mysqli_query($link, "SELECT * FROM exam_category WHERE id=$id");
while ($row = mysqli_fetch_array($res)) {
    $exam_category = $row["category"];
}
?>

<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Add Question To <?php echo "<font color='red'>" . $exam_category . "</font>"; ?></h1>
            </div>
        </div>
    </div>
</div>

<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-6">
                <form name="form1" action="" method="post" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header"><strong>Add New Question</strong></div>
                        <div class="card-body card-block">
                            <div class="form-group">
                                <label for="question_type" class="form-control-label">Select Question Type</label>
                                <select name="question_type" class="form-control" required>
                                    <option value="multiple_choice">Multiple Choice</option>
                                    <option value="true_false">True/False</option>
                                    <option value="text_answer">Text Answer</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="question" class="form-control-label">Question</label>
                                <input type="text" name="question" placeholder="Add Question" class="form-control">
                            </div>

                            <div id="multiple-choice-fields" style="display: none;">
                                <div class="form-group">
                                    <label for="opt1" class="form-control-label">Option 1</label>
                                    <input type="text" placeholder="Option 1" class="form-control" name="opt1">
                                </div>
                                <div class="form-group">
                                    <label for="opt2" class="form-control-label">Option 2</label>
                                    <input type="text" placeholder="Option 2" class="form-control" name="opt2">
                                </div>
                                <div class="form-group">
                                    <label for="opt3" class="form-control-label">Option 3</label>
                                    <input type="text" placeholder="Option 3" class="form-control" name="opt3">
                                </div>
                                <div class="form-group">
                                    <label for="opt4" class="form-control-label">Option 4</label>
                                    <input type="text" placeholder="Option 4" class="form-control" name="opt4">
                                </div>
                                <div class="form-group">
                                    <label for="answer" class="form-control-label">Correct Answer</label>
                                    <input type="text" placeholder="Answer" class="form-control" name="answer">
                                </div>
                            </div>

                            <div id="true-false-fields" style="display: none;">
                                <div class="form-group">
                                    <label for="answer" class="form-control-label">Correct Answer</label>
                                    <select name="answer" class="form-control">
                                        <option value="True">True</option>
                                        <option value="False">False</option>
                                    </select>
                                </div>
                            </div>

                            <div id="text-answer-fields" style="display: none;">
                                <div class="form-group">
                                    <label for="correct_text" class="form-control-label">Correct Answer</label>
                                    <textarea name="correct_text" class="form-control" placeholder="Correct Answer"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="attachment" class="form-control-label">Attachment (Optional)</label>
                                <input type="file" class="form-control" name="attachment" style="padding-bottom: 15px;">
                            </div>

                            <div class="form-group">
                                <input type="submit" name="submit" value="Add Question" class="btn btn-success">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Question Type</th>
                            <th>Question</th>
                            <th>Options/Answer</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $res = mysqli_query($link, "SELECT * FROM questions WHERE category='$exam_category' ORDER BY question_no ASC");
                        while ($row = mysqli_fetch_array($res)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["question_no"]) . "</td>";
                            echo "<td>" . ucfirst(str_replace('_', ' ', htmlspecialchars($row["question_type"]))) . "</td>";
                            echo "<td>" . htmlspecialchars($row["question"]);
                            
                            if (!empty($row["attachment"])) {
                                echo "<br><a href='" . htmlspecialchars($row["attachment"]) . "' target='_blank'>View Attachment</a>";
                            }
                            echo "</td>";
                            
                            echo "<td>";
                    
                            switch($row["question_type"]) {
                                case "multiple_choice":
                                    echo "<strong>Options:</strong><br>";
                                    echo "1. " . htmlspecialchars($row["opt1"]) . "<br>";
                                    echo "2. " . htmlspecialchars($row["opt2"]) . "<br>";
                                    echo "3. " . htmlspecialchars($row["opt3"]) . "<br>";
                                    echo "4. " . htmlspecialchars($row["opt4"]) . "<br>";
                                    echo "<strong>Correct Answer:</strong> " . htmlspecialchars($row["answer"]);
                                    break;
                                    
                                case "true_false":
                                    echo "<strong>Correct Answer:</strong> " . htmlspecialchars($row["answer"]);
                                    break;
                                    
                                case "text_answer":
                                    echo "<strong>Correct Answer:</strong> " . htmlspecialchars($row["correct_text"]);
                                    break;
                            }
                            echo "</td>";
                            
                            echo "<td><a href='edit_option.php?id=" . $row["id"] . "&id1=$id' class='btn btn-primary btn-sm'>Edit</a></td>";
                            echo "<td><a href='delete_option.php?id=" . $row["id"] . "&id1=$id' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this question?\")'>Delete</a></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
    </div>
</div>

<?php
if (isset($_POST["submit"])) {
    $loop = 0;
    $res = mysqli_query($link, "SELECT * FROM questions WHERE category='$exam_category' ORDER BY question_no ASC");
    while ($row = mysqli_fetch_array($res)) {
        $loop = $row["question_no"];
    }
    $loop += 1;

    $question = mysqli_real_escape_string($link, $_POST['question']);
    $question_type = mysqli_real_escape_string($link, $_POST['question_type']);
    
    $opt1 = $opt2 = $opt3 = $opt4 = $answer = $correct_text = "";
    $fopt1 = $fopt2 = $fopt3 = $fopt4 = $fanswer = NULL;
    
    switch($question_type) {
        case "multiple_choice":
            $opt1 = mysqli_real_escape_string($link, $_POST['opt1']);
            $opt2 = mysqli_real_escape_string($link, $_POST['opt2']);
            $opt3 = mysqli_real_escape_string($link, $_POST['opt3']);
            $opt4 = mysqli_real_escape_string($link, $_POST['opt4']);
            $answer = mysqli_real_escape_string($link, $_POST['answer']);
            break;
            
        case "true_false":
            $answer = mysqli_real_escape_string($link, $_POST['answer']);
            break;
            
        case "text_answer":
            $correct_text = mysqli_real_escape_string($link, $_POST['correct_text']);
            break;
    }

    $query = "INSERT INTO questions (
        question_no, 
        question_type, 
        question, 
        opt1, 
        opt2, 
        opt3, 
        opt4, 
        answer,
        fopt1,
        fopt2,
        fopt3,
        fopt4,
        fanswer,
        correct_text,
        category
    ) VALUES (
        '$loop',
        '$question_type',
        '$question',
        " . ($opt1 ? "'$opt1'" : "NULL") . ",
        " . ($opt2 ? "'$opt2'" : "NULL") . ",
        " . ($opt3 ? "'$opt3'" : "NULL") . ",
        " . ($opt4 ? "'$opt4'" : "NULL") . ",
        " . ($answer ? "'$answer'" : "NULL") . ",
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        " . ($correct_text ? "'$correct_text'" : "NULL") . ",
        '$exam_category'
    )";

    if (!mysqli_query($link, $query)) {
        echo "Error: " . mysqli_error($link);
    } else {

        echo "<script type='text/javascript'>
            alert('Question added successfully!');
            window.location.href = window.location.href;
        </script>";
    }
}
?>

<script>
    document.querySelector('[name="question_type"]').addEventListener('change', function() {
        var questionType = this.value;
        
        document.getElementById('multiple-choice-fields').style.display = 'none';
        document.getElementById('true-false-fields').style.display = 'none';
        document.getElementById('text-answer-fields').style.display = 'none';
        
        if (questionType === 'multiple_choice') {
            document.getElementById('multiple-choice-fields').style.display = 'block';
        } else if (questionType === 'true_false') {
            document.getElementById('true-false-fields').style.display = 'block';
        } else if (questionType === 'text_answer') {
            document.getElementById('text-answer-fields').style.display = 'block';
        }
    });
</script>

<?php include "footer.php"; ?>
