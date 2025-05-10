
let isMale = false;
let isMetric = false;

// SVG Templates
const femaleSvgTemplate = `
  <svg viewBox="0 0 200 500" xmlns="http://www.w3.org/2000/svg">
    <!-- Head -->
    <circle class="human-body female-body" cx="100" cy="40" r="30" />
    
    <!-- Neck -->
    <path class="human-body female-body" d="M90,65 Q100,75 110,65 L110,80 Q100,85 90,80 Z" />
    
    <!-- Torso -->
    <path id="female-torso" class="human-body female-body" d="
      M85,80 
      C60,120 60,130 75,160 
      L75,240 
      C60,270 60,280 85,300 
      L115,300 
      C140,280 140,270 125,240 
      L125,160 
      C140,130 140,120 115,80 
      Z" />
    
    <!-- Arms -->
    <path id="left-arm" class="human-body female-body" d="
      M75,100 
      C50,110 40,140 45,180 
      Q50,185 55,180 
      C55,145 60,120 75,105 
      Z" />
      
    <path id="right-arm" class="human-body female-body" d="
      M125,100 
      C150,110 160,140 155,180 
      Q150,185 145,180 
      C145,145 140,120 125,105 
      Z" />
    
    <!-- Legs -->
    <path id="left-leg" class="human-body female-body" d="
      M85,300 
      Q80,380 75,460 
      Q85,465 90,460 
      Q90,380 95,300 
      Z" />
      
    <path id="right-leg" class="human-body female-body" d="
      M115,300 
      Q120,380 125,460 
      Q115,465 110,460 
      Q110,380 105,300 
      Z" />
  </svg>
`;

const maleSvgTemplate = `
  <svg viewBox="0 0 200 500" xmlns="http://www.w3.org/2000/svg">
    <!-- Head -->
    <circle class="human-body male-body" cx="100" cy="40" r="30" />
    
    <!-- Neck -->
    <path class="human-body male-body" d="M88,65 Q100,75 112,65 L112,85 Q100,90 88,85 Z" />
    
    <!-- Torso -->
    <path id="male-torso" class="human-body male-body" d="
      M80,85 
      C50,120 55,150 70,190 
      L70,240 
      C55,260 60,280 80,300 
      L120,300 
      C140,280 145,260 130,240 
      L130,190 
      C145,150 150,120 120,85 
      Z" />
    
    <!-- Arms -->
    <path id="left-arm-male" class="human-body male-body" d="
      M70,110 
      C40,120 30,150 35,200 
      Q45,205 50,200 
      C50,155 55,130 70,115 
      Z" />
      
    <path id="right-arm-male" class="human-body male-body" d="
      M130,110 
      C160,120 170,150 165,200 
      Q155,205 150,200 
      C150,155 145,130 130,115 
      Z" />
    
    <!-- Legs -->
    <path id="left-leg-male" class="human-body male-body" d="
      M80,300 
      Q75,380 70,460 
      Q82,465 90,460 
      Q88,380 90,300 
      Z" />
      
    <path id="right-leg-male" class="human-body male-body" d="
      M120,300 
      Q125,380 130,460 
      Q118,465 110,460 
      Q112,380 110,300 
      Z" />
  </svg>
`;

// Initialize with female SVG
document.getElementById('human-figure').innerHTML = femaleSvgTemplate;

// Function to toggle between male and female
function toggleGender() {
  isMale = !isMale;
  
  if (isMale) {
    document.getElementById('title').textContent = 'Male Body Visualizer';
    document.getElementById('gender-switch').innerHTML = '(<a href="#" onclick="toggleGender(); return false;">switch to female</a>)';
    document.getElementById('human-figure').innerHTML = maleSvgTemplate;
    
    // Update default values for male
    if (!isMetric) {
      document.getElementById('weight').value = 180;
      document.getElementById('weight-slider').value = 180;
      document.getElementById('chest').value = 40;
      document.getElementById('chest-slider').value = 40;
      document.getElementById('waist').value = 34;
      document.getElementById('waist-slider').value = 34;
      document.getElementById('hips').value = 38;
      document.getElementById('hips-slider').value = 38;
    } else {
      // Set metric values
      document.getElementById('weight').value = 82;
      document.getElementById('weight-slider').value = 82;
      document.getElementById('chest').value = 102;
      document.getElementById('chest-slider').value = 102;
      document.getElementById('waist').value = 86;
      document.getElementById('waist-slider').value = 86;
      document.getElementById('hips').value = 97;
      document.getElementById('hips-slider').value = 97;
    }
  } else {
    document.getElementById('title').textContent = 'Female Body Visualizer';
    document.getElementById('gender-switch').innerHTML = '(<a href="#" onclick="toggleGender(); return false;">switch to male</a>)';
    document.getElementById('human-figure').innerHTML = femaleSvgTemplate;
    
    // Update default values for female
    if (!isMetric) {
      document.getElementById('weight').value = 141;
      document.getElementById('weight-slider').value = 141;
      document.getElementById('chest').value = 37;
      document.getElementById('chest-slider').value = 37;
      document.getElementById('waist').value = 30;
      document.getElementById('waist-slider').value = 30;
      document.getElementById('hips').value = 40;
      document.getElementById('hips-slider').value = 40;
    } else {
      // Set metric values
      document.getElementById('weight').value = 64;
      document.getElementById('weight-slider').value = 64;
      document.getElementById('chest').value = 94;
      document.getElementById('chest-slider').value = 94;
      document.getElementById('waist').value = 76;
      document.getElementById('waist-slider').value = 76;
      document.getElementById('hips').value = 102;
      document.getElementById('hips-slider').value = 102;
    }
  }
  
  updateVisualizer();
}

// Function to sync the slider with the input field
function syncInput(id) {
  const slider = document.getElementById(`${id}-slider`);
  const input = document.getElementById(id);
  input.value = slider.value;
  updateVisualizer();
}

// Function to update the visualizer based on inputs
function updateVisualizer() {
  const height = parseFloat(document.getElementById('height').value);
  const weight = parseFloat(document.getElementById('weight').value);
  const chest = parseFloat(document.getElementById('chest').value);
  const waist = parseFloat(document.getElementById('waist').value);
  const hips = parseFloat(document.getElementById('hips').value);
  const exercise = parseFloat(document.getElementById('exercise').value);
  
  // Calculate relative sizes for visualization
  const heightFactor = height / 65; // Base height is 65 inches
  const weightFactor = weight / (isMale ? 180 : 141); // Base weight
  const chestFactor = chest / (isMale ? 40 : 37);
  const waistFactor = waist / (isMale ? 34 : 30);
  const hipsFactor = hips / (isMale ? 38 : 40);
  
  // Scale the SVG based on height
  const svg = document.querySelector('svg');
  svg.style.height = `${500 * heightFactor}px`;
  
  // Update body thickness based on weight
  const bodyParts = document.querySelectorAll('.human-body');
  const scaleX = 0.8 + (weightFactor * 0.4);
  
  bodyParts.forEach(part => {
    // We'll apply transformations to each body part
    if (part.tagName === 'circle') { // For the head
      part.setAttribute('r', 30 * Math.sqrt(weightFactor));
    } else {
      // For paths, we'll use a transform
      const currentTransform = part.getAttribute('transform') || '';
      
      // If chest or waist specific, use those factors
      if (part.id === 'female-torso' || part.id === 'male-torso') {
        const upperScale = chestFactor * 0.8 + 0.2;
        const middleScale = waistFactor * 0.8 + 0.2;
        const lowerScale = hipsFactor * 0.8 + 0.2;
        
        // Complex transform to handle different body areas
        part.setAttribute('transform', `scale(${upperScale} 1) translate(${100 - 100 * upperScale} 0)`);
      } else if (part.id.includes('arm')) {
        // Arms scale based on exercise and weight
        const armScale = (0.7 + (weightFactor * 0.3)) * (1 + exercise/20);
        part.setAttribute('transform', `scale(${armScale} 1) translate(${part.id.includes('left') ? (100 - 100 * armScale) : (100 - 100 * armScale)} 0)`);
      } else if (part.id.includes('leg')) {
        // Legs scale based on weight and hip size
        const legScale = (0.7 + (weightFactor * 0.3)) * (hipsFactor * 0.5 + 0.5);
        part.setAttribute('transform', `scale(${legScale} 1) translate(${part.id.includes('left') ? (100 - 100 * legScale) : (100 - 100 * legScale)} 0)`);
      }
    }
  });
  
  // Adjust color based on exercise level
  const exerciseFactor = exercise / 7; // 7 hours a week as baseline
  const baseTone = 172; // Base blue tone
  const baseColor = 123; // Base color saturation
  
  // More exercise = more muscle tone (deeper blue)
  const colorTone = Math.max(120, Math.min(200, baseTone - exerciseFactor * 30));
  const colorSat = Math.max(100, Math.min(150, baseColor + exerciseFactor * 20));
  
  const bodyColor = `rgb(${colorTone - 50}, ${colorTone}, ${colorSat + 100})`;
  const borderColor = `rgb(${colorTone - 70}, ${colorTone - 20}, ${colorSat + 80})`;
  
  document.querySelectorAll('.human-body').forEach(part => {
    part.style.fill = bodyColor;
    part.style.stroke = borderColor;
  });
}

// Function to switch between metric and imperial units
function switchUnits() {
  isMetric = !isMetric;
  
  if (isMetric) {
    // Convert to metric
    const height = parseInt(document.getElementById('height').value);
    const weight = parseInt(document.getElementById('weight').value);
    const chest = parseInt(document.getElementById('chest').value);
    const waist = parseInt(document.getElementById('waist').value);
    const hips = parseInt(document.getElementById('hips').value);
    const inseam = parseInt(document.getElementById('inseam').value);
    
    // Convert inches to cm
    document.getElementById('height').value = Math.round(height * 2.54);
    document.getElementById('height-slider').value = Math.round(height * 2.54);
    document.getElementById('height-slider').min = "120";
    document.getElementById('height-slider').max = "215";
    document.getElementById('height').min = "120";
    document.getElementById('height').max = "215";
    
    // Convert pounds to kg
    document.getElementById('weight').value = Math.round(weight * 0.453592);
    document.getElementById('weight-slider').value = Math.round(weight * 0.453592);
    document.getElementById('weight-slider').min = "36";
    document.getElementById('weight-slider').max = "136";
    document.getElementById('weight').min = "36";
    document.getElementById('weight').max = "136";
    
    // Convert inches to cm for measurements
    document.getElementById('chest').value = Math.round(chest * 2.54);
    document.getElementById('chest-slider').value = Math.round(chest * 2.54);
    document.getElementById('chest-slider').min = "64";
    document.getElementById('chest-slider').max = "127";
    document.getElementById('chest').min = "64";
    document.getElementById('chest').max = "127";
    
    document.getElementById('waist').value = Math.round(waist * 2.54);
    document.getElementById('waist-slider').value = Math.round(waist * 2.54);
    document.getElementById('waist-slider').min = "51";
    document.getElementById('waist-slider').max = "127";
    document.getElementById('waist').min = "51";
    document.getElementById('waist').max = "127";
    
    document.getElementById('hips').value = Math.round(hips * 2.54);
    document.getElementById('hips-slider').value = Math.round(hips * 2.54);
    document.getElementById('hips-slider').min = "64";
    document.getElementById('hips-slider').max = "152";
    document.getElementById('hips').min = "64";
    document.getElementById('hips').max = "152";
    
    document.getElementById('inseam').value = Math.round(inseam * 2.54);
    document.getElementById('inseam-slider').value = Math.round(inseam * 2.54);
    document.getElementById('inseam-slider').min = "51";
    document.getElementById('inseam-slider').max = "102";
    document.getElementById('inseam').min = "51";
    document.getElementById('inseam').max = "102";
    
    // Update unit labels
    document.querySelectorAll('.unit').forEach((el, i) => {
      if (i === 1) { // Weight
        el.textContent = "kg";
      } else if (i < 6) { // Height and other measurements
        el.textContent = "cm";
      }
    });
  } else {
    // Convert to imperial
    const height = parseInt(document.getElementById('height').value);
    const weight = parseInt(document.getElementById('weight').value);
    const chest = parseInt(document.getElementById('chest').value);
    const waist = parseInt(document.getElementById('waist').value);
    const hips = parseInt(document.getElementById('hips').value);
    const inseam = parseInt(document.getElementById('inseam').value);
    
    // Convert cm to inches
    document.getElementById('height').value = Math.round(height / 2.54);
    document.getElementById('height-slider').value = Math.round(height / 2.54);
    document.getElementById('height-slider').min = "48";
    document.getElementById('height-slider').max = "84";
    document.getElementById('height').min = "48";
    document.getElementById('height').max = "84";
    
    // Convert kg to pounds
    document.getElementById('weight').value = Math.round(weight / 0.453592);
    document.getElementById('weight-slider').value = Math.round(weight / 0.453592);
    document.getElementById('weight-slider').min = "80";
    document.getElementById('weight-slider').max = "300";
    document.getElementById('weight').min = "80";
    document.getElementById('weight').max = "300";
    
    // Convert cm to inches for measurements
    document.getElementById('chest').value = Math.round(chest / 2.54);
    document.getElementById('chest-slider').value = Math.round(chest / 2.54);
    document.getElementById('chest-slider').min = "25";
    document.getElementById('chest-slider').max = "50";
    document.getElementById('chest').min = "25";
    document.getElementById('chest').max = "50";
    
    document.getElementById('waist').value = Math.round(waist / 2.54);
    document.getElementById('waist-slider').value = Math.round(waist / 2.54);
    document.getElementById('waist-slider').min = "20";
    document.getElementById('waist-slider').max = "50";
    document.getElementById('waist').min = "20";
    document.getElementById('waist').max = "50";
    
    document.getElementById('hips').value = Math.round(hips / 2.54);
    document.getElementById('hips-slider').value = Math.round(hips / 2.54);
    document.getElementById('hips-slider').min = "25";
    document.getElementById('hips-slider').max = "60";
    document.getElementById('hips').min = "25";
    document.getElementById('hips').max = "60";
    
    document.getElementById('inseam').value = Math.round(inseam / 2.54);
    document.getElementById('inseam-slider').value = Math.round(inseam / 2.54);
    document.getElementById('inseam-slider').min = "20";
    document.getElementById('inseam-slider').max = "40";
    document.getElementById('inseam').min = "20";
    document.getElementById('inseam').max = "40";
    
    // Update unit labels
    document.querySelectorAll('.unit').forEach((el, i) => {
      if (i === 1) { // Weight
        el.textContent = "pounds";
      } else if (i < 6) { // Height and other measurements
        el.textContent = "inches";
      }
    });
  }
  
  updateVisualizer();
}

// Function to show information about measurements
function showInfo(measurement) {
  let message = "";
  
  switch(measurement) {
    case 'height':
      message = "Height is measured from the top of your head to the bottom of your feet.";
      break;
    case 'weight':
      message = "Weight is your total body weight.";
      break;
    case 'chest':
      message = "Chest measurement is taken at the fullest part of your chest/bust.";
      break;
    case 'waist':
      message = "Waist measurement is taken at the narrowest part of your natural waist.";
      break;
    case 'hips':
      message = "Hip measurement is taken at the fullest part of your hips.";
      break;
    case 'inseam':
      message = "Inseam is the distance from your crotch to the bottom of your leg.";
      break;
    case 'exercise':
      message = "Exercise is the average number of hours per week you spend doing physical activity.";
      break;
  }
  
  alert(message);
}

// Initialize the visualizer when the page loads
window.onload = function() {
  updateVisualizer();

  document.addEventListener('DOMContentLoaded', function() {
    // Set default date to today
    document.getElementById('date').valueAsDate = new Date();
    
    // Form validation and submission
    const form = document.getElementById('measurementForm');
    const messageDiv = document.getElementById('message');
    
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        // Basic validation
        if (!validateForm()) {
            return;
        }
        
        // Form data to send
        const formData = new FormData(form);
        
        // Send data via AJAX
        fetch('save_measurements.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage('Measurements saved successfully!', 'success');
                form.reset();
                document.getElementById('date').valueAsDate = new Date();
            } else {
                showMessage('Error: ' + data.message, 'error');
            }
        })
        .catch(error => {
            showMessage('Error: Unable to save data. Please try again.', 'error');
            console.error('Error:', error);
        });
    });
    
    function validateForm() {
        let isValid = true;
        
        // Clear previous error messages
        messageDiv.classList.remove('error');
        messageDiv.style.display = 'none';
        
        // Required fields validation
        const requiredFields = form.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.style.borderColor = '#e74c3c';
            } else {
                field.style.borderColor = '#ddd';
            }
        });
        
        // Number validation
        const numberFields = form.querySelectorAll('input[type="number"]');
        numberFields.forEach(field => {
            if (field.value && (isNaN(field.value) || 
                parseFloat(field.value) < parseFloat(field.min) || 
                parseFloat(field.value) > parseFloat(field.max))) {
                isValid = false;
                field.style.borderColor = '#e74c3c';
            }
        });
        
        if (!isValid) {
            showMessage('Please fill in all required fields correctly.', 'error');
        }
        
        return isValid;
    }
    
    function showMessage(message, type) {
        messageDiv.textContent = message;
        messageDiv.className = '';
        messageDiv.classList.add(type);
        messageDiv.style.display = 'block';
        
        // Scroll to message
        messageDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    
    // Reset form styling on input
    form.querySelectorAll('input, select').forEach(input => {
        input.addEventListener('input', function() {
            this.style.borderColor = '#ddd';
        });
    });
});


document.getElementById("messuerForm").addEventListener("submit", function(e) {
  e.preventDefault(); // prevent default form submission

  const formData = new FormData(this);

  fetch("save_measurements.php", {
      method: "POST",
      body: formData
  })
  .then(res => res.json())
  .then(data => {
      if (data.success) {
          alert(data.message);
          window.location.href = "view_measurements.php"; // Redirect here
      } else {
          alert("Error: " + data.message);
      }
  })
  .catch(err => {
      console.error("Fetch error:", err);
      alert("Something went wrong.");
  });
});
};
