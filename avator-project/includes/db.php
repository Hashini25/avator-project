<?php
// Set header for JSON response
header('Content-Type: application/json');

// Database configuration
$dbHost = 'localhost';
$dbUser = 'root';         // Default XAMPP username
$dbPass = 'Minol@2001';             // Default XAMPP password
$dbName = 'body_measurements_db'; // Your database name

// Response array
$response = array(
    'success' => false,
    'message' => ''
);

try {
    // Create database connection
    $conn = new mysqli($dbHost, $dbUser, $dbPass);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Create database if not exists
    $sql = "CREATE DATABASE IF NOT EXISTS $dbName";
    if (!$conn->query($sql)) {
        throw new Exception("Error creating database: " . $conn->error);
    }
    
    // Select database
    $conn->select_db($dbName);
    
    // Create table if not exists
    $sql = "CREATE TABLE IF NOT EXISTS body_measurements (
        id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        age INT(3) NOT NULL,
        gender VARCHAR(10) NOT NULL,
        height DECIMAL(5,1) NOT NULL,
        weight DECIMAL(5,1) NOT NULL,
        chest DECIMAL(5,1),
        waist DECIMAL(5,1),
        hips DECIMAL(5,1),
        thigh DECIMAL(5,1),
        bicep DECIMAL(5,1),
        neck DECIMAL(5,1),
        measurement_date DATE NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if (!$conn->query($sql)) {
        throw new Exception("Error creating table: " . $conn->error);
    }
    
    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize and validate inputs
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
        $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
        $height = filter_input(INPUT_POST, 'height', FILTER_VALIDATE_FLOAT);
        $weight = filter_input(INPUT_POST, 'weight', FILTER_VALIDATE_FLOAT);
        $chest = filter_input(INPUT_POST, 'chest', FILTER_VALIDATE_FLOAT);
        $waist = filter_input(INPUT_POST, 'waist', FILTER_VALIDATE_FLOAT);
        $hips = filter_input(INPUT_POST, 'hips', FILTER_VALIDATE_FLOAT);
        $thigh = filter_input(INPUT_POST, 'thigh', FILTER_VALIDATE_FLOAT);
        $bicep = filter_input(INPUT_POST, 'bicep', FILTER_VALIDATE_FLOAT);
        $neck = filter_input(INPUT_POST, 'neck', FILTER_VALIDATE_FLOAT);
        $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
        
        // Validate required fields
        if (empty($name) || $age === false || empty($gender) || $height === false || $weight === false || empty($date)) {
            throw new Exception("All required fields must be filled correctly");
        }
        
        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO body_measurements (name, age, gender, height, weight, chest, waist, hips, thigh, bicep, neck, measurement_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        // Bind parameters
        $stmt->bind_param("sissddddddds", $name, $age, $gender, $height, $weight, $chest, $waist, $hips, $thigh, $bicep, $neck, $date);
        
        // Execute statement
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = "Measurements saved successfully";
        } else {
            throw new Exception("Error: " . $stmt->error);
        }
        
        // Close statement
        $stmt->close();
    } else {
        throw new Exception("Invalid request method");
    }
    
    // Close connection
    $conn->close();
    
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

// Send JSON response
echo json_encode($response);
?>