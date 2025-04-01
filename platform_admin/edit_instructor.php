<?php
include "../connection.php";

if (!isset($_GET['id'])) {
    header("Location: manage_instructors.php");
    exit();
}

$instructor_id = $_GET['id'];

// Handle form submission for updates
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];
    $status = $_POST['status'];

    $update_query = "UPDATE instructors SET 
                    first_name = ?, 
                    last_name = ?, 
                    email = ?, 
                    phone = ?, 
                    department = ?, 
                    status = ? 
                    WHERE instructor_id = ?";
                    
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssssssi", $first_name, $last_name, $email, $phone, $department, $status, $instructor_id);
    
    if ($stmt->execute()) {
        $success_message = "Instructor updated successfully!";
    } else {
        $error_message = "Error updating instructor: " . $conn->error;
    }
    $stmt->close();
}

// Fetch instructor data
$query = "SELECT * FROM instructors WHERE instructor_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $instructor_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: manage_instructors.php");
    exit();
}

$instructor = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Instructor</title>
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
                    <a href="manage_instructors.php" class="active"><i class="fas fa-user-edit me-2"></i> Manage Instructors</a>
                    <a href="add_class.php"><i class="fas fa-school me-2"></i> Add Class</a>
                    <a href="manage_classes.php"><i class="fas fa-book-open me-2"></i> Manage Classes</a>
                    <a href="#"><i class="fas fa-users me-2"></i> Manage Users</a>
                    <a href="#"><i class="fas fa-chart-bar me-2"></i> Reports</a>
                    <a href="#"><i class="fas fa-cog me-2"></i> Settings</a>
                </div>
            </div>

            <!-- Main content -->
            <div class="col-md-9 col-lg-10 content">
                <div class="admin-header">
                    <h1><i class="fas fa-edit me-2"></i>Edit Instructor</h1>
                    <p class="text-muted">Modify instructor information</p>
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
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $instructor['first_name']; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $instructor['last_name']; ?>" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $instructor['email']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $instructor['phone']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="department" class="form-label">Department</label>
                                <input type="text" class="form-control" id="department" name="department" value="<?php echo $instructor['department']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="active" <?php echo ($instructor['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                                    <option value="inactive" <?php echo ($instructor['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="manage_instructors.php" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Back to List</a>
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

</html>b 