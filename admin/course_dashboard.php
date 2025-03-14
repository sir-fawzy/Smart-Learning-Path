<?php
include "header.php";
include "../connection.php";

$course_id = $_GET['id'];
$query = "SELECT * FROM courses WHERE id = $course_id";
$result = mysqli_query($link, $query);
$course = mysqli_fetch_assoc($result);
?>

<div class="content mt-3">
    <h2><?php echo $course['course_name']; ?> (<?php echo $course['course_code']; ?>)</h2>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>Course Materials</h5>
                    <a href="upload_lecture.php?course_id=<?php echo $course_id; ?>" class="btn btn-primary">
                        Add Lecture Materials
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>Assessments</h5>
                    <a href="exam_category.php?course_id=<?php echo $course_id; ?>" class="btn btn-primary">
                        Manage Assessments
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>Students</h5>
                    <a href="manage_students.php?course_id=<?php echo $course_id; ?>" class="btn btn-primary">
                        Manage Students
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>