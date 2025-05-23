# MyLibrary – A Modern Laravel & Inertia/Vue Library Management System

[![License](https://img.shields.io/github/license/yourusername/mylibrary)](LICENSE) [![Laravel](https://img.shields.io/badge/Laravel-10.x-red)](https://laravel.com) [![Vue](https://img.shields.io/badge/Vue–3-green)](https://vuejs.org) [![Inertia.js](https://img.shields.io/badge/Inertia.js-0.13-blue)](https://inertiajs.com)

A full-stack, role-based **Library Management System** built on Laravel 10, Vue 3, Inertia.js & Tailwind CSS.
I've taken the liberty of deploying the app as well, please visit it and try it out [here.](https://www.lms.anirudhvijay.xyz/)
Here's my [portfolio](https://www.anirudhvijay.xyz/), built with React.
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
git clone https://github.com/AnirudhVijayaraghavan/library-management-system.git
cd <repo name>

# 2. Install PHP dependencies
composer install

# 3. Install JS dependencies
npm install
```

---

### Environment Setup

```bash
# 4. Copy .env and generate app key
cp .env.example .env
php artisan key:generate
```

---

### Database Seeding

```bash
# 5. Create SQLite file at the root of the database folder.
touch database.sqlite

# 6. Database and seeding, Drop all tables, run migrations & seed via LMSSeeder
php artisan migrate:fresh --seed --seeder=LMSSeeder
```

---

### Running the app

```bash
# 7. Optimizing.
php artisan optimize

# 8. Running the app.
composer dev
```

---

## Testing
I've used Pest to create a simple unit test case file, to check who can or cannot leave reviews. As per my application logic, only customers are allowed to create reviews, and only the owners of the reviews are allowed to update their own reviews.
To perform the test:
```bash
php artisan test
```

---

## Misc.
- All the requirements have been fulfilled, including the optional extras. The database diagram is shown below :
![Database Diagram](https://github.com/AnirudhVijayaraghavan/library-management-system/blob/main/docs/DatabaseDiagram.png)


