function checkPasswordStrength(password) {
  const progressBar = document.getElementById('progressBar');
  const passwordStrengthText = document.getElementById('passwordStrength');
  const passwordStrengthIcon = document.getElementById('strengthIcon');
  const strength = calculatePasswordStrength(password);

  // Set the width of the progress bar based on the password strength
  progressBar.style.width = strength + '%';

  // Set the password strength text based on the strength level
  if (strength < 33) {
    passwordStrengthText.textContent = 'Weak';
    passwordStrengthText.style.color = '#ff4d4d';
    progressBar.className = 'weak';
    passwordStrengthIcon.className = 'fa fa-exclamation-circle my-1 mx-1 text-danger';
  } else if (strength < 66) {
    passwordStrengthText.textContent = 'Medium';
    passwordStrengthText.style.color = '#ffad4d';
    passwordStrengthIcon.className = 'fa fa-sliders my-1 mx-1 text-warning';
    progressBar.className = 'medium';
  } else {
    passwordStrengthText.textContent = 'Strong';
    passwordStrengthText.style.color = '#4dff4d'
    progressBar.className = 'strong';
    passwordStrengthIcon.className = 'fa fa-check-circle my-1 mx-1 text-success';
  }
}

function calculatePasswordStrength(password) {
  let strength = 0;

  // Length of the password
  if (password.length >= 8) {
    strength += 15;
  }

  // Check for uppercase letters
  if (/[A-Z]/.test(password)) {
    strength += 15;
  }

  // Check for lowercase letters
  if (/[a-z]/.test(password)) {
    strength += 10;
  }

  // Check for numbers
  if (/[0-9]/.test(password)) {
    strength += 15;
  }

  // Check for special characters
  if (/[^A-Za-z0-9]/.test(password)) {
    strength += 10;
  }

  // Complexity check (additional criteria, such as a mix of character types)
  if (/[A-Za-z0-9]{8,}/.test(password)) {
    strength += 15;
  }

  return strength;
}


