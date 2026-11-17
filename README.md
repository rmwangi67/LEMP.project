# LEMP Stack Implementation on AWS EC2

This project demonstrates the implementation of a complete **LEMP web stack** on an **AWS EC2 Ubuntu server**.

LEMP stands for:

- **L** - Linux
- **E** - Nginx (Engine-X)
- **M** - MySQL
- **P** - PHP

The project covers the deployment and configuration of the web server, database server, PHP processing, Nginx server blocks, and a simple PHP application that retrieves data from MySQL.

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

The request flow is:

```text
Browser -> Nginx -> PHP-FPM -> MySQL
```

---

## Technologies Used

| Technology | Purpose |
|---|---|
| AWS EC2 | Cloud server hosting |
| Ubuntu 24.04 LTS | Linux operating system |
| Nginx | Web server |
| MySQL 8 | Relational database |
| PHP 8.3 | Server-side application processing |
| PHP-FPM | PHP processing for Nginx |
| Git | Source control |
| GitHub | Remote source-code repository |
| VS Code | Local development environment |

---

## Project Implementation

### 1. Launch an Ubuntu EC2 Instance

An Ubuntu EC2 instance was provisioned on AWS and accessed securely using SSH.

Example:

```bash
ssh -i ~/Downloads/LEMP.pem ubuntu@<PUBLIC-IP>
```

The EC2 instance was configured to allow:

- SSH traffic on TCP port `22`
- HTTP traffic on TCP port `80`

> For production environments, SSH port 22 should be restricted to trusted IP addresses rather than exposed publicly.

---

## 2. Install Nginx

The server package index was updated:

```bash
sudo apt update
```

Nginx was installed:

```bash
sudo apt install nginx
```

The service status was verified:

```bash
sudo systemctl status nginx
```

The Nginx configuration was also validated using:

```bash
sudo nginx -t
```

Expected result:

```text
syntax is ok
test is successful
```

Nginx was then reloaded:

```bash
sudo systemctl reload nginx
```

The installation was tested locally:

```bash
curl http://localhost:80
```

and through the EC2 public IP in a web browser.

---

## 3. Install MySQL

MySQL Server was installed to provide the database layer:

```bash
sudo apt install mysql-server
```

The installation was secured using:

```bash
sudo mysql_secure_installation
```

The MySQL service and database engine were then verified.

Example:

```sql
SELECT VERSION();
```

---

## 4. Install PHP

PHP and the components required to communicate with Nginx and MySQL were installed.

```bash
sudo apt install php-fpm php-mysql
```

The PHP-FPM service was verified:

```bash
sudo systemctl status php8.3-fpm
```

---

## 5. Configure the Nginx Project

The project web root was created:

```bash
sudo mkdir /var/www/projectLEMP
```

Ownership was assigned appropriately:

```bash
sudo chown -R $USER:$USER /var/www/projectLEMP
```

Nginx was configured to serve the project from:

```text
/var/www/projectLEMP
```

The default Nginx site was disabled after the project server block was enabled.

The configuration was validated:

```bash
sudo nginx -t
```

and Nginx was reloaded:

```bash
sudo systemctl reload nginx
```

---

## 6. Verify the Custom Nginx Website

A simple `index.html` file was created to confirm that Nginx was serving the project directory rather than the default Nginx page.

Example output:

```text
Hello LEMP from hostname <EC2-HOSTNAME> with public IP <PUBLIC-IP>
```

This confirmed that the custom Nginx server block was operating correctly.

---

## 7. Verify PHP Processing

A PHP information page was created:

```php
<?php
phpinfo();
```

The page was accessed through:

```text
http://<PUBLIC-IP>/info.php
```

A successful PHP information page confirmed communication between:

```text
Nginx -> PHP-FPM -> PHP
```

> `info.php` should be removed after testing because `phpinfo()` exposes detailed server configuration information.

---

## 8. Configure the MySQL Database

A database was created for the application:

```sql
CREATE DATABASE example_database;
```

An application database user was configured and granted appropriate access to the database.

A `todo_list` table was created:

```sql
CREATE TABLE example_database.todo_list (
    item_id INT AUTO_INCREMENT,
    content VARCHAR(255),
    PRIMARY KEY (item_id)
);
```

Sample data was inserted:

```sql
INSERT INTO example_database.todo_list (content)
VALUES ('My first important item');
```

The data was verified:

```sql
SELECT * FROM example_database.todo_list;
```

---

## 9. PHP and MySQL Integration

The `todo_list.php` application connects PHP to MySQL using **PDO (PHP Data Objects)**.

The application:

1. Connects to the MySQL database.
2. Queries the `todo_list` table.
3. Retrieves the `content` records.
4. Displays the records through the web server.

The page can be accessed using:

```text
http://<PUBLIC-IP>/todo_list.php
```

A successful response confirms the complete application flow:

```text
Browser
   |
   v
Nginx
   |
   v
PHP-FPM
   |
   v
PHP Application
   |
   v
MySQL
```

---

## Repository Structure

```text
LEMP.project/
├── index.html
├── todo_list.php
└── README.md
```

### `index.html`

Used to verify that the custom Nginx virtual host/server block is serving content from the correct document root.

### `todo_list.php`

PHP application that communicates with the MySQL database and retrieves todo-list records.

### `README.md`

Contains the project implementation documentation.

---

## Security Considerations

Sensitive credentials should never be committed to GitHub.

Database passwords should be supplied through environment variables or another secrets-management mechanism instead of being hardcoded in PHP.

Example:

```php
$password = getenv("DB_PASSWORD");
```

The following should **never** be committed:

```text
*.pem
.env
credentials
private keys
database passwords
API tokens
```

A `.gitignore` file can be used to protect local secrets:

```gitignore
.env
*.pem
*.key
```

Additional production considerations include:

- Restrict SSH access to trusted source IP addresses.
- Enable HTTPS using TLS certificates.
- Apply least-privilege database permissions.
- Regularly patch Ubuntu, Nginx, MySQL, and PHP.
- Disable or remove diagnostic pages such as `phpinfo()`.
- Do not expose MySQL port `3306` publicly.

---

## Verification

The project was successfully tested at each layer:

| Component | Verification |
|---|---|
| Linux | Ubuntu EC2 server accessible through SSH |
| Nginx | Service active and HTTP page accessible |
| MySQL | Database and application table created successfully |
| PHP | PHP-FPM active and PHP processing verified |
| PHP + MySQL | PHP application successfully queries MySQL |
| Git | Local repository initialized and committed |
| GitHub | Project pushed to remote repository |

---

## Key Learning Outcomes

This project demonstrates practical experience with:

- Provisioning Linux infrastructure on AWS
- Connecting to EC2 using SSH
- Configuring EC2 Security Groups
- Installing and managing Nginx
- Installing and securing MySQL
- Configuring PHP-FPM
- Building Nginx server blocks
- Connecting PHP applications to MySQL using PDO
- Troubleshooting Linux and database authentication issues
- Managing source code with Git
- Working locally with Visual Studio Code
- Publishing project code to GitHub
- Managing application credentials securely

---

## Future Improvements

Potential improvements include:

- Enable HTTPS using Let's Encrypt and Certbot
- Use environment-based application configuration
- Add a `.gitignore`
- Add application create/update/delete functionality
- Containerize the LEMP application using Docker
- Add automated deployment with GitHub Actions
- Add infrastructure provisioning using Terraform
- Add monitoring and centralized logging
- Implement database backup and restore procedures

---

## Author

**Richmond Wachira**

Cloud / DevOps Project

---

## Project Status

✅ Linux configured  
✅ Nginx configured  
✅ MySQL configured  
✅ PHP-FPM configured  
✅ Nginx and PHP integration verified  
✅ MySQL database integration completed  
✅ Project stored locally with Git  
✅ Project published to GitHub