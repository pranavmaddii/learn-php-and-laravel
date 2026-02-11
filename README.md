# Learn PHP → Laravel (Backend Foundations)

This repository documents my journey of learning **PHP backend development from first principles** and then transitioning into **Laravel**, with a strong emphasis on correctness, security, and understanding real backend behavior before using frameworks.

The goal is **not just to “use PHP/Laravel”**, but to understand:
- how PHP executes (CLI vs browser),
- how HTTP requests work,
- how sessions persist state,
- how authentication and authorization are actually implemented,
- and how frameworks abstract these fundamentals.

---

## Learning Philosophy

- Fundamentals before frameworks  
- One concept per file  
- One concept per commit  
- No blind copy-paste  
- Security and correctness from day one  

Frameworks are treated as **abstractions over known mechanisms**, not magic.

---

## Topics Covered

### Core PHP Fundamentals
- PHP execution model (CLI vs browser)
- Variables, data types, strings
- Conditions, arrays, loops
- Functions and reusable logic

### Input & HTTP Handling
- Superglobals (`$_GET`, `$_POST`, `$_SERVER`, `$_FILES`, `$argv`)
- GET vs POST semantics
- POST → Redirect → GET (PRG pattern)

### Security & Validation
- Input validation and sanitization
- XSS prevention using `htmlspecialchars`
- Password hashing and verification (`password_hash`, `password_verify`)

### File System & Uploads
- File read/write/append
- Logging with timestamps
- File uploads using `$_FILES`
- Secure uploads:
  - Size validation
  - Extension allow/block lists
  - MIME type validation (`finfo`)
  - Safe file renaming
  - Blocking executable uploads

---

## Database & Authentication (PHP + MySQL)

The `php-database` module completes a **full database-backed authentication system using raw PHP**.

### Database Fundamentals
- Relational database concepts
- Tables, rows, columns
- MySQL integration using PDO

### PDO & SQL
- Secure PDO connection setup
- Error handling modes
- Prepared statements
- Safe SELECT and INSERT operations

### Authentication
- User registration with hashed passwords
- Login using database credentials
- Password verification
- Proper failure handling (user not found vs invalid password)

### Sessions & Authorization
- Session-based login persistence
- Secure session ID regeneration (session fixation prevention)
- Storing only `user_id` in session
- Centralized auth helpers (`auth.php`)
- Protected routes with access control

This mirrors how real frameworks implement authentication internally.

---

## Running the Code

### Using XAMPP / Apache (Recommended)

Place the repository inside:

```text
C:\xampp\htdocs\
http://localhost/LEARN%20PHP/php-basics/filename.php
http://localhost/LEARN%20PHP/php-database/filename.php
```

---

## Running the Code

### CLI (Command Line)

Used for `$argv`, `STDIN`, and logic-only scripts:

```bash
php filename.php
```

### Browser (Built-in PHP Server)
Used for `$_GET`, `$_POST`, and `$_FILES`:
```
php -S localhost:8000
```

Open in browser:
```
http://localhost:8000/php-basics/filename.php
```

> ⚠️ PHP files must be served via the PHP server.  
> Static servers (like Live Server) cannot handle POST or file uploads.

---

## Repository Structure

```
LEARN PHP/
├── php-basics/
│   ├── 01_variables.php
│   ├── 02_datatypes.php
│   ├── 03_output_methods.php
│   ├── 04_strings.php
│   ├── 05_conditions.php
│   ├── 06_arrays.php
│   ├── 07_loops.php
│   ├── 08_functions.php
│   ├── 09_superglobals_and_dynamics.php
│   ├── 10_validations.php
│   ├── 11_file_handling.php
│   ├── 12_file_uploads.php
│   ├── 13_secure_uploads.php
│   ├── 14_http_request_flow.php
│   ├── 15_sessions.php
│   ├── 16_password_hashing.php
│   ├── 17_auth_flow.php
│   ├── 18_protected_routes.php
│   ├── 19_registration_flow.php
│   ├── 20_refactor_auth.php
│   ├── data.txt
│   ├── log.txt
│   ├── notes.txt
│   └── uploads/
│
├── php-database/
│   ├── 01_db_concepts.php
│   ├── 02_pdo_connection.php
│   ├── 03_simple_select.php
│   ├── 04_prepared_basics.php
│   ├── 05_insert_user.php
│   ├── 06_login_user.php
│   ├── 07_session_auth.php
│   ├── 08_protected_page.php
│   └── auth.php
│
└── README.md

```

---

## Current Status

🟢 **Completed**

- Core PHP backend fundamentals  
- Secure file handling and uploads  
- HTTP request lifecycle understanding  
- Session-based authentication and authorization  
- Database-backed authentication using PDO  

The **`php-database` module is complete** and serves as a foundation reference.

---

## Next Step

➡️ **Transition to Laravel 10**, mapping:

- Routes → Controllers  
- PDO → Eloquent ORM  
- `auth.php` → Laravel auth middleware and guards  
- Manual sessions → Laravel session management  

With the same principle:

> **Understand first. Abstract later.**
