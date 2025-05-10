<?php include 'header.php'; ?>

<!-- Body Measurements Form Section -->
<link rel="stylesheet" href='css/bodyForm.css'>
<div class="container">
  <h1>Add New Body Measurements</h1>
  <form action="add_measurement.php" method="POST" id="measurementForm">
    <div class="form-group">
      <label for="name">Full Name:</label>
      <input type="text" id="name" name="name" required>
    </div>
    
    <div class="form-group">
      <label for="age">Age:</label>
      <input type="number" id="age" name="age" min="1" max="120" required>
    </div>
    
    <div class="form-group">
      <label for="gender">Gender:</label>
      <select id="gender" name="gender" required>
        <option value="">Select Gender</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
        <option value="other">Other</option>
      </select>
    </div>
    
    <div class="form-group">
      <label for="height-form">Height (cm):</label>
      <input type="number" id="height-form" name="height" step="0.1" min="50" max="250" required>
    </div>
    
    <div class="form-group">
      <label for="weight-form">Weight (kg):</label>
      <input type="number" id="weight-form" name="weight" step="0.1" min="20" max="300" required>
    </div>
    
    <div class="form-group">
      <label for="chest-form">Chest/Bust (cm):</label>
      <input type="number" id="chest-form" name="chest" step="0.1" min="30" max="200">
    </div>
    
    <div class="form-group">
      <label for="waist-form">Waist (cm):</label>
      <input type="number" id="waist-form" name="waist" step="0.1" min="30" max="200">
    </div>
    
    <div class="form-group">
      <label for="hips-form">Hips (cm):</label>
      <input type="number" id="hips-form" name="hips" step="0.1" min="30" max="200">
    </div>
    
    <div class="form-group">
      <label for="thigh">Thigh (cm):</label>
      <input type="number" id="thigh" name="thigh" step="0.1" min="20" max="100">
    </div>
    
    <div class="form-group">
      <label for="bicep">Bicep (cm):</label>
      <input type="number" id="bicep" name="bicep" step="0.1" min="10" max="70">
    </div>
    
    <div class="form-group">
      <label for="neck">Neck (cm):</label>
      <input type="number" id="neck" name="neck" step="0.1" min="20" max="70">
    </div>
    
    <div class="form-group">
      <label for="date">Measurement Date:</label>
      <input type="date" id="date" name="date" required>
    </div>
    
    <div class="form-group">
      <button type="submit" id="submitBtn">Save Measurements</button>
      <button type="reset" class="reset-btn">Reset Form</button>
    </div>
  </form>
  
  <div id="message"></div>
</div>

<!-- Script to initialize form with today's date -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Set today's date as default for the date input
    const today = new Date();
    const formattedDate = today.toISOString().substr(0, 10);
    document.getElementById('date').value = formattedDate;
    
    // Handle form submission with AJAX
    const form = document.getElementById('measurementForm');
    const messageDiv = document.getElementById('message');
    
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Show loading state
      const submitBtn = document.getElementById('submitBtn');
      submitBtn.disabled = true;
      submitBtn.textContent = 'Saving...';
      
      // Collect form data
      const formData = new FormData(form);
      
      // Send AJAX request
      fetch('save_measurements.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Show success message and redirect after 2 seconds
          messageDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
          setTimeout(() => {
            window.location.href = 'index.php';
          }, 2000);
        } else {
          // Show error message
          messageDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
          submitBtn.disabled = false;
          submitBtn.textContent = 'Save Measurements';
        }
      })
      .catch(error => {
        messageDiv.innerHTML = `<div class="alert alert-danger">An error occurred: ${error.message}</div>`;
        submitBtn.disabled = false;
        submitBtn.textContent = 'Save Measurements';
      });
    });
  });
</script>

<?php include 'footer.php'; ?>