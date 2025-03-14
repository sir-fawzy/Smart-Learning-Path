<?php
session_start();
include "../connection.php";

// For debugging - log errors to a file
error_log("save_answer.php called with POST: " . print_r($_POST, true));

// Return JSON response
header('Content-Type: application/json');

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    error_log("User not logged in");
    echo json_encode(["status" => "error", "message" => "User not logged in"]);
    exit;
}

// Get the required data
if (isset($_POST["questionNo"]) && isset($_POST["answer"])) {
    $question_no = intval($_POST["questionNo"]);
    $answer = $_POST["answer"];
    
    // Check if exam category is set in session
    if (!isset($_SESSION["exam_category"])) {
        error_log("Exam category not set");
        echo json_encode(["status" => "error", "message" => "Exam category not set"]);
        exit;
    }
    
    $exam_category = $_SESSION["exam_category"];
    
    // First save to session for immediate use
    $_SESSION["answer"][$question_no] = $answer;
    
    error_log("Saved to session: questionNo={$question_no}, answer={$answer}, category={$exam_category}");
    
    // Get user ID from the registration table
    $username = $_SESSION["username"];
    $user_query = mysqli_query($link, "SELECT id FROM registration WHERE username='$username'");
    
    if (!$user_query) {
        error_log("Database error (user query): " . mysqli_error($link));
        echo json_encode(["status" => "error", "message" => "Database error: " . mysqli_error($link)]);
        exit;
    }
    
    if ($user_row = mysqli_fetch_assoc($user_query)) {
        $user_id = $user_row["id"];
        
        // Get question type directly from the database
        $question_query = mysqli_query($link, "SELECT question_type FROM questions WHERE category='$exam_category' AND question_no=$question_no");
        
        if (!$question_query) {
            error_log("Database error (question query): " . mysqli_error($link));
            echo json_encode(["status" => "error", "message" => "Database error: " . mysqli_error($link)]);
            exit;
        }
        
        if ($question_row = mysqli_fetch_assoc($question_query)) {
            $question_type = $question_row["question_type"];
            
            // Escape the answer to prevent SQL injection
            $escaped_answer = mysqli_real_escape_string($link, $answer);
            
            // Check if answer already exists
            $check_query = mysqli_query($link, "SELECT id FROM answers WHERE user_id=$user_id AND exam_category='$exam_category' AND question_no=$question_no");
            
            if (!$check_query) {
                error_log("Database error (check query): " . mysqli_error($link));
                echo json_encode(["status" => "error", "message" => "Database error: " . mysqli_error($link)]);
                exit;
            }
            
            if (mysqli_num_rows($check_query) > 0) {
                // Update existing answer
                $answer_row = mysqli_fetch_assoc($check_query);
                $answer_id = $answer_row["id"];
                $update_query = "UPDATE answers SET answer='$escaped_answer' WHERE id=$answer_id";
                
                error_log("Updating answer: " . $update_query);
                
                if (mysqli_query($link, $update_query)) {
                    error_log("Answer updated successfully");
                    echo json_encode(["status" => "success", "message" => "Answer updated"]);
                } else {
                    error_log("Database error (update): " . mysqli_error($link));
                    echo json_encode(["status" => "error", "message" => "Database error: " . mysqli_error($link)]);
                }
            } else {
                // Insert new answer
                $insert_query = "INSERT INTO answers (user_id, exam_category, question_no, answer, question_type) 
                                VALUES ($user_id, '$exam_category', $question_no, '$escaped_answer', '$question_type')";
                
                error_log("Inserting answer: " . $insert_query);
                
                if (mysqli_query($link, $insert_query)) {
                    error_log("Answer inserted successfully");
                    echo json_encode(["status" => "success", "message" => "Answer saved"]);
                } else {
                    error_log("Database error (insert): " . mysqli_error($link));
                    echo json_encode(["status" => "error", "message" => "Database error: " . mysqli_error($link)]);
                }
            }
        } else {
            error_log("Question not found: category=$exam_category, question_no=$question_no");
            echo json_encode(["status" => "error", "message" => "Question not found"]);
        }
    } else {
        error_log("User ID not found for username: $username");
        echo json_encode(["status" => "error", "message" => "User ID not found"]);
    }
} else {
    error_log("Missing parameters in request");
    echo json_encode(["status" => "error", "message" => "Missing parameters"]);
}
?>