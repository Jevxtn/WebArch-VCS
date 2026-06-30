# Docker Deployment Guide (Step by Step)

This guide documents the full Docker setup applied to this project, including the exact commands used and all code/config changes made.

## 1) Prerequisites

- Docker Desktop installed and running
- Docker Compose available (`docker compose`)
- Project cloned locally

## 2) Project Location Used

All commands were run from the repository root:

```bash
cd /c/Users/Windows/Documents/WebArch-VCS/WebArch-VCS
```

## 3) Files Added and Updated

### Added

- `Dockerfile`
- `docker-compose.yml`
- `.dockerignore`
- `.gitignore`

### Updated

- `expense-tracker/backend/config.php`
- `expense-tracker/README.md`

## 4) What Was Changed

### 4.1 Docker image for PHP/Apache

Created `Dockerfile` to:

- Use `php:8.2-apache`
- Enable Apache rewrite module
- Install required PHP/MySQL/ZIP dependencies
- Copy app files from `expense-tracker/` into Apache web root
- Ensure upload directory exists and has correct ownership

### 4.2 Multi-service stack with Docker Compose

Created `docker-compose.yml` with services:

- `web` (PHP + Apache)
  - Host port: `8080` -> container port `80`
  - DB environment variables passed to app
- `db` (MySQL 8.0)
  - Host port: `3307` -> container port `3306`
  - Persistent named volume: `db_data`
  - Healthcheck configured
- `phpmyadmin` (browser DB UI)
  - Host port: `8081` -> container port `80`
  - Connected to `db`

### 4.3 Backend DB configuration for Docker

Updated `expense-tracker/backend/config.php` to support env-based config with local fallbacks:

- `DB_HOST` from env or `localhost`
- `DB_USERNAME`/`DB_USER` from env or `root`
- `DB_PASSWORD`/`DB_PASS` from env or empty
- `DB_DATABASE`/`DB_NAME` from env or `expense_tracker`

This keeps local non-Docker behavior working while enabling containerized deployment.

### 4.4 Ignore files

- Added `.dockerignore` to reduce Docker build context
- Added `.gitignore` for common generated/local files

### 4.5 Documentation updates

Updated `expense-tracker/README.md` with:

- Docker startup/shutdown commands
- App URL (`http://localhost:8080`)
- phpMyAdmin URL (`http://localhost:8081`)
- phpMyAdmin login details

## 5) Step-by-Step Deployment Commands

### 5.1 Build and start full stack

```bash
docker compose up -d --build
```

### 5.2 Check running services

```bash
docker compose ps
```

Expected mapped ports:

- Web app: `8080`
- MySQL: `3307`
- phpMyAdmin: `8081`

### 5.3 Verify app endpoint

```bash
curl -I http://localhost:8080
```

Expected: `HTTP/1.1 200 OK`

### 5.4 Verify phpMyAdmin endpoint

```bash
curl -I http://localhost:8081
```

Expected: `HTTP/1.1 200 OK`

### 5.5 Access in browser

- App: `http://localhost:8080`
- phpMyAdmin: `http://localhost:8081`

phpMyAdmin login used:

- Server: `db`
- Username: `root`
- Password: `root`

## 6) Important Note About Port 3307

`3307` is MySQL TCP port for database clients, not an HTTP web page.

Use `3307` with tools such as MySQL Workbench or DBeaver, not a browser URL.

## 7) Stop and Cleanup Commands

### Stop containers

```bash
docker compose down
```

### Stop and remove DB volume (full reset)

```bash
docker compose down -v
```

## 8) Database Connection Values (App Container)

Configured in `docker-compose.yml` for `web` service:

- `DB_HOST=db`
- `DB_PORT=3306`
- `DB_DATABASE=expense_tracker`
- `DB_USERNAME=webarch_user`
- `DB_PASSWORD=webarch_pass`

## 9) Git History for This Docker Setup

The Docker deployment work and phpMyAdmin UI were committed and pushed with:

- `071a04b` - Add Docker deployment stack and env-based DB config
- `43a4226` - Add phpMyAdmin service for browser DB UI

---

If you want, this guide can also be linked from the main project README for faster onboarding.
