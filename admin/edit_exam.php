<?php 
include "header.php"; 
include "../connection.php";

$id = $_GET["id"];
$res = mysqli_query($link, "SELECT * FROM exam_category WHERE id = $id");
while ($row = mysqli_fetch_array($res)) {
   $assessment_name = $row["category"];
   $assessment_category = $row["assessment_category"];
   $due_date = $row["due_date"];
   $time_limit = $row["time_limit"];
}
?>

<div class="breadcrumbs">
   <div class="col-sm-4">
       <div class="page-header float-left">
           <div class="page-title">
               <h1>Edit Assessment</h1>
           </div>
       </div>
   </div>
</div>

<div class="content mt-3">
   <div class="animated fadeIn">
       <div class="row">
           <div class="col-lg-12">
               <div class="card">
                   <form name="form1" action="" method="post">
                       <div class="card-body">
                           <div class="col-lg-6">
                               <div class="card">
                                   <div class="card-header"><strong>Edit Assessment Details</strong></div>
                                   <div class="card-body card-block">
                                       <div class="form-group">
                                           <label for="assessment_name" class="form-control-label">Assessment Name</label>
                                           <input type="text" name="assessmentname" placeholder="Assessment Name" class="form-control" value="<?php echo $assessment_name; ?>">
                                       </div>

                                       <div class="form-group">
                                           <label for="assessment_category" class="form-control-label">Assessment Category</label>
                                           <select name="assessment_category" class="form-control">
                                               <option value="homework" <?php if($assessment_category == 'homework') echo 'selected'; ?>>Homework</option>
                                               <option value="quiz" <?php if($assessment_category == 'quiz') echo 'selected'; ?>>Quiz</option>
                                               <option value="exercise" <?php if($assessment_category == 'exercise') echo 'selected'; ?>>Exercise</option>
                                               <option value="test" <?php if($assessment_category == 'test') echo 'selected'; ?>>Test</option>
                                           </select>
                                       </div>

                                       <div class="form-group">
                                           <label for="due_date" class="form-control-label">Due Date</label>
                                           <input type="date" name="due_date" class="form-control" value="<?php echo $due_date; ?>">
                                       </div>

                                       <div class="form-group">
                                           <label for="time_limit" class="form-control-label">Time Limit (minutes)</label>
                                           <input type="text" placeholder="Time Limit" class="form-control" name="time_limit" value="<?php echo $time_limit; ?>">
                                       </div>

                                       <div class="form-group">
                                           <input type="submit" name="submit1" value="Update Assessment" class="btn btn-success">
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </form>
               </div>
           </div>
       </div>
   </div>
</div>

<?php
if (isset($_POST["submit1"])) {
   mysqli_query($link, "UPDATE exam_category SET 
       category = '$_POST[assessmentname]', 
       assessment_category = '$_POST[assessment_category]',
       due_date = '$_POST[due_date]',
       time_limit = '$_POST[time_limit]'
       WHERE id = $id") or die(mysqli_error($link));
   ?>
   <script type="text/javascript">
       alert("Assessment updated successfully!");
       window.location = "exam_category.php";
   </script>
   <?php
}
?>

<?php
include "footer.php";
?>