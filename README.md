# 🎒 CampusConnect — Lost & Found Portal

A simple, secure **Lost & Found web portal** for college campuses, built with **PHP + MySQL**. Students can report found items with photos, and owners can claim them by verifying their identity with a college ID card. Admins manage everything from a protected dashboard.

> Developed by **[Karan Dhaodiyal](https://github.com/karandhaodiyal28-hash)** — MCA Student

---

## ✨ Features

### For Students
- 🔍 **Browse & search** available found items (by name, location, or category)
- 📤 **Report a found item** with photo upload (JPG/PNG/WEBP, max 3 MB)
- ✅ **Claim an item** by submitting name, student ID, mobile number, and a college ID card photo as proof

### For Admins
- 🔐 Secure login (bcrypt-hashed passwords, session protection)
- 📋 Dashboard to manage items — mark as claimed or delete (image file is cleaned up too)
- 🧾 View all **claims with ID card proof**
- 📥 One-click **CSV export** of items + claims data
- 🧹 Auto-cleanup: claimed items older than 6 months are deleted automatically

---

## 🛡️ Security Highlights

- **Prepared statements everywhere** — no SQL injection
- **Output escaping** (`htmlspecialchars`) — no stored XSS
- **Strict file upload validation** — real MIME-type check, size limit, random filenames, and an `.htaccess` that blocks script execution inside `uploads/`
- **Passwords hashed with bcrypt** (legacy plaintext passwords are auto-upgraded on first login)
- **DB credentials kept out of the repo** via a gitignored `config.php`
- Admin-only routes (dashboard, CSV export) enforce session checks

---

## 🗂️ Project Structure

```
CampusConnect/
├── index.php              # Home — browse/search available items
├── upload_item.php        # Report a found item
├── claim_item.php         # Claim an item (with ID verification)
├── login.php              # Admin login
├── database.sql           # Full DB schema + default admin seed
├── admin/
│   ├── dashboard.php      # Manage items & view claims
│   ├── export_data.php    # CSV backup export
│   └── logout.php
├── includes/
│   ├── config.sample.php  # Copy to config.php with your credentials
│   ├── db_connect.php     # DB connection
│   ├── upload_helper.php  # Safe image upload handling
│   ├── header.php
│   └── footer.php
├── assets/
│   └── style.css
└── uploads/
    ├── items/             # Item photos
    └── id_cards/          # Claimer ID proofs
```

---

## 🚀 Setup Guide

### Requirements
- PHP 7.4+ (with `mysqli` and `fileinfo` extensions)
- MySQL / MariaDB
- Apache (XAMPP/WAMP works great locally)

### Steps

1. **Clone the repo**
   ```bash
   git clone https://github.com/karandhaodiyal28-hash/CampusConnect.git
   ```

2. **Create the database**
   - Import `database.sql` in phpMyAdmin (or run `mysql -u root -p < database.sql`)

3. **Configure credentials**
   ```bash
   cp includes/config.sample.php includes/config.php
   ```
   Then edit `includes/config.php` with your DB host, username, password, and database name.

4. **Run it**
   - Place the project in your web root (e.g. `htdocs/CampusConnect`) and open `http://localhost/CampusConnect`

5. **Admin login**
   - Default: username `admin`, password `admin123`
   - ⚠️ **Change this immediately after first login!**

---

## 🧰 Tech Stack

| Layer     | Technology            |
|-----------|-----------------------|
| Backend   | PHP (mysqli, prepared statements) |
| Database  | MySQL                 |
| Frontend  | HTML5, CSS3 (vanilla) |
| Hosting   | Any PHP host (tested on InfinityFree) |

---

## 🕰️ Legacy Version

The original (v1) version of this project is preserved as-is on the [`legacy-v1`](https://github.com/karandhaodiyal28-hash/CampusConnect/tree/legacy-v1) branch for reference. It contains the old code **before** the security hardening and feature updates (DB credentials redacted).

---

## 📄 License

This project is licensed under the [MIT License](LICENSE).

---

## 👨‍💻 Author

**Karan Dhaodiyal** — MCA Student

If this project helped you, consider giving it a ⭐ on GitHub!
