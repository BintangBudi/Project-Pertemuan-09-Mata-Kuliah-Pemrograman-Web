document.addEventListener('DOMContentLoaded', function() {
    const daySelect = document.querySelector('select[name="day"]');
    const yearSelect = document.querySelector('select[name="year"]');
    const registrationForm = document.getElementById('registrationForm');

    // Populate days
    for (let i = 1; i <= 31; i++) {
        const option = document.createElement('option');
        option.value = i;
        option.textContent = i;
        daySelect.appendChild(option);
    }

    // Populate years
    const currentYear = new Date().getFullYear();
    for (let i = currentYear; i >= 1905; i--) {
        const option = document.createElement('option');
        option.value = i;
        option.textContent = i;
        yearSelect.appendChild(option);
    }
    
    // Set default selections
    daySelect.value = new Date().getDate();
    yearSelect.value = currentYear - 18; // Default to 18 years ago

    // Basic Form Validation
    registrationForm.addEventListener('submit', function(event) {
        const password = document.getElementById('password').value;
        const inputs = registrationForm.querySelectorAll('input[required], select[required]');
        let isValid = true;

        inputs.forEach(input => {
            if (!input.value) {
                input.style.borderColor = 'red';
                isValid = false;
            } else {
                input.style.borderColor = '#dddfe2';
            }
        });

        if (password.length < 6) {
            alert('Password must be at least 6 characters long.');
            document.getElementById('password').style.borderColor = 'red';
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault(); // Stop form submission
            alert('Please fill in all required fields.');
        }
    });
});