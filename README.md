# Talking Forum

A PHP-based discussion forum web application built with Bootstrap and MySQL.

## Project Overview

This is a simple coding discussion forum where users can:
- browse discussion categories
- view threads inside a category
- post new threads (when logged in)
- add comments to threads (when logged in)
- register and login with email/password

The site uses PHP for server-side rendering and MySQL for data storage.

## Project Structure

- `index.php` - home page showing forum categories
- `threadlist.php` - list of threads for a selected category
- `thread.php` - view a single thread and its comments
- `about.php` / `contact.php` - informational pages
- `partial/_dbconnect.php` - database connection settings
- `partial/_header.php` - site header and authentication controls
- `partial/_handleSignup.php` - signup logic
- `partial/_handelLogin.php` - login logic
- `partial/_logout.php` - logout logic
- `partial/_loginModal.php` / `partial/_signupModal.php` - authentication modals
- `img/` - images used in the site

## Requirements

- XAMPP (or any Apache + PHP + MySQL environment)
- PHP 7.x or newer
- MySQL / MariaDB

## Local Setup

1. Copy the project folder into your XAMPP `htdocs` directory.
   Example: `C:\xampp\htdocs\22_ForumSite`

2. Start Apache and MySQL from the XAMPP control panel.

3. Open phpMyAdmin at `http://localhost/phpmyadmin`.

4. Create the MySQL database and tables described below.

5. Update database credentials in `partial/_dbconnect.php` if needed.

6. Open the app in your browser:
   - `http://localhost/22_ForumSite/index.php`

## Database Setup

The application expects a MySQL database named `talking` by default.

### Database connection

`partial/_dbconnect.php` currently uses:

```php
$servername = "localhost";
$username = "root";
$password = "";
$database = "talking";
```

Change these values if your environment differs.

### Recommended SQL schema

Run the following SQL in phpMyAdmin or via MySQL CLI:

```sql
CREATE DATABASE IF NOT EXISTS `talking`;
USE `talking`;

CREATE TABLE `users` (
  `sno` INT NOT NULL AUTO_INCREMENT,
  `user_email` VARCHAR(255) NOT NULL,
  `user_pass` VARCHAR(255) NOT NULL,
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sno`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `categories` (
  `category_id` INT NOT NULL AUTO_INCREMENT,
  `category_name` VARCHAR(100) NOT NULL,
  `category_description` TEXT NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `threads` (
  `thread_id` INT NOT NULL AUTO_INCREMENT,
  `thread_title` VARCHAR(255) NOT NULL,
  `thread_desc` TEXT NOT NULL,
  `thread_cat_id` INT NOT NULL,
  `thread_user_id` INT NOT NULL DEFAULT 0,
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`thread_id`),
  KEY `thread_cat_id` (`thread_cat_id`),
  KEY `thread_user_id` (`thread_user_id`),
  CONSTRAINT `threads_category_fk` FOREIGN KEY (`thread_cat_id`) REFERENCES `categories`(`category_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `comment` (
  `comment_id` INT NOT NULL AUTO_INCREMENT,
  `comment_content` TEXT NOT NULL,
  `thread_id` INT NOT NULL,
  `comment_by` INT NOT NULL DEFAULT 0,
  `comment_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`),
  KEY `thread_id` (`thread_id`),
  CONSTRAINT `comment_thread_fk` FOREIGN KEY (`thread_id`) REFERENCES `threads`(`thread_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### Initial category data

Add seed categories so the forum has content initially:

```sql
INSERT INTO `categories` (`category_name`, `category_description`) VALUES
('HTML', 'Questions and discussions about HTML markup and structure.'),
('CSS', 'Styling, layouts, responsive design, and front-end appearance.'),
('JavaScript', 'Client-side scripting, DOM manipulation, and browser behavior.'),
('PHP', 'Server-side PHP development, forms, sessions, and backend logic.');
```

## User Authentication

- Sign up with email and password via the signup modal.
- Passwords are hashed with `password_hash()` before storage.
- Login verifies credentials with `password_verify()`.
- Logged-in users can create threads and post comments.

## Notes and Improvements

- The app currently stores anonymous thread/comment authors as `0`.
- There is no fully implemented search feature yet.
- You may want to sanitize input further and use prepared statements to prevent SQL injection.
- The current navigation assumes the site is served from `/22_Forumsite` in XAMPP.

## Run the App

1. Start XAMPP services.
2. Open `http://localhost/22_ForumSite/index.php` in your browser.
3. Register a user, log in, and start posting discussions.

---

If you need help building the database or making the app production-ready, I can add a prepared statement version of the signup/login flow and a complete schema script.