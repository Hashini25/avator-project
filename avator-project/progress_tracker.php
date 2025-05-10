<?php
// Start session at the very beginning before any output
session_start();

// Include the header
include 'header.php';
?>

<!-- Custom CSS for Progress Tracker -->
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
        max-width: 1400px;
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
        padding: 1.25rem;
        background-color: var(--white-color);
    }

    .card-title {
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 0;
        font-size: 1.25rem;
        display: flex;
        align-items: center;
    }

    .card-title i {
        margin-right: 0.75rem;
        color: var(--primary-color);
        font-size: 1.25rem;
    }

    .floating-card {
        transform: translateY(0);
        transition: transform 0.3s ease;
    }

    .floating-card:hover {
        transform: translateY(-5px);
    }

    .btn {
        border-radius: 50rem;
        font-weight: 600;
        padding: 0.375rem 1rem;
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

    .btn-icon-text {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-icon-text i {
        margin-right: 0.5rem;
    }

    .btn-filter {
        background-color: var(--light-color);
        border-color: var(--gray-300);
        color: var(--gray-700);
        font-size: 0.85rem;
        padding: 0.375rem 0.75rem;
    }

    .btn-filter:hover, .btn-filter.active {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: var(--white-color);
    }

    .metric-card {
        border-left: 4px solid var(--primary-color);
    }

    .metric-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--gray-600);
        margin-bottom: 0.5rem;
    }

    .metric-value {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--gray-800);
        margin-bottom: 0.25rem;
    }

    .metric-change {
        font-size: 0.85rem;
        font-weight: 600;
    }

    .metric-change.positive {
        color: var(--success-color);
    }

    .metric-change.negative {
        color: var(--danger-color);
    }

    .metric-change.neutral {
        color: var(--gray-600);
    }

    .metric-icon {
        font-size: 2.5rem;
        opacity: 0.2;
        position: absolute;
        right: 1rem;
        top: 1rem;
        color: var(--primary-color);
    }

    .date-range-selector {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .chart-container {
        position: relative;
        height: 350px;
    }

    .filter-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .progress-container {
        width: 100%;
        background-color: var(--gray-200);
        border-radius: 1rem;
        height: 0.75rem;
        margin-top: 0.5rem;
        margin-bottom: 0.25rem;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        border-radius: 1rem;
        background-color: var(--primary-color);
        transition: width 0.5s ease;
    }

    .goal-progress {
        font-size: 0.85rem;
        color: var(--gray-600);
        display: flex;
        justify-content: space-between;
    }

    .dropdown-toggle::after {
        margin-left: 0.5rem;
    }

    .dropdown-menu {
        border: none;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        border-radius: 0.5rem;
    }

    .dropdown-item {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
    }

    .dropdown-item:hover {
        background-color: var(--gray-100);
    }

    .dropdown-item i {
        margin-right: 0.5rem;
        color: var(--gray-600);
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

    /* Table styles */
    .table {
        color: var(--gray-800);
        margin-bottom: 0;
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table thead th {
        background-color: var(--gray-100);
        color: var(--gray-700);
        border-top: none;
        border-bottom: 2px solid var(--gray-200);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.03em;
        padding: 0.75rem 1rem;
    }

    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: var(--gray-100);
    }

    .table tbody td {
        padding: 0.75rem 1rem;
        vertical-align: middle;
        border-top: 1px solid var(--gray-200);
        font-size: 0.9rem;
    }

    .form-control {
        border: 1px solid var(--gray-300);
        border-radius: 0.35rem;
        padding: 0.375rem 1rem;
        font-size: 0.9rem;
        transition: all 0.2s;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.1);
    }

    .goal-form {
        display: flex;
        gap: 0.5rem;
    }

    .current-goals {
        margin-bottom: 1.5rem;
    }

    .goal-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--gray-200);
    }

    .goal-item:last-child {
        border-bottom: none;
    }

    .goal-item-name {
        font-weight: 600;
        color: var(--gray-700);
    }

    .goal-item-value {
        font-weight: 700;
        color: var(--primary-color);
    }

    .goal-actions {
        display: flex;
        gap: 0.5rem;
    }

    .step-guide {
        margin-bottom: 2rem;
    }

    .step-item {
        display: flex;
        margin-bottom: 1rem;
    }

    .step-number {
        width: 30px;
        height: 30px;
        background-color: var(--primary-color);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .step-content {
        flex-grow: 1;
    }

    .step-title {
        font-weight: 700;
        color: var(--gray-700);
        margin-bottom: 0.25rem;
    }

    .step-desc {
        color: var(--gray-600);
        font-size: 0.9rem;
    }

    /* Modal styles - ensure proper rendering */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1055;
        width: 100%;
        height: 100%;
        overflow-x: hidden;
        overflow-y: auto;
        outline: 0;
    }

    .modal-dialog {
        position: relative;
        width: auto;
        margin: 0.5rem;
        pointer-events: none;
    }

    .modal.fade .modal-dialog {
        transition: transform 0.3s ease-out;
        transform: translate(0, -50px);
    }

    .modal.show .modal-dialog {
        transform: none;
    }

    .modal-content {
        position: relative;
        display: flex;
        flex-direction: column;
        width: 100%;
        pointer-events: auto;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid rgba(0, 0, 0, 0.2);
        border-radius: 0.3rem;
        outline: 0;
    }

    .modal-header {
        display: flex;
        flex-shrink: 0;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1rem;
        border-bottom: 1px solid #dee2e6;
        border-top-left-radius: calc(0.3rem - 1px);
        border-top-right-radius: calc(0.3rem - 1px);
    }

    .modal-body {
        position: relative;
        flex: 1 1 auto;
        padding: 1rem;
    }

    .modal-footer {
        display: flex;
        flex-wrap: wrap;
        flex-shrink: 0;
        align-items: center;
        justify-content: flex-end;
        padding: 0.75rem;
        border-top: 1px solid #dee2e6;
        border-bottom-right-radius: calc(0.3rem - 1px);
        border-bottom-left-radius: calc(0.3rem - 1px);
    }

    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1050;
        width: 100vw;
        height: 100vh;
        background-color: #000;
    }

    .modal-backdrop.fade {
        opacity: 0;
    }

    .modal-backdrop.show {
        opacity: 0.5;
    }

    @media (min-width: 576px) {
        .modal-dialog {
            max-width: 500px;
            margin: 1.75rem auto;
        }
    }

    /* Responsive tweaks */
    @media (max-width: 992px) {
        .dashboard-container {
            padding: 1rem;
        }
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .filter-bar {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .date-range-selector {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<?php
// Database configuration
$dbHost = 'localhost';
$dbUser = 'root';         // Default XAMPP username
$dbPass = 'Minol@2001';   // Your database password
$dbName = 'avatar_db';    // Your database name

// Initialize variables
$measurements = [];
$error_message = '';
$metrics = [];
$dates = [];
$latest = [];
$initial = [];
$changes = [];
$goals = [];

// Default selected metric for charts
$selected_metric = 'weight';
if (isset($_GET['metric'])) {
    $selected_metric = $_GET['metric'];
}

// Default date range (3 months by default)
$start_date = date('Y-m-d', strtotime('-3 months'));
$end_date = date('Y-m-d');

if (isset($_GET['start_date']) && !empty($_GET['start_date'])) {
    $start_date = $_GET['start_date'];
}

if (isset($_GET['end_date']) && !empty($_GET['end_date'])) {
    $end_date = $_GET['end_date'];
}

try {
    // Create connection
    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Get user information (assuming only one user in the system for simplicity)
    $sql_user = "SELECT name FROM body_measurements ORDER BY id DESC LIMIT 1";
    $result_user = $conn->query($sql_user);
    $user_name = "User";
    
    if ($result_user && $result_user->num_rows > 0) {
        $user = $result_user->fetch_assoc();
        $user_name = $user['name'];
    }
    
    // SQL query to get measurements within the date range
    $sql = "SELECT id, name, age, gender, height, weight, chest, waist, hips, thigh, bicep, neck, measurement_date 
            FROM body_measurements 
            WHERE measurement_date BETWEEN ? AND ? 
            ORDER BY measurement_date ASC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $start_date, $end_date);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result) {
        // Fetch all rows into an array
        while ($row = $result->fetch_assoc()) {
            $measurements[] = $row;
            $dates[] = $row['measurement_date'];
        }
        
        // Get latest and initial measurements from the result set
        if (count($measurements) > 0) {
            $latest = end($measurements);
            $initial = reset($measurements);
            
            // Calculate changes
            $metrics_to_track = ['weight', 'height', 'chest', 'waist', 'hips', 'thigh', 'bicep', 'neck'];
            
            foreach ($metrics_to_track as $metric) {
                if (isset($latest[$metric]) && isset($initial[$metric]) && !is_null($latest[$metric]) && !is_null($initial[$metric])) {
                    $changes[$metric] = $latest[$metric] - $initial[$metric];
                } else {
                    $changes[$metric] = 0;
                }
            }
        }
    } else {
        throw new Exception("Error fetching records: " . $conn->error);
    }
    
    // Create goals table if it doesn't exist
    $createGoalsTable = "CREATE TABLE IF NOT EXISTS body_measurement_goals (
        id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        metric VARCHAR(50) NOT NULL UNIQUE,
        goal_value DECIMAL(5,1) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    if (!$conn->query($createGoalsTable)) {
        throw new Exception("Error creating goals table: " . $conn->error);
    }
    
    // Get goals from database
    $goalsQuery = "SELECT metric, goal_value FROM body_measurement_goals";
    $goalsResult = $conn->query($goalsQuery);
    
    if ($goalsResult) {
        while ($row = $goalsResult->fetch_assoc()) {
            $goals[$row['metric']] = $row['goal_value'];
        }
    }
    
    // Load progress steps
    $progressSteps = array(
        array(
            'title' => 'Add Measurements',
            'description' => 'Start by adding your body measurements using the Add Measurement form.',
            'link' => 'index.php',
            'link_text' => 'Add Measurement'
        ),
        array(
            'title' => 'Set Your Goals',
            'description' => 'Define target values for metrics you want to track, such as weight or waist size.',
            'link' => '#set-goals',
            'link_text' => 'Set Goals'
        ),
        array(
            'title' => 'Track Progress',
            'description' => 'Regularly add new measurements to track changes over time.',
            'link' => 'index.php',
            'link_text' => 'Add New Measurement'
        ),
        array(
            'title' => 'Analyze Your Data',
            'description' => 'Use the charts and statistics to understand your progress and make adjustments.',
            'link' => '#',
            'link_text' => 'View Charts'
        )
    );
    
    $conn->close();
    
} catch (Exception $e) {
    $error_message = $e->getMessage();
}

// Function to display alert messages
function showAlert($message, $type = 'success') {
    echo '<div class="alert alert-' . $type . ' animate__animated animate__fadeIn" role="alert">';
    echo '<i class="fas fa-' . ($type == 'success' ? 'check-circle' : 'exclamation-circle') . ' me-2"></i>';
    echo $message;
    echo '<button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}

// Function to calculate progress percentage
function calculateProgress($current, $initial, $goal) {
    if ($goal == 0 || $initial == $goal) {
        return 0;
    }
    
    $total_change_needed = $goal - $initial;
    $current_change = $current - $initial;
    
    if ($total_change_needed == 0) {
        return 100;
    }
    
    $progress = ($current_change / $total_change_needed) * 100;
    
    // Cap progress at 100%
    if ($progress > 100) {
        return 100;
    } elseif ($progress < 0) {
        return 0;
    }
    
    return $progress;
}

// Function to get change indicator and class
function getChangeIndicator($change, $metric) {
    $indicator = '';
    $class = 'neutral';
    
    // Metrics where lower is better
    $lower_is_better = ['weight', 'waist', 'hips'];
    
    // Metrics where higher is better
    $higher_is_better = ['chest', 'thigh', 'bicep', 'neck'];
    
    if (in_array($metric, $lower_is_better)) {
        if ($change < 0) {
            $indicator = '↓ ' . abs($change);
            $class = 'positive';
        } elseif ($change > 0) {
            $indicator = '↑ ' . $change;
            $class = 'negative';
        } else {
            $indicator = '― 0';
        }
    } elseif (in_array($metric, $higher_is_better)) {
        if ($change > 0) {
            $indicator = '↑ ' . $change;
            $class = 'positive';
        } elseif ($change < 0) {
            $indicator = '↓ ' . abs($change);
            $class = 'negative';
        } else {
            $indicator = '― 0';
        }
    } else {
        // For metrics that don't fit either category
        if ($change > 0) {
            $indicator = '↑ ' . $change;
        } elseif ($change < 0) {
            $indicator = '↓ ' . abs($change);
        } else {
            $indicator = '― 0';
        }
    }
    
    return ['indicator' => $indicator, 'class' => $class];
}

// Function to get metric icon
function getMetricIcon($metric) {
    $icons = [
        'weight' => 'fas fa-weight',
        'height' => 'fas fa-ruler-vertical',
        'chest' => 'fas fa-tshirt',
        'waist' => 'fas fa-male',
        'hips' => 'fas fa-female',
        'thigh' => 'fas fa-walking',
        'bicep' => 'fas fa-dumbbell',
        'neck' => 'fas fa-user'
    ];
    
    return isset($icons[$metric]) ? $icons[$metric] : 'fas fa-ruler';
}

// Function to get friendly metric name
function getMetricName($metric) {
    $names = [
        'weight' => 'Weight',
        'height' => 'Height',
        'chest' => 'Chest/Bust',
        'waist' => 'Waist',
        'hips' => 'Hips',
        'thigh' => 'Thigh',
        'bicep' => 'Bicep',
        'neck' => 'Neck'
    ];
    
    return isset($names[$metric]) ? $names[$metric] : ucfirst($metric);
}

// Function to get metric unit
function getMetricUnit($metric) {
    $units = [
        'weight' => 'kg',
        'height' => 'cm',
        'chest' => 'cm',
        'waist' => 'cm',
        'hips' => 'cm',
        'thigh' => 'cm',
        'bicep' => 'cm',
        'neck' => 'cm'
    ];
    
    return isset($units[$metric]) ? $units[$metric] : '';
}
?>

<!-- Main Content -->
<div class="dashboard-container">
    <!-- Page Header with Date Range Selector -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Progress Tracker</h1>
            <p class="page-subtitle">Track and visualize your body measurement progress over time</p>
        </div>
        
        <form action="progress_tracker.php" method="GET" class="date-range-selector">
            <input type="hidden" name="metric" value="<?php echo htmlspecialchars($selected_metric); ?>">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                <input type="date" class="form-control" name="start_date" value="<?php echo $start_date; ?>">
                <span class="input-group-text">to</span>
                <input type="date" class="form-control" name="end_date" value="<?php echo $end_date; ?>">
                <button type="submit" class="btn btn-primary">Apply</button>
            </div>
        </form>
    </div>
    
    <?php 
    // Display flash messages from session
    if (isset($_SESSION['flash_message'])) {
        showAlert($_SESSION['flash_message'], isset($_SESSION['flash_type']) ? $_SESSION['flash_type'] : 'success');
        // Clear flash message
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
    }
    
    if (!empty($error_message)): 
    ?>
        <?php showAlert($error_message, 'danger'); ?>
    <?php endif; ?>
    
    <?php if (empty($measurements)): ?>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                <i class="fas fa-info-circle"></i> Getting Started
            </h5>
        </div>
        <div class="card-body">
            <div class="step-guide">
                <h5>How to Use the Progress Tracker</h5>
                <p>Follow these steps to track your body measurements over time:</p>
                
                <?php foreach ($progressSteps as $index => $step): ?>
                <div class="step-item">
                    <div class="step-number"><?php echo $index + 1; ?></div>
                    <div class="step-content">
                        <div class="step-title"><?php echo $step['title']; ?></div>
                        <div class="step-desc"><?php echo $step['description']; ?></div>
                        <a href="<?php echo $step['link']; ?>" class="btn btn-sm btn-primary mt-2">
                            <?php echo $step['link_text']; ?>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="text-center mt-4">
                <p class="text-muted">No body measurements found in the selected date range.</p>
                <a href="index.php" class="btn btn-primary mt-3">
                    <i class="fas fa-plus-circle me-2"></i> Add Your First Measurement
                </a>
            </div>
        </div>
    </div>
    <?php else: ?>
        <!-- Key Metrics Summary Cards -->
        <div class="row">
            <!-- Weight Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card metric-card floating-card">
                    <div class="card-body position-relative">
                        <div class="metric-title">Weight</div>
                        <div class="metric-value"><?php echo number_format($latest['weight'], 1); ?> kg</div>
                        <?php
                            $change_data = getChangeIndicator($changes['weight'], 'weight');
                        ?>
                        <div class="metric-change <?php echo $change_data['class']; ?>">
                            <?php echo $change_data['indicator']; ?> kg
                        </div>
                        <i class="<?php echo getMetricIcon('weight'); ?> metric-icon"></i>
                    </div>
                </div>
            </div>
            
            <!-- Waist Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card metric-card floating-card">
                    <div class="card-body position-relative">
                        <div class="metric-title">Waist</div>
                        <div class="metric-value">
                            <?php echo !empty($latest['waist']) ? number_format($latest['waist'], 1) : '-'; ?> 
                            <?php echo !empty($latest['waist']) ? 'cm' : ''; ?>
                        </div>
                        <?php if (!empty($latest['waist']) && !empty($initial['waist'])): ?>
                            <?php $change_data = getChangeIndicator($changes['waist'], 'waist'); ?>
                            <div class="metric-change <?php echo $change_data['class']; ?>">
                                <?php echo $change_data['indicator']; ?> cm
                            </div>
                        <?php else: ?>
                            <div class="metric-change neutral">No change data</div>
                        <?php endif; ?>
                        <i class="<?php echo getMetricIcon('waist'); ?> metric-icon"></i>
                    </div>
                </div>
            </div>
            
            <!-- Chest Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card metric-card floating-card">
                    <div class="card-body position-relative">
                        <div class="metric-title">Chest/Bust</div>
                        <div class="metric-value">
                            <?php echo !empty($latest['chest']) ? number_format($latest['chest'], 1) : '-'; ?> 
                            <?php echo !empty($latest['chest']) ? 'cm' : ''; ?>
                        </div>
                        <?php if (!empty($latest['chest']) && !empty($initial['chest'])): ?>
                            <?php $change_data = getChangeIndicator($changes['chest'], 'chest'); ?>
                            <div class="metric-change <?php echo $change_data['class']; ?>">
                                <?php echo $change_data['indicator']; ?> cm
                            </div>
                        <?php else: ?>
                            <div class="metric-change neutral">No change data</div>
                        <?php endif; ?>
                        <i class="<?php echo getMetricIcon('chest'); ?> metric-icon"></i>
                    </div>
                </div>
            </div>
            
            <!-- Hips Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card metric-card floating-card">
                    <div class="card-body position-relative">
                        <div class="metric-title">Hips</div>
                        <div class="metric-value">
                            <?php echo !empty($latest['hips']) ? number_format($latest['hips'], 1) : '-'; ?> 
                            <?php echo !empty($latest['hips']) ? 'cm' : ''; ?>
                        </div>
                        <?php if (!empty($latest['hips']) && !empty($initial['hips'])): ?>
                            <?php $change_data = getChangeIndicator($changes['hips'], 'hips'); ?>
                            <div class="metric-change <?php echo $change_data['class']; ?>">
                                <?php echo $change_data['indicator']; ?> cm
                            </div>
                        <?php else: ?>
                            <div class="metric-change neutral">No change data</div>
                        <?php endif; ?>
                        <i class="<?php echo getMetricIcon('hips'); ?> metric-icon"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Charts Section -->
        <div class="row">
            <!-- Progress Chart -->
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-chart-line"></i> Progress Chart
                        </h5>
                        <div class="filter-bar">
                            <a href="?metric=weight&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>" class="btn btn-filter <?php echo $selected_metric == 'weight' ? 'active' : ''; ?>">Weight</a>
                            <a href="?metric=waist&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>" class="btn btn-filter <?php echo $selected_metric == 'waist' ? 'active' : ''; ?>">Waist</a>
                            <a href="?metric=chest&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>" class="btn btn-filter <?php echo $selected_metric == 'chest' ? 'active' : ''; ?>">Chest</a>
                            <a href="?metric=hips&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>" class="btn btn-filter <?php echo $selected_metric == 'hips' ? 'active' : ''; ?>">Hips</a>
                            <a href="?metric=thigh&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>" class="btn btn-filter <?php echo $selected_metric == 'thigh' ? 'active' : ''; ?>">Thigh</a>
                            <a href="?metric=bicep&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>" class="btn btn-filter <?php echo $selected_metric == 'bicep' ? 'active' : ''; ?>">Bicep</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="progressChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Progress Goals -->
            <div class="col-lg-4 mb-4">
                <div class="card" id="set-goals">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-bullseye"></i> My Goals
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Current Goals -->
                        <?php if (!empty($goals)): ?>
                            <div class="current-goals">
                                <h6 class="mb-3">Current Goals</h6>
                                <?php foreach ($goals as $metric => $goal_value): ?>
                                    <?php if (!empty($latest[$metric]) && !empty($initial[$metric])): 
                                        $progress = calculateProgress($latest[$metric], $initial[$metric], $goal_value);
                                        // Check if we need to go down or up to reach the goal
                                        $direction = $goal_value < $initial[$metric] ? 'down' : 'up';
                                        $remaining = abs($goal_value - $latest[$metric]);
                                    ?>
                                        <div class="mb-4">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <h6><?php echo getMetricName($metric); ?> Goal</h6>
                                                <div class="goal-actions">
                                                    <span class="badge bg-primary"><?php echo $goal_value; ?> <?php echo getMetricUnit($metric); ?></span>
                                                    <button type="button" class="btn btn-sm btn-outline-primary edit-goal-btn" data-metric="<?php echo $metric; ?>" data-value="<?php echo $goal_value; ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="progress-container">
                                                <div class="progress-bar" style="width: <?php echo $progress; ?>%"></div>
                                            </div>
                                            <div class="goal-progress">
                                                <span>Current: <?php echo number_format($latest[$metric], 1); ?> <?php echo getMetricUnit($metric); ?></span>
                                                <span><?php echo number_format($progress, 0); ?>% Complete</span>
                                            </div>
                                            <p class="mt-2 mb-0 text-muted">
                                                <small>
                                                    <?php if ($remaining > 0): ?>
                                                        You need to go <?php echo $direction; ?> by <?php echo number_format($remaining, 1); ?> <?php echo getMetricUnit($metric); ?> to reach your goal.
                                                    <?php else: ?>
                                                        Congratulations! You've reached your goal.
                                                    <?php endif; ?>
                                                </small>
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                No goals set yet. Define your fitness goals below to track your progress.
                            </div>
                        <?php endif; ?>
                        
                        <!-- Add Goal Form -->
                        <div class="mt-4">
                            <h6 class="mb-3">Set a New Goal</h6>
                            <form action="save_goal.php" method="POST" class="goal-form">
                                <select class="form-select" name="goal_metric" id="goal_metric">
                                    <option value="">Select Metric</option>
                                    <option value="weight">Weight</option>
                                    <option value="waist">Waist</option>
                                    <option value="chest">Chest</option>
                                    <option value="hips">Hips</option>
                                    <option value="thigh">Thigh</option>
                                    <option value="bicep">Bicep</option>
                                    <option value="neck">Neck</option>
                                </select>
                                <input type="number" class="form-control" name="goal_value" id="goal_value" step="0.1" placeholder="Target Value">
                                <button type="submit" class="btn btn-primary">Set</button>
                            </form>
                            <p class="mt-2 mb-0 form-text">
                                <small>Set realistic goals based on your progress. Existing goals will be updated if you select the same metric.</small>
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- BMI Card -->
                <div class="card floating-card mt-4">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-calculator"></i> BMI Calculator
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <?php
                            // Calculate BMI if height and weight are available
                            if (!empty($latest['height']) && !empty($latest['weight'])):
                                $height_m = $latest['height'] / 100;
                                $bmi = $latest['weight'] / ($height_m * $height_m);
                                $bmi_category = '';
                                $bmi_color = '';
                                
                                if ($bmi < 18.5) {
                                    $bmi_category = 'Underweight';
                                    $bmi_color = 'text-warning';
                                } elseif ($bmi < 25) {
                                    $bmi_category = 'Normal';
                                    $bmi_color = 'text-success';
                                } elseif ($bmi < 30) {
                                    $bmi_category = 'Overweight';
                                    $bmi_color = 'text-warning';
                                } else {
                                    $bmi_category = 'Obese';
                                    $bmi_color = 'text-danger';
                                }
                        ?>
                        <div class="display-4 mb-2"><?php echo number_format($bmi, 1); ?></div>
                        <p class="<?php echo $bmi_color; ?> fw-bold mb-1"><?php echo $bmi_category; ?></p>
                        <p class="text-muted">
                            <small>Height: <?php echo $latest['height']; ?> cm, Weight: <?php echo $latest['weight']; ?> kg</small>
                        </p>
                        <div class="mt-3">
                            <small class="text-muted">
                                <strong>BMI Categories:</strong><br>
                                <span class="text-warning">Underweight: &lt; 18.5</span><br>
                                <span class="text-success">Normal: 18.5 - 24.9</span><br>
                                <span class="text-warning">Overweight: 25 - 29.9</span><br>
                                <span class="text-danger">Obese: &gt;= 30</span>
                            </small>
                        </div>
                        <?php else: ?>
                        <p class="mb-0">Insufficient data to calculate BMI. Please add height and weight measurements.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Measurement History Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-history"></i> Measurement History
                </h5>
<!-- Replace your export dropdown with this code -->
<div class="dropdown">
    <button class="btn btn-sm btn-filter dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-download me-1"></i> Export
    </button>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="exportDropdown">
        <li><button class="dropdown-item" type="button" onclick="exportTableToExcel('body_measurements.xlsx')"><i class="fas fa-file-excel me-2"></i> Export to Excel</button></li>
        <li><button class="dropdown-item" type="button" onclick="exportTableToPDF('body_measurements.pdf')"><i class="fas fa-file-pdf me-2"></i> Export to PDF</button></li>
        <li><button class="dropdown-item" type="button" onclick="exportTableToCSV('body_measurements.csv')"><i class="fas fa-file-csv me-2"></i> Export to CSV</button></li>
        <li><button class="dropdown-item" type="button" onclick="printTable()"><i class="fas fa-print me-2"></i> Print Table</button></li>
    </ul>
</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="measurementsTable">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Weight (kg)</th>
                                <th>Chest (cm)</th>
                                <th>Waist (cm)</th>
                                <th>Hips (cm)</th>
                                <th>Thigh (cm)</th>
                                <th>Bicep (cm)</th>
                                <th>Neck (cm)</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_reverse($measurements) as $row): ?>
                                <tr>
                                    <td><?php echo date('d M Y', strtotime($row['measurement_date'])); ?></td>
                                    <td><?php echo !empty($row['weight']) ? number_format($row['weight'], 1) : '-'; ?></td>
                                    <td><?php echo !empty($row['chest']) ? number_format($row['chest'], 1) : '-'; ?></td>
                                    <td><?php echo !empty($row['waist']) ? number_format($row['waist'], 1) : '-'; ?></td>
                                    <td><?php echo !empty($row['hips']) ? number_format($row['hips'], 1) : '-'; ?></td>
                                    <td><?php echo !empty($row['thigh']) ? number_format($row['thigh'], 1) : '-'; ?></td>
                                    <td><?php echo !empty($row['bicep']) ? number_format($row['bicep'], 1) : '-'; ?></td>
                                    <td><?php echo !empty($row['neck']) ? number_format($row['neck'], 1) : '-'; ?></td>
                                    <td>
                                        <a href="edit_measurement.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Goal Edit Modal -->
<div class="modal fade" id="editGoalModal" tabindex="-1" aria-labelledby="editGoalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editGoalModalLabel">Edit Goal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editGoalForm" action="save_goal.php" method="POST">
                    <input type="hidden" name="goal_metric" id="edit_goal_metric">
                    <div class="mb-3">
                        <label for="edit_goal_value" class="form-label">Target Value</label>
                        <input type="number" class="form-control" id="edit_goal_value" name="goal_value" step="0.1" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="deleteGoalBtn">Delete Goal</button>
                <button type="button" class="btn btn-primary" id="saveGoalBtn">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Include Font Awesome and Chart.js library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {


    if (typeof bootstrap !== 'undefined') {
        // Initialize all dropdowns on the page
        var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
        dropdownElementList.map(function(dropdownToggleEl) {
            return new bootstrap.Dropdown(dropdownToggleEl);
        });
        
        console.log('Dropdowns initialized successfully');
    } else {
        console.error('Bootstrap JavaScript not loaded properly');
    }
    <?php if (!empty($measurements)): ?>
    // Prepare data for the chart
    const dates = <?php echo json_encode(array_map(function($date) { return date('d M', strtotime($date)); }, $dates)); ?>;
    
    // Find which measurements have data for the selected metric
    const metric = '<?php echo $selected_metric; ?>';
    const metricData = [];
    
    <?php foreach ($measurements as $index => $measurement): ?>
        <?php if (!empty($measurement[$selected_metric])): ?>
            metricData.push(<?php echo $measurement[$selected_metric]; ?>);
        <?php else: ?>
            metricData.push(null);
        <?php endif; ?>
    <?php endforeach; ?>
    
    // Add goal line if available
    const goalData = [];
    const hasGoal = <?php echo isset($goals[$selected_metric]) ? 'true' : 'false'; ?>;
    const goalValue = <?php echo isset($goals[$selected_metric]) ? $goals[$selected_metric] : '0'; ?>;
    
    if (hasGoal) {
        for (let i = 0; i < dates.length; i++) {
            goalData.push(goalValue);
        }
    }
    
    // Create the progress chart
    const ctx = document.getElementById('progressChart').getContext('2d');
    const progressChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [
                {
                    label: '<?php echo getMetricName($selected_metric); ?> (<?php echo getMetricUnit($selected_metric); ?>)',
                    data: metricData,
                    backgroundColor: 'rgba(78, 115, 223, 0.05)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 3,
                    pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointBorderColor: '#fff',
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 2,
                    pointRadius: 4,
                    pointHitRadius: 10,
                    fill: true,
                    tension: 0.4
                },
                hasGoal ? {
                    label: 'Goal',
                    data: goalData,
                    borderColor: 'rgba(28, 200, 138, 0.8)',
                    borderWidth: 2,
                    borderDash: [5, 5],
                    pointRadius: 0,
                    fill: false,
                    tension: 0
                } : null
            ].filter(dataset => dataset !== null)
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: false,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.8)',
                    titleColor: '#5a5c69',
                    bodyColor: '#5a5c69',
                    borderColor: 'rgba(78, 115, 223, 0.2)',
                    borderWidth: 1,
                    displayColors: false,
                    caretPadding: 10,
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ${context.parsed.y}`;
                        }
                    }
                }
            }
        }
    });
    <?php endif; ?>
    
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

    // Handle modal for editing goals
    const editGoalModal = new bootstrap.Modal(document.getElementById('editGoalModal'), {
        backdrop: 'static'
    });
    
    // Edit goal buttons
    const editGoalButtons = document.querySelectorAll('.edit-goal-btn');
    editGoalButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const metric = this.getAttribute('data-metric');
            const value = this.getAttribute('data-value');
            
            document.getElementById('edit_goal_metric').value = metric;
            document.getElementById('edit_goal_value').value = value;
            document.getElementById('editGoalModalLabel').textContent = 'Edit ' + metric.charAt(0).toUpperCase() + metric.slice(1) + ' Goal';
            
            editGoalModal.show();
        });
    });
    
    // Save goal button (submit the form)
    document.getElementById('saveGoalBtn').addEventListener('click', function() {
        document.getElementById('editGoalForm').submit();
    });
    
    // Delete goal button
    document.getElementById('deleteGoalBtn').addEventListener('click', function() {
        const metric = document.getElementById('edit_goal_metric').value;
        
        if (confirm('Are you sure you want to delete this goal?')) {
            window.location.href = 'delete_goal.php?metric=' + metric;
        }
    });
    
    // Set up export functionality
    setupExportFunctions();
});

// Export functionality setup
function setupExportFunctions() {
    // Add event listeners to export buttons
    document.getElementById('exportExcelBtn').addEventListener('click', function(e) {
        e.preventDefault();
        exportTableToExcel('body_measurements.xlsx');
    });
    
    document.getElementById('exportPdfBtn').addEventListener('click', function(e) {
        e.preventDefault();
        exportTableToPDF('body_measurements.pdf');
    });
    
    document.getElementById('exportCsvBtn').addEventListener('click', function(e) {
        e.preventDefault();
        exportTableToCSV('body_measurements.csv');
    });
    
    document.getElementById('printTableBtn').addEventListener('click', function(e) {
        e.preventDefault();
        printTable();
    });
}

// Add these functions at the end of your script section

// Excel export function - simplified version
function exportTableToExcel(filename) {
    alert("Starting Excel export...");
    try {
        const table = document.getElementById('measurementsTable');
        
        if (!table) {
            alert("Error: Table not found!");
            return;
        }
        
        if (typeof XLSX === 'undefined') {
            alert("Error: XLSX library not loaded!");
            return;
        }
        
        // Simple conversion approach
        const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.table_to_sheet(table);
        
        // Remove actions column by setting it to empty
        const range = XLSX.utils.decode_range(ws['!ref']);
        for (let r = range.s.r; r <= range.e.r; r++) {
            const cell_address = XLSX.utils.encode_cell({r: r, c: 8}); // 9th column (index 8)
            if (ws[cell_address]) {
                ws[cell_address].v = "";
            }
        }
        
        XLSX.utils.book_append_sheet(wb, ws, "Measurements");
        XLSX.writeFile(wb, filename);
        
        alert("Excel export complete!");
    } catch (error) {
        alert("Excel export failed: " + error.message);
        console.error(error);
    }
}

// PDF export function - simplified version
function exportTableToPDF(filename) {
    alert("Starting PDF export...");
    try {
        if (typeof window.jspdf === 'undefined') {
            alert("Error: jsPDF library not loaded!");
            return;
        }
        
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        
        doc.text('Body Measurements History', 14, 22);
        
        doc.autoTable({
            html: '#measurementsTable',
            startY: 30,
            columnStyles: {
                8: { ignoreColumn: true } // Skip the actions column
            }
        });
        
        doc.save(filename);
        alert("PDF export complete!");
    } catch (error) {
        alert("PDF export failed: " + error.message);
        console.error(error);
    }
}

// CSV export function - simplified version
function exportTableToCSV(filename) {
    alert("Starting CSV export...");
    try {
        const table = document.getElementById('measurementsTable');
        if (!table) {
            alert("Error: Table not found!");
            return;
        }
        
        let csv = [];
        const rows = table.querySelectorAll('tr');
        
        for (let i = 0; i < rows.length; i++) {
            const row = [];
            const cols = rows[i].querySelectorAll('td, th');
            
            for (let j = 0; j < cols.length - 1; j++) { // Skip last column
                let cell = cols[j].innerText.replace(/\r?\n/g, " ");
                cell = cell.replace(/,/g, ";"); // Replace commas with semicolons
                row.push('"' + cell + '"');
            }
            
            csv.push(row.join(','));
        }
        
        const csvText = csv.join('\n');
        const blob = new Blob([csvText], { type: 'text/csv;charset=utf-8;' });
        
        // Create download link
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = filename;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        alert("CSV export complete!");
    } catch (error) {
        alert("CSV export failed: " + error.message);
        console.error(error);
    }
}

// Print function - simplified version
function printTable() {
    alert("Preparing to print...");
    try {
        const table = document.getElementById('measurementsTable');
        if (!table) {
            alert("Error: Table not found!");
            return;
        }
        
        const printWindow = window.open('', '', 'height=600,width=800');
        printWindow.document.write('<html><head><title>Body Measurements</title>');
        printWindow.document.write('<style>table{width:100%;border-collapse:collapse;}th,td{border:1px solid #ddd;padding:8px;}th{background:#f2f2f2;}</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write('<h1 style="text-align:center">Body Measurements History</h1>');
        
        // Create a table clone without the Actions column
        const tableClone = table.cloneNode(true);
        const rows = tableClone.querySelectorAll('tr');
        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].querySelectorAll('th, td');
            if (cells.length > 0) {
                cells[cells.length - 1].remove();
            }
        }
        
        printWindow.document.write(tableClone.outerHTML);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.focus();
        
        setTimeout(function() {
            printWindow.print();
            printWindow.close();
        }, 250);
        
    } catch (error) {
        alert("Print failed: " + error.message);
        console.error(error);
    }
}
</script>

<?php include 'footer.php'; ?>