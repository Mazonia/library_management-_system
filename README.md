# Bibliotheca: Enterprise Library Management System

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)
[![PHP 8.0+](https://img.shields.io/badge/PHP-8.0%2B-purple.svg)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/Database-MySQL-blue.svg)](db%20of%20library.sql)
[![Code of Conduct](https://img.shields.io/badge/Contributor%20Covenant-2.1-4baaaa.svg)](CODE_OF_CONDUCT.md)

**Bibliotheca Library Management System** is a secure PHP & MySQL application and responsive Web portal for managing book inventories, student/staff memberships, borrowings, reservations, and reviews.

---

## ✨ Key Improvements & Features

- 🛡️ **Hardened Backend**: Refactored with parameterized SQL prepared statements to eliminate SQL Injection (SQLi) vulnerabilities.
- 🎨 **Glassmorphism Theme**: Premium dark-mode UI layout (`css/style.css`) with responsive cards and clean data tables.
- 💻 **Interactive Web App**: Standalone browser portal (`index.html`) for offline search, filter, and checkout simulation.
- 📊 **Comprehensive Schema**: Modular SQL database schema (`db of library.sql`) with sample data and join queries.

---

## 🚀 Quick Start

### 1. Launch Web Portal
Open [`index.html`](index.html) directly in any modern web browser.

### 2. PHP / MySQL Server Setup
1. Import `db of library.sql` into MySQL/MariaDB:
   ```sql
   mysql -u root -p < "db of library.sql"
   ```
2. Configure credentials in `db.php`.
3. Serve admin portal via PHP built-in server or Apache/Nginx:
   ```bash
   php -S localhost:8000
   ```
4. Access admin dashboard at `http://localhost:8000/admin/index.php`.

---

## 🛡️ Governance & Security

- **[Code of Conduct](CODE_OF_CONDUCT.md)**
- **[Contributing Guide](CONTRIBUTING.md)**
- **[Security Policy](SECURITY.md)**
- **[License](LICENSE)**
