<?php
include "../connection.php";

// Delete class if ID is provided
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete_query = "DELETE FROM classes WHERE id = ?";
    $stmt = $link->prepare($delete_query);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $success_message = "Class deleted successfully!";
    } else {
        $error_message = "Error deleting class: " . $link->error;
    }
    $stmt->close();
}

// Fetch all classes with instructor names
$query = "SELECT c.*, CONCAT(i.first_name, ' ', i.last_name) as instructor_name 
          FROM classes c 
          LEFT JOIN instructors i ON c.id = i.id 
          ORDER BY c.class_name ASC";
$result = $link->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Classes</title>
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
                <div class="admin-header d-flex justify-content-between align-items-center">
                    <div>
                        <h1><i class="fas fa-school me-2"></i>Manage Classes</h1>
                        <p class="text-muted">View, edit and delete classes</p>
                    </div>
                    <a href="add_class.php" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add New Class</a>
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
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Class Name</th>
                                        <th>Instructor</th>
                                        <th>Class Code</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result && $result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                    ?>
                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['class_name']; ?></td>
                                                <td><?php echo $row['instructor_name']; ?></td>
                                                <td><?php echo $row['class_code']; ?></td>
                                                <td><?php echo $row['start_date']; ?></td>
                                                <td><?php echo $row['end_date']; ?></td>
                                                <td><?php echo $row['is_active']; ?></td>
                                                <td>
                                                    <?php if ($row['is_active'] == 1) : ?>
                                                        <span class="badge bg-success">Active</span>
                                                    <?php else : ?>
                                                        <span class="badge bg-secondary">Inactive</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="edit_class.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="manage_classes.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this class?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    <a href="view_class_students.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info text-white">
                                                        <i class="fas fa-users"></i> Students
                                                    </a>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                    ?>
                                        <tr>
                                            <td colspan="8" class="text-center">No classes found</td>
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