# Learn PHP and Laravel

This repository documents my journey of learning **PHP from scratch** and gradually transitioning into **Laravel**, with a strong focus on fundamentals, correctness, and real backend behavior.

The goal is to understand how PHP works internally (CLI vs Browser), how data flows, and how to write safe, disciplined backend code—before moving to frameworks.

---

## Learning Approach

- Fundamentals before frameworks  
- One concept per file  
- One concept per commit  
- Focus on understanding behavior, not shortcuts  
- Early emphasis on validation and security  

---

## Topics Covered

- PHP syntax and execution model  
- Variables, data types, and strings  
- Conditions, arrays, and loops  
- Functions and reusable logic  
- Superglobals (`$argv`, `$_GET`, `$_POST`, `$_SERVER`)  
- Dynamic input handling  
- Input validation and XSS prevention  
- File handling and logging  
- File uploads using `$_FILES`  

---

## Running the Code

### CLI (Command Line)
Used for `$argv`, `STDIN`, and logic practice:
```
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
├── data.txt
├── log.txt
└── uploads/
```

---

## Status

🟢 Actively learning and updating.  
Next step: **Laravel fundamentals**.
