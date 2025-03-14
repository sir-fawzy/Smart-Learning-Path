<?php
include "header.php";
include "../connection.php";
?>

<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">My Courses</strong>
                        <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addCourseModal">
                            Add New Course
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php
                            $query = "SELECT * FROM courses WHERE instructor_id = $_SESSION[admin_id]";
                            $result = mysqli_query($link, $query);

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<div class='col-md-4 mb-4'>";
                                echo "<div class='card'>";
                                echo "<div class='card-body'>";
                                echo "<h5 class='card-title'>{$row['course_code']}</h5>";
                                echo "<h6 class='card-subtitle mb-2 text-muted'>{$row['course_name']}</h6>";
                                echo "<p class='card-text'>{$row['description']}</p>";
                                echo "<a href='course_dashboard.php?id={$row['id']}' class='btn btn-primary'>Enter Course</a>";
                                echo "</div></div></div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Course Modal -->
<div class="modal fade" id="addCourseModal" tabindex="-1" role="dialog" aria-labelledby="addCourseModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCourseModalLabel">Add New Course</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Course Code</label>
                        <input type="text" class="form-control" name="course_code" required>
                    </div>
                    <div class="form-group">
                        <label>Course Name</label>
                        <input type="text" class="form-control" name="course_name" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="add_course" class="btn btn-primary">Save Course</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
if (isset($_POST['add_course'])) {
    $course_code = mysqli_real_escape_string($link, $_POST['course_code']);
    $course_name = mysqli_real_escape_string($link, $_POST['course_name']);
    $description = mysqli_real_escape_string($link, $_POST['description']);

    $query = "INSERT INTO courses (course_code, course_name, description, instructor_id) 
              VALUES ('$course_code', '$course_name', '$description', $_SESSION[admin_id])";

    if (mysqli_query($link, $query)) {
        echo "<script>alert('Course added successfully!');</script>";
        echo "<script>window.location.href='courses.php';</script>";
    } else {
        echo "<script>alert('Error adding course!');</script>";
    }
}
?>