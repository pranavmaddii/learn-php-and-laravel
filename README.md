# Learn PHP → Laravel (Backend Foundations)

This repository documents my journey of learning **PHP backend development from first principles** and then transitioning into **Laravel**, with a strong emphasis on correctness, security, and understanding real backend behavior before using frameworks.

The goal is **not just to "use PHP/Laravel"**, but to understand:
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

### Core PHP Fundamentals (`php-basics/`)
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

## Database & Authentication (`php-database/`)

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

## PHP 8 Features (`php-8 features/`)

Exploration of modern PHP 8+ language features and patterns, bridging raw PHP knowledge with the constructs used in Laravel and modern frameworks.

- Match expressions
- Named arguments
- Nullsafe operator (`?->`)
- Constructor property promotion
- Union and intersection types
- Readonly properties and classes
- Enums (backed enums)
- Constants in traits
- Attributes (annotations)
- WeakMaps
- Fibers (cooperative multitasking)
- Closures and arrow functions
- Closures in a Laravel-style router
- Method chaining
- Dependency injection

---

## Postboard — Laravel Project (`postboard/`)

A full-stack **Laravel application** built to apply the fundamentals learned in the raw PHP modules. This is a post board where users can create, read, edit, and delete posts — with authentication, comments, likes, and an API layer.

### Features
- **Authentication**: Registration, login, logout, password reset via email
- **Posts**: Full CRUD with soft deletes and restore
- **Comments**: Threaded comments on posts
- **Likes**: Toggle like/unlike on posts
- **Image uploads**: Attach images to posts
- **Post status**: Active/draft post management
- **My Posts**: View own posts separately
- **API**: RESTful API endpoints with Sanctum token authentication

### Tech Stack
- Laravel (Blade templates, Eloquent ORM, Sanctum)
- MySQL
- Blade views with layouts

### Key Laravel Concepts Applied
- Routes → Controllers (`PostController`, `AuthController`, `CommentController`)
- PDO → Eloquent ORM (`Post`, `User`, `Comment` models)
- `auth.php` → Laravel `auth:sanctum` middleware
- Manual sessions → Laravel session management
- Raw SQL → Migrations and schema builder
- API authentication using Laravel Sanctum

---

## Running the Code

### PHP Basics & Database Modules

#### Using XAMPP / Apache (Recommended)

Place the repository inside:

```text
C:\xampp\htdocs\
http://localhost/LEARN%20PHP/php-basics/filename.php
http://localhost/LEARN%20PHP/php-database/filename.php
```

#### CLI (Command Line)

Used for `$argv`, `STDIN`, and logic-only scripts:

```bash
php filename.php
```

#### Browser (Built-in PHP Server)
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

### Postboard (Laravel)

```bash
cd postboard
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

Open in browser: `http://localhost:8000`

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
│   ├── auth.php
│   └── notes.txt
│
├── php-8 features/
│   └── index.php
│
├── postboard/            ← Laravel application
│   ├── app/
│   │   ├── Http/Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── PostController.php
│   │   │   ├── CommentController.php
│   │   │   └── Api/
│   │   └── Models/
│   │       ├── User.php
│   │       ├── Post.php
│   │       └── Comment.php
│   ├── database/migrations/
│   ├── resources/views/
│   │   ├── layouts/
│   │   ├── auth/
│   │   └── posts/
│   ├── routes/
│   │   ├── web.php
│   │   └── api.php
│   └── ...
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
- PHP 8 modern language features
- Laravel project (Postboard) with full CRUD, auth, comments, likes, and API

🟡 **In Progress**

- Expanding the Postboard Laravel project with additional features

---

## Learning Progression

```
PHP Basics → Database & Auth (Raw PHP) → PHP 8 Features → Laravel (Postboard)
```

> **Understand first. Abstract later.**
