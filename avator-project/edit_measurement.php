<?php
// Include the header
include 'header.php';

// Database configuration
$dbHost = 'localhost';
$dbUser = 'root';         // Default XAMPP username
$dbPass = 'Minol@2001';   // Your database password
$dbName = 'avatar_db'; // Your database name

// Initialize variables
$measurement = null;
$error_message = '';
$success_message = '';

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $error_message = "No measurement ID provided.";
} else {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    
    if (!$id) {
        $error_message = "Invalid measurement ID.";
    } else {
        try {
            // Create connection
            $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
            
            // Check connection
            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }
            
            // Handle form submission for updating record
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
                
                // Prepare SQL statement for update
                $stmt = $conn->prepare("UPDATE body_measurements SET 
                    name = ?, age = ?, gender = ?, height = ?, weight = ?, 
                    chest = ?, waist = ?, hips = ?, thigh = ?, bicep = ?, 
                    neck = ?, measurement_date = ? 
                    WHERE id = ?");
                
                // Bind parameters
                $stmt->bind_param("sisdddddddssi", $name, $age, $gender, $height, $weight, $chest, $waist, $hips, $thigh, $bicep, $neck, $date, $id);
                
                // Execute statement
                if ($stmt->execute()) {
                    $success_message = "Measurement updated successfully";
                } else {
                    throw new Exception("Error updating record: " . $stmt->error);
                }
                
                $stmt->close();
            }
            
            // Get measurement data for the form
            $stmt = $conn->prepare("SELECT * FROM body_measurements WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $measurement = $result->fetch_assoc();
            } else {
                throw new Exception("No measurement found with that ID.");
            }
            
            $stmt->close();
            $conn->close();
            
        } catch (Exception $e) {
            $error_message = $e->getMessage();
        }
    }
}

// Function to display alert messages
function showAlert($message, $type = 'success') {
    echo '<div class="alert alert-' . $type . ' animate__animated animate__fadeIn" role="alert">';
    echo '<i class="fas fa-' . ($type == 'success' ? 'check-circle' : 'exclamation-circle') . ' me-2"></i>';
    echo $message;
    echo '<button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}
?>

<!-- Custom CSS for enhanced styling -->
<style>
    :root {
        --primary-color: #4e73df;
        --secondary-color: #f8f9fc;
        --accent-color: #2e59d9;
        --success-color: #1cc88a;
        --danger-color: #e74a3b;
        --warning-color: #f6c23e;
        --info-color: #36b9cc;
        --dark-color: #5a5c69;
        --light-color: #f8f9fc;
        --white-color: #fff;
        --gray-100: #f8f9fc;
        --gray-200: #eaecf4;
        --gray-300: #dddfeb;
        --gray-400: #d1d3e2;
        --gray-500: #b7b9cc;
        --gray-600: #858796;
        --gray-700: #6e707e;
        --gray-800: #5a5c69;
        --gray-900: #3a3b45;
    }

    body {
        background-color: var(--gray-100);
        color: var(--gray-800);
        font-family: 'Nunito', 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
    }

    .dashboard-container {
        padding: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .page-header {
        margin-bottom: 1.5rem;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--gray-800);
        margin-bottom: 0.5rem;
        margin-right: 1rem;
    }

    .page-subtitle {
        font-size: 1rem;
        color: var(--gray-600);
        margin-bottom: 0;
    }

    .card {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .card-header {
        background-color: var(--white-color);
        border-bottom: 1px solid var(--gray-200);
        padding: 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-body {
        padding: 1.5rem;
        background-color: var(--white-color);
    }

    .card-title {
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 0;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
    }

    .card-title i {
        margin-right: 0.75rem;
        color: var(--primary-color);
        font-size: 1.25rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .form-control, .form-select {
        border: 1px solid var(--gray-300);
        border-radius: 0.35rem;
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
        transition: all 0.2s;
        box-shadow: 0 0.125rem 0.25rem rgba(58, 59, 69, 0.04);
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.1);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .required-field::after {
        content: ' *';
        color: var(--danger-color);
    }

    .input-group-text {
        background-color: var(--gray-100);
        border: 1px solid var(--gray-300);
        color: var(--gray-700);
    }

    .btn {
        border-radius: 50rem;
        font-weight: 600;
        padding: 0.375rem 1.5rem;
        font-size: 0.9rem;
        transition: all 0.2s;
        box-shadow: 0 0.125rem 0.25rem rgba(58, 59, 69, 0.1);
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-primary:hover {
        background-color: var(--accent-color);
        border-color: var(--accent-color);
        transform: translateY(-2px);
    }

    .btn-secondary {
        background-color: var(--gray-500);
        border-color: var(--gray-500);
        color: white;
    }

    .btn-secondary:hover {
        background-color: var(--gray-600);
        border-color: var(--gray-600);
        transform: translateY(-2px);
    }

    .alert {
        border-radius: 0.5rem;
        border: none;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        margin-bottom: 1.5rem;
        position: relative;
        padding: 1rem 1.5rem;
    }

    .alert-success {
        background-color: rgba(28, 200, 138, 0.1);
        color: var(--success-color);
    }

    .alert-danger {
        background-color: rgba(231, 74, 59, 0.1);
        color: var(--danger-color);
    }

    .form-section {
        position: relative;
        margin-bottom: 2rem;
        padding-top: 1rem;
        border-top: 1px solid var(--gray-200);
    }

    .form-section:first-of-type {
        border-top: none;
        padding-top: 0;
    }

    .form-section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--gray-700);
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
    }

    .form-section-title i {
        margin-right: 0.5rem;
        color: var(--primary-color);
    }

    .form-tip {
        font-size: 0.8rem;
        color: var(--gray-600);
        margin-top: 0.25rem;
    }

    .measurement-unit {
        font-size: 0.8rem;
        color: var(--gray-600);
        margin-left: 0.25rem;
    }

    .btn-icon-text {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-icon-text i {
        margin-right: 0.5rem;
    }

    /* Animation classes */
    .animate__fadeIn {
        animation-duration: 0.5s;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .animate__fadeIn {
        animation-name: fadeIn;
    }

    /* Input Highlights for Required Fields */
    .form-control.required, .form-select.required {
        border-left: 3px solid var(--primary-color);
    }

    /* Responsive tweaks */
    @media (max-width: 992px) {
        .dashboard-container {
            padding: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .dashboard-container {
            padding: 1rem;
        }
    }

    /* Custom Floating Labels */
    .form-floating > .form-control,
    .form-floating > .form-select {
        height: calc(3.5rem + 2px);
        padding: 1.625rem 0.75rem 0.625rem;
    }

    .form-floating > label {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        padding: 1rem 0.75rem;
        pointer-events: none;
        border: 1px solid transparent;
        transform-origin: 0 0;
        transition: opacity .1s ease-in-out,transform .1s ease-in-out;
        color: var(--gray-600);
    }

    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label,
    .form-floating > .form-select ~ label {
        opacity: .65;
        transform: scale(.85) translateY(-0.5rem) translateX(0.15rem);
    }

    /* Form Steps Visual Indicator */
    .form-steps {
        display: flex;
        margin-bottom: 2rem;
        position: relative;
    }

    .form-step {
        flex: 1;
        text-align: center;
        padding-bottom: 1.5rem;
        position: relative;
    }

    .form-step::before {
        content: '';
        position: absolute;
        top: 0.5rem;
        left: 0;
        width: 100%;
        height: 3px;
        background-color: var(--gray-300);
        z-index: 1;
    }

    .form-step:first-child::before {
        left: 50%;
        width: 50%;
    }

    .form-step:last-child::before {
        width: 50%;
    }

    .form-step-number {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
        background-color: var(--gray-300);
        color: var(--gray-600);
        border-radius: 50%;
        margin: 0 auto 0.5rem;
        position: relative;
        z-index: 2;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s;
    }

    .form-step.active .form-step-number {
        background-color: var(--primary-color);
        color: white;
    }

    .form-step.active::before, 
    .form-step.completed::before {
        background-color: var(--primary-color);
    }

    .form-step.completed .form-step-number {
        background-color: var(--success-color);
        color: white;
    }

    .form-step.completed .form-step-number::after {
        content: '✓';
    }

    .form-step-label {
        font-size: 0.85rem;
        color: var(--gray-600);
        font-weight: 600;
    }

    .form-step.active .form-step-label {
        color: var(--primary-color);
        font-weight: 700;
    }

    .form-step.completed .form-step-label {
        color: var(--success-color);
    }

    /* Floating Card */
    .floating-card {
        transform: translateY(0);
        transition: transform 0.3s ease;
    }

    .floating-card:hover {
        transform: translateY(-5px);
    }

    /* Gender Selection Cards */
    .gender-cards {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .gender-card {
        flex: 1;
        min-width: 100px;
        cursor: pointer;
        padding: 1rem;
        border-radius: 0.5rem;
        border: 2px solid var(--gray-300);
        background-color: var(--white-color);
        text-align: center;
        transition: all 0.2s;
    }

    .gender-card:hover {
        border-color: var(--primary-color);
        background-color: var(--gray-100);
    }

    .gender-card.selected {
        border-color: var(--primary-color);
        background-color: rgba(78, 115, 223, 0.1);
    }

    .gender-card i {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
        color: var(--gray-600);
    }

    .gender-card.selected i {
        color: var(--primary-color);
    }

    .gender-card-label {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--gray-700);
    }

    /* Tooltip Styling */
    .tooltip-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 18px;
        height: 18px;
        background-color: var(--gray-500);
        color: white;
        border-radius: 50%;
        font-size: 0.7rem;
        margin-left: 0.5rem;
        cursor: help;
    }
</style>

<!-- Main Content -->
<div class="dashboard-container">
    <!-- Page Header with Actions -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Measurement</h1>
            <p class="page-subtitle">Update your body measurements record</p>
        </div>
        <div>
            <a href="view_measurements.php" class="btn btn-secondary btn-icon-text">
                <i class="fas fa-arrow-left"></i> Back to Records
            </a>
        </div>
    </div>

    <!-- Success/Error Alert -->
    <?php if (!empty($error_message)): ?>
        <?php showAlert($error_message, 'danger'); ?>
        <div class="text-center mt-4">
            <a href="view_measurements.php" class="btn btn-primary">Back to All Measurements</a>
        </div>
    <?php elseif (!empty($success_message)): ?>
        <?php showAlert($success_message); ?>
    <?php endif; ?>
    
    <?php if ($measurement): ?>
        <!-- Form Steps Indicator -->
        <div class="form-steps d-none d-md-flex">
            <div class="form-step completed">
                <div class="form-step-number">1</div>
                <div class="form-step-label">Personal Info</div>
            </div>
            <div class="form-step active">
                <div class="form-step-number">2</div>
                <div class="form-step-label">Measurements</div>
            </div>
            <div class="form-step">
                <div class="form-step-number">3</div>
                <div class="form-step-label">Review</div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card floating-card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-edit"></i> Edit Measurement Record
                </h5>
                <span class="badge bg-primary">ID: <?php echo $id; ?></span>
            </div>
            <div class="card-body">
                <form action="edit_measurement.php?id=<?php echo $id; ?>" method="POST" id="editForm">
                    
                    <!-- Personal Information Section -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <i class="fas fa-user-circle"></i> Personal Information
                        </h3>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label required-field">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control required" id="name" name="name" value="<?php echo htmlspecialchars($measurement['name']); ?>" required>
                                </div>
                                <div class="form-tip">Enter your full name as it appears on your records</div>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label for="age" class="form-label required-field">Age</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                                    <input type="number" class="form-control required" id="age" name="age" min="1" max="120" value="<?php echo htmlspecialchars($measurement['age']); ?>" required>
                                    <span class="input-group-text">years</span>
                                </div>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label for="date" class="form-label required-field">Measurement Date</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="date" class="form-control required" id="date" name="date" value="<?php echo htmlspecialchars(date('Y-m-d', strtotime($measurement['measurement_date']))); ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Gender Selection Cards -->
                        <label class="form-label required-field">Gender</label>
                        <div class="gender-cards">
                            <div class="gender-card <?php echo ($measurement['gender'] == 'male') ? 'selected' : ''; ?>" data-value="male">
                                <i class="fas fa-mars"></i>
                                <div class="gender-card-label">Male</div>
                            </div>
                            <div class="gender-card <?php echo ($measurement['gender'] == 'female') ? 'selected' : ''; ?>" data-value="female">
                                <i class="fas fa-venus"></i>
                                <div class="gender-card-label">Female</div>
                            </div>
                            <div class="gender-card <?php echo ($measurement['gender'] == 'other') ? 'selected' : ''; ?>" data-value="other">
                                <i class="fas fa-genderless"></i>
                                <div class="gender-card-label">Other</div>
                            </div>
                        </div>
                        <input type="hidden" id="gender" name="gender" value="<?php echo htmlspecialchars($measurement['gender']); ?>" required>
                    </div>
                    
                    <!-- Basic Measurements Section -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <i class="fas fa-ruler"></i> Basic Measurements
                            <span class="tooltip-icon" data-bs-toggle="tooltip" title="These measurements are required for basic body calculations">?</span>
                        </h3>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="height" class="form-label required-field">Height</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-ruler-vertical"></i></span>
                                    <input type="number" class="form-control required" id="height" name="height" step="0.1" min="50" max="250" value="<?php echo htmlspecialchars($measurement['height']); ?>" required>
                                    <span class="input-group-text">cm</span>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="weight" class="form-label required-field">Weight</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-weight"></i></span>
                                    <input type="number" class="form-control required" id="weight" name="weight" step="0.1" min="20" max="300" value="<?php echo htmlspecialchars($measurement['weight']); ?>" required>
                                    <span class="input-group-text">kg</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional Measurements Section -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <i class="fas fa-tape"></i> Additional Body Measurements
                            <span class="tooltip-icon" data-bs-toggle="tooltip" title="These measurements are optional but recommended for precise body composition tracking">?</span>
                        </h3>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="chest" class="form-label">Chest/Bust</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="chest" name="chest" step="0.1" min="30" max="200" value="<?php echo htmlspecialchars($measurement['chest'] ?? ''); ?>">
                                    <span class="input-group-text">cm</span>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="waist" class="form-label">Waist</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="waist" name="waist" step="0.1" min="30" max="200" value="<?php echo htmlspecialchars($measurement['waist'] ?? ''); ?>">
                                    <span class="input-group-text">cm</span>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="hips" class="form-label">Hips</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="hips" name="hips" step="0.1" min="30" max="200" value="<?php echo htmlspecialchars($measurement['hips'] ?? ''); ?>">
                                    <span class="input-group-text">cm</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="thigh" class="form-label">Thigh</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="thigh" name="thigh" step="0.1" min="20" max="100" value="<?php echo htmlspecialchars($measurement['thigh'] ?? ''); ?>">
                                    <span class="input-group-text">cm</span>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="bicep" class="form-label">Bicep</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="bicep" name="bicep" step="0.1" min="10" max="70" value="<?php echo htmlspecialchars($measurement['bicep'] ?? ''); ?>">
                                    <span class="input-group-text">cm</span>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="neck" class="form-label">Neck</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="neck" name="neck" step="0.1" min="20" max="70" value="<?php echo htmlspecialchars($measurement['neck'] ?? ''); ?>">
                                    <span class="input-group-text">cm</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="view_measurements.php" class="btn btn-secondary btn-icon-text">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary btn-icon-text">
                            <i class="fas fa-save"></i> Update Measurement
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Display Quick BMI Stats -->
        <div class="row">
            <div class="col-md-4">
                <div class="card floating-card">
                    <div class="card-body text-center">
                        <h5 class="text-primary mb-3">BMI Calculation</h5>
                        <div class="display-4 mb-3" id="bmiValue">
                            <?php 
                                $height_m = $measurement['height'] / 100;
                                $bmi = $measurement['weight'] / ($height_m * $height_m);
                                echo number_format($bmi, 1);
                            ?>
                        </div>
                        <p class="text-muted" id="bmiCategory">
                            <?php
                                if ($bmi < 18.5) echo 'Underweight';
                                else if ($bmi < 25) echo 'Normal';
                                else if ($bmi < 30) echo 'Overweight';
                                else echo 'Obese';
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card floating-card">
                    <div class="card-body text-center">
                        <h5 class="text-primary mb-3">Waist-Hip Ratio</h5>
                        <div class="display-4 mb-3" id="whrValue">
                            <?php 
                                if (!empty($measurement['waist']) && !empty($measurement['hips'])) {
                                    $whr = $measurement['waist'] / $measurement['hips'];
                                    echo number_format($whr, 2);
                                } else {
                                    echo 'N/A';
                                }
                            ?>
                        </div>
                        <p class="text-muted" id="whrCategory">
                            <?php
                                if (!empty($measurement['waist']) && !empty($measurement['hips'])) {
                                    $whr = $measurement['waist'] / $measurement['hips'];
                                    $gender = $measurement['gender'];
                                    
                                    if ($gender == 'male') {
                                        if ($whr < 0.9) echo 'Low Risk';
                                        else if ($whr < 1.0) echo 'Moderate Risk';
                                        else echo 'High Risk';
                                    } else {
                                        if ($whr < 0.8) echo 'Low Risk';
                                        else if ($whr < 0.85) echo 'Moderate Risk';
                                        else echo 'High Risk';
                                    }
                                } else {
                                    echo 'Need waist & hip measurements';
                                }
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card floating-card">
                    <div class="card-body text-center">
                        <h5 class="text-primary mb-3">Ideal Weight</h5>
                        <div class="display-4 mb-3" id="idealWeight">
                            <?php 
                                // Simplified ideal weight calculation (Devine formula)
                                $height_cm = $measurement['height'];
                                $gender = $measurement['gender'];
                                
                                if ($gender == 'male') {
                                    $ideal_weight = 50 + 0.91 * ($height_cm - 152.4);
                                } else {
                                    $ideal_weight = 45.5 + 0.91 * ($height_cm - 152.4);
                                }
                                
                                echo number_format($ideal_weight, 1);
                            ?>
                        </div>
                        <p class="text-muted">kg (based on height)</p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Add custom JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-hide alerts after 5 seconds
        let alerts = document.querySelectorAll('.alert');
        if (alerts.length > 0) {
            setTimeout(function() {
                alerts.forEach(function(alert) {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.8s ease';
                    setTimeout(function() {
                        alert.style.display = 'none';
                    }, 800);
                });
            }, 5000);
        }
        
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        
        // Gender card selection
        const genderCards = document.querySelectorAll('.gender-card');
        const genderInput = document.getElementById('gender');
        
        genderCards.forEach(card => {
            card.addEventListener('click', function() {
                // Remove selected class from all cards
                genderCards.forEach(c => c.classList.remove('selected'));
                
                // Add selected class to clicked card
                this.classList.add('selected');
                
                // Set the hidden input value
                genderInput.value = this.dataset.value;
            });
        });
        
        // Real-time BMI calculation
        const heightInput = document.getElementById('height');
        const weightInput = document.getElementById('weight');
        const bmiValue = document.getElementById('bmiValue');
        const bmiCategory = document.getElementById('bmiCategory');
        
        function calculateBMI() {
            if (heightInput.value && weightInput.value) {
                const height_m = heightInput.value / 100;
                const weight = weightInput.value;
                const bmi = weight / (height_m * height_m);
                
                bmiValue.textContent = bmi.toFixed(1);
                
                if (bmi < 18.5) {
                    bmiCategory.textContent = 'Underweight';
                    bmiValue.style.color = '#f6c23e';
                } else if (bmi < 25) {
                    bmiCategory.textContent = 'Normal';
                    bmiValue.style.color = '#1cc88a';
                } else if (bmi < 30) {
                    bmiCategory.textContent = 'Overweight';
                    bmiValue.style.color = '#f6c23e';
                } else {
                    bmiCategory.textContent = 'Obese';
                    bmiValue.style.color = '#e74a3b';
                }
            }
        }
        
        heightInput.addEventListener('input', calculateBMI);
        weightInput.addEventListener('input', calculateBMI);
        
        // Waist-Hip Ratio calculation
        const waistInput = document.getElementById('waist');
        const hipsInput = document.getElementById('hips');
        const whrValue = document.getElementById('whrValue');
        const whrCategory = document.getElementById('whrCategory');
        
        function calculateWHR() {
            if (waistInput.value && hipsInput.value) {
                const waist = parseFloat(waistInput.value);
                const hips = parseFloat(hipsInput.value);
                const whr = waist / hips;
                
                whrValue.textContent = whr.toFixed(2);
                
                const gender = document.getElementById('gender').value;
                
                if (gender === 'male') {
                    if (whr < 0.9) {
                        whrCategory.textContent = 'Low Risk';
                        whrValue.style.color = '#1cc88a';
                    } else if (whr < 1.0) {
                        whrCategory.textContent = 'Moderate Risk';
                        whrValue.style.color = '#f6c23e';
                    } else {
                        whrCategory.textContent = 'High Risk';
                        whrValue.style.color = '#e74a3b';
                    }
                } else {
                    if (whr < 0.8) {
                        whrCategory.textContent = 'Low Risk';
                        whrValue.style.color = '#1cc88a';
                    } else if (whr < 0.85) {
                        whrCategory.textContent = 'Moderate Risk';
                        whrValue.style.color = '#f6c23e';
                    } else {
                        whrCategory.textContent = 'High Risk';
                        whrValue.style.color = '#e74a3b';
                    }
                }
            } else {
                whrValue.textContent = 'N/A';
                whrCategory.textContent = 'Need waist & hip measurements';
                whrValue.style.color = '';
            }
        }
        
        waistInput.addEventListener('input', calculateWHR);
        hipsInput.addEventListener('input', calculateWHR);
        
        // Calculate ideal weight based on height
        const idealWeight = document.getElementById('idealWeight');
        
        function calculateIdealWeight() {
            if (heightInput.value) {
                const height_cm = parseFloat(heightInput.value);
                const gender = document.getElementById('gender').value;
                
                let weight;
                if (gender === 'male') {
                    weight = 50 + 0.91 * (height_cm - 152.4);
                } else {
                    weight = 45.5 + 0.91 * (height_cm - 152.4);
                }
                
                idealWeight.textContent = weight.toFixed(1);
            }
        }
        
        heightInput.addEventListener('input', calculateIdealWeight);
        
        // Form validation highlighting
        const form = document.getElementById('editForm');
        const requiredInputs = document.querySelectorAll('.form-control.required, .form-select.required');
        
        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            requiredInputs.forEach(input => {
                if (!input.value) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fill all required fields');
            }
        });
        
        requiredInputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.value) {
                    this.classList.remove('is-invalid');
                }
            });
        });
    });
</script>

<?php include 'footer.php'; ?>