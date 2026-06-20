# Build and Deploy Guide

This document provides step-by-step instructions for building and deploying each website in this repository.

---

## 1) Prerequisites

Before building/deploying, ensure the following are installed:

- A web server environment (e.g., Apache/Nginx)
- PHP runtime compatible with this project
- Node.js and npm (if frontend tooling is used)
- Git
- Access to deployment target (shared hosting, VPS, cloud VM, or container platform)

Also prepare:

- `.env` or server environment variables for secrets/config
- SSL certificate for HTTPS in production
- Domain/DNS configuration if applicable

---

## 2) Source Code Retrieval

1. Clone repository:

   ```bash
   git clone https://github.com/Jevxtn/WebArch-VCS.git
   cd WebArch-VCS
   ```

2. Checkout target revision/branch for release:

   ```bash
   git checkout <release-branch-or-tag>
   ```

---

## 3) Build Steps (Per Website)

> If this repository contains multiple website folders, repeat these steps per site directory.

1. Navigate to website directory:

   ```bash
   cd <website-directory>
   ```

2. Install dependencies (if `package.json` exists):

   ```bash
   npm install
   ```

3. Build static assets (if scripts are configured):

   ```bash
   npm run build
   ```

4. Validate PHP pages and templates:

   ```bash
   php -l index.php
   ```

5. Run local server smoke test:

   - PHP built-in:

     ```bash
     php -S localhost:8000
     ```

   - Confirm pages load and key features work.

---

## 4) Deployment Steps (Per Website)

### Option A: Traditional Server (Apache/Nginx + PHP)

1. Create deployment directory on server (e.g., `/var/www/<site>`).
2. Upload source code or pull from Git.
3. Set environment variables and secure secrets.
4. Configure virtual host/server block:
   - Document root points to public entrypoint
   - Enable HTTPS redirection
   - Set PHP handler
5. Set file permissions for runtime/cache/uploads (least privilege).
6. Restart/reload services:

   ```bash
   sudo systemctl reload nginx
   sudo systemctl reload apache2
   ```

7. Run post-deploy smoke checks:
   - Home page loads
   - Forms/API calls work
   - No PHP runtime errors in logs

### Option B: Static Hosting (if site is static output)

1. Build project to output folder (e.g., `dist/` or `build/`).
2. Upload output folder to hosting provider.
3. Configure domain and HTTPS.
4. Verify cache headers and compression.

---

## 5) Verification Checklist After Deployment

- [ ] Website is reachable over HTTPS
- [ ] Core pages return HTTP 200
- [ ] Navigation and assets load correctly
- [ ] Forms/auth/session flows behave correctly
- [ ] Error pages (404/500) are handled gracefully
- [ ] Logs show no recurring critical errors

---

## 6) Rollback Procedure

1. Keep a versioned release/tag for each deployment.
2. If failure occurs:
   - Revert to previous known-good release
   - Reload web services
   - Re-run smoke tests
3. Document incident summary and root cause in deployment notes.

---

## 7) Recommended Documentation Per Website

For each website, maintain:

- Build command(s)
- Runtime requirements
- Deployment target and configuration
- Environment variables list (non-secret names only)
- Validation and rollback results
