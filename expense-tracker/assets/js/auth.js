// ========== Authentication Handler ==========

document.addEventListener('DOMContentLoaded', () => {
    const registerForm = document.getElementById('registerForm');
    const loginForm    = document.getElementById('loginForm');

    if (registerForm) {
        setupPasswordToggles();
        setupPasswordStrength();
        setupRealTimeValidation();
        registerForm.addEventListener('submit', handleRegister);
    }

    if (loginForm) {
        setupPasswordToggles();
        loginForm.addEventListener('submit', handleLogin);
    }
});

function getBackendBaseUrl() {
    const { protocol, origin, pathname } = window.location;

    if (protocol === 'file:') {
        return 'http://localhost/expense-tracker/backend/';
    }

    const match = pathname.match(/^(.*\/expense-tracker)\//);
    if (match) {
        return `${origin}${match[1].replace(/^\//, '/')}/backend/`;
    }

    return `${origin}/backend/`;
}

function backendUrl(endpoint) {
    return getBackendBaseUrl() + endpoint.replace(/^\/+/, '');
}

// =====================
// Show / Hide Password
// =====================
function setupPasswordToggles() {
    document.querySelectorAll('.toggle-password').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const wrapper = btn.closest('.input-wrapper');
            if (!wrapper) return;
            const input = wrapper.querySelector('input');
            const icon  = btn.querySelector('i');
            if (!input || !icon) return;

            const willShow = input.type === 'password';
            input.type     = willShow ? 'text' : 'password';
            // Replace className entirely — no risk of stale classes
            icon.className = willShow ? 'fas fa-eye-slash' : 'fas fa-eye';
            input.focus();
        });
    });
}

// =====================
// Password Strength
// =====================
const REQUIREMENTS = [
    { id: 'req-length',  test: p => p.length >= 8,                    label: 'At least 8 characters'          },
    { id: 'req-upper',   test: p => /[A-Z]/.test(p),                  label: 'One uppercase letter'            },
    { id: 'req-lower',   test: p => /[a-z]/.test(p),                  label: 'One lowercase letter'            },
    { id: 'req-number',  test: p => /[0-9]/.test(p),                  label: 'One number'                      },
    { id: 'req-special', test: p => /[^A-Za-z0-9]/.test(p),           label: 'One special character'           },
];

function setupPasswordStrength() {
    const passwordInput = document.getElementById('password');
    if (!passwordInput) return;

    const strengthContainer = document.getElementById('passwordStrength');
    const strengthFill      = document.getElementById('strengthFill');
    const strengthLabel     = document.getElementById('strengthLabel');

    passwordInput.addEventListener('input', () => {
        const val   = passwordInput.value;
        const score = REQUIREMENTS.filter(r => r.test(val)).length;

        // Show meter once user starts typing
        if (val.length > 0) {
            strengthContainer.hidden = false;
        } else {
            strengthContainer.hidden = true;
        }

        // Update requirement checklist
        REQUIREMENTS.forEach(r => {
            const li = document.getElementById(r.id);
            if (!li) return;
            const met = r.test(val);
            li.classList.toggle('met', met);
            const icon = li.querySelector('i');
            icon.className = met ? 'fas fa-check-circle' : 'fas fa-circle';
        });

        // Strength bar
        const pct = (score / REQUIREMENTS.length) * 100;
        strengthFill.style.width = pct + '%';

        const levels = [
            { min: 0, color: '#ef4444', label: 'Too weak'  },
            { min: 1, color: '#f59e0b', label: 'Weak'      },
            { min: 2, color: '#f59e0b', label: 'Fair'      },
            { min: 3, color: '#3b82f6', label: 'Good'      },
            { min: 4, color: '#10b981', label: 'Strong'    },
            { min: 5, color: '#059669', label: 'Very strong'},
        ];
        const level = levels.filter(l => score >= l.min).pop();
        strengthFill.style.backgroundColor = level.color;
        strengthLabel.textContent          = level.label;
        strengthLabel.style.color          = level.color;
    });
}

// =====================
// Real-time Validation
// =====================
function setupRealTimeValidation() {
    const fields = ['full_name', 'username', 'email', 'password', 'confirm_password'];
    fields.forEach(name => {
        const el = document.getElementById(name);
        if (el) {
            el.addEventListener('blur', () => validateField(el));
            el.addEventListener('input', () => {
                const wrapper = el.closest('.input-wrapper');
                if (wrapper && wrapper.classList.contains('input-error')) {
                    validateField(el);
                }
                // Live confirm password check
                if (name === 'password' || name === 'confirm_password') {
                    const confirm = document.getElementById('confirm_password');
                    if (confirm && confirm.value) validateField(confirm);
                }
            });
        }
    });
}

function validateField(input) {
    const name  = input.id;
    const value = input.value.trim();
    let error   = '';

    if (name === 'full_name') {
        if (!value) error = 'Full name is required.';
        else if (value.length < 2) error = 'Name must be at least 2 characters.';
        else if (value.length > 100) error = 'Name is too long.';
    } else if (name === 'username') {
        if (!value) error = 'Username is required.';
        else if (value.length < 3) error = 'Username must be at least 3 characters.';
        else if (value.length > 30) error = 'Username cannot exceed 30 characters.';
        else if (!/^[a-zA-Z0-9_]+$/.test(value)) error = 'Only letters, numbers, and underscores allowed.';
    } else if (name === 'email') {
        if (!value) error = 'Email address is required.';
        else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) error = 'Please enter a valid email address.';
    } else if (name === 'password') {
        if (!value) error = 'Password is required.';
        else if (value.length < 8) error = 'Password must be at least 8 characters.';
        else if (!validatePasswordComplexity(value)) error = 'Password does not meet all requirements.';
    } else if (name === 'confirm_password') {
        const pwd = document.getElementById('password');
        if (!value) error = 'Please confirm your password.';
        else if (pwd && value !== pwd.value) error = 'Passwords do not match.';
    }

    showFieldError(name, error);
    markInputState(input, error === '');
    return error === '';
}

function validatePasswordComplexity(pwd) {
    return REQUIREMENTS.every(r => r.test(pwd));
}

function showFieldError(fieldId, message) {
    const errorMap = {
        'full_name':        'fullNameError',
        'username':         'usernameError',
        'email':            'emailError',
        'password':         'passwordError',
        'confirm_password': 'confirmPasswordError',
    };
    const errEl = document.getElementById(errorMap[fieldId]);
    if (!errEl) return;
    errEl.textContent = message;
    errEl.classList.toggle('visible', !!message);
}

function markInputState(input, isValid) {
    // Apply state classes to the wrapper (which owns the border), not the input
    const target = input.closest('.input-wrapper') || input;
    target.classList.toggle('input-error',   !isValid);
    target.classList.toggle('input-success',  isValid && input.value.trim() !== '');
}

function clearFieldError(fieldId) {
    showFieldError(fieldId, '');
    const el = document.getElementById(fieldId);
    if (el) {
        const target = el.closest('.input-wrapper') || el;
        target.classList.remove('input-error', 'input-success');
    }
}

// =====================
// Submit button loading
// =====================
function setButtonLoading(btnId, isLoading) {
    const btn     = document.getElementById(btnId);
    if (!btn) return;
    const text    = btn.querySelector('.btn-text');
    const spinner = btn.querySelector('.btn-spinner');
    btn.disabled  = isLoading;
    if (text)    text.hidden    = isLoading;
    if (spinner) spinner.hidden = !isLoading;
}

// =====================
// Show form-level message
// =====================
function showMessage(type, text) {
    const div = document.getElementById('message');
    if (!div) return;
    div.className = 'message ' + type;
    div.textContent = text;
    div.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function hideMessage() {
    const div = document.getElementById('message');
    if (div) { div.className = 'message'; div.textContent = ''; }
}

// =====================
// Register Handler
// =====================
async function handleRegister(e) {
    e.preventDefault();
    hideMessage();

    // Full client-side validation pass
    const fields = ['full_name', 'username', 'email', 'password', 'confirm_password'];
    let allValid = fields.every(name => {
        const el = document.getElementById(name);
        return el ? validateField(el) : true;
    });

    // Terms checkbox
    const terms    = document.getElementById('terms');
    const termsErr = document.getElementById('termsError');
    if (terms && !terms.checked) {
        if (termsErr) { termsErr.textContent = 'You must agree to the Terms of Service.'; termsErr.classList.add('visible'); }
        allValid = false;
    } else if (termsErr) {
        termsErr.textContent = '';
        termsErr.classList.remove('visible');
    }

    if (!allValid) return;

    setButtonLoading('registerBtn', true);

    try {
        const formData = new FormData(document.getElementById('registerForm'));

        const response = await fetch(backendUrl('register.php'), {
            method:  'POST',
            body:    formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'include',
        });

        // Always try to parse JSON — even on 4xx/5xx the server returns JSON
        let data;
        try {
            data = await response.json();
        } catch {
            throw new Error('The server returned an unexpected response. Please try again.');
        }

        if (data.success) {
            showMessage('success', data.message || 'Account created! Redirecting to login…');
            document.getElementById('registerForm').reset();
            // Clear validation state from wrappers (not inputs)
            document.querySelectorAll('.input-wrapper').forEach(w => w.classList.remove('input-success', 'input-error'));
            const strengthEl = document.getElementById('passwordStrength');
            if (strengthEl) strengthEl.hidden = true;
            setTimeout(() => { window.location.href = 'login.html'; }, 2000);
        } else {
            showMessage('error', data.message || 'Registration failed. Please try again.');
        }
    } catch (err) {
        const serverHint = `Open this page via http://localhost/expense-tracker/ (not file://).`;
        showMessage('error', `${err.message || 'Failed to fetch'} ${serverHint}`);
    } finally {
        setButtonLoading('registerBtn', false);
    }
}

// =====================
// Login Handler
// =====================
async function handleLogin(e) {
    e.preventDefault();
    hideMessage();

    const emailEl = document.getElementById('email');
    const passEl  = document.getElementById('password');
    let valid = true;

    if (!emailEl.value.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailEl.value.trim())) {
        showFieldError('email', 'Please enter a valid email address.');
        markInputState(emailEl, false);
        valid = false;
    } else {
        showFieldError('email', '');
        markInputState(emailEl, true);
    }

    if (!passEl.value) {
        showFieldError('password', 'Password is required.');
        markInputState(passEl, false);
        valid = false;
    } else {
        showFieldError('password', '');
        markInputState(passEl, true);
    }

    if (!valid) return;

    setButtonLoading('loginBtn', true);

    try {
        const formData = new FormData(document.getElementById('loginForm'));

        const response = await fetch(backendUrl('login.php'), {
            method:  'POST',
            body:    formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'include',
        });

        // Always parse JSON regardless of HTTP status
        let data;
        try {
            data = await response.json();
        } catch {
            throw new Error('The server returned an unexpected response. Please try again.');
        }

        if (data.success) {
            showMessage('success', data.message || 'Login successful! Redirecting…');
            setTimeout(() => { window.location.href = data.redirect || 'dashboard.html'; }, 1000);
        } else {
            showMessage('error', data.message || 'Invalid credentials. Please try again.');
            passEl.value = '';
            markInputState(passEl, false);
        }
    } catch (err) {
        const serverHint = `Open this page via http://localhost/expense-tracker/ (not file://).`;
        showMessage('error', `${err.message || 'Failed to fetch'} ${serverHint}`);
    } finally {
        setButtonLoading('loginBtn', false);
    }
}

