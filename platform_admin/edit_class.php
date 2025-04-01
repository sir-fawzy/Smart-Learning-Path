<?php
include "../connection.php";

if (!isset($_GET['id'])) {
    header("Location: manage_classes.php");
    exit();
}

$class_id = $_GET['id'];

// Handle form submission for updates
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $class_name = $_POST['class_name'];
    $instructor_id = $_POST['instructor_id'];
    $schedule = $_POST['schedule'];
    $location = $_POST['location'];
    $capacity = $_POST['capacity'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    $update_query = "UPDATE classes SET 
                    class_name = ?, 
                    instructor_id = ?, 
                    schedule = ?, 
                    location = ?, 
                    capacity = ?, 
                    description = ?, 
                    status = ? 
                    WHERE class_id = ?";
                    
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sisssssi", $class_name, $instructor_id, $schedule, $location, $capacity, $description, $status, $class_id);
    
    if ($stmt->execute()) {
        $success_message = "Class updated successfully!";
    } else {
        $error_message = "Error updating class: " . $conn->error;
    }
    $stmt->close();
}

// Fetch class data
$query = "SELECT * FROM classes WHERE class_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $class_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: manage_classes.php");
    exit();
}

$class = $result->fetch_assoc();
$stmt->close();

// Fetch all instructors for dropdown
$instructors_query = "SELECT instructor_id, CONCAT(first_name, ' ', last_name) AS instructor_name FROM instructors WHERE status = 'active' ORDER BY last_name";
$instructors_result = $conn->query($instructors_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Class</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            color: white;
        }

        .sidebar a {
            color: rgba(255, 255, 255, .75);
            text-decoration: none;
            padding: 10px 20px;
            display: block;
            transition: all 0.3s;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, .1);
            color: white;
        }

        .content {
            padding: 20px;
        }

        .admin-header {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar py-3">
                <h5 class="text-center mb-4">Admin Dashboard</h5>
                <div class="nav flex-column">
                    <a href="index.php"><i class="fas fa-home me-2"></i> Dashboard</a>
                    <a href="add_instructor.php"><i class="fas fa-chalkboard-teacher me-2"></i> Add Instructor</a>
                    <a href="manage_instructors.php"><i class="fas fa-user-edit me-2"></i> Manage Instructors</a>
                    <a href="add_class.php"><i class="fas fa-school me-2"></i> Add Class</a>
                    <a href="manage_classes.php" class="active"><i class="fas fa-book-open me-2"></i> Manage Classes</a>
                    <a href="#"><i class="fas fa-users me-2"></i> Manage Users</a>
                    <a href="#"><i class="fas fa-chart-bar me-2"></i> Reports</a>
                    <a href="#"><i class="fas fa-cog me-2"></i> Settings</a>
                </div>
            </div>

            <!-- Main content -->
            <div class="col-md-9 col-lg-10 content">
                <div class="admin-header">
                    <h1><i class="fas fa-edit me-2"></i>Edit Class</h1>
                    <p class="text-muted">Modify class information</p>
                </div>

                <?php if (isset($success_message)) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $success_message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($error_message)) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $error_message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="class_name" class="form-label">Class Name</label>
                                <input type="text" class="form-control" id="class_name" name="class_name" value="<?php echo $class['class_name']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="instructor_id" class="form-label">Instructor</label>
                                <select class="form-select" id="instructor_id" name="instructor_id" required>
                                    <option value="">Select an instructor</option>
                                    <?php while ($instructor = $instructors_result->fetch_assoc()) : ?>
                                        <option value="<?php echo $instructor['instructor_id']; ?>" <?php echo ($class['instructor_id'] == $instructor['instructor_id']) ? 'selected' : ''; ?>>
                                            <?php echo $instructor['instructor_name']; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="schedule" class="form-label">Schedule</label>
                                <input type="text" class="form-control" id="schedule" name="schedule" value="<?php echo $class['schedule']; ?>" placeholder="e.g. Monday, Wednesday 2:00 PM - 3:30 PM" required>
                            </div>
                            <div class="mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control" id="location" name="location" value="<?php echo $class['location']; ?>" placeholder="e.g. Room 101" required>
                            </div>
                            <div class="mb-3">
                                <label for="capacity" class="form-label">Capacity</label>
                                <input type="number" class="form-control" id="capacity" name="capacity" value="<?php echo $class['capacity']; ?>" min="1" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"><?php echo $class['description']; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="active" <?php echo ($class['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                                    <option value="inactive" <?php echo ($class['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="manage_classes.php" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Back to List</a>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>