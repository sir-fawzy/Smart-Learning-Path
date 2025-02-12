<?php
include "header.php";
include "../connection.php";

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<div class="breadcrumbs">
    <div class="col-sm-12 col-md-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Add Assessment</h1>
            </div>
        </div>
    </div>
</div>

<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form name="form1" action="" method="post">
                        <div class="card-body">
                            <div class="card-header"><strong>Add Assessment Category</strong></div>
                            <div class="card-body card-block">
                                <div class="form-group">
                                    <label for="assessment_name" class="form-control-label">New Assessment Name</label>
                                    <input type="text" name="assessmentname" placeholder="Add Assessment Name"
                                        class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="assessment_category" class="form-control-label">Assessment
                                        Category</label>
                                    <select name="assessment_category" class="form-control">
                                        <option value="homework">Homework</option>
                                        <option value="quiz">Quiz</option>
                                        <option value="exercise">Exercise</option>
                                        <option value="test">Test</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="due_date" class="form-control-label">Due Date (Optional)</label>
                                    <input type="date" name="due_date" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="time_limit" class="form-control-label">Time Limit (Optional)</label>
                                    <input type="text" name="time_limit" placeholder="Time Limit (minutes)"
                                        class="form-control">
                                </div>

                                <div class="form-group">
                                    <input type="submit" name="submit1" value="Add Assessment" class="btn btn-success">
                                </div>
                            </div> <!-- .card-body -->
                        </div> <!-- .card -->
                    </form>
                </div>
            </div> <!-- .col -->
        </div> <!-- .row -->
    </div> <!-- .animated fadeIn -->
</div> <!-- .content -->

<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Assessment Categories</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Assessment Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Due Date</th>
                                    <th scope="col">Time Limit</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 0;
                                $res = mysqli_query($link, "SELECT * FROM exam_category");
                                while ($row = mysqli_fetch_array($res)) {
                                    $count++;
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $count; ?></th>
                                        <td><?php echo $row["category"]; ?></td>
                                        <td><?php echo ucfirst($row["assessment_category"]); ?></td>
                                        <td><?php echo $row["due_date"] ? $row["due_date"] : "Not Set"; ?></td>
                                        <td><?php echo $row["time_limit"] ? $row["time_limit"] . " minutes" : "Not Set"; ?>
                                        </td>
                                        <td><a href="edit_exam.php?id=<?php echo $row["id"]; ?>">Edit</a></td>
                                        <td><a href="delete.php?id=<?php echo $row["id"]; ?>">Delete</a></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- .col -->
        </div> <!-- .row -->
    </div> <!-- .animated fadeIn -->
</div> <!-- .content -->

<?php
if (isset($_POST["submit1"])) {
    $assessment_name = $_POST['assessmentname'];
    $assessment_category = $_POST['assessment_category'];

    if (!empty($_POST['due_date'])) {
        $due_date = $_POST['due_date']; // or "'" . mysqli_rea_escape_string($link, $_POST['due_date']) . "'";
    } else {
        $due_date = NULL;
    }

    if (!empty($_POST['time_limit'])) {
        $time_limit = $_POST['time_limit'];
    } else {
        $time_limit = NULL;
    }


    mysqli_query($link, "INSERT INTO exam_category (category, assessment_category, due_date, time_limit) 
                         VALUES ('$assessment_name', '$assessment_category', '$due_date', '$time_limit')")
        or die(mysqli_error($link));

    ?>
    <script type="text/javascript">
        alert("Assessment added successfully!");
        window.location.href = window.location.href;
    </script>
    <?php
}
?>

<?php
include "add_exam_questions(exam).php";
?>

<?php
include "footer.php";
?>