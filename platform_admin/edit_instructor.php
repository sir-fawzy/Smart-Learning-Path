<?php
include "../connection.php";  // Ensure the database connection is included

// Check if an instructor ID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid instructor ID.");
}

$instructor_id = $_GET['id'];

// Fetch the instructor's details from the database
$query = "SELECT * FROM instructors WHERE user_id = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $instructor_id);
$stmt->execute();
$result = $stmt->get_result();
$instructor = $result->fetch_assoc();

if (!$instructor) {
    die("Instructor not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = mysqli_real_escape_string($link, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($link, $_POST['last_name']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $department = mysqli_real_escape_string($link, $_POST['department']);
    $phone = mysqli_real_escape_string($link, $_POST['phone']);

    // Update the instructor's information
    $update_query = "UPDATE instructors SET first_name=?, last_name=?, email=?, department=?, phone=? WHERE user_id=?";
    $stmt = $link->prepare($update_query);
    $stmt->bind_param("sssssi", $first_name, $last_name, $email, $department, $phone, $instructor_id);

    if ($stmt->execute()) {
        echo "<script>alert('Instructor updated successfully!'); window.location.href='manage_instructors.php';</script>";
    } else {
        echo "<script>alert('Error updating instructor: " . mysqli_error($link) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Instructor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Instructor</h2>
        <form action="" method="post">
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($instructor['first_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($instructor['last_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($instructor['email']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="department" class="form-label">Department</label>
                <input type="text" class="form-control" id="department" name="department" value="<?php echo htmlspecialchars($instructor['department']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($instructor['phone']); ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Update Instructor</button>
            <a href="manage_instructors.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
