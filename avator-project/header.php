<?php
// Initialize any variables needed for all pages
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Body Metrics Tracker</title>
  <!-- Bootstrap first -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <!-- Then your custom CSS files -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/bodyForm.css">
  <link rel="stylesheet" href="css/header-style.css">
</head>
<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
      <div class="container">
        <!-- <a class="navbar-brand" href="index.php">
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 16 16" class="brand-icon">
            <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z"/>
          </svg>
          <span class="brand-text">Body Metrics Tracker</span>
        </a> -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php">Body Visualizer</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle <?php echo ($current_page == 'view_measurements.php' || $current_page == 'edit_measurement.php') ? 'active' : ''; ?>" href="#" id="measurementsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Measurements
              </a>
              <ul class="dropdown-menu" aria-labelledby="measurementsDropdown">
                <li><a class="dropdown-item" href="add_measurement.php">Add New</a></li>
                <li><a class="dropdown-item" href="view_measurements.php">View All</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo ($current_page == 'progress_tracker.php') ? 'active' : ''; ?>" href="progress_tracker.php">Progress Tracker</a>
            </li>
          
          </ul>
          <div class="ms-lg-3 mt-3 mt-lg-0">
            <a href="add_measurement.php" class="btn btn-success">Add Measurement</a>
          </div>
        </div>
      </div>
    </nav>
  </header>