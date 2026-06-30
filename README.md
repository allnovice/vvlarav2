# CMMS - Computerized Maintenance Management System

> A modern web-based Computerized Maintenance Management System (CMMS) built with Laravel, Vue.js, and Inertia.js for managing organizational assets, maintenance activities, and users.

![Laravel](https://img.shields.io/badge/Laravel-13-red)
![PHP](https://img.shields.io/badge/PHP-8.4-blue)
![Vue](https://img.shields.io/badge/Vue-3-42b883)
![CI](https://github.com/allnovice/vvlarav2/actions/workflows/laravel.yml/badge.svg)
![License](https://img.shields.io/badge/License-MIT-green)


---

# Features

- Asset Management
  - Create, edit, delete, and view assets
  - Asset details page
  - Asset specifications
  - Categories
  - Status tracking

- Authentication
  - Laravel Breeze
  - User login/logout
  - Profile management

- Dashboard
  - Asset summary
  - Statistics
  - Quick navigation

- Search
  - Basic search
  - Smart multi-keyword search

- Responsive Interface
  - Laravel Inertia
  - Vue 3
  - Vite

---

# Tech Stack

| Technology | Version |
|------------|---------|
| Laravel | 13 |
| PHP | 8.4 |
| Vue | 3 |
| Inertia.js | Latest |
| Vite | Latest |
| MariaDB | 11 |
| Docker | Latest |
| Laravel Sail | Latest |
| GitHub Actions | CI/CD |

---

# Requirements

- Docker Desktop
- Laravel Sail
- Git
- Node.js
- Composer

---

# Installation

```bash
git clone https://github.com/allnovice/vvlarav2.git

cd vvlarav2

cp .env.example .env

composer install

npm install

./vendor/bin/sail up -d

./vendor/bin/sail artisan key:generate

./vendor/bin/sail artisan migrate

npm run dev
```

---

# Running Tests

```bash
./vendor/bin/sail artisan test
```

---

# Continuous Integration

GitHub Actions automatically runs:

- Composer install
- Node install
- Vite build
- Laravel migrations
- PHPUnit tests

on every push and pull request.

---

# Project Structure

```
app/
bootstrap/
config/
database/
public/
resources/
    js/
        Components/
        Layouts/
        Pages/
routes/
storage/
tests/
```

---

# Screenshots

## Dashboard

*(Add screenshot here)*

---

## Assets

*(Add screenshot here)*

---

## Asset Details

*(Add screenshot here)*

---

## Login

*(Add screenshot here)*

---

# Roadmap

## Completed

- Laravel Breeze Authentication
- Vue + Inertia
- Asset CRUD
- Asset Details
- GitHub Actions CI

## In Progress

- Asset Specifications
- Categories
- Search Improvements

## Planned

- Maintenance Records
- Preventive Maintenance
- QR Code Assets
- Reports
- Notifications
- User Roles & Permissions
- Audit Logs
- Dashboard Analytics

---

# Learning Goals

This project is also a personal learning journey focused on:

- Laravel
- Vue.js
- Inertia.js
- Docker
- GitHub Actions
- CI/CD
- Software Architecture
- Clean Code Practices

---

# Contributing

Contributions, suggestions, and feedback are welcome.

Feel free to fork the repository and submit a pull request.

---

# License

This project is licensed under the MIT License.
