# Learn PHP and Laravel

This repository documents my journey of learning **PHP from scratch** and gradually transitioning into **Laravel**, with a strong focus on fundamentals, correctness, and real backend behavior.

The goal is to deeply understand how PHP works internally (CLI vs Browser), how HTTP requests flow, how sessions and authentication work, and how to write safe, disciplined backend code **before** moving to frameworks.

---

## Learning Approach

- Fundamentals before frameworks  
- One concept per file  
- One concept per commit  
- Focus on understanding backend behavior, not shortcuts  
- Early emphasis on validation, security, and correctness  

Frameworks are treated as **abstractions over fundamentals**, not replacements for them.

---

## Topics Covered

### Core PHP Fundamentals
- PHP syntax and execution model  
- Variables, data types, and strings  
- Conditions, arrays, and loops  
- Functions and reusable logic  

### Input & Request Handling
- Superglobals (`$argv`, `$_GET`, `$_POST`, `$_SERVER`, `$_FILES`)  
- CLI vs Browser input handling  
- HTTP request methods (GET vs POST)  
- POST → Redirect → GET (PRG pattern)  

### Security & Validation
- Input validation and sanitization  
- XSS prevention using `htmlspecialchars`  

### File System & Uploads
- File handling (read, write, append, logging with timestamps)  
- File uploads (basic flow using `$_FILES`)  
- Secure file uploads:
  - File size validation  
  - Extension allow/block lists  
  - MIME type validation using `finfo`  
  - Safe file renaming  
  - Blocking executable uploads  
  - Secure upload directory handling  

### Sessions & Authentication
- Sessions and cookies (state management)  
- Flash messages using sessions  
- Password hashing and verification  
- Authentication flow (login / logout)  
- Protected routes (access control)  
- User registration flow (signup logic)  

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
php-basics/
├── 01_variables.php
├── 02_datatypes.php
├── 03_output_debugging.php
├── 04_strings.php
├── 05_conditions.php
├── 06_arrays.php
├── 07_loops.php
├── 08_functions.php
├── 09_superglobals.php
├── 10_validation.php
├── 11_file_handling.php
├── 12_file_uploads.php
├── 13_secure_uploads.php
├── 14_http_request_flow.php
├── 15_sessions.php
├── 16_password_hashing.php
├── 17_auth_flow.php
├── 18_protected_routes.php
├── 19_registration_flow.php
├── data.txt
├── log.txt
├── notes.txt
└── uploads/
```

---

## Current Status

🟢 **Core PHP backend fundamentals completed**, including:

- Secure file handling and uploads  
- HTTP request flow and redirects  
- Session-based state management  
- Authentication and authorization logic  
- Registration and protected routes  

---

## Next Learning Steps

- Cookies vs Sessions (deep internal understanding)  
- Refactoring and code structure (pre-MVC thinking)  
- Database integration (MySQL with prepared statements)  
- Transition to **Laravel fundamentals**, following the same principle:

**Understand first. Abstract later.**
