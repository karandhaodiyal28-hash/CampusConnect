# 🎒 CampusConnect — Lost & Found Portal (Legacy v1)

<p align="center">
  <img src="https://readme-typing-svg.demolab.com?font=Fira+Code&weight=600&size=26&duration=3000&pause=1000&color=F59E0B&center=true&vCenter=true&width=680&height=55&lines=CampusConnect+-+Legacy+v1;The+original+archived+version;See+the+main+branch+for+the+latest+code" alt="Typing SVG" />
</p>

> ⚠️ **This is the LEGACY / ORIGINAL version of the project (archived).**
> For the latest, secure and updated code, switch to the [`main`](https://github.com/karandhaodiyal28-hash/CampusConnect/tree/main) branch.

This branch preserves the **original first version** of CampusConnect exactly as it was first built — kept for reference and history. The only change made here is that the real database credentials were **redacted** for safety.

> Developed by **[Karan Dhaodiyal](https://github.com/karandhaodiyal28-hash)** — MCA Student

---

## 📌 About this branch

- 🕰️ **Archival copy** of the initial version (v1) of the project
- 🔑 DB credentials in `includes/db_connect.php` are replaced with placeholders (`YOUR_DB_USERNAME` / `YOUR_DB_PASSWORD`)
- ✨ Includes a small typewriter animation on the home page tagline

**Note:** This legacy code does *not* include the security hardening (prepared statements, upload validation, password hashing, etc.) that was later added on `main`. It is here for historical reference only — please use the `main` branch for any real deployment.

---

## ✨ Original Features

- 📤 Report a found item with a photo
- ✅ Claim an item by uploading a college ID card
- 🔐 Basic admin login + dashboard to manage items
- 📥 CSV data export
- ⌨️ Typewriter effect on the home tagline

---

## 🗂️ Project Structure

```
CampusConnect/
├── index.php              # Home — browse available items
├── upload_item.php        # Report a found item
├── claim_item.php         # Claim an item
├── login.php              # Admin login
├── admin/
│   ├── dashboard.php      # Manage items
│   ├── export_data.php    # CSV backup export
│   └── logout.php
├── includes/
│   ├── db_connect.php     # DB connection (credentials redacted)
│   ├── header.php
│   └── footer.php
└── assets/
    └── style.css
```

---

## 🚀 Setup (for reference)

1. Import your database tables (`items`, `claims`, `admin_users`) into MySQL.
2. Open `includes/db_connect.php` and fill in your real DB host, username, password and database name.
3. Place the project in your web root (e.g. `htdocs/CampusConnect`) and open `http://localhost/CampusConnect`.

---

## 👨‍💻 Author

**Karan Dhaodiyal** — MCA Student

*This is the legacy archive. See the [`main`](https://github.com/karandhaodiyal28-hash/CampusConnect/tree/main) branch for the maintained version.*
