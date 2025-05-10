<?php
// Set header for JSON response
header('Content-Type: application/json');

// Database connection
$conn = mysqli_connect("localhost", "root", "Minol@2001", "avatar_db");

// Response array
$response = array(
    'success' => false,
    'message' => ''
);

try {
    // Check connection
    if (!$conn) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }
    
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
    
    if (!mysqli_query($conn, $sql)) {
        throw new Exception("Error creating table: " . mysqli_error($conn));
    }
    
    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize and validate inputs
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
        $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
        $height = filter_input(INPUT_POST, 'height', FILTER_VALIDATE_FLOAT);
        $weight = filter_input(INPUT_POST, 'weight', FILTER_VALIDATE_FLOAT);
        $chest = filter_input(INPUT_POST, 'chest', FILTER_VALIDATE_FLOAT) ?: null;
        $waist = filter_input(INPUT_POST, 'waist', FILTER_VALIDATE_FLOAT) ?: null;
        $hips = filter_input(INPUT_POST, 'hips', FILTER_VALIDATE_FLOAT) ?: null;
        $thigh = filter_input(INPUT_POST, 'thigh', FILTER_VALIDATE_FLOAT) ?: null;
        $bicep = filter_input(INPUT_POST, 'bicep', FILTER_VALIDATE_FLOAT) ?: null;
        $neck = filter_input(INPUT_POST, 'neck', FILTER_VALIDATE_FLOAT) ?: null;
        $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
        
        // Validate required fields
        if (empty($name) || $age === false || empty($gender) || $height === false || $weight === false || empty($date)) {
            throw new Exception("All required fields must be filled correctly");
        }
        
        // Validate date format
        $date_obj = DateTime::createFromFormat('Y-m-d', $date);
        if (!$date_obj || $date_obj->format('Y-m-d') !== $date) {
            throw new Exception("Invalid date format. Please use YYYY-MM-DD format.");
        }
        
        // Prepare SQL statement
        $stmt = mysqli_prepare($conn, "INSERT INTO body_measurements (name, age, gender, height, weight, chest, waist, hips, thigh, bicep, neck, measurement_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . mysqli_error($conn));
        }
        
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "sissddddddds", $name, $age, $gender, $height, $weight, $chest, $waist, $hips, $thigh, $bicep, $neck, $date);
        
        // Execute statement
        if (mysqli_stmt_execute($stmt)) {
            $response['success'] = true;
            $response['message'] = "Measurements saved successfully";
        } else {
            throw new Exception("Error: " . mysqli_stmt_error($stmt));
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        throw new Exception("Invalid request method");
    }
    
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

// Send JSON response
echo json_encode($response);

// Close connection
mysqli_close($conn);
?>