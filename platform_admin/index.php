<?php
include "../connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platform Admin</title>
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
                    <a href="index.php" class="active"><i class="fas fa-home me-2"></i> Dashboard</a>
                    <a href="add_instructor.php"><i class="fas fa-chalkboard-teacher me-2"></i> Add Instructor</a>
                    <a href="add_class.php"><i class="fas fa-school me-2"></i> Add Class</a>
                    <a href="manage_instructors.php"><i class="fas fa-user-edit me-2"></i> Manage Instructors</a>
                    <a href="#"><i class="fas fa-users me-2"></i> Manage Users</a>
                    <a href="#"><i class="fas fa-chart-bar me-2"></i> Reports</a>
                    <a href="#"><i class="fas fa-cog me-2"></i> Settings</a>
                </div>
            </div>

            <!-- Main content -->
            <div class="col-md-9 col-lg-10 content">
                <div class="admin-header">
                    <h1><i class="fas fa-user-shield me-2"></i>PLATFORM ADMIN</h1>
                    <p class="text-muted">Welcome to your administrative dashboard</p>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="fas fa-chalkboard-teacher fa-3x mb-3 text-primary"></i>
                                <h5 class="card-title">Instructors</h5>
                                <p class="card-text">Manage all instructors in the system</p>
                                <a href="add_instructor.php" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add
                                    Instructor</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="fas fa-school fa-3x mb-3 text-success"></i>
                                <h5 class="card-title">Classes</h5>
                                <p class="card-text">Manage all classes and courses</p>
                                <a href="add_class.php" class="btn btn-success"><i class="fas fa-plus me-2"></i>Add
                                    Class</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="fas fa-chart-line fa-3x mb-3 text-info"></i>
                                <h5 class="card-title">Statistics</h5>
                                <p class="card-text">View platform statistics and analytics</p>
                                <a href="#" class="btn btn-info text-white">View Reports</a>
                            </div>
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