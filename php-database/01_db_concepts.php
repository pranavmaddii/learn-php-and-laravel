<?php
/*
========================================
DATABASE FUNDAMENTALS (CONCEPT ONLY)
========================================

1) What a database is
--------------------
A database is a structured, persistent storage system.
Unlike arrays or sessions:
- Data survives page reloads
- Data survives server restarts
- Data can be queried efficiently

PHP memory (arrays, sessions) is TEMPORARY.
Database storage is PERSISTENT.


2) Why arrays/sessions are wrong for users
------------------------------------------
Arrays:
- Exist only during script execution
- Reset on every request

Sessions:
- Are per-user
- Not shared across users
- Not a source of truth

Correct rule:
The database is the SOURCE OF TRUTH.
Sessions only store references (IDs).


3) Database structure
---------------------
Database
└── Tables
    └── Rows (records)
        └── Columns (fields)

Example:
users table
--------------------------------
id | name | email | password
--------------------------------
1  | A    | a@x   | hash
2  | B    | b@x   | hash


4) What SQL is
--------------
SQL = Structured Query Language

Used to:
- CREATE tables
- INSERT data
- SELECT data
- UPDATE data
- DELETE data

PHP does NOT replace SQL.
PHP SENDS SQL to the database.


5) How PHP talks to a database
------------------------------
PHP → Database Driver → Database

PDO is an ABSTRACTION over drivers.
We will use:
PDO + MySQL driver


6) What a database connection means
-----------------------------------
A connection is:
- A live channel between PHP and MySQL
- Created per request
- Used to execute SQL queries

One request = one connection (normally)


7) Security baseline (non-negotiable)
-------------------------------------
- Never trust user input
- Never concatenate SQL strings with user input
- Always use prepared statements
- Passwords are ALWAYS hashed

These rules are enforced by design, not discipline.


END OF FILE
========================================
*/
?>