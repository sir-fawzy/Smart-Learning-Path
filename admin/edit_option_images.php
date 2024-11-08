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
$res = mysqli_query($link, "SELECT * FROM questions WHERE id='$id'");
while ($row = mysqli_fetch_array($res)) {

    $question = $row["question"];
    $opt1 = $row["opt1"];
    $opt2 = $row["opt2"];
    $opt3 = $row["opt3"];
    $opt4 = $row["opt4"];
    $answer = $row["answer"];
}
?>

<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Update Questions with Images</h1>
            </div>


        </div>

    </div>

</div>

<div class="col-lg-12">
    <form name="form2" action="" method="post" enctype="multipart/form-data">
        <div class="card">
            <div class="card-header"><strong>Add New Questions with Images</strong></div>
            <div class="card-body card-block">
                <div class="form-group">
                    <label for="company" class="form-control-label">Question</label>
                    <input type="text" name="fquestion" placeholder="Add Question" class="form-control"
                        value="<?php echo $question; ?>">
                </div>
                <div class="form-group">
                    <label for="vat" class="form-control-label">Add Option 1</label>
                    <input type="file" class="form-control" name="fopt1" style="padding-bottom: 15px;">
                </div>
                <div class="form-group">
                    <label for="vat" class="form-control-label">Add Option 2</label>
                    <input type="file" class="form-control" name="fopt2" style="padding-bottom: 15px;">
                </div>
                <div class="form-group">
                    <label for="vat" class="form-control-label">Add Option 3</label>
                    <input type="file" class="form-control" name="fopt3" style="padding-bottom: 15px;">
                </div>
                <div class="form-group">
                    <label for="vat" class="form-control-label">Add Option 4</label>
                    <input type="file" class="form-control" name="fopt4" style="padding-bottom: 15px;">
                </div>
                <div class="form-group">
                    <label for="vat" class="form-control-label">Add Correct Answer</label>
                    <input type="file" class="form-control" name="fanswer" style="padding-bottom: 15px;">
                </div>
                <div class="form-group">
                    <input type="submit" name="submit2" value="Add Question" class="btn btn-success">
                </div>
            </div>
        </div>
    </form>
</div>


<?php
include "footer.php";
?>