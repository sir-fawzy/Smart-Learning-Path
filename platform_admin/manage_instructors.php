<?php
session_start();
include "../connection.php";  // Ensure this file is included and has $link set up

// Check if the connection was successfully established
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Delete instructor if ID is provided
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Prepare the delete query
    $delete_query = "DELETE FROM instructors WHERE user_id = ?";
    $stmt = $link->prepare($delete_query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $success_message = "Instructor deleted successfully!";
    } else {
        $error_message = "Error deleting instructor: " . $link->error;
    }
    $stmt->close();
}

// Fetch all instructors and their class status from the classes table
$query = "
    SELECT i.user_id, i.first_name, i.last_name, i.email, i.phone, i.department, c.is_active AS class_status
    FROM instructors i
    LEFT JOIN classes c ON i.user_id = c.instructor_id
    ORDER BY i.last_name ASC
";
$result = $link->query($query);
if (!$result) {
    $error_message = "Error fetching instructors: " . $link->error;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Instructors</title>
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
                <div class="admin-header d-flex justify-content-between align-items-center">
                    <div>
                        <h1><i class="fas fa-chalkboard-teacher me-2"></i>Manage Instructors</h1>
                        <p class="text-muted">View, edit and delete instructors</p>
                    </div>
                    <a href="add_instructor.php" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add New Instructor</a>
                </div>

                <!-- Success or Error Message -->
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
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Department</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($result) && $result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                    ?>
                                            <tr>
                                                <td><?php echo $row['user_id']; ?></td>
                                                <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['phone']; ?></td>
                                                <td><?php echo $row['department']; ?></td>
                                                <td>
                                                    <?php if ($row['class_status'] == 1) : ?>
                                                        <span class="badge bg-success">Active</span>
                                                    <?php else : ?>
                                                        <span class="badge bg-secondary">Inactive</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="edit_instructor.php?id=<?php echo $row['user_id']; ?>" class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="manage_instructors.php?delete=<?php echo $row['user_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this instructor?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    <a href="view_instructor_classes.php?id=<?php echo $row['user_id']; ?>" class="btn btn-sm btn-info text-white">
                                                        <i class="fas fa-books"></i> Classes
                                                    </a>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                    ?>
                                        <tr>
                                            <td colspan="7" class="text-center">No instructors found</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
