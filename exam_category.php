<?php
// ...existing code...

// Get available courses for dropdown
$courses_query = mysqli_query($conn, "SELECT id, course_name FROM course_list");

// Update form handling to include course_id
if (isset($_POST["submit1"])) {
    mysqli_query($conn, "INSERT INTO exam_category(category, course_id) VALUES('$_POST[examname]', '$_POST[course_id]')") or die(mysqli_error($conn));

    // ...existing code...
}

// Update edit functionality
if (isset($_POST["submit2"])) {
    mysqli_query($conn, "UPDATE exam_category SET category='$_POST[examname]', course_id='$_POST[course_id]' WHERE id=$_GET[edit]") or die(mysqli_error($conn));

    // ...existing code...
}
?>

<div class="breadcrumbs">
    <!-- ...existing code... -->
</div>

<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <strong class="card-title">Add Exam Category</strong>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-lg-6">
                            <div class="card">
                                <form name="form1" action="" method="post">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="examname" class="control-label mb-1">New Exam Category</label>
                                            <input id="examname" name="examname" type="text" class="form-control"
                                                value="<?php if (isset($_GET["edit"])) {
                                                    echo $examname;
                                                } ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="course_id" class="control-label mb-1">Select Course</label>
                                            <select name="course_id" id="course_id" class="form-control" required>
                                                <option value="">Select Course</option>
                                                <?php
                                                mysqli_data_seek($courses_query, 0);
                                                while ($course = mysqli_fetch_array($courses_query)):
                                                    $selected = '';
                                                    if (isset($_GET["edit"]) && $course_id == $course['id']) {
                                                        $selected = 'selected';
                                                    }
                                                    ?>
                                                    <option value="<?php echo $course['id']; ?>" <?php echo $selected; ?>>
                                                        <?php echo $course['course_name']; ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>

                                        <div>
                                            <?php
                                            if (isset($_GET["edit"])) {
                                                ?>
                                                <input type="submit" name="submit2" value="Update Exam"
                                                    class="btn btn-success">
                                                <?php
                                            } else {
                                                ?>
                                                <input type="submit" name="submit1" value="Add Exam"
                                                    class="btn btn-success">
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <strong class="card-title">Exam Categories</strong>

                                    <div class="float-right">
                                        <form class="form-inline" method="get">
                                            <select name="filter_course" class="form-control mr-2"
                                                onchange="this.form.submit()">
                                                <option value="">All Courses</option>
                                                <?php
                                                $course_filter_query = mysqli_query($conn, "SELECT id, course_name FROM course_list");
                                                while ($cf = mysqli_fetch_array($course_filter_query)):
                                                    $selected = (isset($_GET['filter_course']) && $_GET['filter_course'] == $cf['id']) ? 'selected' : '';
                                                    ?>
                                                    <option value="<?php echo $cf['id']; ?>" <?php echo $selected; ?>>
                                                        <?php echo $cf['course_name']; ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Exam Name</th>
                                                <th scope="col">Course</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $course_filter = "";
                                            if (isset($_GET['filter_course']) && !empty($_GET['filter_course'])) {
                                                $course_filter = "WHERE ec.course_id = " . $_GET['filter_course'];
                                            }

                                            $count = 0;
                                            $res = mysqli_query($conn, "SELECT ec.*, c.course_name 
                                                              FROM exam_category ec 
                                                              LEFT JOIN course_list c ON ec.course_id = c.id 
                                                              $course_filter 
                                                              ORDER BY ec.id DESC");
                                            while ($row = mysqli_fetch_array($res)) {
                                                $count = $count + 1;
                                                ?>
                                                <tr>
                                                    <th scope="row"><?php echo $count; ?></th>
                                                    <td><?php echo $row["category"]; ?></td>
                                                    <td><?php echo $row["course_name"]; ?></td>
                                                    <td>
                                                        <a href="?edit=<?php echo $row["id"]; ?>">Edit</a>
                                                        &nbsp;
                                                        <a href="?delete=<?php echo $row["id"]; ?>"
                                                            onclick="return confirm('Are you sure?')">Delete</a>
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
        </div>
    </div>
</div>

<?php
// Make sure if edit is set, we populate the form correctly
if (isset($_GET["edit"])) {
    $res = mysqli_query($conn, "SELECT * FROM exam_category WHERE id=$_GET[edit]");
    while ($row = mysqli_fetch_array($res)) {
        $examname = $row["category"];
        $course_id = $row["course_id"];
    }
}

// ...existing code...
?>