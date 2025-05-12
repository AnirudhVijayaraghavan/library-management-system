# MyLibrary – A Modern Laravel & Inertia/Vue Library Management System

[![License](https://img.shields.io/github/license/yourusername/mylibrary)](LICENSE) [![Laravel](https://img.shields.io/badge/Laravel-10.x-red)](https://laravel.com) [![Vue](https://img.shields.io/badge/Vue–3-green)](https://vuejs.org) [![Inertia.js](https://img.shields.io/badge/Inertia.js-0.13-blue)](https://inertiajs.com)

A full-stack, role-based **Library Management System** built on Laravel 10, Vue 3, Inertia.js & Tailwind CSS.

---

## 📖 Table of Contents

1. [🔥 Features](#-features)  
2. [🛠️ Tech Stack](#️-tech-stack)  
3. [🚀 Quick Start](#-quick-start)  
   - [Prerequisites](#prerequisites)  
   - [Installation](#installation)  
   - [Environment Setup](#environment-setup)  
   - [Database & Seeding](#database--seeding)  
   - [Running the App](#running-the-app)  
4. [🧪 Testing](#-testing)  
5. [📄 License](#-license)  

---

## 🔥 Features

- **User Roles & Permissions**  
  - Librarian: manage books, mark returns  
  - Customer: browse, borrow, review  
- **Book Catalog**  
  - Search, filter & sort (title, author, availability)  
  - Detailed pages (publisher, ISBN, page count, reviews)  
- **Loan Management**  
  - Customers check out for 5 days  
  - Librarians & customers can mark returns  
- **Customer Reviews**  
  - One ★1–5 rating + comment per user per book  
- **Responsive SPA**  
  - Laravel + Inertia.js + Vue 3 gives seamless navigation  
- **Seed Data**  
  - Ready-to-use `LMSSeeder` populates authors, categories, books, users, loans & reviews  

---

## 🛠️ Tech Stack

| Layer            | Technology                        |
| ---------------- | --------------------------------- |
| **Backend**      | Laravel                         |
| **Frontend**     | Vue 3 + Inertia.js + Vite         |
| **Styling**      | Tailwind CSS                      |
| **Database**     | SQLite (default)  |
| **Search (opt.)**| Laravel Scout + Database Driver         |
| **Icons**        | Emoji-based (📚 ⏱️ 💬)              |

---

## 🚀 Quick Start

### Prerequisites

- PHP 8.1+  
- Composer  
- Node.js 16+ & npm  
- MySQL **or** SQLite  , by default, the app uses SQLite driver as per the .env.example.

---

### Installation

```bash
# 1. Clone the repo
git clone https://github.com/AnirudhVijayaraghavan/mylibrary.git
cd <repo name>

# 2. Install PHP dependencies
composer install

# 3. Install JS dependencies
npm install

# 4. Copy .env and generate app key
cp .env.example .env
php artisan key:generate

# 5. Create SQLite file at the root of the database folder.
touch database.sqlite

# 6. Database and seeding, Drop all tables, run migrations & seed via LMSSeeder
php artisan migrate:fresh --seed --seeder=LMSSeeder

# 7. Running the app
composer dev
