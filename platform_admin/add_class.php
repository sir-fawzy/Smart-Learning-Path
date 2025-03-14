<?php
include "../connection.php";
// Initialize variables to hold form data and errors
$errors = [];
$success_message = "";

// Process form when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $classCode = trim($_POST['classCode'] ?? '');
    $className = trim($_POST['className'] ?? '');
    $instructorID = filter_var($_POST['instructorID'] ?? 0, FILTER_VALIDATE_INT);
    $description = trim($_POST['description'] ?? '');
    $startDate = trim($_POST['startDate'] ?? '');
    $endDate = trim($_POST['endDate'] ?? '');
    $status = $_POST['status'] ?? '';
    
    // Validation
    if (empty($classCode)) {
        $errors[] = "Class code is required";
    }
    
    if (empty($className)) {
        $errors[] = "Class name is required";
    }
    
    if (!$instructorID) {
        $errors[] = "Valid instructor ID is required";
    }
    
    if (empty($startDate)) {
        $errors[] = "Start date is required";
    }
    
    if (empty($endDate)) {
        $errors[] = "End date is required";
    }
    
    if (strtotime($endDate) <= strtotime($startDate)) {
        $errors[] = "End date must be after start date";
    }
    
    if (empty($status)) {
        $errors[] = "Status is required";
    }
    
    // If no validation errors, proceed with database insertion
    if (empty($errors)) {
        try {
            // Use the existing connection from connection.php
            global $link;
            
            // Check connection
            if (!$link) {
                throw new Exception("Connection failed: " . mysqli_connect_error());
            }
            
            // Convert status value to binary for is_active field
            $isActive = ($status == 'active') ? 1 : 0;
            
            // Prepare SQL statement
            $stmt = $link->prepare("INSERT INTO classes 
                                   (class_code, class_name, instructor_id, description, start_date, end_date, is_active) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?)");
            
            $stmt->bind_param("ssisssi", $classCode, $className, $instructorID, $description, $startDate, $endDate, $isActive);
            
            // Execute statement
            if ($stmt->execute()) {
                $success_message = "Class added successfully!";
                
                // Clear form fields after successful submission
                $classCode = $className = $description = $startDate = $endDate = "";
                $instructorID = 0;
                $status = "";
            } else {
                throw new Exception("Error: " . $stmt->error);
            }
            
            // Close statement
            $stmt->close();
            
        } catch (Exception $e) {
            $errors[] = $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a class</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        
        h1 {
            color: #333;
            text-align: center;
        }
        
        form {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input[type="text"],
        input[type="number"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        .required {
            color: red;
        }
        
        .form-footer {
            text-align: center;
            margin-top: 20px;
        }
        
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
        
        button:hover {
            background-color: #45a049;
        }
        
        .error-message {
            color: red;
            background-color: #ffe6e6;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        
        .success-message {
            color: green;
            background-color: #e6ffe6;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <h1>Add Class</h1>
    
    <?php if (!empty($errors)): ?>
        <div class="error-message">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($success_message)): ?>
        <div class="success-message">
            <?php echo htmlspecialchars($success_message); ?>
        </div>
    <?php endif; ?>
    
    <form id="addClassForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="classCode">Class Code <span class="required">*</span></label>
            <input type="text" id="classCode" name="classCode" required 
                   placeholder="Please enter a class code" 
                   value="<?php echo htmlspecialchars($classCode ?? ''); ?>">
        </div>
        
        <div class="form-group">
            <label for="className">Class Name <span class="required">*</span></label>
            <input type="text" id="className" name="className" required 
                   placeholder="Please Enter Class Name" 
                   value="<?php echo htmlspecialchars($className ?? ''); ?>">
        </div>
        
        <div class="form-group">
            <label for="instructorID">Instructor <span class="required">*</span></label>
            <select id="instructorID" name="instructorID" required>
                <option value="">Select an instructor</option>
                <?php
                $instructor_query = "SELECT id, first_name, last_name FROM instructors ORDER BY last_name, first_name";
                $result = mysqli_query($link, $instructor_query);
                
                while ($row = mysqli_fetch_assoc($result)) {
                    $selected = ($instructorID == $row['id']) ? 'selected' : '';
                    echo '<option value="' . $row['id'] . '" ' . $selected . '>' . 
                        htmlspecialchars($row['last_name'] . ', ' . $row['first_name']) . '</option>';
                }
                ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" placeholder="Description (Optional)" rows="4"><?php echo htmlspecialchars($description ?? ''); ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="startDate">Start Date <span class="required">*</span></label>
            <input type="date" id="startDate" name="startDate" required 
                   value="<?php echo htmlspecialchars($startDate ?? ''); ?>">
        </div>
        
        <div class="form-group">
            <label for="endDate">End Date <span class="required">*</span></label>
            <input type="date" id="endDate" name="endDate" required 
                   value="<?php echo htmlspecialchars($endDate ?? ''); ?>">
        </div>
        
        <div class="form-group">
            <label for="status">Status<span class="required">*</span></label>
            <select id="status" name="status" required>
                <option value="">Select status</option>
                <option value="active" <?php if(($status ?? '') == 'active') echo 'selected'; ?>>Active</option>
                <option value="inactive" <?php if(($status ?? '') == 'inactive') echo 'selected'; ?>>Inactive</option>
                <option value="completed" <?php if(($status ?? '') == 'completed') echo 'selected'; ?>>Completed</option>
            </select>
        </div>
        
        <div class="form-footer">
            <button type="submit">Add Class</button>
        </div>
    </form>
</body>
</html>