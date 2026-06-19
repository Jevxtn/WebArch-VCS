# Changelog

All notable changes to this project are documented here.

## [2026-06-19] Documentation Refresh

### Updated
- README.md
- SETUP.md
- QUICK_START.md
- USER_GUIDE.md
- DEVELOPER_GUIDE.md
- CHANGELOG.md

### Notes
- Removed outdated and duplicated content.
- Aligned docs with current backend endpoints and validation rules.
- Corrected session/auth behavior details.
- Documented current filter support and upload constraints.

## [2026-06-18] Backend and Auth Hardening

### Security and Stability
- register.php rewritten to resolve malformed response corruption.
- login.php hardened with safer error handling.
- logout.php updated for full session cleanup.
- get_expenses.php custom date input validation improved.
- add_expense.php no longer exposes raw DB errors.
- config.php hardened session and error handling defaults.

### Authentication
- Strong password policy enforced on frontend and backend.
- Generic login failure messages to reduce user enumeration.
- Session fixation mitigation via session_regenerate_id(true).
- Session-based lockout after repeated failed login attempts.

### Frontend UX
- Auth form validation and password strength experience improved.
- Mobile navigation behavior corrected.

## [2026-06-18] Landing Page Redesign

### UI Changes
- Homepage structure and section layout redesigned.
- Navbar/header alignment and responsive behavior improved.
- Added richer hero, feature, stats, and footer presentation.
