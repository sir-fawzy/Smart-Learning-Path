<?php
include "../connection.php";

// Check if class ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Class ID is missing.");
}

$class_id = $_GET['id'];

// Fetch class details
$query = "SELECT * FROM classes WHERE id = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $class_id);
$stmt->execute();
$result = $stmt->get_result();
$class = $result->fetch_assoc();

if (!$class) {
    die("Class not found.");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $class_name = $_POST['className'] ?? '';
    $class_code = $_POST['classCode'] ?? '';
    $start_date = $_POST['startDate'] ?? '';
    $end_date = $_POST['endDate'] ?? '';
    $status = $_POST['status'] == 'active' ? 1 : 0;

    // Validate input
    if (empty($class_name) || empty($class_code) || empty($start_date) || empty($end_date)) {
        $error_message = "All fields are required.";
    } elseif (strtotime($end_date) <= strtotime($start_date)) {
        $error_message = "End date must be after the start date.";
    } else {
        // Update class
        $update_query = "UPDATE classes SET class_name = ?, class_code = ?, start_date = ?, end_date = ?, is_active = ? WHERE id = ?";
        $stmt = $link->prepare($update_query);
        $stmt->bind_param("ssssii", $class_name, $class_code, $start_date, $end_date, $status, $class_id);
        
        if ($stmt->execute()) {
            $success_message = "Class updated successfully!";
        } else {
            $error_message = "Error updating class: " . $link->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Class</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Edit Class</h1>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="classCode" class="form-label">Class Code</label>
                <input type="text" class="form-control" name="classCode" value="<?php echo htmlspecialchars($class['class_code']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="className" class="form-label">Class Name</label>
                <input type="text" class="form-control" name="className" value="<?php echo htmlspecialchars($class['class_name']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="startDate" class="form-label">Start Date</label>
                <input type="date" class="form-control" name="startDate" value="<?php echo htmlspecialchars($class['start_date']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="endDate" class="form-label">End Date</label>
                <input type="date" class="form-control" name="endDate" value="<?php echo htmlspecialchars($class['end_date']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="active" <?php echo $class['is_active'] ? 'selected' : ''; ?>>Active</option>
                    <option value="inactive" <?php echo !$class['is_active'] ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Class</button>
            <a href="manage_classes.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
