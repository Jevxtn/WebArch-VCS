// ========== Authentication Handler ==========

document.addEventListener('DOMContentLoaded', () => {
    const registerForm = document.getElementById('registerForm');
    const loginForm = document.getElementById('loginForm');

    if (registerForm) {
        registerForm.addEventListener('submit', handleRegister);
        setDateToday();
    }

    if (loginForm) {
        loginForm.addEventListener('submit', handleLogin);
    }
});

function setDateToday() {
    const dateInput = document.getElementById('date');
    if (dateInput) {
        dateInput.valueAsDate = new Date();
    }
}

// Register Handler
async function handleRegister(e) {
    e.preventDefault();

    const formData = new FormData(document.getElementById('registerForm'));
    const messageDiv = document.getElementById('message');

    try {
        const response = await fetch('backend/register.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();
        messageDiv.classList.remove('success', 'error');

        if (data.success) {
            messageDiv.classList.add('success');
            messageDiv.textContent = data.message;
            document.getElementById('registerForm').reset();
            setTimeout(() => {
                window.location.href = 'login.html';
            }, 2000);
        } else {
            messageDiv.classList.add('error');
            messageDiv.textContent = data.message;
        }
    } catch (error) {
        console.error('Error:', error);
        messageDiv.classList.add('error');
        messageDiv.textContent = 'An error occurred. Please try again.';
    }
}

// Login Handler
async function handleLogin(e) {
    e.preventDefault();

    const formData = new FormData(document.getElementById('loginForm'));
    const messageDiv = document.getElementById('message');

    try {
        const response = await fetch('backend/login.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();
        messageDiv.classList.remove('success', 'error');

        if (data.success) {
            messageDiv.classList.add('success');
            messageDiv.textContent = data.message;
            localStorage.setItem('logged_in', 'true');
            setTimeout(() => {
                window.location.href = data.redirect;
            }, 1000);
        } else {
            messageDiv.classList.add('error');
            messageDiv.textContent = data.message;
        }
    } catch (error) {
        console.error('Error:', error);
        messageDiv.classList.add('error');
        messageDiv.textContent = 'An error occurred. Please try again.';
    }
}
