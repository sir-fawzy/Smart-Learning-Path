<?php
// ...existing code...

// Get available courses for dropdown
$courses_query = mysqli_query($conn, "SELECT id, course_name FROM course_list");

// Handle form submission with course_id
if (isset($_POST["submit"])) {
    $lecture_name = $_POST["lecture_name"];
    $course_id = $_POST["course_id"]; // Get course_id from form

    $target_dir = "lecture/";
    // ...existing code...

    // Insert query with course_id
    mysqli_query($conn, "INSERT INTO lecture_list(lecture_name, lecture_file, course_id) VALUES('$lecture_name', '$lecture_file', '$course_id')") or die(mysqli_error($conn));

    // ...existing code...
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Upload Lecture</strong>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="">Lecture Name</label>
                        <input type="text" name="lecture_name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="course_id">Select Course</label>
                        <select name="course_id" class="form-control" required>
                            <option value="">Select Course</option>
                            <?php while ($course = mysqli_fetch_array($courses_query)): ?>
                                <option value="<?php echo $course['id']; ?>"><?php echo $course['course_name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Upload Lecture</label>
                        <input type="file" name="my_file" class="form-control">
                    </div>

                    <!-- ...existing code... -->
                </form>
            </div>
        </div>
    </div>
</div>

<!-- List of lectures with course filter -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Lecture List</strong>

                <div class="float-right">
                    <form class="form-inline" method="get">
                        <select name="filter_course" class="form-control mr-2" onchange="this.form.submit()">
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
                            <th>Sr.</th>
                            <th>Lecture Name</th>
                            <th>Course</th>
                            <th>File</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $course_filter = "";
                        if (isset($_GET['filter_course']) && !empty($_GET['filter_course'])) {
                            $course_filter = "WHERE course_id = " . $_GET['filter_course'];
                        }

                        $res = mysqli_query($conn, "SELECT l.*, c.course_name FROM lecture_list l 
                                            LEFT JOIN course_list c ON l.course_id = c.id 
                                            $course_filter 
                                            ORDER BY l.id DESC");
                        $count = 1;
                        while ($row = mysqli_fetch_array($res)):
                            ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo $row["lecture_name"]; ?></td>
                                <td><?php echo $row["course_name"]; ?></td>
                                <td><a href="lecture/<?php echo $row["lecture_file"]; ?>" target="_blank">View File</a></td>
                                <td>
                                    <!-- ...existing code... -->
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>