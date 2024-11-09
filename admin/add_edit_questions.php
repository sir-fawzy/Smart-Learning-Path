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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-6">
                            <form name="form1" action="" method="post" enctype="multipart/form-data">
                                <div class="card">
                                    <div class="card-header"><strong>Add New Questions with Text</strong></div>
                                    <div class="card-body card-block">
                                        <div class="form-group">
                                            <label for="company" class="form-control-label">Question</label>
                                            <input type="text" name="question" placeholder="Add Question"
                                                class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="vat" class="form-control-label">Add Option 1</label>
                                            <input type="text" placeholder="Option 1" class="form-control" name="opt1">
                                        </div>
                                        <div class="form-group">
                                            <label for="vat" class="form-control-label">Add Option 2</label>
                                            <input type="text" placeholder="Option 2" class="form-control" name="opt2">
                                        </div>
                                        <div class="form-group">
                                            <label for="vat" class="form-control-label">Add Option 3</label>
                                            <input type="text" placeholder="Option 3" class="form-control" name="opt3">
                                        </div>
                                        <div class="form-group">
                                            <label for="vat" class="form-control-label">Add Option 4</label>
                                            <input type="text" placeholder="Option 4" class="form-control" name="opt4">
                                        </div>
                                        <div class="form-group">
                                            <label for="vat" class="form-control-label">Add Correct Answer</label>
                                            <input type="text" placeholder="Answer" class="form-control" name="answer">
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" name="submit1" value="Add Question"
                                                class="btn btn-success">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-lg-6">
                            <form name="form2" action="" method="post" enctype="multipart/form-data">
                                <div class="card">
                                    <div class="card-header"><strong>Add New Questions with Images</strong></div>
                                    <div class="card-body card-block">
                                        <div class="form-group">
                                            <label for="company" class="form-control-label">Question</label>
                                            <input type="text" name="fquestion" placeholder="Add Question"
                                                class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="vat" class="form-control-label">Add Option 1</label>
                                            <input type="file" class="form-control" name="fopt1"
                                                style="padding-bottom: 15px;">
                                        </div>
                                        <div class="form-group">
                                            <label for="vat" class="form-control-label">Add Option 2</label>
                                            <input type="file" class="form-control" name="fopt2"
                                                style="padding-bottom: 15px;">
                                        </div>
                                        <div class="form-group">
                                            <label for="vat" class="form-control-label">Add Option 3</label>
                                            <input type="file" class="form-control" name="fopt3"
                                                style="padding-bottom: 15px;">
                                        </div>
                                        <div class="form-group">
                                            <label for="vat" class="form-control-label">Add Option 4</label>
                                            <input type="file" class="form-control" name="fopt4"
                                                style="padding-bottom: 15px;">
                                        </div>
                                        <div class="form-group">
                                            <label for="vat" class="form-control-label">Add Correct Answer</label>
                                            <input type="file" class="form-control" name="fanswer"
                                                style="padding-bottom: 15px;">
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" name="submit2" value="Add Question"
                                                class="btn btn-success">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- .card -->
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>No</th>
                                <th>Questions</th>
                                <th>Opt1</th>
                                <th>Opt2</th>
                                <th>Opt3</th>
                                <th>Opt4</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>

                            <?php
                            $res = mysqli_query($link, "SELECT * FROM questions WHERE category='$exam_category' ORDER BY question_no ASC");
                            while ($row = mysqli_fetch_array($res)) {
                                echo "<tr>";
                                echo "<td>" . $row["question_no"] . "</td>";
                                echo "<td>" . $row["question"] . "</td>";

                                for ($i = 1; $i <= 4; $i++) {
                                    $opt = "opt" . $i;
                                    echo "<td>";
                                    if (strpos($row[$opt], "./images/opt_images/") !== false) {
                                        echo '<img src="' . $row[$opt] . '" height="50" width="50">';
                                    } else {
                                        echo $row[$opt];
                                    }
                                    echo "</td>";
                                }

                                echo "<td>";
                                if (strpos($row["opt4"], "./images/opt_images/") !== false) {
                                    ?>
                                    <a href='edit_option_images.php?id=" . $row["id"] . "&id1=" . $id . "'>Edit</a>
                                    <?php
                                } else {
                                    ?>
                                    <a href='edit_option.php?id=" . $row["id"] . "&id1=" . $id . "'>Edit</a>
                                    <?php
                                }
                                echo "</td>";
                                echo "<td><a href='delete_option.php?id=" . $row["id"] . "&id1=" . $id . "'>Delete</a></td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST["submit1"])) {
    $loop = 0;
    $count = 0;
    $res = mysqli_query($link, "SELECT * FROM questions WHERE category='$exam_category' ORDER BY id ASC");

    while ($row = mysqli_fetch_array($res)) {
        $loop += 1;
        mysqli_query($link, "UPDATE questions SET question_no='$loop' WHERE id=" . $row['id']);
    }

    $loop += 1;
    $question = mysqli_real_escape_string($link, $_POST['question']);
    $opt1 = mysqli_real_escape_string($link, $_POST['opt1']);
    $opt2 = mysqli_real_escape_string($link, $_POST['opt2']);
    $opt3 = mysqli_real_escape_string($link, $_POST['opt3']);
    $opt4 = mysqli_real_escape_string($link, $_POST['opt4']);
    $answer = mysqli_real_escape_string($link, $_POST['answer']);

    mysqli_query($link, "INSERT INTO questions VALUES (NULL, '$loop', '$question', '$opt1', '$opt2', '$opt3', '$opt4', '$answer', '$exam_category')");
    echo "<script type='text/javascript'>alert('Question added successfully'); window.location.href=window.location.href;</script>";
}
?>

<?php
if (isset($_POST["submit2"])) {
    $loop = 0;
    $count = 0;
    $res = mysqli_query($link, "SELECT * FROM questions WHERE category='$exam_category' ORDER BY id ASC");

    while ($row = mysqli_fetch_array($res)) {
        $loop += 1;
        mysqli_query($link, "UPDATE questions SET question_no='$loop' WHERE id=" . $row['id']);
    }

    $loop += 1;
    $fquestion = mysqli_real_escape_string($link, $_POST['fquestion']);
    $fopt1 = "./images/opt_images/" . basename($_FILES['fopt1']['name']);
    move_uploaded_file($_FILES['fopt1']['tmp_name'], $fopt1);

    $fopt2 = "./images/opt_images/" . basename($_FILES['fopt2']['name']);
    move_uploaded_file($_FILES['fopt2']['tmp_name'], $fopt2);

    $fopt3 = "./images/opt_images/" . basename($_FILES['fopt3']['name']);
    move_uploaded_file($_FILES['fopt3']['tmp_name'], $fopt3);

    $fopt4 = "./images/opt_images/" . basename($_FILES['fopt4']['name']);
    move_uploaded_file($_FILES['fopt4']['tmp_name'], $fopt4);

    $fanswer = "./images/opt_images/" . basename($_FILES['fanswer']['name']);
    move_uploaded_file($_FILES['fanswer']['tmp_name'], $fanswer);

    // Image upload and saving logic here
    mysqli_query($link, "INSERT INTO questions VALUES (NULL, '$loop', '$fquestion', '$fopt1', '$fopt2', '$fopt3', '$fopt4', '$fanswer', '$exam_category')");
    echo "<script type='text/javascript'>alert('Image question added successfully'); window.location.href=window.location.href;</script>";
}
?>

<?php include "footer.php"; ?>