# Build and Deploy This Static Website on Ubuntu (Local Nginx)

This guide shows how to deploy this static site (`index.html`, `style.css`, `script.js`) on an Ubuntu machine using Nginx for local access.

## 1) Update Ubuntu packages

```bash
sudo apt update
sudo apt upgrade -y
```

## 2) Install Nginx

```bash
sudo apt install nginx -y
```

## 3) Verify Nginx is running

```bash
sudo systemctl status nginx
```

If needed, start and enable it:

```bash
sudo systemctl start nginx
sudo systemctl enable nginx
```

## 4) Create a directory for your site

```bash
sudo mkdir -p /var/www/static-site
```

## 5) Copy your website files

From your project folder, copy all static files:

```bash
sudo cp index.html style.css script.js /var/www/static-site/
```

If you add more assets (images, fonts, etc.), copy them too.

## 6) Set safe ownership and permissions

```bash
sudo chown -R www-data:www-data /var/www/static-site
sudo find /var/www/static-site -type d -exec chmod 755 {} \;
sudo find /var/www/static-site -type f -exec chmod 644 {} \;
```

## 7) Create an Nginx server block

Create a config file:

```bash
sudo nano /etc/nginx/sites-available/static-site
```

Paste this configuration:

```nginx
server {
    listen 80;
    listen [::]:80;

    server_name _;

    root /var/www/static-site;
    index index.html;

    location / {
        try_files $uri $uri/ =404;
    }
}
```

Save and close (`Ctrl+O`, `Enter`, `Ctrl+X`).

## 8) Enable the site and disable default config

```bash
sudo ln -s /etc/nginx/sites-available/static-site /etc/nginx/sites-enabled/
sudo rm -f /etc/nginx/sites-enabled/default
```

## 9) Test Nginx configuration

```bash
sudo nginx -t
```

If successful, reload:

```bash
sudo systemctl reload nginx
```

## 10) Open in browser

On the Ubuntu machine, open:

- `http://localhost`

You should see your static website.

---

## Optional: Firewall rule (if you need LAN access)

If UFW is enabled and you want other devices on your network to access this machine:

```bash
sudo ufw allow 'Nginx Full'
sudo ufw reload
```

Then open `http://<ubuntu-machine-ip>` from another device.

---

## Ubuntu VM setup and access via IP address

If your site is running inside an Ubuntu VM, use this section so you can open it from your host machine (Windows/macOS) using the VM IP.

### 1) Choose VM network mode

- `Bridged Adapter` (recommended): VM gets an IP on your LAN and is reachable directly from host/LAN.
- `NAT`: VM is isolated behind host. You must use port forwarding to access from host.

### 2) Get the Ubuntu VM IP address

Inside Ubuntu VM:

```bash
ip -4 addr show | grep -oP '(?<=inet\s)\d+(\.\d+){3}'
```

Common output example: `192.168.1.120`

### 3) Allow HTTP in Ubuntu firewall (if enabled)

```bash
sudo ufw allow 80/tcp
sudo ufw reload
sudo ufw status
```

### 4) Confirm Nginx listens on all interfaces

Your server block should include:

```nginx
listen 80;
listen [::]:80;
```

Then validate and reload:

```bash
sudo nginx -t && sudo systemctl reload nginx
```

### 5) Open from host machine browser

From your host machine, open:

- `http://<vm-ip>`

Example:

- `http://192.168.1.120`

### 6) If using NAT, add port forwarding in hypervisor

Map host port `8080` to guest port `80`.

- Host IP: `127.0.0.1` (or blank)
- Host port: `8080`
- Guest IP: `<vm-ip>`
- Guest port: `80`

Then open from host:

- `http://127.0.0.1:8080`

### 7) Quick connectivity checks

Inside VM:

```bash
curl -I http://localhost
curl -I http://<vm-ip>
```

From host terminal:

```bash
curl -I http://<vm-ip>
```

If request fails from host but works in VM, the issue is usually VM network mode, host firewall, or missing NAT port forwarding.

---

## How to update the site later

1. Replace files in `/var/www/static-site/`.
2. Run:

```bash
sudo nginx -t && sudo systemctl reload nginx
```

---

## Quick troubleshooting

- Nginx config error:

```bash
sudo nginx -t
```

- Check Nginx logs:

```bash
sudo tail -n 100 /var/log/nginx/error.log
sudo tail -n 100 /var/log/nginx/access.log
```

- Confirm files exist:

```bash
ls -la /var/www/static-site
```

- Confirm service is active:

```bash
sudo systemctl status nginx
```
