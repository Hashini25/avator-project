<?php
// Include the header
include 'header.php';

// Database configuration
$dbHost = 'localhost';
$dbUser = 'root';         // Default XAMPP username
$dbPass = 'Minol@2001';   // Your database password
$dbName = 'avatar_db'; // Your database name

// Delete record if requested
if (isset($_GET['delete_id']) && !empty($_GET['delete_id'])) {
    $delete_id = filter_input(INPUT_GET, 'delete_id', FILTER_VALIDATE_INT);
    
    if ($delete_id) {
        try {
            // Create connection
            $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
            
            // Check connection
            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }
            
            // Prepare and bind
            $stmt = $conn->prepare("DELETE FROM body_measurements WHERE id = ?");
            $stmt->bind_param("i", $delete_id);
            
            // Execute the statement
            if ($stmt->execute()) {
                // Redirect to avoid resubmission on refresh
                header("Location: view_measurements.php?deleted=1");
                exit();
            } else {
                throw new Exception("Error deleting record: " . $stmt->error);
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

// Initialize variable for storing measurements data
$measurements = [];
$error_message = '';

try {
    // Create connection
    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // SQL query to get all measurements ordered by most recent first
    $sql = "SELECT * FROM body_measurements ORDER BY measurement_date DESC";
    $result = $conn->query($sql);
    
    if ($result) {
        // Fetch all rows into an array
        while ($row = $result->fetch_assoc()) {
            $measurements[] = $row;
        }
    } else {
        throw new Exception("Error fetching records: " . $conn->error);
    }
    
    $conn->close();
    
} catch (Exception $e) {
    $error_message = $e->getMessage();
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
        max-width: 1400px;
        margin: 0 auto;
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
        font-size: 1.5rem;
        display: flex;
        align-items: center;
    }

    .card-title i {
        margin-right: 0.75rem;
        color: var(--primary-color);
        font-size: 1.25rem;
    }

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
        padding: 1rem;
        white-space: nowrap;
    }

    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: var(--gray-100);
        transform: translateY(-2px);
        box-shadow: 0 0.15rem 0.3rem rgba(58, 59, 69, 0.1);
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-top: 1px solid var(--gray-200);
        font-size: 0.9rem;
    }

    .badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.35em 0.65em;
        border-radius: 0.25rem;
    }

    .badge-male {
        background-color: var(--info-color);
        color: white;
    }

    .badge-female {
        background-color: var(--danger-color);
        color: white;
    }

    .badge-other {
        background-color: var(--warning-color);
        color: white;
    }

    .stats-badge {
        background-color: var(--gray-200);
        color: var(--gray-700);
        border-radius: 50rem;
        padding: 0.35em 0.65em;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .btn-action {
        border-radius: 50rem;
        font-size: 0.85rem;
        font-weight: 600;
        padding: 0.375rem 0.75rem;
        text-transform: none;
        transition: all 0.2s;
        box-shadow: 0 0.125rem 0.25rem rgba(58, 59, 69, 0.1);
    }

    .btn-edit {
        background-color: var(--info-color);
        color: white;
        border: none;
    }

    .btn-edit:hover {
        background-color: #2a93a3;
        color: white;
        transform: translateY(-2px);
    }

    .btn-delete {
        background-color: var(--danger-color);
        color: white;
        border: none;
    }

    .btn-delete:hover {
        background-color: #c93b2d;
        color: white;
        transform: translateY(-2px);
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
        font-weight: 600;
        border-radius: 50rem;
        padding: 0.375rem 1.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(58, 59, 69, 0.1);
    }

    .btn-primary:hover {
        background-color: var(--accent-color);
        border-color: var(--accent-color);
        transform: translateY(-2px);
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

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .empty-state {
        padding: 3rem 2rem;
        text-align: center;
    }

    .empty-state-icon {
        font-size: 3.5rem;
        color: var(--gray-400);
        margin-bottom: 1.5rem;
    }

    .empty-state-text {
        font-size: 1.1rem;
        color: var(--gray-600);
        margin-bottom: 1.5rem;
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

    .card-header-tabs {
        margin-right: -1.25rem;
        margin-bottom: -1.25rem;
        margin-left: -1.25rem;
        border-bottom: 0;
    }

    .nav-tabs .nav-link {
        border: none;
        color: var(--gray-600);
        font-weight: 600;
        padding: 1rem 1.5rem;
        font-size: 0.9rem;
    }

    .nav-tabs .nav-link.active {
        color: var(--primary-color);
        border-bottom: 3px solid var(--primary-color);
        background: transparent;
    }

    .nav-tabs .nav-link:hover:not(.active) {
        color: var(--gray-800);
        border-bottom: 3px solid var(--gray-300);
    }

    .btn-add-new {
        background-color: var(--success-color);
        border-color: var(--success-color);
        color: white;
        font-weight: 600;
        border-radius: 50rem;
        padding: 0.375rem 1rem;
        display: flex;
        align-items: center;
    }

    .btn-add-new i {
        margin-right: 0.5rem;
    }

    .btn-add-new:hover {
        background-color: #169b6b;
        border-color: #169b6b;
        transform: translateY(-2px);
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

    /* Responsive tweaks */
    @media (max-width: 992px) {
        .table-responsive {
            box-shadow: none;
        }
        
        .dashboard-container {
            padding: 1rem;
        }
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .page-actions {
            margin-top: 1rem;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }
    }
</style>

<!-- Main Content - View Measurements Table -->
<div class="dashboard-container">
    <!-- Page Header with Actions -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Body Measurements Records</h1>
            <p class="page-subtitle">View and manage all your recorded body measurements</p>
        </div>
        
        <div class="page-actions">
            <a href="add_measurement.php" class="btn btn-add-new">
                <i class="fas fa-plus-circle"></i> Add New Measurement
            </a>
        </div>
    </div>
    
    <!-- Success/Error Alert -->
    <?php if (isset($_GET['deleted'])): ?>
        <?php showAlert('Record deleted successfully!'); ?>
    <?php endif; ?>
    
    <?php if (!empty($error_message)): ?>
        <?php showAlert($error_message, 'danger'); ?>
    <?php endif; ?>
    
    <!-- Table Card with Data -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title"><i class="fas fa-table"></i> Measurement Records</h5>
            
            <!-- Optional: Add tabs for different views -->
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#">All Records</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Latest Only</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <?php if (!empty($measurements)): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Height (cm)</th>
                                <th>Weight (kg)</th>
                                <th>Chest (cm)</th>
                                <th>Waist (cm)</th>
                                <th>Hips (cm)</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($measurements as $row): ?>
                                <tr>
                                    <td>
                                        <strong><?php echo htmlspecialchars(date('Y-m-d', strtotime($row['measurement_date']))); ?></strong>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['age']); ?></td>
                                    <td>
                                        <?php if ($row['gender'] == 'Male'): ?>
                                            <span class="badge badge-male">
                                                <i class="fas fa-mars me-1"></i> Male
                                            </span>
                                        <?php elseif ($row['gender'] == 'Female'): ?>
                                            <span class="badge badge-female">
                                                <i class="fas fa-venus me-1"></i> Female
                                            </span>
                                        <?php else: ?>
                                            <span class="badge badge-other">
                                                <i class="fas fa-genderless me-1"></i> <?php echo htmlspecialchars($row['gender']); ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['height']); ?></td>
                                    <td><?php echo htmlspecialchars($row['weight']); ?></td>
                                    <td>
                                        <?php if(!empty($row['chest'])): ?>
                                            <span class="stats-badge"><?php echo htmlspecialchars($row['chest']); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if(!empty($row['waist'])): ?>
                                            <span class="stats-badge"><?php echo htmlspecialchars($row['waist']); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if(!empty($row['hips'])): ?>
                                            <span class="stats-badge"><?php echo htmlspecialchars($row['hips']); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="edit_measurement.php?id=<?php echo $row['id']; ?>" class="btn btn-action btn-edit" title="Edit this record">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>
                                            <a href="view_measurements.php?delete_id=<?php echo $row['id']; ?>" 
                                               class="btn btn-action btn-delete" 
                                               title="Delete this record"
                                               onclick="return confirm('Are you sure you want to delete this record?');">
                                                <i class="fas fa-trash-alt me-1"></i> Delete
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <!-- Empty State with better styling -->
                <div class="empty-state">
                    <i class="fas fa-clipboard-list empty-state-icon"></i>
                    <h3>No Records Found</h3>
                    <p class="empty-state-text">You haven't added any body measurements yet. Add your first measurement to start tracking your progress.</p>
                    <a href="index.php" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> Add Your First Measurement
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Bootstrap & Required JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

<script>
    // Enhanced auto-hide alerts after 5 seconds with fade effect
    document.addEventListener('DOMContentLoaded', function() {
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
        
        // Initialize any Bootstrap components if needed
        // For example, tooltips and popovers
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>

<?php include 'footer.php'; ?>