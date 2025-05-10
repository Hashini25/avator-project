<?php
// Start session at the very beginning before any output
session_start();

// Database configuration
$dbHost = 'localhost';
$dbUser = 'root';         // Default XAMPP username
$dbPass = 'Minol@2001';   // Your database password
$dbName = 'avatar_db';    // Your database name

// Response
$success = false;
$message = '';

try {
    // Check if metric is provided
    if (!isset($_GET['metric']) || empty($_GET['metric'])) {
        throw new Exception("No metric specified for deletion");
    }
    
    $metric = filter_input(INPUT_GET, 'metric', FILTER_SANITIZE_STRING);
    
    // Create connection
    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Prepare delete statement
    $stmt = $conn->prepare("DELETE FROM body_measurement_goals WHERE metric = ?");
    $stmt->bind_param("s", $metric);
    
    // Execute statement
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $success = true;
            $message = "Goal for " . ucfirst($metric) . " has been deleted successfully";
        } else {
            $message = "No goal found for " . ucfirst($metric);
        }
    } else {
        throw new Exception("Error deleting goal: " . $stmt->error);
    }
    
    $stmt->close();
    $conn->close();
    
} catch (Exception $e) {
    $message = $e->getMessage();
}

// Set flash message
$_SESSION['flash_message'] = $message;
$_SESSION['flash_type'] = $success ? 'success' : 'danger';

// Redirect back to progress tracker
header('Location: progress_tracker.php');
exit();
?>