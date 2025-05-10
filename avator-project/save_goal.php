<?php
// Set header for JSON response
header('Content-Type: application/json');

// Database configuration
$dbHost = 'localhost';
$dbUser = 'root';         // Default XAMPP username
$dbPass = 'Minol@2001';   // Your database password
$dbName = 'avatar_db';    // Your database name

// Response array
$response = array(
    'success' => false,
    'message' => ''
);

try {
    // Create connection
    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Create goals table if not exists
    $sql = "CREATE TABLE IF NOT EXISTS body_measurement_goals (
        id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        metric VARCHAR(50) NOT NULL,
        goal_value DECIMAL(5,1) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    if (!$conn->query($sql)) {
        throw new Exception("Error creating goals table: " . $conn->error);
    }
    
    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize and validate inputs
        $metric = filter_input(INPUT_POST, 'goal_metric', FILTER_SANITIZE_STRING);
        $goal_value = filter_input(INPUT_POST, 'goal_value', FILTER_VALIDATE_FLOAT);
        
        // Validate required fields
        if (empty($metric) || $goal_value === false) {
            throw new Exception("All fields must be filled correctly");
        }
        
        // Check if goal for this metric already exists
        $check_sql = "SELECT id FROM body_measurement_goals WHERE metric = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $metric);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Update existing goal
            $row = $result->fetch_assoc();
            $goal_id = $row['id'];
            
            $update_sql = "UPDATE body_measurement_goals SET goal_value = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("di", $goal_value, $goal_id);
            
            if ($update_stmt->execute()) {
                $response['success'] = true;
                $response['message'] = "Goal updated successfully!";
            } else {
                throw new Exception("Error updating goal: " . $update_stmt->error);
            }
            
            $update_stmt->close();
        } else {
            // Insert new goal
            $insert_sql = "INSERT INTO body_measurement_goals (metric, goal_value) VALUES (?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("sd", $metric, $goal_value);
            
            if ($insert_stmt->execute()) {
                $response['success'] = true;
                $response['message'] = "Goal saved successfully!";
            } else {
                throw new Exception("Error saving goal: " . $insert_stmt->error);
            }
            
            $insert_stmt->close();
        }
        
        $check_stmt->close();
    } else {
        throw new Exception("Invalid request method");
    }
    
    // Close connection
    $conn->close();
    
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

// If it's an AJAX request, send JSON response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    echo json_encode($response);
} else {
    // For regular form submission, redirect back to progress tracker
    // Set session flash message for notification
    session_start();
    $_SESSION['flash_message'] = $response['message'];
    $_SESSION['flash_type'] = $response['success'] ? 'success' : 'danger';
    
    // Redirect back to progress tracker
    header('Location: progress_tracker.php');
    exit();
}
?>