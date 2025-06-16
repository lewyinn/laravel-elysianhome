
// Form validation
document.addEventListener('DOMContentLoaded', function () {
    // Profile form validation
    const profileForm = document.getElementById('profileForm');
    profileForm.addEventListener('submit', function (e) {
        // e.preventDefault();
        let isValid = true;

        const username = document.getElementById('username');
        const email = document.getElementById('email');

        // Reset validation states
        [username, email].forEach(input => {
            input.classList.remove('is-invalid');
            input.nextElementSibling.style.display = 'none';
        });

        // Validate username
        if (!username.value.trim()) {
            username.classList.add('is-invalid');
            username.nextElementSibling.style.display = 'block';
            isValid = false;
        }

        // Validate email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email.value.trim() || !emailRegex.test(email.value)) {
            email.classList.add('is-invalid');
            email.nextElementSibling.style.display = 'block';
            isValid = false;
        }

        if (isValid) {
            // Simulate form submission (replace with actual submission logic)
            alert('Profile updated successfully!');
            // Example: profileForm.submit();
        }
    });

    // Password form validation
    const passwordForm = document.getElementById('passwordForm');
    passwordForm.addEventListener('submit', function (e) {
        e.preventDefault();
        let isValid = true;

        const currentPassword = document.getElementById('currentPassword');
        const newPassword = document.getElementById('newPassword');
        const confirmPassword = document.getElementById('confirmPassword');

        // Reset validation states
        [currentPassword, newPassword, confirmPassword].forEach(input => {
            input.classList.remove('is-invalid');
            input.nextElementSibling.style.display = 'none';
        });

        // Validate current password
        if (!currentPassword.value) {
            currentPassword.classList.add('is-invalid');
            currentPassword.nextElementSibling.style.display = 'block';
            isValid = false;
        }

        // Validate new password
        if (!newPassword.value) {
            newPassword.classList.add('is-invalid');
            newPassword.nextElementSibling.style.display = 'block';
            isValid = false;
        }

        // Validate confirm password
        if (newPassword.value !== confirmPassword.value) {
            confirmPassword.classList.add('is-invalid');
            confirmPassword.nextElementSibling.style.display = 'block';
            isValid = false;
        }

        if (isValid) {
            // Simulate form submission (replace with actual submission logic)
            alert('Password updated successfully!');
            // Example: passwordForm.submit();
        }
    });
});