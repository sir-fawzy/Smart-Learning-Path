<?php
include "header.php";
include "../connection.php";
$id = $_GET["id"];
$id1 = $_GET["id1"];

// Modify query to get the course_id for the selected exam category
$exam_category = '';
$course_id = 0;
$res = mysqli_query($conn, "SELECT ec.category, ec.course_id 
                          FROM exam_category ec 
                          WHERE ec.id=$_GET[id]");
while ($row = mysqli_fetch_array($res)) {
    $exam_category = $row["category"];
    $course_id = $row["course_id"];
}

?>

<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Add Questions inside <?php echo $exam_category; ?></h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li><a href="admin.php">Dashboard</a></li>
                    <li><a href="exam_category.php">Exam Category</a></li>
                    <li class="active">Add Questions</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Add Questions inside <?php echo $exam_category; ?></strong>
                    </div>
                    <div class="card-body">
                        <form name="form1" action="" method="post">
                            <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
                            <div class="form-group">
                                <label for="question" class="form-control-label">Add Question</label>
                                <input type="text" name="question" placeholder="Add Question" class="form-control"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="opt1" class="form-control-label">Add Option 1</label>
                                <input type="text" name="opt1" placeholder="Add Option 1" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="opt2" class="form-control-label">Add Option 2</label>
                                <input type="text" name="opt2" placeholder="Add Option 2" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="opt3" class="form-control-label">Add Option 3</label>
                                <input type="text" name="opt3" placeholder="Add Option 3" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="opt4" class="form-control-label">Add Option 4</label>
                                <input type="text" name="opt4" placeholder="Add Option 4" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="answer" class="form-control-label">Add Answer</label>
                                <input type="text" name="answer" placeholder="Add Answer" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" value="Add Question" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Exam Questions</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Questions</th>
                                    <th scope="col">Opt1</th>
                                    <th scope="col">Opt2</th>
                                    <th scope="col">Opt3</th>
                                    <th scope="col">Opt4</th>
                                    <th scope="col">Answer</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $res = mysqli_query($conn, "SELECT * FROM questions WHERE category='$_GET[id]' AND course_id='$course_id'");
                                $count = 0;
                                while ($row = mysqli_fetch_array($res)) {
                                    $count = $count + 1;
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $count; ?></th>
                                        <td><?php echo $row["question"]; ?></td>
                                        <td><?php echo $row["opt1"]; ?></td>
                                        <td><?php echo $row["opt2"]; ?></td>
                                        <td><?php echo $row["opt3"]; ?></td>
                                        <td><?php echo $row["opt4"]; ?></td>
                                        <td><?php echo $row["answer"]; ?></td>
                                        <td><a
                                                href="edit_option.php?id=<?php echo $row["id"]; ?>&id1=<?php echo $id; ?>">Edit</a>
                                        </td>
                                        <td><a
                                                href="delete_option.php?id=<?php echo $row["id"]; ?>&id1=<?php echo $id; ?>">Delete</a>
                                        </td>
                                    </tr>
                                <?php } ?>
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
    $question = mysqli_real_escape_string($conn, $_POST['question']);
    $opt1 = mysqli_real_escape_string($conn, $_POST['opt1']);
    $opt2 = mysqli_real_escape_string($conn, $_POST['opt2']);
    $opt3 = mysqli_real_escape_string($conn, $_POST['opt3']);
    $opt4 = mysqli_real_escape_string($conn, $_POST['opt4']);
    $answer = mysqli_real_escape_string($conn, $_POST['answer']);

    mysqli_query($conn, "INSERT INTO questions(question, opt1, opt2, opt3, opt4, answer, category, course_id) 
                         VALUES ('$question', '$opt1', '$opt2', '$opt3', '$opt4', '$answer', '$_GET[id]', '$course_id')") or die(mysqli_error($conn));
    ?>
    <script type="text/javascript">
        alert("Question added successfully");
        window.location.href = window.location.href;
    </script>
    <?php
}
?>

<?php
include "footer.php";
?>