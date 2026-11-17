# LEMP Stack Implementation on AWS EC2

This project demonstrates the implementation of a **LEMP web stack** on an **AWS EC2 Ubuntu server**.

LEMP stands for:

- **L** - Linux
- **E** - Nginx (Engine-X)
- **M** - MySQL
- **P** - PHP

The project involved deploying an Ubuntu EC2 instance, installing and configuring Nginx, MySQL and PHP, and creating a PHP application that retrieves data from a MySQL database.

---

## Project Architecture

```text
Internet / Web Browser
        |
        | HTTP :80
        v
+-----------------------+
| AWS EC2               |
| Ubuntu 24.04 LTS      |
|                       |
|       Nginx           |
|         |             |
|         v             |
|     PHP 8.3-FPM       |
|         |             |
|         v             |
|      MySQL 8          |
+-----------------------+
```

Application flow:

```text
Browser -> Nginx -> PHP-FPM -> MySQL
```

---

## Technologies Used

| Technology | Purpose |
|---|---|
| AWS EC2 | Hosting the Ubuntu server |
| Ubuntu 24.04 LTS | Server operating system |
| Nginx | Web server |
| MySQL 8 | Database server |
| PHP 8.3 | Server-side processing |
| PHP-FPM | Processing PHP requests through Nginx |
| Git | Version control |
| GitHub | Source-code repository |

---

# Project Implementation

## 1. Launch the EC2 Instance

An Ubuntu EC2 instance was created on AWS.

The server was accessed using SSH:

```bash
ssh -i ~/Downloads/LEMP.pem ubuntu@<PUBLIC-IP>
```

The EC2 Security Group was configured to allow:

- TCP port `22` for SSH
- TCP port `80` for HTTP

---

## 2. Install Nginx

The Ubuntu package index was updated:

```bash
sudo apt update
```

Nginx was installed:

```bash
sudo apt install nginx
```

The Nginx service was checked:

```bash
sudo systemctl status nginx
```

The configuration was tested:

```bash
sudo nginx -t
```

Nginx was then reloaded:

```bash
sudo systemctl reload nginx
```

The web server was tested locally:

```bash
curl http://localhost:80
```

Nginx was also successfully accessed using the EC2 public IP from a web browser.

---

## 3. Install MySQL

MySQL Server was installed:

```bash
sudo apt install mysql-server
```

The MySQL installation was secured using:

```bash
sudo mysql_secure_installation
```

The installed version was verified using:

```sql
SELECT VERSION();
```

---

## 4. Install PHP

PHP, PHP-FPM and MySQL support for PHP were installed:

```bash
sudo apt install php-fpm php-mysql
```

PHP-FPM was verified:

```bash
sudo systemctl status php8.3-fpm
```

The service was confirmed as:

```text
active (running)
```

---

## 5. Configure the Nginx Website

The project web directory was created:

```bash
sudo mkdir /var/www/projectLEMP
```

Ownership was assigned:

```bash
sudo chown -R $USER:$USER /var/www/projectLEMP
```

Nginx was configured to serve the application from:

```text
/var/www/projectLEMP
```

The default Nginx website was disabled and the project configuration was activated.

The configuration was validated:

```bash
sudo nginx -t
```

Nginx was reloaded:

```bash
sudo systemctl reload nginx
```

---

## 6. Test the Custom Nginx Page