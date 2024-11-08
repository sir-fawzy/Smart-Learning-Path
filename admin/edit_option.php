<?php
include "header.php";
include "../connection.php";

// Get the 'id' from the URL
$id = $_GET["id"];
$id1 = $_GET["id1"];

// Initialize variables for question data
$question = "";
$opt1 = "";
$opt2 = "";
$opt3 = "";
$opt4 = "";
$answer = "";

// Fetch question details based on the 'id'
$res = mysqli_query($link, "SELECT * FROM questions WHERE id='$id'"); // Changed to use $id in the query for specific record
if ($res && mysqli_num_rows($res) > 0) { // Added check to ensure the query was successful and returned rows
    $row = mysqli_fetch_array($res); // Fixed typo in while loop; used '=' for assignment instead of '-'
    $question = $row["question"];
    $opt1 = $row["opt1"];
    $opt2 = $row["opt2"];
    $opt3 = $row["opt3"];
    $opt4 = $row["opt4"];
    $answer = $row["answer"];
} else {
    die("Query failed: " . mysqli_error($link)); // Added error handling to display the query error message if it fails
}
?>

<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Update Question</h1>
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
                        <div class="col-lg-12">
                            <form name="form1" action="" method="post" enctype="multipart/form-data">
                                <div class="card">
                                    <div class="card-header"><strong>Update Questions with Text</strong></div>
                                    <div class="card-body card-block">
                                        <div class="form-group">
                                            <label for="company" class="form-control-label">Add Question</label>
                                            <input type="text" name="question" placeholder="Add Question"
                                                class="form-control" value="<?php echo $question; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="vat" class="form-control-label">Add Option 1</label>
                                            <input type="text" placeholder="Option 1" class="form-control" name="opt1"
                                                value="<?php echo $opt1; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="vat" class="form-control-label">Add Option 2</label>
                                            <input type="text" placeholder="Option 2" class="form-control" name="opt2"
                                                value="<?php echo $opt2; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="vat" class="form-control-label">Add Option 3</label>
                                            <input type="text" placeholder="Option 3" class="form-control" name="opt3"
                                                value="<?php echo $opt3; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="vat" class="form-control-label">Add Option 4</label>
                                            <input type="text" placeholder="Option 4" class="form-control" name="opt4"
                                                value="<?php echo $opt4; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="vat" class="form-control-label">Add Correct Answer</label>
                                            <input type="text" placeholder="Answer" class="form-control" name="answer"
                                                value="<?php echo $answer; ?>">
                                            <!-- Added value to retain current answer -->
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" name="submit1" value="Update Question"
                                                class="btn btn-success">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- .card -->
            </div>
            <!--/.col-->
        </div>
    </div><!-- .animated -->
</div><!-- .content -->
</div><!-- /#right-panel -->
<!-- Right Panel -->

<?php
/* Update the options */
if (isset($_POST["submit1"])) {
    // Update the question details using form inputs
    $question = $_POST["question"];
    $opt1 = $_POST["opt1"];
    $opt2 = $_POST["opt2"];
    $opt3 = $_POST["opt3"];
    $opt4 = $_POST["opt4"];
    $answer = $_POST["answer"];

    mysqli_query($link, "UPDATE questions SET question='$question', opt1='$opt1', opt2='$opt2', opt3='$opt3', opt4='$opt4', answer='$answer' WHERE id='$id'")
        or die(mysqli_error($link)); // Added WHERE clause to target specific question ID and error handling for update query

    ?>
    <script type="text/javascript">window.location = "add_edit_questions.php?id=<?php echo $id1 ?>"</script>
    <?php
}
?>

<?php
include "footer.php";
?>