<footer class="bg-light py-4 mt-5">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h5 class="mb-3">Body Metrics Tracker</h5>
          <p class="text-muted">Track your fitness journey with our easy-to-use body measurements tool.</p>
        </div>
        <div class="col-md-3">
          <h5 class="mb-3">Quick Links</h5>
          <ul class="list-unstyled">
            <li><a href="index.php" class="text-decoration-none text-muted">Home</a></li>
            <li><a href="view_measurements.php" class="text-decoration-none text-muted">View All</a></li>
            <li><a href="progress_tracker.php" class="text-decoration-none text-muted">Progress Tracker</a></li>
          </ul>
        </div>
        <div class="col-md-3">
          <h5 class="mb-3">Features</h5>
        </div>
      </div>
      <hr>
      <div class="d-flex justify-content-between align-items-center">
        <p class="small text-muted mb-0">&copy; <?php echo date('Y'); ?> Body Metrics Tracker. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <!-- Bootstrap JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    // Common JavaScript functionality
    document.addEventListener('DOMContentLoaded', function() {
      // Auto-hide messages after 3 seconds
      let messages = document.querySelectorAll('.message, .success, .error');
      if (messages.length > 0) {
        setTimeout(function() {
          messages.forEach(function(message) {
            message.style.display = 'none';
          });
        }, 3000);
      }
    });
  </script>
</body>
</html>